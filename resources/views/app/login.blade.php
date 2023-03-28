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
		      <div class="w-100">
			  <form class="theme-form" action="login/auth" method="POST">
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
			  </form>

			  <hr></hr>
			  <div class="mb-0 text-center theme-form">
			      <a class="btn mt-3 shadow-lg bg-white rounded w-100"  onClick="socialSignin();">
				  <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
				  Login com Google
			      </a>
			      <br>

			      <form id="social-login-form" action="login/googleauth" method="POST" style="display: none;">
				  {{ csrf_field() }}
				  <input id="social-login-access-token" name="social-login-access-token" type="hidden">
				  <input id="social-login-tokenId" name="social-login-tokenId" type="hidden">
			      </form>
			  </div>
		      </div>
                  </div>
                  <div class="sub-cont">
                    <div class="img">
                      <div class="img__text m--up">
                        <h2>Esqueceu-se da password?</h2>
                        <br><br>
                        <br>
                        <a class="btn btn-light btn-lg" href="{{route('reset.index')}}"><span class="icofont icofont-paper"></span></a>
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

      const auth = firebase.auth()
      var googleProvider = new firebase.auth.GoogleAuthProvider();


      async function socialSignin(){
        return await auth.setPersistence(firebase.auth.Auth.Persistence.SESSION)
            .then(() =>  firebase.auth().signInWithPopup(googleProvider).then(result => {
              result.user.getIdToken().then(result => {
                document.getElementById('social-login-tokenId').value = result;
                document.getElementById('social-login-form').submit();
              }).catch(error => {
                  // do error handling
                  console.log(error);
              });
        }));
      }

</script>

@endsection
