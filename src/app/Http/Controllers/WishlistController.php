<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Wishlist;
use App\Client;

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

      $this->authorize('list', Wishlist::class);

      $wishlist = Client::find(Auth::user()->id)->wishlist()->orderBy('id_client')->get();

      return view('pages.wishlist', ['wishlist' => $wishlist]);
    }

    /**
     * Add a new product to the wishlist.
     *
     * @return Product The product created.
     */
    public function create(Request $request)
    {
      $wishlist = new Wishlist();

      $client = Client::find(Auth::user()->id);

      $client->authorize('create', $wishlist);

      $product->id_product = $request->input('id_product');

      $product = Product::find($id_product);

      $wishlist->id_client = Auth::user()->id;
      $wishlist->$id_product = $id_product;

      $wishlist->save();

    }

    public function delete(Request $request, $id_product)
    {
      $client = Client::find(Auth::user()->id);
      $wishlist = Wishlist::find(Auth::user()->id, $id_product);

      $client->authorize('delete', $wishlist);

      $wishlist->delete();

    }
}
