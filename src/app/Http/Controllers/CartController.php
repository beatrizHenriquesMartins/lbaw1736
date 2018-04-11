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
      if($client->cart == null)
        return view('pages.404');

      else {
        if(count($client->cart) != 0) {
          $products = collect(new Product);
          $quantities = array();
          foreach ($client->cart as $list) {
            $products->push(Product::find($list->pivot->id_product));
            $quantities = $quantities + array('quantity' => $list->pivot->quantity);

          }
          echo $client->cart;

          return view('pages.cart', ['carts' => $client->cart]);
        }
        else {
          $products = null;
          $quantities = null;
          return view('pages.cart', ['carts' => $client->cart]);

        }
      }
    }


}
