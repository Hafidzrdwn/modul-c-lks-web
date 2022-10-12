<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Mengambil Data',
            'data' => Customer::with('orders')->get()
        ], 200);
    }

    public function getOrders(Customer $customer)
    {
        $datas = $customer->orders()->with('kirim', 'orderDetails', 'orderDetails.product')->get();

        foreach ($datas as $data) {
            $data['orderDate'] = Carbon::parse($data->orderDate)->translatedFormat('D M d Y');
            $data['totalSemuaHarga'] = $data->orderDetails->sum('totalHarga');
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Mengambil Data',
            'data' => $datas,
        ], 200);
    }
}
