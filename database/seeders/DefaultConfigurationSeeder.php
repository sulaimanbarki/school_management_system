<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\addCampus;
use App\Models\academicsessions;
use App\Models\addClass;
use App\Models\addsection;
use App\Models\ClassWiseSection;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Scale;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Subject;
use App\Models\ClassWiseSubject;
use App\Models\TermName;
use App\Models\MainHead;
use App\Models\FeeSubHead;
use App\Models\ClassWiseFeeCriteria;
use App\Models\Account;
use App\Models\ExpenseHead;
use App\Models\Buses;
use App\Models\Location;
use App\Models\Time;
use App\Models\Pages;
use App\Models\RoleWisePages;

class DefaultConfigurationSeeder extends Seeder
{
    /**
     * Run the default configuration seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Starting Default Configurations Seeding...");

        // 1. Campus configuration
        $campus = addCampus::first();
        if (!$campus) {
            $campus = addCampus::create([
                'CampusName' => 'Main Campus',
                'CampusPrefix' => 'MC-',
                'phone' => '03001234567',
                'CampusEmail' => 'admin@gmail.com',
                'DefaultBoard' => 'BISE',
                'DefaultReligion' => 'Islam',
                'DefaultAddress' => 'Main Boulevard, Education City',
                'SchoolStatus' => 'active',
            ]);
        }
        $campusId = $campus->campusid;

        // 2. Academic Session
        $session = academicsessions::where('CampusID', $campusId)->where('IsCurrent', 1)->first();
        if (!$session) {
            $session = academicsessions::create([
                'Session' => date('Y') . '-' . (date('Y') + 1),
                'CampusID' => $campusId,
                'SessionType' => 'Annual',
                'StartDate' => date('Y-04-01'),
                'EndDate' => date('Y-03-31', strtotime('+1 year')),
                'IsActive' => 1,
                'IsCurrent' => 1,
            ]);
        }
        $sessionId = $session->id;

        // 3. Admin Account & Roles
        $roles = [
            ['Role' => 'SuperAdmin', 'Sequence' => 1],
            ['Role' => 'Admin', 'Sequence' => 2],
            ['Role' => 'Principal', 'Sequence' => 3],
            ['Role' => 'Teacher', 'Sequence' => 4],
            ['Role' => 'Accountant', 'Sequence' => 5],
        ];
        $roleMap = [];
        foreach ($roles as $r) {
            $role = Role::firstOrCreate(
                ['Role' => $r['Role'], 'CampusID' => $campusId],
                ['Sequence' => $r['Sequence'], 'IsActive' => 1]
            );
            $roleMap[$r['Role']] = $role->RoleId;
        }

        $admin = Admin::first();
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Super Administrator',
                'fname' => 'System',
                'cnic' => '00000-0000000-0',
                'gender' => 'male',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'phone1' => '03001234567',
                'phone2' => '03001234567',
                'address1' => 'School Campus',
                'address2' => 'School Campus',
                'joindate' => date('Y-m-d'),
                'isactive' => 1,
                'departmentid' => 1,
                'scaleid' => 1,
                'fixedsalary' => 0,
                'campusid' => $campusId,
                'roleid' => $roleMap['SuperAdmin'],
                'busnumber' => '1',
                'email_verified_at' => now(),
            ]);
        }
        $adminId = $admin->id;

        // 4. Role-Wise Pages Permission (Assign all pages to SuperAdmin)
        $pages = Pages::where('campusid', $campusId)->get();
        foreach ($pages as $p) {
            RoleWisePages::firstOrCreate([
                'role_id' => $roleMap['SuperAdmin'],
                'pages_id' => $p->page_id,
                'campusid' => $campusId,
            ]);
        }

        // 5. Classes & Sections
        $classList = [
            ['name' => 'Playgroup', 'sequence' => 1],
            ['name' => 'Nursery', 'sequence' => 2],
            ['name' => 'Prep', 'sequence' => 3],
            ['name' => 'Class 1', 'sequence' => 4],
            ['name' => 'Class 2', 'sequence' => 5],
            ['name' => 'Class 3', 'sequence' => 6],
            ['name' => 'Class 4', 'sequence' => 7],
            ['name' => 'Class 5', 'sequence' => 8],
            ['name' => 'Class 6', 'sequence' => 9],
            ['name' => 'Class 7', 'sequence' => 10],
            ['name' => 'Class 8', 'sequence' => 11],
            ['name' => 'Class 9', 'sequence' => 12],
            ['name' => 'Class 10', 'sequence' => 13],
        ];

        $classMap = [];
        foreach ($classList as $c) {
            $class = addClass::firstOrCreate(
                ['ClassName' => $c['name'], 'campusid' => $campusId],
                ['Sequence' => $c['sequence'], 'Isdisplay' => '1']
            );
            $classMap[$c['name']] = $class->C_id;
        }

        $sectionList = [
            ['name' => 'Section A', 'sequence' => 1],
            ['name' => 'Section B', 'sequence' => 2],
            ['name' => 'Section C', 'sequence' => 3],
        ];

        $sectionMap = [];
        foreach ($sectionList as $s) {
            $section = addsection::firstOrCreate(
                ['SectionName' => $s['name'], 'campusid' => $campusId],
                ['SectionSequence' => $s['sequence']]
            );
            $sectionMap[$s['name']] = $section->Sec_ID;
        }

        // Link Class Wise Sections
        foreach ($classMap as $className => $cId) {
            // Assign Section A to all classes
            ClassWiseSection::firstOrCreate(
                ['ClassID' => $cId, 'SectionID' => $sectionMap['Section A'], 'campusid' => $campusId],
                ['Sequence' => 1, 'Date' => date('Y-m-d'), 'isDisplay' => 1]
            );

            // Assign Section B to Class 1 through Class 10
            if (!in_array($className, ['Playgroup', 'Nursery', 'Prep'])) {
                ClassWiseSection::firstOrCreate(
                    ['ClassID' => $cId, 'SectionID' => $sectionMap['Section B'], 'campusid' => $campusId],
                    ['Sequence' => 2, 'Date' => date('Y-m-d'), 'isDisplay' => 1]
                );
            }
        }

        // 6. Departments
        $deptList = [
            ['title' => 'Academic / Teaching', 'desc' => 'Teaching Faculty & Curriculum', 'sequence' => 1],
            ['title' => 'Administration', 'desc' => 'General Administration & Staff', 'sequence' => 2],
            ['title' => 'Accounts & Finance', 'desc' => 'Fee Collection & Payroll', 'sequence' => 3],
            ['title' => 'Information Technology', 'desc' => 'IT Infrastructure & Labs', 'sequence' => 4],
            ['title' => 'Transport', 'desc' => 'Student & Staff Transportation', 'sequence' => 5],
            ['title' => 'Security & Maintenance', 'desc' => 'Campus Safety & Facility Operations', 'sequence' => 6],
        ];
        $deptMap = [];
        foreach ($deptList as $d) {
            $dept = Department::firstOrCreate(
                ['title' => $d['title'], 'campusid' => $campusId],
                ['description' => $d['desc'], 'sequence' => $d['sequence'], 'isdisplay' => 1]
            );
            $deptMap[$d['title']] = $dept->id;
        }

        // 7. Designations
        $desigList = [
            ['name' => 'Principal', 'bps' => '19', 'sequence' => 1],
            ['name' => 'Vice Principal', 'bps' => '18', 'sequence' => 2],
            ['name' => 'Senior Subject Specialist', 'bps' => '17', 'sequence' => 3],
            ['name' => 'Secondary School Teacher (SST)', 'bps' => '16', 'sequence' => 4],
            ['name' => 'Primary School Teacher (PST)', 'bps' => '14', 'sequence' => 5],
            ['name' => 'Accountant', 'bps' => '14', 'sequence' => 6],
            ['name' => 'Admin Officer', 'bps' => '14', 'sequence' => 7],
            ['name' => 'Computer Lab Incharge', 'bps' => '12', 'sequence' => 8],
            ['name' => 'Bus Driver', 'bps' => '5', 'sequence' => 9],
            ['name' => 'Security Guard', 'bps' => '2', 'sequence' => 10],
        ];
        foreach ($desigList as $desig) {
            Designation::firstOrCreate(
                ['name' => $desig['name'], 'campusid' => $campusId],
                ['bps' => $desig['bps'], 'isactive' => 1, 'sequence' => $desig['sequence']]
            );
        }

        // 8. Scales
        $scaleList = [
            ['name' => 1, 'desc' => 'BPS-01 to BPS-05 Support Staff', 'basic' => 18000, 'inc' => 800, 'limit' => 30000, 'eobi' => 500, 'seq' => 1],
            ['name' => 2, 'desc' => 'BPS-06 to BPS-10 Junior Staff', 'basic' => 25000, 'inc' => 1200, 'limit' => 45000, 'eobi' => 700, 'seq' => 2],
            ['name' => 3, 'desc' => 'BPS-11 to BPS-14 Primary/Junior Teachers', 'basic' => 35000, 'inc' => 1800, 'limit' => 65000, 'eobi' => 1000, 'seq' => 3],
            ['name' => 4, 'desc' => 'BPS-15 to BPS-16 Secondary Teachers', 'basic' => 45000, 'inc' => 2500, 'limit' => 85000, 'eobi' => 1200, 'seq' => 4],
            ['name' => 5, 'desc' => 'BPS-17+ Senior Specialists / Admin', 'basic' => 60000, 'inc' => 3500, 'limit' => 120000, 'eobi' => 1500, 'seq' => 5],
        ];
        foreach ($scaleList as $sc) {
            Scale::firstOrCreate(
                ['name' => $sc['name'], 'campusid' => $campusId],
                [
                    'description' => $sc['desc'],
                    'basicpay' => $sc['basic'],
                    'yearlyincrement' => $sc['inc'],
                    'salarylimit' => $sc['limit'],
                    'eobiamount' => $sc['eobi'],
                    'academicsession' => $sessionId,
                    'isactive' => 1,
                    'sequence' => $sc['seq'],
                ]
            );
        }

        // 9. Subjects & Class Wise Subjects
        $subjectList = [
            ['name' => 'English', 'seq' => 1],
            ['name' => 'Mathematics', 'seq' => 2],
            ['name' => 'Urdu', 'seq' => 3],
            ['name' => 'Islamiyat', 'seq' => 4],
            ['name' => 'General Science', 'seq' => 5],
            ['name' => 'Social Studies', 'seq' => 6],
            ['name' => 'Computer Science', 'seq' => 7],
            ['name' => 'General Knowledge', 'seq' => 8],
            ['name' => 'Pakistan Studies', 'seq' => 9],
            ['name' => 'Physics', 'seq' => 10],
            ['name' => 'Chemistry', 'seq' => 11],
            ['name' => 'Biology', 'seq' => 12],
        ];

        $subjectMap = [];
        foreach ($subjectList as $sb) {
            $subj = Subject::firstOrCreate(
                ['name' => $sb['name'], 'campusid' => $campusId],
                ['date' => date('Y-m-d'), 'isdisplay' => 1, 'sequence' => $sb['seq']]
            );
            $subjectMap[$sb['name']] = $subj->id;
        }

        // Link ClassWiseSubjects (for Class 1 as demonstration)
        $primaryClassId = $classMap['Class 1'] ?? null;
        if ($primaryClassId) {
            $primarySubjects = ['English', 'Mathematics', 'Urdu', 'Islamiyat', 'General Science', 'General Knowledge'];
            $seq = 1;
            foreach ($primarySubjects as $sName) {
                if (isset($subjectMap[$sName])) {
                    ClassWiseSubject::firstOrCreate(
                        ['classid' => $primaryClassId, 'subjectid' => $subjectMap[$sName], 'campusid' => $campusId],
                        [
                            'isdisplay' => 1,
                            'theorymarks' => 100,
                            'practicalmarks' => 0,
                            'passingmarks' => 33,
                            'date' => date('Y-m-d'),
                            'transcriptsequence' => $seq++,
                        ]
                    );
                }
            }
        }

        // 10. Exam Terms
        $terms = [
            ['name' => 'First Term Exam', 'seq' => 1],
            ['name' => 'Mid Term Exam', 'seq' => 2],
            ['name' => 'Final Term Exam', 'seq' => 3],
        ];
        foreach ($terms as $t) {
            TermName::firstOrCreate(
                ['termname' => $t['name'], 'campusid' => $campusId, 'sessionid' => $sessionId],
                ['isactive' => 1, 'isdisplay' => 1, 'sequence' => $t['seq']]
            );
        }

        // 11. Fee Main Heads & Sub Heads
        $mainHeadList = [
            ['name' => 'Tuition Fee', 'seq' => 1, 'default' => 'yes'],
            ['name' => 'Admission Fee', 'seq' => 2, 'default' => 'no'],
            ['name' => 'Annual Charges', 'seq' => 3, 'default' => 'no'],
            ['name' => 'Examination Fee', 'seq' => 4, 'default' => 'no'],
            ['name' => 'Transport Fee', 'seq' => 5, 'default' => 'no'],
            ['name' => 'Lab & Computer Fee', 'seq' => 6, 'default' => 'no'],
        ];
        foreach ($mainHeadList as $mh) {
            MainHead::firstOrCreate(
                ['mainhead' => $mh['name'], 'campusid' => $campusId],
                [
                    'isactive' => 1,
                    'isdefault' => $mh['default'],
                    'sequence' => $mh['seq'],
                    'addedby' => $adminId,
                    'date' => date('Y-m-d'),
                ]
            );
        }

        $subHeadList = [
            ['subhead' => 'Monthly Tuition Fee', 'amount' => 2500, 'desc' => 'Regular Monthly Tuition Fee', 'seq' => 1, 'transport' => 0, 'default' => 'yes'],
            ['subhead' => 'New Admission Fee', 'amount' => 5000, 'desc' => 'One-time registration fee', 'seq' => 2, 'transport' => 0, 'default' => 'no'],
            ['subhead' => 'Annual Development Charges', 'amount' => 3000, 'desc' => 'Yearly school facility development', 'seq' => 3, 'transport' => 0, 'default' => 'no'],
            ['subhead' => 'Term Exam Fee', 'amount' => 1500, 'desc' => 'Exam question papers and stationery', 'seq' => 4, 'transport' => 0, 'default' => 'no'],
            ['subhead' => 'Monthly Transport Service', 'amount' => 2000, 'desc' => 'School bus pickup and drop-off', 'seq' => 5, 'transport' => 1, 'default' => 'no'],
            ['subhead' => 'Computer Lab Fee', 'amount' => 500, 'desc' => 'Computer lab maintenance and internet', 'seq' => 6, 'transport' => 0, 'default' => 'no'],
        ];
        $subheadMap = [];
        foreach ($subHeadList as $sh) {
            $subhead = FeeSubHead::firstOrCreate(
                ['subhead' => $sh['subhead'], 'campusid' => $campusId],
                [
                    'amount' => $sh['amount'],
                    'description' => $sh['desc'],
                    'sequence' => $sh['seq'],
                    'transport_status' => $sh['transport'],
                    'date' => date('Y-m-d'),
                    'addedby' => $adminId,
                    'isdefault' => $sh['default'],
                ]
            );
            $subheadMap[$sh['subhead']] = $subhead->id;
        }

        // Set Class-Wise Fee Criteria for all classes
        $tuitionSubheadId = $subheadMap['Monthly Tuition Fee'] ?? null;
        if ($tuitionSubheadId) {
            $tuitionFees = [
                'Playgroup' => 2000,
                'Nursery' => 2000,
                'Prep' => 2200,
                'Class 1' => 2500,
                'Class 2' => 2500,
                'Class 3' => 2700,
                'Class 4' => 2700,
                'Class 5' => 3000,
                'Class 6' => 3200,
                'Class 7' => 3400,
                'Class 8' => 3600,
                'Class 9' => 4000,
                'Class 10' => 4500,
            ];
            foreach ($tuitionFees as $cName => $amt) {
                if (isset($classMap[$cName])) {
                    ClassWiseFeeCriteria::firstOrCreate(
                        [
                            'campusid' => $campusId,
                            'classid' => $classMap[$cName],
                            'subheadid' => $tuitionSubheadId,
                            'sessionid' => $sessionId,
                        ],
                        [
                            'amount' => $amt,
                            'addedby' => $adminId,
                            'date' => date('Y-m-d'),
                        ]
                    );
                }
            }
        }

        // 12. Accounts & Expense Heads
        Account::firstOrCreate(
            ['accountname' => 'Cash in Hand', 'campusid' => $campusId],
            ['accountnumber' => 'CASH-001', 'account_desc' => 'Main Cash Counter']
        );
        Account::firstOrCreate(
            ['accountname' => 'Bank of Punjab (Main Account)', 'campusid' => $campusId],
            ['accountnumber' => '6510001234567890', 'account_desc' => 'School Revenue and Operational Account']
        );

        $expenseList = [
            ['head' => 'Staff Salaries', 'desc' => 'Teaching & non-teaching staff monthly salaries'],
            ['head' => 'Electricity & Utilities', 'desc' => 'WAPDA electricity, gas, and water supply bills'],
            ['head' => 'Stationery & Printing', 'desc' => 'Exam sheets, office paperwork, registers'],
            ['head' => 'Building Maintenance & Repair', 'desc' => 'Paint, plumbing, furniture, electrical repairs'],
            ['head' => 'Transport Fuel & Maintenance', 'desc' => 'Diesel/petrol and bus servicing costs'],
            ['head' => 'Events & Refreshments', 'desc' => 'School functions, sports day, annual celebrations'],
        ];
        foreach ($expenseList as $ex) {
            ExpenseHead::firstOrCreate(
                ['expense_head' => $ex['head'], 'campusid' => $campusId],
                ['expense_desc' => $ex['desc']]
            );
        }

        // 13. Buses & Routes
        $buses = [
            [
                'busnumber' => 'BUS-01',
                'drivername' => 'Muhammad Rafiq',
                'drivercontact' => '0301-2345678',
                'conductorname' => 'Tariq Mehmood',
                'route' => 'City Center - University Road - School Campus',
                'seq' => 1,
            ],
            [
                'busnumber' => 'BUS-02',
                'drivername' => 'Gul Zaman',
                'drivercontact' => '0302-3456789',
                'conductorname' => 'Aslam Khan',
                'route' => 'Ring Road - Hayatabad - School Campus',
                'seq' => 2,
            ],
        ];
        foreach ($buses as $b) {
            Buses::firstOrCreate(
                ['busnumber' => $b['busnumber'], 'campusid' => $campusId],
                [
                    'drivername' => $b['drivername'],
                    'drivercontact' => $b['drivercontact'],
                    'conductorname' => $b['conductorname'],
                    'route' => $b['route'],
                    'busisdisplay' => 1,
                    'bussequence' => $b['seq'],
                ]
            );
        }

        // 14. Locations (Classrooms / Labs)
        $locations = [
            ['name' => 'Room 101 (Playgroup/Nursery)', 'seq' => 1],
            ['name' => 'Room 102 (Class 1 & 2)', 'seq' => 2],
            ['name' => 'Room 103 (Class 3 & 4)', 'seq' => 3],
            ['name' => 'Room 104 (Class 5 & 6)', 'seq' => 4],
            ['name' => 'Room 105 (Class 7 & 8)', 'seq' => 5],
            ['name' => 'Room 106 (Class 9 & 10)', 'seq' => 6],
            ['name' => 'Computer Lab', 'seq' => 7],
            ['name' => 'Science Laboratory', 'seq' => 8],
            ['name' => 'Main Library', 'seq' => 9],
            ['name' => 'School Auditorium', 'seq' => 10],
        ];
        foreach ($locations as $loc) {
            Location::firstOrCreate(
                ['locationname' => $loc['name'], 'campusid' => $campusId],
                ['sequence' => $loc['seq'], 'isdisplay' => 1]
            );
        }

        // 15. Times / Periods
        $periods = [
            ['start' => '08:00:00', 'end' => '08:45:00', 'seq' => 1],
            ['start' => '08:45:00', 'end' => '09:30:00', 'seq' => 2],
            ['start' => '09:30:00', 'end' => '10:15:00', 'seq' => 3],
            ['start' => '10:15:00', 'end' => '10:45:00', 'seq' => 4], // Break
            ['start' => '10:45:00', 'end' => '11:30:00', 'seq' => 5],
            ['start' => '11:30:00', 'end' => '12:15:00', 'seq' => 6],
            ['start' => '12:15:00', 'end' => '13:00:00', 'seq' => 7],
        ];
        foreach ($periods as $p) {
            Time::firstOrCreate(
                ['starttime' => $p['start'], 'endtime' => $p['end'], 'campusid' => $campusId],
                ['sequence' => $p['seq'], 'isdisplay' => 1]
            );
        }

        $this->command->info("All Default Configurations Seeded Successfully!");
    }
}
