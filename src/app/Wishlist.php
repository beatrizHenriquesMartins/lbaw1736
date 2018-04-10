<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  /**
   * The user this wishlist belongs to
   */
  public function user() {
    return $this->belongsTo('App\User');
  }

  /**
   * Products inside this Wishlist
   */
  public function products() {
    return $this->hasMany('App\Products');
  }
}
