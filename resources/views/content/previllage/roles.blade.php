@extends('layouts/contentNavbarLayout')

@section('title', 'Role')

@section('content')

<!-- Add styles for flex layout -->
<style>
  .flex {
    justify-content: space-between;
    display: flex;
  }
</style>

<!-- Success Message -->
@if (session('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('message') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
  <div class="flex">
    <h5 class="card-header">Roles</h5>
    <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#basicModal">
      Add New
    </button>
  </div>

  <hr>

  <!-- Table -->
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>NAME</th>
          <th>ROLE</th>
          <th>STATUS</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($roles as $role)
        <tr>
          <td>{{ $role->id }}</td>
          <td>{{ $role->name }}</td>
          <td>{{ $role->role }}</td>
          <td>
            @if($role->status == 1)
            <span class="badge rounded-pill bg-label-primary me-1">Active</span>
            @else
            <span class="badge rounded-pill bg-label-secondary me-1">Inactive</span>
            @endif
          </td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="mdi mdi-dots-vertical"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item editRole" href="javascript:void(0);" data-id="{{ $role->id }}">
                  <i class="mdi mdi-pencil-outline me-1"></i> Edit
                </a>
                <a class="dropdown-item deleteRole" href="javascript:void(0);" data-id="{{ $role->id }}">
                  <i class="mdi mdi-trash-can-outline me-1"></i> Delete
                </a>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<hr class="my-5">

<!-- Modal (Add/Edit) -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="roleForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitle">Add New Role</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="roleId" name="roleId">
          <div class="row">
            <div class="col mb-4 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="nameBasic" class="form-control" name="name" placeholder="Enter Name">
                <label for="nameBasic">Name</label>
              </div>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="role" class="form-control" name="role" placeholder="Enter Role">
                <label for="role">Role</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Auto-close the alert -->
<script>
  setTimeout(function() {
    var alertElement = document.querySelector('.alert');
    if (alertElement) {
      var alertInstance = new bootstrap.Alert(alertElement);
      alertInstance.close();
    }
  }, 1500);
</script>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+2hO2g2Z4Y0/RZ4U4k0b8yHhVJ3p3a0cF+3tu7y" crossorigin="anonymous"></script>

<!-- Role Form and Modal Logic -->
<script>
 $(document).ready(function() {
    // Show the Add Modal
    $('.btn-primary').click(function() {
        $('#modalTitle').text('Add New Role');
        $('#roleForm')[0].reset();
        $('#roleId').val('');
        $('#basicModal').modal('show');
    });

    // Edit Role
    $(document).on('click', '.editRole', function() {
        var id = $(this).data('id');
console.log(id);

        $.ajax({
            url: '/roleedit/' + id,
            type: 'GET',
            success: function(response) {
                $('#modalTitle').text('Edit Role');
                $('#roleId').val(response.id);
                $('#nameBasic').val(response.name);
                $('#role').val(response.role);
                $('#basicModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    // Submit Add/Edit Role
    $('#roleForm').submit(function(e) {
        e.preventDefault();

        var id = $('#roleId').val();
        var formData = $(this).serialize();
        var url = id ? '/roleupdate/' + id : '/rolesave';

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                location.reload(); // Refresh the page to show the changes
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    // Delete Role
    $(document).on('click', '.deleteRole', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this role?')) {
            $.ajax({
                url: '/roledelete', // Ensure this is the correct endpoint
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    location.reload(); // Refresh the page after deletion
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });
});
</script>
@endsection
