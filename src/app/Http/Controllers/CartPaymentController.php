<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

use App\Cart;
use App\User;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Client;
use App\Message;
use App\Product;

class CartPaymentController extends Controller
{
    public function show(Request $request ){

        //return redirect('/404');
        if (!Auth::check())
            return redirect('/login');

$address_id = $request->input('selectedAddr');
$nif = $request->input('nif');
  $type = 0;
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

            $addresses = DB::table('clientaddresses')
            ->where('id_client', Auth::user()->id)
            ->join('addresses', 'addresses.id_address', '=', 'clientaddresses.id_address')
            ->join('cities', 'cities.id_city', '=', 'addresses.id_city')
            ->join('countries', 'countries.id_country', '=', 'cities.id_country')->get();

    $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();

    if(count($client->cart) != 0)
        return view('pages.cart_payment', ['carts' => $client->cart, 'cost' => $cost, 'type' => $type, 'messages' => $messages, 'address' => $addresses[$address_id], 'nif' => $nif,'title' => 'Payment']);
    else
        return view('pages.cart', ['carts' => $client->cart, 'cost' => $cost, 'type' => $type, 'messages' => $messages, 'title' => 'Cart']);
  }
  else {
    $messages = null;
    return view('pages.cart', ['carts' => $client->cart, 'cost' => $cost, 'type' => $type, 'messages' => null, 'title' => 'Cart']);

  }
    //ou...
    //return view('pages.profile', compact('user','type');
}

public function processPayment(Request $request, $address_id, $nif){


    $clientID = Auth::user()->id;


    $ret = 0;
    $client = Client::find(Auth::user()->id);
    $cost = 0;
    if(count($client->cart) != 0) {
        foreach ($client->cart as $list) {
          $product = (Product::find($list->pivot->id_product));
          $quantity = $list->pivot->quantity;
          $price = ltrim(Product::find($list->pivot->id_product)->price);
          settype($price, "float");
          $cost = $cost + $price * $quantity;
          $quantityInStock = ltrim(Product::find($list->pivot->id_product)->quantityinstock);
          if($quantityInStock < $quantity){
              $ret = 1;
              return json_encode($ret);
          }
        }
       $purchaseState = false;
       if($nif == "Undefined")
        $nif = 0;
         DB::beginTransaction();
         $purchaseID = DB::table('purchases')->insertGetId(['id_client'=> $clientID,'id_address' => $address_id, 'purchase_state'=>false, 'cost'=> $cost, 'nif'=>$nif], 'id_purchase');
          foreach($client->cart as $list){
            $product = (Product::find($list->pivot->id_product));
            $quantity = $list->pivot->quantity;
            $price = ltrim(Product::find($list->pivot->id_product)->price);
            settype($price, "float");
            $cost = $price * $quantity;
            DB::table('purchaseproducts')->insert(['id_purchase'=>$purchaseID, 'id_product'=>$list->pivot->id_product, 'quantity'=> $quantity, 'cost' => $cost]);
            $quantityInStock = $product->quantityinstock;
            $newQuantity = $quantityInStock - $quantity;
            Product::where('id', $list->pivot->id_product)->update(['quantityinstock' => $newQuantity]);
          }
         DB::commit();
    }



    return json_encode($ret);
}
}
