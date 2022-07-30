<?php

namespace App\Http\Livewire\Posts;

use App\Models\Categoria;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Maize\Markable\Models\Bookmark;

class ShowCarruselPost extends Component
{
  use WithPagination;

  public $type = 'Etiquetas';
  public $posts;
  public $cantidad = 1;
  public $curPage = 1;
  public $inicio = 0;
  public $postcount = '';
  public $postshow = '';
  public $posPaginator = 2; //abajo
  public $total, $final, $ancho, $canPaginas, $keys;

  public function mount()
  {
    /*
    if ($this->type == 'Guardados') {
      $posts = Post::where('state_id', 5)->with(['user', 'categoria', 'tags'])
        ->orderBy('publicar', 'desc');
    }

     if ($this->type == 'Mis Posts') {
      $posts = Post::where('state_id', 5)->with(['user', 'categoria', 'tags'])
        ->orderBy('publicar', 'desc')
        ->paginate(4);
    }
    if ($this->type == 'Autor') {
      $posts = Post::where('state_id', 5)->with(['user', 'categoria', 'tags'])->where('user_id', '=', $this->value->id)
        ->orderBy('publicar', 'desc')
        ->paginate(4);
    }
    
    }
    if ($this->type == 'Etiqueta') {
      $posts = $this->value->posts()->where('state_id', 5)->with(['user', 'categoria', 'tags'])
        ->orderBy('publicar', 'desc')
        ->paginate(4);
    } */
    $this->cantidad = session('cantidad-post', 1);

    if ($this->type == 'Etiquetas') {

      $posts = Tag::whereHasFavorite(auth()->user())
        ->join('posts', 'tag.posts.id', '=', 'posts.id')
        ->select('posts.*')
        ->get();
      dd('final ', $posts);
      /* $etiquetas->each(function ($item, $post) { */
      /* foreach ($etiquetas as $etq) {
        if (empty($posts)) {
          $posts = $etq->posts->where('state_id', 5);
        } else {
          $posts->merge($etq->posts->where('state_id', 5));
          //dd('2', $posts);
        }
      }; */
    }

    if ($this->type == 'Categorias') {
      $categorias = Categoria::whereHasFavorite(auth()->user())->get()->pluck('id');

      $this->posts = Post::whereIn('categoria_id', $categorias)
        ->where('state_id', 5)
        ->with('user', 'categoria', 'tags')
        ->orderBy('publicar', 'desc')
        ->get();
    }

    if ($this->type == 'Guardados') {
      $this->posts = Post::where('state_id', 5)
        ->with(['user', 'categoria', 'tags'])
        ->whereHasBookmark(auth()->user())
        ->orderBy('publicar', 'desc')
        ->get();
    }
  }

  public function change()
  {
    $this->resetPage();
  }

  public function render()
  {
    $this->setVariables($this->posts);

    return view('livewire.posts.show-carrusel-post', ['posts' => $this->posts]);
  }
  public function setVariables($posts)
  {
    $this->total = count($posts);
    $this->final = $this->inicio + $this->cantidad;
    $this->ancho = '';

    if ($this->cantidad == 2) {
      $this->ancho = 'w-1/2';
    } elseif ($this->cantidad == 3) {
      $this->ancho = 'w-1/3';
    } elseif ($this->cantidad == 4) {
      $this->ancho = 'w-1/4';
    }
    session(['cantidad-post' => $this->cantidad]);

    $this->canPaginas = $this->page($this->total);
    $this->curPage = $this->page($this->inicio);
  }
  private function page($nPos)
  {
    $page = intdiv($nPos, $this->cantidad);
    if ($page * $this->cantidad < $nPos) {
      $page++;
    }

    return $page;
  }
  public function size($cantidad)
  {
    $this->cantidad = $cantidad;
    return;
  }
  public function next()
  {
    if ($this->final >= $this->total) {
      $this->inicio = $this->final - $this->total;
    } else {
      $this->inicio = $this->final;
    }
  }
  public function prev()
  {
    if ($this->inicio < $this->cantidad) {
      $this->inicio = $this->total - $this->cantidad + $this->inicio;
    } else {
      $this->inicio = $this->inicio - $this->cantidad;
    }
  }
  public function post_count()
  {
    if ($this->postcount == '') {
      $this->postcount = 'hidden';
    } else {
      $this->postcount = '';
    }
  }
  public function show_page()
  {
    if ($this->postshow == '') {
      $this->postshow = 'hidden';
    } else {
      $this->postshow = '';
    }
  }
  public function goPage($page)
  {
    $this->inicio = ($page - 1) * $this->cantidad;
  }
}
