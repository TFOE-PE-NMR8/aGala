@extends('theme.default', ['page_title' => 'Guests'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <guests-table url="{{ route('api.registrants.datatable') }}"></guests-table>
        </div>
    </div>
@endsection