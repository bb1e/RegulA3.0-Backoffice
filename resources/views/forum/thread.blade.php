@extends('layouts.simple.master')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)
@section('title', 'Publicação')

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2>Publicação<span></span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Fórum</li>
	<li class="breadcrumb-item active">Publicação</li>
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
            <div class="card-header b-t-primary">
                <h4 style="color:black;"> <b>{!! Purify::clean($thread->getValue()['title']) !!}</b> </h4>
            </div>
            <div class="card-body">
                <h6 style="color:black;"> {!! Purify::clean($thread->getValue()['description']) !!} </h6>
                <br>
                <br>
                    <span class="pull-left" style="color:black;">
                        <img src="{{route('/')}}/img/forum/comentarios.png" width="25" height="25">
                        {{ $thread->getValue()['qtdComentarios'] }}
                    </span>
                @if ($thread->getValue()['profissional'] != "" || $thread->getValue()['profissional'] != null)
                    <span class="pull-right" style="color:black;">
                        <img src="{{route('/')}}/img/forum/verified2.png" width="25" height="25">
                        {{ $thread->getValue()['user_name'] }}  *  {{ \App\Http\Controllers\ForumController::time_elapsed_string($thread->getValue()['created_time']) }}
                    </span>
                @else
                    <span class="pull-right" style="color:black;"> {{ $thread->getValue()['user_name'] }}  *  {{ \App\Http\Controllers\ForumController::time_elapsed_string($thread->getValue()['created_time']) }} </span>
                @endif
            </div>
        </div>


        <div class="card">
            <div class="card-header">

                <div class="text-center">
                    <h4><b>Novo comentário</b></h4>
                    <br>
                    <form enctype="multipart/form-data" action="{{ route('forum.comentar', $thread->getKey()) }}" method="POST">
                        <div class="form-group row">
                            <div class="col-lg-12">
                            <div class="input-group">
                                <input id="comentario" name="comentario" class="form-control btn-square" placeholder="Comentário" required="" type="text">
                                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token()}}">
                                <div class="input-group-prepend">
                                    <button class="btn btn-primary" type="submit">Enviar</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">

                <h3 class="pull-left"><b>Comentários</b></h3>
                <br>
                <br>
                <br>

                @foreach ($comentarios as $key => $comentario)
                    @if ($comentario['user_id'] == $uid)
                        <div class="card">
                            <div class="card-header b-t-info">
                                @if ($comentario['profissional'] == null || $comentario['profissional'] == "" )
                                    <h6 class="pull-left">{{ $comentario['user_name'] }}  *  {{ \App\Http\Controllers\ForumController::time_elapsed_string($comentario['created_time']) }}</h6>
                                    <form method="POST" action="{{$thread->getKey()}}/{{$key}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    <button class="btn btn-danger btn-lg pull-right" type="button" data-toggle="modal" data-original-title="test" data-target="#modal-{{ $key }}"><span class="icon-trash"></span></button>
                                    <div class="modal fade" id="modal-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:black;">Apagar comentário</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body" style="color:black;">Tem a certeza que deseja apagar o comentario <strong>{{$comentario['message']}}</strong>?</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancelar</button>
                                                <button class="btn btn-danger" type="submit">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </form>
                                @else
                                    <h6 class="pull-left" style="color:black;">
                                        <img src="{{route('/')}}/img/forum/verified2.png" width="25" height="25">
                                        {{ $comentario['user_name'] }}  *  {{ \App\Http\Controllers\ForumController::time_elapsed_string($comentario['created_time']) }}
                                    </h6>
                                    <form method="POST" action="{{$thread->getKey()}}/{{$key}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    <button class="btn btn-danger btn-lg pull-right" type="button" data-toggle="modal" data-original-title="test" data-target="#modal-{{ $key }}"><span class="icon-trash"></span></button>
                                    <div class="modal fade" id="modal-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:black;">Apagar comentário</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body" style="color:black;">Tem a certeza que deseja apagar o comentario <strong>{{$comentario['message']}}</strong>?</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancelar</button>
                                                <button class="btn btn-danger" type="submit">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </form>
                                @endif

                            </div>
                            <div class="card-body">
                                <h5 style="color:black;"> {!! Purify::clean($comentario['message']) !!} </h5>
                            </div>
                        </div>

                    @else

                    <div class="card">
                        <div class="card-header">
                            @if ($comentario['profissional'] == null || $comentario['profissional'] == "" )
                                <h6>{{ $comentario['user_name'] }}  *  {{ \App\Http\Controllers\ForumController::time_elapsed_string($comentario['created_time']) }}</h6>
                            @else
                                <h6 class="pull-left" style="color:black;">
                                    <img src="{{route('/')}}/img/forum/verified2.png" width="25" height="25">
                                    {{ $comentario['user_name'] }}  *  {{ \App\Http\Controllers\ForumController::time_elapsed_string($comentario['created_time']) }}
                                </h6>
                            @endif

                        </div>
                        <div class="card-body">
                            <h5 style="color:black;"> {!! Purify::clean($comentario['message']) !!} </h5>
                        </div>
                    </div>
                    @endif


                @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection
