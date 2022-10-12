<?php

namespace App\Http\Controllers;

use App\Models\Kirim;

class KirimController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Kirim::all()
        ], 200);
    }
}
