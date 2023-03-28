@extends('layouts.app.master')
@section('title', 'Coming Soon BG Image')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid p-0 m-0">
   <div class="comingsoon comingsoon-bgimg">
      <div class="comingsoon-inner text-center">
         <h5>WE ARE COMING SOON</h5>
         <div class="countdown" id="clockdiv">
            <ul>
               <li><span class="time digits" id="days"></span><span class="title">days</span></li>
               <li><span class="time digits" id="hours"></span><span class="title">Hours</span></li>
               <li><span class="time digits" id="minutes"></span><span class="title">Minutes</span></li>
               <li><span class="time digits" id="seconds"></span><span class="title">Seconds</span></li>
            </ul>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script src="{{route('/')}}/assets/js/countdown.js"></script>
@endsection