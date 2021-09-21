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
  <h1 class="text-3xl text-blue-600">Se ha aprobado su curso: </h1> 
  <a class="text-blue-800" href="">{{$post->name}}</a> 

  <h3>El editor de su curso: <strong>{{$post->editor->name}}</strong> recientemente ha aprobado su curso. Por lo tanto el mismo pasa para que el staff de publicaciones, lo coloque en calendario. Cuando esto ocurra, le estaremos avisando.</h3>
  <h3>Muchas gracias por colaborar con este blog !</h3>
  <br>
  <h3>Atte: Jose Maria</h3>
  <h3>Administrador</h3>
</body>
</html>