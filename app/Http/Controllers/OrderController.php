<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = Order::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Order Place successfully',
            'data' => $data
        ]);
    }
}
