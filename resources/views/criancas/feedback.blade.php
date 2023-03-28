@extends('layouts.simple.master')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)
@section('title', 'Feedback da estratégia')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Feedback </span>da estratégia</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Perfil</li>
	<li class="breadcrumb-item">Dashboard</li>
	<li class="breadcrumb-item">Feedback da estratégia</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
               <h5>Feedback</h5>
               <span>Detalhes do feedback dado</span>
            </div>
            <div class="card-body">
                <div>
                    <h4>Nome da estratégia</h4>
                    <p>{!! Purify::clean($estrategia->data()['descricao']) !!}</p>
                </div>
                <br>
                <br>
                <div>
                    <h4>Data do feedback</h4>
                    <p>{{$feedback->data()['data']['dia']}}/{{$feedback->data()['data']['mes']}}/{{$feedback->data()['data']['ano']}}</p>
                </div>
                <br>
                <br>
                <div>
                    <h4>Conseguiu realizar a estratégia?</h4>
                    @if ($feedback->data()['realizou'] == 1)
                        <p>Realizou</p>
                    @endif
                    @if ($feedback->data()['realizou'] == 0)
                        <p>Não realizou</p>
                    @endif
                </div>
                    @if ($feedback->data()['avaliacao'] === 2)

                        <br>
                        <br>
                        <div>
                            <h4>Feedback</h4>
                                            <td><img alt="" src="{{route('/')}}/img/caras/sad_size.png"></td>
                        </div>
                    @endif
                    @if ($feedback->data()['avaliacao'] === 3)
                    <br>
                    <br>
                    <div>
                        <h4>Feedback</h4>
                                            <td><img alt="" src="{{route('/')}}/img/caras/meh_size.png"></td>
                    </div>
                    @endif
                    @if ($feedback->data()['avaliacao'] === 5)
                    <br>
                    <br>
                    <div>
                        <h4>Feedback</h4>
                                            <td><img alt="" src="{{route('/')}}/img/caras/smile_size.png"></td>
                    </div>
                    @endif
                    <!-- Comentário se existir-->
                    @if ($feedback->data()['comentario'] === "")
                    @else
                    <br>
                    <br>
                    <div>
                        <h4>Comentário</h4>
                        <p>{{$feedback->data()['comentario']}}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                   <h4>Estatisticas adicionais de feedback da estratégia</h4>
                   <p>{!! Purify::clean($estrategia->data()['descricao']) !!}</p>
               </div>
                <div class="card-body">
                    <div>
                        <h5>Total de feedback recebido</h5>
                        <p> {{$contador}} </p>
                    </div>
                    <br>
                    <br>
                    <div>
                        <h5>Media do feedback</h5>
                        @if ($media == 3)
                            <p><img alt="" src="{{route('/')}}/img/caras/meh_size.png"></p>
                        @endif
                        @if ($media == 5)
                            <p><img alt="" src="{{route('/')}}/img/caras/smile_size.png"></p>

                        @endif
                        @if ($media == 2)
                            <p><img alt="" src="{{route('/')}}/img/caras/sad_size.png"></p>
                        @endif
                    </div>
                    <br>
                    <br>
                    <div class="card-body">
                       <div class="dt-ext table-responsive">
                           <h5>Histórico de feedback da estratégia</h5>
                           <br>
                          <table class="display" id="basic-key-table">
                            <thead>
                                <tr>
                                   <th>Data (ano/mes/dia)</th>
                                   <th>Realizou?</th>
                                   <th>Feedback</th>
                                   <th>Comentario</th>
                                </tr>
                             </thead>
                             <tbody>
                                @foreach ($feedbacksDaEstrategia as $fb)
                                    <tr>
                                       <td>{{$fb->data()['data']['ano']}}/{{$fb->data()['data']['mes']}}/{{$fb->data()['data']['dia']}}</td>
                                       @if ($fb->data()['realizou'] == 1)
                                           <td>Realizou</td>
                                       @endif
                                       @if ($fb->data()['realizou'] == 0)
                                           <td>Não realizou</td>
                                       @endif


                                        @if ($fb->data()['avaliacao'] === 2)
                                            <td><img alt="" src="{{route('/')}}/img/caras/sad_size.png"></td>
                                        @endif
                                        @if ($fb->data()['avaliacao'] === 3)
                                            <td><img alt="" src="{{route('/')}}/img/caras/meh_size.png"></td>
                                        @endif
                                        @if ($fb->data()['avaliacao'] === 5)
                                            <td><img alt="" src="{{route('/')}}/img/caras/smile_size.png"></td>
                                        @endif
                                        @if ($fb->data()['avaliacao'] === 0)
                                            <td>-</td>
                                        @endif

                                       <td>{{$fb->data()['comentario']}}</td>
                                    </tr>

                                @endforeach
                             </tbody>
                          </table>
                       </div>
                    </div>
                    @if ($contador > 1)
                        <div>
                            <br>
                            <br>
                            <div>
                                <h5>Gráfico de evolução</h5>
                            </div>
                            <div class="card-body pt-0 px-0">
                                <div id="line-adwords"></div>
                            </div>
                        </div>
                    @endif
                </div>
         </div>
       </div>
      </div>
   </div>
</div>



@endsection

@section('script')
<script src="{{route('/')}}/assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/jszip.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/pdfmake.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/vfs_fonts.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.select.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/buttons.print.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
<script src="{{route('/')}}/assets/js/datatable/datatable-extension/custom.js"></script>
<script src="{{route('/')}}/assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="{{route('/')}}/assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="{{route('/')}}/assets/js/chart/apex-chart/chart-custom.js"></script>
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
     show: true,
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

  yaxis: {
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
  colors: [pocoAdminConfig.primary],
  series: [{
      name: "Feedback",
      data: {{$avaliacoes}}
    }
  ],
  subtitle: {
    text: '',
    offsetY: 55,
    offsetX: 20
  },
  markers: {
    size: 6,
    strokeWidth: 0,
    hover: {
      size: 9
    }
  },
  labels: {!! Purify::clean($datas) !!},
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
