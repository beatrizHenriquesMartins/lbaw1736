<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FooterController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show404()
    {

      return view('pages.404');
    }

    public function showaboutus()
    {

      return view('pages.aboutus');
    }

    public function showfaq()
    {

      return view('pages.faq');
    }

    public function showcontactus()
    {

      return view('pages.contactus');
    }

    public function showterms()
    {

      return view('pages.terms');
    }

}
