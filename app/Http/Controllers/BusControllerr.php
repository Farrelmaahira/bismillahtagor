<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusResource;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusControllerr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //AMBIL SEMUA DATA BUS DARI DB
        $bus = Bus::all();

        //KEMBALIKAN DATA MENGGUNAKAN RESOURCE
        return response()->json([
            'data' => BusResource::collection($bus)
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

        //VALIDASI DATA REQUEST DARI USERRR
        $vld = Validator::make($request->all(),[
            'plate_number' => 'required|string',
            'brand' => 'required',
            'seat' => 'required|integer',
            'price_per_day' => 'required|integer'
        ]);

        //JIKA VALIDASI GAGAL TAMPILKAN PESAN ERROR
        if($vld->fails()) {
            return response()->json([
                'message' => 'invalid field'
            ], 422);
        }

        //JIKA VALIDASI BERHASIL TAMBAHKAN DATA BUS BARU DI DB
        Bus::create($request->all());


        //KEMBALIKAN PESAN SUCCESS
        return response()->json([
            'message' => 'create bus success'
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
        //CARI DATA BUS YANG INGIN DI EDIT 
        $bus = Bus::find($id);


        //JIKA TIDAK ADA KEMBALIKAN PESAN ERROR
        if(is_null($bus)) {
            return response()->json([
                'message' => 'data not found'
            ]);
        }

        //JIKA ADA, VALIDASI DATA YANG DI REQUEST OLEH USER
        $vld = Validator::make($request->all(),[
            'plate_number' => 'required|string',
            'brand' => 'required',
            'seat' => 'required|integer',
            'price_per_day' => 'required|integer'
        ]);


        //JIKA VALIDASI GAGAL KEMBALIKAN PESAN ERROR
        if($vld->fails()) {
            return response()->json([
                'message' => 'invalid field'
            ], 422);
        }

        //JIKA VALIDASI BERHASIL MAKA UPDATE DATA BUS
        $bus->update($request->all());


        //KEMBALIKAN PESAN SUCCESS 
            return response()->json([
                'message' => 'update bus success'
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
        //CARI BUS YANG INGIN DIHAPUS BERDASARKAN ID
        $bus = Bus::find($id);

        //JIKA TIDAK ADA MAKA KEMBALIKAN PESAN ERROR
        if(is_null($bus)) {
            return response()->json([
                'message' => 'data not found'
            ]);
        }

        //JIKA ADA MAKA HAPUS BUS
        $bus->delete();

        //KEMBALIKAN PESAN ERROR
        return response()->json([
            'message' => 'bus has been deleted'
        ]);
    }
}
