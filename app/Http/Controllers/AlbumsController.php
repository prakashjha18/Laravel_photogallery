<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index(){
    	return view('albums.index');
    }
    public function create(){
    	return view('albums.create');
    }
    public function store(Request $request){
        $this->validate($request, [
          'name' => 'required',
          'cover_image' => 'image|max:1999'
        ]);

        //GET FILENAME WITH EXTENSION
		$filenameWithExt = $request->file('cover_image')->getClientOriginalName();

        //	 JUST GET FILE NAME 
        $filename1 = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // get extension
        $extension =  $request->file('cover_image')->getClientOriginalExtension();
         
        //get new filenname
        $filenameToStore = $filename1.'_'.time().'.'.$extension;

        //upload image
        $path = $request->file('cover_image')->storeAs('public/album_covers', $filenameToStore);

        return $path;
    }     
}
