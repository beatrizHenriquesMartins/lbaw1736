<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Client;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Product;
use App\Brand;

class HomepageController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {

      $products = Product::where([['active', '=', 1], ['tocarousel', '=', '1']])->get()->random(3);
      $brands = Brand::all()->random(9);

      return view('pages.homepage', ['products' => $products, 'brands' => $brands]);
    }
}
