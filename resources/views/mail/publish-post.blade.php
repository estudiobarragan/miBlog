<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Document</title>

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>
<body>
  <h1 class="text-3xl text-blue-600">Se ha publicado su curso: </h1> 
  <a class="text-blue-800" href="{{env('APP_URL')}}/posts/{{$post->slug}}"><strong>{{$post->name}}</strong></a>
  <h3 class="text-blue-800">el día: {{$post->publicar}} se ha publicado</h3> 

  <h3>El responsable de publicar su curso: <strong>{{$post->publicador->name}}</strong> le avisa que su post ha sido publicado con fecha {{$post->publicar}}.</h3>
  <h3>El mismo lo puede ver, haciendo click en el titulo del post en este mismo correo.</h3>
  <h3>Muchas gracias por colaborar con este blog !</h3>
  <br>
  <h3>Atte: Jose Maria</h3>
  <h3>Administrador</h3>
</body>
</html>