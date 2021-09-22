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
  @include('admin.approve.partials.view-show')
@stop

