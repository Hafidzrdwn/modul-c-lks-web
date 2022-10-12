<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $primaryKey = 'idProduk';
    public $incrementing = false;
    protected $fillable = [
        'idProduk',
        'namaProduk',
        'beratProduk',
        'warnaProduk',
        'tanggalProduksi',
        'hargaProduk',
        'idKategori',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idKategori');
    }
}
