@extends('layouts.app.master')
@section('title', 'Password reset')

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
                    <form class="theme-form" action="reset" method="POST">
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
                      <h4>Esqueceu-se da sua Password?</h4>
                      <span>Confirme o seu email</span>
                      <br/>

                      <br/>
                      <div class="form-group">
                        <label for="email" class="col-form-label pt-0">Email</label>
                        <input class="form-control" type="email" name="email" required="">
                      </div>
                      <div class="form-group form-row mt-3 mb-0">
                        <button class="btn btn-info btn-block" type="submit">Confirmar</button>
                      </div>
                    </form>
                  </div>
                  <div class="sub-cont">
                    <div class="img">
                      <div class="img__text m--up">
                        <h2>Voltar ao login</h2>
                        <br><br>
                        <a class="btn btn-info btn-lg" href="{{route('login')}}"><span class="icon-back-left"></span></a>
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
