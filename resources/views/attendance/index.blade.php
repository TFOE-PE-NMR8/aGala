@extends('theme.attendance.default2', ['page_title' => 'Attendance'])

@section('content')
<!-- <div class="row">

    <div class="col-md-6">
        <video id="preview" width="100%"></video>
    </div>
    <div class="col-md-6">
        <label>SCAN QR CODE</label>
        <input type="text" name="text" id="text" readonyy="" placeholder="scan qrcode" class="form-control">
    </div>
</div> -->

<div class="card text-center">
  <div class="card-header">
    <video id="preview" width="50%" height="75%" class="trigger" ></video>
    <div class="col-md-12 py-4">
        <a href="#" class="btn btn-primary card-text" id="inp-ref-no" data-url="{{ URL::to('/scanQr') }}">Input Reference Number</a>
    </div>
  </div>
  <br>
  <div class="card-body ref-num text-center" style="display: none" >
    <div class="input-group ref-inp text-center" >
        <span class="input-group-text" id="ref-string">AG2022-</span>
        <input type="text" placeholder="Enter Reference Number" name="qr_code" id="qr_code" data-id="qr_code" class="form-control" data-url="{{ URL::to('/scanQr') }}">
        <button type="submit" class="btn btn-success search_qr">Search</button>
    </div>
    <div class="col-md-12 py-4">
        <a href="#" class="btn btn-primary card-text m-1" id="scan-qr-code" data-url="{{ URL::to('/scanQr') }}">Scan QR Code</a>
    </div>
  </div>
</div>

<div class="append-registrant-guest"></div>

@endsection

@section('scripts')
    <script>
        function scanQR(){

            var value = "";

            let scanner = new Instascan.Scanner({ video: document.getElementById('preview'),
                mirror: false,
                captureImage: false,
                backgroundScan: true,
                refractoryPeriod: 10000,
            });

            Instascan.Camera.getCameras().then(function(cameras){

                if(cameras.length > 1 ) {
                    scanner.start(cameras[1]);
                }
                else if(cameras.length === 1 ){
                    scanner.start(cameras[0]);
                } else{
                    alert('No cameras found');
                }

            }).catch(function(e) {
                console.error(e);
            });


            scanner.addListener('scan',function(c){
                value = c;
                var url = $("#scan-qr-code").data('url');
                var div = $('.append-registrant-guest');
                div.empty();
                location.href = url+"/"+c;
            });
        };

        $(document).ready(function() {
            scanQR();
            $('#scan-qr-code').on('click', function(){
                $(".card-header").show();
                $(".ref-num").hide();
            });

            $("#inp-ref-no").on('click', function(){
                $(".card-header").hide();
                $(".ref-num").show();
            });

            $(".search_qr").on('click', function(){
                var reference_number = "";
                var ref_string = $("#ref-string").text();
                var qr_code = $("#qr_code").val();
                var url = $("#qr_code").data('url');
                var div = $('.append-registrant-guest');
                reference_number = ref_string+qr_code;

                if (qr_code == "") {
                    swal({
                      title: "Warning!",
                      text: "Please Input Reference Number, Thank You!",
                      icon: "warning",
                      button: "Close",
                    });
                } else {
                    location.href = url+"/"+reference_number;
                }
            });

        });

    </script>


@endsection




