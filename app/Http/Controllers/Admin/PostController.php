<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Approve;
use App\Models\Categoria;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

  public function  __construct()
  {
    $this->middleware('can:admin.posts.index')->only('index');
    $this->middleware('can:admin.posts.edit')->only('edit', 'update');
    $this->middleware('can:admin.posts.create')->only('create', 'store');
    $this->middleware('can:admin.posts.destroy')->only('destroy');
  }

  public function index()
  {
    $posts = Post::all();
    return view('admin.posts.index', compact('posts'));
  }

  public function create()
  {
    $categories = Categoria::pluck('name', 'id');
    $tags = Tag::all();

    return view('admin.posts.create', compact('categories', 'tags'));
  }


  public function store(PostRequest $request)
  {
    /* $post = Post::create($request->all()); */
    /* return Storage::put('img', $request->file('file')); */

    $post = Post::create([
      'name' => $request->name,
      'slug' => $request->slug,
      'state_id' => $request->state_id,
      'categoria_id' => $request->category_id,
      'extract' => $request->extract,
      'body' => $request->body
    ]);

    if ($request->file('file')) {
      $url = Storage::put('img', $request->file('file'));
      $post->image()->create([
        'url' => $url,
      ]);
    }
    if ($request->tags) {
      $post->tags()->attach($request->tags);
    }

    Cache::flush();

    $request->file('file');


    return redirect()->route('admin.posts.index')->with('success', 'Post agregado satisfactoriamente');
  }

  public function edit(Post $post)
  {
    $this->authorize('author', $post);
    $categories = Categoria::pluck('name', 'id');
    $tags = Tag::all();
    return view('admin.posts.edit', compact('post', 'categories', 'tags'));
  }

  public function update(PostRequest $request, Post $post)
  {
    $this->authorize('author', $post);


    $post->update([
      'name' => $request->name,
      'slug' => $request->slug,
      'state_id' => $request->state_id,
      'categoria_id' => $request->category_id,
      'extract' => $request->extract,
      'body' => $request->body
    ]);

    // Si el estado es edicion y tiene un campo editor que no existe en la DB, se coloca null en su lugar
    if ($request->state_id == 2) {
      $editor = User::where('id', $post->user)->first();
      if ($editor == null || !$editor->hasRole('Editor')) {
        $post->update(['editor_id' => null]);

        // si existe un registro approve previo, se borra, dado que el editor no existe
        $approve = Approve::where('post_id', $post->id)->first();

        if (!($approve === null)) {
          $approve->delete();
        }
      }
    }

    if ($request->file('file')) {
      $url = Storage::put('img', $request->file('file'));
      if ($post->image) {
        Storage::delete($post->image->url);
        $post->image()->update([
          'url' => $url,
        ]);
      } else {
        $post->image()->create([
          'url' => $url,
        ]);
      }
    }
    if ($request->tags) {
      $post->tags()->sync($request->tags);
    }
    $request->file('file');

    Cache::flush();

    return redirect()->route('admin.posts.index')->with('success', 'Post actualizado satisfactoriamente');
  }

  public function destroy(Post $post)
  {
    $this->authorize('author', $post);

    $post->delete();

    Cache::flush();

    return redirect()->route('admin.posts.index')->with('success', 'Post eliminado satisfactoriamente');
  }
}
