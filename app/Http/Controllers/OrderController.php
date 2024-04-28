<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //AMBIL DATA DARI SEMUA ORDER
        $order = Order::all();
        //KIRIM DATA ORDER MENGGUNAKAN RESOURCE
        return response()->json([
            'data' => OrderResource::collection($order)
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
        //VALIDASI REQUEST DARI USER 
        $vld = Validator::make($request->all(), [
            'bus_id' => 'required|integer',
            'driver_id' => 'required|integer',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            'start_rent_date' => 'required',
            'total_rent_days' => 'required'
        ]);

        //JIKA VALIDASI GAGAL KEMBALIKAN RESPONSE ERROR
        if($vld->fails())
        {
            return response()->json([
                'message' => 'invalid field'
            ], 422);
        }

        //JIKA VALIDASI BERHASIL BUAT ORDER BARU
        $order = Order::create($request->all());


        //KEMBALIKAN DATA ORDER MENGGUNAKAN RESOURCE
        return response()->json([
            'data' => new OrderResource($order)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //CARI ORDER YANG MAU DI HAPUS BERDASARKAN ID
        $order = Order::find($id);

        //JIKA ORDER TIDAK ADA MAKAN KEMBALIKAN PESAN ERROR 404
        return response()->json([
            'message' => 'data not found'
        ], 404);


        //JIKA ADA MAKA HAPUS ORDER
        $order->delete();


        //KEMBALIKAN PESAN BAHWA ORDER TELAH DIAPUS
        return response()->json([
            'message' => 'order has been deleted'
        ]);
    }
}
