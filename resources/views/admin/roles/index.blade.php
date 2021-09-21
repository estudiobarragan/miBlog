@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')
    @if(session('success'))    
      <div class="alert alert-success">
        <strong>{{ session('success') }}</strong>
      </div>
    @endif
    <div class="card">
      @can('admin.roles.create')
        <div class="card-header d-grid d-md-flex justify-content-md-end">
          <a class="btn btn-primary text-end" href="{{route('admin.roles.create')}}">
            Agregar rol
          </a>
        </div>
      @endcan

      <div class="card-body">

        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Role</th>
              <th colspan="2"></th>
            </tr>
          </thead>

          <tbody>
            @foreach ($roles as $rol)
                <tr>
                  <td>{{$rol->id}}</td>
                  <td>{{$rol->name}}</td>
                  @can('admin.roles.edit')
                    <td width="10px;">
                      <a href="{{route('admin.roles.edit',$rol)}}" class="btn btn-primary btn-sm">Editar</a>
                    </td>
                  @endcan
                  @can('admin.roles.destroy')
                    <td width="10px;">
                      <form action="{{route('admin.roles.destroy',$rol)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">
                          Eliminar
                        </button>
                      </form>
                    </td>
                  @endcan
                </tr>

            @endforeach
          </tbody>

        </table>

      </div>
    </div>
@stop
