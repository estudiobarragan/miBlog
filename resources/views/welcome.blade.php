<x-app-layout>
  
</x-app-layout>

{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    @php
      $color='green';
      $alert = 'alert2';
    @endphp
  <body>

    <div class="container mx.auto">

      <x-alert :color="$color" class="mb-2">
        <x-slot name='title'>
          El dolor humano est.
        </x-slot>
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat, recusandae distinctio ad modi libero, doloremque sapiente officiis nobis ullam dicta nemo at ipsa nam odit aut eum optio tenetur quas?
      </x-alert>

      <x-alert2 color="blue" class="mb-4">
        <x-slot name='title'>
          El dolor humano est.
        </x-slot>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda illum cupiditate minus fugiat quae odit dolorem qui non repudiandae inventore ullam vitae consequuntur consequatur, quam doloribus commodi id incidunt? Odio.
      </x-alert2>

      <x-alert >
        <x-slot name='title'>
          No me gusta sin color ...
        </x-slot>
        Algo anda mal
      </x-alert2>

      <x-alert2 color="green" class="mb-4">
        <x-slot name='title'>
          No me gusta...
        </x-slot>
        Algo anda mal
      </x-alert2>

      <x-dynamic-component :component="$alert" color="blue">
        <x-slot name='title'>
          El dolor humano est.
        </x-slot>
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat, recusandae distinctio ad modi libero, doloremque sapiente officiis nobis ullam dicta nemo at ipsa nam odit aut eum optio tenetur quas?
      </x-dynamic-component>

    </div>


  </body>
</html>
 --}}