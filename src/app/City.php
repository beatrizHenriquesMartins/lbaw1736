<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

	protected $table = 'cities';
  public $timestamps  = false;
  protected $primaryKey = 'id';

   protected $fillable = [
     'city'
  ];

  public function country() {
    return $this->belongsTo('App\Country', 'id_country');
  }

}
