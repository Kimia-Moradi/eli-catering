<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * The single public page. Everything else on the site (nav links to
     * #menu / #about / #contact) is an anchor on this same page, per the
     * spec's one-page requirement.
     */
    public function index(): View
    {
        $menu = Menu::active()
            ->with(['menuItems' => function ($query) {
                $query->whereHas('product', fn ($q) => $q->where('is_active', true))
                    ->with('product')
                    ->orderBy('display_order');
            }])
            ->first();

        $menuItems = $menu?->menuItems ?? collect();

        return view('home', [
            'menuItems' => $menuItems,
        ]);
    }
}
