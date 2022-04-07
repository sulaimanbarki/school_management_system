@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Scholarships<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="container-fluid">
          <form id="ScholarshipForm" onsubmit="return false" method="POST" enctype="multipart/form-data">
            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="id" class="form-label"><b>Scholarship id</b></label>
                <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="name" class="form-label"><b>Name</b></label>
                <input type="text" class="form-control form-control-sm" id="name" required name="name" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="isactive" class="form-label"><b>Is Active</b></label>
                <select class="form-control form-control-sm" id="isactive" required name="isactive" placeholder="">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>
            <div class="row align-items-center  ">
              <div class="col-md-6">
                <label for="sequence" class="form-label"><b>Sequence</b></label>
                <input type="number" min="1" max="20" class="form-control form-control-sm" id="sequence" required
                  name="sequence" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="date" class="form-label"><b>Date</b></label>
                <input type="date" class="form-control form-control-sm" id="date" value="{{ date('Y-m-d') }}" required
                  name="date" placeholder="">
              </div>
              <div class="col-md-4 d-none">
                <label for="amount" class="form-label"><b>Amount</b></label>
                <input type="number" value="0" class="form-control form-control-sm" id="amount" required name="amount"
                  placeholder="">
              </div>
            </div>
            <div class="row align-items-center  ">
              <div class="col-md-12">
                <label for="description" class="form-label"><b>Description</b></label>
                <textarea class="form-control form-control-sm" id="description" name="description" rows=""></textarea>
              </div>
            </div>

            <div class="row align-items-center  pt-3 pb-3">
              <div class="col-md-12">
                <input type="submit" id="addScholarship" class="btn btn-sm btn-primary btn-block" value="Save">
              </div>
              <div class="col-md-12">
                <input type="submit" style="display:none" id="updateScholarship"
                  class="btn btn-sm btn-success btn-block" value="Update">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>


          </form>
        </div>
        <hr>
        <table id="example3" class="table table-hover table-responsive-sm">
          <thead>
            <tr>
              <th>Name</th>
              {{-- <th>Amount</th> --}}
              <th>Is Active</th>
              <th>Sequence</th>
              <th>Date</th>
              <th>Description</th>
              <th></th>
              <!-- <th>SubCat_name</th> -->
            </tr>
          </thead>
          <tbody id="Scholarships">
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>








<script>
  function ResetFormByCancelKey(){
    $("#ScholarshipForm").trigger("reset");
    $('#updateScholarship').hide();
    $('#addScholarship').show();
    $('#addScholarship').prop('type', 'submit');
    $('#cancelbtn').hide(); 
    $('#description').html(""); 
  }

  var data;
  var scholarships = '';
  $(document).ready(function() {
    $('#addScholarship').show();
    LoadCompany();

    $("#updateScholarship").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.UpdateScholarshpConfigration') }}",
        method: 'POST',
        data: $("#ScholarshipForm").serialize(),
        success: function(result) {
        //  // alert(result.result);
        //   if(result.result=="true")
        //   {
        //     swal("Warning!", "This scholarship Already Exist!", "error");
        //   }else if(result.result=="save"){
            swal("Good job!", "Scholarship is successfully Updated!", "success");
            $("#ScholarshipForm").trigger("reset");
            $('#updateScholarship').hide();
            $('#addScholarship').show();
            $('#addScholarship').prop('type', 'submit');
            $('#cancelbtn').hide();
            $('#description').html("");
          // }else{
          //   swal("Warning!", "Issue While Updating Scholarship!", "error");
          // }
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

    $('#addScholarship').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddScholarshipConfigration') }}",
        method: 'POST',
        data: $("#ScholarshipForm").serialize(),
        success: function(result) {
          LoadCompany();
          if(result == 'Error'){
            swal("Duplicate Entry", "Subhead duplicate", "warning");
          }else{
          swal("Good job!", "Successfully added!", "success");
          $("#ScholarshipForm").trigger("reset");
          $('#description').html("");
          }
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
    //alert();
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewScholarshpConfigration') }}",
      success: function(d) {
        scholarships = JSON.parse(d);
        $("#example3").DataTable().destroy();
        $("#Scholarships").empty();
        var j = 1;
        for (i = 0; i < scholarships.length; ++i) {
          $('#Scholarships').append('<tr   ondblclick="EditScholarship(' + scholarships[i].id + ','+ i + ')">' +
            '<td>' + scholarships[i].name + '</td>' +
            // '<td>' + scholarships[i].amount + '</td>' +
            '<td>' + scholarships[i].isactive + '</td>' +
            '<td>' + scholarships[i].sequence + '</td>' +
            '<td>' + scholarships[i].date + '</td>' +
            '<td>' + scholarships[i].description + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
        }
        $("#example3").DataTable();
      },
      error: function() {
      }
    });
  }

  // Edit registration function
  function EditScholarship(scholarship, i) {
    $('#addScholarship').hide();
    $('#addScholarship').prop('type', '');
    $('#updateScholarship').show();
    $('#cancelbtn').show();
    $('#id').val(scholarship);
    $('#name').val(scholarships[i].name);
    // $('#amount').val(scholarships[i].amount);
    $('#isactive').val(scholarships[i].isactive);
    $('#sequence').val(scholarships[i].sequence);
    $('#admissioninclass').val(scholarships[i].admissioninclass);
    $('#date').val(scholarships[i].date);
    $('#description').html(scholarships[i].description);
  }

</script>



@endsection