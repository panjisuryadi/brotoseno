@can('delete_products')
<!-- <button id="delete" class="btn btn-outline-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
    }
    ">
    <i class="bi bi-trash"></i>&nbsp;
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.delete', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button> -->

<button class="btn btn-outline-danger btn-sm" onclick="openPasswordModal2(event, '{{ $data->id }}')">
    <i class="bi bi-trash">Lebur</i>
</button>

<form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.update_lebur', $data->id) }}" method="POST">
    @csrf
    @method('get')
</form>
@endcan



<!-- <button id="delete" class="btn btn-outline-warning btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
    }
    ">
    <i class="bi bi-view-list"></i>&nbsp;
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.delete', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button> -->

<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="delete-password" class="form-label">Enter password to confirm:</label>
        <input type="password" id="delete-password" class="form-control" placeholder="Password">
        <div id="password-error" class="text-danger mt-2 d-none">Wrong password!</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="confirmPasswordAndDelete()">Confirm</button>
      </div>
    </div>
  </div>
</div>


<script>
    let deleteFormId = null;

    function openPasswordModal2(event, id) {
        event.preventDefault();
        deleteFormId = 'destroy' + id;
        document.getElementById('delete-password').value = '';
        document.getElementById('password-error').classList.add('d-none');
        let modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    }

    function confirmPasswordAndDelete() {
        const enteredPassword = document.getElementById('delete-password').value;
        const correctPassword = 'luvenia12345'; // ⚠️ Replace this with a secure check or variable!

        if (enteredPassword === correctPassword) {
            document.getElementById(deleteFormId).submit();
        } else {
            document.getElementById('password-error').classList.remove('d-none');
        }
    }
</script>
