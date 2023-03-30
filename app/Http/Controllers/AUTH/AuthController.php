<?php

namespace App\Http\Controllers\AUTH;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
   public function register(Request $request)
   {
    $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'konfirmasi_password' => 'required|same:password',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'check your validation',
            'errors' => $validator->errors()
        ]);
    }

    try {
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->save();
    } catch (\Throwable $th) {
        return response()->json([
            'message' => 'failed create user',
            'message' => $th->getMessage()
        ]);
    }

    $token = $data->createToken('auth_token')->plainTextToken;
    return response()->json([
        'message' => 'success create user',
        'data' => $data,
        'access_token' => $token,
        'type_token' => 'Bearer'
    ]);
   }
}
