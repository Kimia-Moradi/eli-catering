<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('price'); // Toman, stored as a whole number — no fractional currency in this market.
            $table->string('image_path')->nullable(); // relative path on the 'public' storage disk, not binary data in the DB.

            // Two distinct flags, matching two distinct admin actions:
            //   is_available — "temporarily out of stock" (ناموجود). The item
            //     stays visible on the public menu, just marked unavailable.
            //   is_active    — "removed/deactivated" by the owner. Hidden
            //     from the public menu and from being added to a menu, but
            //     the row is kept (not hard-deleted) so historical menu_items
            //     rows referencing it don't break, and it can be restored.
            $table->boolean('is_available')->default(true);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
