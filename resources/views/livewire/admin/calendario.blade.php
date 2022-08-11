<div class="container-fluid">
  <div class="row">
    <div id='external-events' class="col-2">
      <p class="text-center text-primary">
        <strong>Post a programar</strong>
      </p>
      
      @foreach ($this->tasks as $task)
          <div  data-event='@json(['id' => $task['id'], 'title' => $task['title'], 'color'=>$task['color']])' class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event overflow-hidden'>
              <div class='fc-event-main'>{{ $task['title']}}</div>
          </div>
      @endforeach

      <a href="#" wire:click="publicar" class="btn btn-success btn-block mt-5">Publicar</a>
    </div>

    <div id='calendar-container' wire:ignore class="col-10">
      <div id='calendar'></div>
    </div>
  </div>
</div>

  @push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src='fullcalendar/lang/es.js'></script> 
    <script>
        document.addEventListener('livewire:load', function() {
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;
            var containerEl = document.getElementById('external-events');
            var calendarEl = document.getElementById('calendar');
            var data =   @this.events;

            // initialize the external events
            // -----------------------------------------------------------------
            new Draggable(containerEl, {
              itemSelector: '.fc-event'
            });

            var calendar = new Calendar(calendarEl, {
            timeZone: 'local',
            events: JSON.parse(data),
            locale: 'es',
            editable: true,
            selectable: true,
            displayEventTime: false,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function(info) {
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            },
            eventReceive: info => @this.eventReceive(info.event),
            eventDrop: info => @this.eventDrop(info.event, info.oldEvent),
            loading: function(isLoading) {
                    if (!isLoading) {
                      console.log(isLoading);
                        // Reset custom events
                        this.getEvents().forEach(function(e){
                            if (e.source === null) {
                                e.remove();
                            }
                        });
                    }
                }
            });
            calendar.render();
            @this.on(`refreshCalendar`, () => {
                calendar.refetchEvents()
            });
        });
    </script>
  @endpush

  @push('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />

    <style>

    html, body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        font-size: 14px;
    }

    #external-events {
        /* position: fixed; */
        z-index: 2;
        top: 20px;
        left: 0px;
        width: 150px;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #eee;
    }

    .demo-topbar + #external-events { /* will get stripped out */
        top: 60px;
    }

    #external-events .fc-event {
        cursor: move;
        margin: 3px 0;
    }

    #calendar-container {
        /* position: relative; */
        z-index: 1;
        /* margin-left: 200px; */
    }

    #calendar {
        max-width: 1100px;
        margin: 20px auto;
    }

    </style>
  @endpush
