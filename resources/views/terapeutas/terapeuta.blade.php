@extends('layouts.simple.master')
@section('title', 'Gestão do terapeuta')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Gestão do</span>Terapeuta</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Terapeutas</li>
	<li class="breadcrumb-item">Gestão do terapeuta</li>
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
                        <img src="{{route('/')}}/img/terapeuta/{{$imagem}}" alt="">
                    </div>
                </div>
                <div class="info">
                   <div class="row">
                      <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                         <div class="row">
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                    <h6><i class="fa fa-calendar"></i>   Data do registo</h6>
                                    <span>{{$terapeuta->data()['data']}}</span>
                               </div>
                            </div>
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                  <h6><i class="fa fa-check-square-o"></i>   Estado da conta</h6>
                                  @if ($terapeuta->data()['bloqueado'] == false)
                                      <span>Ativa</span>
                                  @elseif ($terapeuta->data()['bloqueado'] == true)
                                      <span>Bloqueada</span>
                                  @endif
                                </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                         <div class="user-designation">
                            <div class="title"><a target="_blank" href="">{{$terapeuta->data()['nome']}}</a></div>
                            @if ($terapeuta->data()['tipo'] == 'T')
                                <span>Terapeuta</span>
                            @elseif ($terapeuta->data()['tipo'] == 'A')
                                <span>Administrador</span>
                            @endif
                         </div>
                      </div>
                      <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                         <div class="row">
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                  <h6><i class="fa fa-user"></i>   Quantidade de crianças</h6>
                                  <span>{{$qtdCriancas}}</span>
                               </div>
                            </div>
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                  <h6><i class="fa fa-envelope"></i>   Email</h6>
                                  <span>{{$terapeuta->data()['email']}}</span>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <hr>
                   <div>
                        @if ($terapeuta->data()['bloqueado'] == false)
                            <a href="{{ route('terapeutas.profile.estado', $terapeuta->data()['id']) }}" class="btn btn-primary btn-lg"><span class="pe-7s-lock"></span> Bloquear</a>
                        @elseif ($terapeuta->data()['bloqueado'] == true)
                            <a href="{{ route('terapeutas.profile.estado', $terapeuta->data()['id']) }}" class="btn btn-primary btn-lg"><span class="pe-7s-unlock"></span> Ativar</a>
                        @endif

                        @if ($terapeuta->data()['tipo'] == 'T')
                            <a href="{{ route('terapeutas.profile.tipo', $terapeuta->data()['id']) }}" class="btn btn-primary btn-lg"><span class="icon-panel"></span> Tornar administrador</a>
                        @elseif ($terapeuta->data()['tipo'] == 'A')
                            <a href="{{ route('terapeutas.profile.tipo', $terapeuta->data()['id']) }}" class="btn btn-primary btn-lg"><span class="icon-panel"></span> Tornar terapeuta</a>
                        @endif

                        <a href="{{ route('terapeutas.criancas.gestao', $terapeuta->data()['id']) }}" class="btn btn-primary btn-lg"><span class="icon-menu"></span>  Gestão das crianças</a>


                   </div>
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
                            <div class="alert alert-primary text-center">
                                <ul>
                                    <li class="text-center">{{ session()->get('sucess') }}</li>
                                </ul>
                            </div>
                        </div>

                    @endif

                    <div class="card-body">

                        <h5>Crianças que acompanha</h5>
                        <div class="dt-ext table-responsive">

                            <table class="display" id="scrolling">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Data de Nascimento (ano/mes/dia)</th>
                                        <th>Pai/Cuidador</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($criancasDoTerapeuta as $crianca)
                                        <tr>
                                            <td>{{$crianca['nome']}}</td>
                                            <td>{{$crianca['dataNascimento']['ano']}}/{{$crianca['dataNascimento']['mes']}}/{{$crianca['dataNascimento']['dia']}}</td>
                                            <td>{{$crianca['parentName']}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>
          </div>
          <!-- user profile first-style end-->
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
