<?php

namespace App\Http\Controllers;

use App\Models\Trip; 
use Illuminate\Http\Request;
use App\Http\Resources\TripResource; 
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function index(){
        //get posts
        $trip = Trip::latest()->get();

        //render view with posts
        return new TripResource(true, 'List Data Trip', $trip);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [             
            'namaBiro'          => 'required',             
            'tipePerjalanan'    => 'required',             
            'jenisTransportasi' => 'required',        
        ]);

        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 

        $trip = Trip::create([             
            'namaBiro'          => $request->namaBiro,             
            'tipePerjalanan'    => $request->tipePerjalanan,             
            'jenisTransportasi' => $request->jenisTransportasi,         
        ]);

        return new TripResource(true, 'Data Trip Berhasil Ditambahkan!', $trip);
    }

    public function show($id){
        $trip = Trip::find($id);
        return new TripResource(true, 'List Data Trip', $trip);
    }

    public function update (Request $request, Trip $trip)
    {
        $validator = Validator::make($request->all(), [ 
            'namaBiro'          => 'required', 
            'tipePerjalanan'    => 'required', 
            'jenisTransportasi' => 'required',
        ]); 
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 

        //Fungsi Update Data ke dalam Database 
        $trip = Trip::findOrfail($trip->id);

        if($trip){
            $trip->namaBiro             = $request->namaBiro;
            $trip->tipePerjalanan       = $request->tipePerjalanan;
            $trip->jenisTransportasi    = $request->jenisTransportasi;
            $trip->update();

            return response()->json([
                'success' => true,
                'message' => 'Trip Updated',
                'data'    => $trip  
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Trip Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        $trip = Trip::findOrfail($id);

        if($trip){
            $trip->delete();

            return response()->json([
                'success' => true,
                'message' => 'Trip Deleted',
                'data'    => $trip
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Trip Not Found',
        ], 404);
    }
}
