<?php

namespace App\Providers;

use App\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('file_exists_check', function($attribute, $value, $parameters, $validation) {
            $file = File::find($value);

            if($file && Storage::disk('local')->exists(optional($file)->path)) {
                return true; 
            }

            return false;
        });
    }
}
