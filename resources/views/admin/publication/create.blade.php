@extends('adminlte::page')

@section('title', 'Barragan y Asociados')

@section('content_header')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth'
      });
      calendar.render();
    });
  </script>

  <h1>Crear publicacion</h1>
  {{-- {{ route('admin.publication.index')}} --}}
  <a id='xbutton' class="btn btn-warning" onClick="addCarrito()" href="#">Terminar Programacion</a>
@stop

@section('content')
  @csrf
  <div id='external-events'>
    <p>
      <strong>Post a programar</strong>
    </p>
    @foreach($aprogramar as $ap)
      <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>Post {{$ap->id}}</div>
      </div>
    @endforeach

   {{--  <p>
      <input type='checkbox' id='drop-remove' />
      <label for='drop-remove'>remove after drop</label>
    </p> --}}
  </div>

  <div id='calendar-container'>
    <div id='calendar'></div>
  </div>
@stop

@section('css') 
   
  <style>
    html, body {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
      font-size: 14px;
    }

    #external-events {
      position: relative;
      z-index: 2;
      top: 250px;
      left: 0px;
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
      margin-left: 150px;
    }

    #calendar {
      max-width: 1100px;
      margin: 20px auto;
    }
  </style>
@stop

@section('js')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var calendarEl = document.getElementById('calendar');
    /* var checkbox = document.getElementById('drop-remove'); */
    var checked=true;

    

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
        left: 'prev,next today addEventButton',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: '/admin/ajax',
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function(info) {
        // is the "remove after drop" checkbox checked?
        if (checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      },
      customButtons: {
        addEventButton: {
          text: 'Graba',
          click: function() {
            var aData=[];
            calendar.getEvents().forEach(element => {
              aData.push([element.title,element.startStr]);
            });
            /* Envio Ajax al controlador para grabar, vuelve aviso ok */
            $.post('https://miblog.test/admin/ajax',
              { _token: $('meta[name=csrf-token]').attr('content'), 
                _method : 'PUT', 
                data : aData
              }, function(response){
                  if(response != '')
                    {
                      console.log(response);
                    }else{
                      console.log('error')
                  }
            });
          }
        }
      }

    });
    calendar.render();
  });
 </script>

{{-- esta funcion sirve como ejemplo de conexion ajax para put --}}
 <script>
  function addCarrito(){

    $(function(){
      
      $.post('https://miblog.test/admin/ajax',
        { _token: $('meta[name=csrf-token]').attr('content'), 
          _method : 'PUT', 
          data : "{['ok, no lo puedo creeer','algo']}"
        }, function(response){
            if(response != '')
              {
              console.log(response);
              }else{
              console.log('error')
            }

        });
    });
  };
</script>
@stop
