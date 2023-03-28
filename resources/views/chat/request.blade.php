@extends('layouts.simple.master')
@section('title', 'Procurar amigos')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Procurar </span>amigos</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item" >Chat</li>
	<li class="breadcrumb-item">Procurar amigos</li>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
               <h5>Lista de utilizadores</h5>
            </div>
             <div class="card-body">
                <div class="dt-ext table-responsive">
                   <table class="display" id="basic-key-table">
                      <thead>
                         <tr>
                            <th>Nome</th>
                            <th>Tipo de utilizador</th>
                            <th>Convidar</th>
                         </tr>
                      </thead>
                      <tbody>
                        @foreach($webUsers as $user)
                        <tr>
                            <td>{{ $user['name'] }}</td>
                            <td>Terapeuta</td>
                            <td>
                               <form>
                                 <a class="btn btn-success btn-lg btn-block" href="{{ route('send.request', $user['uid']) }}"><span class="icon-check"></span> Enviar pedido</a>
                               </form>
                            </td>
                        </tr>
                     @endforeach
                        @foreach($appUsers as $user)
                        <tr>
                            <td>{{ $user['name'] }}</td>
                            <td>Pai/Cuidador</td>
                            <td>
                               <form>
                                 <a class="btn btn-success btn-lg btn-block" href="{{ route('send.request', $user['uid']) }}"><span class="icon-check"></span> Enviar pedido</a>
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
<script src="{{route('/')}}/assets/js/custom/real.time.input.view.js"></script>


@endsection
