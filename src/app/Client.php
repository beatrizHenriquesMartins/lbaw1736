<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


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
      return $this->hasMany('App\Wishlist');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
