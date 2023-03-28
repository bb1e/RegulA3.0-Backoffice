@extends('layouts.app.master')
@section('title', 'Registar')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid p-0">
   <!-- register page start-->
   <div class="authentication-main">
      <div class="row">
         <div class="col-md-12">
            <div class="auth-innerright">
               <div class="authentication-box">
                  <div class="card-body">
                     <div class="cont text-center">
                        <div>
                           <form class="w-100 px-5 theme-form" action="register/auth" method="POST">
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
                              <h4 class="text-center">Registo</h4>
                              <h6 class="text-center">Para concluir o registo é necessário o código de verificação recebido no email do convite</h6>
                              <div class="form-row">
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <input class="form-control" type="text" name="codigo" required="" placeholder="Código de verificação">
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <input class="form-control" type="text" name="nome" required="" placeholder="Nome completo">
                                    </div>
                                 </div>
                              </div>
{{-- accordion como aqui: https://getbootstrap.com/docs/4.0/components/collapse/#accordion-example --}}
			      <div id="accordion">
				  <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">

				      <label id="headingOne" class="btn btn-secondary active" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					  <input type="radio" name="registerOption" id="option1" autocomplete="off" checked value="password"> Registrar com email & password
				      </label>
				      <label id="headingTwo" class="btn btn-secondary collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					  <input type="radio" name="registerOption" id="option2" autocomplete="off" value="google"> Registrar com Google
				      </label>
				  </div>
				  <div>
				      <div class="collapse show" id="collapseOne"  aria-labelledby="headingOne" data-parent="#accordion">
					  <div class="form-group">
					      <input class="form-control" type="text" name="email" placeholder="Email">
					  </div>
					  <div class="form-group">
					      <input class="form-control" type="password" name="password" placeholder="Password">
					  </div>
					  <div class="form-group">
					      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Confirmar Password">
					  </div>
				      </div>
				      <div class="form-group collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordion">
					  <a class="btn mt-3 shadow-lg bg-white rounded"  onClick="socialSignin();">
					      <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
					      <span></span> Registrar com a Google
					  </a>
					  <input id="social-login-tokenId" name="social-login-tokenId" type="hidden">
					  <input id="social-login-email" name="social-login-email" type="hidden">

					  {{-- Use style property so that it can be altered in js (d-none has !important) --}}
					  <div style="display:none" id="google-checkmark">
					      <h2 class="text-success d-inline-block"><i class="fa fa-check"></i></h2>
					  </div>
				      </div>
				  </div>
			      </div>
                              <div class="form-row">
                                 <div class="col-sm-4">
                                    <button class="btn btn-primary" type="submit">Sign Up</button>
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
   <!-- register page end-->
</div>
@endsection

@section('script')

<script src="https://www.gstatic.com/firebasejs/7.22.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.22.0/firebase-auth.js"></script>
<script>

      const config = {
        apiKey: "AIzaSyBlizQNXAj9_zfTboEoek_qzulJQ4vnEBY",
        authDomain: "regula-9d0d3.firebaseapp.com",
        databaseURL: "https://regula-9d0d3-default-rtdb.europe-west1.firebasedatabase.app",
        projectId: "regula-9d0d3",
        storageBucket: "regula-9d0d3.appspot.com",
        messagingSenderId: "673196519117",
        appId: "1:673196519117:web:6c09bff6c1b9360a1a8384",
        measurementId: "G-T9LGMCNGC7"
      };


      firebase.initializeApp(config);

      var googleProvider = new firebase.auth.GoogleAuthProvider();

      async function socialSignin(){
        await firebase.auth().signInWithPopup(googleProvider).then(result => {
            result.user.getIdToken().then(idToken => {
                document.getElementById('social-login-tokenId').value = idToken;
		document.getElementById('social-login-email').value = result.user.email;
		document.getElementById('google-checkmark').style.display = 'block';
		// document.getElementById('social-login-form').submit(); */
            }).catch(console.log);
        });
      };

</script>
@endsection
