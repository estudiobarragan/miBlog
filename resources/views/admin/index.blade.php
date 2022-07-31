@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')

@stop

@section('content')
    @livewire('admin.show-notification')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop