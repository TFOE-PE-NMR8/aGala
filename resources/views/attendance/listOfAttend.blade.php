@extends('theme.attendance.default2', ['page_title' => 'Attendance'])

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <br>
                    <table id="example" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Ref #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Club</th>
                                <th scope="col">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
//                        dd($listOfGuest)
                        @endphp
                            @foreach($listOfGuest as $listOfGuest)
                                @if($listOfGuest->guest_id)
                                    <tr>
                                        <th scope="row">{{ $loop->index+1}}</th>
                                        <td>
                                            {{ $listOfGuest->guest->name }}
                                        </td>
                                        <td>
                                            {{ $listOfGuest->guest->registrant->club }}
                                        </td>
                                        <td>
                                            {{ $listOfGuest->registrant->phone }}
                                        </td>
                                    </tr>
                                @elseif($listOfGuest->registrant_id)
                                    <tr>
                                        <th scope="row">{{ $loop->index+1}}</th>
                                        <td>
                                            {{ $listOfGuest->registrant->first_name }} {{ $listOfGuest->registrant->last_name }}
                                        </td>
                                        <td>
                                            {{ $listOfGuest->registrant->club }}
                                        </td>
                                        <td>
                                            {{ $listOfGuest->registrant->phone }}
                                        </td>
                                    </tr>
                                @endif

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection

@section('scripts')
    <link rel="stylesheet" type="text/css" href="{!! asset('theme/vendor/simple-datatables/style.css') !!}">
    <script src="{!! asset('theme/vendor/simple-datatables/simple-datatables.js') !!}"></script>

    <script>
        $(document).ready(function () {
            const dataTable = new simpleDatatables.DataTable("#example");
        });
    </script>
@endsection
