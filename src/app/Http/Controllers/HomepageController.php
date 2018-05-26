<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Client;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Product;
use App\Brand;
use App\Message;

class HomepageController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {

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

      $products = Product::where([['active', '=', 1], ['tocarousel', '=', '1']])->get()->random(3);
      $brands = Brand::all()->random(9);

      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.homepage', ['products' => $products, 'brands' => $brands, 'type' => $type, 'messages' => $messages, 'title' => 'Homepage']);
      }
      else {
        $messages = null;
        return view('pages.homepage', ['products' => $products, 'brands' => $brands, 'type' => $type, 'messages' => $messages, 'title' => 'Homepage']);
      }
    }
}
