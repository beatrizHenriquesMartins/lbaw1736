<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;



  /**
   * Products with this Category
   */
  public function products() {
    return $this->hasMany('App\Product', 'id_product');
  }

  public function brands() {
    return $this->belongsToMany('App\BrandManager', 'brandbrandmanagers', 'id_brand', 'id_brandmanager');
  }
}
