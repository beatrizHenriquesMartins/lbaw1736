<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

	protected $table = 'addresses';
  public $timestamps  = false;
  protected $primaryKey = 'id';

   protected $fillable = [
     'address', 'zipcode'
  ];

  public function city() {
    return $this->belongsTo('App\City', 'id_city');
  }

}
