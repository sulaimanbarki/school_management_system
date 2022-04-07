<aside class="main-sidebar sidebar-dark-primary elevation-4">
  {{-- {{ dd("sdsd");}} --}}
  <!-- Brand Logo -->

  <a href="/admin/dashboard" class="brand-link">

    <?php
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
    ?>

    <img
      src="<?php if( $campus->Logo_photo_path){ echo asset('CampusLogos/' . $campus->Logo_photo_path); }else{ echo asset('userbackend/dist/img/AdminLTELogo.png'); } ?>"
      alt="" class="brand-image img-circle elevation-3" style="opacity: .8">

    <span class="brand-text font-weight-light">{{ $campus->CampusName }}</span>

  </a>



  <!-- Sidebar -->

  <div class="sidebar">

    <!-- Sidebar user panel (optional) -->

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="image">

        <img src="{{ asset('userbackend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">

      </div>

      <div class="info">
        @php
        $role = \App\Models\Role::where('RoleId', Auth::user()->roleid)->where('campusid',
        Auth::user()->campusid)->value('Role');
        @endphp
        <small><a href="/admin/dashboard" class="d-block">{{ Auth::user()->name}} ({{$role}})</a></small>

      </div>

    </div>



    <!-- SidebarSearch Form -->

    {{-- <div class="form-inline">

      <div class="input-group" data-widget="sidebar-search">

        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">

        <div class="input-group-append">

          <button class="btn btn-sidebar">

            <i class="fas fa-search fa-fw"></i>

          </button>

        </div>

      </div>

    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Admin Controls
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if (Auth::user()->id == 1)
            <li class="nav-item">
              <a href="{{ route('adminbackend.addCampus.page') }}"
                class="nav-link {{(request()->is('admin/AddCampus')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon active"></i>
                <p>Add Campus</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('adminbackend.AddRole.page') }}"
                class="nav-link {{(request()->is('admin/AddRole')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Roles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.pages.page') }}"
                class="nav-link {{(request()->is('admin/Pages')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon active"></i>
                <p>Admin Pages</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.pages.PagesRoleWise') }}"
                class="nav-link {{(request()->is('admin/PagesRoleWise')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon active"></i>
                <p>Role Wise Pages</p>
              </a>
            </li>

            @endif

            <li class="nav-item">
              <a href="{{ route('adminbackend.AddEmployee.page') }}"
                class="nav-link {{(request()->is('admin/AddEmployee')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Employee</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.addClass.page') }}"
                class="nav-link {{(request()->is('admin/addClass')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Classes And Sections</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.StaffwiseFeesCriteria.page') }}"
                class="nav-link {{(request()->is('admin/StaffwiseFeesCriteria')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Staff wise Allowances</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.NetSalarySheet.page') }}"
                class="nav-link {{(request()->is('admin/NetSalarySheet')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Staff SalarySheet</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.FeeGenerationStaff.page') }}"
                class="nav-link {{(request()->is('admin/FeeGenerationStaff')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Salary Generations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/StaffProfile" class="nav-link {{(request()->is('admin/StaffProfile')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Staff's Profile</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>
              Accounts
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('adminbackend.AddFees.page') }}"
                class="nav-link {{(request()->is('admin/AddFees')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Fee Heads</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.ClassWiseFeeCriterial.page') }}"
                class="nav-link {{(request()->is('admin/ClassWiseFeeCriterial')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Class Wise Fee Criterias</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.AddStudentWiseFeeCriteria.page') }}"
                class="nav-link {{(request()->is('admin/AddStudentWiseFeeCriteria')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Student Wise Fee Criterias</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.AddScholarships.page') }}"
                class="nav-link {{(request()->is('admin/AddScholarships')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Scholarships</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-comment-dollar"></i>
            <p>
              Fee'S
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('adminbackend.FeeGenerations.page') }}"
                class="nav-link {{(request()->is('admin/FeeGenerations')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Fee Generations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.FeesSlip.page') }}"
                class="nav-link {{(request()->is('admin/FeesSlip')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pay Fee</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminbackend.EditFeeSlip.page') }}"
                class="nav-link {{(request()->is('admin/EditFeeSlip')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Fee Discount</p>
              </a>
            </li>
        </li>

      </ul>
      </li>
      <li class="nav-item ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Reports
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('adminbackend.FeeReports.page') }}"
              class="nav-link {{(request()->is('admin/FeeReports')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Fee Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.ExpenseAndIncomeReports.page') }}"
              class="nav-link {{(request()->is('admin/ExpenseAndIncomeReports')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Expense & Income</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.ReportStudents.page') }}"
              class="nav-link {{(request()->is('admin/ReportStudents')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Student's Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.ExaminationReports.page') }}"
              class="nav-link {{(request()->is('admin/ExaminationReports')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Exam Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.InventoryReports.page') }}"
              class="nav-link {{(request()->is('admin/InventoryReports')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Inventory Reports</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Timetable Setup
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="/admin/Locations" class="nav-link {{(request()->is('admin/Locations')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Locations & Timings</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/TimeTable" class="nav-link {{(request()->is('admin/TimeTable')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Time Table</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a href="{{ route('adminbackend.SMSRemainder.page') }}"
          class="nav-link {{(request()->is('admin/SMSRemainder')) ? 'active' : ''}}">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            SMS / Reminder
            {{-- <i class="right fas fa-angle-left"></i> --}}
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/admin/Expenses" class="nav-link {{(request()->is('admin/Expenses')) ? 'active' : ''}}">
          <i class="nav-icon fas fa-comments-dollar"></i>
          <p>
            Expenses
            {{-- <i class="right fas fa-angle-left"></i> --}}
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/admin/Accounts" class="nav-link {{(request()->is('admin/Accounts')) ? 'active' : ''}}">
          <i class="nav-icon fas fa-comments-dollar"></i>
          <p>
            Accounts
            {{-- <i class="right fas fa-angle-left"></i> --}}
          </p>
        </a>
      </li>

      <li class="nav-item ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-graduate"></i>
          <p>
            Students
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
          <li class="nav-item">
            <a href="{{ route('adminbackend.StudentsAttendance.page') }}"
              class="nav-link {{(request()->is('admin/StudentsAttendance')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Attendance</p>
            </a>
          </li>
          <li class="nav-item">
          <li class="nav-item">
            <a href="{{ route('adminbackend.NewRegistration.page') }}"
              class="nav-link {{(request()->is('admin/NewRegistration')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>New Registration</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.NewAdmission.page') }}"
              class="nav-link {{(request()->is('admin/NewAdmission')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>New Admission</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/StudentProfile"
              class="nav-link {{(request()->is('admin/StudentProfile')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Student's Profile</p>
            </a>
          </li>
        </ul>

      </li>

      <li class="nav-item ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-graduate"></i>
          <p>
            Examination
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('adminbackend.AddSubjects.page') }}"
              class="nav-link {{(request()->is('admin/AddSubjects')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Class Wise Subjects</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.SubjectWiseMarks.page') }}"
              class="nav-link {{(request()->is('admin/SubjectWiseMarks')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Subject Wise Marks</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.PersonalDevelopment.page') }}"
              class="nav-link {{(request()->is('admin/PersonalDevelopment')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Personal Development</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.ClassWisePersonalDevelopment.page') }}"
              class="nav-link {{(request()->is('admin/ClassWisePersonalDevelopment')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Classwise Personal Development</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/StudentPromotion"
              class="nav-link {{(request()->is('admin/StudentPromotion')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Student Promotions</p>
            </a>
          </li>
        </ul>

      </li>

      <li class="nav-item ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-graduate"></i>
          <p>
            Inventory
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('adminbackend.CompaniesPage.page') }}"
              class="nav-link {{(request()->is('admin/CompaniesPage')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Companies</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.ItemsPage.page') }}"
              class="nav-link {{(request()->is('admin/ItemsPage')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Items</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.Inventory.AddStock') }}"
              class="nav-link {{(request()->is('admin/AddStock')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Add Stock</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.Inventory.StockStatistics') }}"
              class="nav-link {{(request()->is('admin/StockStatistics')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Stock Statistics</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.Inventory.CounterSale') }}"
              class="nav-link {{(request()->is('admin/CounterSale')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Counter Sale</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminbackend.payments.CounterSale') }}"
              class="nav-link {{(request()->is('admin/payments')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Payments</p>
            </a>
          </li>
        </ul>

      </li>

      <li class="nav-item ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-graduate"></i>
          <p>
            Services
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('adminbackend.AddSubjects.page') }}"
              class="nav-link {{(request()->is('admin/AddSubjects')) ? 'active' : ''}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Class Wise Subjects</p>
            </a>
          </li>
        </ul>

      </li>
      </ul>

    </nav>

    <!-- /.sidebar-menu -->

  </div>

  <!-- /.sidebar -->

</aside>