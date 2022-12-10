@extends('theme.public.default', ['page_title' => ''])

@section('content')
<?php
  $CurPageURL =$_SERVER['REQUEST_URI'];
  if (str_contains($CurPageURL, '100'))
  {
    $mode = 1;
    $ttl = "a'Gala - 1st 100 Paid Raffle";
  }else{
    $mode = 0;
    $ttl = "a'Gala - Main Raffle";
  }
?>
<div class="row">
  <div class="col-sm-9">
    <div class="card glass">
      <div class="card-body">
          <iframe src="{{$url}}" width="100%" height="800px" scrolling="no" frameborder="0"></iframe>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card glass" style="height: 828px;">
      <div class="card-body">
        <h5 class="card-title text-center">{{$ttl}}</h5>
        @if(session('success'))
          <div class="alert rounded-1 p-2" style="background: #ff5967; font-size: 13px" id="alert">
              {{session('success')}}
              <span onclick="hide(); return false" id="close-btn" style="float: right; cursor: pointer;">x</span>
          </div>
          
        @endif
        <hr>
        <div class="dropdown text-center">
          <a href="/dashboard" class="btn btn-secondary" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">⬅</a>
          <button class="btn btn-warning dropdown-toggle rounded-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
            Generate
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="/raffle/raffle-main-generate">Main Raffle Entry</a>
            <a class="dropdown-item" href="/raffle/raffle-100-generate">1st 100 Raffle Entry</a>
          </div>
          <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
              Load
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="/raffle/raffle-main">Main Raffle List</a>
            <a class="dropdown-item" href="/raffle/raffle-100">1st 100 Raffle List</a>
          </div>
          <hr>
          <form action="/raffle/winner" method="post" class="">
            @csrf
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Winner's Name" autocomplete="off" aria-label="Winner's Name" aria-describedby="basic-addon2" name="name" style="background: rgba(9, 183, 149, -0.69); border-color: darkgreen;" required>
              <input type="hidden" class="form-control" name="mode" value="{{$mode}}">
              <div class="input-group-append">
                <button class="btn btn-outline-success p-2" type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">ADD</button>
              </div>
            </div>
          </form>
          <h3 class="mt-4"><b>🎉 Winners List 🎉</b></h2>
      </div>
      <div class="text-left">
        @if (count($winner_100)>0 || count($winner_main)>0)
          <ul class="list-group list-group-flush">
            @foreach ($winner_100 as $item)
              <li class="list-group-item" style="background: rgba(9, 183, 149, -0.69);">💯 {{$item}} </li>
            @endforeach
            @foreach ($winner_main as $item)
              <li class="list-group-item" style="background: rgba(9, 183, 149, -0.69);">Ⓜ️ {{$item}} </li>
            @endforeach
          </ul>
        @else
          <p class="text-center">No winners yet.</p>
        @endif
      </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  var x = document.getElementById("alert");
  function hide(){
     document.getElementById('alert').style.display="none";
  }
</script>
@endsection
