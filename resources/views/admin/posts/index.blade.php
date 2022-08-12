@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
  @can('admin.posts.create')
    <a class="btn btn-primary btn-sm float-right" href="{{route('admin.posts.create')}}">Nuevo post</a>    
  @endcan
  <h1>Posts</h1>
@stop

@section('content')
    @livewire('admin.post-index')
@stop

@section('css')

@stop

@section('js')

@stop