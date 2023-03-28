@extends('layouts.app.master')
@section('title', 'Login')

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
                    <form class="theme-form" action="/login/auth" method="POST">
                    @csrf
                      <h4>Bem-Vindo</h4>
                      <br/>
                      
                      <br/>
                      <div class="form-group">
                        <label for="email" class="col-form-label pt-0">Email</label>
                        <input class="form-control" type="email" name="email" required="">
                      </div>
                      <div class="form-group">
                        <label for="password" class="col-form-label">Palavra-chave</label>
                        <input class="form-control" type="password" name="password" required="">
                      </div>
                      <div class="checkbox p-0">
                        <input id="checkbox1" type="checkbox">
                        <label for="checkbox1">Remember me</label>
                      </div>
                      <div class="form-group form-row mt-3 mb-0">
                        <button class="btn btn-primary btn-block" type="submit">LOGIN</button>
                      </div>
                      <div class="login-divider"></div>
                      <div class="social mt-3">
                        <div class="form-row btn-showcase">
                          <div class="col-md-4 col-sm-6">
                            <button class="btn social-btn btn-fb">Facebook</button>
                          </div>
                          <div class="col-md-4 col-sm-6">
                            <button class="btn social-btn btn-twitter">Twitter</button>
                          </div>
                          <div class="col-md-4 col-sm-6">
                            <button class="btn social-btn btn-google">Google + </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="sub-cont">
                    <div class="img">
                      <div class="img__text m--up">
                        <h2>New here?</h2>
                        <p>Sign up and discover great amount of new opportunities!</p>
                      </div>
                      <div class="img__text m--in">
                        <h2>One of us?</h2>
                        <p>If you already has an account, just sign in. We've missed you!</p>
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