<div class="form-group">
  {!! Form::label('name', 'Nombre') !!}
  {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Ingrese el nombre del post']) !!}
  @error('name')
    <small class="text-danger">{{$message}}</small>
  @enderror
</div>

<div class="form-group">
  {!! Form::label('slug', 'Slug') !!}
  {!! Form::text('slug', null, ['class'=>'form-control','placeholder'=>'Ingrese el slug del post','readonly' ]) !!}
  @error('slug')
    <small class="text-danger">{{$message}}</small>
  @enderror
</div>

<div class="form-group">
  {!! Form::label('category_id', 'Categoria') !!}
  {!! Form::select('category_id', $categories, null, ['class'=>'form-control']) !!}
  @error('category_id')
    <small class="text-danger">{{$message}}</small>
  @enderror
</div>

<div class="form-group">
  <p class="font-weight-bold" >Etiquetas</p>

  @foreach($tags as $tag)
    <label class="mr-2">
      {!! Form::checkbox('tags[]', $tag->id, null) !!}
      {{$tag->name}}
    </label>
  @endforeach
  @error('tags')
    <br>
    <small class="text-danger">{{$message}}</small>
  @enderror
</div>

<div class="form-group">
  <p class="font-weight-bold" >Estado del post</p>
  <label>
    {!! Form::radio('state_id', 1, true) !!}
    Borrador
  </label>
  <label>
    {!! Form::radio('state_id', 2) !!}
    A edición
  </label>
</div>

<div class="row mb-3">
  <div class="col">
    <div class="image-wrapper">
      @isset($post->image)
        <img id="picture" src="{{ Storage::url($post->image->url) }}" alt="">
      @else
        <img id="picture" src="{{asset('/img-default/post-default.webp')}}" alt="">
      @endisset
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('file', 'Imagen del post') !!}
      {!! Form::file('file', ['class'=>'form-control-file','accept'=>'image/*']) !!}

      @error('file')
        <small class="text-danger">{{$message}}</small>
      @enderror
    </div>

    <p class="mt-2">Condiciones del tipo de archivo, maximo tamaño y peso en kb. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum iste nam nemo quos, ex quidem dolores aliquid! Dolorum porro voluptatibus magni rerum blanditiis quidem et numquam accusamus? Necessitatibus, blanditiis in?</p>
  </div>
</div>

<div class="form-group">
  {!! Form::label('extract', 'Extracto') !!}
  {!! Form::textarea('extract', null, ['class'=>'form-control']) !!}
  @error('extract')
    <small class="text-danger">{{$message}}</small>
  @enderror
</div>

<div class="form-group">
  {!! Form::label('body', 'Cuerpo del post') !!}
  {!! Form::textarea('body', null, ['class'=>'form-control']) !!}
  @error('body')
    <small class="text-danger">{{$message}}</small>
  @enderror
</div>