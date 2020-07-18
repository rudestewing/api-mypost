<?php
namespace App\Domain\Auth\Actions;

use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GetAccessTokenRequest;

class GetAccessTokenAction
{
    public function excute(GetAccessTokenRequest $request)
    {
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