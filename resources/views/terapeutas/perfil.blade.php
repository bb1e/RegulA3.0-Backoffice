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
                                    <span>{{$terapeuta['data']}}</span>
                               </div>
                            </div>
                            <div class="col-md-6">
                               <div class="ttl-info text-left">
                                  <h6><i class="fa fa-check-square-o"></i>   Função</h6>
                                  @if ($terapeuta['tipo'] == 'T')
                                      <span>Terapeuta</span>
                                  @elseif ($terapeuta['tipo'] == 'A')
                                      <span>Administrador</span>
                                  @endif
                                </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                         <div class="user-designation">
                            <div class="title"><a target="_blank" href="">{{$terapeuta['nome']}}</a></div>
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
                                  <span>{{$terapeuta['email']}}</span>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <hr>
                   <br><br>
                   <div class="card-body">
                    @if(session()->has('sucess'))
                    <div>
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ session()->get('sucess') }}</li>
                            </ul>
                        </div>
                    </div>
                    <br><br>
                @endif
                    <h5>Descrição</h5>
                    <form enctype="multipart/form-data" action="{{ route('terapeuta.perfil.descricao') }}" method="POST">
                    <div class="form-group">
                        <textarea class="form-control" id="descricao" placeholder="Sem descrição..." name="descricao" rows="2">{!! Purify::clean($terapeuta['descricao']) !!}</textarea>
                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token()}}">
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit">Guardar descrição</button>
                    </form>

                   </div>
                   <br>

                    <div class="card-body">
                        <h5>Mudar foto de perfil</h5>
                        <br>
                        <form enctype="multipart/form-data" action="{{ route('terapeuta.perfil.foto') }}" method="POST">
                        <div class="form-group">
                            <input id="filebutton" name="foto" class="input-file" type="file">
                            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token()}}">
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit">Guardar fotografia</button>
                        </form>


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
