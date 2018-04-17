<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Client;

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


}
