<?php

namespace Tests\Feature;

use App\Models\addCampus;
use App\Models\Admin;
use App\Models\Company;
use App\Models\StudentInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
    }

    protected function tearDown(): void
    {
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        parent::tearDown();
    }

    public function test_student_info_can_upload_media_using_common_method()
    {
        Storage::fake('public');

        $student = StudentInfo::create([
            'studentid' => 'TEST-001',
            'registrationid' => '1001',
            'studentname' => 'John Doe',
            'fathername' => 'Richard Doe',
            'gender' => 'Male',
            'status' => 'Active',
            'dob' => '2010-01-01',
            'address1' => 'Street 1',
            'fathercontact' => '1234567890',
            'campusid' => 1,
            'date' => '2026-01-01',
            'session' => '2026',
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg');
        $media = $student->uploadMedia($file, 'profile_picture', 'picturepath');

        $this->assertNotNull($media);
        $this->assertEquals($media->file_name, $student->fresh()->picturepath);
        $this->assertCount(1, $student->getMedia('profile_picture'));
        $this->assertStringContainsString('avatar', $student->fresh()->picture_url);
    }

    public function test_admin_can_upload_media_using_common_method()
    {
        Storage::fake('public');

        $admin = Admin::create([
            'name' => 'Staff Member',
            'fname' => 'Father Member',
            'cnic' => '12345-6789012-3',
            'gender' => 'Male',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'),
            'phone1' => '03001234567',
            'address1' => 'Address Line 1',
            'joindate' => '2026-01-01',
            'isactive' => 1,
            'campusid' => 1,
        ]);

        $file = UploadedFile::fake()->image('staff.png');
        $media = $admin->uploadMedia($file, 'profile_picture', 'profile_photo_path');

        $this->assertNotNull($media);
        $this->assertEquals($media->file_name, $admin->fresh()->profile_photo_path);
        $this->assertCount(1, $admin->getMedia('profile_picture'));
        $this->assertStringContainsString('staff', $admin->fresh()->profile_photo_url);
    }

    public function test_campus_can_upload_media_using_common_method()
    {
        Storage::fake('public');

        $campus = addCampus::create([
            'CampusName' => 'Test Campus',
            'CampusEmail' => 'campus@example.com',
            'CampusPrefix' => 'TC-',
            'DefaultReligion' => 'Islam',
            'DefaultBoard' => 'BISE',
            'Phone' => '0421234567',
            'DefaultAddress' => 'Lahore',
            'SchoolStatus' => 'Active',
        ]);

        $logo = UploadedFile::fake()->image('logo.png');
        $bank = UploadedFile::fake()->image('bank.png');

        $campus->uploadMedia($logo, 'campus_logo', 'Logo_photo_path');
        $campus->uploadMedia($bank, 'bank_logo', 'banklogo');

        $this->assertCount(1, $campus->getMedia('campus_logo'));
        $this->assertCount(1, $campus->getMedia('bank_logo'));
        $this->assertStringContainsString('logo', $campus->fresh()->logo_photo_url);
        $this->assertStringContainsString('bank', $campus->fresh()->bank_logo_url);
    }

    public function test_company_can_upload_media_using_common_method()
    {
        Storage::fake('public');

        $company = Company::create([
            'company_name' => 'Tech Corp',
            'campusid' => 1,
        ]);

        $logo = UploadedFile::fake()->image('company_logo.png');
        $media = $company->uploadMedia($logo, 'logo', 'logo');

        $this->assertNotNull($media);
        $this->assertEquals($media->file_name, $company->fresh()->logo);
        $this->assertCount(1, $company->getMedia('logo'));
        $this->assertStringContainsString('company_logo', $company->fresh()->logo_url);
    }
}
