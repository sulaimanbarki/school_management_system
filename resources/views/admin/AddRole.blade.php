@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Roles <Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">

        <form class="form-check" id="RoleForm" onsubmit="return false" method="POST">
          <div class="row  pt-1 pb-1">
            <div class="col-md-4" style="display: none">
              <label for="RoleId" class="form-label"><b>Role Id</b></label>
              <input type="text" class="form-control form-control-sm" id="RoleId" value="0" name="RoleId"
                placeholder="">
            </div>
            <div class="col-md-4">
              <label for="Role" class="form-label"><b>Role Name</b></label>
              <input type="text" class="form-control form-control-sm" id="Role" required name="Role" placeholder="">
            </div>
            <div class="col-md-4">
              <label for="IsActive" class="form-label"><b>Is Active</b></label>
              <select class="form-control form-control-sm" id="IsActive" required name="IsActive" placeholder="">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="Sequence" class="form-label"><b>Sequence</b></label>
              <input type="number" min="1" max="20" class="form-control form-control-sm" id="Sequence" required
                name="Sequence" placeholder="">
            </div>
          </div>

          <div class="row align-items-center  pt-1 pb-1">
            <div class="col-md-12">
              <input type="submit" id="insertRole" class="btn btn-sm btn-primary btn-block" value="Save Role">
            </div>
            <div class="col-md-12">
              <input type="submit" name="submit" id="updateRole" class="btn btn-sm btn-success btn-block"
                value="Update Role" style="display: none;">
              <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn" class="btn btn-sm btn-danger btn-block"
                style="display: none;" value="Cancel">
            </div>
          </div>


        </form>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Roles</h4>
            <table id="example3" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Role Name</th>
                  <th>Is Active</th>
                  <th>Sequence</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="RoleData">
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>

<script>
  function ResetFormByCancelKey(){
    $("#updateRole").hide();
    $('#insertRole').show();
    $('#cancelbtn').hide();
    $("#RoleForm").trigger("reset");
    $('#insertRole').prop("type", 'submit'); 
  }

  $(document).ready(function() {
    $('#insertRole').show();
    $("#updateRole").hide();
    LoadCompany();
    var dataa = '';

    $("#updateRole").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateRoleConfigration') }}",
        method: 'POST',
        data: $("#RoleForm").serialize(),
        success: function(result) {
          if(result == 'Error'){
            swal("Warning!", "Role Already Exist!", "error");
            return;
          }
          if(result.result=="true")
          {
            swal("Warning!", "Role Already Exist!", "error");
          }else if(result.result == 'superadmin'){
            swal("Warning!", "Supper admin can not be modified.", "error");
          }else if(result.result=="save"){
          $("#updateRole").hide();
          $('#insertRole').show();
          $('#cancelbtn').hide();
          $("#RoleForm").trigger("reset");
          $('#insertRole').prop("type", 'submit');
          swal("Good job!", "Role is successfully Updated!", "success");
          }else{
            swal("Warning!", "Issue While Updating Role!", "error");
          }
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

    $('#insertRole').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddRoleConfigration') }}",
        method: 'POST',
        data: $("#RoleForm").serialize(),
        success: function(result) {
          console.log(result.result);
          if(result.result=="true")
          {
            swal("Warning!", "Role Already Exist!", "error");
          }else if(result.result=="save"){
            
          swal("Good job!", "Role is successfully added!", "success");
          $("#RoleForm").trigger("reset");
          }else{
            swal("Warning!", "Issue Whiling Adding Role!", "error");
          }
          LoadCompany();
          //   alert(result.result);

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
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewRoleConfigration') }}",
      success: function(RoleData) {
        dataa = JSON.parse(RoleData);
        $("#example3").DataTable().destroy();  
        $("#RoleData").empty();
        var j = 1;
        for (i = 0; i < dataa.length; ++i) {
          $('#RoleData').append('<tr  ondblclick="EditRole(' +dataa[i].RoleId+','+ i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + dataa[i].Role + '</td>' +
            '<td>' + (dataa[i].IsActive ? 'Yes' : 'No') + '</td>' +
            '<td>' + dataa[i].Sequence + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'
            + '</tr>');
          j++;
        }
        $("#example3").DataTable();
      },
      error: function() {
      }
    });
  }

  function EditRole(roleid, i) {
    $('#insertRole').hide();
    $('#insertRole').prop("type", '');
    $('#updateRole').show();
    $('#cancelbtn').show();
    $('#RoleId').val(roleid);
    $('#Role').val(dataa[i].Role);
    $('#IsActive').val(dataa[i].IsActive);
    $('#Sequence').val(dataa[i].Sequence);
  }
</script>



@endsection