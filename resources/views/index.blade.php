@extends('theme.public.default', ['page_title' => ''])

@section('styles')
    <style>
        .item .headline {
            font-size: 2rem;
            font-weight: 700;
        }
    </style>
@endsection

@section('content')
    <div class="container col-xxl-8 px-4 py-2">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-2">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="{!! asset('images/gala.png') !!}" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
            </div>
            <div class="col-lg-6 text-center">
                <img src="{!! asset('theme/img/logo-small.png') !!}">
                <h2 class="display-5 fw-bold lh-1 mb-3">NMR8<br/>a'Gala Night</h2>
                <p class="lead">
                    a'GALA Night is a pleasant, evening held in Frosty Bites Dome where people from various clubs of the Fraternal Order of Eagles Philippine Eagles can talk, dance and meet new friends to feel sweet home.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="/registration" class="btn btn-outline-primary">Register</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-3 item">
                <div class="item-inner">
                    <div class="icon"><i class="icon-house"></i></div>
                    <div class="headline">1st year</div>
                    <div class="description">1st edition of a'GALA Night</div>
                </div>
            </div>
            <div class="col-12 col-sm-3 item">
                <div class="item-inner">
                    <div class="icon"><i class="icon-chat"></i></div>
                    <div class="headline">{{ $total_guests }} guests</div>
                    <div class="description">Successfully registered guests</div>
                </div>
            </div>
            <div class="col-12 col-sm-3 item">
                <div class="item-inner">
                    <div class="icon"><i class="icon-possibilities"></i></div>
                    <div class="headline">Performers</div>
                    <div class="description">Musicians, DJs, dancers</div>
                </div>
            </div>
            <div class="col-12 col-sm-3 item">
                <div class="item-inner">
                    <div class="icon"><i class="icon-tie"></i></div>
                    <div class="headline">Raffle prizes</div>
                    <div class="description">Each ticket has a chance to win</div>
                </div>
            </div>
        </div>
    </div>
@endsection
