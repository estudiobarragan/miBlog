<div>
  <div class="row">
    <div class="col info-box">
      <span class="info-box-icon"><i class="far fa-flag"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Totales</span>
        <span class="info-box-number">{{$posts->count()}}</span>
      </div>
    </div>
    <div class="col info-box bg-primary">
      <span class="info-box-icon"><i class="far fa-flag"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Borrador</span>
        <span class="info-box-number">{{$posts->where('state_id',1)->count()}}</span>
      </div>
    </div>
    <div class="col info-box bg-warning">
      <span class="info-box-icon"><i class="far fa-flag"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Edicion</span>
        <span class="info-box-number">{{$posts->where('state_id',2)->count()}}</span>
      </div>
    </div>
    <div class="col info-box bg-danger">
      <span class="info-box-icon"><i class="far fa-flag"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Programacion</span>
        <span class="info-box-number">{{$posts->where('state_id',3)->count()}}</span>
      </div>
    </div>
    <div class="col info-box bg-info">
      <span class="info-box-icon"><i class="far fa-flag"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Calendario</span>
        <span class="info-box-number">{{$posts->where('state_id',4)->count()}}</span>
      </div>
    </div>

    <div class="col info-box bg-success">
      <span class="info-box-icon"><i class="far fa-flag"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Publicado</span>
        <span class="info-box-number">{{$posts->where('state_id',5)->count()}}</span>
      </div>
    </div>
  </div>
  {{-- poner otro grafico general --}}
  <div class="row align-middle">
    <div class="col-5">
      <canvas id="doughtnutChart" width="200" height="125"></canvas>
    </div>
    <div class="col align-middle">
      <canvas id="barChart" width="200" height="125"></canvas>
    </div>

  </div>

  <div class="row">
    <div class="col info-box">
      <span class="info-box-icon"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Registrados</span>
        <span class="info-box-number">{{$users->count()}}</span>
      </div>
    </div>
    <div class="col info-box bg-primary">
      <span class="info-box-icon"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Autores</span>
        <span class="info-box-number">{{$cant_aut}}</span>
      </div>
    </div>
    <div class="col info-box bg-warning">
      <span class="info-box-icon"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Editores</span>
        <span class="info-box-number">{{$cant_edt}}</span>
      </div>
    </div>
    <div class="col info-box bg-danger">
      <span class="info-box-icon"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Publicadores</span>
        <span class="info-box-number">{{$cant_pub}}</span>
      </div>
    </div>
    <div class="col info-box bg-info">
      <span class="info-box-icon"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Lectores</span>
        <span class="info-box-number">{{$cant_lec}}</span>
      </div>
    </div>

    <div class="col info-box bg-success">
      <span class="info-box-icon"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Administradores</span>
        <span class="info-box-number">{{$cant_adm}}</span>
      </div>
    </div>
  </div>

  {{-- Grafico lineal --}}
  <div class="row items-center">
    <div class="col-2"></div>
    <div class="col-8">
      <canvas id="lineChart" width="200" height="125"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  /* Post creados en el tiempo */
  new Chart(document.getElementById("lineChart"), {
    
    type: 'line',
      data: {
        labels: ['nov-21','dic-21','ene-22','feb-22','mar-22','abr-22','may-22','jun-22','jul-22','ago-22'],
        datasets: [{ 
            data: [8,11,16,16,17,21,23,32,78,247],
            label: "Creados",
            borderColor: "#3e95cd",
            fill: false
          }]
      },
      options: {
        title: {
          display: true,
          text: 'Post creados por dia en forma acumulada'
        }
      }
    });

  /* Post publicados */
  new Chart(document.getElementById("doughtnutChart"), {
    type: 'doughnut',
      data: {
        labels: ["Borrador", "Edicion", "Programacion", "Calendario", "Publicados"],
        datasets: [
          {
            label: "Post publicados",
            backgroundColor: ["#1c39bb", "#ffae42","#b0000d","#00868b","#006b3c"],
            data: [{{$posts->where('state_id',1)->count()}},{{$posts->where('state_id',2)->count()}},
                  {{$posts->where('state_id',3)->count()}},{{$posts->where('state_id',4)->count()}},
                  {{$posts->where('state_id',5)->count()}}]
          }
        ]
      },
      options: {
        legend: { display: true },
        title: {
          display: true,
          text: "Post publicados segun estado."
        }
      }
  });

  /* Usuarios registrados */
  new Chart(document.getElementById("barChart"), {
    type: 'bar',
        data: {
          labels: ["Autores", "Editores", "Publicadores", "Lectores", "Administradores"],
          datasets: [
            {
              label: "Usuarios registrados: {{$users->count()}}",
              backgroundColor: ["#1c39bb", "#ffae42","#b0000d","#00868b","#006b3c"],
              data: [{{$cant_aut}},{{$cant_edt}},{{$cant_pub}},{{$cant_lec}},{{$cant_adm}}]
            }
          ]
        },
        options: {
          legend: { display: false },
          title: {
            display: true,
            text: 'Usuarios registrados segun roles'
          }
        }
    });
</script>