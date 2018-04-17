<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Review;
use App\Purchase;
use App\User;
use App\Client;
use App\BrandManager;
use App\SupportChat;
use App\Admin;

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

      if($product == null || $product->active == 0)
        return redirect('/404');


      $reviews = DB::table('reviews')->where('id_product', $id)->join('purchases','purchases.id','=','id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

      $type = 0;


      if(Auth::check()) {

        $userBM = BrandManager::find(Auth::user()->id);
        $userSP = SupportChat::find(Auth::user()->id);
        $userADM = SupportChat::find(Auth::user()->id);
        $userCL = SupportChat::find(Auth::user()->id);


        if($userCL != null)
          $type = 1;

        if($userBM != null)
          $type = 2;

        if($userSP != null)
          $type = 3;

        if($userADM != null)
          $type = 4;
      }


      $total = 0;
      $number = 0;
      foreach ($reviews as $review) {
        $total  = $total + $review->rating;
        $number++;
      }
      if($total == 0)
        $reviewmed = 0;

      else
        $reviewmed = round($total / $number);

      return view('pages.product', ['product' => $product, 'reviews' => $reviews, 'reviewmed' =>$reviewmed, 'type' =>$type]);
    }

    public function edit($id)
    {
      $product = Product::find($id);

      if($product == null)
        return view('pages.404');

      $type = 0;


      if(Auth::check()) {

        $userBM = BrandManager::find(Auth::user()->id);
        $userSP = SupportChat::find(Auth::user()->id);
        $userADM = SupportChat::find(Auth::user()->id);
        $userCL = SupportChat::find(Auth::user()->id);


        if($userCL != null)
          $type = 1;

        if($userBM != null)
          $type = 2;

        if($userSP != null)
          $type = 3;

        if($userADM != null)
          $type = 4;
      }

      if($userBM == null)
        return redirect('/404');

      $canchange = 0;

      foreach ($userBM->brands as $brand) {
        if($product->id_brand == $brand->id)
          $canchange = 1;
      }

      if($canchange == 0)
        return redirect('/404');

      $reviews = DB::table('reviews')->where('id_product', $id)->join('purchases','purchases.id','=','id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

      $total = 0;
      $number = 0;
      foreach ($reviews as $review) {
        $total  = $total + $review->rating;
        $number++;
      }
      if($total == 0)
        $reviewmed = 0;

      else
        $reviewmed = round($total / $number);

      return view('pages.productedit', ['product' => $product, 'reviews' => $reviews, 'reviewmed' =>$reviewmed, 'type' => $type]);
    }

    public function delete($id)
    {
      if (!Auth::check()) return redirect('/login');

      $userBM = BrandManager::find(Auth::user()->id);
      $userSP = SupportChat::find(Auth::user()->id);
      $userADM = SupportChat::find(Auth::user()->id);
      $userCL = SupportChat::find(Auth::user()->id);

      $type = 0;

      if($userCL != null)
        $type = 1;

      if($userBM != null)
        $type = 2;

      if($userSP != null)
        $type = 3;

      if($userADM != null)
        $type = 4;

      if($userBM == null)
        return redirect('/404');

        $canchange = 0;

      foreach ($userBM->brands as $brand) {
        if($product->id_brand == $brand->id)
          $canchange = 1;
      }

      if($canchange == 0)
        return redirect('/404');

      $product = Product::find($id);

      if($product != null) {
        DB::table('products')->where([['id', '=', $id]])->update(['active' => 0]);
        return redirect('/homepage');
      }
      $previousUrl = app('url')->previous();

      return redirect('/homepage');
    }



}
