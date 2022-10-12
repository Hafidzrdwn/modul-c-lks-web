<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
        // coba statement
        try {
            $validateUser = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email|unique:customers',
                'password' => 'required|min:2',
                'noHP' => 'required',
                'alamat' => 'required',
            ]);

            // jika validasi gagal
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Error!',
                    'errors' => $validateUser->errors()
                ], 200);
            }

            // jika validasi berhasil
            $role = (explode('@', $request->email)[0] == "admin") ? 1 : 0;

            Customer::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'noHP' => $request->noHP,
                'alamat' => $request->alamat,
                'role' => $role,
            ]);

            // jika berhasil
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Registrasi, Silahkan Login!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:2',
            ]);

            // jika validasi gagal
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Error!',
                    'errors' => $validateUser->errors()
                ], 200);
            }

            // jika validasi berhasil
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login Gagal, Email atau Password Salah!',
                ], 401);
            }

            // cari data customer berdasarkan email
            $customer = Customer::where('email', $request->email)->first();

            // jika berhasil
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login!',
                'token' => $customer->createToken('API TOKEN')->plainTextToken,
                'user' => $customer,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function checkAuth()
    {
        if (Auth::check()) {
            return response()->json([
                'status' => true,
                'message' => 'Anda Sudah Login!',
                'data' => Auth::user(),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Anda Belum Login!',
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        try {
            // hapus token
            session()->invalidate();
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Logout!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
