<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  public $primaryKey = 'id_purchase';

  protected $guarded = [];

  public function reviews() {
    return $this->hasMany('App\Review', 'id_purchase');
  }

  public function client() {
    return $this->belongsTo('App\Client', 'id_client');
  }

  public function productwishlist() {
    return $this->belongsToMany('App\Product', 'productwishlist', 'id_product', 'id_purchase');
  }


}
