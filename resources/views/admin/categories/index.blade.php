@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')

  @if(session('success'))    
    <div class="alert alert-success">
      <strong>{{ session('success') }}</strong>
    </div>
  @endif
  
  <div class="card">
    @can('admin.categories.create')
      <div class="card-header d-grid d-md-flex justify-content-md-end">
        <a class="btn btn-primary text-end" href="{{route('admin.categories.create')}}">
          Agregar categoria
        </a>
      </div>
    @endcan

    <div class="card-body">

      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th class="Colspan="2""></th>
          </tr>
        </thead>
          @foreach ($categories as $category)
              <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>

                @can('admin.categories.edit')
                  <td width="10px;">
                    <a class="btn btn-primary btn-sm" href="{{route('admin.categories.edit',$category)}}">
                      <i class="far fa-edit"></i>
                    </a>
                  </td>
                @endcan
                @can('admin.categories.destroy')
                  <td width="10px;">
                    @livewire('admin.show-modal-delete', ['model' => $category,'ruta'=>'/admin/categories', 'key'=>$category->id])
                  </td>
                @endcan
              </tr>

          @endforeach
        <tbody>

        </tbody>
      </table>

    </div>
  </div>
@stop
