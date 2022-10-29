<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Profile',
            'data' => auth()->guard('api')->user()
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $donatur = Donatur::whereId(auth()->guard('api')->user()->id)->first();

        // update with avatar
        if ($request->file('avatar')) {
            Storage::disk('local')->delete('public/donaturs/' . basename($donatur->image));
            $image = $request->file('avatar');
            $image->storeAs('public/donaturs', $image->hashName());

            $donatur->update([
                'name' => $request->name,
                'avatar' => $image->hashName()
            ]);
        }

        // update without avatar
        $donatur->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Profil Berhasil Diupdate!',
            'data' => $donatur
        ], 201);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $donatur = Donatur::whereId(auth()->guard('api')->user()->id)->first();
        $donatur->update([
            'password' => $request->password
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password Berhasil Diupdate!',
            'data' => $donatur
        ], 201);
    }

    public function updatePasswordWithoutLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:donaturs,email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Donatur::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => true], 200);
    }
}
