<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = array('name', 'description', 'cover_image');

    public function photos(){
    	//this hasmany means that one album can have many photos
    	return $this->hasMany('App\Photo');
    }
}
