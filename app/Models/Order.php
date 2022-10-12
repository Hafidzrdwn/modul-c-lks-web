<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['idOrder'];
    protected $primaryKey = 'idOrder';

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'idOrder');
    }

    public function kirim()
    {
        return $this->belongsTo(Kirim::class, 'idKirim');
    }
}
