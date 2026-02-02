<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaterialRequest;
use App\Models\StockMutation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Unified Reports Index
     */
    public function index(Request $request)
    {
        $activeTab = $request->input('tab', 'loss_damage');

        // --- 1. Loss & Damage Data ---
        $lossQuery = StockMutation::with(['item.category', 'creator'])
            ->whereIn('type', [StockMutation::TYPE_DAMAGED, StockMutation::TYPE_LOST]);

        if ($request->filled('start_date')) {
            $lossQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $lossQuery->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('type') && in_array($request->type, [StockMutation::TYPE_DAMAGED, StockMutation::TYPE_LOST])) {
            $lossQuery->where('type', $request->type);
        }

        $lossMutations = $lossQuery->latest()->paginate(10, ['*'], 'loss_page');
        $lossSummary = [
            'total_damaged' => StockMutation::where('type', StockMutation::TYPE_DAMAGED)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('qty'),
            'total_lost' => StockMutation::where('type', StockMutation::TYPE_LOST)
                 ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                 ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('qty'),
        ];

        // --- 2. Stock Movement Data ---
        $stockQuery = StockMutation::with(['item.category', 'creator']);
        
        if ($request->filled('start_date')) {
            $stockQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $stockQuery->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('item_id')) {
            $stockQuery->where('item_id', $request->item_id);
        }
        if ($request->filled('type')) {
            $stockQuery->where('type', $request->type);
        }

        $stockMutations = $stockQuery->latest()->paginate(10, ['*'], 'stock_page');
        $items = Item::orderBy('name')->get();

        // --- 3. Tool Utilization Data ---
        $toolQuery = Item::where('item_type', 'tools')
            ->withCount(['materialRequestItems as usage_count' => function ($q) use ($request) {
                $q->whereHas('materialRequest', function ($mq) use ($request) {
                     if ($request->filled('start_date')) {
                         $mq->whereDate('created_at', '>=', $request->start_date);
                     }
                     if ($request->filled('end_date')) {
                         $mq->whereDate('created_at', '<=', $request->end_date);
                     }
                });
            }]);
        
        $tools = $toolQuery->orderByDesc('usage_count')->paginate(10, ['*'], 'tool_page');

        return view('reports.index', compact(
            'activeTab',
            'lossMutations', 'lossSummary',
            'stockMutations', 'items',
            'tools'
        ));
    }
    /**
     * Loss & Damage Report
     */
    public function lossAndDamage(Request $request)
    {
        $query = StockMutation::with(['item.category', 'creator'])
            ->whereIn('type', [StockMutation::TYPE_DAMAGED, StockMutation::TYPE_LOST]);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $mutations = $query->latest()->paginate(20);

        // Summary stats
        $summary = [
            'total_damaged' => StockMutation::where('type', StockMutation::TYPE_DAMAGED)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('qty'),
            'total_lost' => StockMutation::where('type', StockMutation::TYPE_LOST)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('qty'),
        ];

        return view('reports.loss-damage', compact('mutations', 'summary'));
    }

    /**
     * Stock Movement Report
     */
    public function stockMovement(Request $request)
    {
        $query = StockMutation::with(['item.category', 'creator']);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by item
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $mutations = $query->latest()->paginate(20);
        $items = Item::orderBy('name')->get();

        return view('reports.stock-movement', compact('mutations', 'items'));
    }

    /**
     * Tool Utilization Report
     */
    public function toolUtilization(Request $request)
    {
        $query = Item::where('item_type', 'tools')
            ->withCount(['materialRequestItems as usage_count' => function ($q) use ($request) {
                $q->whereHas('materialRequest', function ($mq) use ($request) {
                    if ($request->filled('start_date')) {
                        $mq->whereDate('created_at', '>=', $request->start_date);
                    }
                    if ($request->filled('end_date')) {
                        $mq->whereDate('created_at', '<=', $request->end_date);
                    }
                });
            }]);

        $tools = $query->orderByDesc('usage_count')->paginate(20);

        return view('reports.tool-utilization', compact('tools'));
    }

    /**
     * Dashboard summary
     */
    public function dashboard()
    {
        $stats = [
            'total_items' => Item::count(),
            'low_stock_items' => Item::whereColumn('stock', '<=', 'min_stock')->count(),
            'pending_requests' => MaterialRequest::pending()->count(),
            'checked_out_requests' => MaterialRequest::checkedOut()->count(),
            'total_damaged_this_month' => StockMutation::where('type', StockMutation::TYPE_DAMAGED)
                ->whereMonth('created_at', now()->month)
                ->sum('qty'),
            'total_lost_this_month' => StockMutation::where('type', StockMutation::TYPE_LOST)
                ->whereMonth('created_at', now()->month)
                ->sum('qty'),
        ];

        $recentRequests = MaterialRequest::with(['creator', 'template', 'items.item'])
            ->latest()
            ->take(10)
            ->get();

        $lowStockItems = Item::with('category')
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentRequests', 'lowStockItems'));
    }
    /**
     * Export Loss & Damage Report PDF
     */
    public function exportLossDamagePdf(Request $request)
    {
        $query = StockMutation::with(['item.category', 'creator'])
            ->whereIn('type', [StockMutation::TYPE_DAMAGED, StockMutation::TYPE_LOST]);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $mutations = $query->latest()->get(); // Get all data

        $summary = [
            'total_damaged' => StockMutation::where('type', StockMutation::TYPE_DAMAGED)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('qty'),
            'total_lost' => StockMutation::where('type', StockMutation::TYPE_LOST)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('qty'),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf.loss-damage', compact('mutations', 'summary'));
        return $pdf->download('laporan-loss-damage-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Stock Movement Report PDF
     */
    public function exportStockMovementPdf(Request $request)
    {
        $query = StockMutation::with(['item.category', 'creator']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $mutations = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf.stock-movement', compact('mutations'));
        return $pdf->download('laporan-mutasi-stok-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Tool Utilization Report PDF
     */
    /**
     * Export Unified Report PDF
     */
    public function exportUnifiedPdf(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // 1. Loss & Damage Data
        $lossMutations = StockMutation::with(['item.category', 'creator'])
            ->whereIn('type', [StockMutation::TYPE_DAMAGED, StockMutation::TYPE_LOST])
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->latest()
            ->get();

        $lossSummary = [
            'total_damaged' => $lossMutations->where('type', StockMutation::TYPE_DAMAGED)->sum('qty'),
            'total_lost' => $lossMutations->where('type', StockMutation::TYPE_LOST)->sum('qty'),
        ];

        // 2. Stock Movement Data
        $stockMutations = StockMutation::with(['item.category', 'creator'])
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->latest()
            ->get();

        // 3. Tool Utilization Data
        $tools = Item::where('item_type', 'tools')
            ->withCount(['materialRequestItems as usage_count' => function ($q) use ($startDate, $endDate) {
                $q->whereHas('materialRequest', function ($mq) use ($startDate, $endDate) {
                    if ($startDate) {
                        $mq->whereDate('created_at', '>=', $startDate);
                    }
                    if ($endDate) {
                        $mq->whereDate('created_at', '<=', $endDate);
                    }
                });
            }])
            ->orderByDesc('usage_count')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf.unified', compact(
            'lossMutations', 
            'lossSummary', 
            'stockMutations', 
            'tools',
            'startDate',
            'endDate'
        ));

        return $pdf->download('laporan-lengkap-' . date('Y-m-d') . '.pdf');
    }
}
