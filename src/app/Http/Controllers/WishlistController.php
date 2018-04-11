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

      if($client->wishlist == null)
        return view('pages.404');

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

    /**
     * Add a new product to the wishlist.
     *
     * @return Product The product created.
     */
    public function create(Request $request, $id_product)
    {

      $product = Product::find($id_product);


      if (!$this->authorize('create', Wishlist::class))
        return redirect('/homepage');

      $client = Client::find(Auth::user()->id);



      if($client == null || $product == null)
        return view('pages.404');

      $client->wishlist()->create([
        'id_client' => Auth::user()->id(),
        'id_product' => $id_product,
      ]);

    }

    public function delete(Request $request, $id_product)
    {
      echo 'HERE';

/*      $product = Product::find((int)$id_product);
      $client = Client::find(Auth::user()->id);
      echo $product;
      if (!$this->authorize('delete', [$client, $product]))
        return '/homepage';


      if($client == null || $product == null)
        return view('pages.404');

      $client->wishlist()->where($id_product, $id_product)->delete();

      return $product;
  */  }
}
