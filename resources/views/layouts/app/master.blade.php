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
      @include('layouts.app.css')
      @yield('style')
   </head>
   <body>
      <!-- Loader starts-->
      <div class="loader-wrapper">
         <div class="typewriter">
            <h1>A carregar..</h1>
         </div>
      </div>
      <!-- Loader ends-->
      <!-- page-wrapper Start-->
      <div class="page-wrapper">
           @yield('content')
      </div>
      @include('layouts.app.script')
   </body>
</html>
