<div>
  @if($total>=1)
    <div class="flex place-content-around">

      {{-- Cantidad de post --}}
      <div class="{{$postcount}} mt-4 ml-4 text-center">
        Cantidad de post: <strong>{{$total}}</strong>
        <div>
          <a wire:click="size(1)" class="@if($total<1)hidden @endif inline-flex hover:bg-gray-600 hover:text-white" href="#">1</a>
          <a wire:click="size(2)" class="@if($total<2)hidden @endif invisible sm:visible hover:bg-gray-600 hover:text-white" href="#">2</a>
          <a wire:click="size(3)" class="@if($total<3)hidden @endif invisible md:visible hover:bg-gray-600 hover:text-white" href="#">3</a>
          
          <a wire:click="size(4)" class="@if($total<4)hidden @endif invisible lg:visible hover:bg-gray-600 hover:text-white" href="#">4</a>
        </div>
      </div>

    </div>

    <div class="mt-10 text-center">
      <h1 class="md:uppercase md:text-3xl sm:text-xs font-bold inline-flex">
        {{$type}}     
      </h1>
    </div>
    <div class="@if($posPaginator==2)flex flex-col-reverse @endif">
      {{-- paginate navigation --}}      
      <div class="{{$postshow}} text-center mt-5">
        <div class="flex justify-center">
          @if($canPaginas<=5)
            @for($i = 1; $i <= 5; $i++)
              @if($canPaginas>=$i)
                <div  wire:click="goPage({{$i}})" class="@if($i==1 || $i==$canPaginas) rounded-full h-6 w-6  @endif cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm @if($curPage+1==$i) bg-blue-100 @endif">
                  {{$i}}
                </div>
              @endif          
            @endfor
          @else
            <div  wire:click="goPage(1)" class="cursor-pointer rounded-full h-6 w-6 border-2 border-gray-500 text-center ml-1 text-sm @if($curPage==0) bg-blue-100 @endif">
              1
            </div>
            @if($curPage<2)
              <div  wire:click="goPage(2)" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm @if($curPage==1) bg-blue-100 @endif">
                2
              </div>
              <div  wire:click="goPage(3)" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm">
                3
              </div>
              <div  wire:click="goPage(4)" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm">
                4
              </div>
            @elseif($curPage+1>$canPaginas-2)
              <div  wire:click="goPage({{$canPaginas-3}})" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm ">
                {{$canPaginas-3}}
              </div>
              <div  wire:click="goPage({{$canPaginas-2}})" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm ">
                {{$canPaginas-2}}
              </div>
              <div  wire:click="goPage({{$canPaginas-1}})" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm @if($curPage==$canPaginas-2) bg-blue-100 @endif">
                {{$canPaginas-1}}
              </div>
            @else
              <div  wire:click="goPage({{$curPage}})" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm">
                {{$curPage}}
              </div>
              <div  wire:click="goPage({{$curPage+1}})" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm bg-blue-100">
                {{$curPage+1}}
              </div>
              <div  wire:click="goPage({{$curPage+2}})" class="cursor-pointer border-2 border-gray-500 text-center ml-1 text-sm">
                {{$curPage+2}}
              </div>
            @endif

            <div  wire:click="goPage({{$canPaginas}})" class="cursor-pointer rounded-full h-6 w-6 border-2 border-gray-500 text-center ml-1 text-sm @if($curPage+1==$canPaginas) bg-blue-100 @endif">
              {{$canPaginas}}
            </div>
            
          @endif        
        </div>
      </div>

      {{-- infinite scroll --}}
      <div class="flex gap-2 mt-4 items-center container mx-auto ">
        {{-- flecha previo --}}
        <div wire:click="prev" class="@if($total==$cantidad) hidden @endif w-min cursor-pointer rounded-full bg-gray-200 hover:bg-gray-700 hover:text-white hover:rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
        </div>
        {{-- posts --}}
        <div class="flex flex-row gap-3">
          @for($k = $inicio; $k < $final; $k++)
            @if ($k>=$total)
              @php($i=$k-$total)
            @else
              @php($i=$k)
            @endif
            @php($post=$posts[$i])
            @php($ms = rand())

            <div class="{{$ancho}} mx-auto">
                @livewire('posts.show-card-carrusel-post',['post'=>$post, key('post-'.$ms) ])      
            </div>
          @endfor
        </div>

        {{-- flecha next --}}
        <div wire:click="next"@if($total==$cantidad) hidden @endif class="w-min cursor-pointer rounded-full bg-gray-200 hover:bg-gray-700 hover:text-white hover:rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
        </div>

      </div>
    </div>
    
  @else
    <div class="bg-gray-400 text-white text-center mt-4 ml-4">
      No hay posts para ver.
    </div>
  @endif
</div>