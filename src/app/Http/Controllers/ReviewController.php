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

      if($purchaseproducts == null)
        return redirect()->back();


      $rating = $request->input('rating');
      $textreview = $request->input('reviewtext');
      if($rating == null && $textreview == null)
        return redirect()->back();
      else if($rating == null)
        $rating = 0;
      else if($textreview == null)
        $textreview = "";


      if($review != null) {
        $rating =
        $review = DB::table('reviews')->where([['id_product', '=', $product_id], ['id_purchase', '=', $purchase_id]])
        ->update(['rating' => $rating]);
        $review = DB::table('reviews')->where([['id_product', '=', $product_id], ['id_purchase', '=', $purchase_id]])
        ->update(['textreview' => $textreview]);
        $review = DB::table('reviews')->where([['id_product', '=', $product_id], ['id_purchase', '=', $purchase_id]])
        ->update(['reviewdate' => date('Y-m-d H:i:s')]);

        return redirect()->back()->withErrors(['message' => 'Your review was added']);
      }
      else {
        $review = new Review();
        $review->id_purchase = $purchase_id;
        $review->id_product = $product_id;
        $review->rating =  $rating;
        $review->textreview = $textreview;
        $review->reviewdate = date('Y-m-d H:i:s');


        $review->save();
        return redirect()->back()->withErrors(['message' => 'Your review was updated']);
      }

    }

    public function delete(Request $request) {
      $review = DB::table('reviews')->where('id_product', $request->input('id_product'))->where('id_purchase', $request->input('id_purchase'))->first();

      if($review) {
        DB::table('reviews')->where('id_product', $request->input('id_product'))->where('id_purchase', $request->input('id_purchase'))->delete();
      }

      return json_encode($review);
    }
}
