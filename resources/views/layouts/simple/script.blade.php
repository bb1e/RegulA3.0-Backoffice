<!-- latest jquery-->
<script src="{{route('/')}}/assets/js/jquery-3.5.1.min.js"></script>
<script src="{{route('/')}}/assets/js/bootstrap/popper.min.js"></script>
<!-- Bootstrap js-->
<script src="{{route('/')}}/assets/js/bootstrap/bootstrap.js"></script>
<!-- feather icon js-->
<script src="{{route('/')}}/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="{{route('/')}}/assets/js/icons/feather-icon/feather-icon.js"></script>
<!-- Sidebar jquery-->
<script src="{{route('/')}}/assets/js/sidebar-menu.js"></script>
<script src="{{route('/')}}/assets/js/config.js"></script>
<script src="{{route('/')}}/assets/js/chat-menu.js"></script>
@yield('script')
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{route('/')}}/assets/js/script.js"></script>
<!--
<script src="{{route('/')}}/assets/js/theme-customizer/customizer.js"></script>
-->
<!-- login js-->
<script type="module">
    import {getAuth,signOut} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-auth.js'
    import {initializeApp} from 'https://www.gstatic.com/firebasejs/9.9.0/firebase-app.js'

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

    const app = initializeApp(config);

    const auth = getAuth()

    function logout(){
        signOut(auth).then(() => window.location.href = this.href)
    }
</script>
