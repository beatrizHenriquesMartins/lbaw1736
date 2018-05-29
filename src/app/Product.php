<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $fillable = [
      'id', 'name', 'quantityinstock', 'price', 'imageURL', 'bigDescription', 'shortDescription', 'id_brand', 'id_category'
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

  public function reviews() {
    return $this->hasMany('App\Review', 'id_product');
  }

  public function category() {
    return $this->belongsTo('App\Category', 'id_category');
  }

  public function brand() {
    return $this->belongsTo('App\Brand', 'id_brand');
  }

  public function productwishlist() {
    return $this->belongsToMany('App\Purchase', 'productwishlist', 'id_product', 'id_purchase');
  }
}
