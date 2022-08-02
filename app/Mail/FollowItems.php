<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowItems extends Mailable
{
  use Queueable, SerializesModels;
  public $post, $frase;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($post, $frase)
  {
    $this->post = $post;
    $this->frase = $frase;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('mail.follow-item')
      ->subject('Post publicado');
  }
}
