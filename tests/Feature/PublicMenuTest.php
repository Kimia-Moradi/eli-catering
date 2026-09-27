<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_homepage_shows_an_empty_state_when_no_menu_is_active(): void
    {
        // Deliberately no Menu created at all here.
        $this->get('/')->assertOk()->assertSee('هنوز تنظیم نشده');
    }

    public function test_active_menu_items_are_displayed_in_order(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString(), 'is_active' => true]);

        $first = Product::create(['name' => 'جوجه کباب', 'price' => 300000, 'is_available' => true, 'is_active' => true]);
        $second = Product::create(['name' => 'قورمه سبزی', 'price' => 260000, 'is_available' => true, 'is_active' => true]);

        MenuItem::create(['menu_id' => $menu->id, 'product_id' => $second->id, 'display_order' => 0]);
        MenuItem::create(['menu_id' => $menu->id, 'product_id' => $first->id, 'display_order' => 1]);

        $response = $this->get('/');

        $response->assertOk()->assertSeeInOrder(['قورمه سبزی', 'جوجه کباب']);
    }

    public function test_unavailable_product_shows_the_unavailable_tag(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString(), 'is_active' => true]);
        $product = Product::create(['name' => 'دوغ', 'price' => 25000, 'is_available' => false, 'is_active' => true]);
        MenuItem::create(['menu_id' => $menu->id, 'product_id' => $product->id, 'display_order' => 0]);

        $this->get('/')->assertOk()->assertSee('ناموجود')->assertSee('دوغ');
    }

    public function test_deactivated_products_never_appear_even_if_still_linked_to_the_active_menu(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString(), 'is_active' => true]);
        $product = Product::create(['name' => 'محصول حذف‌شده', 'price' => 10000, 'is_available' => true, 'is_active' => false]);
        MenuItem::create(['menu_id' => $menu->id, 'product_id' => $product->id, 'display_order' => 0]);

        $this->get('/')->assertOk()->assertDontSee('محصول حذف‌شده');
    }

    public function test_only_the_active_menu_is_shown_not_other_dated_menus(): void
    {
        $inactiveMenu = Menu::create(['menu_date' => now()->subDay()->toDateString(), 'is_active' => false]);
        $yesterdayProduct = Product::create(['name' => 'غذای دیروز', 'price' => 50000, 'is_available' => true, 'is_active' => true]);
        MenuItem::create(['menu_id' => $inactiveMenu->id, 'product_id' => $yesterdayProduct->id, 'display_order' => 0]);

        $this->get('/')->assertOk()->assertDontSee('غذای دیروز');
    }
}
