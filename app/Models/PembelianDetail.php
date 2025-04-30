<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
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

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'Nota', 'Nota');
    }
}