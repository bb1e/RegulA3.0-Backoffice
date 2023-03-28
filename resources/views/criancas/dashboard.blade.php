@extends('layouts.simple.master')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)
@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2><span>Dashboard </span>{{$crianca->data()['nome']}}</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Crianças</li>
	<li class="breadcrumb-item">Perfil</li>
	<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
               <h5>Feedback de estratégias</h5>
               <span>Total de feedback de estratégias enviado: {{$feedbackCounter}}</span>
            </div>
            <div class="card-body">
               <div class="dt-ext table-responsive">
                  <table class="display" id="basic-key-table">
                     <thead>
                        <tr>
                            <th>Nome estratégia</th>
                            <th>Realizou?</th>
                            <th>Data (ano/mes/dia)</th>
                            <th>Info</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($feedbacks as $fb)
                            @foreach ($estrategiasComFeedback as $strat)
                                @if ($fb->data()['idEstrategia'] == $strat->data()['id'])
                                <tr>
                                  <td><p>{!! Purify::clean($strat->data()['descricao']) !!}</p></td>
                                  @if ($fb->data()['realizou'] == 1)
                                      <td>Realizou</td>
                                  @endif
                                  @if ($fb->data()['realizou'] == 0)
                                      <td>Não realizou</td>
                                  @endif
                                  <td>{{$fb->data()['data']['ano']}}/{{$fb->data()['data']['mes']}}/{{$fb->data()['data']['dia']}}</td>
                                  <td>
                                        <a class="btn btn-primary btn-lg btn-block" href="{{ route('crianca.dashboard.feedback', $fb->data()['id']) }}">Detalhes</a>
                                  </td>
                              </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
                <h5>Relatórios semanais</h5>
                <span>Total de relatórios semanais enviados: {{$relatoriosCounter}}</span>
            </div>

            <div class="text-center">
                <div class="user-image">
                   <div class="avatar">
                        <a class="btn btn-success btn-lg" href="{{ route('crianca.dashboard.graficos', $crianca->data()['id']) }}"><span class="icon-bar-chart"></span> Ver gráficos de evolução</a>
                   </div>
                </div>
            </div>

            <div class="card-body">
                <h5>Média</h5>
                <span>Média calculada para cada parametro do total de relatórios semanais.</span>
                <div class="table-responsive">
                   <table class="table">
                      <thead>
                         <tr>
                            <th>
                                <img alt="" src="{{route('/')}}/img/dashboard/av1.png">
                                <p>Tomar banho</p>
                            </th>
                            <th>
                                <img alt="" src="{{route('/')}}/img/dashboard/av2.png">
                                <p>Vestir e despir</p>
                            </th>
                            <th>
                                <img alt="" src="{{route('/')}}/img/dashboard/av3.png">
                                <p>Alimentação</p>
                            </th>
                            <th>
                                <img alt="" src="{{route('/')}}/img/dashboard/av4.png">
                                <p>Higiene sanitária</p>
                            </th>
                            <th>
                                <img alt="" src="{{route('/')}}/img/dashboard/av5.png">
                                <p>Descanso e sono</p>
                            </th>
                            <th>
                                <img alt="" src="{{route('/')}}/img/dashboard/av6.png">
                                <p>Brincar e jogar</p>
                            </th>
                            <th>
                                <img alt="" src="{{route('/')}}/img/dashboard/av7.png">
                                <p>Higiene pessoal</p>
                            </th>
                         </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>{{$mediaAv1}}</td>
                              <td>{{$mediaAv2}}</td>
                              <td>{{$mediaAv3}}</td>
                              <td>{{$mediaAv4}}</td>
                              <td>{{$mediaAv5}}</td>
                              <td>{{$mediaAv6}}</td>
                              <td>{{$mediaAv7}}</td>
                          </tr>
                      </tbody>
                   </table>
                </div>
             </div>
            <div class="card-body">
                <h5>Histórico de relatórios</h5>
               <div class="dt-ext table-responsive">
                  <table class="display" id="focus-cell">
                     <thead>
                        <tr>
                           <th>Semana</th>
                           <th><img alt="" src="{{route('/')}}/img/dashboard/av1.png"></th>
                           <th><img alt="" src="{{route('/')}}/img/dashboard/av2.png"></th>
                           <th><img alt="" src="{{route('/')}}/img/dashboard/av3.png"></th>
                           <th><img alt="" src="{{route('/')}}/img/dashboard/av4.png"></th>
                           <th><img alt="" src="{{route('/')}}/img/dashboard/av5.png"></th>
                           <th><img alt="" src="{{route('/')}}/img/dashboard/av6.png"></th>
                           <th><img alt="" src="{{route('/')}}/img/dashboard/av7.png"></th>
                        </tr>
                     </thead>
                     <tbody>
                         @foreach ($relatorios as $relatorio)
                            <tr>
                                <td>{{$relatorio->data()['semana']}}</td>
                                <td>{{$relatorio->data()['avaliacao1']}}</td>
                                <td>{{$relatorio->data()['avaliacao2']}}</td>
                                <td>{{$relatorio->data()['avaliacao3']}}</td>
                                <td>{{$relatorio->data()['avaliacao4']}}</td>
                                <td>{{$relatorio->data()['avaliacao5']}}</td>
                                <td>{{$relatorio->data()['avaliacao6']}}</td>
                                <td>{{$relatorio->data()['avaliacao7']}}</td>
                            </tr>
                         @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
             <div class="card-body">
                <h5>Histórico de comentários de relatórios semanais</h5>
                <ul class="list-group">
                    <?php $count = 0 ?>
                    @foreach ($relatorios as $relatorio)
                        @if ($relatorio->data()['comentario'] == "")

                        @else
                            <li class="list-group-item"><b>{{$relatorio->data()['semana']}}</b>: {{$relatorio->data()['comentario']}}</li>
                            <?php $count++ ?>
                        @endif
                    @endforeach
                    @if ($count === 0)
                        <li class="list-group-item">Sem comentários</li>
                    @endif
                </ul>
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
@endsection
