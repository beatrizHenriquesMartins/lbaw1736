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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

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

      $reviews = DB::table('reviews')->where('id_product', $id)->join('purchases','purchases.id_purchase','=','reviews.id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

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

      return view('pages.product', ['product' => $product, 'reviews' => $reviews, 'reviewmed' =>$reviewmed, 'type' => $type]);
    }

    public function showCategory($categoryname)
    {

      $category = Category::where('categoryname', '=', $categoryname)->first();

      if($category == null)
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

      $products = Product::where('active', '=', 1)->join('categories', 'categories.id_category', '=', 'products.id_category')->where('categories.categoryname', '=', $categoryname)->paginate(12);
      $reviewsmed = [];
      foreach ($products as $product) {
        $reviews = DB::table('reviews')->where('id_product', $product->id)->join('purchases','purchases.id_purchase','=','reviews.id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

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
      return view('pages.category', ['categoryname' => $categoryname, 'products' => $products, 'reviewsmed' => $reviewsmed, 'type' => $type]);
    }


    public function showedit($id)
    {
      $product = Product::find($id);
      if($product == null)
        return view('pages.404');


      if(!Auth::check()) {
        return view('login');
      }

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

      $userBM = BrandManager::find(Auth::user()->id);

      if($userBM == null)
        return redirect('/404');

      $canchange = 0;

      foreach ($userBM->brands as $brand) {
        if($product->id_brand == $brand->id_brand)
          $canchange = 1;
      }
      if($canchange == 0)
        return redirect('/404');

      $reviews = DB::table('reviews')->where('id_product', $id)->join('purchases','purchases.id_purchase','=','reviews.id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

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

      $brands = Brand::all();
      return view('pages.editproduct', ['product' => $product, 'type' => $type, 'brands' => $brands]);
    }

    public function delete($id)
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

      $products = Product::where('active', '=', 1)->join('brands', 'brands.id_brand', '=', 'products.id_brand')->where('brands.brandname', '=', $brandname)->paginate(12);

      if($products == null)
        return view('pages.brand', ['brandname' => $brandname, 'products' => null, 'reviewsmed' => null]);

      $reviewsmed = [];
      foreach ($products as $product) {
        $reviews = DB::table('reviews')->where('id_product', $product->id)->join('purchases','purchases.id_purchase','=','reviews.id_purchase')->join('users', 'users.id', '=', 'id_client')->get();

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
      return view('pages.brand', ['brandname' => $brandname, 'products' => $products, 'reviewsmed' => $reviewsmed, 'type' => $type]);
    }

    public function edit(Request $request, $id) {
      $product = Product::find($id);

      $rules = array(
          'name'       => 'required',
          'brandname'      => 'required',
          'categoryname' => 'required',
          'price' => 'required|numeric',
          'shortdescription' => 'required',
          'bigdescription' => 'required',
          'imageurl' => 'mimes:jpeg,png,jpg,gif,svg',
      );

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return redirect()->route('editProduct', ['id' => $id])->withErrors($validator);
      } else {

        $product->name = $request->input('name');
        $product->id_brand = $request->input('brandname');
        $product->id_category = $request->input('categoryname');
        $product->shortdescription = $request->input('shortdescription');
        $product->bigdescription = $request->input('bigdescription');
        if($request->input('tocarousel') == 0)
          $product->tocarousel = 1;

        $product->price = $request->input('price');
        $destinationPath = public_path('/images');
        $brand = Brand::find($request->Input('brandname'));
        $brandname = $brand->brandname;
        $brandname = str_replace(' ', '_', $brandname);
        $brandname = strtolower($brandname);
        if ($request->hasFile('imageurl')) {
          $imageName = $request->imageurl->getClientOriginalName();
          $request->imageurl->move(public_path('images/brands'.'/'.$brandname), $imageName);
          $product->imageurl = "/images/brands".'/'.$brandname.'/'.$imageName;
        }
        $product->save();
        return redirect()->route('product', ['id' => $id]);
      }
    }

    public function create(Request $request) {

      $rules = array(
          'name'       => 'required',
          'brandname'      => 'required',
          'categoryname' => 'required',
          'price' => 'required|numeric',
          'shortdescription' => 'required',
          'bigdescription' => 'required',
          'imageurl' => 'required',
      );

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return redirect()->route('newProduct')->withErrors($validator);
      } else {
        $product = new Product();

        $product->name = $request->input('name');
        $product->id_brand = $request->input('brandname');
        $product->id_category = $request->input('categoryname');
        $product->shortdescription = $request->input('shortdescription');
        $product->bigdescription = $request->input('bigdescription');
        $product->price = $request->input('price');
        $product->active = 1;
        if($request->input('tocarousel') == 0)
          $product->tocarousel = 1;
        else {
          $product->tocarousel = 0;
        }
        $destinationPath = public_path('/images');
        $brand = Brand::find($request->Input('brandname'));
        $brandname = $brand->brandname;
        $brandname = str_replace(' ', '_', $brandname);
        $brandname = strtolower($brandname);
        $imageName = $request->imageurl->getClientOriginalName();
        $request->imageurl->move(public_path('images/brands'.'/'.$brandname), $imageName);
        $product->imageurl = "/images/brands".'/'.$brandname.'/'.$imageName;
        $product->save();
        return redirect()->route('product', ['id' => $product->id]);
      }
    }

    public function showadd()
    {


      if(!Auth::check()) {
        return view('login');
      }

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

      $userBM = BrandManager::find(Auth::user()->id);

      if($userBM == null)
        return redirect('/404');



      $brands = Brand::all();
      return view('pages.addproduct', ['type' => $type, 'brands' => $brands]);
    }
}
