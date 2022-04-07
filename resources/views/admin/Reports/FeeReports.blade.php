@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $classes = \App\Models\addClass::where('CampusID', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
    ?>

    <form id="ReportForm" action="/admin" method="POST">
      @csrf
      <div class="row  pt-1 pb-1">
        <div class="col-md-4">
          <label for="Role" class="form-label"><b>Class</b></label>
          <select name="class" class="form-control form-control-sm" onchange="FetchSections(this.value)" required
            name="IsActive" id="formClass">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
            <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label for="Role" class="form-label"><b>Section</b></label>
          <select name="section" class="form-control form-control-sm" id="formSection" required>

          </select>
        </div>
        <div class="col-md-4 d-none">
          <label for="IsActive" class="form-label"><b>Session</b></label>
          <select class="form-control form-control-sm" id="IsActive" required name="IsActive" placeholder="">
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>
      </div>

      <div class="row  pt-1 pb-1">
        <div class="col-md-4">
          <label for="FromDate" class="form-label"><b>From Date</b></label>
          <input type="date" value="<?php echo date('Y-m-d'); ?>" name="fromdate" id="fromdate"
            class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
          <label for="ToDate" class="form-label"><b>To Date</b></label>
          <input type="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" name="todate"
            id="todate">
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
      Full Outstanding Report</button>

    <button formtarget='_blank' formaction="{{ route('admin.OutstandingPaid') }}"
      onclick="DisableFormBothAttribute(event)" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Paid Fee Statement</button>

    <button formtarget='_blank' formaction="{{ route('admin.ClassWiseOutstanding') }}"
      onclick="DisableFormSectionAttribute(event)" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Class Wise Outstanding</button>

    <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Class & Section Wise Outstanding</button>

    {{-- <button formtarget='_blank' formaction="/admin/ClassWiseList" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block " onclick="DisableFormSectionAttribute(event)">Class Wise List</button>

    <button formtarget='_blank' formaction="/admin/ClassWiseStrength" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">Class Wise Strength</button>
    --}}
    {{-- <a class="btn btn-sm btn-primary btn-block">Bus Strength</a> --}}
    <button formtarget='_blank' formaction="/admin/HeadWiseFeeReports" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">Head Wise Reports</button>
  </div>
  <div class="col-md-3">
    {{-- <select class="form-control form-control-sm mb-2" id="IsActive" required name="IsActive" placeholder="">
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select> --}}
    {{-- <a class="btn btn-sm btn-primary btn-block">Character Certificate</a>
    <a class="btn btn-sm btn-primary btn-block">Provisional Certificate</a>
    <a class="btn btn-sm btn-primary btn-block">Section Wise List 2</a>
    <a class="btn btn-sm btn-primary btn-block">Class Wise Strength</a>
    <a class="btn btn-sm btn-primary btn-block">Bus Strength</a> --}}

    {{-- <fieldset>
      <legend>Cards:</legend>
      <div class="form-check ml-2">
        <input class="form-check-input" type="checkbox" value="" id="transport">
        <label class="form-check-label" for="transport">
          With Transport
        </label>
      </div>
      <div class="form-check ml-2 mb-2">
        <input class="form-check-input" type="checkbox" value="" id="picture">
        <label class="form-check-label" for="picture">
          With Picture
        </label>
      </div>
      <a class="btn btn-sm btn-primary btn-block">All Students Card</a>
      <a class="btn btn-sm btn-primary btn-block">Single Student Card</a>
    </fieldset> --}}
  </div>


  {{-- <div class="col-md-3">
    <fieldset>
      <legend>Attendense:</legend>
      <div class="form-group">
        <label for="exampleInputPassword1">Month</label>
        <input type="month" form="ReportForm" onchange="alert(this.value)" class="form-control form-control-sm"
          name="attendancemonth">
      </div>
      <button formtarget='_blank' formaction="/admin/AttendenceRegister" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Attendence Register</button>
      <button formtarget='_blank' formaction="/admin/AllAttendenceRegister" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block" onclick="DisableFormSectionAttribute(event)">All Attendence
        Register</button>
      <a class="btn btn-sm btn-primary btn-block">All Attendence Register</a>
      <a class="btn btn-sm btn-primary btn-block">Student Attendence Report</a>
      <div class="form-group row pt-2">
        <label for="inputPassword" class="col-sm-2 col-form-label">From</label>
        <div class="col-sm-10">
          <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm"
            id="inputPassword" placeholder="Password">
        </div>
      </div>
      <div class="form-group row ">
        <label for="inputPassword" class="col-sm-2 col-form-label">To</label>
        <div class="col-sm-10">
          <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm"
            id="inputPassword" placeholder="Password">
        </div>
      </div>
      <a class="btn btn-sm btn-primary btn-block">Class/Section Wise Attendence</a>
      <a class="btn btn-sm btn-primary btn-block">Consession List</a>
      <a class="btn btn-sm btn-primary btn-block">Class Wise with Address</a>
      <a class="btn btn-sm btn-primary btn-block">All Student's Tag</a>
      <a class="btn btn-sm btn-primary btn-block">Class Wise List Blank Contact</a>
    </fieldset>
  </div> --}}

  {{-- <div class="col-md-3">
    <fieldset>
      <legend>Cards:</legend>
      <a class="btn btn-sm btn-primary btn-block">All Students Card</a>
      <a class="btn btn-sm btn-primary btn-block">Single Student Card</a>
    </fieldset>
  </div> --}}
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