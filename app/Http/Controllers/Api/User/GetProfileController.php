<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Resource\Item;

class GetProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $resource = new Item($request->user(), new UserTransformer());

        return response()->json(
            fractal($request->user(), new UserTransformer()),
            200
        );
    }
}
