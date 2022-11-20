@extends('theme.default', ['page_title' => 'Registrants'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <registrants-table url="{{ route('api.registrants.datatable') }}"></registrants-table>
        </div>
    </div>
@endsection