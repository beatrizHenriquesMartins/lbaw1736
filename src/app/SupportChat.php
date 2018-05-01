<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SupportChat extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  public $table = 'chatsupports';
  protected $primaryKey = 'id_chatsupport';

  public static function getNextChatSupport() {
    $supports = SupportChat::all();
    $min = 100000;
    $id = 0;
    foreach($supports as $support) {
      $uniques = [];
      $exists = false;
      $messages = DB::table('messages')->where('id_chatsupport', $support->id_chatsupport)->get();
      foreach ($messages as $message) {
        for($i = 0; $i < count($uniques); $i++) {
          if($message->id_client == $uniques[$i]->id_client) {
            $exits = true;
          }
        }
        if(!$exists) {
          array_push($uniques, $message);
        }
      }
      if(count($uniques) < $min) {
        $min = count($uniques);
        $id = $uniques[0]->id_chatsupport;
      }
    }
    return $id;
  }
}
