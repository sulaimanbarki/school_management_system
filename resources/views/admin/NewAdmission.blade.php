@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary collapsed-card colapse">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Student Bio Data</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body collapse in colapse-body">
        <div class="container-fluid">
          {{-- <form action="#">
            <div class="row bg-primary align-items-center pt-3 pb-3">
              <div class="col-md-1">
              </div>
              <div class="col-md-2">
                <div class="btn btn-sm btn-block btn-success"><i class="bi bi-plus"></i> Add New</div>
              </div>
              <div class="col-md-2">
                <div class="btn btn-sm btn-block btn-success"><i class="bi bi-printer"></i> Print Form</div>
              </div>
              <div class="col-md-2">
                <label class="form-check-label" for="searchadmission">
                  Admission no
                </label>
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" id="searchadmission">
              </div>
              <div class="col-md-1">
                <input type="submit" class="btn btn-sm btn-info btn-block" value="Search">
              </div>
            </div>
          </form> --}}
          <form onsubmit="return false" id="AdmissionForm">
            <div class="row align-items-center">
              <div class="col-md-3 d-none">
                <label for="admissionid"><b>ID</b></label>
                <input type="number" class="form-control form-control-sm" id="admissionid" name="admissionid"
                  placeholder="">
              </div>
              <div class="col-md-3">
                <label for="formidd"><b>Form Number</b></label>
                <input type="number" class="form-control form-control-sm formidd" id="formidd"
                  onchange="loadForm($(this).val())" required name="formid" placeholder="">
                <div id="validationServer03Feedback" class="text-danger d-none">
                  Form is invalid or already used.
                </div>
              </div>
              <div class="col-md-3">
                <label for="admissionnumber"><b>Admission No</b></label>
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <?php
                        $campusid = Auth::user()->campusid;
                      $prefix = \App\Models\addCampus::where('campusid', '=',$campusid)->first();
                      $asessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsActive', 1)->get();
                      $buses = \App\Models\Buses::where('campusid', Auth::user()->campusid)->where('busisdisplay', 1)->get();
                    if(empty($prefix)){
                      echo "<script>alert('campus Not found contact to your administation')</script>";
                    }else{

                    ?>
                    <div class="input-group input-group-text" id="prefix">{{ $prefix->CampusPrefix }}
                    </div>
                    <?php  } ?>

                  </div>
                  <input type="number" class="form-control form-control-sm" readonly id="admissionnumber"
                    name="admissionnumber" placeholder="">
                </div>
              </div>

              <div class="col-md-3">
                <label for="admissiondate"><b>Admission Date</b></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm"
                  id="admissiondate" required name="admissiondate" placeholder="">
              </div>
              <div class="col-md-3">
                <label for="session"><b>Session</b></label>
                <select id="session" class="form-control form-control-sm" name="session" required>
                  <option value="">Select Session</option>
                  @foreach ($asessions as $asession)
                  <option {{ $asession->IsCurrent ? "selected" : ""}} value="{{ $asession->id }}">{{ $asession->Session }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row align-items-center ">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="studentnamee"><b>Student Name</b></label>
                  <input type="text" class="form-control form-control-sm" id="studentnamee" required name="studentnamee"
                    placeholder="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="profilepicture" class="form-label"><b>Profile Picture</b></label>
                  <input type="file" class="form-control-sm form-control-file" id="profilepicture" required
                    name="profilepicture" placeholder="">
                </div>
              </div>
            </div>

            <div class="row align-items-center ">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="gender"><b>Gender</b></label>
                  <select name="gender" class="form-control form-control-sm" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Transgender">Transgender</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="status" class="form-label"><b>Status</b></label>
                  <select name="status" class="form-control form-control-sm" id="status">
                    <option value="Active">Active</option>
                    <option value="stuckoff_absences">Struck Due Long Absences</option>
                    <option value="stuckoff_feeDefluter">Struck Due Fee</option>
                    <option value="Matriculate">Matriculate</option>
                    <option value="Slc">SLC Issue</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="dob"><b>Date of birth</b></label>
                  <input type="date" name="dob" class="form-control form-control-sm" id="dob">
                </div>
              </div>
            </div>

            <div class="row align-items-center ">
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label" for="transport"><b>Transport</b></label>
                  <select name="transport" class="form-control form-control-sm"
                    onchange="EnableDisableTransportType(this.selectedIndex)" name="transport" id="transport">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label" for="transporttype"><b>Bus number</b></label>
                  <select name="transporttype" disabled class="form-control form-control-sm" id="transporttype">
                    <option value=''>Select Bus</option>
                    @foreach ($buses as $bus)
                    <option value="{{ $bus->busnumber }}">{{ $bus->busnumber }} - {{$bus->route }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="admissioninclass"><b>Admission in class</b></label>
                  <select name="admissioninclass" id="admissioninclass"
                    onchange="fetchSectionForClass(this, this.selectedIndex)" required
                    class="form-control form-control-sm">

                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="section"><b>Section</b></label>
                  <select name="section" disabled required class="form-control form-control-sm" id="section">

                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="address1"><b>Current Address</b></label>
                  <textarea class="form-control form-control-sm" id="address1" rows="" name="address1"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="address2"><b>Permanent Address</b></label>
                  <textarea class="form-control form-control-sm" id="address2" rows="" name="address2"></textarea>
                </div>
              </div>
            </div>

            <div class="row  " style="background-color: #F4F6F9;">
              <div class="col-md-4">
                <h4><b>Parents Information</b></h4>
              </div>
            </div>

            <div class="row align-items-center  " style="background-color: #F4F6F9;">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="fathername"><b>Name</b></label>
                  <input type="text" required class="form-control form-control-sm" id="fathername" name="fathername">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="cnic"><b>CNIC</b></label>
                  <input type="text" class="form-control form-control-sm" id="cnic" name="cnic">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="cnic"><b>Student Form-B</b></label>
                  <input type="text" class="form-control form-control-sm" id="formb" name="formb">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="occupation"><b>Occupation</b></label>
                  <input type="text" class="form-control form-control-sm" id="occupation" name="occupation">
                </div>
              </div>
            </div>

            <div class="row align-items-center " style="background-color: #F4F6F9;">
              <div class="col-md-2">
              </div>
            </div>
            <div class="row " style="background-color: #F4F6F9;">
              <div class="col-md-4">
                {{-- <h4><b>Contact Information</b></h4> --}}
              </div>
            </div>

            <div class="row align-items-center" style="background-color: #F4F6F9;">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="fathercontact"><b>Father contact</b></label>
                  <input type="tel" required class="form-control form-control-sm" id="fathercontact"
                    name="fathercontact">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="contact1"><b>Contact 1 (Optional)</b></label>
                  <input type="tel" class="form-control form-control-sm" id="contact1" name="contact1">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="contactwhatsapp"><b>Whatsapp Contact</b></label>
                  <input type="tel" class="form-control form-control-sm" id="contactwhatsapp" name="contactwhatsapp">
                </div>
              </div>
            </div>

            <div class="row align-items-center  " style="background-color: #f0efed;">
              <div class="col-md-2 text-right">
              </div>
              <div class="col-md-2">
              </div>
            </div>

            <div class="row align-items-center ">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label" for="admissionremarks"><b>Admission remarks</b></label>
                  <textarea area class="form-control form-control-sm" id="admissionremarks" rows=""
                    name="admissionremarks"></textarea>
                </div>
              </div>
            </div>

            <div class="row align-items-center">
              <div class="col-md-12">
                <input name="insertAdmission" id="insertAdmission" class="btn btn-primary btn-block" type="submit"
                  value="Save">
                <input name="updateAdmission" id="updateAdmission" class="btn btn-success btn-block" type="submit"
                  value="Update">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">View Students</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="row">
          <div class="col-md-12" style="overflow-x:auto;overflow-y:auto;">
            <table id="example33" class="table table-hover">
              <thead>
                <tr>
                  <th>F#</th>
                  {{-- <th>Ad#</th> --}}
                  <th>Std. Id</th>
                  <th>Date</th>
                  <th>Session</th>
                  <th>Student Name</th>
                  <th>Father Name</th>
                  <th>Gender</th>
                  <th>Status</th>
                  {{-- <th>DOB</th> --}}
                  <th>Class</th>
                  <th>Section</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="AdmissionDataList">
              </tbody>
              <tfoot>
                <th></th>
                {{-- <th></th> --}}
                <th></th>
                <th></th>
                <th></th>
                <th class="th">Search by student name</th>
                <th class="th">Search by father name</th>
                <th></th>
                <th></th>
                <th></th>
                {{-- <th></th> --}}
                <th></th>
                <th></th>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  function ResetFormByCancelKey(){
    $("#updateAdmission").hide();
    $("#insertAdmission").show();
    $("#section").prop("disabled", true);
    $("#transporttype").prop("disabled", true);
    $('#insertAdmission').prop('type', 'submit');
    $('#cancelbtn').hide();
    $('#AdmissionForm').trigger("reset");
    FetchAdmissionNumber();
  }
  var admissionData = "";
  $(document).ready(function(){
    FetchClasses();
    LoadCompany();
    LoadStudentAdmissions();
  });
  function loadForm(formid) {
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.checkFormExists') }}",
      method: "POST",
      data: {formid: formid},
      success: function(result) {
        d = JSON.parse(result);
        if(d.id){
          $("#studentnamee").val(d.studentname);
          $("#fathername").val(d.fname);
          $(".formidd").removeClass('border, border-danger');
          $("#validationServer03Feedback").addClass('d-none');
          $("#insertAdmission").show();
        }else{
          $("#studentnamee").val("");
          $("#fathername").val("");
          $(".formidd").addClass('border, border-danger');
          $("#validationServer03Feedback").removeClass('d-none');
          $("#insertAdmission").hide();
        }
      },
      error: function(error) {
        console.log(error);
        $("#insertAdmission").hide();
      }
    });
  }
  
  $("#transporttype").prop("readonly", true);

// loads tables data from database
function LoadStudentAdmissions() {
  $.ajax({
    dataType: "json",
    url: "{{ route('admin.ViewAdmissionConfigration') }}",
    success: function(d) {
      admissionData = JSON.parse(d);
      // console.log(admissionData);
      $("#example33").DataTable().destroy();
      $("#AdmissionDataList").empty();
      var j = 1;
      for (i = 0; i < admissionData.length; ++i) {
        $('#AdmissionDataList').append('<tr ondblclick="EditAdmission(' + admissionData[i].stid + ','+ i + ')">' +
          '<td>' + admissionData[i].formid + '</td>' +
          // '<td>' + admissionData[i].registrationid + '</td>' +
          '<td>' + admissionData[i].studentid + '</td>' +
          '<td>' + admissionData[i].date + '</td>' +
          '<td>' + admissionData[i].Session + '</td>' +
          '<td>' + admissionData[i].studentname + '</td>' +
          '<td>' + admissionData[i].fathername + '</td>' +
          '<td>' + admissionData[i].gender + '</td>' +
          '<td>' + admissionData[i].status + '</td>' +
          // '<td>' + admissionData[i].dob + '</td>' +
          '<td>' + admissionData[i].ClassName + '</td>' +
          '<td>' + admissionData[i].SectionName + '</td>' +
          '<td> <a href="/admin/StudentProfile" style="color: #FFC107;" ><i onclick="SetStudentId(' + admissionData[i].registrationid + ')" class="fa fa-user" aria-hidden="true"></i></a> ' + 
            ' <a style="color: #08bf1a;" ondblclick="EditAdmission(' + admissionData[i].stid + ','+ i + ')" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
        j++;
      }
      $('#example33 tfoot .th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />' );
      });
      var table = $('#example33').DataTable({
        initComplete: function () {
          // Apply the search
          this.api().columns().every( function () {
              var that = this;

              $( 'input', this.footer() ).on( 'keyup change clear', function () {
                  if ( that.search() !== this.value ) {
                      that
                          .search( this.value )
                          .draw();
                  }
              } );
          } );
        }
      });
    },
    error: function() {
    }
  });
}

function SetStudentId(id){
  localStorage.setItem('studentid', id);
}

// get last admission number
function FetchAdmissionNumber(){
  $.ajax({
    dataType: "json",
    type: 'GET',
    url: "{{ route('admin.FetchAdmissionNumberConfigration') }}",
    success: function(adnumber)
    {
      $("#admissionnumber").val(adnumber);
    },
    error: function()
    {
      alert('internet issue');
    }
  });
}
// enable or disable transport type
  function EnableDisableTransportType(e){
    if(e == 0){
      $("#transporttype").prop("disabled", true);
      $("#transporttype").prop("required", true);
      document.getElementById("transporttype").selectedIndex = 0;
    }else{
      $("#transporttype").prop("disabled", false);
      $("#transporttype").prop("required", false);
    }
  }
  // fetchSectionForClass
  function fetchSectionForClass(e, vall){
    // console.log(vall);
    if(vall == 0){
      $("#section").prop("disabled", true);
      document.getElementById("section").selectedIndex = 0;
    }else{
      $("#section").prop("disabled", false);
    }

    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchSectionForClassConfigration') }}",
        data: {classId: e.value},
        success: function(SessionData)
        {
          sessionData=JSON.parse(SessionData);
          $("#section").empty();
          var j=1;
          $('#section').append("<option value=''>Select section</option>");
          for (i=0; i < sessionData.length; ++i) {
            $('#section').append('<option value='+sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
            j++;
          }
          // $("#section").prop('disabled', false);
        },
        error: function()
        {
          alert('internet issue');
        }
      });
  }
  // loads tables data from database
  function LoadCompany() {
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewRegistrationConfigration') }}",
      success: function(EmpData) {
        dataa = JSON.parse(EmpData);
        $("#RegistrationData").empty();
        var j = 1;
        for (i = 0; i < dataa.length; ++i) {
          $('#RegistrationData').append('<tr  onclick="EditRegistration(' + dataa[i].regid + ','+ i + ')">' +
            '<td>' + dataa[i].formid + '</td>' +
            '<td>' + dataa[i].studentname + '</td>' +
            '<td>' + dataa[i].fname + '</td>' +
            '<td>' + dataa[i].contact + '</td>' +
            '<td>' + dataa[i].ClassName + '</td>' +
            '<td>' + dataa[i].date + '</td>' +
            '<td>' + dataa[i].Session + '</td>' +
            '<td><a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
        }
        $("#example3").dataTable();
      },
      error: function() {
      }
    });
  }

// Edit admission function
  function EditAdmission(admissionid, i) {
    $("#section").prop("disabled", false);
    $('#insertAdmission').hide();
    $('#insertAdmission').prop('type', '');
    $('#formidd').prop('disabled', true);
    $('#updateAdmission').show();
    $('#cancelbtn').show();
    $('#admissionid').val(admissionid);
    // $('#formidd').val(admissionData[i].formid);
    $('#admissionnumber').val(admissionData[i].registrationid);
    $('#admissiondate').val(admissionData[i].date);
    $('#session').val(admissionData[i].session);
    $('#studentnamee').val(admissionData[i].studentname);
    // $('#profilepicture').val(admissionData[i].picturepath);
    $('#gender').val(admissionData[i].gender);
    $('#status').val(admissionData[i].status);
    $('#dob').val(admissionData[i].dob);
    $('#transport').val(admissionData[i].transportstatus);
    admissionData[i].transportstatus == "Yes" ? $('#transporttype').attr("disabled", false) : $('#transporttype').attr("disabled", true)
    $('#transporttype').val(admissionData[i].busnumber);
    $('#admissioninclass').val(admissionData[i].admissioninclass);
    $('#section').val(admissionData[i].admissioninsection);
    $('#section').attr("readonly", false);
    $('#address1').val(admissionData[i].address1);
    $('#address2').val(admissionData[i].address2);
    $('#fathername').val(admissionData[i].fathername);
    $('#cnic').val(admissionData[i].cnic);
    $('#formb').val(admissionData[i].formb);
    $('#occupation').val(admissionData[i].occupation);
    $('#fathercontact').val(admissionData[i].fathercontact);
    $('#contact1').val(admissionData[i].contact1);
    $('#contactwhatsapp').val(admissionData[i].contactwhatsapp);
    $('#admissionremarks').val(admissionData[i].admissionremarks);
  }

  // document.ready starts here
  $(document).ready(function(){
    FetchBuses();
    $("#updateAdmission").hide();
    // $("#insertAdmission").hide();
    FetchAdmissionNumber();

    function DisableFormImgAttribute(){
      $("#profilepicture").removeAttr('required');
      setTimeout(() => {
        $("#profilepicture").attr('required', 'required');
      }, 1000);
    }


    // update admision from
    $("#updateAdmission").click(function(){
      DisableFormImgAttribute();
      var formData = new FormData(document.getElementById("AdmissionForm"));
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
      });
      $.ajax({
        url: "{{ route('admin.UpdateAdmissionConfigration') }}",
        dataType: "json",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(result) {
          // enable input type text jquery
          $('#formidd').prop('disabled', false);
          FetchAdmissionNumber();
          $("#updateAdmission").hide();
          $("#insertAdmission").show();
          $("#section").prop("disabled", true);
          $('#insertAdmission').prop('type', 'submit');
          $('#cancelbtn').hide();
          LoadCompany();
          swal("Good job!", "Updated successfully!", "success");
          $('#AdmissionForm').trigger("reset");
          $("#transporttype").prop("disabled", true);
          $("#transporttype").prop("required", true);
          LoadStudentAdmissions();
        },
        error: function(error) {
          // console.log(error);
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


    // insert admision from
    $("#insertAdmission").click(function(){
      var formData = new FormData(document.getElementById("AdmissionForm"));
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
      });
      $.ajax({
        url: "{{ route('admin.AddAdmissionConfigration') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(result) {
          if(result == 'success'){
            swal("Good job!", "Admited successfully!", "success");
            LoadStudentAdmissions();
            $('#AdmissionForm').trigger("reset");
          }else{
            swal("Warning!", "Formid Already Exist!", "error");
          }
          FetchAdmissionNumber();
          LoadCompany();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });
    // insert registration form
    $("#RegisterStudent").click(function(){
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
      });
      $.ajax({
        url: "{{ route('admin.AddRegistrationConfigration') }}",
        data: $("#RegistraionForm").serialize(),
        type: 'POST',
        success: function(result) {
          if(result == 'success'){
            swal("Good job!", "Registered successfully!", "success");
            LoadCompany();
            $('#RegistraionForm').trigger("reset");
          }else{
            swal("Error", "Duplicate Entry", "warning");
          }
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    })
  });
  // document.ready ends here
  ViewSession();
  FetchClasses();
  function ViewSession() {
      // $.ajax({
      //   dataType: "json",
      //   type: 'GET',
      //   url: "{{ route('admin.ViewSessionConfigration') }}",
      //   success: function(SessionData)
      //   {
      //   sessionData=JSON.parse(SessionData);
      //   $("#session").empty();
      //   var j=1;
      //   $('#session').append("<option value=''>Select Sessions</option>");
      //   for (i=0; i < sessionData.length; ++i) {
      //     $('#session').append('<option value='+sessionData[i].id+'>'+ sessionData[i].Session +'</option>');
      //     j++;
      //   }
      //   },
      //   error: function()
      //   {
      //     alert('internet issue');
      //   }
      // });
  }  
  // fetch sections
  ViewSection();
  function ViewSection() {
      $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.ViewSectionConfigration') }}",
        success: function(SectionData)
        {
          sectionData=JSON.parse(SectionData);
          $("#section").empty();
          var j=1;
          $('#section').append("<option value=''>Select Section</option>");
          for (i=0; i < sectionData.length; ++i) {
            $('#section').append('<option value='+sectionData[i].Sec_ID+'>'+ sectionData[i].SectionName +'</option>');
            j++;
          }
        },
        error: function()
        {
          alert('internet issue');
        }
      });
  }  

function FetchClasses(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: "{{ route('admin.ViewClasss') }}",
      success: function(ClassData){
        dataa=JSON.parse(ClassData);  
        $("#admissioninclasss").empty();
        $("#admissioninclass").empty();
        var j=1;
        $('#admissioninclasss').append("<option value=''>Select Class</option>");
        $('#admissioninclass').append("<option value=''>Select Class</option>");
        for (i=0; i < dataa.length; ++i) {
          $('#admissioninclasss').append('<option value='+dataa[i].C_id+'>'+ dataa[i].ClassName +'</option>');
          $('#admissioninclass').append('<option value='+dataa[i].C_id+'>'+ dataa[i].ClassName +'</option>');
          j++;
        }
      },
      error: function(){
        alert('Internet Issue');
      }
    });
  }
  // fetch buses
function FetchBuses(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    // $.ajax({
    //   dataType: "json",
    //   type: 'POST',
    //   url: "{{ route('admin.ViewBuses') }}",
    //   success: function(busData){
    //     busdata = JSON.parse(busData);  
    //     $("#transporttype").empty();
    //     var j=1;
    //     $('#transporttype').append("<option value=''>Select Class</option>");
    //     for (i=0; i < busdata.length; ++i) {
    //       $('#transporttype').append('<option value='+busdata[i].busnumber+'>'+ busdata[i].busnumber +'</option>');
    //       j++;
    //     }
    //   },
    //   error: function(){
    //     alert('Internet Issue');
    //   }
    // });
  }

  $(document).ready(function(){
    var studddd = "{{ empty($studid) ? '' : $studid }}";
    if(studddd != ""){
      $(".colapse").removeClass("collapsed-card");
      $(".colapse-body").css("display", "block");
      setTimeout(() => {
        for (i = 0; i < admissionData.length; ++i) {
          if(admissionData[i].studentid == studddd){
            EditAdmission(admissionData[i].stid,  i);
          }
        }
      }, 2000);
    }
  })



</script>

@endsection