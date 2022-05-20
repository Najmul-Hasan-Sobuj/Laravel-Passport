<?php

namespace App\Http\Controllers\API;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User data",
            "data" => $user_data
        ]);
    }
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:authors',
            'password' => 'required',
            'phone_no' => 'required',
        ]);

        if ($validation->passes()) {
            Author::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone_no' => $request->phone_no,
            ]);
            return response()->json([
                'status' => 1,
                'message' => 'Successfully registered'
            ]);
        } else {
            return response()->json([
                'error' => $validation->messages(),
            ]);
        }
    }
    public function login(Request $request)
    {
        $login_data = $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($login_data)) {
            return response()->json([
                'status' => false,
                'messages' => 'Invalid Credentials'
            ]);
        }

        $token = auth()->user()->createToken("auth_token");

        return response()->json([
            'status' => true,
            'message' => 'auther loged successfully',
            'token' => $token
        ]);
    }
    public function logout(Request $request)
    {
        // get token value
        $token = $request->user()->token();

        // revoke this token value
        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "You have been successfully logged out!"
        ]);
    }
}
