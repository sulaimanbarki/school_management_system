<?php

namespace App\Console\Commands;

use App\Models\addCampus;
use App\Models\Admin;
use App\Models\Company;
use App\Models\StudentInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateExistingMediaToSpatie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:migrate-legacy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing files into Spatie Media Library collections';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting legacy media migration...');

        // 1. Campus logos and bank logos
        $campuses = addCampus::all();
        foreach ($campuses as $campus) {
            if ($campus->Logo_photo_path && $campus->getMedia('campus_logo')->isEmpty()) {
                $path = public_path('CampusLogos/' . $campus->Logo_photo_path);
                if (File::exists($path)) {
                    $campus->addMedia($path)->preservingOriginal()->toMediaCollection('campus_logo');
                    $this->line("Migrated campus logo for campus ID: {$campus->campusid}");
                }
            }

            if ($campus->banklogo && $campus->getMedia('bank_logo')->isEmpty()) {
                $path = public_path('banklogo/' . $campus->banklogo);
                if (File::exists($path)) {
                    $campus->addMedia($path)->preservingOriginal()->toMediaCollection('bank_logo');
                    $this->line("Migrated bank logo for campus ID: {$campus->campusid}");
                }
            }
        }

        // 2. Admin / Staff profile pictures
        $admins = Admin::whereNotNull('profile_photo_path')->get();
        foreach ($admins as $admin) {
            if ($admin->profile_photo_path && $admin->getMedia('profile_picture')->isEmpty()) {
                $path = public_path('profilepicture/' . $admin->profile_photo_path);
                if (File::exists($path)) {
                    $admin->addMedia($path)->preservingOriginal()->toMediaCollection('profile_picture');
                    $this->line("Migrated profile picture for admin ID: {$admin->id}");
                }
            }
        }

        // 3. Student profile pictures
        $students = StudentInfo::whereNotNull('picturepath')->get();
        foreach ($students as $student) {
            if ($student->picturepath && $student->getMedia('profile_picture')->isEmpty()) {
                $path = public_path('studentprofilepicture/' . $student->picturepath);
                if (File::exists($path)) {
                    $student->addMedia($path)->preservingOriginal()->toMediaCollection('profile_picture');
                    $this->line("Migrated picture for student ID: {$student->id}");
                }
            }
        }

        // 4. Company logos
        $companies = Company::whereNotNull('logo')->get();
        foreach ($companies as $company) {
            if ($company->logo && $company->getMedia('logo')->isEmpty()) {
                $path = public_path('companylogo/' . $company->logo);
                if (File::exists($path)) {
                    $company->addMedia($path)->preservingOriginal()->toMediaCollection('logo');
                    $this->line("Migrated logo for company ID: {$company->id}");
                }
            }
        }

        $this->info('Legacy media migration completed successfully!');

        return Command::SUCCESS;
    }
}
