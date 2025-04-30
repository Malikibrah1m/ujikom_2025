<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $primaryKey = 'Nota';
    
    protected $fillable = [
        'TglNota',
        'KdPelanggan',
        'Diskon'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'KdPelanggan', 'KdPelanggan');
    }

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'Nota', 'Nota');
    }
}