<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Purchase;
use App\Client;
use App\Product;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Review;

class ReviewController extends Controller
{


    public function create(Request $request, $product_id, $purchase_id) {
      if (!Auth::check()) return redirect('/login');


      $client = Client::find(Auth::user()->id);
      if($client == null)
        return redirect('/404');

      $purchase = Purchase::find($purchase_id);
      $product = Product::find($product_id);

      if($purchase == null || $purchase->id_client != Auth::user()->id || $product == null)
        return redirect('/404');

      $purchaseproducts = DB::table('purchaseproducts')->where([['id_product', '=', $product_id], ['id_purchase', '=', $purchase_id]])->first();
      $review = DB::table('reviews')->where([['id_product', '=', $product_id], ['id_purchase', '=', $purchase_id]])->first();

      if($purchaseproducts == null || $review != null)
        return redirect()->back();

      $review = new Review();
      $review->id_purchase = $purchase_id;
      $review->id_product = $product_id;
      $review->rating =  $request->input('rating');
      $review->textreview = $request->input('reviewtext');
      $review->reviewdate = date('Y-m-d H:i:s');
      $review->save();
      return redirect()->back();


    }

}