<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Livewire\WithPagination;

class PostController extends Controller
{
  use WithPagination;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    if (request()->page) {
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
    }

    return view('posts.index', compact('posts',));
    /* return view('posts.index'); */
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
      ->latest('id')
      ->take(5)
      ->get();

    return view('posts.show', compact('post', 'similares'));
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

  public function categoria(Categoria $categoria)
  {
    $posts = $categoria->posts()
      ->where('state_id', 5)
      ->orderBy('publicar', 'desc')
      ->paginate(5);

    return view('posts.categoria', compact('posts', 'categoria'));
  }
  public function tag(Tag $tag)
  {
    $posts = $tag->posts()
      ->where('state_id', 5)
      ->orderBy('publicar', 'desc')
      ->paginate(5);

    return view('posts.tag', compact('posts', 'tag'));
  }
  public function user(User $user)
  {
    $posts = $user->posts()
      ->where('state_id', 5)
      ->orderBy('publicar', 'desc')
      ->paginate(5);

    return view('posts.user', compact('posts', 'user'));
  }
}
