<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Google_Client;
use GuzzleHttp;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/homepage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string|max:255|unique:users',
            'cellphone' => 'required|string|min:9|max:17',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      DB::beginTransaction();
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'username' => $data['username'],
            'imageurl' => '/images/user_image.png',
            'active' => 'true',
        ]);

        $client = Client::create([
          'id_client' => $user['id'],
          'cellphone' => $data['cellphone'],
        ]);
        DB::commit();
        return $user;
    }

    public function googleRegister(Request $request) {
      $user = User::where('email',$request->email)->first();

      if($user==null){
        $names = explode(" ", $request->input('name'));
        $username =  str_replace(' ', '', $request->input('name'));

        // Get $id_token via HTTPS POST.

        $id_token = $request->id;
        $CLIENT_ID ='876344229012-l89i8ark42rpp6m4rkcd4kr7em43pvhm.apps.googleusercontent.com';
        $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
        $client->setHttpClient(new GuzzleHttp\Client(['verify'=>false]));
        $payload = $client->verifyIdToken($id_token);

        if ($payload) {
          $userid = $payload['sub'];
        // If request specified a G Suite domain:
        //$domain = $payload['hd'];
        } else {
            return null;
        }
        DB::beginTransaction();
        $user = User::create([
            'firstname' => $names[0],
            'username' => $username,
            'lastname' => $names[1],
            'email' => $request->email,
            'password' => $userid,
            'imageurl'=> $request->photo,
            'active'=> true,
        ]);
        $user->save();

        $client = Client::create([
            'id_client' => $user->id,
            'cellphone' => '111111111',
        ]);
        $client->save();
        DB::commit();
        Auth::login($user);
      }
      else{
        Auth::login($user);
      }
      return $user;
    }

}
