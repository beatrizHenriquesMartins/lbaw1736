<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Cart;
use App\Client;
use App\Product;

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

      if (!$this->authorize('list', Cart::class))
        return redirect('/homepage');

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return view('pages.404');

      else {
        $cost = 0;
        if(count($client->cart) != 0) {
          foreach ($client->cart as $list) {
            $product = (Product::find($list->pivot->id_product));
            $quantity = $list->pivot->quantity;
            $price = ltrim(Product::find($list->pivot->id_product)->price);
            settype($price, "integer");
            $cost = $cost + $price * $quantity;
          }
          return view('pages.cart', ['carts' => $client->cart, 'cost' => $cost]);
        }
        else {

          return view('pages.cart', ['carts' => $client->cart, 'cost' => '0']);

        }
      }
    }

    public function create(Request $request, $product_id) {

      if (!Auth::check()) return redirect('/login');

      if (!$this->authorize('list', Cart::class))
        return redirect('/homepage');

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');

      DB::table('carts')->insert(['id_product' => $product_id, 'id_client' => Auth::user()->id, 'quantity' => 1]);



      return redirect('/cart');


    }


}
