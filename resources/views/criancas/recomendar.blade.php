@extends('layouts.simple.master')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)
@section('title', 'Recomendar estratégias')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Recomendação de </span>estratégias</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Crianças</li>
	<li class="breadcrumb-item">Perfil</li>
	<li class="breadcrumb-item">Recomendar estratégias</li>
@endsection

@section('content')
<form action="{{ route('crianca.atualizar', $crianca->data()['id']) }}" method="PUT">
@csrf
@method('PUT')

<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
             <div class="card-header">
                <h5>Avaliação - {{$crianca->data()['nome']}}</h5>
                <br><br>
                <div class="table-responsive">
                   <table class="table">
                      <thead>
                         <tr>
                            <th>Tátil</th>
                            <th>Auditivo</th>
                            <th>Visual</th>
                            <th>Olfativo</th>
                            <th>Gustativo</th>
                            <th>Propriocetivo</th>
                            <th>Vestibular</th>
                         </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>{{$crianca->data()['ssAv1']}}</td>
                              <td>{{$crianca->data()['ssAv2']}}</td>
                              <td>{{$crianca->data()['ssAv3']}}</td>
                              <td>{{$crianca->data()['ssAv4']}}</td>
                              <td>{{$crianca->data()['ssAv5']}}</td>
                              <td>{{$crianca->data()['ssAv6']}}</td>
                              <td>{{$crianca->data()['ssAv7']}}</td>
                          </tr>
                      </tbody>
                   </table>
                </div>
                <br><br>
                @if ($crianca->data()['comentario'] != "")
                  <h6><b>Comentário: </b> {{$crianca->data()['comentario']}}</h6>
                @endif
             </div>
             <div class="card-body">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Gravar</button>
                <br><br>
                <!-- Smart Wizard start-->
                <div class="wizard-4" id="wizard">
                   <ul>
                        <li><a href="#step-1"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_banho.png"><small>Tomar banho</small></a></li>
                        <li><a href="#step-2"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_vestir.png"><small>Vestir e despir</small></a></li>
                        <li><a href="#step-3"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_alimentacao.png"><small>Alimentação</small></a></li>
                        <li><a href="#step-4"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_higiene.png"><small>Higiene sanitária</small></a></li>
                        <li><a href="#step-5"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_dentes.png"><small>Lavar os dentes</small></a></li>
                        <li><a href="#step-6"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_unhas.png"><small>Cortar as unhas</small></a></li>
                        <li><a href="#step-7"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_maos.png"><small>Lavar as mãos</small></a></li>
                        <li><a href="#step-8"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_creme.png"><small>Colocar creme</small></a></li>
                        <li><a href="#step-9"><img alt="" src="{{route('/')}}/img/areas_ocupacao/avd_cabelo.png"><small>Cortar cabelo</small></a></li>
                        <li><a href="#step-10"><img alt="" src="{{route('/')}}/img/areas_ocupacao/sono_prep.png"><small>Preparação do sono</small></a></li>
                        <li><a href="#step-11"><img alt="" src="{{route('/')}}/img/areas_ocupacao/sono_part.png"><small>Participação no sono</small></a></li>
                        <li><a href="#step-12"><img alt="" src="{{route('/')}}/img/areas_ocupacao/ao_brincar.png"><small>Brincar e jogar</small></a></li>
                        <li class="pb-0"><a href="#step-13"><img alt="" src="{{route('/')}}/img/areas_ocupacao/ao_regulatorias.png"><small>Regulatórias</small></a></li>
                   </ul>
                   <div id="step-1">
                      <div class="col-sm-12 pl-0">
                        <br>
                         <div class="form-group">
                            <div class="dt-ext table-responsive">
                                <table class="display" id="scrolling2">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th>Estratégia</th>
                                            <th>Reatividade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banho as $strat)
                                        <?php $encontrou = 0?>
                                            <tr>
                                                @foreach ($estrategiasRecomendadas as $recomendada)
                                                    @if ($recomendada == $strat['id'])
                                                        <?php $encontrou = 1 ?>
                                                    @endif
                                                @endforeach
                                                @if ($encontrou === 1)
                                                    <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                                @endif
                                                @if ($encontrou === 0)
                                                    <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]"  type="checkbox"></td>
                                                @endif
                                                <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                                <td> {{$strat['tipoAlvo']}} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div id="step-2">
                    <div class="col-sm-12 pl-0">
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($vestir as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]"  type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-3">
                    <div class="col-sm-12 pl-0">
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($alimentacao as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]"  type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-4">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($higiene as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-5">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($dentes as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-6">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($unhas as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-7">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($maos as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-8">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($creme as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-9">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($cabelo as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-10">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($sonoPrep as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-11">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($sonoPart as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-12">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($brincar as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                   <div id="step-13">
                    <div class="col-sm-12 pl-0">
                        <br>
                       <div class="form-group">
                          <div class="dt-ext table-responsive">
                              <table class="display" id="scrolling2">
                              <thead>
                                  <tr>
                                      <th> </th>
                                      <th>Estratégia</th>
                                      <th>Reatividade</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($regulatorias as $strat)
                                  <?php $encontrou = 0?>
                                      <tr>
                                          @foreach ($estrategiasRecomendadas as $recomendada)
                                              @if ($recomendada == $strat['id'])
                                                  <?php $encontrou = 1 ?>
                                              @endif
                                          @endforeach
                                          @if ($encontrou === 1)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" checked="" type="checkbox"></td>
                                          @endif
                                          @if ($encontrou === 0)
                                              <td><input id={{$strat['id']}} name="checkbox[{{$strat['id']}}]" type="checkbox"></td>
                                          @endif
                                          <td> <p>{!! Purify::clean($strat['descricao']) !!}</p> </td>
                                          <td> {{$strat['tipoAlvo']}} </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                          </div>
                       </div>
                    </div>
                   </div>
                </div>
                <!-- Smart Wizard Ends-->
             </div>
          </div>
       </div>
    </div>
 </div>
</form>
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
<script src="{{route('/')}}/assets/js/form-wizard/jquery.backstretch.min.js"></script>
<script src="{{route('/')}}/assets/js/form-wizard/form-wizard-five.js"></script>
@endsection
