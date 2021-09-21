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
  <h1 class="text-3xl text-blue-600">Se ha rechazado su curso: </h1> 
  <a class="text-blue-800" href="">{{$post->name}}</a> 

  <h3>El editor de su curso: <strong>{{$post->editor->name}}</strong> recientemente ha rechazado su curso.
     El feedback que realizo nuestro editor dice:
  </h3>
  
  {!! $approve->feedback !!}
  <hr>
  <h3>Observaciones adicionales</h3>
  <ul>        
    <li>Nivel: @if($approve->level==1) Inicial @elseif($approve->level==2) Intermedio @elseif($approve->level==3) Avanzado @endif </li>
    <li>Tiempo de lectura: {{$approve->timeToRead}} minutos</li>
    <li>¿Posee citas con enlace a fuentes externas?: @if($approve->linksSource == 1) Si @else No @endif </li>
    <li>¿El post es comprensible?: @if($approve->understandable == 1) Si @else No @endif </li>
    <li>¿El post posee un titulo acorde al contenido?: @if($approve->title == 1) Si @else No @endif </li>
    <li>¿El post posee una imagen acorde al contenido?: @if($approve->image == 1) Si @else No @endif </li>
    <li>¿El post posee un extracto o resumen y es acorde al contenido?: @if($approve->summary == 1) Si @else No @endif </li>
    <li>¿El post posee conclusiones y es acorde al contenido?: @if($approve->conclusion == 1) Si @else No @endif </li>
    <li>¿El post posee ejemplos y son apropiados y suficientes?: @if($approve->examples == 1) Si @else No @endif </li>
    <li>¿El post posee etiquetas acordes y suficientes?: @if($approve->tagRight == 1) Si @else No @endif </li>
    <li>¿El post fue categorizado en forma adecuada con el contenido?: @if($approve->categoryRight == 1) Si @else No @endif </li>    
  </ul>
  <h3>Cualquier duda, por favor comuniquese con el editor de este post para mas aclaraciones, a su correo: {{$post->editor->email}}</h3>
  <h3>Muchas gracias por colaborar con este blog !</h3>
  <br>
  <h3>Atte: Jose Maria</h3>
  <h3>Administrador</h3>
</body>
</html>