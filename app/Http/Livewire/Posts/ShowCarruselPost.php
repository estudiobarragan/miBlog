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

  public $type = 'Guardados';
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
    $this->cantidad = session('cantidad-post', 1);

    if ($this->type == 'Etiquetas') {
      $tags = Tag::whereHasFavorite(auth()->user())
        ->pluck('id')->toArray();
      $this->posts = Post::select('id', 'slug', 'name', 'user_id', 'state_id', 'publicar', 'categoria_id', 'extract')
        ->leftJoin('taggables', 'taggables.taggable_id', '=', 'posts.id')
        ->leftJoin('tags', 'taggables.tag_id', '=', 'tags.id')
        ->whereIn('tags.id', $tags)
        ->where('state_id', 5)
        ->select('posts.*')
        ->distinct()
        ->get();
    }

    if ($this->type == 'Categorias') {
      $categorias = Categoria::whereHasFavorite(auth()->user())->get()->pluck('id');

      $this->posts = Post::select('id', 'slug', 'name', 'user_id', 'state_id', 'publicar', 'categoria_id', 'extract')
        ->whereIn('categoria_id', $categorias)
        ->where('state_id', 5)
        ->with('user', 'categoria', 'tags')
        ->orderBy('publicar', 'desc')
        ->get();
    }

    if ($this->type == 'Guardados') {
      $this->posts = Post::select('id', 'slug', 'name', 'user_id', 'state_id', 'publicar', 'categoria_id', 'extract')
        ->where('state_id', 5)
        ->with(['user', 'categoria', 'tags'])
        ->whereHasBookmark(auth()->user())
        ->orderBy('publicar', 'desc')
        ->get();
    }

    if ($this->type == 'Proximos') {
      $this->posts = Post::select('id', 'slug', 'name', 'user_id', 'state_id', 'publicar', 'categoria_id', 'extract')
        ->where('state_id', 4)
        ->with(['user', 'categoria', 'tags'])
        ->where('publicar', '>=', today())
        ->where('publicar', '<=', date_add(today(), date_interval_create_from_date_string("8 days")))
        ->orderBy('publicar', 'asc')
        ->get();
    }

    if ($this->type == 'Autores') {
      $autores = User::whereHasFavorite(auth()->user())->get()->pluck('id');

      $this->posts = Post::select('id', 'slug', 'name', 'user_id', 'state_id', 'publicar', 'categoria_id', 'extract')
        ->whereIn('user_id', $autores)
        ->where('state_id', 5)
        ->with('user', 'categoria', 'tags')
        ->orderBy('publicar', 'desc')
        ->get();
    }
    $cantidad = $this->posts->count();
    if ($cantidad > 0 && $cantidad < $this->cantidad) {
      $this->cantidad = $cantidad;
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
