@extends('layouts.simple.master')
@section('title', 'Gestão de crianças')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Gestão de </span>Crianças</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Terapeuta</li>
	<li class="breadcrumb-item">Gestao de crianças</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="user-profile">
       <div class="row">
          <!-- user profile first-style start-->
          <div class="col-sm-12">
             <div class="card hovercard text-center">
                <div class="info">
                    <div>
                        <h4>{{$terapeuta['nome']}}</h4>
                        <span>Gerir as crianças que o terapeuta {{$terapeuta['nome']}} acompanha</span>
                    </div>
                   <hr>
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
                                <div class="alert alert-success text-center">
                                    <ul>
                                        <li class="text-center">{{ session()->get('sucess') }}</li>
                                    </ul>
                                </div>
                            </div>

                        @endif
                        <div class="card-header">
                            <h4><strong>Crianças que acompanha</strong></h4>
                        </div>
                        <div class="dt-ext table-responsive">
                            <table class="display" id="scrolling">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Data de Nascimento (ano/mes/dia)</th>
                                        <th scope="col">Pai/Cuidador</th>
                                        <th scope="col">Remover</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($criancasDoTerapeuta as $crianca)
                                        <tr>
                                            <td>{{$crianca['nome']}}</td>
                                            <td>{{$crianca['dataNascimento']['ano']}}/{{$crianca['dataNascimento']['mes']}}/{{$crianca['dataNascimento']['dia']}}</td>
                                            <td>{{$crianca['parentName']}}</td>
                                            <td>

                                            <form method="POST" action="/terapeuta/{{$terapeuta['id']}}/remover/{{$crianca['id']}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-lg btn-block" type="button" data-toggle="modal" data-original-title="test" data-target="#modal-{{ $crianca['id'] }}"><span class="icon-trash"></span></button>
                                                <div class="modal fade" id="modal-{{ $crianca['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Deixar de acompanhar criança</h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            </div>
                                                            <div class="modal-body">Tem a certeza que pretende que <strong> {{ $terapeuta['nome'] }}</strong> deixe de seguir <strong>{{$crianca['nome']}}</strong>?</div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-danger" type="submit">Confirmar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br><br>
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
                      <h4><strong>Lista de crianças sem terapeuta</strong></h4>
                  </div>
                  <div class="card-body">
                    <div class="dt-ext table-responsive">
                        <table class="display" id="basic-key-table">

                            <thead>
                              <tr>
                                  <th>Nome</th>
                                  <th>Data de Nascimento (ano/mes/dia)</th>
                                  <th>Pai/Cuidador</th>
                                  <th>Associar</th>
                              </tr>
                          </thead>
                          <tbody>

                            @foreach ($criancas as $crc)
                            <tr>
                                <td>{{$crc['nome']}}</td>
                                <td>{{$crc['dataNascimento']['ano']}}/{{$crc['dataNascimento']['mes']}}/{{$crc['dataNascimento']['dia']}}</td>
                                <td>{{$crc['parentName']}}</td>
                                <td>

                                <form enctype="multipart/form-data" action="{{ route('terapeutas.criancas.adicionar', [$terapeuta['id'], $crc['id']]) }}" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token()}}">
                                    </div>
                                    <button class="btn btn-info btn-lg btn-block" type="submit">Associar</button>
                                </form>
                                </td>
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
