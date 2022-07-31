<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;

class ShowNotification extends Component
{
  public $notifications, $postReject, $approve;
  public $vermodal = 'invisible';
  public $vercomponente = 'visible';

  protected $listeners = ['refreshComponent' => '$refresh'];

  public function render()
  {
    $this->notifications = auth()->user()->unreadNotifications;
    if (auth()->user()->unreadNotifications->count() == 0) {
      $this->vercomponente = 'invisible';
    }

    return view('livewire.admin.show-notification');
  }
  public function motivos($id)
  {
    $this->postReject = Post::findOrFail($id);
    $this->approve = $this->postReject->approve;
    $this->vermodal = 'visible';
    return;
  }
  public function markread($notifie)
  {
    /* dd($notifie); */
    foreach (auth()->user()->unreadNotifications as $notify) {
      if ($notify->id == $notifie['id']) {
        $notify->markAsRead();
      }
    }
    $this->notifications = auth()->user()->unreadNotifications;
    $this->emit('refreshComponent');
    return;
  }
}
