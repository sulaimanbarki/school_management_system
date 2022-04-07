@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Registration</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <form id="RegistraionForm" onsubmit="return false">
              <div class="row align-items-center ">
                <div class="col-md-4 d-none">
                  <label for="id"><b>ID</b></label>
                  <input type="text" value="" class="form-control form-control-sm" id="regid" name="id" placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="formid"><b>Form Number</b></label>
                  <input type="number" class="form-control form-control-sm" id="formid" required name="formid"
                    placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="studentname"><b>Student Name</b></label>
                  <input type="text" class="form-control form-control-sm" id="studentname" required name="studentname"
                    placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="fname"><b>Father Name</b></label>
                  <input type="text" id="fname" class="form-control form-control-sm" name="fname" required>
                </div>
              </div>

              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="contact"><b>Contact</b></label>
                    <input type="tel" class="form-control form-control-sm" id="contact" required name="contact"
                      placeholder="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="date"><b>Date</b></label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control form-control-sm" id="date"
                      required name="date" placeholder="">
                  </div>
                </div>
                <div class="col-md-4">
                  <?php
                          $campusid = Auth::user()->campusid;
                    $sessions = \App\Models\academicsessions::where('CampusID', '=',$campusid)->where('IsActive', '=', 1)->get();
                  ?>
                  <div class="form-group">
                    <label for="academicsession"><b> Academic Session</b></label>
                    <select class="form-control form-control-sm" id="academicsession" required name="academicsession"
                      placeholder="">
                      <option value="">Choose Session</option>
                      @foreach ($sessions as $session)
                      <option {{ $session->IsCurrent ? "selected" : "" }} value="{{ $session->id }}">{{
                        $session->Session }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="row align-items-center">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label" for="admissioninclass"><b>Admission in Class</b></label>
                    <select name="admissioninclass" class="form-control form-control-sm admissioninclasss"
                      id="admissioninclasss">
                    </select>
                  </div>
                </div>
              </div>

              <div class="row align-items-center  pt-3">
                <div class="col-md-12">
                  <input name="RegisterStudent" id="RegisterStudent" class="btn btn-primary btn-block" type="submit"
                    value="Register">
                </div>
                <div class="col-md-12">
                  <input name="RegisterStudentUpdate" id="RegisterStudentUpdate" class="btn btn-success btn-block"
                    type="submit" value="Update">
                  <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                </div>
              </div>
            </form>
          </div>
        </div>
        <hr>
        <table id="example" class="table table-responsive-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Form</th>
              <th>Name</th>
              <th>F Name</th>
              <th>Contact</th>
              <th class="select-filter">Admission Class</th>
              <th>Date</th>
              <th class="select-filter">Session</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="RegistrationData">
          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
  function ResetFormByCancelKey(){
    $("#RegisterStudentUpdate").hide();
    $("#RegisterStudent").show();
    $('#RegistraionForm').trigger("reset");
    $('#RegisterStudent').prop('type', 'submit');
    $('#cancelbtn').hide();
  }

  $(document).ready(function(){
    FetchClasses();
    LoadCompany();
  })


  $("#RegisterStudentUpdate").hide();

  // loads tables data from database
  function LoadCompany() {
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewRegistrationConfigration') }}",
      success: function(EmpData) {
        dataa = JSON.parse(EmpData);
        $("#example").DataTable().destroy();
        $("#RegistrationData").empty();
        var j = 1;
        for (i = 0; i < dataa.length; ++i) {
          $('#RegistrationData').append('<tr  ondblclick="EditRegistration(' + dataa[i].regid + ','+ i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + dataa[i].formid + '</td>' +
            '<td>' + dataa[i].studentname + '</td>' +
            '<td>' + dataa[i].fname + '</td>' +
            '<td>' + dataa[i].contact + '</td>' +
            '<td>' + dataa[i].ClassName + '</td>' +
            '<td>' + dataa[i].date + '</td>' +
            '<td>' + dataa[i].Session + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
        }
        $("#example").dataTable({
                initComplete: function () {
                    this.api().columns(".select-filter").every( function () {
                        var column = this;
                        var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
        
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' );
                        } );
                    } );
                }
            });
      },
      error: function() {
      }
    });
  }

// Edit registration function
  function EditRegistration(registrationid, i) {
    $('#RegisterStudent').hide();
    $('#RegisterStudent').prop('type', '');
    $('#RegisterStudentUpdate').show();
    $('#cancelbtn').show();
    $('#regid').val(registrationid);
    $('#formid').val(dataa[i].formid);
    $('#studentname').val(dataa[i].studentname);
    $('#fname').val(dataa[i].fname);
    $('#contact').val(dataa[i].contact);
    $('.admissioninclasss').val(dataa[i].admissioninclass);
    $('#date').val(dataa[i].date);
    $('#academicsession').val(dataa[i].academicsession);
  }

  // document.ready starts here
  $(document).ready(function(){
    $("#updateAdmission").hide();
    // $("#insertAdmission").hide();

    // update admision from
    $("#updateAdmission").click(function(){
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
          LoadCompany();
          swal("Good job!", "Updated successfully!", "success");
          $('#AdmissionForm').trigger("reset");
          setDate();
        },
        error: function(error) {
          console.log(error);
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
            $('#AdmissionForm').trigger("reset");
          }else{
            swal("Warning!", "Formid Already Exist!", "error");
          }
          setDate();
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
            $('#RegistraionForm').trigger("reset");
            LoadCompany();
            setDate();
          }else{
            swal("Error", "Form ID already used. Duplicate entry", "warning");
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


    // update registration form
    $("#RegisterStudentUpdate").click(function(){
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
      });
      $.ajax({
        url: "{{ route('admin.UpdateRegistrationConfigration') }}",
        data: $("#RegistraionForm").serialize(),
        dataType: "json",
        type: 'POST',
        success: function(result) {
          LoadCompany();
          swal("Success!", "Registration successfully updated!", "success");
          $("#RegisterStudentUpdate").hide();
          $("#RegisterStudent").show();
          $('#RegistraionForm').trigger("reset");
          $('#RegisterStudent').prop('type', 'submit');
          $('#cancelbtn').hide();
          setDate();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
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
      $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.ViewSessionConfigration') }}",
        success: function(SessionData)
        {
        sessionData=JSON.parse(SessionData);
        $("#session").empty();
        var j=1;
        $('#session').append("<option value=''>Select Sessions</option>");
        for (i=0; i < sessionData.length; ++i) {
          $('#session').append('<option value='+sessionData[i].id+'>'+ sessionData[i].Session +'</option>');
          j++;
        }
        },
        error: function()
        {
          alert('internet issue');
        }
      });
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
          $('#section').append("<option value=''>Select Sessions</option>");
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
</script>

@endsection