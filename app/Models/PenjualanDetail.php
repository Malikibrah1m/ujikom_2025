<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nota',
        'KdObat',
        'Jumlah'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'KdObat', 'KdObat');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'Nota', 'Nota');
    }
}