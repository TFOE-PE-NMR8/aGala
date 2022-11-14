<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{  isset($page_title) ? 'aGala - ' . $page_title : 'aGala Page' }}</title>
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

<body class="toggle-sidebar">

@include('theme.public.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{  isset($page_title) ? $page_title : '' }}</h1>
    </div><!-- End Page Title -->

    <section class="section">
        @yield('content')
    </section>

</main><!-- End #main -->

@include('theme.footer')
@include('theme.public.scripts')
@yield('scripts')

</body>

</html>