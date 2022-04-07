@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary  collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Departments</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid">
          <form id="departmentform" onsubmit="return false" method="POST">

            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="departmentid" class="form-label"><b>Dept Id</b></label>
                <input type="text" class="form-control form-control-sm" id="departmentid" name="departmentid" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="title" class="form-label"><b>Title</b></label>
                <input type="text" class="form-control form-control-sm" id="title" required name="title"
                  placeholder="">
              </div>
              <div class="col-md-6">
                <label for="departmentdescription" class="form-label"><b>Description</b></label>
                <input type="text" class="form-control form-control-sm" id="departmentdescription" required name="departmentdescription" placeholder="">
              </div>
            </div>
            <div class="row align-item-center">
              <div class="col-md-6">
                <label for="departmentisdisplay" class="form-label"><b>Display Status</b></label>
                <select class="form-control form-control-sm" id="departmentisdisplay" required name="departmentisdisplay" placeholder="">
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="departmmentsequence" class="form-label"><b>Sequence</b></label>
                <input type="number" class="form-control form-control-sm" id="departmmentsequence" required name="departmmentsequence"
                  placeholder="">
              </div>
            </div>
            <div class="row align-items-center  pt-2">
              <div class="col-md-12">
                <input name="submit" id="insertdepartment" class="btn btn-sm btn-primary btn-block" type="submit"
                  value="Save Department">
              </div>
              <div class="col-md-12">
                <input type="submit" name="submit" id="updatedepartment" class="btn btn-sm btn-success btn-block"
                  value="Update Department">
                <input type="submit" onclick="ResetFormByCancelKey()" id="canceldeptformbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>
          </form>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Departments</h4>
            <table id="departmentTable" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Display Status</th>
                  <th>Sequence</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="departmentTableBody">
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="card card-primary  collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Scale</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid">
          <form id="designationForm" onsubmit="return false" method="POST">
            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="id" class="form-label"><b>Scale Id</b></label>
                <input type="text" class="form-control form-control-sm" id="desid" name="id" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="scalename" class="form-label"><b>Pay Scale</b></label>
                <input type="text" class="form-control form-control-sm" id="scalename" required name="scalename"
                  placeholder="">
              </div>
              <div class="col-md-6">
                <label for="scaledescription" class="form-label"><b>Description</b></label>
                <input type="text" class="form-control form-control-sm" id="scaledescription" required name="scaledescription" placeholder="">
              </div>
            </div>

            <div class="row align-items-center  ">
              <div class="col-md-6">
                <label for="basicpay" class="form-label"><b>Basic Pay</b></label>
                <input type="number" class="form-control form-control-sm" id="basicpay" required name="basicpay" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="yearlyincrement" class="form-label"><b>Yearly Increment</b></label>
                <input type="number" class="form-control form-control-sm" id="yearlyincrement" required name="yearlyincrement" placeholder="">
              </div>
            </div>
            <div class="row align-item-center">
              <div class="col-md-3">
                <label for="salarylimit" class="form-label"><b>Salary Limit</b></label>
                <input type="number" class="form-control form-control-sm" id="salarylimit" required name="salarylimit" placeholder="">
              </div>
              <div class="col-md-3">
                <label for="eobiamount" class="form-label"><b>EOBI Amount</b></label>
                <input type="number" class="form-control form-control-sm" id="eobiamount" required name="eobiamount" placeholder="">
              </div>
              <div class="col-md-3">
                <label for="LeaveAmount" class="form-label"><b>One Leave Deduction</b></label>
                <input type="number" class="form-control form-control-sm" id="LeaveAmount" required name="LeaveAmount" placeholder="">
              </div>
              <div class="col-md-3">
                <label for="LeaveStatus" class="form-label"><b>Leave Status</b></label>
                <input type="checkbox" class="form-control form-control-sm text-left" id="LeaveStatus" required name="LeaveStatus" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="isactive" class="form-label"><b>IsActive</b></label>
                <select class="form-control form-control-sm" id="isactive" required name="isactive" placeholder="">
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="sequence" class="form-label"><b>Sequence</b></label>
                <input type="number" class="form-control form-control-sm" id="sequence" required name="sequence"
                  placeholder="">
              </div>
              <div class="col-md-6">
                <label for="academicsession" class="form-label"><b>Academic Session</b></label>
                <?php
                  $sessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsActive', 1)->get();
                ?>
                <select class="form-control form-control-sm" id="academicsession" name="academicsession" placeholder="">
                  <option value="">Select session</option>
                  @foreach ($sessions as $session)
                  <option {{ $session->IsCurrent ? "selected" : "" }} value="{{ $session->id }}">{{ $session->Session }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row align-items-center  pt-2">
              <div class="col-md-12">
                <input name="submit" id="insertDesignation" class="btn btn-sm btn-primary btn-block" type="submit"
                  value="Save Scale">
              </div>
              <div class="col-md-12">
                <input type="submit" name="submit" id="updateDesignation" class="btn btn-sm btn-success btn-block"
                  value="Update Scale">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>
          </form>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Basic Pay Scale</h4>
            <table id="example33" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Pay Scale</th>
                  <th>Description</th>
                  <th>Basic Pay</th>
                  <th>Yearly Increment</th>
                  <th>Salary Limit</th>
                  <th>EOBI</th>
                  <th>LeaveAmount</th>
                  <th>LeaveStatus</th>
                  <th>IsActive</th>
                  <th>Sequence</th>
                  <th>Session</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="DesData">
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>


  <div class="col-md-12">
    <div class="card card-primary  collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Allowances</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid">
          <form id="allawanceForm" onsubmit="return false" method="POST">

            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="allowanceid" class="form-label"><b>Dept Id</b></label>
                <input type="text" class="form-control form-control-sm" id="allowanceid" name="allowanceid" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="allowancename" class="form-label"><b>Name</b></label>
                <input type="text" class="form-control form-control-sm" id="allowancename" required name="allowancename"
                  placeholder="">
              </div>
              <div class="col-md-4 d-none">
                <label for="allawanceamount" class="form-label"><b>Max Amount</b></label>
                <input type="number" value="1" class="form-control form-control-sm" id="allawanceamount" required name="allawanceamount" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="allowancedescription" class="form-label"><b>Description</b></label>
                <input type="text" class="form-control form-control-sm" id="allowancedescription" required name="allowancedescription" placeholder="">
              </div>
            </div>
            <div class="row align-items-center  ">
              <div class="col-md-6">
                <label for="allowancescale" class="form-label"><b>Scale</b></label>
                <select class="form-control form-control-sm" id="allowancescale" required name="allowancescale" placeholder="">
                </select>
              </div>
              <div class="col-md-4 d-none">
                <label for="allowancetype" class="form-label"><b>Type (Deduction or Allowance)</b></label>
                <select class="form-control form-control-sm" id="allowancetype" required name="allowancetype" placeholder="">
                  <option value="PLUS">Allowance</option>
                  <option value="MINUS">Deduction</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="allownaceacademinsession" class="form-label"><b>Academinc Session</b></label>
                <select class="form-control form-control-sm" id="allownaceacademinsession" required name="allownaceacademinsession" placeholder="">
                  <option value="">Select session</option>
                  @foreach ($sessions as $session)
                  <option value="{{ $session->id }}">{{ $session->Session }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row align-items-center  pt-2">
              <div class="col-md-12">
                <input name="submit" id="insertAllowance" class="btn btn-sm btn-primary btn-block" type="submit"
                  value="Save Allowance">
              </div>
              <div class="col-md-12">
                <input type="submit" name="submit" id="updateAllowance" class="btn btn-sm btn-success btn-block"
                  value="Update Allowance">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelallowanceformbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>
          </form>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Allowances</h4>
            <table id="allowanceTable" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  {{-- <th>Max Amount</th> --}}
                  {{-- <th>Ded. Amount</th> --}}
                  <th>Session</th>
                  <th>Description</th>
                  <th>Scale</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="allowanceTableBody">
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Employee<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid">
          <form id="EmployeeForm" onsubmit="return false" method="POST" enctype="multipart/form-data">
            @if (Auth::user()->id == 1)
            <div class="row align-items-center  ">
              <div class="col-md-4">
                <?php
                  $campuss = \App\Models\addCampus::all();
                  $scales = \App\Models\Scale::where('campusid', Auth::user()->campusid)->get();
                ?>
                <label for="addCampusAdmin" class="form-label"><b>Campus</b></label>
                <select class="form-control form-control-sm" id="addCampusAdmin" required name="addCampusAdmin"
                  placeholder="">
                  <option value="">Select</option>
                  @foreach ($campuss as $campus)
                  <option @if (Auth::user()->campusid == $campus->campusid)
                    {{ "selected" }}
                    @endif value="{{ $campus->campusid }}">{{ $campus->CampusName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @endif
            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="id" class="form-label"><b>Employee Id</b></label>
                <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="">
              </div>
              <div class="col-md-4">
                <label for="name" class="form-label"><b>Employee Name</b></label>
                <input type="text" class="form-control form-control-sm" id="name" required name="name" placeholder="">
              </div>
              <div class="col-md-4">
                <label for="fname" class="form-label"><b>Father Name</b></label>
                <input type="text" class="form-control form-control-sm" id="fname" required name="fname" placeholder="">
              </div>
              <div class="col-md-4">
                <label for="cnic" class="form-label"><b>CNIC</b></label>
                <input type="text" class="form-control form-control-sm" id="cnic" required name="cnic" placeholder="">
              </div>
            </div>

            <div class="row align-items-center  ">
              <div class="col-md-2">
                <?php
                  $roles = \App\Models\Role::where('CampusID', Auth::user()->campusid)->where('IsActive', '=', 1)->get();
                ?>
                <label for="empRole" class="form-label"><b>Role</b></label>
                <select class="form-control form-control-sm" id="empRole" required name="empRole" placeholder="">
                  <option value="">Select</option>
                  @foreach ($roles as $role)
                  <option value="{{ $role->RoleId }}">{{ $role->Role }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label for="gender" class="form-label"><b>Gender</b></label>
                <select class="form-control form-control-sm" id="gender" required name="gender" placeholder="">
                  <option value="">Select</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Transgender">Transgender</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="email" class="form-label"><b>Email Address</b></label>
                <input type="email" class="form-control form-control-sm" id="email" required name="email"
                  placeholder="">
              </div>
              <div class="col-md-4">
                <label for="password" class="form-label"><b>Password</b></label>
                <input type="password" class="form-control form-control-sm" id="password" required name="password"
                  placeholder="">
              </div>
            </div>

            <div class="row align-items-center  ">
              <div class="col-md-4">
                <label for="empindepartment" class="form-label"><b>Department</b></label>
                <select class="form-control form-control-sm" id="empindepartment" required name="empindepartment" placeholder="">
                </select>
              </div>
              <div class="col-md-4">
                <label for="empscale" class="form-label"><b>Scale</b></label>
                <select class="form-control form-control-sm" id="empscale" required name="empscale" placeholder="">
                </select>
              </div>
              <div class="col-md-4">
                <label for="fixedsalary" class="form-label"><b>Fixed Salary</b></label>
                <select class="form-control form-control-sm" id="fixedsalary" required name="fixedsalary" placeholder="">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>
            </div>

            <div class="row align-items-center  ">
              <div class="col-md-3">
                <label for="phone1" class="form-label"><b>Phone 1</b></label>
                <input type="tel" maxlength="11" class="form-control form-control-sm" id="phone1" required name="phone1"
                  placeholder="">
              </div>
              <div class="col-md-3">
                <label for="phone2" class="form-label"><b>Phone 2</b></label>
                <input type="tel" maxlength="11" class="form-control form-control-sm" id="phone2" name="phone2"
                  placeholder="">
              </div>
              <div class="col-md-3">
                <label for="joindate" class="form-label"><b>Join Date</b></label>
                <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" id="joindate"
                  required name="joindate" placeholder="">
              </div>
              <div class="col-md-3">
                <label for="isactiveemployee" class="form-label"><b>IsActive</b></label>
                <select class="form-control form-control-sm" id="isactiveemployee" required name="isactiveemployee" placeholder="">
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
            </div>

            <div class="row align-items-center  ">
              <div class="col-md-4">
                <label for="address1" class="form-label"><b>Address 1</b></label>
                <textarea class="form-control form-control-sm" id="address1" name="address1" rows=""></textarea>
              </div>
              <div class="col-md-4">
                <label for="address2" class="form-label"><b>Address 2</b></label>
                <textarea class="form-control form-control-sm" id="address2" name="address2" rows=""></textarea>
              </div>
              <div class="col-md-2">
                <label for="busnumber" class="form-label"><b>Bus</b></label>
                <?php
                  $buses = \App\Models\Buses::where('campusid', Auth::user()->campusid)->where('busisdisplay', 1)->get();
                ?>
                <select class="form-control form-control-sm" id="busnumber" name="busnumber" placeholder="">
                  <option value="">Select</option>
                  @foreach ($buses as $bus)
                  <option value="{{ $bus->busnumber }}">{{ $bus->busnumber }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label for="profilepicture" class="form-label"><b>Profile Picture</b></label>
                <input type="file" class="form-control-sm form-control-file" id="profilepicture" name="profilepicture">
              </div>
            </div>

            <div class="row align-items-center  pt-2">
              <div class="col-md-12">
                <input type="submit" type="submit" id="insertEmployee" class="btn btn-sm btn-primary btn-block"
                  value="Save Employee">
              </div>
              <div class="col-md-12">
                <input type="submit" id="updateEmployee" class="btn btn-sm btn-success btn-block"
                  value="Update Employee">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelEmpFormbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>


          </form>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Employees</h4>
            <table id="example3" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#.</th>
                  <th>Emp Name</th>
                  <th>Father Name</th>
                  <th>CNIC</th>
                  <th>Role</th>
                  <th>Campus</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="EmpData">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>




<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous">
</script>
<script>
  function ResetFormByCancelKey(){
    $("#EmployeeForm").trigger("reset");
    $('#updateEmployee').hide();
    $('#insertEmployee').show();
    $('#cancelEmpFormbtn').hide();
    $('#insertEmployee').prop('type', 'submit');

    $("#designationForm").trigger("reset");
    $('#updateDesignation').hide();
    $('#insertDesignation').show();
    $('#insertDesignation').prop('type', 'submit');
    $('#cancelbtn').hide();

    $("#departmentform").trigger("reset");
    $('#updatedepartment').hide();
    $('#insertdepartment').show();
    $('#insertdepartment').prop('type', 'submit');
    $('#canceldeptformbtn').hide();

    $("#allawanceForm").trigger("reset");
    $('#updateAllowance').hide();
    $('#insertAllowance').show();
    $('#insertAllowance').prop('type', 'submit');
    $('#cancelallowanceformbtn').hide();
  }
  var data;
  var scales = '';
  var departments = "";
  var allowances = "";
  $(document).ready(function() {
    $('#updateAllowance').hide();
    $('#updateEmployee').hide();
    $('#insertEmployee').show();
    $('#updateDesignation').hide();
    $('#updatedepartment').hide();
    $('#insertDesignation').show();
    LoadCompany();
    var dataa = '';

    // updating allowance
    $('#updateAllowance').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.UpdateAllowance') }}",
        method: 'POST',
        data: $("#allawanceForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Allowance already exist", "warning");
            return;
          }
          LoadCompany();
          swal("Good job!", "Allowance is successfully updated!", "success");
          $("#allawanceForm").trigger("reset");
          $('#updateAllowance').hide();
          $('#insertAllowance').show();
          $('#insertAllowance').prop('type', 'submit');
          $('#cancelallowanceformbtn').hide();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // updating department
    $('#updatedepartment').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.UpdateDepartment') }}",
        method: 'POST',
        data: $("#departmentform").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Department already exist", "warning");
            return;
          }
          LoadCompany();
          swal("Good job!", "Department is successfully updated!", "success");
          $("#departmentform").trigger("reset");
          $('#updatedepartment').hide();
          $('#insertdepartment').show();
          $('#insertdepartment').prop('type', 'submit');
          $('#canceldeptformbtn').hide();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // Inserting allowance
    $('#insertAllowance').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddAllowance') }}",
        method: 'POST',
        data: $("#allawanceForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Allowance already exist", "warning");
            return;
          }
          LoadCompany();
          swal("Good job!", "Allowance is successfully added!", "success");
          $("#allawanceForm").trigger("reset");
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // updating department
    $('#updatedepartment').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.UpdateDepartment') }}",
        method: 'POST',
        data: $("#departmentform").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Department already exist", "warning");
            return;
          }
          LoadCompany();
          swal("Good job!", "Department is successfully updated!", "success");
          $("#departmentform").trigger("reset");
          $('#updatedepartment').hide();
          $('#insertdepartment').show();
          $('#insertdepartment').prop('type', 'submit');
          $('#canceldeptformbtn').hide();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // Inserting designations
    $('#insertdepartment').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddDepartment') }}",
        method: 'POST',
        data: $("#departmentform").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Department already exist", "warning");
            return;
          }
          LoadCompany();
          swal("Good job!", "Department is successfully added!", "success");
          $("#departmentform").trigger("reset");
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


    $("#updateEmployee").click(function() {
      var formData = new FormData(document.getElementById("EmployeeForm"));
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateEmployeeConfigration') }}",
        method: 'POST',
        // data: $("#EmployeeForm").serialize(),
        data: formData,
        processData: false,
        contentType: false,
        success: function(result) {
          LoadCompany();
          swal("Good job!", "Employee is successfully updated!", "success");
          $("#EmployeeForm").trigger("reset");
          $('#updateEmployee').hide();
          $('#insertEmployee').show();
          $('#cancelEmpFormbtn').hide();
          $('#insertEmployee').prop('type', 'submit');
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    $('#insertEmployee').click(function() {
      var formData = new FormData(document.getElementById("EmployeeForm"));
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddEmployeeConfigration') }}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(result) {
          // console.log(result.result);
          LoadCompany();
          swal("Good job!", "Employee is successfully added!", "success");
          $("#EmployeeForm").trigger("reset");
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
            // alert(error);
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


// Inserting designations
    $('#insertDesignation').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddScale') }}",
        method: 'POST',
        data: $("#designationForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Scale already exist", "warning");
            return;
          }
          LoadCompany();
          swal("Good job!", "Scale is successfully added!", "success");
          $("#designationForm").trigger("reset");
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // updating designation
    $('#updateDesignation').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.UpdateScale') }}",
        method: 'POST',
        data: $("#designationForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Scale already exist", "warning");
            return;
          }
          LoadCompany();
          swal("Good job!", "Scale is successfully added!", "success");
          $("#designationForm").trigger("reset");
          $('#updateDesignation').hide();
          $('#insertDesignation').show();
          $('#insertDesignation').prop('type', 'submit');
          $('#cancelbtn').hide();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


  });

  function LoadCompany() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
      dataType: "json",
      method: "POST",
      url: "{{ route('admin.ViewAllowances') }}",
      success: function(dept) {
        allowances = JSON.parse(dept);
        $("#allowanceTable").DataTable().destroy();
        $("#allowanceTableBody").empty();
        var j = 1;
        for (i = 0; i < allowances.length; ++i) {
          $('#allowanceTableBody').append('<tr  ondblclick="EditAllowance(' + allowances[i].allowanceid + ','+ i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + allowances[i].allowancename + '</td>' +
            // '<td>' + allowances[i].amount + '</td>' +
            // '<td>' + allowances[i].allowancetype + '</td>' +
            '<td>' + allowances[i].Session + '</td>' +
            '<td>' + allowances[i].AllowanceDescription + '</td>' +
            '<td>' + allowances[i].scalename + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
        }
        $('#allowanceTable').dataTable();
      },
      error: function() {
      }
    });

    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewDepartment') }}",
      success: function(dept) {
        departments = JSON.parse(dept);
        $("#departmentTable").DataTable().destroy();
        $("#departmentTableBody").empty();
        $("#empindepartment").empty();
        $("#empindepartment").append('<option value="">Select Department</option>');
        var j = 1;
        for (i = 0; i < departments.length; ++i) {
          $('#departmentTableBody').append('<tr  ondblclick="EditDepartment(' + departments[i].id + ','+ i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + departments[i].title + '</td>' +
            '<td>' + departments[i].description + '</td>' +
            '<td>' + (departments[i].isdisplay ? "Yes" : "No") + '</td>' +
            '<td>' + departments[i].sequence + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></span></td>'+'</tr>');
          j++;
          if(departments[i].isdisplay)
            $("#empindepartment").append('<option value="' + departments[i].id + '">' + departments[i].title + '</option>');
        }
        $('#departmentTable').dataTable();
      },
      error: function() {
      }
    });

    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewEmployeeConfigration') }}",
      success: function(EmpData) {
        dataa = JSON.parse(EmpData);
        $("#example3").DataTable().destroy();
        $("#EmpData").empty();
        var j = 1;
        for (i = 0; i < dataa.length; ++i) {
          $('#EmpData').append('<tr  ondblclick="EditEmployee(' +dataa[i].id+','+ i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + dataa[i].name + '</td>' +
            '<td>' + dataa[i].fname + '</td>' +
            '<td>' + dataa[i].cnic + '</td>' +
            '<td>' + dataa[i].Role + '</td>' +
            '<td>' + dataa[i].CampusName + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
        }
        $('#example3').dataTable();
      },
      error: function() {
      }
    });

    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewScale') }}",
      success: function(data) {
        scales = JSON.parse(data);
        // console.log(scales);
        $("#example33").DataTable().destroy();
        $("#DesData").empty();
        $("#empscale").empty();
        $("#allowancescale").empty();
        $("#empscale").append('<option value="">Select Scale</option>');
        $("#allowancescale").append('<option value="">Select Scale</option>');
        var j = 1;
        // console.log(scales);
        for (i = 0; i < scales.length; i++) {
          $('#DesData').append('<tr  ondblclick="EditDesignation(' +scales[i].scaleid+','+ i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + scales[i].name + '</td>' +
            '<td>' + scales[i].description + '</td>' +
            '<td>' + scales[i].basicpay + '</td>' +
            '<td>' + scales[i].yearlyincrement + '</td>' +
            '<td>' + scales[i].salarylimit + '</td>' +
            '<td>' + scales[i].eobiamount + '</td>' +
            '<td>' + scales[i].leaveAmount + '</td>' +
            '<td>' + (scales[i].leaveStatus ? "Yes" : "No") + '</td>' +
            '<td>' + (scales[i].isactive ? "Yes" : "No") + '</td>' +
            '<td>' + scales[i].sequence + '</td>' +
            '<td>' + scales[i].Session + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
          if(scales[i].isactive){
            $("#empscale").append('<option value="' + scales[i].scaleid + '">' + scales[i].name + " - " + scales[i].Session + '</option>');
          }
          if(scales[i].isactive && scales[i].IsCurrent){
            $("#allowancescale").append('<option value="' + scales[i].scaleid + '">' + scales[i].name + " - " + scales[i].Session + '</option>');
          }
        }
        $('#example33').dataTable();
      },
      error: function() {
      }
    });
  }

  function EditAllowance(allid, i) {
    // console.log(allowances[i]);
    $('#insertAllowance').hide();
    $('#insertAllowance').prop('type', '');
    $('#updateAllowance').show();
    $('#cancelallowanceformbtn').show();
    $('#allowanceid').val(allid);
    $('#allowancename').val(allowances[i].allowancename);
    $('#allawanceamount').val(allowances[i].amount);
    $('#allowancedescription').val(allowances[i].AllowanceDescription);
    $('#allowancescale').val(allowances[i].scaleid);
    $('#allowancetype').val(allowances[i].allowancetype);
    $('#allownaceacademinsession').val(allowances[i].sessionid);
  }

  function EditDepartment(deptid, i) {
    $('#insertdepartment').hide();
    $('#insertdepartment').prop('type', '');
    $('#updatedepartment').show();
    $('#canceldeptformbtn').show();
    $('#departmentid').val(deptid);
    $('#title').val(departments[i].title);
    $('#departmentdescription').val(departments[i].description);
    $('#departmentisdisplay').val(departments[i].isdisplay);
    $('#departmmentsequence').val(departments[i].sequence);
  }

  function EditEmployee(empid, i) {
    $('#insertEmployee').hide();
    $('#insertEmployee').prop('type', '');
    $('#updateEmployee').show();
    $('#cancelEmpFormbtn').show();
    $('#id').val(empid);
    $('#name').val(dataa[i].name);
    $('#fname').val(dataa[i].fname);
    $('#cnic').val(dataa[i].cnic);
    $('#gender').val(dataa[i].gender);
    $('#empRole').val(dataa[i].roleid);
    $('#email').val(dataa[i].email);
    $('#phone1').val(dataa[i].phone1);
    $('#phone2').val(dataa[i].phone2);
    $('#address1').val(dataa[i].address1);
    $('#address2').val(dataa[i].address2);
    $('#joindate').val(dataa[i].joindate);
    $('#isactiveemployee').val(dataa[i].isactive);
    $('#empindepartment').val(dataa[i].departmentid);
    $('#empscale').val(dataa[i].scaleid);
    $('#fixedsalary').val(dataa[i].fixedsalary);
    $('#busnumber').val(dataa[i].busnumber);
  }

  function EditDesignation(desid, i) {
    // console.log(scales[i]);
    $('#insertDesignation').hide();
    $('#insertDesignation').prop('type', '');
    $('#updateDesignation').show();
    $('#cancelbtn').show();
    $('#desid').val(desid);
    $('#scalename').val(scales[i].name);
    $('#scaledescription').val(scales[i].description);
    $('#basicpay').val(scales[i].basicpay);
    $('#yearlyincrement').val(scales[i].yearlyincrement);
    $('#salarylimit').val(scales[i].salarylimit);
    $('#LeaveAmount').val(scales[i].leaveAmount);
    scales[i].leaveStatus ? $('#LeaveStatus').prop('checked', true) : $('#LeaveStatus').prop('checked', false);
    $('#eobiamount').val(scales[i].eobiamount);
    $('#isactive').val(scales[i].isactive);
    $('#sequence').val(scales[i].sequence);
    $('#academicsession').val(scales[i].academicsession);
  }
</script>



@endsection
