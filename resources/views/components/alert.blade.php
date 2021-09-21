
<div {{$attributes->merge(['class'=>"bg-$color-100 border-l-4 border-$color-500 text-$color-700 p-4"])}} role="alert">
  <p class="font-bold">{{$title}}</p></p>
  <p>{{$slot}}</p>
  <strong>{{$prueba()}}</strong>
</div>