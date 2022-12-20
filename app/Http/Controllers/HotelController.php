<?php

namespace App\Http\Controllers;

use App\Models\Hotel; 
use Illuminate\Http\Request;
use App\Http\Resources\HotelResource; 
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    public function index(){
        //get posts
        $hotel = Hotel::latest()->get();

        //render view with posts
        return new HotelResource(true, 'List Data Hotel', $hotel);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [             
            'namaHotel'    => 'required',             
            'rating'        => 'required',             
            'alamat'        => 'required'         
        ]);

        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 

        $hotel = Hotel::create([             
            'namaHotel'    => $request->namaHotel,             
            'rating'        => $request->rating,             
            'alamat'        => $request->alamat       
        ]);

        return new HotelResource(true, 'Data Hotel Berhasil Ditambahkan!', $hotel);
    }

    public function show($id){
        $hotel = Hotel::find($id);
        return new HotelResource(true, 'Data Tempat Wisata Berhasil Diambil!', $hotel);
    }

    public function update (Request $request, Hotel $hotel)
    {
        $validator = Validator::make($request->all(), [ 
            'namaHotel'    => 'required',             
            'rating'        => 'required',             
            'alamat'        => 'required' 
        ]); 
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 

        //Fungsi Update Data ke dalam Database 
        $hotel = Hotel::findOrFail($hotel->id);

        if($hotel){
            $hotel->namaHotel      = $request->namaHotel;
            $hotel->rating         = $request->rating;
            $hotel->alamat         = $request->alamat;
            $hotel->update();

            return response()->json([
                'success' => true,
                'message' => 'Hotel Updated',
                'data'    => $hotel  
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Hotel Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrfail($id);

        if($hotel){
            $hotel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tempat Wisata Deleted',
                'data'    => $hotel
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tempat Wisata Not Found',
        ], 404);
    }
}
