@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')

  <div class="row">
    <div class="col-8">
      <h1>Post a aprobar</h1>
    </div>
  </div>
  @stop

@section('content')


  <div class="container row pt-5">
    <div class="col-sm-2">

    </div>
    <div class="col-sm-9">
      <hr>
      <h1>{{$post->name}}</h1>
      <h5>{{$post->extract}}</h5>
      
      <div class="card">
        @if($post->image)
          <img class="card-img-top" src="{{Storage::url($post->image->url)}}" alt="">
        @else
          <img class="card-img-top" src="{{asset('/img-default/post-default.webp')}}" alt="">
        @endif
      </div>

      <div class="row">
        
        <div class="col-7" >
          <p>Categoria: <strong>{{$post->categoria->name}}</strong></p>
          <p>Publicado: <strong>{{$post->updated_at->format('j F, Y')}}</strong></p>
        </div>
        
        <div class="col-5">
          
          @foreach ($post->tags as $tag)
            <label class="mr-2">
              @if($loop->index==0)
                Etiquetas:
              @endif

              {{$tag->name}}
            </label>          
          @endforeach
          <p>Autor: <strong>{{$post->user->name}}</strong></p>
        </div>
      </div>
      <div class="row">

        <div class="col">
          <p>{{$post->body}}</p>
        </div>
      </div>
      
    </div>
  </div>
  <hr>
  {!! Form::model($approved, ['route'=>['admin.approves.update',$approved], 'method'=>'put']) !!}

    <div class="row">
      <div class="col-2"></div>

      <div class="col-4">

        <div class="form-group">
          {!! Form::label('level', 'Nivel del curso', ['class'=>'form-control']) !!}
          <label class="mx-4">
            {!! Form::radio('level', 1) !!} Iniclal
            {!! Form::radio('level', 2) !!} Intermedio
            {!! Form::radio('level', 3) !!} Avanzado
          </label>
          @error('level')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

        <div class="form-group">
          {!! Form::label('title', '¿Tiene las fuentes enlazadas?', ['class'=>'form-control']) !!}
          {!! Form::radio('linksSource', 1) !!} Si
          {!! Form::radio('linksSource', 0) !!} No
          @error('title')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>

        <div class="form-group">
          {!! Form::label('title', '¿Tiene el titulo acorde al contenido?', ['class'=>'form-control']) !!}
          {!! Form::radio('title', 1) !!} Si
          {!! Form::radio('title', 0) !!} No
          @error('title')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>

        <div class="form-group">
          {!! Form::label('summary', '¿Tiene un extracto acorde al contenido?', ['class'=>'form-control']) !!}
          {!! Form::radio('summary', 1) !!} Si
          {!! Form::radio('summary', 0) !!} No
          @error('summary')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>

        <div class="form-group">
          {!! Form::label('examples', '¿Tiene ejemplos aclaratorios suficientes?', ['class'=>'form-control']) !!}
          {!! Form::radio('examples', 1) !!} Si
          {!! Form::radio('examples', 0) !!} No
          @error('examples')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>

        <div class="form-group">
          {!! Form::label('categoryRight', '¿Tiene un categoria correcta con el contenido?', ['class'=>'form-control']) !!}
          {!! Form::radio('categoryRight', 1) !!} Si
          {!! Form::radio('categoryRight', 0) !!} No
          @error('categoryRight')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>
          
      </div>

      <div class="col-4">
        <div class="form-group">
          {!! Form::label('timeToRead', 'Tiempo de lectura (minutos)', ['class'=>'form-control']) !!}
          {!! Form::number('timeToRead', null, ['class'=>'form-control']) !!}
          @error('timeToRead')
            <small class="text-danger">{{'Debe ser mayor que uno para aprobacion'}}</small>
          @enderror
        </div>
        <div class="form-group">
          {!! Form::label('understandable', '¿Es comprensible el texto?', ['class'=>'form-control']) !!}
          {!! Form::radio('understandable', 1) !!} Si
          {!! Form::radio('understandable', 0) !!} No
          @error('understandable')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>
        <div class="form-group">
          {!! Form::label('image', '¿Tiene una imagen apropiada?', ['class'=>'form-control']) !!}
          {!! Form::radio('image', 1) !!} Si
          {!! Form::radio('image', 0) !!} No
          @error('image')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>
        <div class="form-group">
          {!! Form::label('conclusion', '¿Tiene conclusiones o cierre apropiado?', ['class'=>'form-control']) !!}
          {!! Form::radio('conclusion', 1) !!} Si
          {!! Form::radio('conclusion', 0) !!} No
          @error('conclusion')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>
        <div class="form-group">
          {!! Form::label('tagRight', '¿Tiene al menos dos etiquetas acorde al contenido?', ['class'=>'form-control']) !!}
          {!! Form::radio('tagRight', 1) !!} Si
          {!! Form::radio('tagRight', 0) !!} No
          @error('tagRight')
            <small class="text-danger">{{'Debe ser true para aprobacion'}}</small>
          @enderror
        </div>
        
        <div class="form-group">
          {!! Form::label('approved', '¿Aprueba, rechaza o guarda para continuar?', ['class'=>'form-control']) !!}
          {!! Form::radio('approved', 0, null) !!} Cancela
          {!! Form::radio('approved', 1, null) !!} Graba temporalmente
          {!! Form::radio('approved', 2, null) !!} Aprueba
          {!! Form::radio('approved', 3, null) !!} Rechaza
        </div>
      </div>
      
    </div>  

    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <div class="form-group">
          {!! Form::label('feedback', 'Haga la devolución acorde', ['class'=>'form-control']) !!}
          {!! Form::textarea('feedback', null, ['class'=>'form-control','placeholder'=>'Ingrese su devolución']) !!}
          @error('feedback')
            <small class="text-danger">{{'Debe contener observaciones para ser rechazado.'}}</small>
          @enderror
        </div>

      </div>
    </div>
    
    <div class="row">
      <div class="col-5"></div>
      <div class="col-6">
        {!! Form::submit('Fin acción', ['class'=>'btn btn-success']) !!}
      </div>
    </div>

  {!! Form::close() !!}
@stop

@section('css')
  <style>
    .image-wrapper{
      position: relative;
      padding-bottom: 56.25%;
    }
    .image-wrapper img{
      position: absolute;
      object-fit: cover;
      width: 100%;
      height: 100%;
    }
  </style>
@stop

@section('js')
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>

    <script>
      $(document).ready( function() {
        $("#name").stringToSlug({
          setEvents: 'keyup keydown blur',
          getPut: '#slug',
          space: '-'
        });
      });

      ClassicEditor
        .create( document.querySelector( '#feedback' ) )
        .catch( error => {
            console.error( error );
        } );

    </script>
@stop