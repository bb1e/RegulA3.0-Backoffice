
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
	<h2><span>Editar </span>estratégia</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item" >Estratégias</li>
	<li class="breadcrumb-item">Editar</li>
@endsection

@section('content')
<form action="{{ route('estrategias_resources.update', $estrategia->data()['id']) }}" method="POST">
@csrf
@method('PUT')

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


                            <textarea class="form-control" id="descricao" placeholder="Descrição da estratégia..." name="descricao" rows="2" required="">{!! Purify::clean($estrategia->data()['descricao']) !!}</textarea>
                            <br>
                            <div>

                                <label>Pré-Visualização</label>
                                <pre>
                                    <p id="preview"></p>
                                </pre>
                            </div>
                            <br><br>

                            </div>
                        </div>
                    </div>
                    <div></div>
                    <div class="form-row">
                        <div class="col">
                            <label for="titulo">Área de ocupação</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="titulo" name="titulo">
                                    <optgroup label="Atividades da Vida Diária">
                                    @if($estrategia->data()['titulo'] === "Tomar banho")
                                        <option selected="" value="Tomar banho">Tomar banho</option>
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
                                    @endif

                                    @if($estrategia->data()['titulo'] === "Vestir/despir")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option selected="" value="Vestir/despir">Vestir e despir</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Alimentação e horas da refeição")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option value="Vestir/despir">Vestir e despir</option>
                                        <option selected="" value="Alimentação e horas da refeição">Alimentação</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Higiene sanitária")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option value="Vestir/despir">Vestir e despir</option>
                                        <option value="Alimentação e horas da refeição">Alimentação</option>
                                        <option selected="" value="Higiene sanitária">Higiene sanitária</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Higiene pessoal – lavar os dentes")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option value="Vestir/despir">Vestir e despir</option>
                                        <option value="Alimentação e horas da refeição">Alimentação</option>
                                        <option value="Higiene sanitária">Higiene sanitária</option>
                                        <option selected="" value="Higiene pessoal – lavar os dentes">Lavar os dentes</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Higiene Pessoal – cortar as unhas")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option value="Vestir/despir">Vestir e despir</option>
                                        <option value="Alimentação e horas da refeição">Alimentação</option>
                                        <option value="Higiene sanitária">Higiene sanitária</option>
                                        <option value="Higiene pessoal – lavar os dentes">Lavar os dentes</option>
                                        <option selected="" value="Higiene Pessoal – cortar as unhas">Cortar as unhas</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Higiene Pessoal – lavar a mãos")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option value="Vestir/despir">Vestir e despir</option>
                                        <option value="Alimentação e horas da refeição">Alimentação</option>
                                        <option value="Higiene sanitária">Higiene sanitária</option>
                                        <option value="Higiene pessoal – lavar os dentes">Lavar os dentes</option>
                                        <option value="Higiene Pessoal – cortar as unhas">Cortar as unhas</option>
                                        <option selected="" value="Higiene Pessoal – lavar a mãos">Lavar as mãos</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Higiene Pessoal - colocar creme")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option value="Vestir/despir">Vestir e despir</option>
                                        <option value="Alimentação e horas da refeição">Alimentação</option>
                                        <option value="Higiene sanitária">Higiene sanitária</option>
                                        <option value="Higiene pessoal – lavar os dentes">Lavar os dentes</option>
                                        <option value="Higiene Pessoal – cortar as unhas">Cortar as unhas</option>
                                        <option value="Higiene Pessoal – lavar a mãos">Lavar as mãos</option>
                                        <option selected="" value="Higiene Pessoal - colocar creme">Colocar creme</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Higiene Pessoal – cortar o cabelo")
                                        <option value="Tomar banho">Tomar banho</option>
                                        <option value="Vestir/despir">Vestir e despir</option>
                                        <option value="Alimentação e horas da refeição">Alimentação</option>
                                        <option value="Higiene sanitária">Higiene sanitária</option>
                                        <option value="Higiene pessoal – lavar os dentes">Lavar os dentes</option>
                                        <option value="Higiene Pessoal – cortar as unhas">Cortar as unhas</option>
                                        <option value="Higiene Pessoal – lavar a mãos">Lavar as mãos</option>
                                        <option value="Higiene Pessoal - colocar creme">Colocar creme</option>
                                        <option selected="" value="Higiene Pessoal – cortar o cabelo">Cortar o cabelo</option>
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
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Preparação do sono")
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
                                        <option selected="" value="Preparação do sono">Preparação do sono</option>
                                        <option value="Participação do sono">Participação do sono</option>
                                        </optgroup>
                                        <optgroup label="Brincar e jogar">
                                        <option value="Brincar/Jogar">Brincar e jogar</option>
                                        </optgroup>
                                        <optgroup label="Estratégias regulatórias">
                                        <option value="Estratégias Regulatórias">Estratégias regulatórias</option>
                                        </optgroup>
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Participação do sono")
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
                                        <option selected="" value="Participação do sono">Participação do sono</option>
                                        </optgroup>
                                        <optgroup label="Brincar e jogar">
                                        <option value="Brincar/Jogar">Brincar e jogar</option>
                                        </optgroup>
                                        <optgroup label="Estratégias regulatórias">
                                        <option value="Estratégias Regulatórias">Estratégias regulatórias</option>
                                        </optgroup>
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Brincar/Jogar")
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
                                        <option selected="" value="Brincar/Jogar">Brincar e jogar</option>
                                        </optgroup>
                                        <optgroup label="Estratégias regulatórias">
                                        <option value="Estratégias Regulatórias">Estratégias regulatórias</option>
                                        </optgroup>
                                    @endif
                                    @if($estrategia->data()['titulo'] === "Estratégias Regulatórias")
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
                                        <option selected="" value="Estratégias Regulatórias">Estratégias regulatórias</option>
                                        </optgroup>
                                    @endif

                            </select>
                        </div>
                    </div>
                    <div><br></div>
                    <div class="form-row">
                        <div class="col">
                            <label for="tipoAlvo">Reatividade alvo</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="tipoAlvo" name="tipoAlvo" value="{{$estrategia->data()['tipoAlvo']}}">
                                @if($estrategia->data()['tipoAlvo'] === "Hipo_reativo")
                                    <option selected="" value="Hipo_reativo">Hipo-reativo</option>
                                    <option value="Hiper_reativo">Hiper-reativo</option>
                                    <option value="Nenhum">Nenhum</option>
                                @endif

                                    @if($estrategia->data()['tipoAlvo'] === "Hiper_reativo")
                                    <option value="Hipo_reativo">Hipo-reativo</option>
                                    <option selected="" value="Hiper_reativo">Hiper-reativo</option>
                                    <option value="Nenhum">Nenhum</option>
                                @endif

                                    @if($estrategia->data()['tipoAlvo'] === "Nenhum")
                                    <option value="Hipo_reativo">Hipo-reativo</option>
                                    <option value="Hiper_reativo">Hiper-reativo</option>
                                    <option selected="" value="Nenhum">Nenhum</option>
                                @endif

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
