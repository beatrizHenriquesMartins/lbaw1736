<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandManager extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  public $table = 'brandmanagers';
  protected $primaryKey = 'id_brandmanager';

  /**
   * Products with this Category
   */
  public function brands() {
    return $this->belongsToMany('App\Brand', 'brandbrandmanagers', 'id_brandmanager', 'id_brand');
  }
}
