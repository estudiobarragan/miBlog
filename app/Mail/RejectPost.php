<?php

namespace App\Mail;

use App\Models\Approve;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectPost extends Mailable
{
  public $post, $approve;

  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(Post $post, Approve $approve)
  {
    $this->post = $post;
    $this->approve = $approve;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('mail.reject-course')
      ->subject('Curso rechazado');
  }
}
