@php
  $nav_links=[
    [
      'name' => 'Dashboard',
      'route'=> 'dashboard',
      'active' => request()->routeIs('dashboard'),
    ],
    [
      'name' => 'Prueba',
      'route'=> '#',
      'active' => request()->routeIs('prueba'),
    ],
  ]
@endphp

<nav class="bg-gray-100 shadow fixed top-0 w-full z-50" x-data="{ open: false }" >
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">

      <!-- Mobile menu button-->
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <button x-on:click="open=true" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <!--
            Icon when menu is closed.

            Heroicon name: outline/menu

            Menu open: "hidden", Menu closed: "block"
          -->
          <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <!--
            Icon when menu is open.

            Heroicon name: outline/x

            Menu open: "block", Menu closed: "hidden"
          -->
          <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">

        {{-- Logotipo --}}
        <a href="/" class="flex-shrink-0 flex items-center">
          <img class="block lg:hidden h-8 w-auto rounded-full" src="{{asset('img-default/byaLogo.png')}}" alt="estudio barragan">
          <img class="hidden lg:block h-10 w-auto" src="{{asset('img-default/byaLogo.png')}}" alt="estudio barragan">
          <p class="hidden lg:block text-blue-700 font-extrabold">BARRAGAN<br><br></p>
          <p class="hidden lg:block text-blue-700 font-extrabold  -ml-24 pl-1 mt-4">& Asociados</p> 
        </a>

        {{-- Menu propiamente dicho lgS--}}
        <div class="hidden sm:block sm:ml-6">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            {{-- <a href="#" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Dashboard</a> --}}

            @auth
              <a href="{{route('posts.misposts',1)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
                {{__('Mis post')}}
              </a>
              <a href="{{route('posts.misposts',2)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
                {{__('Mis categorias')}}
              </a>
              <a href="{{route('posts.misposts',3)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
                {{__('Mis etiquetas')}}
              </a>
              <a href="{{route('posts.misposts',4)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
                {{__('Mis autores')}}
              </a>
            @endauth
           
          </div>
        </div>
      </div>

      @auth
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        
          {{-- Boton notificacion --}}
          {{-- <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
            <span class="sr-only">View notifications</span>
            <!-- Heroicon name: outline/bell -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
          </button> --}}
          <div class="ml-3 relative" x-data="{ open: false }">
            <div x-on:click="open = true" type="button">
              <button type="button" class="text-md text-gray-600 text-2xl relative">
                @if(count(auth()->user()->unreadNotifications))
                  <span class="w-4 h-4 rounded-full absolute left-4 bottom-3 leading text-xs bg-red-500 text-white">
                    {{count(auth()->user()->unreadNotifications)}}
                  </span>
                @endif
                <!-- Heroicon name: outline/bell -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
              </button>

              <!-- Notificaciones dropdown -->
              <div  x-cloak x-show="open" x-on:click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-xl py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <!-- Active: "bg-gray-100", Not Active: "" -->
                @foreach(auth()->user()->unreadNotifications as $notification)
                  <div class="flex">
                    <a href="{{route('admin.home')}}" class="block px-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">
                      {{$notification->data['name']}}
                    </a>
                    <div class="text-sm text-gray-400 m-auto ">
                      {{ $notification->created_at->diffForHumans()}}
                    </div>

                    <hr>
                  </div>
                @endforeach

              </div>
            </div>
          </div>
          

          <!-- Profile dropdown -->
          <div class="ml-3 relative" x-data="{ open: false }">
            <div>
              <button x-on:click="open = true" type="button" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full" src="{{auth()->user()->profile_photo_url}}" alt="">
              </button>
            </div>

            <!--
              Dropdown menu, show/hide based on menu state.

              Entering: "transition ease-out duration-100"
                From: "transform opacity-0 scale-95"
                To: "transform opacity-100 scale-100"
              Leaving: "transition ease-in duration-75"
                From: "transform opacity-100 scale-100"
                To: "transform opacity-0 scale-95"
            -->
            <div x-cloak x-show="open" x-on:click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <!-- Active: "bg-gray-100", Not Active: "" -->
              <a href="{{route('profile.show')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Tu perfil</a>
              @can('admin.home')
                <a href="{{route('admin.home')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Administracion</a>
              @endcan
              <hr class="mt-2">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" 
                  onclick="event.preventDefault(); this.closest('form').submit();"tabindex="-1" id="user-menu-item-2">
                  Salir
                </a>
              </form>

            </div>
          </div>
        </div>     
      @else
        <div>
          <a href="{{route( 'login' )}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-mediu m">
            Ingresar
          </a>
          <a href="{{route( 'register' )}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-mediu  m">
            Registrar
          </a>
        </div>   
      @endauth

    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div x-show="open" x-on:click.away="open=false" class="sm:hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      {{-- <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Dashboard</a> --}}
 
      @auth
        {{-- <a href="#" class="text-gray-600 hover:bg-gray-100 hover:text-gray-800 block px-3 py-2 rounded-md text-base font-medium">
          {{__('Mis post')}}
        </a> --}}

        <a href="{{route('posts.misposts',1)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
          {{__('Mis post')}}
        </a>
        <a href="{{route('posts.misposts',2)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
          {{__('Mis categorias')}}
        </a>
        <a href="{{route('posts.misposts',3)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
          {{__('Mis etiquetas')}}
        </a>
        <a href="{{route('posts.misposts',4)}}" class="text-gray-600 hover:bg-gray-200 hover:text-gray-700 hover:border hover:border-b-gray-600 px-3 py-2 rounded-md text-sm font-medium">
          {{__('Mis autores')}}
        </a>
        @endauth
      
    </div>
  </div>
</nav>


