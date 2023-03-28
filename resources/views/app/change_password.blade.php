@extends('layouts.app.master')
@section('title', 'Mudar password')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<!-- login page start-->
<div class="container-fluid p-0">
  <div class="authentication-main">
     <div class="row">
        <div class="col-md-12">
          <div class="auth-innerright">
            <div class="authentication-box">
              <div class="card-body p-0">

                <div class="cont text-center">
                  <div class="login">
                    <form class="theme-form" action="newpassword" method="POST">
                    @csrf
                    @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-center">{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        <br>
                    @endif
                    @if(session()->has('sucess'))
                            <div class="alert alert-success text-center">
                                <ul>
                                    <li class="text-center">{{ session()->get('sucess') }}</li>
                                </ul>
                            </div>
                        <br>
                    @endif
                      <h4>Insira a nova password</h4>
                      <span>É necessário o código de confirmação enviado para o endereço de email</span>
                      <br/>

                      <br/>
                      <div class="form-group">
                        <label for="codigo" class="col-form-label pt-0">Código de confirmação</label>
                        <input class="form-control" type="text" name="codigo" required="">
                      </div>
                      <br>
                      <div class="form-group">
                        <label for="email" class="col-form-label pt-0">Email</label>
                        <input class="form-control" type="email" name="email" required="">
                      </div>
                      <div class="form-group">
                        <label for="password" class="col-form-label">Palavra-chave</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required="">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                      <div class="form-group">
                        <label for="password" class="col-form-label">Palavra-chave</label>
                        <input class="form-control" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
                      </div>
                      <div class="form-group form-row mt-3 mb-0">
                        <button class="btn btn-primary btn-block" type="submit">Confirmar</button>
                      </div>
                    </form>
                  </div>
                  <div class="sub-cont">
                    <div class="img">
                      <div class="img__text m--up">
                        <h2>Não recebeu o email?</h2>
                        <a class="btn btn-primary btn-lg" href="{{route('reset')}}">Preencha o formulário novamente</a>
                      </div>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
  </div>
</div>
<!-- login page end-->
@endsection

@section('script')


@endsection
