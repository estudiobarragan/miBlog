<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuspendPost extends Mailable
{
  use Queueable, SerializesModels;

  public $post;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(Post $post)
  {
    $this->post = $post;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $admin = User::first();
    return $this->view('mail.suspend-post', compact('admin'))
      ->subject('Post suspendido');
  }
}
