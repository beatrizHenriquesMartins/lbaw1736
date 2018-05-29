<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirmationpayment extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $primaryKey = 'id_client';

    protected $fillable = [
        'cost'
    ];

    
     
}