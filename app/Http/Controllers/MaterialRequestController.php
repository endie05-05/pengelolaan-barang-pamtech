<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use App\Models\ProjectTemplate;
use App\Models\StockMutation;
use App\Models\TemplateItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialRequestController extends Controller
{
    /**
     * Display a listing of the material requests.
     */
    public function index(Request $request)
    {
        $query = MaterialRequest::with(['template', 'creator', 'items.item'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by project name or technician
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('technician_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(15);

        return view('requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new material request.
     */
    public function create(Request $request)
    {
        $templates = ProjectTemplate::with('items.item')->get();
        $items = Item::with('category')->where('stock', '>', 0)->orderBy('name')->get();
        $selectedTemplate = null;

        if ($request->filled('template_id')) {
            $selectedTemplate = ProjectTemplate::with('items.item')->find($request->template_id);
        }

        return view('requests.create', compact('templates', 'items', 'selectedTemplate'));
    }

    /**
     * Store a newly created material request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'nullable|exists:project_templates,id',
            'project_name' => 'required|string|max:255',
            'technician_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'departure_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty_requested' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Create material request
            $materialRequest = MaterialRequest::create([
                'template_id' => $validated['template_id'] ?? null,
                'created_by' => auth()->id(),
                'project_name' => $validated['project_name'],
                'technician_name' => $validated['technician_name'],
                'location' => $validated['location'] ?? null,
                'departure_date' => $validated['departure_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => MaterialRequest::STATUS_PENDING,
            ]);

            // Create request items
            foreach ($validated['items'] as $itemData) {
                MaterialRequestItem::create([
                    'material_request_id' => $materialRequest->id,
                    'item_id' => $itemData['item_id'],
                    'qty_requested' => $itemData['qty_requested'],
                ]);
            }
        });

        return redirect()->route('requests.index')
            ->with('success', 'Request berhasil dibuat!');
    }

    /**
     * Display the specified material request.
     */
    public function show(MaterialRequest $materialRequest)
    {
        $materialRequest->load(['template', 'creator', 'checkoutUser', 'checkinUser', 'items.item.category']);

        return view('requests.show', compact('materialRequest'));
    }

    /**
     * Process checkout - barang keluar dari gudang
     */
    public function checkout(Request $request, MaterialRequest $materialRequest)
    {
        if (!$materialRequest->canCheckout()) {
            return back()->with('error', 'Request tidak dapat di-checkout.');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:material_request_items,id',
            'items.*.qty_out' => 'required|integer|min:0',
            'items.*.condition_out' => 'required|in:good,fair',
        ]);

        DB::transaction(function () use ($validated, $materialRequest) {
            foreach ($validated['items'] as $itemData) {
                $requestItem = MaterialRequestItem::find($itemData['id']);
                $item = $requestItem->item;

                // Validate stock availability
                if ($itemData['qty_out'] > $item->stock) {
                    throw new \Exception("Stok {$item->name} tidak mencukupi. Tersedia: {$item->stock}");
                }

                // Update request item
                $requestItem->update([
                    'qty_out' => $itemData['qty_out'],
                    'condition_out' => $itemData['condition_out'],
                ]);

                // Record stock mutation (stock decreases)
                if ($itemData['qty_out'] > 0) {
                    StockMutation::record(
                        $item,
                        StockMutation::TYPE_OUT,
                        $itemData['qty_out'],
                        "Checkout untuk: {$materialRequest->project_name}",
                        MaterialRequest::class,
                        $materialRequest->id
                    );
                }
            }

            // Update request status
            $materialRequest->update([
                'status' => MaterialRequest::STATUS_CHECKED_OUT,
                'checkout_by' => auth()->id(),
                'checkout_at' => now(),
            ]);
        });

        return redirect()->route('requests.show', $materialRequest)
            ->with('success', 'Checkout berhasil! Barang telah dikeluarkan dari gudang.');
    }

    /**
     * Show checkin form
     */
    public function checkinForm(MaterialRequest $materialRequest)
    {
        if (!$materialRequest->canCheckin()) {
            return back()->with('error', 'Request tidak dapat di-checkin.');
        }

        $materialRequest->load(['items.item.category']);

        return view('requests.checkin', compact('materialRequest'));
    }

    /**
     * Process checkin - rekonsiliasi barang kembali
     */
    public function checkin(Request $request, MaterialRequest $materialRequest)
    {
        if (!$materialRequest->canCheckin()) {
            return back()->with('error', 'Request tidak dapat di-checkin.');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:material_request_items,id',
            'items.*.qty_used' => 'required|integer|min:0',
            'items.*.qty_returned' => 'required|integer|min:0',
            'items.*.qty_damaged' => 'required|integer|min:0',
            'items.*.qty_lost' => 'required|integer|min:0',
            'items.*.notes' => 'nullable|string',
            'items.*.photo' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($validated, $request, $materialRequest) {
            foreach ($validated['items'] as $index => $itemData) {
                $requestItem = MaterialRequestItem::find($itemData['id']);
                $item = $requestItem->item;

                // Validate reconciliation
                $totalIn = $itemData['qty_used'] + $itemData['qty_returned'] + $itemData['qty_damaged'] + $itemData['qty_lost'];
                if ($totalIn > $requestItem->qty_out) {
                    throw new \Exception("Total qty untuk {$item->name} melebihi qty yang dikeluarkan.");
                }

                // Handle photo upload if exists
                $photoPath = null;
                if ($request->hasFile("items.{$index}.photo")) {
                    $photoPath = $request->file("items.{$index}.photo")->store('evidence', 'public');
                }

                // Determine condition_in based on quantities
                $conditionIn = 'good';
                if ($itemData['qty_damaged'] > 0 || $itemData['qty_lost'] > 0) {
                    $conditionIn = $itemData['qty_lost'] > 0 ? 'lost' : 'damaged';
                }

                // Update request item
                $requestItem->update([
                    'qty_used' => $itemData['qty_used'],
                    'qty_returned' => $itemData['qty_returned'],
                    'qty_damaged' => $itemData['qty_damaged'],
                    'qty_lost' => $itemData['qty_lost'],
                    'condition_in' => $conditionIn,
                    'notes' => $itemData['notes'] ?? null,
                    'photo_path' => $photoPath ?? $requestItem->photo_path,
                ]);

                // Record stock mutations

                // 1. Returned items go back to stock
                if ($itemData['qty_returned'] > 0) {
                    StockMutation::record(
                        $item,
                        StockMutation::TYPE_IN,
                        $itemData['qty_returned'],
                        "Pengembalian dari: {$materialRequest->project_name}",
                        MaterialRequest::class,
                        $materialRequest->id
                    );
                }

                // 2. Damaged items
                if ($itemData['qty_damaged'] > 0) {
                    StockMutation::record(
                        $item,
                        StockMutation::TYPE_DAMAGED,
                        $itemData['qty_damaged'],
                        "Rusak dari: {$materialRequest->project_name}",
                        MaterialRequest::class,
                        $materialRequest->id
                    );
                }

                // 3. Lost items
                if ($itemData['qty_lost'] > 0) {
                    StockMutation::record(
                        $item,
                        StockMutation::TYPE_LOST,
                        $itemData['qty_lost'],
                        "Hilang dari: {$materialRequest->project_name}",
                        MaterialRequest::class,
                        $materialRequest->id
                    );
                }
            }

            // Update request status
            $materialRequest->update([
                'status' => MaterialRequest::STATUS_CLOSED,
                'checkin_by' => auth()->id(),
                'checkin_at' => now(),
            ]);
        });

        return redirect()->route('requests.show', $materialRequest)
            ->with('success', 'Check-in selesai! Rekonsiliasi berhasil dicatat.');
    }

    /**
     * Get template items for AJAX request
     */
    public function getTemplateItems(ProjectTemplate $template)
    {
        $items = $template->items()->with('item')->get()->map(function ($templateItem) {
            return [
                'item_id' => $templateItem->item_id,
                'item_name' => $templateItem->item->name,
                'item_code' => $templateItem->item->code,
                'item_unit' => $templateItem->item->unit,
                'item_stock' => $templateItem->item->stock,
                'default_qty' => $templateItem->default_qty,
            ];
        });

        return response()->json($items);
    }
    /**
     * Remove the specified material request from storage.
     */
    public function destroy(MaterialRequest $materialRequest)
    {
        // Allow delete if pending OR corrupted (null status)
        if ($materialRequest->status !== MaterialRequest::STATUS_PENDING && !is_null($materialRequest->status)) {
            return back()->with('error', 'Hanya request dengan status Pending yang dapat dihapus. Status saat ini: ' . $materialRequest->status);
        }

        try {
            DB::transaction(function () use ($materialRequest) {
                // Manually delete items first
                $materialRequest->items()->delete();
                $materialRequest->delete();
            });
    
            return redirect()->route('requests.index')
                ->with('success', 'Request berhasil dihapus.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
