@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
  <div class="row">
    <div class="col-10">
      <h1>Programacion de posts</h1>
    </div>
    <div class="col-2 float-right">
      <a href="{{route('admin.publication.calendario')}}" class="btn btn-success">Calendario</a>
    </div>
  </div>
  
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
  @livewire('admin.publication-post-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
@stop

@section('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
@stop