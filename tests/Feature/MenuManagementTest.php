<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_visiting_the_menu_page_creates_a_menu_row_for_that_date_if_none_exists(): void
    {
        $this->assertDatabaseCount('menus', 0);

        $this->actingAs($this->admin())->get('/admin/menus/2026-12-25')->assertOk();

        $menu = Menu::first();

$this->assertNotNull($menu);
$this->assertSame('2026-12-25', $menu->menu_date->toDateString());
$this->assertFalse($menu->is_active);
    }

    public function test_the_date_query_string_is_accepted_as_a_fallback_for_the_date_picker_form(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/menus?date=2026-12-25')
            ->assertOk()
            ->assertSee('2026-12-25');
    }

    public function test_admin_can_add_a_product_to_the_menu(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString()]);
        $product = Product::create(['name' => 'جوجه کباب', 'price' => 300000, 'is_available' => true, 'is_active' => true]);

        $this->actingAs($this->admin())->post('/admin/menu-items', [
            'menu_id' => $menu->id,
            'product_id' => $product->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('menu_items', ['menu_id' => $menu->id, 'product_id' => $product->id]);
    }

    public function test_a_product_already_used_elsewhere_does_not_appear_twice_in_the_add_dropdown(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString()]);
        $product = Product::create(['name' => 'دوغ', 'price' => 25000, 'is_available' => true, 'is_active' => true]);
        MenuItem::create(['menu_id' => $menu->id, 'product_id' => $product->id, 'display_order' => 0]);

        // Adding the same product again should not create a second row (firstOrCreate).
        $this->actingAs($this->admin())->post('/admin/menu-items', [
            'menu_id' => $menu->id,
            'product_id' => $product->id,
        ]);

        $this->assertSame(1, MenuItem::where('menu_id', $menu->id)->where('product_id', $product->id)->count());
    }

    public function test_admin_can_remove_an_item_from_the_menu(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString()]);
        $product = Product::create(['name' => 'سالاد فصل', 'price' => 60000, 'is_available' => true, 'is_active' => true]);
        $item = MenuItem::create(['menu_id' => $menu->id, 'product_id' => $product->id, 'display_order' => 0]);

        $this->actingAs($this->admin())->delete("/admin/menu-items/{$item->id}")->assertRedirect();

        $this->assertDatabaseMissing('menu_items', ['id' => $item->id]);
        $this->assertDatabaseHas('products', ['id' => $product->id]); // the product itself is untouched
    }

    public function test_admin_can_change_a_menu_items_display_order(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString()]);
        $product = Product::create(['name' => 'قورمه سبزی', 'price' => 260000, 'is_available' => true, 'is_active' => true]);
        $item = MenuItem::create(['menu_id' => $menu->id, 'product_id' => $product->id, 'display_order' => 0]);

        $this->actingAs($this->admin())
            ->patch("/admin/menu-items/{$item->id}/order", ['display_order' => 5])
            ->assertRedirect();

        $this->assertSame(5, $item->fresh()->display_order);
    }

    public function test_activating_a_menu_deactivates_every_other_menu(): void
    {
        $oldActive = Menu::create(['menu_date' => now()->subDay()->toDateString(), 'is_active' => true]);
        $newMenu = Menu::create(['menu_date' => now()->toDateString(), 'is_active' => false]);

        $this->actingAs($this->admin())->patch("/admin/menus/{$newMenu->id}/activate")->assertRedirect();

        $this->assertFalse($oldActive->fresh()->is_active);
        $this->assertTrue($newMenu->fresh()->is_active);
    }

    public function test_activating_a_future_menu_makes_it_the_one_shown_publicly(): void
    {
        $tomorrow = Menu::create(['menu_date' => now()->addDay()->toDateString(), 'is_active' => false]);
        $product = Product::create(['name' => 'غذای فردا', 'price' => 90000, 'is_available' => true, 'is_active' => true]);
        MenuItem::create(['menu_id' => $tomorrow->id, 'product_id' => $product->id, 'display_order' => 0]);

        $this->get('/')->assertDontSee('غذای فردا'); // not active yet

        $this->actingAs($this->admin())->patch("/admin/menus/{$tomorrow->id}/activate");

        $this->get('/')->assertSee('غذای فردا'); // now it is
    }

    public function test_guests_cannot_modify_the_menu(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString()]);
        $product = Product::create(['name' => 'محافظت‌شده', 'price' => 10000, 'is_available' => true, 'is_active' => true]);

        $this->post('/admin/menu-items', ['menu_id' => $menu->id, 'product_id' => $product->id])
            ->assertRedirect('/admin/login');

        $this->assertDatabaseMissing('menu_items', ['menu_id' => $menu->id, 'product_id' => $product->id]);
    }
}
