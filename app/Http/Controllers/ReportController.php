<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaterialRequest;
use App\Models\StockMutation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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

        $recentRequests = MaterialRequest::with(['creator', 'template'])
            ->latest()
            ->take(5)
            ->get();

        $lowStockItems = Item::with('category')
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentRequests', 'lowStockItems'));
    }
}
