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
        Schema::create('menu_deck_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_deck_id')->constrained('menus_deck')->onDelete('cascade');
            $table->string('deskripsi_pembayaran');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->date('tanggal_bayar');
            $table->string('metode_pembayaran'); // Transfer / Cash / dll
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_deck_payments');
    }
};
