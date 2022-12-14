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
    <script script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
  
 
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@endsection