<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
		'phone', 'address','customer_id','status'
    ];


    public function customer()
    {
    	return $this->belongsTo('App\Customer')
    }

    

}
