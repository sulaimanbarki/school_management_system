@extends('admin.admin_master')

@section('Admindata')
<style>
  .admin-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
  }
  .stat-box {
    border-radius: 12px;
    padding: 16px 20px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .stat-box .count {
    font-size: 1.8rem;
    font-weight: 800;
    line-height: 1;
  }
  .stat-box .label {
    font-size: 0.85rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .stat-box i {
    font-size: 2.2rem;
    opacity: 0.75;
  }
  .user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #4f46e5;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.95rem;
  }
</style>

<div class="content-header p-0 mb-3">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-users-cog text-primary mr-2"></i> System Administrators & Staff Accounts
        </h1>
        <p class="text-muted mb-0 small">Create and manage administrative login credentials and assigned roles</p>
      </div>
      <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill font-weight-bold" data-toggle="modal" data-target="#createAdminModal">
          <i class="fas fa-user-plus mr-1"></i> Add New Admin User
        </button>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-sm px-3 shadow-sm rounded-pill ml-2">
          <i class="fas fa-shield-alt mr-1"></i> Configure Roles & Permissions
        </a>
      </div>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
  <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
  <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<!-- Overview Stats -->
<div class="row">
  <div class="col-md-3">
    <div class="stat-box shadow-sm" style="background: linear-gradient(135deg, #4f46e5, #6366f1);">
      <div>
        <div class="count">{{ $admins->count() }}</div>
        <div class="label">Total Admins</div>
      </div>
      <i class="fas fa-users"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-box shadow-sm" style="background: linear-gradient(135deg, #059669, #10b981);">
      <div>
        <div class="count">{{ $admins->where('isactive', 1)->count() }}</div>
        <div class="label">Active Accounts</div>
      </div>
      <i class="fas fa-user-check"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-box shadow-sm" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
      <div>
        <div class="count">{{ $admins->filter(fn($a) => $a->hasRole('SuperAdmin'))->count() }}</div>
        <div class="label">Super Administrators</div>
      </div>
      <i class="fas fa-user-shield"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-box shadow-sm" style="background: linear-gradient(135deg, #0284c7, #38bdf8);">
      <div>
        <div class="count">{{ $campuses->count() }}</div>
        <div class="label">Campuses Managed</div>
      </div>
      <i class="fas fa-university"></i>
    </div>
  </div>
</div>

<!-- Admins Table Card -->
<div class="card admin-card mb-4">
  <div class="card-header bg-white border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
    <h5 class="card-title font-weight-bold text-dark mb-0">
      <i class="fas fa-list text-primary mr-1"></i> Active Administrator Accounts
    </h5>
    <span class="badge badge-light border px-2 py-1">{{ $admins->count() }} Accounts</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="adminsTable">
        <thead class="thead-light">
          <tr>
            <th style="width: 50px;" class="text-center">#</th>
            <th>Administrator</th>
            <th>Email Address</th>
            <th>Campus</th>
            <th>Assigned Role</th>
            <th>Status</th>
            <th style="width: 260px;" class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($admins as $index => $adm)
          @php
            $roleName = $adm->roles->first()?->name ?? 'No Role Assigned';
            $campusName = $adm->campus?->CampusName ?? 'Campus #' . $adm->campusid;
          @endphp
          <tr>
            <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="user-avatar mr-2">
                  {{ strtoupper(substr($adm->name, 0, 1)) }}
                </div>
                <div>
                  <div class="font-weight-bold text-dark">{{ $adm->name }}</div>
                  @if($adm->phone1 && $adm->phone1 !== '0000000000')
                    <small class="text-muted"><i class="fas fa-phone-alt mr-1"></i>{{ $adm->phone1 }}</small>
                  @endif
                </div>
              </div>
            </td>
            <td><code class="text-primary font-weight-bold">{{ $adm->email }}</code></td>
            <td><span class="badge badge-light border px-2 py-1"><i class="fas fa-school mr-1 text-muted"></i>{{ $campusName }}</span></td>
            <td>
              <span class="badge 
                @if($roleName === 'SuperAdmin') badge-danger
                @elseif($roleName === 'Admin') badge-primary
                @elseif($roleName === 'Principal') badge-info
                @elseif($roleName === 'Accountant') badge-success
                @elseif($roleName === 'Teacher') badge-warning
                @else badge-secondary @endif px-2 py-1" style="font-size: 0.8rem;">
                <i class="fas fa-shield-alt mr-1"></i> {{ $roleName }}
              </span>
            </td>
            <td>
              @if($adm->isactive == 1)
                <span class="badge badge-pill badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Active</span>
              @else
                <span class="badge badge-pill badge-danger px-2 py-1"><i class="fas fa-ban mr-1"></i> Inactive</span>
              @endif
            </td>
            <td class="text-right">
              @if($adm->id !== Auth::id())
              <a href="{{ route('admin.impersonate', $adm->id) }}" 
                target="_blank" 
                class="btn btn-sm btn-outline-warning rounded-pill px-2 py-1 font-weight-bold" 
                title="Impersonate {{ $adm->name }} in new tab">
                <i class="fas fa-user-secret mr-1"></i> Impersonate
              </a>
              @endif

              <button type="button" 
                class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1 btn-edit-admin ml-1"
                data-id="{{ $adm->id }}"
                data-name="{{ $adm->name }}"
                data-email="{{ $adm->email }}"
                data-phone="{{ $adm->phone1 }}"
                data-campusid="{{ $adm->campusid }}"
                data-role="{{ $roleName }}"
                data-isactive="{{ $adm->isactive }}">
                <i class="fas fa-edit mr-1"></i> Edit
              </button>

              @if($adm->id !== Auth::id() && $adm->id !== 1 && !$adm->hasRole('SuperAdmin'))
              <form action="{{ route('admin.users.destroy', $adm->id) }}" method="POST" class="d-inline-block ml-1" onsubmit="return confirm('Are you sure you want to delete admin user {{ $adm->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" title="Delete Admin">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal: Create New Admin User -->
<div class="modal fade" id="createAdminModal" tabindex="-1" role="dialog" aria-labelledby="createAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content" style="border-radius: 12px; overflow: hidden;">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title font-weight-bold" id="createAdminModalLabel">
          <i class="fas fa-user-plus mr-1"></i> Create New Admin User
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="new_admin_name" class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="new_admin_name" name="name" required placeholder="e.g. John Doe">
        </div>

        <div class="form-group">
          <label for="new_admin_email" class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="new_admin_email" name="email" required placeholder="e.g. john@school.com">
          <small class="form-text text-muted">Used as the login username at <code>/admin/login</code>.</small>
        </div>

        <div class="form-group">
          <label for="new_admin_password" class="font-weight-bold">Password <span class="text-danger">*</span></label>
          <input type="password" class="form-control" id="new_admin_password" name="password" required minlength="6" placeholder="Min. 6 characters">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="new_admin_campus" class="font-weight-bold">Campus <span class="text-danger">*</span></label>
              <select name="campusid" id="new_admin_campus" class="form-control" required>
                @foreach($campuses as $campus)
                  <option value="{{ $campus->campusid }}">{{ $campus->CampusName }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="new_admin_role" class="font-weight-bold">Role <span class="text-danger">*</span></label>
              <select name="role" id="new_admin_role" class="form-control" required>
                @foreach($roles as $role)
                  <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="new_admin_phone" class="font-weight-bold">Phone Number (Optional)</label>
          <input type="text" class="form-control" id="new_admin_phone" name="phone1" placeholder="e.g. 03001234567">
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary rounded-pill px-3" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm">Create Admin User</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Admin User -->
<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editAdminForm" method="POST" class="modal-content" style="border-radius: 12px; overflow: hidden;">
      @csrf
      @method('PUT')
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title font-weight-bold" id="editAdminModalLabel">
          <i class="fas fa-user-edit mr-1"></i> Edit Admin User
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="edit_admin_name" class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="edit_admin_name" name="name" required>
        </div>

        <div class="form-group">
          <label for="edit_admin_email" class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="edit_admin_email" name="email" required>
        </div>

        <div class="form-group">
          <label for="edit_admin_password" class="font-weight-bold">Reset Password (Leave blank to keep unchanged)</label>
          <input type="password" class="form-control" id="edit_admin_password" name="password" minlength="6" placeholder="Leave empty to keep existing password">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="edit_admin_campus" class="font-weight-bold">Campus <span class="text-danger">*</span></label>
              <select name="campusid" id="edit_admin_campus" class="form-control" required>
                @foreach($campuses as $campus)
                  <option value="{{ $campus->campusid }}">{{ $campus->CampusName }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="edit_admin_role" class="font-weight-bold">Role <span class="text-danger">*</span></label>
              <select name="role" id="edit_admin_role" class="form-control" required>
                @foreach($roles as $role)
                  <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="edit_admin_phone" class="font-weight-bold">Phone Number</label>
              <input type="text" class="form-control" id="edit_admin_phone" name="phone1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="edit_admin_isactive" class="font-weight-bold">Account Status <span class="text-danger">*</span></label>
              <select name="isactive" id="edit_admin_isactive" class="form-control" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary rounded-pill px-3" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success rounded-pill px-4 font-weight-bold shadow-sm">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('.btn-edit-admin').on('click', function () {
      var id = $(this).data('id');
      var name = $(this).data('name');
      var email = $(this).data('email');
      var phone = $(this).data('phone');
      var campusid = $(this).data('campusid');
      var role = $(this).data('role');
      var isactive = $(this).data('isactive');

      $('#edit_admin_name').val(name);
      $('#edit_admin_email').val(email);
      $('#edit_admin_phone').val(phone);
      $('#edit_admin_campus').val(campusid);
      $('#edit_admin_role').val(role);
      $('#edit_admin_isactive').val(isactive);
      $('#edit_admin_password').val('');

      $('#editAdminForm').attr('action', '/admin/admins/' + id);
      $('#editAdminModal').modal('show');
    });
  });
</script>
@endsection
