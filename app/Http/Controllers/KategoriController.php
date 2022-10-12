<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{

    protected function customMessage($req)
    {
        return [
            'namaKategori.required' => 'Input new category!',
            'namaKategori.unique' => "{$req->namaKategori} category already exist!"
        ];
    }

    public function index()
    {
        $kategori = Kategori::all();
        return response()->json([
            'status' => true,
            'data' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make(
            $request->all(),
            [
                'namaKategori' => 'required|unique:kategoris|alpha',
            ],
            $this->customMessage($request)
        );

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Error!',
                'errors' => $validatedData->errors(),
                'type' => 'category'
            ], 200);
        }

        $kategori = Kategori::create($request->all());
        return response()->json([
            'status' => true,
            'data' => $kategori,
            'type' => 'category'
        ], 200);
    }

    public function edit(Kategori $kategori)
    {
        return response()->json([
            'status' => true,
            'data' => $kategori->only(['idKategori', 'namaKategori'])
        ], 200);
    }

    public function update(Request $request, Kategori $kategori)
    {
        if ($request->namaKategori == $kategori->namaKategori) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Error!',
                'errors' => [
                    'namaKategori' => ['Category not changed!']
                ]
            ], 200);
        } else {
            $validatedData = Validator::make(
                $request->all(),
                [
                    'namaKategori' => 'required|unique:kategoris|alpha',
                ],
                $this->customMessage($request)
            );

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Error!',
                    'errors' => $validatedData->errors(),
                    'type' => 'category'
                ], 200);
            }

            $kategori->update($request->all());
            return response()->json([
                'status' => true,
                'type' => 'category',
                'data' => $kategori
            ], 200);
        }
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category deleted!',
        ], 200);
    }
}
