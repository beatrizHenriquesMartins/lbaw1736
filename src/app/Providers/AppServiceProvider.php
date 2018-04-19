<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Category;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        View::share('categories', Category::get());

        $type = 0;


        if(Auth::check()) {

          $userBM = BrandManager::find(Auth::user()->id);
          $userSP = SupportChat::find(Auth::user()->id);
          $userADM = Admin::find(Auth::user()->id);
          $userCL = Client::find(Auth::user()->id);


          if($userCL != null)
            $type = 1;

          if($userBM != null)
            $type = 2;

          if($userSP != null)
            $type = 3;

          if($userADM != null)
            $type = 4;
        }

        View::share('type', $type);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
