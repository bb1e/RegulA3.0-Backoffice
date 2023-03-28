@extends('layouts.app.master')
@section('title', 'Signup')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid p-0">
   <!-- login page start-->
   <div class="authentication-main">
      <div class="row">
         <div class="col-md-12">
            <div class="auth-innerright">
               <div class="authentication-box">
                  <div class="card-body">
                     <div class="cont text-center">
                        <div>
                           <form class="theme-form">
                              <h4 class="text-center">NEW USER</h4>
                              <h6 class="text-center">Enter your Username and Password For Signup</h6>
                              <div class="form-row">
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <input class="form-control" type="text" placeholder="First Name">
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <input class="form-control" type="text" placeholder="Last Name">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <input class="form-control" type="text" placeholder="User Name">
                              </div>
                              <div class="form-group">
                                 <input class="form-control" type="password" placeholder="Password">
                              </div>
                              <div class="form-row">
                                 <div class="col-sm-4">
                                    <button class="btn btn-primary" type="submit">Sign Up</button>
                                 </div>
                                 <div class="col-sm-8">
                                    <div class="text-left mt-2 m-l-20">Are you already user?  <a class="btn-link text-capitalize" href="{{ route('login') }}">Login</a></div>
                                 </div>
                              </div>
                              <div class="form-divider"></div>
                              <div class="social mt-3">
                                 <div class="form-row btn-showcase">
                                    <div class="col-sm-4">
                                       <button class="btn social-btn btn-fb">Facebook</button>
                                    </div>
                                    <div class="col-sm-4">
                                       <button class="btn social-btn btn-twitter">Twitter</button>
                                    </div>
                                    <div class="col-sm-4">
                                       <button class="btn social-btn btn-google">Google +</button>
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
                              <div class="img__btn"><span class="m--up">Sign in</span><span class="m--in">Sign up</span></div>
                           </div>
                           <div>
                              <form class="theme-form">
                                 <h4>LOGIN</h4>
                                 <h6>Enter your Username and Password</h6>
                                 <div class="form-group">
                                    <label class="col-form-label pt-0">Your Name</label>
                                    <input class="form-control" type="text" required="">
                                 </div>
                                 <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <input class="form-control" type="password" required="">
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
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- login page end-->
</div>
@endsection

@section('script')
<script src="{{route('/')}}/assets/js/login.js"></script>
@endsection