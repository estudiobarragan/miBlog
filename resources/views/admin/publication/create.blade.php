@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')

    <h1>Crear publicacion</h1>
@stop

@section('content')
  {{-- <div>
    <div class="row">
      <div class="col-2"></div>
      <div class="col-1 text-center bg-success border border-1 border-white">Lunes</div>
      <div class="col-1 text-center bg-success border border-1 border-white">Martes</div>
      <div class="col-1 text-center bg-success border border-1 border-white">Miercoles</div>
      <div class="col-1 text-center bg-success border border-1 border-white">Jueves</div>
      <div class="col-1 text-center bg-success border border-1 border-white">Viernes</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">Sabado</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">Domingo</div>
    </div>
    <div class="row">
      <div class="col-2"></div>
      <div class="col-1 text-center bg-success"></div>
      <div class="col-1 text-center bg-success"></div>
      <div class="col-1 text-center bg-success border border-1 border-white">1</div>
      <div class="col-1 text-center bg-success border border-1 border-white">2</div>
      <div class="col-1 text-center bg-success border border-1 border-white">3</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">4</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">5</div>
    </div>

    <div class="row">
      <div class="col-2"><br><br><br><br></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
    </div>

    <div class="row">
      <div class="col-2"></div>
      <div class="col-1 text-center bg-success border border-1 border-white">6</div>
      <div class="col-1 text-center bg-success border border-1 border-white">7</div>
      <div class="col-1 text-center bg-success border border-1 border-white">8</div>
      <div class="col-1 text-center bg-success border border-1 border-white">9</div>
      <div class="col-1 text-center bg-success border border-1 border-white">10</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">11</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">12</div>
    </div>
    <div class="row">
      <div class="col-2"><br><br><br><br></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
    </div>
    <div class="row">
      <div class="col-2"></div>
      <div class="col-1 text-center bg-success border border-1 border-white">13</div>
      <div class="col-1 text-center bg-success border border-1 border-white">14</div>
      <div class="col-1 text-center bg-success border border-1 border-white">15</div>
      <div class="col-1 text-center bg-success border border-1 border-white">16</div>
      <div class="col-1 text-center bg-success border border-1 border-white">17</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">18</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">19</div>
    </div>
    <div class="row">
      <div class="col-2"><br><br><br><br></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
    </div>
    <div class="row">
      <div class="col-2"></div>
      <div class="col-1 text-center bg-success border border-1 border-white">20</div>
      <div class="col-1 text-center bg-success border border-1 border-white">21</div>
      <div class="col-1 text-center bg-success border border-1 border-white">22</div>
      <div class="col-1 text-center bg-success border border-1 border-white">23</div>
      <div class="col-1 text-center bg-success border border-1 border-white">24</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">25</div>
      <div class="col-1 text-center bg-primary border border-1 border-white">26</div>
    </div>
    <div class="row">
      <div class="col-2"><br><br><br><br></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
    </div>
    <div class="row">
      <div class="col-2"></div>
      <div class="col-1 text-center bg-success border border-1 border-white">27</div>
      <div class="col-1 text-center bg-success border border-1 border-white">28</div>
      <div class="col-1 text-center bg-success border border-1 border-white">29</div>
      <div class="col-1 text-center bg-success border border-1 border-white">30</div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary"></div>
      <div class="col-1 text-center bg-primary"></div>
    </div>
    <div class="row">
      <div class="col-2"><br><br><br><br></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-success border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
      <div class="col-1 text-center bg-primary border border-1 border-white"></div>
    </div>
  </div> --}}
 
@stop

@section('css')
  <link rel="stylesheet" href="/css/admin_custom.css">
   
  {{-- <style>
    html, body {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
      font-size: 14px;
    }

    #external-events {
      position: fixed;
      z-index: 2;
      top: 20px;
      left: 20px;
      width: 150px;
      padding: 0 10px;
      border: 1px solid #ccc;
      background: #eee;
    }

    #external-events .fc-event {
      cursor: move;
      margin: 3px 0;
    }

    #calendar-container {
      position: relative;
      z-index: 1;
      margin-left: 200px;
    }

    #calendar {
      max-width: 1100px;
      margin: 20px auto;
    }
  </style> --}}
@stop

@section('js')

  {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var calendarEl = document.getElementById('calendar');
    var checkbox = document.getElementById('drop-remove');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText
        };
      }
    });

    // initialize the calendar
    // -----------------------------------------------------------------

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }
    });

    calendar.render();
  });
  </script> --}}
@stop