@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
    <h1>Crear Profile del usuario: {{auth()->user()->name}}</h1>
    @if(session('info'))    
      <div class="alert alert-warning mt-2">
        <strong>{{ session('info') }}</strong>
      </div>
    @endif
    @if(session('success'))    
      <div class="alert alert-success mt-2">
        <strong>{{ session('success') }}</strong>
      </div>
    @endif
@stop

@section('content')
  <div class="card">
    <div class="card-body">
      {{-- crear - store --}}
      {!! Form::open(['route'=>'admin.profile.store']) !!}

      @include('admin.profile.partials.form')

      {!! Form::submit('Crea el perfil', ['class'=>'btn btn-success']) !!}

      {!! Form::close() !!}
    </div>
  </div>
@stop

@section('css')
  <style>
  .image-wrapper{
    position: relative;
    padding-bottom: 56.25%;
  }
  .image-wrapper img{
    position: absolute;
    object-fit: cover;
    width: 100%;
    height: 100%;
  }
</style>
@stop

@section('js')
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>

    <script>
      $(document).ready( function() {
        $("#name").stringToSlug({
          setEvents: 'keyup keydown blur',
          getPut: '#slug',
          space: '-'
        });
      });

      ClassicEditor
        .create( document.querySelector( '#biografia' ) )
        .catch( error => {
            console.error( error );
        } );

    </script>
@stop