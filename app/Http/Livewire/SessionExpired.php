<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SessionExpired extends Component
{
    public $session, $isLoggedIn;

    public function render()
    {
        return view('livewire.session-expired');
    }
    public function cerrarSession()
    {
      $this->session->forget('lastActivityTime');
      $cookie = cookie('intend', $this->isLoggedIn ? url()->current() : 'dashboard');
      auth()->logout();
    }
}
