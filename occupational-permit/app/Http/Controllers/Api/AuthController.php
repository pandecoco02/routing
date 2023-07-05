<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
          
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user = User::find($user->id);
            return response([
                'user' => new ResourcesUser($user),
                'access_token' => Auth::user()->createToken('authToken')->accessToken
            ], Response::HTTP_OK);
        }else{
            return response([
                'message' => 'This user does not exist'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(){
        Auth::guard('web')->logout();

        return response([
            'message' => 'This user successfully logout'
        ], Response::HTTP_OK);
    }

    public function storePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $user->password = Hash::make($request->password);
            $user->is_new = false;
            $user->update();

            return response([
                'message' => 'User password successfully updated.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
