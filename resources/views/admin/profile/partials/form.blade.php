<div class="container text-center">
  <div class="row">
    <div class="col">

      <div class="form-group">
        {!! Form::label('title', 'Como quiere ser llamado', ['class'=>'form-control']) !!}
        {!! Form::text('title', null, ['class'=>'form-control','placeholder'=>'Sr. Sra. Sta.']) !!}
        @error('title')
          <small class="text-danger">{{'Es importante que nos ayude a elegir.'}}</small>
        @enderror
      </div>
      
      <div class="form-group">
        {!! Form::label('biografia', 'Escriba algo sobre usted', ['class'=>'form-control']) !!}
        {!! Form::textarea('biografia', null, ['class'=>'form-control','placeholder'=>'Lo que quiera compartir sobre usted.']) !!}
        @error('biografia')
          <small class="text-danger">{{'Debe contener observaciones para ser rechazado.'}}</small>
        @enderror
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="form-group">
        {!! Form::label('website', 'Website que quiera compartir', ['class'=>'form-control']) !!}
        {!! Form::text('website', null, ['class'=>'form-control','placeholder'=>'https:// or www.']) !!}
        @error('website')
          <small class="text-danger">{{'Debe ser una url.'}}</small>
        @enderror
      </div>

      <div class="form-group">
        {!! Form::label('telegram', 'Telegram que quiera compartir', ['class'=>'form-control']) !!}
        {!! Form::text('telegram', null, ['class'=>'form-control','placeholder'=>'https:// or www.']) !!}
        @error('telegram')
          <small class="text-danger">{{'Debe ser una url.'}}</small>
        @enderror
      </div>

      <div class="form-group">
        {!! Form::label('facebook', 'facebook que quiera compartir', ['class'=>'form-control']) !!}
        {!! Form::text('facebook', null, ['class'=>'form-control','placeholder'=>'https:// or www.']) !!}
        @error('facebook')
          <small class="text-danger">{{'Debe ser una url.'}}</small>
        @enderror
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        {!! Form::label('instagram', 'Instagram que quiera compartir', ['class'=>'form-control']) !!}
        {!! Form::text('instagram', null, ['class'=>'form-control','placeholder'=>'https:// or www.']) !!}
        @error('instagram')
          <small class="text-danger">{{'Debe ser una url.'}}</small>
        @enderror
      </div>

      <div class="form-group">
        {!! Form::label('twitter', 'Twitter que quiera compartir', ['class'=>'form-control']) !!}
        {!! Form::text('twitter', null, ['class'=>'form-control','placeholder'=>'@nombre-de-usuario']) !!}
        @error('twitter')
          <small class="text-danger">{{'Debe ser un @nombre-de-usuario.'}}</small>
        @enderror
      </div>

      <div class="form-group">
        {!! Form::label('tiktok', 'tiktok que quiera compartir', ['class'=>'form-control']) !!}
        {!! Form::text('tiktok', null, ['class'=>'form-control','placeholder'=>'ingrese su usuario']) !!}
        @error('tiktok')
          <small class="text-danger">{{'Debe ser una url.'}}</small>
        @enderror
      </div>
    </div>

  </div>
</div>