@extends('admin.admin_master')

@section('Admindata')
<style>
  .role-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
  }
  .module-card {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.2s ease;
  }
  .module-card:hover {
    box-shadow: 0 6px 16px rgba(0,0,0,0.05);
  }
  .module-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 10px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
</style>

<div class="content-header p-0 mb-3">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-edit text-primary mr-2"></i> Edit Role: <span class="text-primary">{{ $role->name }}</span>
        </h1>
        <p class="text-muted mb-0 small">Customize permissions and access rights for this role</p>
      </div>
      <div class="col-sm-6 text-right">
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill">
          <i class="fas fa-arrow-left mr-1"></i> Back to Roles
        </a>
      </div>
    </div>
  </div>
</div>

<form action="{{ route('roles.update', $role->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="card role-card mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group mb-0">
            <label for="role_name" class="font-weight-bold">Role Name</label>
            <input type="text" class="form-control font-weight-bold" id="role_name" name="name" 
              value="{{ $role->name }}" {{ $role->name === 'SuperAdmin' ? 'readonly' : 'required' }}>
            @if($role->name === 'SuperAdmin')
              <small class="text-muted"><i class="fas fa-lock mr-1"></i> SuperAdmin name is protected and retains full root permissions.</small>
            @endif
          </div>
        </div>
        <div class="col-md-6 d-flex align-items-end justify-content-end">
          <div class="text-right">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mr-2" id="globalCheckAll">
              <i class="fas fa-check-square mr-1"></i> Check All
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill mr-2" id="globalUncheckAll">
              <i class="fas fa-square mr-1"></i> Uncheck All
            </button>
            <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill font-weight-bold shadow-sm">
              <i class="fas fa-save mr-1"></i> Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    @foreach($groupedPermissions as $groupName => $perms)
    <div class="col-md-6">
      <div class="card module-card">
        <div class="module-header">
          <span class="font-weight-bold text-dark">
            <i class="fas fa-cube text-primary mr-1"></i> {{ $groupName }}
          </span>
          <div>
            <button type="button" class="btn btn-xs btn-link text-primary module-toggle-btn" data-target="group-{{ \Illuminate\Support\Str::slug($groupName) }}">
              Toggle All
            </button>
          </div>
        </div>
        <div class="card-body p-3">
          <div class="row">
            @foreach($perms as $perm)
            <div class="col-12 mb-2">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" 
                  class="custom-control-input perm-box group-{{ \Illuminate\Support\Str::slug($groupName) }}" 
                  id="perm_edit_{{ $perm->id }}" 
                  name="permissions[]" 
                  value="{{ $perm->name }}"
                  {{ in_array($perm->name, $rolePermissions) || $role->name === 'SuperAdmin' ? 'checked' : '' }}
                  {{ $role->name === 'SuperAdmin' ? 'disabled' : '' }}>
                <label class="custom-control-label font-weight-normal small" for="perm_edit_{{ $perm->id }}">
                  <code>{{ $perm->name }}</code>
                </label>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="text-right mb-5">
    <a href="{{ route('roles.index') }}" class="btn btn-secondary rounded-pill px-4 mr-2">Cancel</a>
    <button type="submit" class="btn btn-success rounded-pill px-5 font-weight-bold shadow">
      <i class="fas fa-save mr-1"></i> Save Role Permissions
    </button>
  </div>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnCheck = document.getElementById('globalCheckAll');
    const btnUncheck = document.getElementById('globalUncheckAll');
    if (btnCheck && btnUncheck) {
      btnCheck.addEventListener('click', function () {
        document.querySelectorAll('.perm-box:not(:disabled)').forEach(cb => cb.checked = true);
      });
      btnUncheck.addEventListener('click', function () {
        document.querySelectorAll('.perm-box:not(:disabled)').forEach(cb => cb.checked = false);
      });
    }

    document.querySelectorAll('.module-toggle-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const targetClass = this.getAttribute('data-target');
        const boxes = document.querySelectorAll('.' + targetClass + ':not(:disabled)');
        const anyUnchecked = Array.from(boxes).some(b => !b.checked);
        boxes.forEach(b => b.checked = anyUnchecked);
      });
    });
  });
</script>
@endsection
