<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;



  /**
   * Products with this Category
   */
  public function items() {
    return $this->hasMany('App\Product', 'id_product');
  }
}
