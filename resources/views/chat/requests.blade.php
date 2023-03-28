@extends('layouts.simple.master')
@section('title', 'Pedidos amizade')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Pedidos de </span>amizade</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item" >Chat</li>
	<li class="breadcrumb-item">Pedidos de amizade</li>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
               <div class="dt-ext table-responsive">
                  <table class="display" id="basic-key-table">
                     <thead>
                         <h4><strong>Pedidos recebidos</strong></h4>
                         <br>
                        <tr>
                           <th>Nome</th>
                           <th>Tipo de utilizador</th>
                           <th>Aceitar</th>
                           <th>Rejeitar</th>
                        </tr>
                     </thead>

                     <tbody>
                        @if (!empty($pedidos))
                          @foreach($pedidos as $key=>$pedido)
                              @if (!empty($pedido) && $pedido['tipo'] != "sent")
                              <tr>
                                  <td>{{   $pedido['remetente']['name'] }}</td>
                                  <td>{{ $pedido['tipoUser'] }}</td>
                                  <td>
                                      <form>
                                          <a class="btn btn-success btn-lg btn-block" href="{{ route('accept_request', $pedido['key']) }}"><span class="icon-check"></span> Aceitar</a>
                                      </form>
                                  </td>
                                  <td>
                                      <form>
                                          <a class="btn btn-danger btn-lg btn-block" href="{{ route('deny_request', $pedido['key']) }}"> <span class="icon-trash"></span> Rejeitar</button>
                                      </form>
                                  </td>
                              </tr>
                              @endif
                          @endforeach
                        @endif
                    </tbody>

                  </table>
               </div>
            </div>
            <div class="card-body">
               <div class="dt-ext table-responsive">
                  <table class="display" id="scrolling">
                      <thead>
                          <h4><Strong>Pedidos enviados</Strong></h4>
                         <tr>
                            <th>Nome</th>
                            <th>Tipo de utilizador</th>
                            <th>Ações</th>
                         </tr>
                      </thead>
                      <tbody>
                        @if (!empty($pedidos))
                          @foreach($pedidos as $key=>$pedido)
                              @if (!empty($pedido) && $pedido['tipo'] != "received")
                              <tr>
                                  <td>{{ $pedido['remetente']['name'] }}</td>
                                  <td>{{ $pedido['tipoUser'] }}</td>
                                  <td>
                                      <form>
                                          <a class="btn btn-danger btn-block" href="{{ route('deny_request', $pedido['key']) }}"> <span class="icon-trash"></span> Cancelar</button>
                                      </form>
                                  </td>
                              </tr>
                              @endif
                          @endforeach
                        @endif
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
<script src="{{route('/')}}/assets/js/custom/real.time.input.view.js"></script>


@endsection
