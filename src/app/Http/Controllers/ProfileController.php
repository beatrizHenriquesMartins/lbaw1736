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

				$addresses = DB::table('clientaddresses')
				->where('id_client', Auth::user()->id)
				->join('addresses', 'addresses.id_address', '=', 'clientaddresses.id_address')
				->join('cities', 'cities.id_city', '=', 'addresses.id_city')
				->join('countries', 'countries.id_country', '=', 'cities.id_country')->get();

        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
				return view('pages.profile', ['type' => $type, 'messages' => $messages, 'addresses' => $addresses, 'title' => 'Profile']);
      }
      else {
        $messages = null;
				return view('pages.profile', ['type' => $type, 'messages' => null, 'addresses' =>null, 'title' => 'Profile']);
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
				$addresses = DB::table('clientaddresses')
				->where('id_client', Auth::user()->id)
				->join('addresses', 'addresses.id_address', '=', 'clientaddresses.id_address')
				->join('cities', 'cities.id_city', '=', 'addresses.id_city')
				->join('countries', 'countries.id_country', '=', 'cities.id_country')->get();

        $messages = Message::where('id_client', Auth::user()->id)->with('client')->with('chatsupport')->get();
				return view('pages.editprofile', ['type' => $type, 'messages' => $messages, 'addresses' => $addresses, 'title' => 'Edit Profile']);
      }
      else {
        $messages = null;
				return view('pages.editprofile', ['type' => $type, 'messages' => null, 'addresses' => null, 'title' => 'Edit Profile']);
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

		public function removeAddress(Request $request) {

			$clientaddress = DB::table('clientaddresses')
			->where('id_client', Auth::user()->id)
			->where('clientaddresses.id_address', $request->input('addressId'))
			->join('addresses', 'addresses.id_address', '=', 'clientaddresses.id_address')
			->join('cities', 'cities.id_city', '=', 'addresses.id_city')
			->join('countries', 'countries.id_country', '=', 'cities.id_country')->first();
			if($clientaddress)
				DB::table('clientaddresses')->where('id_client', Auth::user()->id)
				->where('id_address', $request->input('addressId'))->delete();


			return json_encode($clientaddress);
		}

		public function addAddress(Request $request) {

			$clientaddress = DB::table('clientaddresses')
			->where('id_client', Auth::user()->id)
			->join('addresses', 'addresses.id_address', '=', 'clientaddresses.id_address')
			->join('cities', 'cities.id_city', '=', 'addresses.id_city')
			->join('countries', 'countries.id_country', '=', 'cities.id_country')
			->where('address', $request->input('address'))
			->where('city', $request->input('city'))
			->where('country', $request->input('country'))->first();

			if($clientaddress)
				return json_encode("Already Exists");


			$country = DB::table('countries')->where('country', $request->input('country'))->first();

			if(!$country) {
				$country = DB::table('countries')->insert([
					'country' => $request->input('country')
				]);
				$country = DB::table('countries')->where('country', $request->input('country'))->first();

			}

			$city = DB::table('cities')->where('city', $request->input('city'))->where('id_country', $country->id_country)->first();

			if(!$city) {
				$city = DB::table('cities')->insert([
					'city' => $request->input('city'),
					'id_country' => $country->id_country
				]);
				$city = DB::table('cities')->where('city', $request->input('city'))->where('id_country', $country->id_country)->first();

			}

			$address = DB::table('addresses')->where('address', $request->input('address'))->where('id_city', $city->id_city)->where('zipcode', $request->input('zipcode'))->first();

			if(!$address) {

				DB::table('addresses')->insert([
					'address' => $request->input('address'),
					'zipcode' => $request->input('zipcode'),
					'id_city' => $city->id_city
				]);
				$address = DB::table('addresses')->where('address', $request->input('address'))->where('id_city', $city->id_city)->where('zipcode', $request->input('zipcode'))->first();

			}

			DB::table('clientaddresses')->insert([
				'id_client' => Auth::user()->id,
				'id_address' => $address->id_address
			]);

			$clientaddress = DB::table('clientaddresses')
			->where('id_client', Auth::user()->id)
			->join('addresses', 'addresses.id_address', '=', 'clientaddresses.id_address')
			->join('cities', 'cities.id_city', '=', 'addresses.id_city')
			->join('countries', 'countries.id_country', '=', 'cities.id_country')
			->where('address', $request->input('address'))
			->where('city', $request->input('city'))
			->where('country', $request->input('country'))->first();


			return json_encode($clientaddress);
		}


}
