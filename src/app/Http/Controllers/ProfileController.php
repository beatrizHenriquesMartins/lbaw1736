<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

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

		return view('pages.profile', ['type' => $type]);
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

        return view('pages.editprofile', ['type' => $type]);
    }

    public function edit(Request $request)
    {
    	 $user = Auth::user();

    	  $rules = array(
          'firstname' => 'required',
           'lastname' => 'required',
          'imageurl' => 'mimes:jpeg,png,jpg,gif,svg',
      );

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return redirect()->route('editProfile')->withErrors($validator);
      } else {
      }
				if($request->input('password')) {
					$rules2 = array(
						'password' => 'required|min:6|confirmed'
					);

					$validator2 = Validator::make(Input::all(), $rules2);

					if ($validator2->fails()) {
						return redirect()->route('editProfile')->withErrors($validator2);
					}
				}
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->password = bcrypt($request->input('password'));
				$user->datemodified = date('Y-m-d H:i:s');

        $destinationPath = public_path('/images');
        if ($request->hasFile('imageurl')) {
          $imageName = $request->imageurl->getClientOriginalName();
          $request->imageurl->move(public_path('images/users'.'/'.$user), $imageName);
          $user->imageurl = "/images/users".'/'.$user.'/'.$imageName;
        }

        $user->save();

        return redirect()->route('profile');
    }
}
