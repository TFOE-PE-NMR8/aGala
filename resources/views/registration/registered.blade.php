@extends('theme.public.default')
@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3 col-sm-12">
            <div class="card">
                <div class="card-body" id="capture">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="text-center">
                                <svg viewBox="1 -11 511.99988 511" xmlns="http://www.w3.org/2000/svg" style="fill:#2BBD13;width: 110px;">
                                    <path d="m507.949219 232.933594-42.386719-56.027344 1.367188-70.25c.175781-8.953125-5.625-16.929688-14.199219-19.527344l-67.246094-20.367187-40.125-57.679688c-5.121094-7.363281-14.515625-10.417969-22.992187-7.46875l-66.367188 23.09375-66.371094-23.09375c-8.46875-2.945312-17.867187.101563-22.988281 7.46875l-40.125 57.679688-67.246094 20.367187c-8.574219 2.597656-14.375 10.574219-14.199219 19.527344l1.367188 70.25-42.386719 56.027344c-5.402343 7.136718-5.402343 16.996094 0 24.132812l42.386719 56.027344-1.367188 70.25c-.175781 8.953125 5.625 16.933594 14.199219 19.527344l67.246094 20.371094 40.125 57.675781c5.121094 7.363281 14.515625 10.417969 22.988281 7.46875l66.371094-23.09375 66.371094 23.09375c8.46875 2.945312 17.867187-.101563 22.988281-7.46875l40.125-57.679688 67.246094-20.367187c8.574219-2.597656 14.375-10.574219 14.199219-19.527344l-1.367188-70.25 42.386719-56.027344c5.402343-7.136718 5.402343-16.996094 0-24.132812zm-78.464844 61.550781c-2.707031 3.582031-4.132813 7.96875-4.046875 12.457031l1.207031 62.039063-59.40625 17.992187c-4.308593 1.304688-8.050781 4.023438-10.621093 7.71875l-35.429688 50.933594-58.613281-20.394531c-4.257813-1.484375-8.890625-1.484375-13.148438 0l-58.613281 20.394531-35.429688-50.933594c-2.570312-3.695312-6.3125-6.414062-10.621093-7.71875l-59.40625-17.992187 1.207031-62.039063c.085938-4.488281-1.339844-8.875-4.046875-12.453125l-37.4375-49.488281 37.4375-49.484375c2.710937-3.582031 4.136719-7.96875 4.046875-12.457031l-1.207031-62.039063 59.40625-17.992187c4.308593-1.304688 8.050781-4.023438 10.621093-7.71875l35.429688-50.933594 58.617188 20.394531c4.253906 1.480469 8.886718 1.480469 13.144531 0l58.613281-20.394531 35.433594 50.933594c2.570312 3.691406 6.3125 6.414062 10.617187 7.71875l59.40625 17.992187-1.207031 62.039063c-.085938 4.488281 1.339844 8.875 4.046875 12.453125l37.4375 49.488281zm-70.554687-122.816406c7.808593 7.808593 7.808593 20.472656 0 28.285156l-118.382813 118.378906c-7.792969 7.792969-20.464844 7.820313-28.285156 0l-59.191407-59.1875c-7.808593-7.8125-7.808593-20.476562 0-28.285156 7.8125-7.8125 20.476563-7.8125 28.285157 0l45.050781 45.046875 104.238281-104.238281c7.808594-7.8125 20.472657-7.8125 28.285157 0zm0 0"></path>
                                </svg>

                                <h3 class="mt-2">Thank you for Registering</h3>
                                <div class="text-secondary mt-4">
                                    <p>This receipt will be sent via email</p>
                                    <p>Reference number will be sent to your number via SMS</p>
                                    <p>Please save the QR code. It will serve as e-ticket in the Gala event.</p>
                                </div>

                                <h4>Reference #: {{ $data->reference_number }}</h4>

                                <div class="row mt-5">
                                    <div class="col-lg-6 text-lg-end col-sm-12 text-sm-center mb-2">
                                        <img src="data:image/png;base64, {!! base64_encode(QrCode::errorCorrection('H')->format('png')->merge('theme/img/eagles-logo.png', .4, true)->size(200)->generate($data->reference_number)) !!}" />
                                   </div>
                                    <div class="col-lg-6 text-lg-start col-sm-12 text-sm-center mb-2">
                                        <span class="fw-bolder">{{ ucfirst($data->registrant->title) }} {{ ucfirst($data->registrant->first_name) }} {{ ucfirst($data->registrant->last_name) }}</span>
                                        <br>
                                        <span>{{ $data->registrant->club }}</span>
                                        @if ($data->registrant->guests->count() > 0)
                                        <div class="mt-3">
                                            <span class="fw-bold">Guests</span>:
                                            <ol class="list">
                                                @foreach ($data->registrant->guests as $guest)
                                                    <li>{{ ucfirst($guest->relation) }} {{ ucfirst($guest->name) }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                        @endif
                                        <div class="mt-3">
                                            Total amount to pay: <strong>PHP {{$data->total_amount}}</strong>
                                        </div>
                                    </div>
                                </div>

                                <registered-button registration_id="{{$data->id}}"></registered-button>

                                <div class="row border-top pt-4 mt-3 page-break-avoid">
                                    <div class="col-md-12 mb-2">
                                        <h4>Where to Pay?</h4>
                                    </div>
                                    <div class="row pt-2 mb-4">
                                        <div class="col-md-4 pt-2">
                                            <img src="{{ asset('theme/img/gcash-logo.png') }}" alt="GCash" width="100">
                                        </div>
                                        <div class="col-md-8 text-md-start text-sm-center">
                                            <span><strong>09177228744</strong> - Kuya Angelo</span>
                                            <br />
                                            <span><strong>09271897249</strong> - Kuya Ryan</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 pt-2">
                                            <img src="{{ asset('theme/img/palawan-express.png') }}" alt="Palawan Express" width="100">
                                        </div>
                                        <div class="col-md-8 text-md-start text-sm-center">
                                            <span>Name: <strong>KIER M. PAQUE</strong></span><br />
                                            <span>Phone: <strong>09971240523</strong></span><br />
                                            <span>Address: <strong>PRK.15 TIBANGA ILIGAN CITY</strong></span>
                                        </div>
                                    </div>
                                </div>

                                 <div class="row pt-4 mt-3 border-top page-break-avoid">
                                     <div class="col-md-12 mb-2 mb-4">
                                         <h4>Next Step, How to Pay?</h4>
                                     </div>
                                     <div class="col-md-12 text-start">
                                         <h5>For GCash payment:</h5>
                                         <ol>
                                             <li>Send your payment via GCash to any of these number <strong>09177228744</strong> / <strong>09271897249</strong></li>
                                             <li>Download the screenshot of your payment.</li>
                                             <li>Send the receipt to our facebook page (<a href="https://www.facebook.com/aGalaNmr8">https://fb.com/aGalaNmr8</a>) messenger and indicate your name.</li>
                                             <li>You will receive a text confirmation shortly.</li>
                                         </ol>
                                         <h5>For Palawan Express Payment</h5>
                                         <ol>
                                             <li>Send the payment to: <br />
                                                Name: <strong>KIER M. PAQUE</strong><br/>
                                                 Phone: <strong>09971240523</strong><br/>
                                                 Address: <strong>PRK.15 TIBANGA ILIGAN CITY</strong>
                                             </li>
                                             <li>
                                                 Take a photo of the receipt, and send to our facebook page (<a href="https://www.facebook.com/aGalaNmr8">https://fb.com/aGalaNmr8</a>) messenger.
                                             </li>
                                             <li>You will receive a text confirmation shortly.</li>
                                         </ol>
                                     </div>
                                 </div>

                                 <div class="row pt-4 mt-3 border-top page-break-avoid">
                                     <div class="col-md-12 mb-2 mb-4">
                                         <h4>Payment Status</h4>
                                     </div>
                                     <div class="col-md-12 text-start">
                                        @if ($data->total_amount == $data->paid_amount)
                                             <h5 style="text-align: center;"><div class="icon" style="color: green"> <i class="bi bi-check-circle-fill" style="margin-right: 10px; font-size: 2.5rem; vertical-align: middle;"></i>Payment Confirmed!</div></h5>
                                        @else
                                            <h5 style="text-align: center;"><div class="icon" style="color: red"> <i class="bi bi-clock-history" style="margin-right: 10px; font-size: 2.5rem; vertical-align: middle;"></i>We are waiting for your payment</div></h5>
                                        @endif
                                        
                                         
                                     </div>
                                     <div class="col-md-12 text-start" style="margin-top: 20px">
                                         @if ($data->total_amount == $data->paid_amount)
                                         <ul>
                                             <li>Thank you for your payment Kuya/Ate! See you on December 18.</li>
                                         </ul>
                                         @else
                                         <ul>
                                             <li>Comeback here to see if your payment has been verified after you paid your ticket.</li>
                                         </ul>
                                         @endif
                                        
                                 </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
