@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Fee Heads<Section></Section>
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
          <form id="FeesForm" onsubmit="return false" method="POST" enctype="multipart/form-data">


            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="id" class="form-label"><b>Head Id</b></label>
                <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="subhead" class="form-label"><b>Add Fee Head</b></label>
                <input type="text" class="form-control form-control-sm" id="subhead" required name="subhead"
                  placeholder="">
                <input type="checkbox" name="transportStatus" id="transportStatus" class="d-none" />
              </div>
              <div class="col-md-4 d-none">
                <label for="amount" class="form-label"><b>Amount</b></label>
                <input type="number" value="0" class="form-control form-control-sm" id="amount" required name="amount"
                  placeholder="">
              </div>
              <div class="col-md-6">
                <label for="sequence" class="form-label"><b>Sequence</b></label>
                <input type="number" min="1" max="20" class="form-control form-control-sm" id="sequence" required
                  name="sequence" placeholder="">
              </div>
            </div>

            <div class="row align-items-center  ">
              <div class="col-md-6">
                <label for="isdefault" class="form-label"><b>Active Head</b></label>
                <select class="form-control form-control-sm" id="isdefault" required name="isdefault" placeholder="">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="date" class="form-label"><b>Date</b></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm" id="date"
                  required name="date" placeholder="">
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
                <input type="submit" id="insertFeeHead" class="btn btn-sm btn-primary btn-block" value="Save">
              </div>
              <div class="col-md-12">
                <input type="submit" style="display:none" id="updateFeeHead" class="btn btn-sm btn-success btn-block"
                  value="Update">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>


          </form>
        </div>
        <hr>
        <table id="example3" class="table table-responsive-sm">
          <thead>
            <tr>
              <th>Add Fee Head</th>
              {{-- <th>Amount</th> --}}
              <th>Description</th>
              <th>Sequence</th>
              <th>Date</th>
              <th>Active Head</th>
              <th></th>
              <!-- <th>SubCat_name</th> -->
            </tr>
          </thead>
          <tbody id="FeesHead">
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>


<script>
  function ResetFormByCancelKey(){
    $("#FeesForm").trigger("reset");
    $("#description").html("");
    $('#insertFeeHead').show();
    $('#updateFeeHead').hide();
    $('#insertFeeHead').prop('type', 'submit');
    $('#cancelbtn').hide();
  }

  $("#subhead").keyup(function(){
    let t = this.value;
    if(t.search(/tran/i) == -1){
      $('#transportStatus').prop('checked', false);
    }else{
      $('#transportStatus').prop('checked', true);
    }
  })
  var data;
  $(document).ready(function() {
    $('#insertFeeHead').show();
    LoadCompany();
    // FetchSWSH();
    var dataa = '';

    $("#updateFeeHead").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateFeesHeadConfigration') }}",
        method: 'POST',
        data: $("#FeesForm").serialize(),
        success: function(result) {
          console.log(result);
          LoadCompany();
          swal("Good job!", "Employee is successfully updated!", "success");
          $("#FeesForm").trigger("reset");
          $("#description").html("");
          $('#insertFeeHead').show();
          $('#updateFeeHead').hide();
          $('#insertFeeHead').prop('type', 'submit');
          $('#cancelbtn').hide();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // $('#addSWSH').click(function() {
    //   $.ajaxSetup({
    //     headers: {
    //       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //     }
    //   });
    //   $.ajax({
    //     url: "{{ route('admin.AddSholarshipWiseSubheads') }}",
    //     method: 'POST',
    //     data: $("#ScholarshipWSHForm").serialize(),
    //     success: function(result) {
    //       LoadCompany();
    //       FetchSWSH();
    //       if(result == 'Error'){
    //         swal("Duplicate Entry", "Subhead duplicate", "warning");
    //       }else{
    //       swal("Good job!", "Successfully added!", "success");
    //       $("#ScholarshipWSHForm").trigger("reset");
    //       }
    //     },
    //     error: function(error) {
    //       $.each(error.responseJSON.errors, function(field_name,error){
    //         swal('Warning', error[0], 'warning');
    //         // alert(error);
    //           // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
    //       });
    //     }
    //   });
    // });

  });
    $('#insertFeeHead').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddFeesHeadConfigration') }}",
        method: 'POST',
        data: $("#FeesForm").serialize(),
        success: function(result) {
          // alert(result.result);
          // FetchSWSH();
          LoadCompany();
          if(result.result=='already'){
            swal("Duplicate Entry", "Subhead duplicate", "warning");
          }else{
          swal("Good job!", "Successfully added!", "success");
          $("#FeesForm").trigger("reset");
          $("#description").html("");
          }
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
            // alert(error);
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


  // function FetchSWSH() {
  // //  alert();
  //   $.ajax({
  //     dataType: "json",
  //     url: "{{ route('admin.ViewSholarshipWiseSubheads') }}",
  //     success: function(d) {
  //       SWfeesheads = JSON.parse(d);
  //       $("#SubheadTable").DataTable().destroy();
  //       $("#SWFeesHead").empty();
  //       var j = 1;
  //       for (i = 0; i < SWfeesheads.length; ++i) {
  //         $('#SWFeesHead').append('<tr>' +
  //           '<td>' + j + '</td>' +
  //           '<td>' + SWfeesheads[i].amount+ '</td>' +
  //           '<td>' + SWfeesheads[i].subhead + '</td>' +
  //           '<td>' + SWfeesheads[i].name + '</td>' +
  //           '<td>' + SWfeesheads[i].sequence + '</td>' +
  //           '<td>' + SWfeesheads[i].isactive + '</td>' +
  //           '<td onclick="DeleteSWSH(' + SWfeesheads[i].id + ')"  style="color:red">Delete</td>'+'</tr>');
  //         j++;
  //       }
  //       $("#SubheadTable").DataTable();
  //     },
  //     error: function() {
  //     }
  //   });
  // }

  function LoadCompany() {
   // alert();
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewFeesHeadConfigration') }}",
      success: function(d) {
        feesheads = JSON.parse(d);
        $("#example3").DataTable().destroy();
        $("#FeesHead").empty();
        var j = 1;
        for (i = 0; i < feesheads.length; ++i) {
          $('#FeesHead').append('<tr  ondblclick="EditSubhead(' +feesheads[i].id+','+ i + ')">' +
            '<td>' + feesheads[i].subhead + '</td>' +
            // '<td>' + feesheads[i].amount + '</td>' +
            '<td>' + feesheads[i].description + '</td>' +
            '<td>' + feesheads[i].sequence + '</td>' +
            '<td>' + feesheads[i].date + '</td>' +
            '<td>' + feesheads[i].isdefault + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
        }
        $("#example3").DataTable();
      },
      error: function() {
      }
    });
  }

  function EditSubhead(id, i){
    $('#insertFeeHead').hide();
    $('#insertFeeHead').prop('type', '');
    $("#updateFeeHead").show();
    $('#cancelbtn').show();
    $("#id").val(feesheads[i].id);
    $("#subhead").val(feesheads[i].subhead);
    $("#sequence").val(feesheads[i].sequence);
    $("#isdefault").val(feesheads[i].isdefault);
    $("#date").val(feesheads[i].date);
    $("#description").html(feesheads[i].description);
  }

  function DeleteSWSH(id) {
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this record!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
                });
                  $.ajax({
                    url: "{{ route('admin.DeleteSholarshipWiseSubheads') }}",
                    method: 'POST',
                    data:{subheadid:id},
                    success: function(result){
                      // FetchSWSH();
                      swal("Good job!", "Class successfully updated!", "success");
                      //   alert(result.result);
                    },
                    error: function(error){
                    $.each(error.responseJSON.errors, function(field_name,error){
                      swal('Warning', error[0], 'warning');
                        // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                    });
                  }
              });
      } else {
      }
  });
  }

</script>



@endsection
