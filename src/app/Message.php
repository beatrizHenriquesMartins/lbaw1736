<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $primaryKey = 'id';

  protected $fillable = [
      'id_chatsupport', 'id_client', 'sender', 'datesent', 'message'
  ];

  public function client()
  {
      return $this->belongsTo('App\User','id_client');//c_id - customer id
  }
  public function chatsupport()
  {
      return $this->belongsTo('App\User','id_chatsupport');//s_id - staff id
  }
}
