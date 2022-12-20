<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Resources\TiketResource; 
use Illuminate\Support\Facades\Validator;

class TiketController extends Controller
{
    public function index(){
        $trip = Trip::latest()->get();
        $tiket = Tiket::with('trip')->latest()->get();         
        //render view with posts
        return new TiketResource(true, 'List Data Tiket', $tiket);
    }

    public function store(Request $request) 
    { 
        //Validasi Formulir 
        $validator = Validator::make($request->all(), [ 
            'namaPembeli'       => 'required', 
            'id_trip'           => 'required', 
            'tlp'               => 'required',
            'tipeKelas'         => 'required',
            'tglBeli'           => 'required', 
            'email'             => 'required', 
            'harga'             => 'required', 
        ]); 

        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 
        
        //Fungsi Simpan Data ke dalam Database 
        $tiket = Tiket::create([ 
            'namaPembeli'       => $request->namaPembeli, 
            'id_trip'           => $request->id_trip,
            'tlp'               => $request->tlp,
            'tipeKelas'         => $request->tipeKelas,
            'tglBeli'           => $request->tglBeli,
            'email'             => $request->email,
            'harga'             => $request->harga,

        ]);
        return new TiketResource(true, 'List Data Tiket', $tiket);
    }

    public function show($id)
    {
        $trip = Trip::all();
        $tiket = Tiket::with('trip')->find($id);
        return new TiketResource(true, 'Data Tiket Berhasil Diambil!', $tiket);
    }

    public function update (Request $request, Tiket $tiket)
    {
        $validator = Validator::make($request->all(), [ 
            'namaPembeli'       => 'required', 
            'id_trip'           => 'required',
            'tlp'               => 'required',
            'tipeKelas'         => 'required',
            'tglBeli'           => 'required', 
            'email'             => 'required', 
            'harga'             => 'required', 
        ]); 
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 

        //Fungsi Update Data ke dalam Database 
        $tiket = Tiket::findOrFail($tiket->id);

        if($tiket){
            $tiket->namaPembeli     = $request->namaPembeli;
            $tiket->id_trip         = $request->id_trip;
            $tiket->tlp             = $request->tlp;
            $tiket->tipeKelas       = $request->tipeKelas;
            $tiket->tglBeli         = $request->tglBeli;
            $tiket->email           = $request->email;
            $tiket->harga           = $request->harga;
            $tiket->update();

            return response()->json([
                'success' => true,
                'message' => 'Tiket Updated',
                'data'    => $tiket  
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tiket Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        $tiket = Tiket::findOrfail($id);
        if($tiket){
            $tiket->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tiket Deleted',
                'data'    => $tiket  
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Tiket Not Found',
        ], 404);
    }
}