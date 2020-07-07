<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class GetAccessTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if(!$user) {
            return response()->json([
                'errors' => [
                    'email' => ['not found']
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    'email' => ['credentials didn`t match']
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'data' => [
                'access_token' => $user->createToken('access-token')->plainTextToken 
            ]
        ], Response::HTTP_OK);
    }
}
