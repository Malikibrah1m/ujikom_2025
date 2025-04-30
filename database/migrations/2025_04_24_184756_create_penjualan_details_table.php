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
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Nota')
                  ->constrained('penjualans', 'Nota') // Tambahkan parameter kedua
                  ->onDelete('cascade');
            $table->foreignId('KdObat')->constrained('obats', 'KdObat')->onDelete('cascade');
            $table->integer('Jumlah');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_details');
    }
};
