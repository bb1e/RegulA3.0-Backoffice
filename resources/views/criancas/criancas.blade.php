@extends('layouts.simple.master')
@section('title', 'Crianças')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span></span>Crianças</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Crianças</li>
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
                        <tr>
                           <th>Nome</th>
                           <th>Data de Nascimento (ano/mes/dia)</th>
                           <th>Pai/Cuidador</th>
                           <th>Perfil</th>
                        </tr>
                     </thead>

                     <tbody>
                        @foreach($criancas as $crianca)

                            <tr>
                                <td>{{$crianca['nome']}}</td>
                                <td>{{$crianca['dataNascimento']['ano']}}/{{$crianca['dataNascimento']['mes']}}/{{$crianca['dataNascimento']['dia']}}</td>
                                <td>{{$crianca['parentName']}}</td>
                                <td>
                                    <form>
                                        <a class="btn btn-info btn-lg btn-block" href="{{ route('crianca.perfil', $crianca['id']) }}"> <span class="icon-id-badge"></span> </a>

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
