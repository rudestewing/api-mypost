<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetAccessTokenRequest;
use App\Domain\Auth\Actions\GetAccessTokenAction;

class GetAccessTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        GetAccessTokenRequest $request, 
        GetAccessTokenAction $action
    )
    {
        return $action->excute($request);
    }
}
