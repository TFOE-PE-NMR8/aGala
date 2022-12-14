

  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Users</h5>
      </div>
      <div class="modal-body">
        <form action="{{ URL::to('/create_users') }}" method="post">
            @csrf      
            <div class="modal-body">
                <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                <select name="role" class="form-control mb-3" id="role_select">
                    <option value="">-- Role(Skip if Role is only User) --</option>
                    @foreach($roles as $i => $role)
                        <option value="{{ $role->name }}">{{ ucwords($role->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>