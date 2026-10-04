<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the roles and permissions.
     */
    public function index()
    {
        $guard = 'admin';
        $roles = Role::where('guard_name', $guard)->with(['permissions', 'users'])->get();
        $permissions = Permission::where('guard_name', $guard)->get();

        // Group permissions logically by category prefix
        $groupedPermissions = $this->groupPermissions($permissions);

        // Admins for role assignment
        $admins = Admin::all();

        return view('admin.roles.index', compact('roles', 'permissions', 'groupedPermissions', 'admins'));
    }

    /**
     * Store a newly created role with permissions.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:spatie_roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $guard = 'admin';
        $role = Role::create([
            'name' => trim($request->name),
            'guard_name' => $guard,
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' created successfully!");
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit($id)
    {
        $guard = 'admin';
        $role = Role::where('guard_name', $guard)->findOrFail($id);
        $permissions = Permission::where('guard_name', $guard)->get();
        $groupedPermissions = $this->groupPermissions($permissions);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'groupedPermissions', 'rolePermissions'));
    }

    /**
     * Update the specified role and its permissions.
     */
    public function update(Request $request, $id)
    {
        $guard = 'admin';
        $role = Role::where('guard_name', $guard)->findOrFail($id);

        $rules = [
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ];

        // Do not rename SuperAdmin
        if ($role->name !== 'SuperAdmin') {
            $rules['name'] = 'required|string|max:100|unique:spatie_roles,name,' . $role->id;
        }

        $request->validate($rules);

        if ($role->name !== 'SuperAdmin' && $request->filled('name')) {
            $role->name = trim($request->name);
            $role->save();
        }

        // If SuperAdmin, keep all permissions
        if ($role->name === 'SuperAdmin') {
            $allPerms = Permission::where('guard_name', $guard)->get();
            $role->syncPermissions($allPerms);
        } else {
            $role->syncPermissions($request->permissions ?? []);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' updated successfully!");
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy($id)
    {
        $guard = 'admin';
        $role = Role::where('guard_name', $guard)->findOrFail($id);

        if ($role->name === 'SuperAdmin') {
            return redirect()->route('roles.index')->with('error', 'Cannot delete the SuperAdmin role.');
        }

        $roleName = $role->name;
        $role->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', "Role '{$roleName}' deleted successfully.");
    }

    /**
     * Assign role to an admin user.
     */
    public function assignAdminRole(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'role_name' => 'required|string|exists:spatie_roles,name',
        ]);

        $admin = Admin::findOrFail($request->admin_id);
        $role = Role::where('guard_name', 'admin')->where('name', $request->role_name)->firstOrFail();

        $admin->syncRoles([$role]);

        return redirect()->route('roles.index')->with('success', "Assigned role '{$role->name}' to {$admin->name}.");
    }

    /**
     * Helper to group permissions into human-readable modules.
     */
    private function groupPermissions($permissions)
    {
        $grouped = [];

        $categoryMap = [
            'admin' => 'System & Administration',
            'campus' => 'System & Administration',
            'roles' => 'System & Administration',
            'permissions' => 'System & Administration',
            'employees' => 'System & Administration',
            'classes' => 'System & Administration',
            'subjects' => 'Academics',
            'timetable' => 'Academics',
            'student-promotion' => 'Academics',
            'personal-development' => 'Academics',
            'students' => 'Students & Admissions',
            'admissions' => 'Students & Admissions',
            'slc' => 'Students & Admissions',
            'fee-heads' => 'Fee Management',
            'fee-criteria' => 'Fee Management',
            'scholarships' => 'Fee Management',
            'fee-generation' => 'Fee Management',
            'fee-slip' => 'Fee Management',
            'fee' => 'Fee Management',
            'staff-allowances' => 'Staff & Payroll',
            'salary-sheet' => 'Staff & Payroll',
            'salary-generation' => 'Staff & Payroll',
            'staff' => 'Staff & Payroll',
            'accounts' => 'Accounts & Finance',
            'expenses' => 'Accounts & Finance',
            'locations' => 'Accounts & Finance',
            'finance' => 'Accounts & Finance',
            'marks' => 'Examinations',
            'exam' => 'Examinations',
            'dmc' => 'Examinations',
            'inventory' => 'Inventory & Store',
            'stock' => 'Inventory & Store',
            'counter-sale' => 'Inventory & Store',
            'sms' => 'Communications',
        ];

        foreach ($permissions as $permission) {
            $prefix = explode('.', $permission->name)[0];
            $groupName = $categoryMap[$prefix] ?? 'General';
            $grouped[$groupName][] = $permission;
        }

        return $grouped;
    }
}
