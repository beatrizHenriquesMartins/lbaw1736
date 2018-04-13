<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;



  public function reviews() {
    return $this->hasMany('App\Review', 'id_purchase');
  }

  public function client() {
    return $this->belongsTo('App\Client', 'id_client');
  }

}
