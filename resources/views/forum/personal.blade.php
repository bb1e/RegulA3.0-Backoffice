@extends('layouts.simple.master')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)

@section('title', 'As minhas publicações')

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2><span>As minhas </span>Publicações</h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item">Fórum</li>
	<li class="breadcrumb-item active">As minhas publicações</li>
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
                {{-- aqui vai tar um foreach para cada thread --}}
                @foreach ($personalThreads as $thread)
                        <div class="card">
                            <div class="card-header b-t-info">

                        <a class="col-sm-12" href="{{route('forum.thread', $thread->getKey())}}">
                                    <h4 class="pull-left" style="color:black;"> <b>{!! Purify::clean($thread->getValue()['title']) !!}</b> </h4>
                        </a>

                            <form method="POST" action="/forum/personal/{{$thread->getKey()}}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            <button class="btn btn-danger btn-lg pull-right" type="button" data-toggle="modal" data-original-title="test" data-target="#modal-{{ $thread->getKey() }}"><span class="icon-trash"></span></button>
                            <div class="modal fade" id="modal-{{ $thread->getKey() }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:black;">Apagar publicação</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body" style="color:black;">Tem a certeza que pretende apagar a publicação <strong> {!! Purify::clean($thread->getValue()['title']) !!}</strong>?</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="button" data-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-danger" type="submit">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </form>
                            </div>

                    <a class="col-sm-12" href="{{route('forum.thread', $thread->getKey())}}">
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
                    </a>
                @endforeach
                {{-- até aqui!!! --}}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection
