@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $classes = \App\Models\addClass::where('CampusID', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
    ?>

    <form id="ReportForm" action="#" method="POST">
      @csrf
      <div class="row  pt-1 pb-1">
        {{-- <div class="col-md-2">
          <p></p>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
            <label class="form-check-label" for="inlineRadio1">All Students</label>
          </div>
          <br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
            <label class="form-check-label" for="inlineRadio2">Classwise</label>
          </div>
        </div> --}}

        <div class="col-md-3">
          <label for="Role" class="form-label"><b>Class</b></label>
          <select name="formClass" class="form-control form-control-sm" onchange="FetchSections(this.value)" required
            name="IsActive" id="formClass">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
            <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="Role" class="form-label"><b>Section</b></label>
          <select name="formSection" onchange="ClassSectionWiseStudents(this.value)"
            class="form-control form-control-sm" id="formSection">

          </select>
        </div>
        <div class="col-md-2 d-none">
          <label for="stdid">Student Id</label>
          <input type="text" class="form-control form-control-sm" id="stdid" name="stdid" placeholder="">
        </div>
        <div class="col-md-1 d-none">
          <label for="">&nbsp;</label>
          <input name="submit" id="insertRole" onclick="LoadSingleStudent(event)" class="btn btn-sm btn-primary btn-block"
            type="submit" value="Search">
        </div>
      </div>
      <hr>
      <h4>Fee defaulter(s)</h4>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label for="datefrom" class="col-sm-2 col-form-label">From date</label>
            <div class="col-sm-4">
              <input type="date" value="<?php echo date('Y-m-d'); ?>" required class="form-control form-control-sm" name="datefrom" id="datefrom"
                placeholder="">
            </div>
            <label for="dateto" class="col-sm-2 col-form-label">To date</label>
            <div class="col-sm-4">
              <input type="date" class="form-control form-control-sm" required id="dateto" name="dateto" placeholder="">
            </div>
          </div>
        </div>
      </div>

      <div class="row d-none">
        <div class="col-md-6">
          <div class="form-group row">
            <label for="paidbefore" class="col-sm-2 col-form-label">Paid Before</label>
            <div class="col-sm-4">
              <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="paidbefore"
                placeholder="">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-2">
    <button class="btn btn-sm btn-primary btn-block" onclick="LoadModal()">Format
      1</button>
  </div>
  {{-- <div class="col-md-2">
    <button formtarget='_blank' formaction="/admin/classWiseContact" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Format 2 With Dates</button>
  </div> --}}
  <div class="col-md-2">
    <button formtarget='_blank' formaction="/admin/StruckOffRemainder" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Struck Off</button>
  </div>
  {{-- <div class="col-md-2">
    <button formtarget='_blank' formaction="/admin/classWiseContact" type="submit" form="ReportForm"
      class="btn btn-sm btn-primary btn-block">Struck Off Format 2</button>
  </div> --}}
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table class="table" id="allStudents" style="width: 100% !important">
      <thead>
        <tr>
          <th>S.No#</th>
          <th>Check</th>
          <th>StudentID</th>
          <th>Std Name</th>
          <th>SMS No</th>
          <th>Class + Section</th>
        </tr>
      </thead>
      <tbody id="tablebody" style="width: 100%">

      </tbody>
    </table>
  </div>
</div>
<br>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/smsremainderwhole" method="POST" id="modalForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reminder Printing</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body d-none">
          <div class="row">
            <div class="col-md-6">
              <div class="form-check form-check-inline">
                <label class="form-check-label" for="displayAmount">Is Display Amount </label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input class="form-check-input" type="checkbox" id="displayAmount" name="displayAmount">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check form-check-inline">
                <label class="form-check-label" for="lastWarning">Last Warning </label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input class="form-check-input" type="checkbox" id="lastWarning" name="lastWarning">
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
              <div class="form-check form-check-inline">
                <label class="form-check-label" for="monthRestriction">Month restriction </label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input class="form-check-input" onchange="EnableDisablednoOfMonths()" type="checkbox"
                  id="monthRestriction" name="monthRestriction">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <input type="number" id="numberOfMonths" name="numberOfMonths" disabled
                  class="form-control form-control-sm">
              </div>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-md-12">
              <div class="form-group">
                <label for="message">Type format for notification <a href="#"><span
                      class="text-danger monthsLocation">&#60;Insert
                      month's
                      location&#62;</span></a></label>
                <textarea class="form-control" id="message" required name="message"
                  rows="4">You have not paid your child fee for $$$ months(s). Therefore, you are requested to deposit the outstanding fee etc. for the said period at your earliest.</textarea>
              </div>
            </div>
          </div>
          <div class="row d-none">
            <input type="date" name="DateFrom" class="" id="DateFrom" placeholder="">
            <input type="date" class="" name="DateTo" id="DateTo" placeholder="">
            <input type="text" class="" name="classIdd" id="classIdd" placeholder="">
            <input type="text" class="" name="sectionIdd" id="sectionIdd" placeholder="">
            {{-- <input type="date" class="" name="DateTo" id="DateTo" placeholder=""> --}}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" formtarget="_blank" class="btn btn-primary">Print
            Remainder</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
  function LoadModal(){
    $('#dateto').val() ? $('#exampleModal').modal('show') : swal('Warning', 'Select to date please.', 'warning');

    $("#DateTo").val($("#dateto").val());
    $("#DateFrom").val($("#datefrom").val());
    $("#classIdd").val($("#formClass").val());
    $("#sectionIdd").val($("#formSection").val());
  }
  $(".monthsLocation").click(function(){
    $("#message").val($("#message").val() + " " + "$$$ ");
  })
  function LoadSingleStudent(e){
    if(!$("#stdid").val()){
      swal('Warning', "Select id please", 'warning');
      return;
    }
    e.preventDefault();
    
  }

  function EnableDisablednoOfMonths(){
    if($('#numberOfMonths').attr('disabled'))
    $('#numberOfMonths').prop('disabled', false)
    else{
      $('#numberOfMonths').prop('disabled', true)
      $('#numberOfMonths').val(0)
    }
    
  }



  $(document).ready(function () {
    const monthControl = document.querySelector('input[type="month"]');
    const date= new Date()
    const month=("0" + (date.getMonth() + 1)).slice(-2)
    const year=date.getFullYear()
    monthControl.value = `${year}-${month}`;

    $("#allStudents").DataTable();
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

    // fetch classwise details
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        dataType: "json",
        url: "{{ route('admin.FetchStudentsForRemainder') }}",
        method: 'post',
        data: { classId: e },
        success: function(d) {
          data = d;
          students = JSON.parse(d);
          $("#allStudents").DataTable().destroy();
          $("#tablebody").empty();
          var j = 1;
          for (i = 0; i < students.length; i++) {
            $('#tablebody').append('<tr onclick=CheckPaymentStatus(\'' + students[i].studentid + '\')>' +
              '<td>' + j + '</td>' +
              '<td>' + '<input type="checkbox" checked value="' + students[i].studentid + '" name="students[]">' + '</td>' +
              '<td>' + students[i].studentid + '</td>' +
              '<td>' + students[i].studentname + '</td>' +
              '<td>' + students[i].fathercontact + '</td>' +
              '<td>' + students[i].classname + '  ' + students[i].sectionname + '</td></tr>');
            j++;
          }
          $("#allStudents").DataTable();
        },
        error: function() {
        }
      });
  }

  function ClassSectionWiseStudents(Section){
      $("#All").val('');
      var classid = $('#formClass').val();
      $("#searchStudent1").val('');
  
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
      });

      $.ajax({
        dataType: "json",
        url: "{{ route('admin.FetchStudentsForRemainderClassAndSection') }}",
        method: 'post',
        data: { sectionid :Section,classid:classid},
        success: function(d) {
        data = d;
        students = JSON.parse(d);
        $("#allStudents").DataTable().destroy();
        // $("#allStudents").DataTable().destroy();
        $("#tablebody").empty();
        var j = 1;
        for (i = 0; i < students.length; i++) {
          $('#tablebody').append('<tr onclick=CheckPaymentStatus(\'' + students[i].studentid + '\')>' +
            '<td>' + j + '</td>' +
            '<td>' + '<input type="checkbox" checked value="' + students[i].studentid + '" name="students[]">' + '</td>' +
            '<td>' + students[i].studentid + '</td>' +
            '<td>' + students[i].studentname + '</td>' +
            '<td>' + students[i].fathercontact + '</td>' +
            '<td>' + students[i].classname + '  ' + students[i].sectionname + '</td></tr>');
          j++;
        }
        $("#allStudents").DataTable();
      },
        error: function() {
        }
      });
    
  }
</script>



@endsection