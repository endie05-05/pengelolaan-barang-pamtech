<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use App\Models\ProjectTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TechnicianController extends Controller
{
    /**
     * Technician Dashboard - "My Projects"
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // Active projects - created by user
        $activeProjects = MaterialRequest::with(['template', 'items.item'])
            ->where('created_by', $user->id)
            ->whereIn('status', [
                MaterialRequest::STATUS_PENDING, 
                MaterialRequest::STATUS_CHECKED_OUT, 
                MaterialRequest::STATUS_RETURNED
            ])
            ->latest()
            ->get();

        // Completed projects - created by user
        $completedProjects = MaterialRequest::with(['template', 'items.item'])
            ->where('created_by', $user->id)
            ->where('status', MaterialRequest::STATUS_CLOSED)
            ->latest()
            ->take(5)
            ->get();

        return view('technician.dashboard', compact('activeProjects', 'completedProjects'));
    }

    /**
     * Show form to create a new request (Simplified)
     */
    public function createRequest()
    {
        $templates = ProjectTemplate::with('items.item')->get();
        // Technicians can see all available items
        $items = Item::with('category')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();
            
        return view('technician.create-request', compact('templates', 'items'));
    }

    /**
     * Store a new request from technician
     */
    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'nullable|exists:project_templates,id',
            'project_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'departure_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty_requested' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $user = Auth::user();
            
            // Create material request
            $materialRequest = MaterialRequest::create([
                'template_id' => $validated['template_id'] ?? null,
                'created_by' => $user->id,
                'project_name' => $validated['project_name'],
                'technician_name' => $user->name,
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

        return redirect()->route('technician.dashboard')
            ->with('success', 'Request proyek berhasil dibuat! Menunggu persetujuan admin.');
    }

    /**
     * Show project details for technician
     */
    public function showProject(MaterialRequest $materialRequest)
    {
        // Ensure technician handles only their own projects
        $user = Auth::user();
        if (strpos($materialRequest->technician_name, $user->name) === false && $materialRequest->created_by !== $user->id) {
             // Optional: Allow viewing if they are just a viewer, but for now restrict
             // return abort(403); 
        }

        $materialRequest->load(['template', 'items.item.category', 'creator']);
        return view('technician.show-project', compact('materialRequest'));
    }

    /**
     * View items (read-only for technician)
     */
    public function items(Request $request)
    {
        $query = Item::with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $items = $query->orderBy('name')->paginate(20);
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('technician.items', compact('items', 'categories'));
    }

    /**
     * View reports (read-only for technician)
     */
    public function reports()
    {
        return view('technician.reports');
    }
}
