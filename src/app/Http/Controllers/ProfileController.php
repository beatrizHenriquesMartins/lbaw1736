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
	public function show($id){

			if (!Auth::check())
				return redirect('/login');

			$user = Auth::user();
			//..............ou?
			//$user = User::find($id);


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

		return view('pages.profile', ['user' => $user, 'type' => $type]);
		//ou...
		//return view('pages.profile', compact('user','type');
	}


  public function showedit($id)
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

        return view('pages.editprofile', ['user' => $user, 'type' => $type]);
    }

    public function edit(Request $request, $id)
    {
    	 $user = Auth::user();

    	  $rules = array(
          'firstname' => 'required',
           'lastname' => 'required',
          'imageurl' => 'mimes:jpeg,png,jpg,gif,svg',
           'username' => 'required|string|unique:users',
            //'birthday' => 'date',
            'email' => 'required|email|unique:users',
            'nif' => 'integer',
            'password' => 'required|min:6|confirmed'
      );

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return redirect()->route('editProduct', ['id' => $id])->withErrors($validator);
      } else {
      }
        $user->firstname = request('firstname');
        $user->lastname = request('lastname');
        $user->password = bcrypt(request('password'));
        $user->imageurl = request('imageurl');
				$user->datemodified = date('Y-m-d H:i:s');

        $destinationPath = public_path('/images');
        if ($request->hasFile('imageurl')) {
          $imageName = $request->imageurl->getClientOriginalName();
          $request->imageurl->move(public_path('images/users'.'/'.$user), $imageName);
          $user->imageurl = "/images/users".'/'.$user.'/'.$imageName;
        }

        $user->save();

        return redirect()->route('pages.profile');
    }
}
