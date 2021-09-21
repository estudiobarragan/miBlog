@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
    <h1>Etiquetas</h1>
@stop

@section('content')
  @if(session('success'))    
    <div class="alert alert-success">
      <strong>{{ session('success') }}</strong>
    </div>
  @endif
  <div class="card">
    @can('admin.tags.create')
      <div class="card-header d-grid d-md-flex justify-content-md-end">
        <a class="btn btn-primary text-end" href="{{route('admin.tags.create')}}">
          Agregar etiqueta
        </a>
      </div>      
    @endcan
    <div class="card-body">

      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Color</th>
            <th class="Colspan="2""></th>
          </tr>
        </thead>
          @foreach ($tags as $tag)
              <tr>
                <td>{{$tag->id}}</td>
                <td>{{$tag->name}}</td>
                <td>{{$tag->color}}</td>

                @can('admin.tags.edit')                  
                  <td width="10px;">
                    <a class="btn btn-primary btn-sm" href="{{route('admin.tags.edit',$tag)}}">
                      Editar
                    </a>
                  </td>
                @endcan
                @can('admin.tags.destroy')  
                  <td width="10px;">
                    <form action="{{route('admin.tags.destroy',$tag)}}" method="POST">
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
        <tbody>

        </tbody>
      </table>

    </div>
  </div>
@stop

