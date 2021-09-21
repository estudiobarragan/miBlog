@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
    <h1>Editar rol</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-body">

      {!! Form::model($role,['route'=>['admin.roles.update',$role], 'method'=>'put']) !!}

      @include('admin.roles.partials.form')

      {!! Form::submit('Actualizar Rol', ['class'=>'btn btn-primary']) !!}

      {!! Form::close() !!}

    </div>
  </div>
@stop