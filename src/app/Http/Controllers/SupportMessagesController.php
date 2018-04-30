<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Purchase;
use App\Client;
use App\Product;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Review;

class SupportMessagesController extends Controller{
    public function showMessage(){
        if (!Auth::check()) {
            return redirect('/login');
        }

        $type = 0;

        if(Auth::check()) {
            $userBM = BrandManager::find(Auth::user()->id);
            $userSP = SupportChat::find(Auth::user()->id);
            $userADM = Admin::find(Auth::user()->id);
            $userCL = Client::find(Auth::user()->id);

            if($userCL != null){
                $type = 1;
            }

            if($userBM != null){
                $type = 2;
            }

            if($userSP != null){
                $type = 3;
            }

            if($userADM != null){
                $type = 4;
            }
        }

        if($type != 3){
            return redirect('/404');
        }

        return view('pages.chatSupport', ['type' => $type]);
    }
}