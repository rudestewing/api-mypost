<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateProfileRequest $request)
    {
        $user = $request->user();

        DB::transaction(function() use ($request, &$user) {
            $user->update([
                'email' => $request->email,
                'name' => $request->name,
                'avatar_file' => $request->avatar_file,
                'id_card_file' => $request->id_card_file,
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
            'message' => 'success',
        ], 200);
    }
}
