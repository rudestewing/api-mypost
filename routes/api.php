<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Post\FetchPostController;
use App\Http\Controllers\Api\Storage\UploadController;
use App\Http\Controllers\Api\Post\CreatePostController;
use App\Http\Controllers\Api\Post\UpdatePostController;
use App\Http\Controllers\Api\User\GetProfileController;
use App\Http\Controllers\Api\Storage\RetrieveController;
use App\Http\Controllers\Api\Storage\GetByPathController;
use App\Http\Controllers\Api\User\UpdateProfileController;
use App\Http\Controllers\Api\Auth\GetAccessTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:scantum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('index', function() {
    return 'api index';
});

Route::as('Api.')
    ->group(function() {
        // Storage
        Route::prefix('Storage')
            ->group(function() {
                // Route::get('Retrieve/{id?}', RetrieveController::class)->name('Storage.Retrieve');
                Route::get('{path?}', RetrieveController::class)->name('Storage.Get');
            });

        // Auth
        Route::prefix('Auth')
            ->group(function() {
                Route::post('Register', RegisterController::class);        
                Route::post('GetAccessToken', GetAccessTokenController::class);        
            });

        Route::prefix('Post')
            ->group(function() {
                Route::get('FetchPost', FetchPostController::class);
            });

        Route::middleware('auth:sanctum')
            ->group(function() {
                Route::prefix('User')
                    ->group(function() {
                        Route::get('GetProfile', GetProfileController::class);
                        Route::patch('UpdateProfile', UpdateProfileController::class);
                    });

                Route::prefix('Storage')
                    ->group(function() {
                        Route::post('Upload', UploadController::class);
                    });
        
                Route::prefix('Post')
                    ->group(function() {
                        Route::post('CreatePost', CreatePostController::class);
                        Route::patch('UpdatePost', UpdatePostController::class);
                    });
            });
    });
