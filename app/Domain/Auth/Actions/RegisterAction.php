<?php
namespace App\Domain\Auth\Actions;

use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterAction
{
    public function excute(RegisterRequest $request)
    {
        $user = null;
        DB::transaction(function() use (&$user, $request) {
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);
        });

        return response()->json([
            'message' => 'success'
        ], Response::HTTP_CREATED);
    }
}