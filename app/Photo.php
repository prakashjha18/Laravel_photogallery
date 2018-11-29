<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //we need belongs to relation
    protected $fillable = array('album_id','description', 'photo', 'title', 'size');

    public function album(){
    	return $this->belongsTo('App\Album');
    }
}
