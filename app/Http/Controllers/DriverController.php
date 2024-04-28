<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //AMBIL DATA DRIVER DARI DB
        $driver = Driver::all();

        //KEMBALI KAN DATA DRIVER MENGGUNAKAN RESOURCE
        return response()->json([
            'data' => BusResource::collection($driver)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //VALIDASI DATA DARI REQUEST USER
        $vld = Validator::make($request->all(), [
            'name' => 'required|string',
            'age' => 'required|integer',
            'id_number' => 'required|string'
        ]);

        //JIKA VALIDASI GAGAL KEMBALIKAN PESAN ERROR
        if($vld->fails())
        {
            return response()->json([
                'message' => 'invalid field'
            ], 422);
        }


        //JIKA VALIDASI BERHASIL BUAT DRIVER BARU
        Driver::create($request->all());

        //KEMBALIKAN RESPONSE 
        return response()->json([
            'message' => 'create driver success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //CARI DRIVER YANG INGIN DI UPDATE 
        $driver = Driver::find($id);

        //JIKA TIDAK ADA KEMBALIKAN PESAN ERROR
        if(is_null($driver)){
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }


        //JIKA ADA, VALIDASI DATA DARI REQUEST USER
        $vld = Validator::make($request->all(), [
            'name' => 'required|string',
            'age' => 'required|integer',
            'id_number' => 'required|string'
        ]);

        //JIKA VALIDASI GAGAL TAMPILKAN PESAN ERROR
        if($vld->fails())
        {
            return response()->json([
                'message' => 'invalid field'
            ], 422);
        }


        //JIKA VALIDASI BERHASIL MAKA UPDATE DATA BERDASARKAN ID 
        $driver->update($request->all());


        //KEMBALIKAN PESAN SUCCESS
        return response()->json([
            'message' => 'update driver succces'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //CARI DRIVER YANG INGIN DIHAPUS BERDASARKAN ID
        $driver = Driver::find($id);

        //JIKA TIDAK ADA KEMBALIKAN PESAN ERROR
        if(is_null($driver)){
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }


        //JIKA ADA HAPUS DATA
        $driver->delete();


        //KEMBALIKAN PESAN ERROR
        return response()->json([
            'message' => 'delete driver success'
        ]);
    }
}
