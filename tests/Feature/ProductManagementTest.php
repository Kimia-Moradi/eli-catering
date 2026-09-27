<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_create_a_product(): void
    {
        $response = $this->actingAs($this->admin())->post('/admin/products', [
            'name' => 'کباب کوبیده',
            'price' => 320000,
            'is_available' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'کباب کوبیده', 'price' => 320000, 'is_active' => true]);
    }

    public function test_creating_a_product_requires_a_name_and_price(): void
    {
        $response = $this->actingAs($this->admin())->post('/admin/products', []);

        $response->assertSessionHasErrors(['name', 'price']);
    }

    public function test_deactivating_a_product_soft_removes_it_rather_than_deleting_the_row(): void
    {
        $product = Product::create(['name' => 'سالاد فصل', 'price' => 60000, 'is_available' => true, 'is_active' => true]);

        $this->actingAs($this->admin())->delete("/admin/products/{$product->id}");

        $this->assertDatabaseHas('products', ['id' => $product->id]); // still exists
        $this->assertFalse($product->fresh()->is_active); // just deactivated
    }

    public function test_deactivating_a_product_removes_it_from_the_public_menu(): void
    {
        $menu = Menu::create(['menu_date' => now()->toDateString(), 'is_active' => true]);
        $product = Product::create(['name' => 'به‌زودی حذف می‌شود', 'price' => 40000, 'is_available' => true, 'is_active' => true]);
        MenuItem::create(['menu_id' => $menu->id, 'product_id' => $product->id, 'display_order' => 0]);

        $this->get('/')->assertSee('به‌زودی حذف می‌شود');

        $this->actingAs($this->admin())->delete("/admin/products/{$product->id}");

        $this->get('/')->assertDontSee('به‌زودی حذف می‌شود');
    }

    public function test_restoring_a_deactivated_product_brings_it_back(): void
    {
        $product = Product::create(['name' => 'قورمه سبزی', 'price' => 260000, 'is_available' => true, 'is_active' => false]);

        $this->actingAs($this->admin())->patch("/admin/products/{$product->id}/restore");

        $this->assertTrue($product->fresh()->is_active);
    }

    public function test_toggling_availability_flips_the_flag(): void
    {
        $product = Product::create(['name' => 'دوغ', 'price' => 25000, 'is_available' => true, 'is_active' => true]);

        $this->actingAs($this->admin())->patch("/admin/products/{$product->id}/toggle-availability");

        $this->assertFalse($product->fresh()->is_available);
    }

    public function test_guests_cannot_perform_any_product_management_action(): void
    {
        $product = Product::create(['name' => 'محافظت‌شده', 'price' => 10000, 'is_available' => true, 'is_active' => true]);

        $this->delete("/admin/products/{$product->id}")->assertRedirect('/admin/login');
        $this->assertTrue($product->fresh()->is_active); // untouched
    }
}
