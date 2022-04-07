@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Subject <Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body collapse in">

        <form class="form-check" id="RoleForm" onsubmit="return false" method="POST">
          <div class="row  pt-1 pb-1">
            <div class="col-md-4" style="display: none">
              <label for="id" class="form-label"><b>Subject Name</b></label>
              <input type="text" class="form-control form-control-sm" id="id" value="0" name="id" placeholder="">
            </div>
            <div class="col-md-4">
              <label for="name" class="form-label"><b>Subject Name</b></label>
              <input type="text" class="form-control form-control-sm" id="name" required name="name" placeholder="">
            </div>
            <div class="col-md-4">
              <label for="isdisplay" class="form-label"><b>Is Display</b></label>
              <select class="form-control form-control-sm" id="isdisplay" required name="isdisplay" placeholder="">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="sequence" class="form-label"><b>Sequence</b></label>
              <input type="number" min="1" max="20" class="form-control form-control-sm" id="sequence" required
                name="sequence" placeholder="">
            </div>
          </div>

          <div class="row align-items-center  pt-1 pb-1">
            <div class="col-md-12">
              <input name="submit" id="insertSubject" class="btn btn-sm btn-primary btn-block" type="submit"
                value="Save Subject">
            </div>
            <div class="col-md-12">
              <input type="submit" name="submit" id="updateRole" class="btn btn-sm btn-success btn-block"
                value="Update Subject">
              <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
            </div>
          </div>


        </form>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Subjects</h4>
            <table id="example3" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#id</th>
                  <th class="select-filter">Subject Name</th>
                  <th>Is Display</th>
                  <th>Sequence</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="RoleData">
              </tbody>
              <tfoot>
                <tr>
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
  </div>

</div>


<div class="row">
  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Assign Subjects to Class<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body collapse in">

        <form class="form-check" id="ClassWiseSubjectForm" onsubmit="return false" method="POST">
          <div class="row  pt-1 pb-1">
            <div class="col-md-6 d-none">
              <label for="CWid" class="form-label"><b>Id</b></label>
              <input type="number" class="form-control form-control-sm" id="CWid" value="" required name="CWid"
                placeholder="">
            </div>
            <div class="col-md-6">
              <?php
                  $classes = \App\Models\addClass::where('Campusid', Auth::user()->campusid)->where("Isdisplay", 1)->get();
                ?>
              <label for="classid" class="form-label"><b>Class Name</b></label>
              <select class="form-control form-control-sm" id="classid" required name="classid" placeholder="">
                <option value="">Select</option>
                @foreach ($classes as $class)
                <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="subjectid" class="form-label"><b>Subject Name</b></label>
              <select class="form-control form-control-sm" id="subjectid" required name="subjectid" placeholder="">

              </select>
            </div>
          </div>

          <div class="row  pt-1 pb-1">
            <div class="col-md-2">
              <label for="transcriptsequence" class="form-label"><b>Sequence</b></label>
              <input type="number" min="1" max="20" class="form-control form-control-sm" id="transcriptsequence"
                required name="transcriptsequence">
            </div>
            <div class="col-md-2">
              <label for="issdisplay" class="form-label"><b>Is Display</b></label>
              <select class="form-control form-control-sm" id="issdisplay" required name="issdisplay">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-2">
              <label for="theorymarks" class="form-label"><b>Theory Marks</b></label>
              <input type="number" class="form-control form-control-sm" id="theorymarks" required name="theorymarks">
            </div>
            <div class="col-md-2">
              <label for="obtainmarks" class="form-label"><b>Practical Marks</b></label>
              <input type="number" class="form-control form-control-sm" id="obtainmarks" required name="obtainmarks">
            </div>
            <div class="col-md-2">
              <label for="passingmarks" class="form-label"><b>Passing Marks</b></label>
              <input type="number" class="form-control form-control-sm" id="passingmarks" required name="passingmarks">
            </div>
            <div class="col-md-2">
              <label for="date" class="form-label"><b>Date</b></label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm" id="date"
                required name="date">
            </div>
          </div>

          <div class="row align-items-center  pt-1 pb-1">
            <div class="col-md-12">
              <input name="submit" id="AssignSubject" class="btn btn-sm btn-primary btn-block" type="submit"
                value="Assign Subject to Class">
            </div>
            <div class="col-md-12">
              <input name="submit" id="UpdateClassWiseSubject" class="btn btn-sm btn-success btn-block" type="submit"
                value="Update Class Wise Subject">
              <input type="submit" onclick="ResetFormByCancelKey()" id="cancelAssignSubjectFormbtn"
                class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
            </div>
          </div>


        </form>
        <hr>
        <div class=" row">
          <div class="col-md-12">
            <h4>Class Wise Subjects</h4>
            <table id="example33" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#id</th>
                  <th class="select-filter">Class Name</th>
                  <th class="select-filter">Subject</th>
                  <th>Is Display</th>
                  <th>Theory Marks</th>
                  <th>Practical Marks</th>
                  <th>Passing Marks</th>
                  {{-- <th>Date</th> --}}
                  <th>Sequence</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="ClassWiseSubject">
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
                  {{-- <td></td> --}}
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>


<div class="row">
  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Examinations Terms<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body collapse in">

        <form class="form-check" id="TermForm" onsubmit="return false" method="POST">
          <div class="row  pt-1 pb-1">
            <div class="col-md-6 d-none">
              <label for="termid" class="form-label"><b>Id</b></label>
              <input type="text" class="form-control form-control-sm" id="termid" name="termid">
            </div>
            <div class="col-md-6">
              <label for="termname" class="form-label"><b>Term Name</b></label>
              <input type="text" class="form-control form-control-sm" id="termname" required name="termname"
                placeholder="">
            </div>
            <div class="col-md-6">
              <?php
                  $sessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsActive', 1)->get();
                ?>
              <label for="sessionid" class="form-label"><b>Academic Session</b></label>
              <select class="form-control form-control-sm" id="sessionid" required name="sessionid" placeholder="">
                <option value="">Select</option>
                @foreach ($sessions as $session)
                <option @if ($session->IsCurrent)
                  {{"selected"}}
                  @endif value="{{ $session->id }}">{{ $session->Session }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row  pt-1 pb-1">
            <div class="col-md-4">
              <label for="tsequence" class="form-label"><b>Sequence</b></label>
              <input type="number" min="1" max="20" class="form-control form-control-sm" id="tsequence" required
                name="tsequence">
            </div>
            <div class="col-md-4">
              <label for="tisactive" class="form-label"><b>Is Active</b></label>
              <select class="form-control form-control-sm" id="tisactive" required name="tisactive">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="tisdisplay" class="form-label"><b>Is Display</b></label>
              <select class="form-control form-control-sm" id="tisdisplay" required name="tisdisplay">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
          </div>

          <div class="row align-items-center  pt-1 pb-1">
            <div class="col-md-12">
              <input name="submit" id="AddTerm" class="btn btn-sm btn-primary btn-block" type="submit"
                value="Add Examination Term">
            </div>
            <div class="col-md-12">
              <input name="submit" id="UpdateTerm" class="btn btn-sm btn-success btn-block" type="submit"
                value="Update Examination Term">
              <input type="submit" onclick="ResetFormByCancelKey()" id="cancelExamTermbtn"
                class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
            </div>
          </div>


        </form>
        <hr>
        <div class=" row">
          <div class="col-md-12">
            <h4>Examination Terms</h4>
            <table id="ExamTerm" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#id</th>
                  <th class="select-filter">Term</th>
                  <th>Session</th>
                  <th>Is Active</th>
                  <th>Is Display</th>
                  <th>Sequence</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="ExamTermBody">
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
                </tr>
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
    $("#RoleForm").trigger("reset");
    $("#updateRole").hide();
    $('#insertSubject').show();
    $('#insertSubject').prop('type', 'submit');
    $('#cancelbtn').hide();

    $("#ClassWiseSubjectForm").trigger("reset");
    $("#UpdateClassWiseSubject").hide();
    $('#AssignSubject').show();
    $('#AssignSubject').prop('type', 'submit');
    $('#cancelAssignSubjectFormbtn').hide();

    $("#TermForm").trigger("reset");
    $("#UpdateTerm").hide();
    $('#AddTerm').show();
    $('#AddTerm').prop('type', 'submit');
    $('#cancelExamTermbtn').hide();
  }

  $(document).ready(function() {
    $('#insertSubject').show();
    $("#updateRole").hide();
    $('#UpdateTerm').hide();
    LoadCompany();
    var dataa = '';
    var examTerms = '';

    $("#updateRole").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateSubject') }}",
        method: 'POST',
        data: $("#RoleForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Duplicate!", "Subject already exists!", "warning");
            return;
          }
          swal("Good job!", "Subject is successfully Updated!", "success");
          $("#RoleForm").trigger("reset");
          $("#updateRole").hide();
          $('#insertSubject').show();
          $('#insertSubject').prop('type', 'submit');
          $('#cancelbtn').hide();
          LoadCompany();
        },
        error: function(errors){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }

      });
    });

    $("#UpdateTerm").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateExamTerm') }}",
        method: 'POST',
        data: $("#TermForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Term already exist", "warning");
            return;
          }
          swal("Good job!", "Exam Term is successfully Updated!", "success");
          $("#TermForm").trigger("reset");
          $("#UpdateTerm").hide();
          $('#AddTerm').show();
          $('#AddTerm').prop('type', 'submit');
          $('#cancelExamTermbtn').hide();
          LoadCompany();
        },
        error: function(errors){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }

      });
    });

    $("#UpdateClassWiseSubject").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateClassWiseSubject') }}",
        method: 'POST',
        data: $("#ClassWiseSubjectForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Subjects already exists", "warning");
            return;
          }
          swal("Good job!", "Subject to class updated successfully", "success");
          $("#ClassWiseSubjectForm").trigger("reset");
          $("#UpdateClassWiseSubject").hide();
          $('#AssignSubject').show();
          $('#AssignSubject').prop('type', 'submit');
          $('#cancelAssignSubjectFormbtn').hide();
          LoadCompany();
        },
        error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }

      });
    });

    $('#insertSubject').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddSubject') }}",
        method: 'POST',
        data: $("#RoleForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Duplicate!", "Subject already assigned!", "warning");
            return;
          }
          swal("Good job!", "Subject is successfully added!", "success");
          $("#RoleForm").trigger("reset");
          LoadCompany();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    $('#AssignSubject').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AssignSubject') }}",
        method: 'POST',
        data: $("#ClassWiseSubjectForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Subject is already assigned!", "warning");
            return;
          }
          swal("Good job!", "Subject successfully assigned!", "success");
          $("#ClassWiseSubjectForm").trigger("reset");
          LoadCompany();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


    $('#AddTerm').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddTerm') }}",
        method: 'POST',
        data: $("#TermForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Term already exist", "warning");
            return;
          }
          swal("Good job!", "Term Successfully Added!", "success");
          $("#TermForm").trigger("reset");
          LoadCompany();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });
  });

  function LoadCompany() {
    // display subjects
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewSubjects') }}",
      success: function(RoleData) {
        dataa = JSON.parse(RoleData);
        $("#example3").DataTable().destroy();  
        $("#RoleData").empty();
        $("#subjectid").empty();
        $('#subjectid').append('<option selected value="0">Choose Subject</option>');
        var j = 1;
        for (i = 0; i < dataa.length; ++i) {
          $('#RoleData').append('<tr ondblclick="EditRole(' + dataa[i].id + ',' + i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + dataa[i].name + '</td>' +
            '<td>' + (dataa[i].isdisplay ? "Yes" : "No") + '</td>' +
            '<td>' + dataa[i].sequence + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></td>'
            + '</tr>');
          j++;

          $('#subjectid').append('<option value="' + dataa[i].id + '">'+
          dataa[i].name +'</option>');        
        }
        // $("#example3").DataTable();

        $('#example3').DataTable( {
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
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
      },
      error: function() {
      }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewActiveSubjects') }}",
      success: function(RoleData) {
        let subjects = JSON.parse(RoleData);
        $("#subjectid").empty();
        $('#subjectid').append('<option value="">Choose Subject</option>');
        for (i = 0; i < subjects.length; i++) {
          $('#subjectid').append('<option value="' + subjects[i].id + '">'+
          subjects[i].name +'</option>');        
        }
      },
      error: function() {
      }
    });


    // display class wise subjects
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewClassWiseSubjects') }}",
      success: function(RoleData) {
        dataaa = JSON.parse(RoleData);
        $("#example33").DataTable().destroy();  
        $("#ClassWiseSubject").empty();
        var j = 1;
        for (i = 0; i < dataaa.length; ++i) {
          $('#ClassWiseSubject').append('<tr  ondblclick="EditClassWiseSubject(' + dataaa[i].iddd + ',' + i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + dataaa[i].ClassName + '</td>' +
            '<td>' + dataaa[i].name + '</td>' +
            '<td>' + (dataaa[i].isdisplay ? "Yes" : "No") + '</td>' +
            '<td>' + dataaa[i].theorymarks + '</td>' +
            '<td>' + dataaa[i].practicalmarks + '</td>' +
            '<td>' + dataaa[i].passingmarks + '</td>' +
            // '<td>' + dataaa[i].date + '</td>' +
            '<td>' + dataaa[i].transcriptsequence + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'
            + '</tr>');
          j++;        
        }
        // $("#example33").DataTable();
        $('#example33').DataTable( {
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
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
      },
      error: function() {
      }
    });


    // display exam terms
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewExamTerms') }}",
      success: function(RoleData) {
        examTerms = JSON.parse(RoleData);
        $("#ExamTerm").DataTable().destroy();  
        $("#ExamTermBody").empty();
        var j = 1;
        for (i = 0; i < examTerms.length; i++) {
          $('#ExamTermBody').append('<tr  ondblclick="EditExamTerm(' + examTerms[i].examtermid + ',' + i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + examTerms[i].termname + '</td>' +
            '<td>' + examTerms[i].Session + '</td>' +
            '<td>' + (examTerms[i].isactive ? "Yes" : "No") + '</td>' +
            '<td>' + (examTerms[i].isdisplay ? "Yes" : "No") + '</td>' +
            '<td>' + examTerms[i].sequence + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'
            + '</tr>');
          j++;        
        }
        // $("#ExamTerm").DataTable();
        $('#ExamTerm').DataTable( {
            initComplete: function () {
                this.api().columns(".select-filter").every( function () {
                    var column = this;
                    var select = $('<select class="form-control form-control-sm"><option value="" ></option></select>')
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
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
      },
      error: function() {
      }
    });
  }

  function EditRole(roleid, i) {
    $('#insertSubject').hide();
    $('#insertSubject').prop('type', '');
    $('#updateRole').show();
    $('#cancelbtn').show();
    $('#id').val(roleid);
    $('#name').val(dataa[i].name);
    $('#isdisplay').val(dataa[i].isdisplay);
    $('#sequence').val(dataa[i].sequence);
  }

  function EditExamTerm(termid, i) {
    $('#AddTerm').hide();
    $('#AddTerm').prop('type', '');
    $('#UpdateTerm').show();
    $('#cancelExamTermbtn').show();
    
    $('#termid').val(termid);
    $('#termname').val(examTerms[i].termname);
    $('#sessionid').val(examTerms[i].sessionid);
    $('#tsequence').val(examTerms[i].sequence);
    $('#tisactive').val(examTerms[i].isactive);
    $('#tisdisplay').val(examTerms[i].isdisplay);
  }
  $('#UpdateClassWiseSubject').hide();

  function EditClassWiseSubject(cwsid, iterator){
    $('#AssignSubject').hide();
    $('#AssignSubject').prop('type', '');
    $('#UpdateClassWiseSubject').show();
    $('#cancelAssignSubjectFormbtn').show();
    
    $('#CWid').val(cwsid);
    $('#subjectid').val(dataaa[iterator].subid);
    $('#classid').val(dataaa[iterator].C_id);
    $('#transcriptsequence').val(dataaa[iterator].transcriptsequence);
    $('#issdisplay').val(dataaa[iterator].isdisplay);
    $('#theorymarks').val(dataaa[iterator].theorymarks);
    $('#obtainmarks').val(dataaa[iterator].practicalmarks);
    $('#passingmarks').val(dataaa[iterator].passingmarks);
    $('#date').val(dataaa[iterator].date);
  }
</script>



@endsection