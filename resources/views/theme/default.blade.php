<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{  isset($page_title) ? 'aGala -' . $page_title : 'aGala Page' }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{!! asset('theme/img/favicon.png') !!}" rel="icon">
    <link href="{!! asset('theme/img/apple-touch-icon.png') !!}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    @include('theme.styles')
    @yield('styles')

</head>

<body>

@include('theme.header')
@include('theme.sidebar')

<main id="main" class="main">
    <div id="app">
        <div class="pagetitle">
            <h1>{{  isset($page_title) ? $page_title : 'aGala' }}</h1>
        </div><!-- End Page Title -->

        <section class="section">
            @yield('content')
    <!--        <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Example Card</h5>
                            <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Example Card</h5>
                            <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
                        </div>
                    </div>

                </div>
            </div>-->
        </section>
    </div>
</main><!-- End #main -->

@include('theme.footer')
@include('theme.scripts')
@yield('scripts')

</body>

</html>