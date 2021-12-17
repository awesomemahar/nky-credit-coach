<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        Schema::defaultStringLength(191);
        $theme = 'bg-info';
        if(Schema::hasTable('business_settings')){
            $setting = \App\Models\BusinessSetting::where('type','theme')->first();
            if(!is_null($setting)){
                if($setting->value == 'dark'){
                    $theme = 'bg-blue';
                }
            }
        }
        view()->share('theme', $theme);

    }
}
