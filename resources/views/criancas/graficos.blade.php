@extends('layouts.simple.master')
@section('title', 'Chart Widget')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)


@section('css')

<!-- Plugins css start-->
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/chartist.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/prism.css">
<!-- Plugins css Ends-->
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
  <h2>Gráficos <span>de evolução </span></h2>
@endsection

@section('breadcrumb-items')
  <li class="breadcrumb-item active">Crianças</li>
  <li class="breadcrumb-item">Perfil</li>
  <li class="breadcrumb-item">Dashboard</li>
  <li class="breadcrumb-item">Gráficos de evolução</li>
@endsection

@section('content')
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <!-- status widget Start-->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
                <h5>Relatórios semanais</h5>
            </div>
          </div>
          <div class="card-body pt-0 px-0">
            <div id="line-adwords"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- status widget Ends-->
  </div>
  <!-- Container-fluid Ends-->
@endsection

@section('script')
<!-- Plugins JS start-->
<script src="{{route('/')}}/assets/js/chart/chartist/chartist.js"></script>
<script src="{{route('/')}}/assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
<script src="{{route('/')}}/assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="{{route('/')}}/assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="{{route('/')}}/assets/js/prism/prism.min.js"></script>
<script src="{{route('/')}}/assets/js/clipboard/clipboard.min.js"></script>
<script src="{{route('/')}}/assets/js/counter/jquery.waypoints.min.js"></script>
<script src="{{route('/')}}/assets/js/counter/jquery.counterup.min.js"></script>
<script src="{{route('/')}}/assets/js/counter/counter-custom.js"></script>
<script src="{{route('/')}}/assets/js/custom-card/custom-card.js"></script>
<script>

//Valores do gráfico
var optionsLine = {
   yaxis: {
     show: false,
   },
  grid: {
    show: false,
  },

  xaxis: {
     axisBorder: {
          show: true,
          color: '#cccccc',
          height: 1,
          width: '100%',
          offsetX: 0,
          offsetY: 0
      },
  },

  chart: {
    height: 360,
    type: 'line',
    zoom: {
      enabled: false
    },
    toolbar: {
        show: false
    }
  },
  stroke: {
    curve: 'smooth',
    width: 4
  },
  colors: ['$ffdd55', '#FFAAAA', '#578fe6', '#4e4848', '#D7EEF4', '#abe66c', '#A47AAB'],
  series: [{
      name: "Tomar banho",
      data: {{$av1}}
    },
    {
      name: "Vestir e despir",
      data: {{$av2}}
    },
    {
      name: "Alimentacão",
      data: {{$av3}}
    },
    {
      name: "Higiene sanitária",
      data: {{$av4}}
    },
    {
      name: "Higiene pessoal",
      data: {{$av5}}
    },
    {
      name: "Descanso e sono",
      data: {{$av6}}
    },
    {
      name: "Brincar e jogar",
      data: {{$av7}}
    }
    ],
  subtitle: {
    text: 'Estatísticas',
    offsetY: 10,
    offsetX: 20
  },
  markers: {
    size: 6,
    strokeWidth: 0,
    hover: {
      size: 9
    }
  },
  labels: {!! Purify::clean($data) !!},
  legend: {
    position: 'top',
    horizontalAlign: 'right',
    offsetY: -20
  }
}
var chartLine = new ApexCharts(document.querySelector('#line-adwords'), optionsLine);
chartLine.render();

// ======
</script>
<!-- Plugins JS Ends-->
@endsection

