<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Wishlist;
use App\Client;
use App\Product;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Message;

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


      if(count($client->wishlist) != 0) {
        $products = collect(new Product);
        foreach ($client->wishlist as $list) {
          $products->push(Product::find($list->pivot->id_product));

        }
      }
      else {
        $products = null;

      }
      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.wishlist', ['products' => $products, 'type' => $type, 'messages' => $messages, 'title' => 'Wishlist']);
      }
      else {
        return view('pages.wishlist', ['products' => $products, 'type' => $type, 'messages' => null, 'title' => 'Wishlist']);
      }

    }

    public function create(Request $request, $product_id) {

      if (!Auth::check()) return redirect('/login');

      if (!$this->authorize('list', Wishlist::class)) {
        $product = ['message' => 'Not Authorized to add to wishlist'];
        return json_encode($product);
      }

      $client = Client::find(Auth::user()->id);

      if($client == null || $client->wishlist == null) {
        $product = ['message' => 'Not Authorized to add to wishlist'];
        return json_encode($product);
      }

      $product = Product::find($product_id);
      $wishlist = DB::table('wishlists')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->first();

      if($wishlist == null && $product->active == 1) {
        DB::table('wishlists')->insert(['id_product' => $product_id, 'id_client' => Auth::user()->id]);

      }

      return json_encode($product);
    }


    public function delete(Request $request, $product_id) {

      if (!Auth::check()) return redirect('/login');

      $product = Product::find($product_id);

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');


      $product = DB::table('wishlists')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->first();

      if($product != null) {
        DB::table('wishlists')->where([['id_product', '=', $product_id,], ['id_client', '=', Auth::user()->id]])->delete();
      }

      return json_encode($product);


    }

}
