@extends('layouts.simple.master')
@section('title', 'Fórum')
@inject('Purify', \Stevebauman\Purify\Facades\Purify::class)

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
	<h2>Fórum<span></span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item active">Fórum</li>
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

        <div class="text-center">
            <a href="{{route('forum.personal')}}" class="btn btn-info btn-lg text-center"> Ver as minhas publicações</a>
        </div>
        <br>

        <div class="card">
            <div class="card-body text-center">
                <h4><b>Nova publicação</b></h4>
                <form enctype="multipart/form-data" action="{{ route('forum.publicar') }}" method="POST">
                    <div class="form-group">
                        <input id="textinput" name="title" type="text" placeholder="Título" required="" class="form-control btn-square input-md">
                        <br>
                        <textarea class="form-control" id="description" placeholder="Descrição" name="description" rows="2"></textarea>
                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token()}}">
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit">Publicar</button>
                </form>
            </div>
        </div>


         <div class="card">
            <div class="card-header">
               <h5 class="pull-left">Publicações</h5>
            </div>
            <div class="card-body">
               <div class="tabbed-card">
                  <ul class="pull-right nav nav-pills nav-primary" id="pills-clrtab1" role="tablist">
                     <li class="nav-item"><a class="nav-link active" id="pills-clrhome-tab1" data-toggle="pill" href="#pills-clrhome1" role="tab" aria-controls="pills-clrhome1" aria-selected="true">Recentes</a></li>
                     <li class="nav-item"><a class="nav-link" id="pills-clrprofile-tab1" data-toggle="pill" href="#pills-clrprofile1" role="tab" aria-controls="pills-clrprofile1" aria-selected="false">Populares</a></li>
                  </ul>
                  <div class="tab-content" id="pills-clrtabContent1">
                     <div class="tab-pane fade show active" id="pills-clrhome1" role="tabpanel" aria-labelledby="pills-clrhome-tab1">
                        {{-- aqui vai tar um foreach para cada thread --}}
                        @foreach ($threadsRecentes as $thread)
                            <a class="col-sm-12" href="{{route('forum.thread', $thread->getKey())}}">
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
                            </a>
                        @endforeach
                        {{-- até aqui!!! --}}
                     </div>
                     <div class="tab-pane fade" id="pills-clrprofile1" role="tabpanel" aria-labelledby="pills-clrprofile-tab1">

                        {{-- aqui vai tar um foreach para cada thread --}}
                        @foreach ($threadsPopulares as $thread)
                        <a class="col-sm-12" href="{{route('forum.thread', $thread->getKey())}}">
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
                        </a>
                    @endforeach
                    {{-- até aqui!!! --}}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection
