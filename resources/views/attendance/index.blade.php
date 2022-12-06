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
  </div>
  <div class="card-body">
    <!-- <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
    <br>
    <a href="#" class="btn btn-primary card-text" id="scan-qr-code" data-url="{{ URL::to('/scanQr') }}">Scan QR Code</a>
  </div>
</div>

<div class="append-registrant-guest"></div>

@endsection

@section('scripts')
    <script script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>


    <script>
        $(document).ready(function() {
            $(".card-header").hide();
        });

        var value = "";
        $("#scan-qr-code").click(function(){
            $(".card-header").show();

            let scanner = new Instascan.Scanner({ video: document.getElementById('preview'),
                    mirror: false,
                    captureImage: false,
                    backgroundScan: true,
                    refractoryPeriod: 5000,
                });
            
            Instascan.Camera.getCameras().then(function(cameras){
                    if(cameras.length > 0 ){
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

                    $.ajax({
                        url: url+"/"+c,
                        success:function(data){
                            // console.log(data)
                            $(".card-header").hide();
                            div.append(data);
                            $('#viewRegistrantAndGuest').modal('show');
                        }
                    });
                });

        });
        
        
    </script>


@endsection



    
