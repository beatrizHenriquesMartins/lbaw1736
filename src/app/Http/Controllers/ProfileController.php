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
     echo "<script>console.log( 'entrou ProfileController@show' );</script>";

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
      echo "<script>console.log( 'entrou ProfileController@showedit' );</script>";

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
      echo "<script>console.log( 'entrou ProfileController@edit' );</script>";
    	 $user = Auth::user();

    	  $rules = array(
          'firstname' => 'required',
          'lastname' => 'required',
          //'imageurl' => 'mimes:jpeg,png,jpg,gif,svg',
      );

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {

       echo "<script>console.log( 'validacao falhou' );</script>";
        return redirect()->route('editProfile')->withErrors($validator);
      } else {

         echo "<script>console.log( 'validacao ok' );</script>";
      /*
				if($request->input('password')) {
					$rules2 = array(
						'password' => 'required|min:6|confirmed'
					);

					$validator2 = Validator::make(Input::all(), $rules2);

					if ($validator2->fails()) {
						return redirect()->route('editProfile')->withErrors($validator2);
					}
*/
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        /*
        $user->password = bcrypt($request->input('password'));
				$user->datemodified = date('Y-m-d H:i:s');

        $destinationPath = public_path('/images');
        if ($request->hasFile('imageurl')) {
          $imageName = $request->imageurl->getClientOriginalName();
          $request->imageurl->move(public_path('images/users'.'/'.$user), $imageName);
          $user->imageurl = "/images/users".'/'.$user.'/'.$imageName;
        }
        */

        $user->save();

        return redirect()->route('profile');
    }
  }

  public function showUpdateAvatar(){
     echo "<script>console.log( 'entrou ProfileController@showUpdateAvatar' );</script>";

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
        return view('pages.updateAvatar', ['type' => $type, 'messages' => $messages]);
      }
      else {
        $messages = null;
        return view('pages.updateAvatar', ['type' => $type, 'messages' => null]);
      }
  }

  public function updateAvatar(Request $request){
 
        $request->validate([
            'imageurl' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
 
        $user = Auth::user();
 
        $avatarName = $user->id.'_avatar'.time().'.'.request()->imageurl->getClientOriginalExtension();
 
        $request->imageurl->storeAs('avatars',$avatarName);
 
        $user->imageurl = $avatarName;
        $user->save();
 
        return back()
            ->with('success','You have successfully upload image.');
    }

    public function showChangePassword(){

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
        return view('pages.changepassword', ['type' => $type, 'messages' => $messages]);
      }
      else {
        $messages = null;
        return view('pages.changepassword', ['type' => $type, 'messages' => null]);
      }
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
        return redirect()->back()->with("success","Password changed successfully !");
    }

}
