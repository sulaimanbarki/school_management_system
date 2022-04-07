@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $classes = \App\Models\addClass::where('CampusID', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
      $asessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsActive', 1)->get();
    ?>
    {{-- {{ dd('')}} --}}
    <form id="ReportForm" action="/admin" method="POST">
      @csrf
      <div class="row  pt-1 pb-1">
        <div class="col-md-4">
          <label for="formClass" class="form-label"><b>Class</b></label>
          <select name="class" class="form-control form-control-sm" onchange="FetchSections(this.value)" required
            name="IsActive" id="formClass">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
            <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label for="formSection" class="form-label"><b>Section</b></label>
          <select name="section" class="form-control form-control-sm" id="formSection" required>
          </select>
        </div>
        <div class="col-md-4">
          <label for="sessionid" class="form-label"><b>Session</b></label>
          <select class="form-control form-control-sm" id="sessionid" required name="sessionid" placeholder="">
            <option value="">Select Class</option>
            @foreach ($asessions as $asession)
            <option {{ $asession->IsCurrent ? "selected" : "" }} value="{{ $asession->id }}">{{ $asession->Session }}
            </option>
            @endforeach
          </select>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="row mt-2 mb-2">
  <div class="col-md-12 pt-2 pb-2">
    <form onsubmit="return false" id="searchStudentForm">
      <div class="row">
        <div class="col-md-2">
          <label for="stdid">Search by Student Id</label>
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
        <div class="col-md-3">
          <input type="text" readonly class="form-control form-control-sm" id="stdname" name="stdname" placeholder="">
        </div>
        <div class="col-md-2">
          <input type="text" readonly class="form-control form-control-sm" id="fathername" name="fathername"
            placeholder="">
        </div>
        <div class="col-md-2">
          <input type="text" readonly class="form-control form-control-sm" id="inClass" placeholder="">
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <fieldset>
      <legend>Lists:</legend>
      <button formtarget='_blank' formaction="{{ route('admin.justClassWiseContact') }}"
        onclick="DisableFormSectionAttribute(event)" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Class Wise Contact Number</button>
      <button formtarget='_blank' formaction="/admin/classWiseContact" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Class & Section Wise Contact
        Numbers</button>
      <button formtarget='_blank' formaction="/admin/ClassWiseList" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block" onclick="DisableFormSectionAttribute(event)">Class Wise List</button>

      <button formtarget='_blank' formaction="/admin/classAndSectionWiseList" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Class & Section Wise List</button>

      <button formtarget='_blank' formaction="/admin/ClassWiseStrength" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">Class Wise Strength</button>

      {{-- <a class="btn btn-sm btn-primary btn-block">Bus Strength</a> --}}
      <hr>
      <button formtarget='_blank' formaction="/admin/PrintTimeTables" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Print Timetable</button>

    </fieldset>
  </div>
  <div class="col-md-3">
    <fieldset>
      <legend>Certificates:</legend>
      <select class="form-control form-control-sm mb-2" id="IsActive" required name="IsActive" placeholder="">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
      <a class="btn btn-sm btn-primary btn-block" onclick="SLCertificate()">School Leaving Certificate</a>
      <hr>
      <form action="/admin" method="POST" id="ReportForm1">
        @csrf
        <div class="form-group">
          <label for="session"><b>Session</b></label>
          <select id="session" class="form-control form-control-sm" name="session" required>
            <option value="">Select Session</option>
            @foreach ($asessions as $asession)
            <option selected value="{{ $asession->id }}">{{ $asession->Session }}</option>
            @endforeach
          </select>
        </div>
      </form>

      <button formtarget='_blank' formaction="/admin/MatriculatedStudents" type="submit" form="ReportForm1"
        class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">Matriculated
        Students</button>


      <button formtarget='_blank' formaction="/admin/SLCStudentsList" type="submit" form="ReportForm1"
        class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">SLC Students</button>
      {{-- <a class="btn btn-sm btn-primary btn-block">Character Certificate</a>
      <a class="btn btn-sm btn-primary btn-block">Provisional Certificate</a>
      <a class="btn btn-sm btn-primary btn-block">Section Wise List 2</a>
      <a class="btn btn-sm btn-primary btn-block">Class Wise Strength</a> --}}
      {{-- <a class="btn btn-sm btn-primary btn-block">Bus Strength</a> --}}
    </fieldset>

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


  <div class="col-md-3">
    <fieldset>
      <legend>Attendance:</legend>
      <div class="form-group">
        <label for="exampleInputPassword1">Month</label>
        <input type="month" form="ReportForm" class="form-control form-control-sm" name="attendancemonth">
      </div>
      <button formtarget='_blank' formaction="/admin/AttendenceRegister" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Attendance Register</button>
      <button formtarget='_blank' formaction="/admin/AllAttendenceRegister" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block" onclick="DisableFormSectionAttribute(event)">All Attendance
        Register</button>
      <hr>
      <div class="form-group">
        <label for="attendancedate">Date</label>
        <input type="date" form="ReportForm" value="{{date('Y-m-d')}}" form="ReportForm"
          class="form-control form-control-sm" id="attendancedate" name="attendancedate">
      </div>

      <button formtarget='_blank' formaction="/admin/StudentAttendanceReportDateWise" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Search Student Attendance Date Wise</button>

      <hr>
      <div class="form-group">
        <label for="fromdate">From Date</label>
        <input type="date" form="ReportForm" value="{{date('Y-m-d')}}" form="ReportForm"
          class="form-control form-control-sm" id="fromdate" name="fromdate">
      </div>
      <div class="form-group">
        <label for="todate">To Date</label>
        <input type="date" form="ReportForm" value="{{date('Y-m-d')}}" form="ReportForm"
          class="form-control form-control-sm" id="todate" name="todate">
      </div>

      <button formtarget='_blank' formaction="/admin/StudentAttendanceReportCount" type="submit" form="ReportForm"
        class="btn btn-sm btn-primary btn-block">Count Student Attendance</button>

    </fieldset>
  </div>

  <div class="col-md-3">
    <fieldset>
      <legend>Bus Register:</legend>
      <label for="busnumber" class="form-label"><b>Bus</b></label>
      <?php
        $buses = \App\Models\Buses::where('campusid', Auth::user()->campusid)->get();
      ?>
      <form id="busForm" action="/admin" method="POST">
        @csrf
        <select class="form-control form-control-sm mb-2" id="busnumber" form="ReportForm" name="busnumber"
          placeholder="">
          <option value="">Select bus</option>
          @foreach ($buses as $bus)
          <option value="{{ $bus->busnumber }}">{{ $bus->busnumber }}</option>
          @endforeach
        </select>
        <div class="form-group d-none">
          <label for="exampleInputPassword1">Month</label>
          <input type="month" value="<?=date('Y-m')?>" form="ReportForm" class="form-control form-control-sm"
            name="attendancemonthh">
        </div>
      </form>
      <button type="submit" form="ReportForm" onclick="DisableFormBothAttribute(event)" formtarget="_blank" formaction="{{ route('admin.SingleBusRegister') }}"
        class="btn btn-sm btn-primary btn-block">Single Bus Register</button>
      <button type="submit" form="ReportForm" onclick="DisableFormBothAttribute(event)" formtarget="_blank"
        formaction="/admin/AllBusRegister" class="btn btn-sm btn-primary btn-block">All Bus Register</button>
    </fieldset>
    {{-- <fieldset>
      <legend>Cards:</legend>
      <a class="btn btn-sm btn-primary btn-block">All Students Card</a>
      <a class="btn btn-sm btn-primary btn-block">Single Student Card</a>
    </fieldset> --}}
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">School Leaving Certificate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="slcModalForm">
          <div class="row p-2">
            <div class="col-md-6">
              <label for="section" class="form-label"><b>Student Name</b></label>
              <input type="text" readonly class="form-control form-control-sm d-none" id="student-id" name="student_id"
                required placeholder="">
              <input type="text" readonly class="form-control form-control-sm" id="student-Name" required
                placeholder="">
              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            </div>
            <div class="col-md-6">
              <label for="section" class="form-label"><b>Father Name</b></label>
              <input type="text" readonly class="form-control form-control-sm" id="student-Father" required
                placeholder="">
            </div>
          </div>
          <div class="row p-2">
            <div class="col-md-12">
              <label for="admisstion-class" class="form-label"><b>Class</b></label>
              <input type="hidden" class="form-control form-control-sm" readonly id="admisstion-class"
                name="admisstion_class" required placeholder="">
              <input type="text" class="form-control form-control-sm" readonly id="admisstion-class1"
                name="admisstion_class1" required placeholder="">
            </div>
            <div class="col-md-6">
              <label for="section" class="form-label"><b>Date</b></label>
              <input type="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" id=""
                required placeholder="">
            </div>
            <div class="col-md-6">
              <label for="section" class="form-label"><b>Admission Date</b></label>
              <input type="date-time" class="form-control form-control-sm" id="admissiondate" name="admissiondate"
                required placeholder="">
            </div>
            <div class="col-md-6">
              <label for="section" class="form-label"><b>TotalWorkingDay</b></label>
              <input type="number" class="form-control form-control-sm" id="tw" name="tw" required placeholder="">
            </div>
            <div class="col-md-6">
              <label for="section" class="form-label"><b>Parsent Days</b></label>
              <input type="number" class="form-control form-control-sm" id="pd" name="pd" required placeholder="">
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="section" class="form-label"><b>Reason For Leaving School</b></label>
                <textarea class="form-control" id="reason" name="reason" rows="2"></textarea>
              </div>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-md-6">
              <label for="Role" class="form-label"><b>Certificate Copy</b></label>
              <select class="form-control form-control-sm" required name="copy" id="formClass">
                <option value="">Select printing copy</option>
                <option value="Office">Office</option>
                <option value="Student">Student</option>
                <option value="File">File</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="Role" class="form-label"><b>Conduct</b></label>
              <select class="form-control form-control-sm" required name="Conduct" id="Conduct">

                <option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
                <option value="Fair">Fair</option>
                <option value="Poor">Poor</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="SaveSLC()">Save-SLC</button>
        <button formtarget='_blank' formaction="/admin/SLCStudents" type="submit" class="btn btn-primary"
          id="SLCprintButton" form="slcModalForm">Print</button>
      </div>
    </div>
  </div>
</div>


<script>
  function SaveSLC(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.SaveSchoolLeavingCertificate') }}",
      method: 'post',
      data: $("#slcModalForm").serialize(),
      success: function(d) {
        console.log(d);

          if(d==1){
            swal("Error!", "Kindly Change Student Status To SLC", "warning");
            return;
          }else if(d==2){
            swal("Error!", "Kindly Clear Student Dues", "warning");
            return;
          }else if(d==3){
            swal("Error!", "Kindly Cancel Student previous SLC", "warning");
            return;
          }

          $("#student-id").val(sessionData[0].studentid);
          $("#student-Name").val(sessionData[0].studentname);
          $("#student-Father").val(sessionData[0].fathername);
          $("#admisstion-class").val(sessionData[0].admissioninclass);

          $("#admissiondate").val(sessionData[0].admissiondate);
          $('#exampleModal').modal('show');
          // alert(sessionData[0].status);
          if(sessionData[0].status=="Slc")
          $("#SLCprintButton").removeAttr('disabled');
          else
          $("#SLCprintButton").attr('disabled', 'disabled');
          },error: function(e){
        console.log(e);
      }
    });
  }
  function SLCertificate(id){
    let stdid = $("#stdid").val();
    if(stdid === ""){
      alert("Select student please");
      return;
    }
    stdid = "{{ $campus->CampusPrefix }}" + stdid;
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.SchoolLeavingCertificate') }}",
      method: 'post',
      data: {stdid: stdid},
      success: function(d) {
        // det = JSON.parse(d);
        sessionData=JSON.parse(d);
        console.log(sessionData);
          if(sessionData.length < 1){
            swal("Error!", "This Student Is Still Active kindly Change His Status", "warning");
            return;
          }

          $("#student-id").val(sessionData[0].studentid);
          $("#student-Name").val(sessionData[0].studentname);
          $("#student-Father").val(sessionData[0].fathername);
          $("#admisstion-class").val(sessionData[0].admissioninclass);
          $("#admisstion-class1").val(sessionData[0].classname);
          $("#admissiondate").val(sessionData[0].admissiondate);
          $('#exampleModal').modal('show');
          // alert(sessionData[0].status);
          if(sessionData[0].status=="Slc")
          $("#SLCprintButton").removeAttr('disabled');
          else
          $("#SLCprintButton").attr('disabled', 'disabled');
          },error: function(e){
        console.log(e);
      }
    });
  }

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
        // url: "{{ route('admin.SchoolLeavingCertificate') }}",
        data: {studentid: prefix + e.target[0].value},
        success: function(SessionData){
          sessionData=JSON.parse(SessionData);
          if(sessionData.length < 1){
            $("#stdname").val("");
            $("#fathername").val("");
            swal("Error!", "No record found", "warning");
            return;
          }
          $("#stdname").val(sessionData[0].studentname);
          $("#fathername").val(sessionData[0].fathername);
          $("#inClass").val(sessionData[0].ClassName);

          // $("#student-Name").val(sessionData[0].studentname);
          // $("#student-Father").val(sessionData[0].fathername);
          // $("#admisstion-class").val(sessionData[0].classname);
          // $("#admissiondate").val(sessionData[0].admissiondate);
          // $('#exampleModal').modal('show');
          // if(sessionData[0].remaining > 0)
          //   $("#SLCprintButton").attr('disabled', 'disabled');
          // else
          //   $("#SLCprintButton").removeAttr('disabled');
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

  function DisableBusForm(){
    $("#busnumber").removeAttr('required');
    setTimeout(() => {
      $("#busnumber").attr('required', 'required');
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