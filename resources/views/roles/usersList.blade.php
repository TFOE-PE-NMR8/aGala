@extends('theme.attendance.default2', ['page_title' => 'Users'])

@section('content')
@include('roles._create')
<div class="container-fluid">
    <div class="animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Create
                </button>
            </div>
            <br>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Roles</th>
                        <th width="5%">Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @php
                                $roles = null;
                            @endphp
                            @foreach($user->roles as $role)
                                @php
                                    $roles .= ucwords($role->name).', ';
                                @endphp
                            @endforeach
                            {{ substr($roles,0,-2) }}
                        </td>
                        <!-- {{-- <td>
                        <a href="{{ url('/users/' . $user->id) }}" class="btn btn-block btn-primary"><i class="fa fa-eye"></i></a>
                        </td> --}} -->
                        <td>
                            <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn btn-block btn-primary">Edit</a>
                              
                        </td>
                        <td>
                            <form action="{{ url('/users/' . $user->id . '/delete') }}" method="POST">
                                @csrf 
                                @method('POST')
                                <button type="button" class="btn btn-danger btn-delete">
                                    Delete
                                </button>
                            </form>	   
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>       
    
    <script>
        $('.btn-delete').click(function(){
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


