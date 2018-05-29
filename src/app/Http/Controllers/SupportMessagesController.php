<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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


        $finalpeoples = [];
        foreach ($peoples as $people) {
          array_push($finalpeoples, $people[0]->client);
        }

        if($id==-1)
          $id = $finalpeoples[0]->id;

        $messages = Message::where('id_chatsupport', Auth::user()->id)->where('id_client', $id)->with('client')->with('chatsupport')->get();
        return view('pages.chatSupport', ['type' => $type, 'peoples' => $finalpeoples,
            'messages_chat' => $messages, 'title' => 'Messages', 'id_client' => $id]);
    }

    public function newMessage(Request $request) {

      $msg = Message::create([
        'id_chatsupport' => Auth::user()->id,
        'message' => $request->message,
        'datesent' => date('Y-m-d H:i:s'),
        'sender' => 'chatSupport',
        'id_client' => $request->id_client,
      ]);
      return Message::find($msg->id)->with('chatsupport')->first();
    }

    public function getMessages(Request $request) {
      $messages = Message::where('id_chatsupport', Auth::user()->id)
      ->where('id_client', $request->id_client)->with('client')->with('chatsupport')->get();
      return $messages;

    }
}
