@extends('theme.public.default', ['page_title' => ''])

@section('content')
    <div class="row g-3">
        <div class="col-md-2"></div>
        <div class="col-md-8 text-center">
            
            <div class="card info-card sales-card">
                
                <div class="card-body pt-3">
                    
                    {{-- <a href="/raffle/download-csv" class="btn btn-outline-success btn-lg m-1">Download CSV</a>
                    <a href="/raffle/raffle-100" class="btn btn-outline-info btn-lg m-1">1st 100 Raffle</a>
                    <a href="/raffle/raffle-main" class="btn btn-outline-primary btn-lg m-1">Main Raffle</a>
                    <a href="/raffle/raffle-main-generate" class="btn btn-outline-primary btn-lg m-1">Generate Main Raffle</a> --}}
                    
                    <div class="dropdown">
                        <a href="/dashboard" class="btn btn-outline-secondary btn-lg m-1 border-0">⬅</a>
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                      </div>
                </div>
                
                
                <div class="card-body">
                    <iframe src="{{$url}}" width="100%" height="800px" scrolling="no" frameborder="0"></iframe>
                </div>

            </div>
        </div>
    </div>

@endsection

