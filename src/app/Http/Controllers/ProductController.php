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
use App\Category;
use App\Brand;

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

      return view('pages.product', ['product' => $product, 'reviews' => $reviews, 'reviewmed' =>$reviewmed]);
    }

    public function showCategory($categoryname)
    {

      $category = Category::where('categoryname', '=', $categoryname)->first();

      if($category == null)
        return redirect('/404');




      $products = Product::where('active', '=', 1)->join('categories', 'categories.id_category', '=', 'products.id_category')->where('categories.categoryname', '=', $categoryname)->paginate(12);
      $reviewsmed = [];
      foreach ($products as $product) {
        $reviews = DB::table('reviews')->where('id_product', $product->id)->join('purchases','purchases.id','=','id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

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
          array_push($reviewsmed, $reviewmed);
      }
      return view('pages.category', ['categoryname' => $categoryname, 'products' => $products, 'reviewsmed' => $reviewsmed]);
    }


    public function showedit($id)
    {
      $product = Product::find($id);

      if($product == null)
        return view('pages.404');


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

      $userBM = BrandManager::find(Auth::user()->id);

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

      return view('pages.productedit', ['product' => $product, 'reviews' => $reviews, 'reviewmed' =>$reviewmed]);
    }

    public function delete($id)
    {
      if (!Auth::check()) return redirect('/login');

      $userBM = BrandManager::find(Auth::user()->id);

      if($userBM == null)
        return redirect('/404');

      $canchange = 0;
      $product = Product::find($id);
      $brandname = $product->brand->brandName;
      foreach ($userBM->brands as $brand) {
        if($product->id_brand == $brand->id)
          $canchange = 1;
      }

      if($canchange == 0)
        return redirect('/404');

      if($product != null) {
        DB::table('products')->where([['id', '=', $id]])->update(['active' => 0]);
        return redirect('/brand', ['brandName' => $brandname]);
      }

      return redirect('/homepage');
    }

    public function showBrand($brandname)
    {

      $brand = Brand::where('brandname', '=', $brandname)->first();

      if($brand == null)
        return redirect('/404');


      $products = Product::where('active', '=', 1)->join('brands', 'brands.id_brand', '=', 'products.id_brand')->where('brands.brandname', '=', $brandname)->paginate(12);

      if($products == null)
        return view('pages.brand', ['brandname' => $brandname, 'products' => null, 'reviewsmed' => null]);

      $reviewsmed = [];
      foreach ($products as $product) {
        $reviews = DB::table('reviews')->where('id_product', $product->id)->join('purchases','purchases.id','=','id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

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
          array_push($reviewsmed, $reviewmed);
      }
      return view('pages.brand', ['brandname' => $brandname, 'products' => $products, 'reviewsmed' => $reviewsmed]);
    }

}
