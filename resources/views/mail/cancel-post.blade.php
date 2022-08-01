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
  <h1 class="text-3xl text-blue-600">Se ha cancelado su post titulado: </h1> 
  <a class="text-blue-800" href="">{{$post->name}}</a> 

  <h3>El administrador del blog: <strong>{{$admin->name}}</strong> ha decidido CANCELAR el post citado, por motivos que le explicaremos cuando se ponga en contacto con el administrador de este blog.</h3>
  <h3>Esperamos comprenda que, debido a su imposibilidad para revertir la situación generada, nos vimos obligados a cancelar la publicación. Esto lamentablemente, es parte de los inconvenientes que pueden ocurrir en la participación en este blog, tal como estan explicados en las normas de convivencia.</h3>
  <br>
  <h3>Muchas gracias por colaborar con este blog !</h3>
  <br>
  <h3>Atte: Jose Maria</h3>
  <h3>Administrador</h3>
</body>
</html>