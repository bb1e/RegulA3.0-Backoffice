@extends('layouts.simple.master')
@section('title', 'Terapeutas')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span></span>Terapeutas</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Terapeutas</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="card">
                  <a href="{{route('terapeutas.convidar')}}" class="btn btn-primary btn-lg"> <span class="icon-plus"></span> Convidar terapeuta</a>
               </div>
               <div class="dt-ext table-responsive">
                  <table class="display" id="basic-key-table">
                     <thead>
                        <tr>
                           <th>Nome</th>
                           <th>Email</th>
                           <th>Função</th>
                           <th>Estado</th>
                           <th>Gestão</th>
                        </tr>
                     </thead>
                        @foreach ($terapeutas as $terapeuta)
                            <tr>
                                <td> {{ $terapeuta->data()['nome'] }}</td>
                                <td> {{ $terapeuta->data()['email'] }}</td>
                                @if ($terapeuta->data()['tipo'] == 'T')
                                    <td> Terapeuta</td>
                                @elseif ($terapeuta->data()['tipo'] == 'A')
                                    <td> Administrador</td>
                                @endif

                                @if ($terapeuta->data()['bloqueado'] == false)
                                    <td>Ativo</td>
                                @elseif ($terapeuta->data()['bloqueado'] == true)
                                    <td>Bloqueado</td>
                                @endif
                                <td>
                                    <form>
                                        <a class="btn btn-primary btn-lg btn-block" href="{{ route('terapeutas.profile', $terapeuta->data()['id']) }}"> <span class="icon-id-badge"></span> </a>
                                    </form>
                                </td>
                            </tr>


                        @endforeach
                     <tbody>

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
