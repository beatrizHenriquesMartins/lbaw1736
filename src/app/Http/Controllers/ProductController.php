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
      $reviews = DB::table('reviews')->where('id_product', $id)->join('purchases','purchases.id','=','id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

      return view('pages.product', ['product' => $product, 'reviews' => $reviews]);
    }



}
