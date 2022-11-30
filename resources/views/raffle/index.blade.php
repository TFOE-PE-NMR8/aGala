@extends('theme.public.default', ['page_title' => ''])

@section('content')
    <div class="row g-3">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center">
            <div class="card info-card sales-card">

                <div class="card-body pt-3">
                    <a href="/dashboard" class="btn btn-outline-secondary btn-lg m-1">⬅</a>
                    {{-- <a href="/raffle/download-csv" class="btn btn-outline-success btn-lg m-1">Download CSV</a> --}}
                    <a href="/raffle/raffle-100" class="btn btn-outline-info btn-lg m-1">1st 100 Raffle</a>
                    <a href="/raffle/raffle-main" class="btn btn-outline-primary btn-lg m-1">Main Raffle</a>
                    <a href="/raffle/raffle-main-generate" class="btn btn-outline-primary btn-lg m-1">Generate Main Raffle</a>
                </div>
                
                <div class="card-body">
                    <iframe src="{{$data}}" width="100%" height="800px" scrolling="no" frameborder="0"></iframe>
                </div>

            </div>
        </div>
        
    </div>
@endsection