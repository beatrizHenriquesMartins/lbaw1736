<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $primaryKey = ['id_purchase','id_product'];

  protected $fillable = [
      'id_purchase', 'id_product', 'reviewdate', 'textreview', 'rating'
  ];

  public function product() {
    return $this->belongsTo('App\Product', 'id');
  }

}
