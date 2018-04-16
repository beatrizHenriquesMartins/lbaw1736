<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Review;
use App\Purchase;
use App\User;

class ProductController extends Controller
{
    /**
     * Shows the product for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $product = Product::find($id);

      if($product == null)
        return view('pages.404');


      $reviews = DB::table('reviews')->where('id_product', $id)->join('purchases','purchases.id','=','id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

      $total = 0;
      $number = 0;
      foreach ($reviews as $review) {
        $total  = $total + $review->rating;
        $number++;
      }
      $reviewmed = round($total / $number);
      return view('pages.product', ['product' => $product, 'reviews' => $reviews, 'reviewmed' =>$reviewmed]);
    }



}
