@extends('theme.public.default', ['page_title' => ''])

@section('content')
    <div class="row g-3">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center">
            <div class="card info-card sales-card">

                <div class="card-body pt-3">
                    <a href="/raffle/download-csv" class="btn btn-outline-success btn-lg m-1">Download CSV</a>
                    <a href="https://wheelofnames.com/sju-apq" target="_blank" class="btn btn-outline-info btn-lg m-1">Open Raffle</a>
                </div>

            </div>
        </div>
        
    </div>
@endsection