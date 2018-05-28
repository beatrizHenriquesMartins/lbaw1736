<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Client;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Message;
use App\ContactUs;

class FooterController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show404(){

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

      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.404', ['type' => $type, 'messages' => $messages, 'title' => '404']);
      }
      else {
        $messages = null;
        return view('pages.404', ['type' => $type, 'messages' => null, 'title' => '404']);
      }
    }

    public function showaboutus(){

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

      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.aboutus', ['type' => $type, 'messages' => $messages, 'title' => 'About Us']);
      }
      else {
        $messages = null;
        return view('pages.aboutus', ['type' => $type, 'messages' => null, 'title' => 'About Us']);
      }
    }

    public function showfaq()
    {

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

      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.faq', ['type' => $type, 'messages' => $messages, 'title' => 'FAQ']);
      }
      else {
        $messages = null;
        return view('pages.faq', ['type' => $type, 'messages' => null, 'title' => 'FAQ']);
      }
    }

    public function showcontactus()
    {

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

      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.contactus', ['type' => $type, 'messages' => $messages, 'title' => 'Contact Us']);
      }
      else {
        $messages = null;
        return view('pages.contactus', ['type' => $type, 'messages' => null, 'title' => 'Contact Us']);
      }
    }

    public function showterms()
    {

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
      if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
        return view('pages.terms', ['type' => $type, 'messages' => $messages, 'title' => 'Terms']);
      }
      else {
        $messages = null;
        return view('pages.terms', ['type' => $type, 'messages' => null, 'title' => 'Terms']);
      }

    }

  public function contactus(Request $request)
  {
    Mail::to("luissaraiva96@gmail.com")->send(new ContactUs($request->input('name'), $request->input('email'), $request->input('phone'), $request->input('message'), $request->input('subject')));

    return redirect('contactus')->withErrors(['message' => 'Mail Sended!']);
  }

}
