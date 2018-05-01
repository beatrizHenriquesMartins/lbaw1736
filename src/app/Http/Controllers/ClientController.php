<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Client;
use App\SupportChat;
use App\Message;

class ClientController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */



    /**
     * Creates a new Client.
     *
     * @return Client The client created.
     */
    public function create(Request $request)
    {
      $client = new Client();
      $client->id_client = Auth::user()->id;

      $client->save();

      return $client;
    }

    public function newMessage(Request $request) {

      $oldmessage = Message::where('id_client', Auth::user()->id)->first();


      $message = new Message();
      $message->id_client = Auth::user()->id;
      $message->message = $request->message;
      $message->datesent = date('Y-m-d H:i:s');
      $message->sender = "Client";
      if($oldmessage != null)
        $message->id_chatsupport = $oldmessage->id_chatsupport;
      else
        $message->id_chatsupport = SupportChat::getNextChatSupport();
      $message->save();
      return $message->with('client')->where('id', $message->id)->first();
    }
}
