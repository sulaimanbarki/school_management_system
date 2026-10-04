@extends('admin.admin_master')

@section('Admindata')
<style>
  .role-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
  }
  .role-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  }
  .badge-role {
    font-size: 0.82rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
  }
  .perm-group-header {
    background: #f4f6f9;
    border-radius: 8px;
    padding: 8px 14px;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
  }
  .perm-pill {
    display: inline-block;
    background: #eef2f7;
    color: #334155;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.78rem;
    margin: 2px 4px 2px 0;
    border: 1px solid #e2e8f0;
  }
  .stat-widget {
    border-radius: 12px;
    padding: 16px 20px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .stat-widget .count {
    font-size: 1.8rem;
    font-weight: 800;
    line-height: 1;
  }
  .stat-widget .label {
    font-size: 0.85rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .stat-widget i {
    font-size: 2.4rem;
    opacity: 0.7;
  }
</style>

<div class="content-header p-0 mb-3">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold" style="font-size: 1.6rem;">
          <i class="fas fa-shield-alt text-primary mr-2"></i> Roles & Permissions Control
        </h1>
        <p class="text-muted mb-0 small">Dynamic role-based access control engine powered by Spatie</p>
      </div>
      <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill" data-toggle="modal" data-target="#createRoleModal">
          <i class="fas fa-plus-circle mr-1"></i> Create New Role
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm px-3 shadow-sm rounded-pill ml-2" data-toggle="modal" data-target="#assignUserModal">
          <i class="fas fa-user-tag mr-1"></i> Assign Role to Admin
        </button>
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
  <div class="col-md-4">
    <div class="stat-widget shadow-sm" style="background: linear-gradient(135deg, #4f46e5, #6366f1);">
      <div>
        <div class="count">{{ $roles->count() }}</div>
        <div class="label">Defined Roles</div>
      </div>
      <i class="fas fa-user-shield"></i>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-widget shadow-sm" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8);">
      <div>
        <div class="count">{{ $permissions->count() }}</div>
        <div class="label">Total System Permissions</div>
      </div>
      <i class="fas fa-key"></i>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-widget shadow-sm" style="background: linear-gradient(135deg, #059669, #10b981);">
      <div>
        <div class="count">{{ $admins->count() }}</div>
        <div class="label">Configured Admin Accounts</div>
      </div>
      <i class="fas fa-users-cog"></i>
    </div>
  </div>
</div>

<!-- Roles Table Card -->
<div class="card role-card mb-4">
  <div class="card-header bg-white border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
    <h5 class="card-title font-weight-bold text-dark mb-0">
      <i class="fas fa-list text-primary mr-1"></i> Configured System Roles
    </h5>
    <span class="badge badge-light border px-2 py-1">{{ $roles->count() }} Roles Available</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="thead-light">
          <tr>
            <th style="width: 60px;" class="text-center">#</th>
            <th>Role Name</th>
            <th>Guard</th>
            <th>Assigned Permissions</th>
            <th>Assigned Admins</th>
            <th style="width: 160px;" class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $index => $role)
          <tr>
            <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
            <td>
              <span class="badge-role 
                @if($role->name === 'SuperAdmin') bg-danger text-white
                @elseif($role->name === 'Admin') bg-primary text-white
                @elseif($role->name === 'Principal') bg-info text-white
                @elseif($role->name === 'Accountant') bg-success text-white
                @elseif($role->name === 'Teacher') bg-warning text-dark
                @else bg-secondary text-white @endif">
                <i class="fas fa-shield-alt mr-1"></i> {{ $role->name }}
              </span>
            </td>
            <td><code class="text-muted">{{ $role->guard_name }}</code></td>
            <td>
              @if($role->name === 'SuperAdmin')
                <span class="badge badge-pill badge-success px-2 py-1"><i class="fas fa-check-double mr-1"></i> All Permissions (Full Access)</span>
              @else
                <span class="badge badge-pill badge-primary px-2 py-1">{{ $role->permissions->count() }} Permissions</span>
                <small class="text-muted d-block mt-1">
                  {{ $role->permissions->take(3)->pluck('name')->implode(', ') }}
                  @if($role->permissions->count() > 3)
                    <span class="text-muted font-italic">+{{ $role->permissions->count() - 3 }} more</span>
                  @endif
                </small>
              @endif
            </td>
            <td>
              @php $assignedCount = $role->users->count(); @endphp
              @if($assignedCount > 0)
                <span class="badge badge-pill badge-info px-2 py-1"><i class="fas fa-user-check mr-1"></i> {{ $assignedCount }} User(s)</span>
              @else
                <span class="badge badge-pill badge-light border text-muted px-2 py-1">0 Assigned</span>
              @endif
            </td>
            <td class="text-right">
              <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Configure Permissions">
                <i class="fas fa-edit mr-1"></i> Edit
              </a>
              @if($role->name !== 'SuperAdmin')
              <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete role {{ $role->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" title="Delete Role">
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

<!-- Modal: Create New Role -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('roles.store') }}" method="POST" class="modal-content" style="border-radius: 12px; overflow: hidden;">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title font-weight-bold" id="createRoleModalLabel">
          <i class="fas fa-plus-circle mr-1"></i> Create New Custom Role
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
        <div class="form-group">
          <label for="new_role_name" class="font-weight-bold">Role Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="new_role_name" name="name" required placeholder="e.g. Librarian, Warden, IT Support">
          <small class="form-text text-muted">A clear, unique identifier for this role.</small>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
          <label class="font-weight-bold mb-0">Assign Permissions to this Role</label>
          <div>
            <button type="button" class="btn btn-xs btn-outline-primary" id="btnCheckAll">Check All</button>
            <button type="button" class="btn btn-xs btn-outline-secondary" id="btnUncheckAll">Uncheck All</button>
          </div>
        </div>

        @foreach($groupedPermissions as $groupName => $perms)
        <div class="card mb-3 border">
          <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
            <span class="font-weight-bold text-dark"><i class="fas fa-layer-group text-primary mr-1"></i> {{ $groupName }}</span>
            <small class="text-muted">{{ count($perms) }} permissions</small>
          </div>
          <div class="card-body py-2">
            <div class="row">
              @foreach($perms as $perm)
              <div class="col-md-6 mb-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input perm-checkbox" id="perm_create_{{ $perm->id }}" name="permissions[]" value="{{ $perm->name }}">
                  <label class="custom-control-label font-weight-normal small" for="perm_create_{{ $perm->id }}">
                    <code>{{ $perm->name }}</code>
                  </label>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary rounded-pill px-3" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm">Save Role</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Assign Role to Admin -->
<div class="modal fade" id="assignUserModal" tabindex="-1" role="dialog" aria-labelledby="assignUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('roles.assignAdmin') }}" method="POST" class="modal-content" style="border-radius: 12px; overflow: hidden;">
      @csrf
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title font-weight-bold" id="assignUserModalLabel">
          <i class="fas fa-user-tag mr-1"></i> Assign Dynamic Role to Admin Staff
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="assign_admin_id" class="font-weight-bold">Select Admin / Staff Account</label>
          <select name="admin_id" id="assign_admin_id" class="form-control" required>
            <option value="">-- Choose Account --</option>
            @foreach($admins as $adm)
              @php $currRole = $adm->roles->first()?->name ?? 'No Spatie Role'; @endphp
              <option value="{{ $adm->id }}">{{ $adm->name }} ({{ $adm->email }}) [Current: {{ $currRole }}]</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="assign_role_name" class="font-weight-bold">Select Role to Assign</label>
          <select name="role_name" id="assign_role_name" class="form-control" required>
            <option value="">-- Choose Role --</option>
            @foreach($roles as $r)
              <option value="{{ $r->name }}">{{ $r->name }} ({{ $r->permissions->count() }} permissions)</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary rounded-pill px-3" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success rounded-pill px-4 font-weight-bold shadow-sm">Assign Role</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnCheck = document.getElementById('btnCheckAll');
    const btnUncheck = document.getElementById('btnUncheckAll');
    if (btnCheck && btnUncheck) {
      btnCheck.addEventListener('click', function () {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true);
      });
      btnUncheck.addEventListener('click', function () {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
      });
    }
  });
</script>
@endsection
