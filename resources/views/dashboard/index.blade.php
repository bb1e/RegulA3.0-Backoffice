@extends('layouts.simple.master')
@section('title', 'Homepage')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/prism.css">
    <!-- Plugins css start-->
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/chartist.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/date-picker.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2>Página <span>Principal</span></h2>
@endsection

@section('breadcrumb-items')
   <li class="breadcrumb-item">Página Principal</li>
@endsection

@section('content')

<div class="container-fluid general-widget">
    <div class="row">

      <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-primary o-hidden">
          <div class="b-r-4 card-body">
            <div class="media static-top-widget">
              <div class="align-self-center text-center"><i data-feather="user"></i></div>
              <div class="media-body"><span class="m-0 text-white">Utilizadores</span>
                <h4 class="mb-0 counter">{{$qtdUsers['qtdTotal']}}</h4><i class="icon-bg" data-feather="user"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-warning o-hidden">
          <div class="b-r-4 card-body">
            <div class="media static-top-widget">
              <div class="align-self-center text-center">
                <div class="text-white i" data-feather="user-check"></div>
              </div>
              <div class="media-body"><span class="m-0 text-white">Perfis de crianças</span>
                <h4 class="mb-0 counter text-white">{{$qtdUsers['qtdCriancas']}}</h4><i class="icon-bg" data-feather="user-check"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-secondary o-hidden">
          <div class="b-r-4 card-body">
            <div class="media static-top-widget">
              <div class="align-self-center text-center"><i data-feather="trending-up"></i></div>
              <div class="media-body"><span class="m-0">Estratégias</span>
                <h4 class="mb-0 counter">{{$qtdEstrategias['qtdTotal']}}</h4><i class="icon-bg" data-feather="trending-up"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-info o-hidden">
          <div class="b-r-4 card-body">
            <div class="media static-top-widget">
              <div class="align-self-center text-center">
                <div class="text-white i" data-feather="clipboard"></div>
              </div>
              <div class="media-body"><span class="m-0 text-white">Relatórios semanais</span>
                <h4 class="mb-0 counter text-white">{{$qtdRelatorios['qtdTotal']}}</h4><i class="icon-bg" data-feather="clipboard"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>



<!-- Container-fluid starts-->
<div class="container-fluid">
   <div class="row">

    <!-- Tipo de utilizadores -->
    <div class="col-xl-4 xl-100 box-col-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-9">
                  <h5>Tipo de utilizadores</h5>
                </div>
                <div class="col-3 text-right"><i class="text-muted" data-feather="user"></i></div>
              </div>
            </div>
            <div class="card-body r-dount">
              <div id="chart1"> </div>
            </div>
          </div>
     </div>


    <!-- Relatorios semanais do ano por mes -->
      <div class="col-xl-4 xl-100 box-col-12">
         <div class="card">
            <div class="card-header">
               <h5>Quantidade de relatórios semanais p/mês</h5>
               <span>Total de relatórios semanais este ano: <b>{{$qtdRelatorios['qtdTotalAno']}}</b></span>
            </div>
            <div class="card-body chart-block">
               <div class="flot-chart-container">
                  <div class="flot-chart-placeholder" id="bar-line-chart-morris"></div>
               </div>
            </div>
         </div>
      </div>



      <!-- Feedback por área de ocupação -->
      <div class="col-xl-4 xl-100 box-col-12">
         <div class="card">
            <div class="card-header no-border">
               <h5>Feedback por área de ocupação</h5>
            </div>
            <div class="card-body p-0">
               <div class="radial-default">
                  <div id="feedbackcirclechart"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script src="{{route('/')}}/assets/js/typeahead/handlebars.js"></script>
<script src="{{route('/')}}/assets/js/typeahead/typeahead.bundle.js"></script>
<script src="{{route('/')}}/assets/js/typeahead/typeahead.custom.js"></script>
<script src="{{route('/')}}/assets/js/typeahead-search/handlebars.js"></script>
<script src="{{route('/')}}/assets/js/typeahead-search/typeahead-custom.js"></script>
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
<script src="{{route('/')}}/assets/js/notify/bootstrap-notify.min.js"></script>
<script src="{{route('/')}}/assets/js/dashboard/default.js"></script>
<script src="{{route('/')}}/assets/js/datepicker/date-picker/datepicker.js"></script>
<script src="{{route('/')}}/assets/js/datepicker/date-picker/datepicker.en.js"></script>
<script src="{{route('/')}}/assets/js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="{{route('/')}}/assets/js/owlcarousel/owl.carousel.js"></script>
<script src="{{route('/')}}/assets/js/general-widget.js"></script>
<script src="{{route('/')}}/assets/js/height-equal.js"></script>

<script src="{{route('/')}}/assets/js/chart/morris-chart/raphael.js"></script>
<script src="{{route('/')}}/assets/js/chart/morris-chart/morris.js"> </script>
<script src="{{route('/')}}/assets/js/chart/morris-chart/prettify.min.js"></script>
<script>
    // circle chart
var options4 = {
    chart: {
        height: 372,
        type: 'radialBar',
        fullWidth: true,
    },
    plotOptions: {
        padding: {
            left: 0,
            right: 0
        },
        radialBar: {
            hollow: {
                size: '40%',
            },
            track: {
               show: false
            },
            dataLabels: {
                name: {
                    fontSize: '22px',
                },
                value: {
                    fontSize: '16px',
                },
                total: {
                    show: true,
                    label: 'Total',
                    formatter: function (w) {
                        return {{ $qtdFeedback['qtdTotal'] }}
                    }
                }
            }
        }
    },
    fill: {
        //pocoAdminConfig.primary
    colors: ['#ffdd55', '#168ef7', pocoAdminConfig.primary, '#fe6aa4'],
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'horizontal',
            shadeIntensity: 0.2,
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    colors: ['#ffdd55', '#168ef7', '#5a1aab', '#fe6aa4'],
    series: [
        {{ $qtdFeedback['AVD%'] }},
        {{ $qtdFeedback['dormir%'] }},
        {{ $qtdFeedback['brincar%'] }},
        {{ $qtdFeedback['regulatorias%'] }}
    ],
    labels: ['AVDs', 'Dormir', 'Brincar', 'Regulatórias'],
    stroke: {
        lineCap: "round",
    }
}

var chart4 = new ApexCharts(
    document.querySelector("#feedbackcirclechart"),
    options4
);

chart4.render();
</script>

<script>
"use strict";
var morris_chart = {
    init: function() {
        Morris.Bar({
            element: "bar-line-chart-morris",
            data: [{
                x: "Jan",
                    y: {{ $qtdRelatorios['qtdPMes']['1'] }}
            },
                {
                    x: "Fev",
                    y: {{ $qtdRelatorios['qtdPMes']['2'] }}
                },
                {
                    x: "Mar",
                    y: {{ $qtdRelatorios['qtdPMes']['3'] }}
                },
                {
                    x: "Abr",
                    y: {{ $qtdRelatorios['qtdPMes']['4'] }}
                },
                {
                    x: "Mai",
                    y: {{ $qtdRelatorios['qtdPMes']['5'] }}
                },
                {
                    x: "Jun",
                    y: {{ $qtdRelatorios['qtdPMes']['6'] }}
                },
                {
                    x: "Jul",
                    y: {{ $qtdRelatorios['qtdPMes']['7'] }}
                },
                {
                    x: "Ago",
                    y: {{ $qtdRelatorios['qtdPMes']['8'] }}
                },
                {
                    x: "Set",
                    y: {{ $qtdRelatorios['qtdPMes']['9'] }}
                },
                {
                    x: "Out",
                    y: {{ $qtdRelatorios['qtdPMes']['10'] }}
                },
                {
                    x: "Nov",
                    y: {{ $qtdRelatorios['qtdPMes']['11'] }}
                },
                {
                    x: "Dez",
                    y: {{ $qtdRelatorios['qtdPMes']['12'] }}
                }],
            xkey: "x",
            ykeys: ["y"],
            labels: ["Y"],
            barColors: ["#7e37d8"]
        });
    }
};
(function($) {
    "use strict";
    morris_chart.init()
})(jQuery);

</script>


<script>

    // [ dount chart ] start
var options = {
    chart: {
        width: 350,
        type: 'donut',
    },
    dataLabels: {
        enabled: false
    },
    series: [
        {{$qtdUsers['percPais']}},
        {{$qtdUsers['percTerapeutas']}},
        {{$qtdUsers['percdministradores']}}
    ],
    responsive: [{
        breakpoint: 200,
        options: {
            chart: {
                width: 200
            },
            legend: {
                show: true
            }
        }
    }],

    labels: ['Pais/Cuidadores', 'Terapeutas', 'Administradores'],
    legend: {
        position: 'bottom'
    },
    fill: {
        opacity: 1
    },
    colors:['#7e37d8', '#fe80b2', '#06b5dd'],

}

var chart = new ApexCharts(
    document.querySelector("#chart1"),
    options
);

chart.render()

</script>
@endsection

