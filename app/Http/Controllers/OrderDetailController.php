<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function store(Request $request)
    {
        OrderDetail::insert($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Order Detail successfully created'
        ]);
    }
}
