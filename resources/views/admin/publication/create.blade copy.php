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
    $(document).ready(function () {
      var SITEURL = "{{url('https://miblog.test/')}}";
      var containerEl = document.getElementById('external-events');
      var checked=true;

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

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
      var calendar = $('#calendar').fullCalendar({
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        events: SITEURL + "/admin/publish/create",
        displayEventTime: true,
        editable: true,
        eventRender: function (event, element, view) {
          if (event.allDay === 'true') {
            event.allDay = true;
          } else {
            event.allDay = false;
          }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
          var title = prompt('Event Title:');
          if (title) {
            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

            $.ajax({
              url: SITEURL + "/admin/publish/create",
              data: 'title=' + title + '&start=' + start + '&end=' + end,
              type: "POST",
              success: function (data) {
                displayMessage("Added Successfully"); 
              }
            });

            calendar.fullCalendar('renderEvent',
              {
                title: title,
                start: start,
                end: end,
                allDay: allDay
              },
              true
            );
          }
          calendar.fullCalendar('unselect');
        },
        eventDrop: function (event, delta) {
          var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
          var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

          $.ajax({
            url: SITEURL + "/admin/publish/update',
            data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
            type: "POST",
            success: function (response) {
              displayMessage("Updated Successfully");
            }
          });
        },
        eventClick: function (event) {
          var deleteMsg = confirm("Do you really want to delete?");
          if (deleteMsg) {
            $.ajax({
              type: "POST",
              url: SITEURL + "/admin/publish/delete',
              data: "&id=" + event.id,
              success: function (response) {
                if(parseInt(response) > 0) {
                  $('#calendar').fullCalendar('removeEvents', event.id);
                  displayMessage("Deleted Successfully");
                }
              }
            });
          }
        },
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
        },
      });
    });    
    function displayMessage(message) {
      $(".response").html("<div class='success'>"+message+"</div>");
      setInterval(function() { $(".success").fadeOut(); }, 2000);
    }
 </script>
    

    
{{--     var calendar = $('#calendar').fullCalendar({
      headerToolbar: {
        left: 'prev,next today addEventButton',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: SITEURL + '/admin/publication/create',
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      eventRender: function (event, element, view) {
        if (event.allDay === 'true') {
          event.allDay = true;
        } else {
          event.allDay = false;
        }
      },
      selectable: true,
      selectHelper: true,
      select: function (start, end, allDay) {
        var title = prompt('Event Title:');
        if (title) {
          var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
          var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

          $.ajax({
            url: SITEURL + "/admin/publication/create",
            data: 'title=' + title + '&start=' + start + '&end=' + end,
            type: "POST",
            success: function (data) {
              displayMessage("Added Successfully"); 
            }
          });

          calendar.fullCalendar('renderEvent',
            {
              title: title,
              start: start,
              end: end,
              allDay: allDay
            },
            true
          );
        }
        calendar.fullCalendar('unselect');
      },
      drop: function(info) {
        // is the "remove after drop" checkbox checked?
        if (checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      },
      eventDrop: function (event, delta) {
        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

        $.ajax({
          url: SITEURL + '/admin/publication/update',
          data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
          type: "POST",
          success: function (response) {
            displayMessage("Updated Successfully");
          }
        });
      },
      eventClick: function (event) {
        var deleteMsg = confirm("Do you really want to delete?");
        if (deleteMsg) {
          $.ajax({
            type: "POST",
            url: SITEURL + '/admin/publication/delete',
            data: "&id=" + event.id,
            success: function (response) {
              if(parseInt(response) > 0) {
                $('#calendar').fullCalendar('removeEvents', event.id);
                displayMessage("Deleted Successfully");
              }
            }
          });
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
  function displayMessage(message) {
      $(".response").html("<div class='success'>"+message+"</div>");
      setInterval(function() { $(".success").fadeOut(); }, 2000);
    } 
--}}


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
