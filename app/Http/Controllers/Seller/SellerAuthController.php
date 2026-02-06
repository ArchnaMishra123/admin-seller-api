<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (! $token = auth('api')->attempt($request->only('email','password'))) {
            return response()->json(['message'=>'Invalid credentials'],401);
        }

        if (auth('api')->user()->role !== 'SELLER') {
            return response()->json(['message'=>'Unauthorized role'],403);
        }

        return response()->json([
            'token' => $token,
            'role'  => 'SELLER'
        ]);
    }
}
