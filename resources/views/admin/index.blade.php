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
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@stop