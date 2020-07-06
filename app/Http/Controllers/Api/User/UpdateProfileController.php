<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
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
            'email' => 'required|email|unique:users,email,'.$request->user()->id,
            'name' => 'required|string',
            'password' => 'nullable|string|min:6|max:18|confirmed',
            'old_password' => 'required_with:password|string',
            'avatar_file_id' => 'nullable|string|file_exists_check',
            'id_card_file_id' => 'nullable|string|file_exists_check',
        ]);

        $user = $request->user();

        DB::transaction(function() use ($request, &$user) {
            $user->update([
                'email' => $request->email,
                'name' => $request->name,
                'avatar_file_id' => $request->avatar_file_id,
                'id_card_file_id' => $request->id_card_file_id,
            ]);

            if($request->password) {
                if(!Hash::check($request->old_password, $user->password)) {
                    return response()->json([
                        'errors' => [
                            'old_password' => 'old password didn`t match'
                        ]
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
        }); 

        return response()->json([
            'data' => $user,
        ]);
    }
}
