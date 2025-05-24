<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_deck_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_deck_id')->constrained('menus_deck')->onDelete('cascade');
            $table->string('deskripsi_biaya');
            $table->decimal('jumlah_biaya', 12, 2); // Jika butuh pecahan misal 2.643,75, 1500.50
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_deck_expenses');
    }
};
