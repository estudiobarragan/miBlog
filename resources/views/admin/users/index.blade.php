@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')

  @livewire('admin.users-index')
  
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop