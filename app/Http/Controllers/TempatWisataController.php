<?php

namespace App\Http\Controllers;

use App\Models\TempatWisata; 
use Illuminate\Http\Request;
use App\Http\Resources\TempatWisataResource; 
use Illuminate\Support\Facades\Validator;

class TempatWisataController extends Controller
{
    public function index(){
        //get posts
        $tw = TempatWisata::latest()->get();

        //render view with posts
        return new TempatWisataResource(true, 'List Data Tempat Wisata', $tw);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [             
            'namaTempat'    => 'required',             
            'alamat'        => 'required',             
            'rating'        => 'required',
            'review'        => 'required'         
        ]);

        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 

        $tw = TempatWisata::create([             
            'namaTempat'    => $request->namaTempat,             
            'alamat'        => $request->alamat,             
            'rating'        => $request->rating,
            'review'        => $request->review         
        ]);

        return new TempatWisataResource(true, 'Data Tempat Wisata Berhasil Ditambahkan!', $tw);
    }

    public function show($id){
        $tw = TempatWisata::find($id);
        return new TempatWisataResource(true, 'Data Tempat Wisata Berhasil Diambil!', $tw);
    }

    public function update (Request $request, TempatWisata $tw, $id)
    {
        $validator = Validator::make($request->all(), [ 
            'namaTempat'    => 'required', 
            'alamat'        => 'required', 
            'rating'        => 'required',
            'review'        => 'required', 
        ]); 
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 

        //Fungsi Update Data ke dalam Database 
        $tw = TempatWisata::findOrfail($id);

        if($tw){
            $tw->namaTempat     = $request->namaTempat;
            $tw->alamat         = $request->alamat;
            $tw->rating         = $request->rating;
            $tw->review         = $request->review;
            $tw->update();

            return response()->json([
                'success' => true,
                'message' => 'Tempat Wisata Updated',
                'data'    => $tw  
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tempat Wisata Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        $tw = TempatWisata::findOrfail($id);

        if($tw){
            $tw->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tempat Wisata Deleted',
                'data'    => $tw
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tempat Wisata Not Found',
        ], 404);
    }
}
