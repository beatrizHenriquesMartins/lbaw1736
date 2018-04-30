<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $primaryKey = 'id_client';

    protected $fillable = [
        'id_client', 'cellphone'
    ];

    /**
     * The wishlist this user owns.
     */
     public function wishlist() {
      return $this->belongsToMany('App\Product', 'wishlists', 'id_client', 'id_product');
    }

    public function cart() {
     return $this->belongsToMany('App\Product', 'carts', 'id_client', 'id_product')->withPivot('quantity');
   }


    public function user() {
      return $this->belongsTo('App\User');
    }

    public function purchases() {
      return $this->hasMany('App\Purchase', 'id_client');
    }

    public function addresses() {
    return $this->hasMany('App\Address', 'id_client');
  }
}
