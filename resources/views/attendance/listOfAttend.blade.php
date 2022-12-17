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
                            @foreach($listOfGuest as $listOfGuest)
                                <tr>
                                    <th scope="row">{{ $loop->index+1}}</th>
                                    <td>
                                        @if ($listOfGuest->name)
                                            {{ $listOfGuest->name }}
                                        @else
                                            {{ $listOfGuest->first_name }} {{ $listOfGuest->last_name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($listOfGuest->name)
                                            {{ $listOfGuest->club }}
                                        @else
                                            {{ $listOfGuest->club }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($listOfGuest->name)
                                            {{ $listOfGuest->phone }}
                                        @else
                                            {{ $listOfGuest->phone }}
                                        @endif
                                    </td>
                                </tr>
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
