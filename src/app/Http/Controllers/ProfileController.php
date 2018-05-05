<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Client;
use App\Message;

class ProfileController extends Controller
{
	public function show(){

			if (!Auth::check())
				return redirect('/login');


      $type = 0;
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

			if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
				return view('pages.profile', ['type' => $type, 'messages' => $messages]);
      }
      else {
        $messages = null;
				return view('pages.profile', ['type' => $type, 'messages' => null]);
      }
		//ou...
		//return view('pages.profile', compact('user','type');
	}


  public function showedit()
    {

    	if(!Auth::check())
    		return view('/login');
      $user = Auth::user();

        $type = 0;
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

			if($type == 1) {
        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
				return view('pages.editprofile', ['type' => $type, 'messages' => $messages]);
      }
      else {
        $messages = null;
				return view('pages.editprofile', ['type' => $type, 'messages' => null]);
      }
    }

    public function edit(Request $request)
    {

			      $rules = array(
			          'firstname'       => 'required|string',
			          'lastname'      => 'required|string',
			          'password' => 'required|string|min:6|confirmed',
			          'imageurl' => 'mimes:jpeg,png,jpg,gif,svg',
			      );

			      $validator = Validator::make(Input::all(), $rules);

			      if ($validator->fails()) {
			        return redirect()->route('editProfile')->withErrors($validator);
			      } else {

			        Auth::user()->firstname = $request->input('firstname');
							Auth::user()->lastname = $request->input('lastname');
			        if($request->input('birthday'))
								Auth::user()->birthday = $request->input('birthday');


							Auth::user()->password = bcrypt($request->input('birthday'));


			        $destinationPath = public_path('/images');

			        if ($request->hasFile('imageurl')) {
			          $imageName = $request->imageurl->getClientOriginalName();
			          $request->imageurl->move(public_path('images/users'.'/'.Auth::user()->username), $imageName);
			          Auth::user()->imageurl = "/images/users".'/'.Auth::user()->username.'/'.$imageName;
			        }
			        Auth::user()->save();
			        return redirect()->route('profile');
			      }

  	}


}
