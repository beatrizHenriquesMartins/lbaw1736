<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Client;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\User;
use App\Ban;
use App\Product;
use App\Confirmationpayment;

class AdminController extends Controller
{


     public function listClients(Request $request)
     {

      if (!Auth::check()) return redirect('/login');


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

      if($type != 4)
        return redirect('/404');

      $clients = Client::join('users', 'id', '=', 'id_client')->whereNotIn('id_client', function($query) {
         $query->select('id_user')
               ->from('bans');})->paginate(15);


      return view('pages.administration', ['users' => $clients, 'type' => $type, 'page' => 1, 'messages' => null, 'title' => 'Administration']);
    }

    public function listBms(Request $request)
    {

     if (!Auth::check()) return redirect('/login');


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

     if($type != 4)
       return redirect('/404');

     $bms = BrandManager::join('users', 'users.id', '=', 'id_brandmanager')->whereNotIn('id_brandmanager', function($query) {
        $query->select('id')
              ->from('admins');})->whereNotIn('id_brandmanager', function($query) {
                 $query->select('id_user')
                       ->from('bans');})->paginate(15);

     return view('pages.administration', ['users' => $bms, 'type' => $type, 'page' => 2, 'messages' => null, 'title' => 'Administration']);
   }

   public function listSupports(Request $request)
   {

    if (!Auth::check()) return redirect('/login');


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

    if($type != 4)
      return redirect('/404');

    $supports = SupportChat::join('users', 'id', '=', 'id_chatsupport')->whereNotIn('id_chatsupport', function($query) {
       $query->select('id_user')
             ->from('bans');})->paginate(15);


    return view('pages.administration', ['users' => $supports, 'type' => $type, 'page' => 3, 'messages' => null, 'title' => 'Administration']);
  }

  public function listBans(Request $request)
  {

   if (!Auth::check()) return redirect('/login');


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

   if($type != 4)
     return redirect('/404');

   $bans = User::join('bans', 'bans.id_user', '=', 'id')->paginate(15);


   return view('pages.administration', ['users' => $bans, 'type' => $type, 'page' => 4, 'messages' => null, 'title' => 'Administration']);
 }

  public function ban(Request $request)
  {

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

    if($type != 4) {
      return redirect('/404');
    }

    $ban = Ban::find($request->input('id'));

    if($ban != null)
      return $ban;

    $ban = new Ban();
    $ban->id_admin = Auth::user()->id;
    $ban->id_user = $request->input('id');
    $ban->bandate = date('Y-m-d H:i:s');
    $ban->save();

    $client = User::find($request->input('id'));
    $client->active = false;
    $client->save();

    return $ban;
  }

  public function unban(Request $request)
  {

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

    if($type != 4) {
      return redirect('/404');
    }

    $ban = Ban::find($request->input('id'));

    if($ban == null)
      return redirect('/404');

    $ban->delete();

    $client = User::find($request->input('id'));
    $client->active = true;
    $client->save();

    return $ban;
  }

  public function showUser($id){

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


    if($type != 4)
      return redirect('/404');

    $user = User::find($id);

    return view('pages.profile', ['type' => $type, 'user' => $user, 'page' => 2, 'messages' => null, 'title' => 'Administration']);
  }

  public function confirmPaymentShow(){
    if (!Auth::check()) return redirect('/login');


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

      if($type == 4){
        //$clientsID = DB::table('confirmationpayments')->pluck('id_client');
        $purchases = DB::table('purchases')->where('purchase_state','=', false)->get();
        $clientNames = [];
        $clientCosts = [];
        foreach($purchases as $purchase){
          $clientID = $purchase->id_client;
          $user = User::find($clientID);
          $username = $user->getAttribute('username');
          $clientNames[$purchase->id_purchase] = $username;
          $clientCosts[$purchase->id_purchase] = $purchase->cost;
        }
        /*foreach($clientsID as $clientID){
        
          $user = User::find($clientID);
          $username = $user->getAttribute('username');
          $clientNames[$clientID] = $username; 

          $cost = ConfirmationPayment::find($clientID)->getAttribute('cost');
          $clientCosts[$clientID] = $cost;
        }*/
        
        return view('pages.confirmation_payment', ['names' => $clientNames, 'costs'=> $clientCosts, 'type' => $type, 'title' => 'Confirmation Payment']);
      }

  }

  public function validatePayment(Request $request, $id){
     $newPurchaseState = true;
     DB::table('purchases')->where('id_purchase', $id)->update(['purchase_state' => $newPurchaseState]);
     return json_encode($id);
     
     $ret = 0;
     return json_encode($ret);
  }

}
