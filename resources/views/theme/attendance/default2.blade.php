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
<!-- Vendor JS Files -->
{{--<script src="{!! asset('theme/vendor/apexcharts/apexcharts.min.js') !!}"></script>--}}
<script src="{!! asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
{{--<script src="{!! asset('theme/vendor/chart.js/chart.min.js') !!}"></script>--}}
{{--<script src="{!! asset('theme/vendor/echarts/echarts.min.js') !!}"></script>--}}
<script src="{!! asset('theme/vendor/quill/quill.min.js') !!}"></script>
<script src="{!! asset('theme/vendor/simple-datatables/simple-datatables.js') !!}"></script>
{{--<script src="{!! asset('theme/vendor/tinymce/tinymce.min.js') !!}"></script>--}}
{{--<script src="{!! asset('theme/vendor/php-email-form/validate.js') !!}"></script>--}}

<!-- Template Main JS File -->
<script src="{!! asset('theme/js/jquery.min.js') !!}"></script>
<script src="{!! asset('theme/js/jquery.validate.min.js') !!}"></script>
<script src="{!! asset('theme/js/jquery-ui.min.js') !!}"></script>
<script src="{!! asset('theme/js/sweetalert.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('theme/js/adapter.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('theme/js/instascan.min.js') !!}"></script>
<script src="{!! asset('theme/js/main.js') !!}"></script>
@yield('scripts')

<script type="text/javascript">
    var success = "{{ Session::get('success') }}";
    if (success) {
        swal ({
            text: success,
            icon: 'success',
            button: 'OK',
        });
    }
    var deleted = "{{ Session::get('deleted') }}";
    if (deleted) {
        swal ({
            text: deleted,
            icon: 'error',
            button: 'OK',
        });
    }
    var error = "{{ Session::get('error') }}";
    if (error) {
        swal ({
            text: error,
            icon: 'error',
            button: 'OK',
        });
    }
    var danger = "{{ Session::get('flash_danger') }}";
    if (danger) {
        swal ({
            text: danger,
            icon: 'error',
            button: 'OK',
        });
    }
    var warning = "{{ Session::get('warning') }}";
    if (warning) {
        swal ({
            text: warning,
            icon: 'info',
            button: 'OK',
        });
    }
    var errors = $('.alert-errors').length;
    var html_errors = $('#html_errors').val();
    if(errors){
        swal ({
            text: html_errors,
            icon: 'error',
            button: 'OK',
        });
    }
</script>



</body>

</html>
