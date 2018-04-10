<?php

namespace App;
use App\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends User
{

    /**
     * The wishlist this user owns.
     */
     public function wishlist() {
      return $this->hasMany('App\Wishlist');
    }

    public function user() {
      return $this->morphOne('User', 'userable');
    }
}
