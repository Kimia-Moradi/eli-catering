<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeMenu = Menu::active()->with('menuItems')->first();

        return view('admin.dashboard', [
            'productCount' => Product::where('is_active', true)->count(),
            'unavailableCount' => Product::where('is_active', true)->where('is_available', false)->count(),
            'activeMenuItemCount' => $activeMenu?->menuItems->count() ?? 0,
            'hasActiveMenu' => $activeMenu !== null,
        ]);
    }
}
