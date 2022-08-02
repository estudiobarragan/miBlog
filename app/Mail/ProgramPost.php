<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProgramPost extends Mailable
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
    return $this->view('mail.program-course')
      ->subject('Post con fecha de publicacion programada');
  }
}