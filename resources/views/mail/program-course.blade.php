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
  <h1 class="text-3xl text-blue-600">Se ha programado su curso para ser publicado: </h1> 
  <h2 class="text-blue-800" href=""><strong>{{$post->name}}</strong></h2>
  <h3 class="text-blue-800" href="">el día: {{$post->publicar}} (tentativo)</h3> 

  <h3>El responsable de publicar su curso: <strong>{{$post->publicador->name}}</strong> recientemente ha programado la fecha de publicacion de su curso. La misma se ha fijado para el {{$post->publicar}}.</h3>
  <h3>Recuerde que esta fecha es tentativa y puede sufrir modificaciones.Cuando finalmente se publique, le estaremos avisando.</h3>
  <h3>Muchas gracias por colaborar con este blog !</h3>
  <br>
  <h3>Atte: Jose Maria</h3>
  <h3>Administrador</h3>
</body>
</html>