<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use App\Services\PostService;
use Livewire\Component;

class Calendario extends Component
{
  public $events = '';
  public $tasks = [];
  public $page;
  private $postService;

  public function boot(PostService $postService)
  {
    $this->postService = $postService;
  }
  public function mount($page)
  {
    $this->page = $page;
  }

  public function getevent()
  {
    $events = Post::select('id', 'name AS title', 'publicar AS start', 'state_id AS state')
      ->where('state_id', '=', 4)
      ->orWhere('state_id', '=', 5)
      ->get();

    return  json_encode($events);
  }

  public function eventReceive($event)
  {
    $this->postService->programar(Post::find($event['id']), date('Y-m-d', strtotime($event['start'])));
  }

  public function eventDrop($event, $oldEvent)
  {
    $this->postService->programar(Post::find($event['id']), date('Y-m-d', strtotime($event['start'])));
  }

  public function render()
  {
    /* $events = Event::select('id', 'title', 'start', 'state', 'editable')->get(); */
    $events = Post::select('id', 'name AS title', 'publicar AS start', 'state_id AS state')
      ->where('state_id', '=', 4)
      ->orWhere('state_id', '=', 5)
      ->get();
    $es = Post::select('id', 'name AS title', 'publicar AS start', 'state_id AS state')
      ->where('state_id', '=', 3)
      ->take(5)->get();

    foreach ($events as $event) {
      if ($event->state == 4) {
        $event->editable = true;
        $event->color = 'red';
      } elseif ($event->state == 5) {
        $event->editable = false;
        $event->color = 'green';
      }
    }
    $this->tasks = [];
    foreach ($es as $e) {
      $this->tasks[] = [
        'id' => $e->id,
        'title' => $e->title,
        'start' => $e->start,
        'state' => 3,
        'color' => 'red',
      ];
    }
    $this->events = [];
    $this->events = json_encode($events);
    return view('livewire.admin.calendario');
  }
  public function publicar()
  {
    $this->postService->publicar();
    return redirect($this->page);
  }
}
