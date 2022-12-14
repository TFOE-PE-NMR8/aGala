  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Role</h5>
      </div>
      <div class="modal-body">
        <form action="{{ URL::to('/create_roles') }}" method="post">
            @csrf      
            <div class="modal-body">
                <h6>Enter Role:</h6>
                <input type="text" name="name" class="form-control mb-3" placeholder="Role Name" required>
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