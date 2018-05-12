<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'username', 'imageurl', 'active', 'birthday','age'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    //necessário? como estamos a inserir novos users?
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('username');
            $table->string('imageurl')->default('user-default.jpg');
            $table->boolval('active');
            $table->string('dateOfBirth');
            $table->intval('age');
            $table->rememberToken();
        });
    }
    */

    /**
    * Accessor for Age.
    */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthday'])->age;
    }

}
