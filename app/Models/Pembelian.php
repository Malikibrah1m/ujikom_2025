<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians';
    protected $primaryKey = 'Nota';
    
    protected $fillable = [
        'TglNota',
        'KdSupplier',
        'Diskon'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'KdSupplier', 'KdSupplier');
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class, 'Nota', 'Nota');
    }
}