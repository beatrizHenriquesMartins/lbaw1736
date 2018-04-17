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

class CartController extends Controller
{

    /**
     * Shows all Products in Wishlist.
     *
     * @return Response
     */
    public function list()
    {
      if (!Auth::check()) return redirect('/login');

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


      if (!$this->authorize('list', Cart::class))
        return redirect('/homepage');

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');


      if(count($client->cart) != 0) {
        foreach ($client->cart as $list) {
          $product = (Product::find($list->pivot->id_product));
          $quantity = $list->pivot->quantity;
          $price = ltrim(Product::find($list->pivot->id_product)->price);
          settype($price, "integer");
          $cost = $cost + $price * $quantity;
        }
      }

      return view('pages.cart', ['carts' => $client->cart, 'cost' => $cost, 'type' => $type]);

    }

    public function create(Request $request, $product_id) {

      if (!Auth::check()) return redirect('/login');


      if (!$this->authorize('create', Cart::class))
        return redirect('/homepage');

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');

      $product = DB::table('carts')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->get();

      if($product == null && $product->active == 1) {
        DB::table('carts')->insert(['id_product' => $product_id, 'id_client' => Auth::user()->id, 'quantity' => 1]);
        return redirect('/cart');

      }

      return redirect()->back();


    }

    public function delete(Request $request, $product_id) {

      if (!Auth::check()) return redirect('/login');

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');

      $product = DB::table('carts')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->get();

      if($product != null) {
        DB::table('carts')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->delete();
        return redirect('/cart');
      }
      return redirect()->back();
    }


    public function deleteAll(Request $request) {

      if (!Auth::check()) return redirect('/login');

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');

      $product = DB::table('carts')->where([['id_client', '=', Auth::user()->id]])->get();

      if($product != null) {
        DB::table('carts')->where([['id_client', '=', Auth::user()->id]])->delete();
        return redirect('/cart');
      }
      return redirect()->back();

    }


}
