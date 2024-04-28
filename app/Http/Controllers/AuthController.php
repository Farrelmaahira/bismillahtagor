<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        //VALIDASI REQUEST DATA DARI USER UNTUK LOGIN
        $vld = Validator::make($request->aLL(), [
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        //JIKA VALIDASI GAGAL KEMBALIKAN PESAN ERROR
        if($vld->fails())
        {
            return response()->json([
                'message' => 'invalid field'
            ], 422);
        }

        //JIKA VALIDASI BERHASIL CARI USER BERDASARKAN USERNAME YANG DI INPUT USER
        $user = User::where('username', $request->username)->first();

        //JIKA TIDAK ADA USER ATAU!! PASSWORD TIDAK SAMA KEMBALIKAN PESAN ERROR
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'invalid login'
            ], 401);
        }


        //JIKA BERHASIL LOGIN BIKIN TOKEN
        $token = $user->createToken('token')->plainTextToken;


        //KEMBALIKAN TOKEN KE USER
        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {

        //AMBIL USER YANG SEDANG LOGIN MENGGUNAKAN TOKEN, KEMUDIAN HAPUS/DEACTIVE TOKEN
        $request->user()->currentAccessToken()->delete();

        //KEMBALIKAN PESAN BERHASIL LOGOUT
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
