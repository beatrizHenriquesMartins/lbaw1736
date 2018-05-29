<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Client;
use App\BrandManager;
use App\SupportChat;
use App\Admin;
use App\Message;

class SupportMessagesController extends Controller{

    public function showMessage($id){
        if (!Auth::check()) {
            return redirect('/login');
        }

        $type = 0;

        if(Auth::check()) {
            $userBM = BrandManager::find(Auth::user()->id);
            $userSP = SupportChat::find(Auth::user()->id);
            $userADM = Admin::find(Auth::user()->id);
            $userCL = Client::find(Auth::user()->id);

            if($userCL != null){
                $type = 1;
            }

            if($userBM != null){
                $type = 2;
            }

            if($userSP != null){
                $type = 3;
            }

            if($userADM != null){
                $type = 4;
            }
        }

        if($type != 3){
            return redirect('/404');
        }

        $peoples = Message::where('id_chatsupport', Auth::user()->id)
            ->with('client')->with('chatsupport')->get()->groupBy('id_client');

        $messages = [];
        $finalpeoples = [];
        foreach ($peoples as $people) {
          array_push($finalpeoples, $people[0]->client);
          array_push($messages, $people[0]);
        }


        return view('pages.chatSupport', ['type' => $type, 'peoples' => $finalpeoples,
            'messages_chat' => $messages, 'title' => 'Messages']);
    }
}
