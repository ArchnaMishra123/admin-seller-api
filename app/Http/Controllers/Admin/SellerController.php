<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function createSeller(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => 'required|digits:10',
            'country'  => 'required|string',
            'state'    => 'required|string',
            'skills'   => 'required|array',
            'password' => 'required|min:6'
        ]);

        try {
            User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'mobile'   => $data['mobile'],
                'country'  => $data['country'],
                'state'    => $data['state'],
                'skills'   => $data['skills'],
                'password' => Hash::make($data['password']),
                'role'     => 'SELLER'
            ]);

            return response()->json(['message'=>'Seller created'],201);

        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Failed to create seller',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    public function listSellers()
    {
        return User::where('role','SELLER')->paginate(10);
    }
}