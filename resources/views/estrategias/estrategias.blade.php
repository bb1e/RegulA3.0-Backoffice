@extends('layouts.simple.master')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)
@section('title', 'Estratégias')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span></span>Estratégias</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Estratégias</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
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
            <br>
        @endif
        @if(session()->has('sucess'))
            <div class="cont text-center">
                <div class="alert alert-success text-center">
                    <ul>
                        <li class="text-center">{{ session()->get('sucess') }}</li>
                    </ul>
                </div>
            </div>
            <br>
        @endif
         <div class="card">
            <div class="card-body">
               <div class="card">
                  <a href="{{route('adicionar_estrategia')}}" class="btn btn-primary btn-lg"> <span class="icon-plus"></span> Adicionar nova estratégia</a>
               </div>
               <div class="dt-ext table-responsive">
                  <table class="display" id="basic-key-table">
                     <thead>
                        <tr>
                           <th>Nome</th>
                           <th>Grupo</th>
                           <th>Reatividade</th>
                           <th>Gestão</th>
                        </tr>
                     </thead>

                     <tbody>
                     @foreach($estrategias as $estrategia)
                        <tr>
                           <td>{!! Purify::clean($estrategia->data()['descricao']) !!}</td>
                           <td>{{$estrategia->data()['titulo']}}</td>
                           <td>{{$estrategia->data()['tipoAlvo']}}</td>
                           <td>
                                <button class="btn btn-warning btn-lg btn-block"><a href="{{ route('estrategias_resources.edit', $estrategia->data()['id']) }}"> <span class="icon-pencil" style="color:white;"></span></a></button>

                                <form method="POST" action="/estrategias_resources/{{$estrategia->data()['id']}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                <button class="btn btn-danger btn-lg btn-block" type="button" data-toggle="modal" data-original-title="test" data-target="#modal-{{ $estrategia->data()['id'] }}"><span class="icon-trash"></span></button>
                                <div class="modal fade" id="modal-{{ $estrategia->data()['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Apagar estratégia</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">Tem a certeza que pretende apagar a estratégia <strong> {!! Purify::clean($estrategia->data()['descricao']) !!}</strong>?</div>
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
