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
                        <br><br>
                    @endif
                    @if(session()->has('erro'))
                        <div class="cont text-center">
                            <div class="alert alert-success text-center">
                                <ul>
                                    <li class="text-center">{{ session()->get('erro') }}</li>
                                </ul>
                            </div>
                        </div>
                        <br><br>
                    @endif
                <div class="cont text-center">
                  <div class="login">
                    <form class="theme-form" action="/change/password" method="POST">
                    @csrf
                      <h4>Mudar a password</h4>
                      <br/>

                      <div class="form-group">
                        <label for="password_old" class="col-form-label">Password antiga</label>
                        <input class="form-control" type="password" name="password_old" required autocomplete="">
                      </div>
                      <br>
                      <div class="form-group">
                        <label for="password" class="col-form-label">Password nova</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required="">
                    </div>
                      <div class="form-group">
                        <label for="password_confirmation" class="col-form-label">Confirmação da password nova</label>
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
                        <a class="btn btn-light btn-lg" href="{{route('default')}}">Cancelar</a>
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
