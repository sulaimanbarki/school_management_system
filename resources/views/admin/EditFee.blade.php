@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="container-fluid pl-1 pr-1 pt-2 pb-2">
    <form onsubmit="return false" method="POST" enctype="multipart/form-data">
      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-2">
          <label for="searchStudent" class="form-label"><b>Student Id</b></label>

          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <?php
                $prefix = \App\Models\addCampus::where('campusid', '=', Auth::user()->campusid)->first();
              if(empty($prefix)){
                echo "<script>alert('campus Not found contact to your administation')</script>";
              }else{
              ?>
              <div class="input-group-text" id="prefix">{{ $prefix->CampusPrefix }}</div>
              <?php  } ?>

            </div>
            <input type="search" class="form-control form-control-sm" name="searchStudent" id="searchStudent">
          </div>


        </div>
        <div class="col-md-1">
          <label for="">&nbsp;</label>
          <button type="submit" class="btn btn-block btn-sm btn-success" onclick="LoadStudentFees()">Search</button>
        </div>
        <div class="col-md-3">
          <label for="lastdate" class="form-label"><b>Student Name</b></label>
          <input type="text" class="form-control form-control-sm" id="stdname" readonly name="stdname">
        </div>
        <div class="col-md-2">
          <label for="lastdate" class="form-label"><b>Father Name</b></label>
          <input type="text" class="form-control form-control-sm" id="fname" readonly name="fname">
        </div>
        <div class="col-md-2">
          <label for="lastdate" class="form-label"><b>Class</b></label>
          <input type="text" class="form-control form-control-sm" id="class" readonly name="class">
        </div>
        <div class="col-md-2">
          <label for="lastdate" class="form-label"><b>Section</b></label>
          <input type="text" class="form-control form-control-sm" id="section" readonly name="section">
        </div>
      </div>

    </form>
    <form id="FeesForm" onsubmit="return false" method="POST" enctype="multipart/form-data">


      <div class="row  pt-1 pb-1">
        <div class="table-responsive col-md-12 ">
          <table id="allStudents" class="table table-responsive-sm">
            <thead>
              <tr>
                <th>Reverse Fee</th>
                <th>Fee Heads</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Discounted Amount</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody id="allStudentsBody">
            </tbody>
            <tfoot>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tfoot>
          </table>
        </div>
      </div>

    </form>
  </div>
</div>




<script>
  var months = [ "January", "February", "March", "April", "May", "June", 
          "July", "August", "September", "October", "November", "December" ];
  $(document).ready(function() {
    
});

  
  var data;

  function LoadStudentFees() {
    var id = $("#prefix").html() + $("#searchStudent").val();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.EditFeeFetch') }}",
      method: 'post',
      data: {stdid: id},
      success: function(d) {
        feesheads = JSON.parse(d);
        if(feesheads.length < 1){
          $("#stdname").val('');
          $("#fname").val('');
          $("#class").val('');
          $("#section").val('');
          swal('Information', 'No fees found to edit for this student.', 'info');
        }
        // $("#allStudents").DataTable().destroy();
        var sum = 0;
        $("#allStudentsBody").empty();
        var j = 1;
        for (i = 0; i < feesheads.length; ++i) {
          sum += parseInt(feesheads[i].amount);
          $("#stdname").val(feesheads[i].studentname);
          $("#fname").val(feesheads[i].fathername);
          $("#class").val(feesheads[i].classname);
          $("#section").val(feesheads[i].sectionname);
          $('#allStudentsBody').append('<tr>' +
            '<td >' + '<input type="checkbox" onchange="ReverseHead(event)" value="0" name="students[]">' + '</td>' +
            '<td>' + feesheads[i].subhead + '</td>' +
            '<td>' + months[feesheads[i].month - 1] + " " + feesheads[i].year + '</td>' +
            '<td class="feesamount">' + feesheads[i].amount + '</td>' + 
            '<td>' + '<input type="hidden" value="' + feesheads[i].id + '" name="feeid[]" class="form-control form-control-sm feeeid">' + 
            '<input type="hidden" value="' + feesheads[i].amount + '" name="amount[]" class="form-control form-control-sm amount">' + 
            '<input type="number" name="discount[]" value="' + feesheads[i].amount + '" class="form-control form-control-sm discount">' + '</td>' + 
            '<td>' + '<input type="text" name="discription[]" value="' + (feesheads[i].comment == null ? "" : feesheads[i].comment) + '" class="form-control form-control-sm desc">' + '</td>' +             
            '</tr>');
          j++;
        }
        $('#allStudentsBody').append('<tr><td>'+
        '<input type="submit" onclick="UpdateFees()" class="btn btn-block btn-primary" name="submit" value="Update" >'
        + '</td><td></td><td><b>Sum</b></td><td><b>' + sum +'</b></td><td></td><td></td></tr>');
        if(feesheads.length < 1){
          $("#allStudentsBody").empty();
        }
      },
      error: function() {
      }
    });
  }

  function UpdateFees(){
    var flage = true;
    $('#allStudentsBody tr').each(function(index, tr) { 
      // console.log($(tr).find('.feesamount').html());
      // return;
      if($(tr).find('.discount').val() != $(tr).find('.feesamount').html() && $(tr).find('.desc').val().length < 10){
        $(tr).find('.desc').addClass("border border-danger");
        swal({
          title: "Comment please",
          text: "Please provide comment",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        });
        flage = false;
        return false;
      }else{
        $(tr).find('.desc').removeClass("border border-danger");
        flage = true;
      }
    });

    if(flage == false)
      return false;
    swal({
      title: "Are you sure?",
      text: "Are you sure to submit changes?",
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
          url: "{{ route('admin.UpdateFees') }}",
          method: 'post',
          data: $("#FeesForm").serialize(),
          success: function(d) {
            LoadStudentFees();
            swal({
              title: "Sucsess",
              text: "Successfully updated",
              icon: "success",
              buttons: true,
              dangerMode: true,
            });
          }
        });
      } else {
      }
    });
  }

  
  function ReverseHead(e){
    var target = e.target;
    var parent = target.parentElement;
    var parentParent = parent.parentElement;
    var comment = parentParent.querySelector('.desc').value;
    var id = parentParent.querySelector('.feeeid').value;
    if(comment.length < 10){
      swal({
        title: "Comment please",
        text: "Please provide comment",
        icon: "warning",
        // buttons: true,
        dangerMode: true,
      });
      e.target.checked = false;
      return;
    }
    swal({
      title: "Are you sure?",
      text: "Are you sure to reverce this head?",
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
                  url: "{{ route('admin.ReverseStudentFees') }}",
                  method: 'POST',
                  data:{tableid: id, comments: comment},
                  success: function(result){
                    LoadStudentFees();
                    swal("Good job!", "Head reversed successfully!", "success");
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
        e.target.checked = false;
      }
    });
  }


</script>



@endsection