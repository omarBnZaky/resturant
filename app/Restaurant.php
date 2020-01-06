<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
 protected $fillable = [
        'name','user_id'
    ];

 public function categories()
 {
    return $this->hasMany('App\Category');
 }


 public function user()
 {
    return $this->belongsTo('App\User');
 }

}
