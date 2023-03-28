@extends('layouts.simple.master')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)
@section('title', 'Perfil')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span></span>Perfil</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Crianças</li>
	<li class="breadcrumb-item">Perfil</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="user-profile">
       <div class="row">
          <!-- user profile first-style start-->
          <div class="col-sm-12">
             <div class="card hovercard text-center">
                <div class="user-image">
                   <div class="avatar">
                       <img alt="" src="{{route('/')}}/img/perfil/{{$crianca->data()['id']}}.png">
                    </div>
                </div>
                <div class="info">
                   <div class="row">
                      <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                         <div class="row">
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                    <h6><i class="fa fa-check-square-o"></i>   Última avaliação</h6>
                                    <span>{{$crianca->data()['dataUltimaAvaliacao']}}</span>
                               </div>
                            </div>
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                  <h6><i class="fa fa-calendar"></i>   Data de Nascimento</h6>
                                  <span>{{$crianca->data()['dataNascimento']['dia']}}/{{$crianca->data()['dataNascimento']['mes']}}/{{$crianca->data()['dataNascimento']['ano']}}</span>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                         <div class="user-designation">
                            <div class="title"><a target="_blank" href="">{{$crianca->data()['nome']}}</a></div>
                            <div class="desc mt-2">5 anos</div>
                         </div>
                      </div>
                      <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                         <div class="row">
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                  <h6><i class="fa fa-user"></i>   Nome do pai/cuidador</h6>
                                  <span>{{$crianca->data()['parentName']}}</span>
                               </div>
                            </div>
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                  <h6><i class="fa fa-envelope"></i>   Email do pai/cuidador</h6>
                                  <span>{{$cuidador->data()['email']}}</span>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <hr>
                   <div>
                        <a href="{{ route('crianca.dashboard', $crianca->data()['id']) }}" class="btn btn-info btn-lg"><span class="icon-bar-chart"></span> Dashboard</a>
                        <a href="{{ route('crianca.avaliar', $crianca->data()['id']) }}" class="btn btn-info btn-lg"><span class="icon-clipboard"></span> Avaliar</a>
                        <a href="{{ route('crianca.recomendar', $crianca->data()['id']) }}" class="btn btn-info btn-lg ">  <span class="icon-timer"> </span> Recomendar estratégias</a>
                   </div>
                   <br>
                    @if($errors->any())
                    <div class="cont text-center">
                        <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-center">{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if(session()->has('sucess'))
                    <div class="cont text-center">
                        <div class="alert alert-info text-center">
                            <ul>
                                <li class="text-center">{{ session()->get('sucess') }}</li>
                            </ul>
                        </div>
                    </div>
                @endif
                        <div class="card-header">
                            <h5>Sistemas sensoriais</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordernone">
                                <thead>
                                    <tr>
                                        <th scope="col">Tátil</th>
                                        <th scope="col">Auditivo</th>
                                        <th scope="col">Visual</th>
                                        <th scope="col">Olfativo</th>
                                        <th scope="col">Gustativo</th>
                                        <th scope="col">Propriocetivo</th>
                                        <th scope="col">Vestibular</th>
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
                        <div>
                            <h5><b>Comentário</b></h5>
                            <p>{{$crianca->data()['comentario']}}</p>
                        </div>
                    </div>
                    <div>
                </div>
             </div>
          </div>
          <!-- user profile first-style end-->
          <div class="col-sm-12">
            <div class="card hovercard">
                  <div class="text-center">
                      <br>
                      <br>
                      <h5><b>Estratégias recomendadas</b></h5>
                  </div>
                  <div class="card-body">
                      <div class="dt-ext table-responsive">

                          <table class="display" id="scrolling">

                          <thead>
                              <tr>
                                  <th>Estratégia</th>
                                  <th>Área ocupação</th>
                                  <th>Reatividade</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($estrategiasRecomendadas as $rcms)
                                  <tr>
                                      <td><p>{!! Purify::clean($rcms->data()['descricao']) !!}</p></td>

                                        @switch($rcms->data()['titulo'])
                                            @case('Alimentação e horas da refeição')
                                                <td>Alimentação</td>
                                                @break
                                            @case('Brincar/Jogar')
                                                <td>Alimentação</td>
                                                @break
                                            @case('Estratégias Regulatórias')
                                                <td>Regulatórias</td>
                                                @break
                                            @case('Higiene Pessoal - colocar creme')
                                                <td>Colocar creme</td>
                                                @break
                                            @case('Higiene Pessoal – cortar as unhas')
                                                <td>Cortar as unhas</td>
                                                @break
                                            @case('Higiene Pessoal – cortar o cabelo')
                                                <td>Cortar o cabelo</td>
                                                @break
                                            @case('Higiene Pessoal – lavar a mãos')
                                                <td>Lavar as mãos</td>
                                                @break
                                            @case('Higiene pessoal – lavar os dentes')
                                                <td>Lavar os dentes</td>
                                                @break
                                            @case('Higiene sanitária')
                                                <td>Higiene sanitária</td>
                                                @break
                                            @case('Participação do sono')
                                                <td>Participação do sono</td>
                                                @break
                                            @case('Preparação do sono')
                                                <td>Preparação do sono</td>
                                                @break
                                            @case('Tomar banho')
                                                <td>Tomar banho</td>
                                                @break
                                            @case('Vestir/despir')
                                                <td>Vestir e despir</td>
                                                @break
                                            @default
                                                <td>Nenhum</td>
                                                @break
                                            @endswitch


                                            @switch($rcms->data()['tipoAlvo'])
                                                @case('Hipo_reativo')
                                                    <td>Hipo-reativo</td>
                                                    @break
                                                @case('Hiper_reativo')
                                                    <td>Hiper-reativo</td>
                                                    @break
                                                @default
                                                    <td>Nenhum</td>
                                                    @break
                                            @endswitch
                                  </tr>
                              @endforeach
                          </tbody>
                          </table>
                      </div>
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
@endsection
