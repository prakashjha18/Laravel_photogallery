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

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

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

  
