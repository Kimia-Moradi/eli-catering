<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // CHANGE THIS PASSWORD before deploying anywhere real.
        User::firstOrCreate(
            ['email' => 'owner@elicatering.test'],
            [
                'name' => 'Eli Catering Owner',
                'password' => 'change-me-immediately', // hashed automatically via the User model's cast
                'role' => 'admin',
            ],
        );

        $menu = Menu::firstOrCreate(
            ['menu_date' => now()->toDateString()],
            ['is_active' => true],
        );

        // Same five items already used (and visually verified) in the
        // static front-end prototype, so the Blade-rendered page can be
        // compared directly against it.
        $items = [
            ['name' => 'زرشک پلو با مرغ', 'price' => 280000, 'is_available' => true],
            ['name' => 'قورمه سبزی', 'price' => 260000, 'is_available' => true],
            ['name' => 'جوجه کباب', 'price' => 300000, 'is_available' => true],
            ['name' => 'سالاد فصل', 'price' => 60000, 'is_available' => true],
            ['name' => 'دوغ', 'price' => 25000, 'is_available' => false],
        ];

        foreach ($items as $order => $item) {
            $product = Product::firstOrCreate(
                ['name' => $item['name']],
                ['price' => $item['price'], 'is_available' => $item['is_available'], 'is_active' => true],
            );

            MenuItem::firstOrCreate(
                ['menu_id' => $menu->id, 'product_id' => $product->id],
                ['display_order' => $order],
            );
        }
    }
}
