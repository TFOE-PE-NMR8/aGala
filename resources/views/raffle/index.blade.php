@extends('theme.public.default', ['page_title' => ''])

@section('content')
<div class="row">
  <div class="col-sm-9">
    <div class="card">
      <div class="card-body">
          <iframe src="{{$url}}" width="100%" height="800px" scrolling="no" frameborder="0"></iframe>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-center">a'Gala Raffle Menu</h5><hr>
        
        <div class="dropdown text-center">
          <a href="/dashboard" class="btn btn-outline-secondary btn-lg m-1 border-0">⬅</a>
          <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Generate
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="/raffle/raffle-main-generate">Main Raffle Entry</a>
            <a class="dropdown-item" href="/raffle/raffle-100-generate">1st 100 Raffle Entry</a>
          </div>

          <button class="btn btn-info dropdown-toggle m-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Load
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="/raffle/raffle-main">Main Raffle List</a>
              <a class="dropdown-item" href="/raffle/raffle-100">1st 100 Raffle List</a>
            </div>
            <hr>
            <?php
              $CurPageURL =$_SERVER['REQUEST_URI'];
              if (str_contains($CurPageURL, '100'))
              {
                $mode = 1;
              }else{
                $mode = 0;
              }
            ?>
            <form action="/raffle/winner" method="post" class="">
              @csrf
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Winner's Name" autocomplete="off" aria-label="Winner's Name" aria-describedby="basic-addon2" name="name">
                <input type="hidden" class="form-control" name="mode" value="{{$mode}}">
                <div class="input-group-append">
                  <button class="btn btn-success" type="submit">ADD</button>
                </div>
              </div>
            </form>
            <h3 class="mt-4"><b>🎉 Winners List 🎉</b></h2>
      </div>
      <div class="text-left">
        @if (count($winner_100)>0 || count($winner_main)>0)
          <ul class="list-group list-group-flush">
            @foreach ($winner_100 as $item)
              <li class="list-group-item">💯 {{$item}} </li>
            @endforeach
            @foreach ($winner_main as $item)
              <li class="list-group-item">Ⓜ️ {{$item}} </li>
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

