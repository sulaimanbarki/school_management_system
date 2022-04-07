@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Personal Development Tags<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body collapse in">

        <form id="RoleForm" onsubmit="return false" method="POST">
          <div class="row  pt-1 pb-1">
            <div class="col-md-4" style="display: none">
              <label for="id" class="form-label"><b>Id</b></label>
              <input type="text" class="form-control form-control-sm" id="id" value="0" name="id" placeholder="">
            </div>
            <div class="col-md-4">
              <label for="pname" class="form-label"><b>Personal Development Name</b></label>
              <input type="text" class="form-control form-control-sm" id="pname" required name="pname" placeholder="">
            </div>
            <div class="col-md-4">
              <label for="date" class="form-label"><b>Date</b></label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" class=" form-control form-control-sm" id="date"
                required name="date" placeholder="">
            </div>
          </div>

          <div class="row align-items-center  pt-1 pb-1">
            <div class="col-md-12">
              <input name="submit" id="insertPname" class="btn btn-sm btn-primary btn-block" type="submit" value="Save">
            </div>
            <div class="col-md-12">
              <input type="submit" name="submit" id="updatePname" class="btn btn-sm btn-success btn-block"
                value="Update">
              <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
            </div>
          </div>


        </form>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Personal Development Tags</h4>
            <table id="example3" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>#id</th>
                  <th class="select-filter">Personal Development Tags</th>
                  <th>Date</th>
                  <th></th>
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
        <h3 class="card-title">Assign Personal Development to Class<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body collapse in">

        <form id="ClassWiseSubjectForm" onsubmit="return false" method="POST">
          <div class="row  pt-1 pb-1">
            <div class="col-md-6 d-none">
              <label for="CWid" class="form-label"><b>Id</b></label>
              <input type="number" class="form-control form-control-sm" id="CWid" value="" required name="CWid"
                placeholder="">
            </div>
            <div class="col-md-6">
              <?php
                  $roles = \App\Models\addClass::where('Campusid', Auth::user()->campusid)->get();
                ?>
              <label for="classid" class="form-label"><b>Class Name</b></label>
              <select class="form-control form-control-sm" id="classid" required name="classid" placeholder="">
                <option value="">Select</option>
                @foreach ($roles as $role)
                <option value="{{ $role->C_id }}">{{ $role->ClassName }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="pdid" class="form-label"><b>Personal Development</b></label>
              <select class="form-control form-control-sm" id="pdid" required name="pdid" placeholder="">

              </select>
            </div>
          </div>

          <div class="row  pt-1 pb-1">
            <div class="col-md-3">
              <label for="isactive" class="form-label"><b>Is Active</b></label>
              <select class="form-control form-control-sm" id="isactive" required name="isactive">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="status" class="form-label"><b>Status</b></label>
              <select class="form-control form-control-sm" id="status" required name="status">
                <option value="Active">Active</option>
                <option value="InActive">InActive</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="date" class="form-label"><b>Date</b></label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm" id="date"
                required name="date">
            </div>
            <div class="col-md-3">
              <label for="sequence" class="form-label"><b>Sequence</b></label>
              <input type="number" min="1" max="20" class="form-control form-control-sm" id="sequence" required
                name="sequence" placeholder="">
            </div>
          </div>

          <div class="row align-items-center  pt-1 pb-1">
            <div class="col-md-12">
              <input name="submit" id="AssignPDT" class="btn btn-sm btn-primary btn-block" type="submit"
                value="Assign Personal Development to Class">
            </div>
            <div class="col-md-12">
              <input name="submit" id="UpdateClassWiseSubject" class="btn btn-sm btn-success btn-block" type="submit"
                value="Update Class Wise Personal Development">
              <input type="submit" onclick="ResetFormByCancelKey()" id="cancelClassWisePDFormbtn"
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
                  <th class="select-filter">Class</th>
                  <th class="select-filter">Personal Development</th>
                  <th>Is Active</th>
                  <th>Status</th>
                  <th>Sequence</th>
                  {{-- <th>Date</th> --}}
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="ClassWiseSubject">
              </tbody>
              <tfoot>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
    $("#updatePname").hide();
    $('#insertPname').show();
    $('#insertPname').prop('type', 'submit');
    $('#cancelbtn').hide();

    $("#ClassWiseSubjectForm").trigger("reset");
    $("#UpdateClassWiseSubject").hide();
    $('#AssignPDT').show();
    $('#AssignPDT').prop('type', 'submit');
    $('#cancelClassWisePDFormbtn').hide();
  }

  $(document).ready(function() {
    $('#insertPname').show();
    $("#updatePname").hide();
    $('#UpdateTerm').hide();
    LoadCompany();
    var dataa = '';
    var examTerms = '';

    $("#updatePname").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdatePersonalDevelopment') }}",
        method: 'POST',
        data: $("#RoleForm").serialize(),
        success: function(result) {
          swal("Good job!", "Personal Development tag updated!", "success");
          $("#RoleForm").trigger("reset");
          $("#updatePname").hide();
          $('#insertPname').show();
          $('#insertPname').prop('type', 'submit');
          $('#cancelbtn').hide();
          LoadCompany();
        },
        error: function(errors){
          $.each(errors.responseJSON.errors, function(field_name,error){
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
        url: "{{ route('admin.UpdateClassWisePD') }}",
        method: 'POST',
        data: $("#ClassWiseSubjectForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Personal Development already assigned!", "warning");
            return;
          }
          swal("Good job!", "Updated successfully", "success");
          $("#ClassWiseSubjectForm").trigger("reset");
          $("#UpdateClassWiseSubject").hide();
          $('#AssignPDT').show();
          $('#AssignPDT').prop('type', 'submit');
          $('#cancelClassWisePDFormbtn').hide();

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

    $('#insertPname').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddPersonalDevelopment') }}",
        method: 'POST',
        data: $("#RoleForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Duplicate entry for personal development!", "warning");
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

    $('#AssignPDT').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AssignPDT') }}",
        method: 'POST',
        data: $("#ClassWiseSubjectForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Warning!", "Personal Development Tag is already assigned!", "warning");
            return;
          }
          swal("Good job!", "Personal Development Tag successfully assigned!", "success");
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
  });

  function LoadCompany() {
    // display subjects
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewPersonalDevelopment') }}",
      success: function(RoleData) {
        dataa = JSON.parse(RoleData);
        $("#example3").DataTable().destroy();  
        $("#RoleData").empty();
        $("#pdid").empty();
        var j = 1;
        $('#pdid').append('<option value="">Select</option>');
        for (i = 0; i < dataa.length; ++i) {
          $('#RoleData').append('<tr  ondblclick="EditPersonalDevelopment(' + dataa[i].id + ',' + i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + dataa[i].pname + '</td>' +
            '<td>' + dataa[i].date + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'
            + '</tr>');
            $('#pdid').append('<option value="' + dataa[i].id + '">' + dataa[i].pname +'</option>');
          j++;      
        }
        $('#example3').DataTable();
      },
      error: function() {
      }
    });


    // display class wise subjects
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewCWPDT') }}",
      success: function(RoleData) {
        dataaa = JSON.parse(RoleData);
        $("#example33").DataTable().destroy();  
        $("#ClassWiseSubject").empty();
        var j = 1;
        for (i = 0; i < dataaa.length; ++i) {
          $('#ClassWiseSubject').append('<tr  ondblclick="EditClassWiseSubject(' + dataaa[i].iddd + ',' + i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + dataaa[i].ClassName + '</td>' +
            '<td>' + dataaa[i].pname + '</td>' +
            '<td>' + (parseInt(dataaa[i].isactive) ? "Yes" : "No") + '</td>' +
            '<td>' + dataaa[i].status + '</td>' +
            '<td>' + dataaa[i].sequence + '</td>' +
            // '<td>' + dataaa[i].date + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'
            + '</tr>');
          j++;        
        }
        // $("#example33").DataTable();
        $('#example33').DataTable({
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

  function EditPersonalDevelopment(roleid, i) {
    $('#insertPname').hide();
    $('#insertPname').prop('type', '');
    $('#updatePname').show();
    $('#cancelbtn').show();
    $('#id').val(roleid);
    $('#pname').val(dataa[i].pname);
    $('#date').val(dataa[i].date);
  }


  $('#UpdateClassWiseSubject').hide();
  function EditClassWiseSubject(cwsid, iterator){
    $('#AssignPDT').hide();
    $('#AssignPDT').prop('type', '');
    $('#UpdateClassWiseSubject').show();
    $('#cancelClassWisePDFormbtn').show();
    $('#CWid').val(cwsid);
    $('#pdid').val(dataaa[iterator].pdid);
    $('#classid').val(dataaa[iterator].C_id);
    $('#sequence').val(dataaa[iterator].sequence);
    $('#isactive').val(dataaa[iterator].isactive);
    $('#date').val(dataaa[iterator].date);
    $('#status').val(dataaa[iterator].status);
  }
</script>



@endsection