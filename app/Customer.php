<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name'
    ];


    public function orders()
    {
    	return $this->hasMany('App\Order')
    }
    
    public function ordersInside()
    {
    	
    }
}
