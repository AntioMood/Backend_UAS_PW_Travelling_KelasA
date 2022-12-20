<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validator\Rule;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function show($id){
        $user = User::find($id);
        if(!is_null($user)){
            return response([
                'message' => 'User ada',
                'data' => $user
            ], 200);
        }
    }

    public function update(Request $request, $id){

        $user = User::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => $user
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',            
                'regex:/[a-z]/',     
                'regex:/[A-Z]/',     
                'regex:/[0-9]/',     
                'regex:/[@$!%*#?&]/' 
            ],
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
            $user->name = $updateData['name'];
            $user->password = $updateData['password'];
        
        if($user->save()){
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
    }
}
