@extends('layouts.app')

@section('content')
   <h1>{{$album->name}}</h1>
   <a class="button secondary" href="/">Go back</a>
   <a class="button" href="/photos/create/{{$album->id}}">upload Photo to Album</a>
   <hr>
@endsection   