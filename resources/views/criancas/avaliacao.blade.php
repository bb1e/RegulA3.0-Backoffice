
@extends('layouts.simple.master')
@section('title', 'Avaliação')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Avaliar </span>criança</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item" >Crianças</li>
	<li class="breadcrumb-item">Perfil</li>
	<li class="breadcrumb-item">Avaliar</li>
@endsection

@section('content')
<form action="{{ route('crianca.update', $crianca->data()['id']) }}" method="POST">
@csrf
@method('PUT')

<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
                <div>
                    <h2>{{$crianca->data()['nome']}}</h2>
                    <br>
                </div>
                <form class="needs-validation" novalidate="">
                    <div class="form-row">
                        <div class="col">
                            <label for="av1">Tátil</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="av1" name="av1">
                                <option value="Nenhum">Nenhum</option>
                                <option value="Hipo-reativo">Hipo-reativo</option>
                                <option value="Hiper-reativo">Hiper-reativo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="av2">Auditivo</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="av2" name="av2">
                                <option value="Nenhum">Nenhum</option>
                                <option value="Hipo-reativo">Hipo-reativo</option>
                                <option value="Hiper-reativo">Hiper-reativo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="av3">Visual</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="av3" name="av3">
                                <option value="Nenhum">Nenhum</option>
                                <option value="Hipo-reativo">Hipo-reativo</option>
                                <option value="Hiper-reativo">Hiper-reativo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="av4">Olfativo</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="av4" name="av4">
                                <option value="Nenhum">Nenhum</option>
                                <option value="Hipo-reativo">Hipo-reativo</option>
                                <option value="Hiper-reativo">Hiper-reativo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="av5">Gustativo</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="av5" name="av5">
                                <option value="Nenhum">Nenhum</option>
                                <option value="Hipo-reativo">Hipo-reativo</option>
                                <option value="Hiper-reativo">Hiper-reativo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="av6">Propriocetivo</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="av6" name="av6">
                                <option value="Nenhum">Nenhum</option>
                                <option value="Hipo-reativo">Hipo-reativo</option>
                                <option value="Hiper-reativo">Hiper-reativo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="av7">Vestibular</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="av7" name="av7">
                                <option value="Nenhum">Nenhum</option>
                                <option value="Hipo-reativo">Hipo-reativo</option>
                                <option value="Hiper-reativo">Hiper-reativo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                            <label for="comentario">Comentário</label>
                            <textarea class="form-control" id="comentario" placeholder="Comentário adicional" name="comentario" rows="2" ></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Confirmar</button>
                </form>
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
