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
  <h1 class="text-3xl text-blue-600">Se ha suspendido su post titulado: </h1> 
  <a class="text-blue-800" href="">{{$post->name}}</a> 

  <h3>El administrador del blog: <strong>{{$admin->name}}</strong> ha decidido SUSPENDER el post citado.</h3>
  <h3>Para conocer los motivos, le sugerimos ponerse en cotacto con el administrador y solucionar de ser posible los aspectos que requieren de su intervención, a fin de volver a publicar dicho post. Como comprenderá esta situación es delicada y requiere de la mayor celeridad para encontrar una solución y evitar tener que cancelar dicha publicación.</h3>
  <h3>Esperamos establecer pronto contacto.</h3><br>
  <h3>Muchas gracias por colaborar con este blog !</h3>
  <br>
  <h3>Atte: Jose Maria</h3>
  <h3>Administrador</h3>
</body>
</html>