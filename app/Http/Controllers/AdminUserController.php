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
     * Authorize and get current logged in admin.
     */
    protected function authorizeAccess(): Admin
    {
        /** @var Admin|null $user */
        $user = Auth::guard('admin')->user();
        if (!$user) {
            abort(401);
        }

        if (!$this->isSuperAdmin($user) && !$user->can('employees.manage') && !$user->can('roles.manage')) {
            abort(403, 'Unauthorized access to admin user management.');
        }

        return $user;
    }

    /**
     * Check if user is SuperAdmin.
     */
    protected function isSuperAdmin(Admin $user): bool
    {
        return $user->id === 1 || $user->hasRole('SuperAdmin');
    }

    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        $currentUser = $this->authorizeAccess();
        $isSuperAdmin = $this->isSuperAdmin($currentUser);

        if ($isSuperAdmin) {
            $admins = Admin::with(['campus', 'roles'])->get();
            $campuses = addCampus::all();
            $roles = SpatieRole::where('guard_name', 'admin')->get();
        } else {
            // Campus Admin only manages staff and accounts within their own campus
            $admins = Admin::where('campusid', $currentUser->campusid)
                ->with(['campus', 'roles'])
                ->get();
            $campuses = addCampus::where('campusid', $currentUser->campusid)->get();
            // Exclude SuperAdmin role so campus admins cannot elevate privileges
            $roles = SpatieRole::where('guard_name', 'admin')
                ->where('name', '!=', 'SuperAdmin')
                ->get();
        }

        return view('admin.admin_users.index', compact('admins', 'campuses', 'roles', 'isSuperAdmin', 'currentUser'));
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        $currentUser = $this->authorizeAccess();
        $isSuperAdmin = $this->isSuperAdmin($currentUser);

        // Non-SuperAdmin must be forced to their own campus
        if (!$isSuperAdmin) {
            $request->merge(['campusid' => $currentUser->campusid]);
        }

        $allowedRoles = SpatieRole::where('guard_name', 'admin')
            ->when(!$isSuperAdmin, function ($query) {
                $query->where('name', '!=', 'SuperAdmin');
            })
            ->pluck('name')
            ->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:6',
            'campusid' => 'required|exists:configurations,campusid',
            'role' => ['required', 'string', \Illuminate\Validation\Rule::in($allowedRoles)],
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

        return redirect()->route('admin.users.index')->with('success', "User '{$admin->name}' created successfully with role '{$request->role}'.");
    }

    /**
     * Update the specified admin user in storage.
     */
    public function update(Request $request, $id)
    {
        $currentUser = $this->authorizeAccess();
        $isSuperAdmin = $this->isSuperAdmin($currentUser);

        $admin = Admin::findOrFail($id);

        // Security check: Campus Admin cannot modify users outside their campus
        if (!$isSuperAdmin && $admin->campusid != $currentUser->campusid) {
            abort(403, 'You are not authorized to update accounts outside your campus.');
        }

        // Security check: Cannot modify root SuperAdmin accounts unless SuperAdmin
        if (!$isSuperAdmin && ($admin->id === 1 || $admin->hasRole('SuperAdmin'))) {
            abort(403, 'You cannot modify a SuperAdmin account.');
        }

        // If not SuperAdmin, lock campusid to existing value
        if (!$isSuperAdmin) {
            $request->merge(['campusid' => $admin->campusid]);
        }

        $allowedRoles = SpatieRole::where('guard_name', 'admin')
            ->when(!$isSuperAdmin, function ($query) {
                $query->where('name', '!=', 'SuperAdmin');
            })
            ->pluck('name')
            ->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6',
            'campusid' => 'required|exists:configurations,campusid',
            'role' => ['required', 'string', \Illuminate\Validation\Rule::in($allowedRoles)],
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

        return redirect()->route('admin.users.index')->with('success', "User '{$admin->name}' updated successfully.");
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy($id)
    {
        $currentUser = $this->authorizeAccess();
        $isSuperAdmin = $this->isSuperAdmin($currentUser);

        $admin = Admin::findOrFail($id);

        if ($admin->id === $currentUser->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own logged-in account.');
        }

        if ($admin->id == 1 || $admin->hasRole('SuperAdmin')) {
            return redirect()->route('admin.users.index')->with('error', 'SuperAdmin root account cannot be deleted.');
        }

        // Security check: Campus Admin cannot delete accounts of other campuses
        if (!$isSuperAdmin && $admin->campusid != $currentUser->campusid) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete accounts belonging to other campuses.');
        }

        $adminName = $admin->name;
        $admin->delete();

        return redirect()->route('admin.users.index')->with('success', "User '{$adminName}' has been removed.");
    }

    /**
     * Impersonate another admin user (Session-based).
     */
    public function impersonate($id)
    {
        $currentUser = $this->authorizeAccess();
        $isSuperAdmin = $this->isSuperAdmin($currentUser);

        $targetAdmin = Admin::findOrFail($id);

        // Only allow SuperAdmin or users with explicit roles.manage permission
        if (!$isSuperAdmin && !$currentUser->can('roles.manage')) {
            return redirect()->route('admin.users.index')->with('error', 'You are not authorized to impersonate users.');
        }

        // Prevent impersonating SuperAdmin root user if not already root
        if (!$isSuperAdmin && ($targetAdmin->hasRole('SuperAdmin') || $targetAdmin->id === 1)) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot impersonate a SuperAdmin account.');
        }

        // Save original admin details in session if not already impersonating
        if (!session()->has('impersonate_original_admin_id')) {
            session()->put('impersonate_original_admin_id', $currentUser->id);
            session()->put('impersonate_original_admin_name', $currentUser->name);
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
