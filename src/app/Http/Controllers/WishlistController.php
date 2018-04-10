<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Wishlist;

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

      $wishlist = Auth::client()->wishlist()->get();

      return view('pages.wishlist', ['wishlist' => $wishlist]);
    }

    /**
     * Add a new product to the wishlist.
     *
     * @return Product The product created.
     */
    public function create(Request $request)
    {
      $product = new Product();

      $this->authorize('create', $product);

      $product->id_product = $request->input('id_product');
      $product->id_client = Auth::user()->id;
      $product->save();

    }

    public function delete(Request $request, $id_product)
    {
      $product->id_client = Auth::user()->id;
      $product = Product::find($id_client, $id_product);

      $this->authorize('delete', $product);
      $product->delete();

    }
}
