<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index', [
            'items' => Item::query()->orderBy('name')->get(),
            'lowStockCount' => Item::query()->whereColumn('current_stock', '<=', 'minimum_stock')->count(),
            'recentMovements' => StockMovement::query()->with('item')->latest()->limit(20)->get(),
        ]);
    }

    public function printStock(): View
    {
        return view('reports.print-stock', [
            'items' => Item::query()->orderBy('name')->get(),
        ]);
    }
}
