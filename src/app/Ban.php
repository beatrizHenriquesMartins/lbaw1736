<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  public $table = 'bans';
  protected $primaryKey = 'id_user';


}
