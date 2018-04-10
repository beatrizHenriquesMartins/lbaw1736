<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $primaryKey = ['id_client', 'id_product'];

  protected $fillable = [
      'id_client', 'id_product'
  ];

  /**
   * The user this wishlist belongs to
   */
  public function client() {
    return $this->belongsTo('App\Client', 'id_client');
  }

  /**
   * Products inside this Wishlist
   */
  public function products() {
    return $this->belongsTo('App\Products', 'id_product');
  }


}
