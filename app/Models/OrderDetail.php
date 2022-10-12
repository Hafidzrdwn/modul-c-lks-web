<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = ['idOrderDetail'];
    protected $primaryKey = 'idOrderDetail';

    public function product()
    {
        return $this->belongsTo(Produk::class, 'idProduk')->withDefault();
    }
}
