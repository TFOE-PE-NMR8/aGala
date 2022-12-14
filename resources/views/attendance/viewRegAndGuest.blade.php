@extends('theme.attendance.default2', ['page_title' => ''])

@section('content')
<a href="{{ URL::to('/attendance') }}"><button type="button" class="btn btn-info">Back</button></a>
<br><br>
<div class="card text-center">
    <br>
    <h4>Registrant Name: {{ $getRegistrant->first_name }} {{ $getRegistrant->last_name }}</h4>
    <h4>Total Amount: ₱   {{ $getRegistrant->total_amount }}</h4>
    <h4>
        Paid Amount: 
        @if ($getRegistrant->paid_amount != null)
            ₱ {{ $getRegistrant->paid_amount }}
        @else
            ₱ 0
        @endif
    </h4>
    <h4>Balance Amount: ₱ {{$balance}}</h4>
    <br>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Relation</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                <th scope="row">1</th>
                <td>{{ $getRegistrant->first_name }} {{ $getRegistrant->last_name }} {{ $getRegistrant->id }}</td>
                <td>Registrant</td>
                <td>N/A</td>
                <td>
                    <button type="button" class="btn btn-primary">Attend</button>
                </td>
            </tr> -->
            @foreach($arrayRegistrantAndGuest as $data)
                
            <tr>
                <th scope="row">{{ $loop->index+1}}</th>
                <td>
                    @if ($data->name)
                    {{ $data->name }}
                    @else
                    {{ $data->first_name }} {{ $data->last_name }}
                    @endif
                </td>
                <td>
                    @if ($data->name)
                    Guest
                    @else
                    Registrant
                    @endif
                </td>
                <td>
                    @if ($data->relation)
                    {{ $data->relation }}
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    @if ( $loop->index+1 <= $countNotYetPaid)
                    @if ($data->is_attend != "Attend")
                        @php
                        $status = "";
                        if ($data->name) {
                            $status = "Guest";
                        } else {
                            $status = "Registrant";
                        }
                        @endphp
                        <!-- <button type="button" class="btn btn-primary btn-attend" data-url="{{ URL::to('/attend/'.$status) }}">Attend</button> -->
                        <form action="{{ URL::to('/attend/'.$status.'/'.$data->id) }}" method="POST">
                            @csrf 
                            @method('POST')
                            <button type="button" class="btn btn-primary btn-attend">
                            Attend
                            </button>
                        </form>	   
                        <!-- <button type="button" class="btn btn-primary btn-attend" data-url="{{ URL::to('/attend/'.$status.'/'.$data->id) }}">
                            Attend
                        </button> -->
                    @else
                        <button type="button" class="btn btn-success">
                            Attended
                        </button>
                    @endif
                    
                    @else 
                    <button type="button" class="btn btn-warning">Not Yet Paid</button>
                    @endif
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <script script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>
        $('.btn-attend').click(function(){
			swal ({
			    title: "Are you sure?",
			      text: "Are you sure?",
			      icon: "warning",
			      buttons: true,
			      dangerMode: true,
			}).then((result) => {
				if (result) {
					$(this).closest('form').submit();
				}
			})
		});
    </script>
@endsection