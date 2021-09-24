<?php

namespace App\Notifications;

use App\Models\Approve;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostNotification extends Notification
{
  public $post, $approve;

  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Post $post, Approve $approve)
  {
    $this->post = $post;
    $this->approve = $approve;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['database'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->line('The introduction to the notification.')
      ->action('Notification Action', url('/'))
      ->line('Thank you for using our application!');
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    if ($this->approve->approved == 3) {
      $name = 'Post rechazado';
    } elseif ($this->approve->approved == 1) {
      $name = 'Post aprobado';
    }

    return [
      'name' => $name,
      'post' => $this->post->id,
      'title' => $this->post->name,
      'autor' => $this->post->user->name,
      'editor' => $this->post->editor->name,
      'time' => Carbon::now()->diffForHumans(),
      'estado' => $this->post->state->name,
      'edicion' => $this->approve->approved,
    ];
  }
}
