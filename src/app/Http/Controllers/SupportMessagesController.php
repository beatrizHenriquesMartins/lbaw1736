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

        $peoples = Client::join('messages', 'messages.id_client', '=', 'clients.id_client')
            ->join('chatsupports', 'chatsupports.id_chatsupport', '=', 'messages.id_chatsupport')
            ->join('users', 'users.id', '=', 'clients.id_client')
            ->where('chatsupports.id_chatsupport', Auth::user()->id)->groupBy('clients.id_client',
                'messages.id_message', 'chatsupports.id_chatsupport', 'users.id')->get();

        if($id == -1) {
            $first_msg = Message::where('id_chatsupport', Auth::user()->id)->first();
            $id = $first_msg->id_client;
        }

        $messages_chat = Message::where('id_chatsupport', Auth::user()->id)
            ->where('id_client', $id)
            ->with('client')->with('chatsupport')->get();


        return view('pages.chatSupport', ['type' => $type, 'peoples' => $peoples,
            'messages_chat' => $messages_chat]);
    }
}
