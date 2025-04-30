<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obats';
    protected $primaryKey = 'KdObat';
    
    protected $fillable = [
        'NmObat',
        'Jenis',
        'Satuan',
        'HargaBeli',
        'HargaJual',
        'Stok',
        'KdSupplier'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'KdSupplier', 'KdSupplier');
    }
}