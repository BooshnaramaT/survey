<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addusers extends Model
{
    protected $table = 'users';
    protected $fillable=['fname','lname','email','demographic_data','password','enabled','last_login','last_access_ip','serialized'];
    public $timestamps=false;
}
