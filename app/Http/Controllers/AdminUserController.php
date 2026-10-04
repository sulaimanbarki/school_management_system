<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\addCampus;
use App\Models\Department;
use App\Models\Scale;
use App\Models\Role as LegacyRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SpatieRole;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        $admins = Admin::with(['campus', 'roles'])->get();
        $campuses = addCampus::all();
        $roles = SpatieRole::where('guard_name', 'admin')->get();

        return view('admin.admin_users.index', compact('admins', 'campuses', 'roles'));
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:6',
            'campusid' => 'required|exists:configurations,campusid',
            'role' => 'required|string|exists:spatie_roles,name',
            'phone1' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Transgender',
        ]);

        $dept = Department::where('campusid', $request->campusid)->first() ?: Department::first();
        $scale = Scale::where('campusid', $request->campusid)->first() ?: Scale::first();
        $legacyRole = LegacyRole::where('Role', $request->role)->first() ?: LegacyRole::first();

        $admin = Admin::create([
            'name' => trim($request->name),
            'fname' => $request->fname ?: 'Admin',
            'cnic' => $request->cnic ?: 'ADM-' . time(),
            'gender' => $request->gender ?: 'Male',
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'phone1' => $request->phone1 ?: '0000000000',
            'phone2' => $request->phone2 ?: null,
            'address1' => $request->address1 ?: 'Campus Office',
            'address2' => null,
            'joindate' => date('Y-m-d'),
            'isactive' => 1,
            'departmentid' => $dept ? $dept->id : 1,
            'scaleid' => $scale ? $scale->id : 1,
            'fixedsalary' => 0,
            'campusid' => $request->campusid,
            'roleid' => $legacyRole ? $legacyRole->RoleId : 2,
            'busnumber' => '',
        ]);

        // Assign Spatie Role
        $admin->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', "Admin user '{$admin->name}' created successfully with role '{$request->role}'.");
    }

    /**
     * Update the specified admin user in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6',
            'campusid' => 'required|exists:configurations,campusid',
            'role' => 'required|string|exists:spatie_roles,name',
            'isactive' => 'required|in:0,1',
            'phone1' => 'nullable|string|max:20',
        ]);

        $admin->name = trim($request->name);
        $admin->email = strtolower(trim($request->email));
        $admin->campusid = $request->campusid;
        $admin->isactive = $request->isactive;

        if ($request->filled('phone1')) {
            $admin->phone1 = $request->phone1;
        }

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        // Update Spatie Role
        $admin->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', "Admin user '{$admin->name}' updated successfully.");
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own logged-in admin account.');
        }

        if ($admin->id == 1 || $admin->hasRole('SuperAdmin')) {
            return redirect()->route('admin.users.index')->with('error', 'SuperAdmin root account cannot be deleted.');
        }

        $adminName = $admin->name;
        $admin->delete();

        return redirect()->route('admin.users.index')->with('success', "Admin user '{$adminName}' has been removed.");
    }

    /**
     * Impersonate another admin user (Session-based).
     */
    public function impersonate($id)
    {
        $targetAdmin = Admin::findOrFail($id);
        $currentAdmin = Auth::guard('admin')->user();

        // Only allow SuperAdmin, ID 1, or users with roles.manage
        if (!$currentAdmin->hasRole('SuperAdmin') && $currentAdmin->id != 1 && !$currentAdmin->can('roles.manage')) {
            return redirect()->route('admin.users.index')->with('error', 'You are not authorized to impersonate users.');
        }

        // Save original admin details in session if not already impersonating
        if (!session()->has('impersonate_original_admin_id')) {
            session()->put('impersonate_original_admin_id', $currentAdmin->id);
            session()->put('impersonate_original_admin_name', $currentAdmin->name);
        }

        // Log in as target admin
        Auth::guard('admin')->login($targetAdmin);

        return redirect('/admin/dashboard');
    }

    /**
     * Leave impersonation and restore original admin session.
     */
    public function leaveImpersonate()
    {
        if (session()->has('impersonate_original_admin_id')) {
            $originalId = session()->get('impersonate_original_admin_id');
            $originalAdmin = Admin::find($originalId);

            session()->forget('impersonate_original_admin_id');
            session()->forget('impersonate_original_admin_name');

            if ($originalAdmin) {
                Auth::guard('admin')->login($originalAdmin);
            }

            return redirect()->route('admin.users.index')->with('success', 'Returned to your original administrator account.');
        }

        return redirect('/admin/dashboard');
    }
}
