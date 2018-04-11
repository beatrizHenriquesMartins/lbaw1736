<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $fillable = [
      'id', 'name', 'quantityInStock', 'price', 'imageURL', 'bigDescription', 'shortDescription', 'id_brand', 'id_category'
  ];

  /**
   * The wishlist this product is.
   */
  public function wishlist() {
    return $this->belongsToMany('App\Client', 'wishlist', 'id_client', 'id_product');
  }

  public function cart() {
    return $this->belongsToMany('App\Client', 'cart', 'id_client', 'id_product');
  }


}