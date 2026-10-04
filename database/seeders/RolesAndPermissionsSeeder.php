<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Admin;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Guard to configure
        $guard = 'admin';

        // Permissions organized by module
        $modules = [
            'System & Administration' => [
                'admin.access',
                'campus.manage',
                'roles.manage',
                'permissions.manage',
                'employees.manage',
                'classes.manage',
            ],
            'Academics' => [
                'subjects.manage',
                'timetable.manage',
                'student-promotion.manage',
                'personal-development.manage',
            ],
            'Students & Admissions' => [
                'students.view',
                'admissions.create',
                'admissions.edit',
                'admissions.delete',
                'students.attendance',
                'slc.issue',
            ],
            'Fee Management' => [
                'fee-heads.manage',
                'fee-criteria.manage',
                'scholarships.manage',
                'fee-generation.manage',
                'fee-slip.collect',
                'fee-slip.edit',
                'fee.reports',
            ],
            'Staff & Payroll' => [
                'staff-allowances.manage',
                'salary-sheet.manage',
                'salary-generation.manage',
                'staff.attendance',
                'staff.profile',
            ],
            'Accounts & Finance' => [
                'accounts.manage',
                'expenses.manage',
                'locations.manage',
                'finance.reports',
            ],
            'Examinations' => [
                'marks.entry',
                'exam.reports',
                'dmc.generate',
            ],
            'Inventory & Store' => [
                'inventory.manage',
                'stock.add',
                'counter-sale.manage',
                'inventory.reports',
            ],
            'Communications' => [
                'sms.send',
            ],
        ];

        // Create all permissions for 'admin' guard
        $allCreatedPermissions = [];
        foreach ($modules as $moduleName => $permissions) {
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => $guard,
                ]);
                $allCreatedPermissions[$permissionName] = $permission;
            }
        }

        // 1. SuperAdmin Role
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => $guard]);
        $superAdminRole->syncPermissions(Permission::where('guard_name', $guard)->get());

        // 2. Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => $guard]);
        $adminPermissions = collect($allCreatedPermissions)->reject(function ($perm, $key) {
            return in_array($key, ['campus.manage', 'roles.manage', 'permissions.manage']);
        });
        $adminRole->syncPermissions($adminPermissions->values());

        // 3. Principal Role
        $principalRole = Role::firstOrCreate(['name' => 'Principal', 'guard_name' => $guard]);
        $principalRole->syncPermissions([
            'admin.access',
            'employees.manage',
            'classes.manage',
            'subjects.manage',
            'timetable.manage',
            'student-promotion.manage',
            'personal-development.manage',
            'students.view',
            'admissions.create',
            'admissions.edit',
            'students.attendance',
            'slc.issue',
            'staff.attendance',
            'staff.profile',
            'marks.entry',
            'exam.reports',
            'dmc.generate',
            'fee.reports',
            'sms.send',
        ]);

        // 4. Accountant Role
        $accountantRole = Role::firstOrCreate(['name' => 'Accountant', 'guard_name' => $guard]);
        $accountantRole->syncPermissions([
            'admin.access',
            'fee-heads.manage',
            'fee-criteria.manage',
            'scholarships.manage',
            'fee-generation.manage',
            'fee-slip.collect',
            'fee-slip.edit',
            'fee.reports',
            'staff-allowances.manage',
            'salary-sheet.manage',
            'salary-generation.manage',
            'accounts.manage',
            'expenses.manage',
            'finance.reports',
            'counter-sale.manage',
        ]);

        // 5. Teacher Role
        $teacherRole = Role::firstOrCreate(['name' => 'Teacher', 'guard_name' => $guard]);
        $teacherRole->syncPermissions([
            'admin.access',
            'subjects.manage',
            'timetable.manage',
            'students.view',
            'students.attendance',
            'personal-development.manage',
            'marks.entry',
            'dmc.generate',
        ]);

        // 6. FrontDesk / Clerk Role
        $frontDeskRole = Role::firstOrCreate(['name' => 'FrontDesk', 'guard_name' => $guard]);
        $frontDeskRole->syncPermissions([
            'admin.access',
            'students.view',
            'admissions.create',
            'admissions.edit',
            'fee-slip.collect',
            'sms.send',
        ]);

        // Assign SuperAdmin to the first admin
        $firstAdmin = Admin::first();
        if ($firstAdmin) {
            $firstAdmin->assignRole($superAdminRole);
        }
    }
}
