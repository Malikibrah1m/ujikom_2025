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
        Schema::create('obats', function (Blueprint $table) {
            $table->id('KdObat');
            $table->string('NmObat');
            $table->string('Jenis');
            $table->string('Satuan');
            $table->decimal('HargaBeli', 12, 2);
            $table->decimal('HargaJual', 12, 2);
            $table->integer('Stok')->default(0);
            $table->foreignId('KdSupplier')->constrained('suppliers', 'KdSupplier')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
