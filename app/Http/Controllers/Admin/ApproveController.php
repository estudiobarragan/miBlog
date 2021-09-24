<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveRequest;
use App\Mail\ApprovedPost;
use App\Mail\RejectPost;
use App\Models\Approve;
use App\Models\Post;
use App\Notifications\PostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;

class ApproveController extends Controller
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";

  public function  __construct()
  {
    $this->middleware('can:admin.approves.index')->only('index');
    $this->middleware('can:admin.approves.edit')->only('edit', 'update', 'show');
    $this->middleware('can:admin.approves.create')->only('store');
    $this->middleware('can:admin.approves.reject')->only('reject');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.approve.index');
  }

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

      // Aviso al autor de que fue aprobado
      $mail = new ApprovedPost($post);
      /* Mail::to($post->user->email)->send($mail); */
      Mail::to($post->user->email)->queue($mail);

      $post->user->notify(new PostNotification($post, $approve));

      return redirect()->route('admin.approves.index')->with('success', 'Ha aprobado el post en ediccion. Muchas Gracias !');
    } else {

      // Rechaza
      $post = Post::where('id', $approve->post_id)->first();
      $post->update(['state_id' => 1]);
      $approve->update($request->all());


      // Aviso al autor de que fue rechazado
      $mail = new RejectPost($post, $approve);
      Mail::to($post->user->email)->queue($mail);

      $post->user->notify(new PostNotification($post, $approve));
    }
    return redirect()->route('admin.approves.index')->with('success', 'Ha rechazado el post en ediccion. Muchas Gracias !');
  }

  public function reject()
  {
    return redirect()->route('admin.approves.index')->with('info', 'Usted ha rechazado ser el editor del post');
  }
}
