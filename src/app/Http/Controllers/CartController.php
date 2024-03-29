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

      /*if (!$this->authorize('list', Cart::class))
        return redirect('/homepage');*/

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');


      if(count($client->cart) != 0) {
        foreach ($client->cart as $list) {
          $product = (Product::find($list->pivot->id_product));
          $quantity = $list->pivot->quantity;
          $price = ltrim(Product::find($list->pivot->id_product)->price);
          settype($price, "float");
          $cost = $cost + $price * $quantity;
        }
      }
      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.cart', ['carts' => $client->cart, 'cost' => $cost, 'type' => $type, 'messages' => $messages, 'title' => 'Cart']);
      }
      else {
        $messages = null;
        return view('pages.cart', ['carts' => $client->cart, 'cost' => $cost, 'type' => $type, 'messages' => null, 'title' => 'Cart']);
      }


    }

    public function create(Request $request, $product_id) {

      if (!Auth::check()) {
        $product = ['message' => 'Not Authorized to add to cart'];
        return json_encode($product);
      }


      if (!$this->authorize('create', Cart::class)) {
        $product = ['message' => 'Not Authorized to add to cart'];
        return json_encode($product);
      }

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null) {
        $product = ['message' => 'Not Authorized to add to cart'];
        return json_encode($product);
      }

      $product = Product::find($product_id);
      $cart = DB::table('carts')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->get();
      if(count($cart) == 0 && $product->active == 1) {
        DB::table('carts')->insert(['id_product' => $product_id, 'id_client' => Auth::user()->id, 'quantity' => 1]);

      }

      return json_encode($product);


    }

    public function delete(Request $request, $product_id) {

      if (!Auth::check()) return redirect('/login');

      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');

      $product = DB::table('carts')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->first();

      if($product != null) {
        DB::table('carts')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->delete();
      }

      return json_encode($product);
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

      }

      return json_encode($product);
    }


    public function update(Request $request, $product_id, $quantity) {

      if (!Auth::check()) return redirect('/login');

      $product = DB::table('carts')->where([['id_product', '=', $product_id], ['id_client', '=', Auth::user()->id]])->first();

      if(!is_numeric($quantity))
        return json_encode($product);
      $client = Client::find(Auth::user()->id);
      $cost = 0;
      if($client == null || $client->cart == null)
        return redirect('/404');


      if($product != null) {
        DB::table('carts')->where([['id_client', '=', Auth::user()->id], ['id_product', '=', $product_id]])->update(['quantity'=> $quantity]);
      }

      return json_encode($product);
    }

}
