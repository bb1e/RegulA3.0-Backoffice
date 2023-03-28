<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Poco admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Poco admin template, dashboard template, flat admin template, responsive admin template, web app (Laravel 8)">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{route('/')}}/img/logo/logo_mini.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{route('/')}}/img/logo/logo_mini.png" type="image/x-icon">
    <title>Regul-A - @yield('title')</title>
    @include('layouts.simple.css')
    @yield('style')

  </head>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="typewriter">
        <h1>A carregar...</h1>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
      <!-- Page Header Start-->
      @include('layouts.simple.header')
      <!-- Page Header Ends -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        @include('layouts.simple.sidebar')
        <!-- Page Sidebar Ends-->
        <!-- Right sidebar Start-->
        @include('layouts.simple.chat_sidebar')
        <!-- Right sidebar Ends-->
        <div class="page-body">
            <div class="container-fluid">
              <div class="page-header">
                 <div class="row">
                    <div class="col-lg-6 main-header">
                        @yield('breadcrumb-title')
                    </div>
                    <div class="col-lg-6 breadcrumb-right">
                       <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="pe-7s-home"></i></a></li>
                          @yield('breadcrumb-items')
                       </ol>
                    </div>
                 </div>
              </div>
            </div>
            @yield('content')

        </div>
        <!-- footer start-->
        @include('layouts.simple.footer')
      </div>
    </div>
    @include('layouts.simple.script')
  </body>
</html>
