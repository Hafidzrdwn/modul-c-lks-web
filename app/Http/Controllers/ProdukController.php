<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{

    protected function customMessage($req)
    {
        return [
            'idProduk.required' => 'Input new product!',
            'idProduk.unique' => "Product with id {$req->idProduk} already exist!"
        ];
    }

    public function index()
    {
        $produk = Produk::with('kategori')->oldest()->get();
        return response()->json([
            'status' => true,
            'data' => $produk
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = Validator::make(
            $request->all(),
            [
                'idProduk' => 'required|unique:produks|numeric',
                'namaProduk' => 'required',
                'beratProduk' => 'required',
                'warnaProduk' => 'required',
                'tanggalProduksi' => 'required',
                'hargaProduk' => 'required',
                'idKategori' => 'required'
            ],
            $this->customMessage($request)
        );

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Error!',
                'errors' => $validatedData->errors(),
                'type' => 'product'
            ], 200);
        }

        $produk = Produk::create([
            'idProduk' => (int)$request->idProduk,
            'namaProduk' => $request->namaProduk,
            'beratProduk' => (int)$request->beratProduk,
            'warnaProduk' => $request->warnaProduk,
            'tanggalProduksi' => $request->tanggalProduksi,
            'hargaProduk' => (int)$request->hargaProduk,
            'idKategori' => $request->idKategori
        ]);
        return response()->json([
            'status' => true,
            'data' => $produk,
            'type' => 'product'
        ], 200);
    }

    public function edit(Produk $product)
    {
        return response()->json([
            'status' => true,
            'data' => $product->only(['idProduk', 'namaProduk', 'beratProduk', 'warnaProduk', 'tanggalProduksi', 'hargaProduk', 'idKategori'])
        ]);
    }

    public function update(Request $request, Produk $product)
    {
        $rules = [
            'idProduk' => 'required|numeric',
            'namaProduk' => 'required',
            'beratProduk' => 'required',
            'warnaProduk' => 'required',
            'tanggalProduksi' => 'required',
            'hargaProduk' => 'required',
            'idKategori' => 'required'
        ];

        if ((int)$request->idProduk !== $product->idProduk) {
            $rules['idProduk'] = 'required|numeric|unique:produks';
        }

        $validatedData = Validator::make(
            $request->all(),
            $rules,
            $this->customMessage($request)
        );

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Error!',
                'errors' => $validatedData->errors(),
                'type' => 'product'
            ], 200);
        }

        $product->update([
            'idProduk' => (int)$request->idProduk,
            'namaProduk' => $request->namaProduk,
            'beratProduk' => (int)$request->beratProduk,
            'warnaProduk' => $request->warnaProduk,
            'tanggalProduksi' => $request->tanggalProduksi,
            'hargaProduk' => (int)$request->hargaProduk,
            'idKategori' => $request->idKategori
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Update succes!',
            'type' => 'product'
        ], 200);
    }

    public function destroy(Produk $product)
    {
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'Product deleted!',
        ]);
    }
}
