<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveRequest;
use App\Models\Approve;
use App\Models\Post;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class ApproveController extends Controller
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.approve.index');
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
    $slug = $request['slug'];
    $post = Post::where('slug', $slug)->first();

    $post->update([
      'editor_id' => auth()->user()->id,

    ]);
    $approved = Approve::create([
      'post_id' => $post->id,
    ]);
    return redirect()->route('admin.approves.index')->with('success', 'Usted acepto editar el post. Gracias !!!');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($approved)
  {
    $post = Post::where('slug', $approved)->first();
    $botones = true;
    return view('admin.approve.show', compact('post', 'botones'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Post $approve)
  {
    $post = $approve;
    $approved = $post->approve;

    return view('admin.approve.edit', compact('post', 'approved'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ApproveRequest $request, Approve $approve)
  {
    if ($request->approved == 1) {

      // Graba
      $approve->update($request->all());
      return redirect()->route('admin.approves.index')->with('success', 'Ha grabado temporalmente su ediccion.');
    } elseif ($request->approved == 0) {

      //  Cancela
      $post = Post::where('id', $approve->post_id)->first();
      $post->update([
        'editor_id' => null,
      ]);
      $approve->delete();

      return redirect()->route('admin.approves.index')->with('info', 'Usted ha rechazado ser el editor del post');
    } elseif ($request->approved == 2) {

      // Aprueba
      $post = Post::where('id', $approve->post_id)->first();
      $post->update(['state_id' => 3]);

      return redirect()->route('admin.approves.index')->with('success', 'Ha aprobado el post en ediccion. Muchas Gracias !');
    }
    return [$request->all(), $approve];
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
  public function reject()
  {
    return redirect()->route('admin.approves.index')->with('info', 'Usted ha rechazado ser el editor del post');
  }
}
