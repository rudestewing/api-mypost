<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('Api\Storage')
        ->prefix('Storage')
        ->group(function() {
            Route::get('Retrieve/{id?}', 'RetrieveController')->name('Api.Storage.Retrieve');
            Route::get('{path?}', 'GetByPathController')->name('Api.Storage.Get');
        });

Route::namespace('Api')
    ->as('Api.')
    ->group(function() {
        Route::namespace('Auth')
            ->prefix('Auth')
            ->group(function() {
                Route::post('CreateUser', 'CreateUserController');        
                Route::post('GetAccessToken', 'GetAccessTokenController');        
            });

        Route::namespace('Post')
            ->prefix('Post')
            ->group(function() {
                Route::get('FetchPost', 'FetchPostController');
            });

        Route::middleware('auth:sanctum')
            ->group(function() {
                Route::namespace('User')
                    ->prefix('User')
                    ->group(function() {
                        Route::get('GetProfile', 'GetProfileController');
                        Route::patch('UpdateProfile', 'UpdateProfileController');
                    });

                Route::namespace('Storage')
                    ->prefix('Storage')
                    ->group(function() {
                        Route::post('Upload', 'UploadController');
                    });
        
                Route::namespace('Post')
                    ->prefix('Post')
                    ->group(function() {
                        Route::post('CreatePost', 'CreatePostController');
                        Route::patch('UpdatePost', 'UpdatePostController');
                    });
            });

        
    });
