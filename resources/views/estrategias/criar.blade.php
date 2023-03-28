@extends('layouts.simple.master')
@section('title', 'Estratégias')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Adicionar </span>estratégia</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item" >Estratégias</li>
	<li class="breadcrumb-item">Adicionar</li>
@endsection

@section('content')
<form action="{{ route('estrategias_resources.store') }}" method="POST">
@csrf

<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="descricao">Estratégia</label>
                                <textarea class="form-control" id="descricao" placeholder="Descrição da estratégia..." name="descricao" rows="2" required=""></textarea>
                                <br>
                                <div>

                                    <label>Pré-Visualização</label>
                                    <pre>
                                        <p id="preview"></p>
                                    </pre>
                                </div>
                            </div>
                            <br><br>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="titulo">Área de ocupação</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="titulo" name="titulo">
                                    <optgroup label="Atividades da Vida Diária">
                                    <option value="Tomar banho">Tomar banho</option>
                                    <option value="Vestir/despir">Vestir e despir</option>
                                    <option value="Alimentação e horas da refeição">Alimentação</option>
                                    <option value="Higiene sanitária">Higiene sanitária</option>
                                    <option value="Higiene pessoal – lavar os dentes">Lavar os dentes</option>
                                    <option value="Higiene Pessoal – cortar as unhas">Cortar as unhas</option>
                                    <option value="Higiene Pessoal – lavar a mãos">Lavar as mãos</option>
                                    <option value="Higiene Pessoal - colocar creme">Colocar creme</option>
                                    <option value="Higiene Pessoal – cortar o cabelo">Cortar o cabelo</option>
                                    </optgroup>
                                    <optgroup label="Descanso e sono">
                                    <option value="Preparação do sono">Preparação do sono</option>
                                    <option value="Participação do sono">Participação do sono</option>
                                    </optgroup>
                                    <optgroup label="Brincar e jogar">
                                    <option value="Brincar/Jogar">Brincar e jogar</option>
                                    </optgroup>
                                    <optgroup label="Estratégias regulatórias">
                                    <option value="Estratégias Regulatórias">Estratégias regulatórias</option>
                                    </optgroup>
                            </select>
                        </div>
                    </div>
                    <div><br></div>
                    <div class="form-row">
                        <div class="col">
                            <label for="tipoAlvo">Reatividade alvo</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="tipoAlvo" name="tipoAlvo">
                                    <option value="Hipo_reativo">Hipo-reativo</option>
                                    <option value="Hiper_reativo">Hiper-reativo</option>
                                    <option value="Nenhum">Nenhum</option>
                        </select>
                        </div>
                    </div>
                    <div><br></div>
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
<script src="{{route('/')}}/assets/js/custom/real.time.input.view.js"></script>
@endsection
