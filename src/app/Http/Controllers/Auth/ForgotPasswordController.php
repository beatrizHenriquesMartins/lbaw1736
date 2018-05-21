<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

use App\ResetPassword;
use App\User;

class ForgotPasswordController extends Controller
{

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getResetAuthenticatedView(Request $request)
    {
        return view('auth.reset');
    }

    /**
     * Reset password for not logged in users.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetNotAuthenticated(Request $request)
    {
        $this->validate($request, ['password' => 'required|confirmed|min:6']);

        $credentials = $request->only('password', 'password_confirmation');


        $user = User::where('email', $request->input('email'))->first();

        if($user) {
          if($user->remember_token == $request->input('token')) {
            $user->update(['password' => bcrypt($credentials['password'])]);
            return view('auth.login');
          }
          else {
            return view('auth.reset')->withErrors(['email' => 'INVALID TOKEN']);
          }
        }
        else {
          return view('auth.reset')->withErrors(['email' => 'We dont have this email in your DB!']);
        }
    }

    public function getEmail(Request $request) {

      return view('auth.email');

    }


    public function sendEmail(Request $request) {

      $user = User::where('email', $request->input('email'))->first();

      if($user) {

        Mail::to($user->email)->send(new ResetPassword($user->remember_token, $user));

        return redirect('/homepage');
      }
      else {
        return view('auth.email')->withErrors(['email' => 'We dont have this email in our DB!']);
      }

    }
}
