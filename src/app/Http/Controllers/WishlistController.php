<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Wishlist;
use App\Client;
use App\Product;

class WishlistController extends Controller
{

    /**
     * Shows all Products in Wishlist.
     *
     * @return Response
     */
    public function list()
    {
      if (!Auth::check()) return redirect('/login');

      if (!$this->authorize('list', Wishlist::class))
        return redirect('/homepage');

      $client = Client::find(Auth::user()->id);

      if($client == null || $client->wishlist == null)
        return redirect('/404');

      else {
        if(count($client->wishlist) != 0) {
          $products = collect(new Product);
          foreach ($client->wishlist as $list) {
            $products->push(Product::find($list->pivot->id_product));

          }
          return view('pages.wishlist', ['products' => $products]);
        }
        else {
          $products = null;
          return view('pages.wishlist', ['products' => $products]);

        }
      }
    }

    public function create(Request $request, $product_id) {

      if (!Auth::check()) return redirect('/login');

      if (!$this->authorize('list', Wishlist::class))
        return redirect('/homepage');

      $client = Client::find(Auth::user()->id);

      if($client == null || $client->wishlist == null)
        return redirect('/404');

      DB::table('wishlists')->insert(['id_product' => $product_id, 'id_client' => Auth::user()->id]);


      return redirect('/wishlist');
    }

}
