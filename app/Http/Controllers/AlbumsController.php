<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;

class AlbumsController extends Controller
{
    public function index(){
    	$albums = Album::with('Photos')->get();
    	return view('albums.index')->with('albums', $albums);
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

        //create album
        $album = new Album;
        $album->name = $request->input('name');
        $album->description = $request->input('description');
        $album->cover_image = $filenameToStore;
        $album->save();
        return redirect('/albums')->with('success','Album created');

    }     
}
