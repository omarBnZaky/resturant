<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [
	        'name','resturant_id'
	    ];



	 public function restaurants()
	 {
	    return $this->belongsTo('App\Restaurant');
	 }
}
