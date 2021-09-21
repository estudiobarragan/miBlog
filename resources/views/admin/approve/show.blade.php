@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')

  <div class="row">
    <div class="col-8">
      <h1>Post a aprobar</h1>
    </div>
    <div class="col flow-root ml-3">
      @isset($botones)
        <form action="{{ route('admin.approves.store', ['slug'=> $post->slug]) }}" method="post">
          @csrf
          @method('post')
          <button type="submit" class="btn btn-primary float-left" >
            Aceptar autorizacion
          </button>
        </form>
        
        <form action="{{ route('admin.approves.reject') }}" method="post">
          @csrf
          @method('post')
          <button type="submit" class="btn btn-warning float-right">
            Rechazar autorizacion
          </button>
        </form>
      @endisset
    </div>
  </div>
  @stop

@section('content')
<div class="container row pt-5">
  <div class="col-sm-2">

  </div>
  <div class="col-sm-9">
    <hr>
    <h1>{{$post->name}}</h1>
    <h5>{{$post->extract}}</h5>
    
    <div class="card">
      @if($post->image)
        <img class="card-img-top" src="{{Storage::url($post->image->url)}}" alt="">
      @else
        <img class="card-img-top" src="{{asset('/img-default/post-default.webp')}}" alt="">
      @endif
    </div>

    <div class="row">
      
      <div class="col-7" >
        <p>Categoria: <strong>{{$post->categoria->name}}</strong></p>
        <p>Publicado: <strong>{{$post->updated_at->format('j F, Y')}}</strong></p>
      </div>
      
      <div class="col-5">
        
        @foreach ($post->tags as $tag)
          <label class="mr-2">
            @if($loop->index==0)
              Etiquetas:
            @endif

            {{$tag->name}}
          </label>          
        @endforeach
        <p>Autor: <strong>{{$post->user->name}}</strong></p>
      </div>
    </div>
    <div class="row">

      <div class="col">
        <p>{{$post->body}}</p>
      </div>
    </div>
    
  </div>
</div>
@stop

