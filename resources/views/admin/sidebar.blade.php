<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <a href="/admin/dashboard" class="brand-link">

        <?php
        $currentUser = Auth::guard('admin')->user() ?? Auth::user();
        $campus = \App\Models\addCampus::where('campusid', $currentUser?->campusid ?? 1)->first();
        ?>

        <img src="<?php if ($campus?->Logo_photo_path) {
            echo asset('CampusLogos/' . $campus->Logo_photo_path);
        } else {
            echo asset('userbackend/dist/img/AdminLTELogo.png');
        } ?>" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">

        <span class="brand-text font-weight-light">{{ $campus?->CampusName ?? 'School System' }}</span>

    </a>

    <!-- Sidebar -->

    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="image">

                <img src="{{ asset('userbackend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">

            </div>

            <div class="info">
                @php
                    $dynamicRole = $currentUser?->roles?->first()?->name;
                    $legacyRole = \App\Models\Role::where('RoleId', $currentUser?->roleid)
                        ->where('campusid', $currentUser?->campusid)
                        ->value('Role');
                    $displayRole = $dynamicRole ?: ($legacyRole ?: 'Administrator');
                    $isSuper = $currentUser?->hasRole('SuperAdmin') || $currentUser?->id == 1;

                    // Permission check helper: SuperAdmins have root access to all menus,
                    // non-super admins check dynamic Spatie permissions.
                    $can = function ($permissions) use ($currentUser, $isSuper) {
                        if (!$currentUser) return false;
                        if ($isSuper) return true;
                        $perms = is_array($permissions) ? $permissions : [$permissions];
                        foreach ($perms as $p) {
                            if ($currentUser->can($p)) {
                                return true;
                            }
                        }
                        return false;
                    };
                @endphp
                <small><a href="/admin/dashboard" class="d-block font-weight-bold">{{ $currentUser?->name ?? 'Admin' }}
                        <span class="badge badge-primary ml-1"
                            style="font-size: 0.72rem; vertical-align: middle;">{{ $displayRole }}</span></a></small>
            </div>

        </div>

        <style>
            /* Active top-level item highlight */
            .main-sidebar .nav-sidebar > .nav-item > .nav-link.active {
                background-color: #007bff !important;
                color: #ffffff !important;
                box-shadow: 0 2px 6px rgba(0, 123, 255, 0.4);
            }
            /* Active submenu item clear & bold highlight */
            .main-sidebar .nav-treeview > .nav-item > .nav-link.active {
                background-color: rgba(255, 255, 255, 0.95) !important;
                color: #1e293b !important;
                font-weight: 600;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            }
            .main-sidebar .nav-treeview > .nav-item > .nav-link.active > .nav-icon {
                color: #007bff !important;
            }
            .main-sidebar .nav-treeview > .nav-item > .nav-link.active > p {
                color: #1e293b !important;
            }
        </style>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- 1. Admin Controls --}}
                @php
                    $adminControlsPerms = [
                        'roles.manage',
                        'manage roles',
                        'campus.manage',
                        'employees.manage',
                        'classes.manage',
                        'staff-allowances.manage',
                        'salary-sheet.manage',
                        'salary-generation.manage',
                        'staff.profile',
                    ];
                @endphp
                @if ($can($adminControlsPerms))
                @php
                    $adminControlsActive = request()->is([
                        'admin/admins*',
                        'admin/roles-permissions*',
                        'admin/AddRole*',
                        'admin/Pages*',
                        'admin/AddCampus*',
                        'admin/AddEmployee*',
                        'admin/addClass*',
                        'admin/StaffwiseFeesCriteria*',
                        'admin/NetSalarySheet*',
                        'admin/FeeGenerationStaff*',
                        'admin/StaffProfile*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $adminControlsActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $adminControlsActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Admin Controls
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can(['roles.manage', 'manage roles']))
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->is('admin/admins*') ? 'active' : '' }}">
                                    <i class="fas fa-users-cog nav-icon text-info"></i>
                                    <p>Admin Users </p>
                                </a>
                            </li>
                        @endif

                        @if ($can(['roles.manage', 'permissions.manage', 'manage roles']))
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}"
                                    class="nav-link {{ request()->is('admin/roles-permissions*') ? 'active' : '' }}">
                                    <i class="fas fa-shield-alt nav-icon text-warning"></i>
                                    <p>Roles & Permissions </p>
                                </a>
                            </li>
                        @endif

                        @if ($can('campus.manage'))
                            <li class="nav-item">
                                <a href="{{ route('adminbackend.addCampus.page') }}"
                                    class="nav-link {{ request()->is('admin/AddCampus*') ? 'active' : '' }}">
                                    <i class="fas fa-university nav-icon text-muted"></i>
                                    <p>Add Campus</p>
                                </a>
                            </li>
                        @endif

                        @if ($can('employees.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.AddEmployee.page') }}"
                                class="nav-link {{ request()->is('admin/AddEmployee*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Employee</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('classes.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.addClass.page') }}"
                                class="nav-link {{ request()->is('admin/addClass*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Classes And Sections</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('staff-allowances.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.StaffwiseFeesCriteria.page') }}"
                                class="nav-link {{ request()->is('admin/StaffwiseFeesCriteria*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Staff wise Allowances</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('salary-sheet.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.NetSalarySheet.page') }}"
                                class="nav-link {{ request()->is('admin/NetSalarySheet*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Staff SalarySheet</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('salary-generation.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.FeeGenerationStaff.page') }}"
                                class="nav-link {{ request()->is('admin/FeeGenerationStaff*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Salary Generations</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['staff.profile', 'employees.manage']))
                        <li class="nav-item">
                            <a href="/admin/StaffProfile"
                                class="nav-link {{ request()->is('admin/StaffProfile*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Staff's Profile</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 2. Accounts --}}
                @php
                    $accountsPerms = [
                        'fee-heads.manage',
                        'fee-criteria.manage',
                        'scholarships.manage',
                        'accounts.manage',
                    ];
                @endphp
                @if ($can($accountsPerms))
                @php
                    $accountsActive = request()->is([
                        'admin/AddFees*',
                        'admin/ClassWiseFeeCriterial*',
                        'admin/AddStudentWiseFeeCriteria*',
                        'admin/AddScholarships*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $accountsActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $accountsActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Accounts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can('fee-heads.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.AddFees.page') }}"
                                class="nav-link {{ request()->is('admin/AddFees*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Fee Heads</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('fee-criteria.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.ClassWiseFeeCriterial.page') }}"
                                class="nav-link {{ request()->is('admin/ClassWiseFeeCriterial*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Class Wise Fee Criterias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.AddStudentWiseFeeCriteria.page') }}"
                                class="nav-link {{ request()->is('admin/AddStudentWiseFeeCriteria*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Student Wise Fee Criterias</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('scholarships.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.AddScholarships.page') }}"
                                class="nav-link {{ request()->is('admin/AddScholarships*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Scholarships</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 3. Fee'S --}}
                @php
                    $feesPerms = [
                        'fee-generation.manage',
                        'fee-slip.collect',
                        'fee-slip.edit',
                    ];
                @endphp
                @if ($can($feesPerms))
                @php
                    $feesActive = request()->is([
                        'admin/FeeGenerations*',
                        'admin/FeesSlip*',
                        'admin/EditFeeSlip*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $feesActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $feesActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comment-dollar"></i>
                        <p>
                            Fee'S
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can('fee-generation.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.FeeGenerations.page') }}"
                                class="nav-link {{ request()->is('admin/FeeGenerations*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fee Generations</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('fee-slip.collect'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.FeesSlip.page') }}"
                                class="nav-link {{ request()->is('admin/FeesSlip*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pay Fee</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('fee-slip.edit'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.EditFeeSlip.page') }}"
                                class="nav-link {{ request()->is('admin/EditFeeSlip*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fee Discount</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 4. Reports --}}
                @php
                    $reportsPerms = [
                        'fee.reports',
                        'finance.reports',
                        'expenses.manage',
                        'students.view',
                        'admissions.create',
                        'exam.reports',
                        'inventory.reports',
                        'inventory.manage',
                    ];
                @endphp
                @if ($can($reportsPerms))
                @php
                    $reportsActive = request()->is([
                        'admin/FeeReports*',
                        'admin/ExpenseAndIncomeReports*',
                        'admin/ReportStudents*',
                        'admin/ExaminationReports*',
                        'admin/InventoryReports*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $reportsActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $reportsActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can('fee.reports'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.FeeReports.page') }}"
                                class="nav-link {{ request()->is('admin/FeeReports*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fee Reports</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['finance.reports', 'expenses.manage']))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.ExpenseAndIncomeReports.page') }}"
                                class="nav-link {{ request()->is('admin/ExpenseAndIncomeReports*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense & Income</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['students.view', 'admissions.create']))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.ReportStudents.page') }}"
                                class="nav-link {{ request()->is('admin/ReportStudents*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Student's Reports</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('exam.reports'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.ExaminationReports.page') }}"
                                class="nav-link {{ request()->is('admin/ExaminationReports*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Exam Reports</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['inventory.reports', 'inventory.manage']))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.InventoryReports.page') }}"
                                class="nav-link {{ request()->is('admin/InventoryReports*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inventory Reports</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 5. Timetable Setup --}}
                @php
                    $timetablePerms = ['locations.manage', 'timetable.manage'];
                @endphp
                @if ($can($timetablePerms))
                @php
                    $timetableActive = request()->is([
                        'admin/Locations*',
                        'admin/TimeTable*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $timetableActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $timetableActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Timetable Setup
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can(['locations.manage', 'timetable.manage']))
                        <li class="nav-item">
                            <a href="/admin/Locations"
                                class="nav-link {{ request()->is('admin/Locations*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Locations & Timings</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('timetable.manage'))
                        <li class="nav-item">
                            <a href="/admin/TimeTable"
                                class="nav-link {{ request()->is('admin/TimeTable*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Time Table</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 6. Standalone Items --}}
                @if ($can('sms.send'))
                <li class="nav-item">
                    <a href="{{ route('adminbackend.SMSRemainder.page') }}"
                        class="nav-link {{ request()->is('admin/SMSRemainder*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sms"></i>
                        <p>
                            SMS / Reminder
                        </p>
                    </a>
                </li>
                @endif

                @if ($can(['expenses.manage', 'finance.reports']))
                <li class="nav-item">
                    <a href="/admin/Expenses" class="nav-link {{ request()->is('admin/Expenses*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Expenses
                        </p>
                    </a>
                </li>
                @endif

                @if ($can('accounts.manage'))
                <li class="nav-item">
                    <a href="/admin/Accounts" class="nav-link {{ request()->is('admin/Accounts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments-dollar"></i>
                        <p>
                            Accounts
                        </p>
                    </a>
                </li>
                @endif

                {{-- 7. Students --}}
                @php
                    $studentsPerms = [
                        'students.attendance',
                        'admissions.create',
                        'students.view',
                        'admissions.edit',
                    ];
                @endphp
                @if ($can($studentsPerms))
                @php
                    $studentsActive = request()->is([
                        'admin/StudentsAttendance*',
                        'admin/NewRegistration*',
                        'admin/NewAdmission*',
                        'admin/StudentProfile*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $studentsActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $studentsActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Students
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can('students.attendance'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.StudentsAttendance.page') }}"
                                class="nav-link {{ request()->is('admin/StudentsAttendance*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Attendance</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('admissions.create'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.NewRegistration.page') }}"
                                class="nav-link {{ request()->is('admin/NewRegistration*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.NewAdmission.page') }}"
                                class="nav-link {{ request()->is('admin/NewAdmission*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Admission</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['students.view', 'admissions.edit']))
                        <li class="nav-item">
                            <a href="/admin/StudentProfile"
                                class="nav-link {{ request()->is('admin/StudentProfile*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Student's Profile</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 8. Examination --}}
                @php
                    $examinationPerms = [
                        'subjects.manage',
                        'marks.entry',
                        'personal-development.manage',
                        'student-promotion.manage',
                    ];
                @endphp
                @if ($can($examinationPerms))
                @php
                    $examinationActive = request()->is([
                        'admin/AddSubjects*',
                        'admin/SubjectWiseMarks*',
                        'admin/PersonalDevelopment*',
                        'admin/ClassWisePersonalDevelopment*',
                        'admin/StudentPromotion*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $examinationActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $examinationActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>
                            Examination
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can('subjects.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.AddSubjects.page') }}"
                                class="nav-link {{ request()->is('admin/AddSubjects*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Class Wise Subjects</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('marks.entry'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.SubjectWiseMarks.page') }}"
                                class="nav-link {{ request()->is('admin/SubjectWiseMarks*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Subject Wise Marks</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('personal-development.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.PersonalDevelopment.page') }}"
                                class="nav-link {{ request()->is('admin/PersonalDevelopment*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Personal Development</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.ClassWisePersonalDevelopment.page') }}"
                                class="nav-link {{ request()->is('admin/ClassWisePersonalDevelopment*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Classwise Personal Development</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('student-promotion.manage'))
                        <li class="nav-item">
                            <a href="/admin/StudentPromotion"
                                class="nav-link {{ request()->is('admin/StudentPromotion*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Student Promotions</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 9. Inventory --}}
                @php
                    $inventoryPerms = [
                        'inventory.manage',
                        'stock.add',
                        'counter-sale.manage',
                        'accounts.manage',
                    ];
                @endphp
                @if ($can($inventoryPerms))
                @php
                    $inventoryActive = request()->is([
                        'admin/CompaniesPage*',
                        'admin/ItemsPage*',
                        'admin/AddStock*',
                        'admin/StockStatistics*',
                        'admin/CounterSale*',
                        'admin/payments*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $inventoryActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $inventoryActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Inventory
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($can('inventory.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.CompaniesPage.page') }}"
                                class="nav-link {{ request()->is('admin/CompaniesPage*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Companies</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.ItemsPage.page') }}"
                                class="nav-link {{ request()->is('admin/ItemsPage*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Items</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['stock.add', 'inventory.manage']))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.Inventory.AddStock') }}"
                                class="nav-link {{ request()->is('admin/AddStock*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Stock</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['inventory.manage', 'inventory.reports']))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.Inventory.StockStatistics') }}"
                                class="nav-link {{ request()->is('admin/StockStatistics*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Statistics</p>
                            </a>
                        </li>
                        @endif

                        @if ($can('counter-sale.manage'))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.Inventory.CounterSale') }}"
                                class="nav-link {{ request()->is('admin/CounterSale*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Counter Sale</p>
                            </a>
                        </li>
                        @endif

                        @if ($can(['counter-sale.manage', 'accounts.manage']))
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.payments.CounterSale') }}"
                                class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payments</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                {{-- 10. Services --}}
                @if ($can('subjects.manage'))
                @php
                    $servicesActive = request()->is([
                        'admin/Services*',
                    ]);
                @endphp
                <li class="nav-item has-treeview {{ $servicesActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $servicesActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-concierge-bell"></i>
                        <p>
                            Services
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('adminbackend.AddSubjects.page') }}"
                                class="nav-link {{ request()->is('admin/Services*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Class Wise Subjects</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

</aside>
