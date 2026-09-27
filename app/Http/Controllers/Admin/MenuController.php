<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Route is /admin/menus/{date?} — defaults to today. Kept simple on
     * purpose: v1 only needs to manage "the current menu", not a full
     * historical archive, but modeling menus by date leaves room for that
     * later without a schema change.
     */
    public function edit(Request $request, ?string $date = null): View
    {
        $date ??= $request->query('date');
        $date ??= now()->toDateString();
        $carbonDate = \Illuminate\Support\Carbon::parse($date);

        $menu = Menu::firstOrCreate(['menu_date' => $date]);

        $menu->load(['menuItems' => fn ($q) => $q->orderBy('display_order')->with('product')]);

        $usedProductIds = $menu->menuItems->pluck('product_id');

        $availableProducts = Product::where('is_active', true)
            ->whereNotIn('id', $usedProductIds)
            ->orderBy('name')
            ->get();

        return view('admin.menu.edit', [
            'menu' => $menu,
            'availableProducts' => $availableProducts,
            'date' => $date,
            'previousDate' => $carbonDate->copy()->subDay()->toDateString(),
            'nextDate' => $carbonDate->copy()->addDay()->toDateString(),
            'isToday' => $date === now()->toDateString(),
        ]);
    }

    public function addItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'menu_id' => ['required', 'exists:menus,id'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $nextOrder = MenuItem::where('menu_id', $validated['menu_id'])->max('display_order') + 1;

        MenuItem::firstOrCreate(
            ['menu_id' => $validated['menu_id'], 'product_id' => $validated['product_id']],
            ['display_order' => $nextOrder],
        );

        $menu = Menu::findOrFail($validated['menu_id']);

        return redirect()->route('admin.menu.edit', ['date' => $menu->menu_date->toDateString()])
            ->with('status', 'غذا به منو اضافه شد.');
    }

    public function removeItem(MenuItem $menuItem): RedirectResponse
    {
        $date = $menuItem->menu->menu_date->toDateString();
        $menuItem->delete();

        return redirect()->route('admin.menu.edit', ['date' => $date])
            ->with('status', 'غذا از منو حذف شد.');
    }

    /**
     * Deliberately per-row rather than one big batch form: each menu item
     * is its own small <form> with two submit buttons (save order / remove).
     * A single form covering the whole list would mean nesting a "remove"
     * form inside the "reorder" form, which plain HTML can't do. This is
     * simpler and needs no JavaScript, matching the spec's "JS only where
     * necessary" guidance.
     */
    public function updateOrder(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $validated = $request->validate([
            'display_order' => ['required', 'integer', 'min:0'],
        ]);

        $menuItem->update($validated);

        return redirect()->route('admin.menu.edit', ['date' => $menuItem->menu->menu_date->toDateString()])
            ->with('status', 'ترتیب ذخیره شد.');
    }

    public function activate(Menu $menu): RedirectResponse
    {
        $menu->activateExclusively();

        return redirect()->route('admin.menu.edit', ['date' => $menu->menu_date->toDateString()])
            ->with('status', 'این منو به عنوان منوی فعال سایت تنظیم شد.');
    }
}
