@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
  <div class="row">
    <div class="col-10">
      <h1>Calendario</h1>
    </div>
    {{-- <div class="col-2 float-right">
      <button class="btn btn-success">Calendario</button>
    </div> --}}
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
  @can('admin.publication.create')
    @can('admin.publication.edit')
      @livewire('admin.calendario',['page'=>request()->fullUrl()])
    @else
      No tiene los permisos requeridos
    @endcan
  @else
    No tiene los permisos requeridos
  @endcan
@stop

@section('css')

@stop

@section('js')

@stop