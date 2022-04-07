@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
      // select all companies
      $companies = \App\Models\Company::where('campusid', Auth::user()->campusid)->get();
      $teacherRoleId = \App\Models\Role::where('Role', 'Teacher')->where('Role', 'teacher')->value('RoleId');
      $teachers = \App\Models\Admin::where('RoleId', $teacherRoleId)->where('campusid', Auth::user()->campusid)->get();
    ?>

    <form id="ReportForm" action="/admin" method="POST">
      <div class="row  pt-1 pb-1">
        <div class="col-md-3">
          <label for="FromDate" class="form-label"><b>From Date</b></label>
          <input type="date" value="<?php echo date('Y-m-d'); ?>" name="fromdate" id="fromdate"
            class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
          <label for="ToDate" class="form-label"><b>To Date</b></label>
          <input type="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" name="todate"
            id="todate">
        </div>
        <div class="col-md-3">
          <label for="ToDate" class="form-label"><b>Company</b></label>
          <select class="form-control form-control-sm" id="company" name="company">
            <option value="">Select Company</option>
            @foreach ($companies as $company)
            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="ToDate" class="form-label"><b>Users</b></label>
          <select class="form-control form-control-sm" id="company" name="company">
            <option value="">Select User</option>
            @foreach ($teachers as $teacher)
            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- <div class="row mt-2 mb-2">
  <div class="col-md-12 pt-2 pb-2">
    <form onsubmit="return false" id="searchStudentForm">
      <hr>
      <div class="row">
        <div class="col-md-2">
          <label for="stdid">Search Student by Id</label>
        </div>
        <div class="col-md-2">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text" id="campusId">{{ $campus->CampusPrefix }}</span>
            </div>
            <input type="text" class="form-control" id="stdid" name="stdid" placeholder="Student Id"
              aria-label="StudentId" aria-describedby="basic-addon1">
          </div>
        </div>
        <div class="col-md-1">
          <input name="submit" id="searchStudent" class="btn btn-sm btn-primary btn-block" type="submit" value="Search">
        </div>
        <div class="col-md-2">
          <input type="text" readonly class="form-control form-control-sm" id="stdname" name="stdname" placeholder="">
        </div>
        <div class="col-md-2">
          <input type="text" readonly class="form-control form-control-sm" id="fathername" name="fathername"
            placeholder="">
        </div>
        <div class="col-md-1">
          <input type="text" readonly class="form-control form-control-sm" id="inClass" placeholder="">
        </div>
        <div class="col-md-2">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text">Bus</span>
            </div>
            <input type="text" readonly class="form-control form-control-sm" id="busstatus" placeholder="">
          </div>
        </div>
      </div>
      <hr>
    </form>
  </div>
</div> --}}
<hr>
<div class="row">
  <div class="col-md-3">
    <button formtarget='_blank' formaction="/admin/Outstanding" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">
      Item Ledger Stock in</button>

    <button formtarget='_blank' formaction="{{ route('admin.OutstandingPaid') }}"
      onclick="DisableFormBothAttribute(event)" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Cash Payment to company</button>

    <button formtarget='_blank' formaction="{{ route('admin.ClassWiseOutstanding') }}"
      onclick="DisableFormSectionAttribute(event)" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">User Sale Reports</button>

    <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">User Cash Payments</button>

    <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Users Invoice Edit Sale</button>
  </div>
</div>


<script>
  $("#searchStudentForm").submit(function (e) {
    e.preventDefault();
    let prefix = "{{ $campus->CampusPrefix }}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        dataType: "json",
        type: 'POST',
        url: "{{ route('admin.ViewSingleStudent') }}",
        data: {studentid: prefix + e.target[0].value},
        success: function(SessionData){
          sessionData=JSON.parse(SessionData);
          // console.log(sessionData);
          if(sessionData.length < 1){
            $("#stdname").val("");
            $("#fathername").val("");
            swal("Error!", "No record found", "warning");
            return;
          }
          $("#stdname").val(sessionData[0].studentname);
          $("#fathername").val(sessionData[0].fathername);
          $("#inClass").val(sessionData[0].ClassName);
          $("#busstatus").val(sessionData[0].busnumber);
        },
        error: function()
        {
          alert('internet issue');
        }
    });
  });
  $(document).ready(function () {
    const monthControl = document.querySelector('input[type="month"]');
    const date= new Date()
    const month=("0" + (date.getMonth() + 1)).slice(-2)
    const year=date.getFullYear()
    monthControl.value = `${year}-${month}`;
  });

  function DisableFormSectionAttribute(e){
    $("#formSection").removeAttr('required');
    setTimeout(() => {
      $("#formSection").attr('required', 'required');
    }, 1000);
  }

  function DisableFormBothAttribute(e){
    $("#formClass").removeAttr('required');
    $("#formSection").removeAttr('required');
    setTimeout(() => {
      $("#formClass").attr('required', 'required');
      $("#formSection").attr('required', 'required');
    }, 1000);
  }

  function FetchSections(e){
    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchSectionForClassConfigration') }}",
        data: {classId: e},
        success: function(SessionData)
        {
          sessionData=JSON.parse(SessionData);
          $("#formSection").empty();
          var j=1;
          $('#formSection').append("<option value=''>Select section</option>");
          for (i=0; i < sessionData.length; ++i) {
            $('#formSection').append('<option value='+sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
            j++;
          }
        },
        error: function()
        {
          alert('internet issue');
        }
    });
  }
</script>



@endsection