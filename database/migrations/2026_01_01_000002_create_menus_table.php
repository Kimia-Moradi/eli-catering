<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->date('menu_date')->unique();
            // Exactly one menu is active at a time — the public homepage
            // renders whichever menu has is_active = true. Modeling it this
            // way (rather than always using "today's date") means the owner
            // can prepare tomorrow's menu in advance without it going live
            // early, and a holiday/special menu can stay active across
            // several calendar days if needed.
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
