@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
    <h1>Programacion de posts</h1>
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
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
  
@stop