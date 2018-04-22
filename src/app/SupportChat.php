<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  public $table = 'chatsupports';
  protected $primaryKey = 'id_chatsupport';


}
