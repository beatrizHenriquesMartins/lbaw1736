<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Cart;
use App\Client;
use App\Product;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Message;

class CartOrderController extends Controller
{
    	public function show(){
            
			if (!Auth::check())
				return redirect('/login');


      $type = 0;
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

			if($type == 1) {

				$addresses = DB::table('clientaddresses')
				->where('id_client', Auth::user()->id)
				->join('addresses', 'addresses.id_address', '=', 'clientaddresses.id_address')
				->join('cities', 'cities.id_city', '=', 'addresses.id_city')
				->join('countries', 'countries.id_country', '=', 'cities.id_country')->get();

        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
				return view('pages.cart_order', ['type' => $type, 'messages' => $messages, 'addresses' => $addresses, 'title' => 'Order']);
      }
      else {
        $messages = null;
				return view('pages.cart_order', ['type' => $type, 'messages' => null, 'addresses' =>null, 'title' => 'Order']);
      }
		//ou...
		//return view('pages.profile', compact('user','type');
	}
}
