<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

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

  
