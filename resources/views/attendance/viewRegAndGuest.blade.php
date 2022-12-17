@extends('theme.attendance.default2', ['page_title' => ''])

@section('content')
<a href="{{ URL::to('/attendance') }}"><button type="button" class="btn btn-info">Back</button></a>
<br><br>
<div class="card text-center">
    <br>
    <h4>Registrant Name: {{ $getRegistrant->first_name }} {{ $getRegistrant->last_name }}</h4>
    <h4>Total Amount: ₱   {{ $getRegistrationId->total_amount }}</h4>
    <h4>
        Paid Amount:
        @if ($getRegistrationId->paid_amount != null)
            ₱ {{ $getRegistrationId->paid_amount }}
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
    <div class="row">
        <div class="col-md-12 text-center py-3">
            <a href="{{ route('attendance') }}" class="btn btn-primary card-text m-1" id="scan-qr-code">Scan Another</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $('.btn-attend').click(function(){
			swal ({
			    title: "Are you sure?",
			      text: "You won't be able to undo this.",
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
