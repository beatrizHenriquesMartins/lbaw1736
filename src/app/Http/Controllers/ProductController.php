<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Review;

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

      $reviews = $product->reviews;
      print_r($reviews);

      return view('pages.product', ['product' => $product, 'reviews' => $reviews]);
    }



}
