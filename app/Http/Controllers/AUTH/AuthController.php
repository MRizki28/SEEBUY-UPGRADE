<?php

namespace App\Http\Controllers\AUTH;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'check your validation',
                'errors' => $validator->errors()
            ]);
        }

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->save();

        // send verification email
        $this->sendVerificationEmail($data);

        $token = $data->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'success create user',
            'data' => $data,
            'access_token' => $token,
            'type_token' => 'Bearer'
        ]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
                'code' => 401
            ]);
        }

        $user = User::where('email', $request['email'])->first();
        if (!$user || !$user->email_verified_at) {
            Auth::logout();
            return response()->json([
                'message' => 'Email not verified',
                'code' => 401
            ]);
        }
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'success create user',
            'data' => $user,
            'access_token' => $token,
            'type_token' => 'Bearer'
        ]);
    }



    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();



        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Email already verified',
                'code' => 400
            ]);
        }

        $user->email_verified_at = now();

        $user->save();

        return redirect('/')->with([
            'success' => 'Email verified successfully',
            'data' => $user,
            'code' => 200
        ]);
    }

    private function sendVerificationEmail(User $user)
    {
        $verificationUrl = url('cms/verify-email/' . $user->email);

        Mail::to($user->email)->send(new VerificationMail($verificationUrl));

        return response()->json([
            'message' => 'Success sending verification email',
            'code' => 200
        ]);
    }
}
