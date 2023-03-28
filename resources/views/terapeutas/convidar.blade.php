@extends('layouts.simple.master')
@section('title', 'Estratégias')

@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatables.css">
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>Convidar </span>terapeuta</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item" >Terapeutas</li>
	<li class="breadcrumb-item">Convidar</li>
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

        @endif
        @if(session()->has('sucess'))
            <div class="cont text-center">
                <div class="alert alert-primary text-center">
                    <ul>
                        <li class="text-center">{{ session()->get('sucess') }}</li>
                    </ul>
                </div>
            </div>

        @endif

        <form action="{{ route('convite.store') }}" method="POST">
        @csrf
         <div class="card">
            <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" required="">
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="tipo">Tipo de usuário</label>
                            <select class="form-control js-example-basic-single col-sm-12" id="tipo" name="tipo">
                                <option value="T">Terapeuta</option>
                                    <option value="A">Administrador</option>
                            </select>
                        </div>
                    </div>
                    <div><br></div>
                    <button class="btn btn-primary" type="submit">Confirmar</button>

                <div class="text-center">
                    <br>
                </div>
            </div>
        </div>
    </form>

   </div>
</div>

<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
               <h5>Lista de convites pendentes</h5>
            </div>
             <div class="card-body">
                <div class="dt-ext table-responsive">
                   <table class="display" id="basic-key-table">
                      <thead>
                         <tr>
                            <th>Email</th>
                            <th>Data</th>
                            <th>Função</th>
                            <th>Apagar</th>
                         </tr>
                      </thead>

                      <tbody>
                        @foreach($convites as $convite)
                        <tr>
                            <td>{{ $convite->data()['email'] }}</td>
                            <td>{{$convite->data()['data']}}</td>
                            @if ($convite->data()['tipo'] == "T")
                               <td>Terapeuta</td>
                            @elseif ($convite->data()['tipo'] == "A")
                                <td>Administrador</td>
                            @endif
                           <td>
                            <form method="POST" action="/terapeutas/convite/{{ $convite->data()['codigo'] }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger btn-lg btn-block" type="button" data-toggle="modal" data-original-title="test" data-target="#modal-{{ $convite->data()['codigo'] }}"><span class="icon-trash"></span></button>

                                <!-- Modal -->
                                <div class="modal fade" id="modal-{{ $convite->data()['codigo'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Cancelar convite</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">Tem a certeza que pretende cancelar o convite para <strong> {{ $convite->data()['email'] }}</strong>?</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Voltar</button>
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
<script src="{{route('/')}}/assets/js/custom/real.time.input.view.js"></script>


@endsection
