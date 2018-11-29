<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## commit 1
we make controllers by writing php artisan make:controller PhotosController and model by writing php artisan make:model Album -m
then to migrate the changes simply php artisan migrate

## commit 2
 in AlbumsController.php we write this code
 ```public function index(){
    	return view('albums.index');
    }
    public function create(){
    	return view('albums.create');
    }
```    
then in views we create a folder named albums and two blade php file named index and create
the routing is done in web.php as
```
Route::get('/','AlbumsController@index' );
Route::get('/albums','AlbumsController@index' );
Route::get('/albums/create','AlbumsController@create' );
```
now in views create another folder layouts and in layouts create a file named app here we will use foundation framework
insert this in app 

```
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PhotoShow</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.css">
  </head>
  <body>
    <div class="row">
      @yield('content')
    </div>
  </body>
</html>
```
yield content is used mainly for code redundancy
now to kick in the foundation framework
include this code in create.blade.php
```
@extends('layouts.app')

@section('content')
    <h3>create Albumn</h3>
@endsection    
``` 
and this code in index.blade.php
```
@extends('layouts.app')

@section('content')
    <h3> Albumns</h3>
@endsection    
```
now here comes the implementation of form which is done using laravel collective
we need to write this in terminal
```
composer require "laravelcollective/html":"^5.4.0"
```
Next, add your new provider to the providers array of config/app.php:

 ``` 
 'providers' => [
    // ...
    Collective\Html\HtmlServiceProvider::class,
    // ...
  ],
  ```
Finally, add two class aliases to the aliases array of config/app.php:

 ``` 'aliases' => [
    // ...
      'Form' => Collective\Html\FormFacade::class,
      'Html' => Collective\Html\HtmlFacade::class,
    // ...
  ],
  ```
  now create a provider as
  ```
  php artisan make:provider FormServiceProvider
```
you also have to include this in app.php
```
App\Providers\FormServiceProvider::class,
```
now in boot function of FormServiceProvider.php write this
```
public function boot()
    {
        Form::component('text','components.form.text',['name','value'=> null, 'attributes' => []]);
        Form::component('textarea','components.form.textarea',['name','value'=> null, 'attributes' => []]);
        Form::component('submit,','components.form.submit',['value'=> 'Submit', 'attributes' => []]);
        Form::component('hidden','components.form.hidden',['name','value'=> null, 'attributes' => []]);
        Form::component('file','components.form.file',['name', 'attributes' => []]);
    }
```  
all add ```use Form ``` in FormServiceProvider.php
now trust me this is going to be little tedious work to do
now in views create a folder called as components and in components create a folder called as form
now in form create files as text,textarea,submit,hidden
in text file :
```
<label>
	{{Form::label($name)}}
	{{Form::text($name, $value, $attributes)}}
</label>	
```
in file file
```
<div>
	{{Form::file($name)}}
</div>	
```
in textarea file :
```
<label>
	{{Form::label($name)}}
	{{Form::textarea($name, $value, $attributes)}}
</label>	
```
in submit file:
```
<div>
	{{Form::submit($value, $attributes)}}
</div>
```
in hidden file
```
{{form::hidden($name, $value, $attributes)}}
```
now in create.blade.php add this
```
{!!Form::open(['action' => 'AlbumsController@store','method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
    {{Form::text('name','',['placeholder' => 'Album Name'])}}
    {{Form::textarea('description','',['placeholder' => 'Album Description'])}}
    {{Form::file('cover_image')}}
    {{Form::submit('submit')}}
  {!! Form::close() !!}
```  
then in AlbumsController.php :
```
public function store(Request $request){
        return;
    }
```
and in web.php :
```
Route::post('/albums/store','AlbumsController@store' );
```
and now the form work is done

## commit 3

we will create now navbar and have our error messages include
TO setup topbar in components create a folder as ins and make two files as messages and topbar 
in messages:
```
@if(count($errors) > 0)
  @foreach($errors->all() as $error)
    <div class="callout alert">
      {{$error}}
    </div>
  @endforeach
@endif

@if(session('success'))
  <div class="callout success">
    {{session('success')}}
  </div>
@endif

@if(session('error'))
  <div class="callout alert">
    {{session('error')}}
  </div>
@endif
```
in topbar:
```
<div class="top-bar">
	<div class="row">
		<div class="top-bar-left">
			<ul class="menu">
				<li class="menu-text">PhotoShow</li>
				<li><a href="/">Home</a></li>
				 <li><a href="/albums/create">Create Album</a></li>
			</ul>	
		</div>
	</div>
</div>			
```
now comes the validation and cover image part 
in AlbumsController.php add this function
```
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
```
## commit 4
in Album.php apply hasmany relationship :
```
class Album extends Model
{
    protected $fillable = array('name', 'description', 'cover_image');

    public function photos(){
    	//this hasmany means that one album can have many photos
    	return $this->hasMany('App\Photo');
    }
}
```
 and in Photo.php apply belongsto relationship
 ```
 class Photo extends Model
{
    //we need belongs to relation
    protected $fillable = array('album_id','description', 'photo', 'title', 'size');

    public function album(){
    	return $this->belongsTo('App\Album');
    }
}
``` 
now create album in AlbumsController.php in the same function
```
 //create album
        $album = new Album;
        $album->name = $request->input('name');
        $album->description = $request->input('description');
        $album->cover_image = $filenameToStore;
        $album->save();
        return redirect('/albums')->with('success','Album created');
```
now in AlbumsController.php we need to pass the albums value to index.blade.php to show the photo for that we have to implement this code
```
public function index(){
    	$albums = Album::with('Photos')->get();
    	return view('albums.index')->with('albums', $albums);
    }
```
and now display the phots in index.blade.php as this:
```
@extends('layouts.app')

@section('content')
    @if(count($albums) > 0)
    <?php
      $colcount = count($albums);
  	  $i = 1;
    ?>
    <div id="albums">
      <div class="row text-center">
        @foreach($albums as $album)
          @if($i == $colcount)
             <div class='medium-4 columns end'>
               <a href="/albums/{{$album->id}}">
                  <img class="thumbnail" src="storage/album_covers/{{$album->cover_image}}" alt="{{$album->name}}">
                </a>
               <br>
               <h4>{{$album->name}}</h4>
          @else
            <div class='medium-4 columns'>
              <a href="/albums/{{$album->id}}">
                <img class="thumbnail" src="storage/album_covers/{{$album->cover_image}}" alt="{{$album->name}}">
              </a>
              <br>
              <h4>{{$album->name}}</h4>
          @endif
        	@if($i % 3 == 0)
          </div></div><div class="row text-center">
        	@else
            </div>
          @endif
        	<?php $i++; ?>
        @endforeach
      </div>
    </div>
  @else
    <p>No Albums To Display</p>
  @endif 
  ```
  and this is not something difficult or tedious to implement
