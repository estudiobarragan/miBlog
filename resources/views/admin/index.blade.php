@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')

@stop

@section('content')

    @if (auth()->user()->unreadNotifications->count() > 0) 
      @livewire('admin.show-notification')
    @endif
    @livewire('admin.show-statistics')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop