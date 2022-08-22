<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

class PostController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    /* if (request()->page) {
      $key = 'posts' . request()->page;
    } else {
      $key =  'posts';
    }

    if (Cache::has($key)) {
      $posts = Cache::get($key);
    } else {
      $posts = Post::where('state_id', 5)
        ->orderBy('publicar', 'desc')
        ->paginate(5);

      Cache::put($key, $posts);
    } */
    $type = 'Ultimos Posts';
    return view('posts.index', compact('type',));
  }

  public function misposts(int $id)
  {

    if ($id == 1) {
      $type = 'Guardados';
    } elseif ($id == 2) {
      $type = 'Categorias';
    } elseif ($id == 3) {
      $type = 'Etiquetas';
    } elseif ($id == 4) {
      $type = 'Autores';
    } elseif ($id == 5) {
      $type = 'Proximos';
    }
    return view('posts.misposts', compact('type'));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Post $post)
  {

    $this->authorize('published', $post);
    $similares = Post::where('categoria_id', $post->categoria_id)
      ->where('state_id', 5)
      ->where('id', '!=', $post->id)
      ->orderBy('publicar', 'desc')
      ->take(5)
      ->get();
    $role = '';
    foreach ($post->user->roles as $rol) {
      $role = $role . $rol->name . ' ';
    }
    $comments = $post->comments;
    return view('posts.show', compact('post', 'similares', 'role', 'comments'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
