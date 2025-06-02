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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            // Komponen menu disimpan di tabel menus_component
            $table->foreignId('category_id')->constrained('menus_category')->onDelete('restrict');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->integer('harga')->nullable();
            $table->date('terakhir_dipilih')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
