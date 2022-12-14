@extends('theme.attendance.default2', ['page_title' => 'Users'])

@section('content')


<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                          
                            <form action="{{ URL::to('/usersEdit/'.$user->id) }}" method="post">
                                @csrf   
                                @method('POST')   
                                    <div class="modal-body">
                                        <input type="text" name="name" class="form-control mb-3" placeholder="Name" value="{{ $user->name }}" required>
                                        <input type="email" name="email" class="form-control mb-3" placeholder="Email" value="{{ $user->email }}" required>
                                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                                        <select name="role_id" class="form-control mb-3" id="role_select">
                                            <option value="">-- Role(Skip if Role is only User) --</option>
                                            @foreach($roles as $i => $role)
                                                <option value="{{ $role->id }}" 
                                                    @php 
                                                        if (!empty($user->roles->first()->id))
                                                            if ($user->roles->first()->id == $role->id)
                                                                echo 'selected'
                                                    @endphp >
                                                    {{ ucwords($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div class="modal-footer">
                                    <a href="{{ URL::to('/list-users') }}"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Return</button></a> &nbsp;
                                    <button type="submit" class="btn btn-primary">Save changes</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

