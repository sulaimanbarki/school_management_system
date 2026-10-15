<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\addCampus;
use App\Models\Department;
use App\Models\Scale;
use App\Models\Role as LegacyRole;
use Spatie\Permission\Models\Role as SpatieRole;
use Tests\TestCase;

class AdminUserCampusScopingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure roles exist
        SpatieRole::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'admin']);
        SpatieRole::firstOrCreate(['name' => 'Admin', 'guard_name' => 'admin']);
        SpatieRole::firstOrCreate(['name' => 'Teacher', 'guard_name' => 'admin']);
    }

    public function test_campus_admin_can_only_see_users_from_their_own_campus(): void
    {
        // Campus 1 Admin
        $campus1Admin = Admin::firstOrCreate(
            ['email' => 'campus1admin@example.com'],
            [
                'name' => 'Campus 1 Admin',
                'fname' => 'Father',
                'cnic' => '1111111111111',
                'gender' => 'Male',
                'password' => bcrypt('password'),
                'phone1' => '03001111111',
                'campusid' => 1,
                'roleid' => 2,
                'departmentid' => 1,
                'scaleid' => 1,
                'isactive' => 1,
                'fixedsalary' => 0,
                'joindate' => date('Y-m-d'),
                'busnumber' => '',
            ]
        );
        $campus1Admin->syncRoles(['Admin']);

        // Ensure Campus 2 exists
        addCampus::firstOrCreate(
            ['campusid' => 2],
            [
                'CampusName' => 'Branch Campus',
                'CampusPrefix' => 'B-',
                'CampusEmail' => 'branch@example.com',
                'DefaultBoard' => 'BISE',
                'DefaultReligion' => 'Islam',
                'Phone' => '03009999999',
                'DefaultAddress' => 'Branch Address',
                'SchoolStatus' => 'active',
            ]
        );

        // User in Campus 2
        $campus2User = Admin::firstOrCreate(
            ['email' => 'campus2user@example.com'],
            [
                'name' => 'Campus 2 User',
                'fname' => 'Father',
                'cnic' => '2222222222222',
                'gender' => 'Male',
                'password' => bcrypt('password'),
                'phone1' => '03002222222',
                'campusid' => 2, // Another campus
                'roleid' => 2,
                'departmentid' => 1,
                'scaleid' => 1,
                'isactive' => 1,
                'fixedsalary' => 0,
                'joindate' => date('Y-m-d'),
                'busnumber' => '',
            ]
        );
        $campus2User->syncRoles(['Teacher']);

        // Log in as Campus 1 Admin
        $response = $this->actingAs($campus1Admin, 'admin')->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Campus 1 Admin');
        $response->assertDontSee('Campus 2 User');
        $response->assertDontSee('<option value="SuperAdmin">', false); // Cannot assign SuperAdmin role
    }

    public function test_campus_admin_cannot_create_user_with_superadmin_role(): void
    {
        $campus1Admin = Admin::where('email', 'campus1admin@example.com')->first();
        if (!$campus1Admin) {
            $this->markTestSkipped('Campus 1 admin not found.');
        }

        $response = $this->actingAs($campus1Admin, 'admin')->post(route('admin.users.store'), [
            'name' => 'Hacker Admin',
            'email' => 'hacker@example.com',
            'password' => 'secret123',
            'campusid' => 1,
            'role' => 'SuperAdmin', // Forbidden for campus admin
        ]);

        $response->assertSessionHasErrors(['role']);
    }

    public function test_campus_admin_cannot_delete_users_from_another_campus(): void
    {
        $campus1Admin = Admin::where('email', 'campus1admin@example.com')->first();
        $campus2User = Admin::where('email', 'campus2user@example.com')->first();

        if (!$campus1Admin || !$campus2User) {
            $this->markTestSkipped('Test users missing.');
        }

        $response = $this->actingAs($campus1Admin, 'admin')->delete(route('admin.users.destroy', $campus2User->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error');

        // Verify campus 2 user still exists
        $this->assertDatabaseHas('admins', ['id' => $campus2User->id]);
    }

    public function test_campus_admin_can_create_teacher_account_for_their_own_campus(): void
    {
        $campus1Admin = Admin::where('email', 'campus1admin@example.com')->first();

        $response = $this->actingAs($campus1Admin, 'admin')->post(route('admin.users.store'), [
            'name' => 'Math Teacher',
            'email' => 'math_teacher@example.com',
            'password' => 'secret123',
            'campusid' => 999, // Should be overridden to campus 1 automatically
            'role' => 'Teacher',
            'phone1' => '03001234567',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $teacher = Admin::where('email', 'math_teacher@example.com')->first();
        $this->assertNotNull($teacher);
        $this->assertEquals(1, $teacher->campusid); // Enforced to campus 1
        $this->assertTrue($teacher->hasRole('Teacher'));
    }
}
