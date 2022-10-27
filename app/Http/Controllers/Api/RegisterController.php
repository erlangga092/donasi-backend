<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:donaturs',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $donatur = Donatur::create($validator->validated());

        return response()->json([
            'success' => TRUE,
            'message' => 'Successfully Registration',
            'data' => $donatur,
            'token' => $donatur->createToken('authToken')->accessToken,
        ], 201);
    }
}
