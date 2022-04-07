@extends('admin.admin_master')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@section('Admindata')
<div class="row">
  <div class="container-fluid pl-1 pr-1 pt-2 pb-2">
    <form id="feeslipform" onsubmit="return false" method="POST" enctype="multipart/form-data">
      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-2">
          <label for="searchStudent" class="form-label"><b>Search by student id</b></label>
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
        <div class="col-md-2">
          <label for="lastdate" class="form-label"><b>Student Name</b></label>
          <input type="text" class="form-control form-control-sm" id="stdname" readonly name="stdname">
        </div>
        <div class="col-md-2">
          <label for="lastdate" class="form-label"><b>Father Name</b></label>
          <input type="text" class="form-control form-control-sm" id="fname" readonly name="fname">
        </div>
        <div class="col-md-1">
          <label for="lastdate" class="form-label"><b>Class</b></label>
          <input type="text" class="form-control form-control-sm" id="class" readonly name="class">
        </div>
        <div class="col-md-1">
          <label for="lastdate" class="form-label"><b>Section</b></label>
          <input type="text" class="form-control form-control-sm" id="section" readonly name="section">
        </div>
        <div class="col-md-2">
          <label for="lastdate" class="form-label"><b>Status</b></label>
          <input type="text" class="form-control form-control-sm" id="studentStatus" readonly name="section">
        </div>
        <div class="col-md-1">
          <label for="lastdate" class="form-label"><b>Van no.</b></label>
          <input type="text" class="form-control form-control-sm" id="studentBusStatus" readonly name="">
        </div>
      </div>
      <hr>
    </form>
    {{-- forms ends here --}}




    {{-- new forms starts here --}}

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
          role="tab" aria-controls="home" aria-selected="true">Unpaid Fee</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Paid Fee</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
          role="tab" aria-controls="contact" aria-selected="false">Reversed Fee</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="modify-tab" data-bs-toggle="tab" data-bs-target="#modify" type="button" role="tab"
          aria-controls="modify" aria-selected="false">Modify Recieve Date</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <form id="FeesForm" onsubmit="return false" method="POST" enctype="multipart/form-data">
          <div class="row pt-2 pb-2">
            <div class="col-md-3">
              <label for="recievedate" class="form-label"><b>Recieving Date</b></label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm"
                id="recievedate" name="recievedate">
            </div>
            <div class="col-md-3 recievingDate">
              <label for="recievedate" class="form-label"><b>&nbsp;</b></label>
              <input type="submit" onclick="PayFees()" class="form-control form-control-sm bg-primary" id="submit"
                name="submit" value="Pay Fee">
            </div>
            <div class="col-md-3 recievingDate">
              <label for="unpaidsum" class="form-label"><b>Sum</b></label>
              <input type="number" class="form-control form-control-sm" id="unpaidsum" name="unpaidsum" readonly>
            </div>
          </div>
          <table id="allStudents" class="table table-responsive-sm">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Class</th>
                <th>Subhead</th>
                <th>Date</th>
                <th>Amount</th>
                <th width="10%">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" class="checkbox" value="" id="checkallispaid">
                    <label class="form-check-label" for="checkallispaid">Check All</label>
                  </div>
                </th>
                {{-- <th width="7%">Reverse</th> --}}
              </tr>
            </thead>
            <tbody id="allStudentsBody">
            </tbody>
          </table>
        </form>
      </div>

      {{-- paid --}}
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <form id="ListPaidFees" onsubmit="return false">
            <div class="row pt-2 pb-2">
              <div class="col-md-3">
                <label for="recievedate" class="form-label"><b>Recieving Date</b></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm"
                  id="recievedate" name="recievedate">
              </div>
              <div class="col-md-3 recievingDate">
                <label for="recievedate" class="form-label"><b>&nbsp;</b></label>
                <input type="submit" onclick="UnPayFees()" class="form-control form-control-sm bg-primary" id="submit"
                  name="submit" value="Unpay Fee">
              </div>
              <div class="col-md-3 recievingDate">
                <label for="paidSum" class="form-label"><b>Sum</b></label>
                <input type="number" class="form-control form-control-sm" id="paidSum" name="paidSum" readonly>
              </div>
            </div>
            <table id="PaidFeesTable" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Class</th>
                  <th>Subhead</th>
                  <th>Month</th>
                  <th>Rcv Date</th>
                  <th>Amount</th>
                  <th>Comments</th>
                  <th width="10%">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" class="checkbox" value="" id="checkallispaid">
                      <label class="form-check-label" for="checkallispaid">Check All</label>
                    </div>
                  </th>
                  {{-- <th>Description</th>
                  <th width="7%">Reverse</th> --}}
                </tr>
              </thead>
              <tbody id="PaidFeesBody">
              </tbody>
            </table>
          </form>
        </div>
      </div>


      {{-- reversed --}}
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <form id="UnReversedFeeForm" onsubmit="return false">
            <div class="row pt-2 pb-2">
              <div class="col-md-3">
                <label for="recievedate" class="form-label"><b>Recieving Date</b></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm"
                  id="recievedate" name="recievedate">
              </div>
              <div class="col-md-3">
                <label for="recievedate" class="form-label"><b>&nbsp;</b></label>
                <input type="submit" onclick="UnReversedFee()" class="form-control form-control-sm bg-primary"
                  id="submit" name="submit" value="Unreverse Fee">
              </div>

              <div class="col-md-3">
                <label for="reversedSum" class="form-label"><b>Sum</b></label>
                <input type="number" class="form-control form-control-sm" id="reversedSum" name="reversedSum" readonly>
              </div>
            </div>
            <table id="ReversedFeeTable" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Class</th>
                  <th>Subhead</th>
                  <th>Month</th>
                  <th>Rvse Date</th>
                  <th>Comment</th>
                  <th>Amount</th>
                  <th width="10%">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" class="checkbox" value="" id="checkallispaid">
                      <label class="form-check-label" for="checkallispaid">Check All</label>
                    </div>
                  </th>
                  {{-- <th>Description</th>
                  <th width="7%">Reverse</th> --}}
                </tr>
              </thead>
              <tbody id="ReversedFeeBody">
              </tbody>
            </table>
          </form>
        </div>
      </div>



      {{-- modify-tab --}}
      <div class="tab-pane fade" id="modify" role="tabpanel" aria-labelledby="modify-tab">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <form id="ModifyRecieveDate" onsubmit="return false">
            <div class="row pt-2 pb-2">
              <div class="col-md-2">
                <label for="datee" class="form-label"><b>Date</b></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm" id="datee"
                  name="datee">
              </div>
              <div class="col-md-2 recievingDate">
                <label for="datee" class="form-label"><b>&nbsp;</b></label>
                <input type="submit" onclick="LoadFeesForDateModify()" class="form-control form-control-sm bg-primary"
                  id="submit" name="submit" value="Search">
              </div>
              <div class="col-md-4 recievingDate">
                <label for="datee" class="form-label"><b>Sum</b></label>
                <input type="number" class="form-control form-control-sm" readonly id="modifySum">
              </div>
              <div class="col-md-2">
                <label for="todatee" class="form-label"><b>To Date</b></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm"
                  id="todatee" name="todatee">
              </div>
              <div class="col-md-2 recievingDate">
                <label for="datee" class="form-label"><b>&nbsp;</b></label>
                <input type="submit" onclick="ModifyRecieveDate()" class="form-control form-control-sm bg-primary"
                  id="submit" name="submit" value="Modify Date">
              </div>
            </div>
            <table id="ModifyFeeTable" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>Std. Id</th>
                  <th>Name</th>
                  <th>Father</th>
                  <th>Amount</th>
                  <th>Recieve Date</th>
                  <th></th>
                  {{-- <th>Description</th>
                  <th width="7%">Reverse</th> --}}
                </tr>
              </thead>
              <tbody id="ModifyFeeBody">
              </tbody>
            </table>
          </form>
        </div>
      </div>

    </div>

  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
  var data = 0;
  var unpaidSum = 0;
  var paidSum = 0;
  var reversedSum = 0;
  var modifySum = 0;
  var months = [ "January", "February", "March", "April", "May", "June", 
          "July", "August", "September", "October", "November", "December" ];
  $(document).ready(function() {
    
});

  
  var data;

  function ModifyRecieveDate() {
    swal({
      title: "Are you sure?",
      text: "Are you sure to modify fees date ?",
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
            url: "{{ route('admin.ModifyRecieveDate') }}",
            method: 'post',
            data: $("#ModifyRecieveDate").serialize(),
            success: function(d) {
              swal({
                title: "Updated",
                text: "Modified Successfully",
                icon: "success",
                buttons: true,
                dangerMode: true,
              });
              LoadFeesForDateModify();
            },
            error: function() {
            }
          });
      } else {
      }
    });



    
  }


  function LoadFeesForDateModify() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.LoadFeesForDateModify') }}",
      method: 'post',
      data: $("#ModifyRecieveDate").serialize(),
      success: function(d) {
        feesheads = JSON.parse(d);
        $("#ModifyFeeTable").DataTable().destroy();
        $("#ModifyFeeBody").empty();
        var j = 1;
        modifySum = 0;
        for (i = 0; i < feesheads.length; ++i) {
          modifySum += parseInt(feesheads[i].amount);
          $('#ModifyFeeBody').append('<tr>' +
            '<td>' + feesheads[i].studentid + '</td>' +
            '<td>' + feesheads[i].studentname + '</td>' +
            '<td>' + feesheads[i].fathername + '</td>' +
            '<td>' + feesheads[i].amount + '</td>' + 
            '<td>' + feesheads[i].recievedate + '</td>' + 
            '<td >' + 
              '<input type="checkbox" onclick="IncDecModifySum(event)" data-valu="' + feesheads[i].amount + '"  checked onchange="changeCheckValue(event)" value="1" name="students[]">' + 
              '<input type="hidden" class="checkstatus" value="1" name="checkStatus[]">' + 
              '<input type="hidden" value="' + feesheads[i].id + '" name="feeheadid[]">' + 
              '</td>' +
            '</tr>');
          j++;
        }
        $('#modifySum').val(modifySum);
        $("#ModifyFeeTable").DataTable();
      },
      error: function() {
      }
    });
  }

  function LoadStudentFees() {
    var id = $("#prefix").html() + $("#searchStudent").val();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.FeeSlipUnpaidFees') }}",
      method: 'post',
      data: {stdid: id},
      success: function(d) {
        feesheads = JSON.parse(d);
        data = feesheads;
        // console.log(data);
        // return;
        if(data.student.length < 1){
          swal({
              title: "Error",
              text: "No student found",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            });
          $("#feeslipform").trigger("reset");
          $("#allStudentsBody").empty();
          $("#PaidFeesBody").empty();
          $("#ReversedFeeBody").empty();
          return;
        }
        $("#stdname").val(data.student[0].studentname);
        $("#fname").val(data.student[0].fathername);
        $("#class").val(data.student[0].classname);
        $("#section").val(data.student[0].sectionname);
        $("#studentStatus").val(data.student[0].status);
        data.student[0].busnumber ? $("#studentBusStatus").val(data.student[0].busnumber) : $("#studentBusStatus").val("No service");
        unpaidSum = 0;
        $("#allStudents").DataTable().destroy();
        $("#allStudentsBody").empty();
        var j = 1;
        for (i = 0; i < data.unpaid.length; ++i) {
          unpaidSum += parseInt(data.unpaid[i].amount);
          $('#allStudentsBody').append('<tr>' +
            '<td>' + j + '</td>' +
            '<td>' + data.unpaid[i].classname + '</td>' +
            '<td>' + data.unpaid[i].subhead + '</td>' +
            '<td>' + months[data.unpaid[i].month - 1] + " " + data.unpaid[i].year + '</td>' +
            '<td>' + data.unpaid[i].amount + '</td>' + 
            '<td >' + 
              '<input type="checkbox" onclick="IncDecUnpaidSum(event)" data-valu="' + data.unpaid[i].amount + '" checked onchange="changeCheckValue(event)" class="unpaidCheckBox" value="1" name="students[]">' + 
              '<input type="hidden" class="checkstatus" value="1" name="checkStatus[]">' + 
              '<input type="hidden" value="' + data.unpaid[i].id + '" name="feeheadid[]">' + 
              '</td>' +
            '</tr>');
          j++;
        }
        $('#unpaidsum').val(unpaidSum);



        paidSum = 0;
        // $("#allStudents").DataTable().destroy();
        $("#PaidFeesBody").empty();
        var j = 1;
        for (i = 0; i < data.paid.length; ++i) {
          var rcvDate = data.paid[i].recievedate;
          var [yyyy, mm, dd] = rcvDate.split("-");
          var rcvDate = `${mm}-${dd}-${yyyy}`;

          paidSum += parseInt(data.paid[i].amount);
          $('#PaidFeesBody').append('<tr>' +
            '<td>' + j + '</td>' +
            '<td>' + data.paid[i].classname + '</td>' +
            '<td>' + data.paid[i].subhead + '</td>' +
            '<td>' + months[data.paid[i].month - 1] + " " + data.paid[i].year + '</td>' +
            '<td>' +  rcvDate + '</td>' + 
            '<td>' + data.paid[i].amount + '</td>' + 
            '<td>' + data.paid[i].comment + '</td>' + 
            '<td >' + 
              '<input type="checkbox" onclick="IncDecPaidSum(event)" data-valu="' + data.paid[i].amount + '" checked onchange="changeCheckValue(event)" value="1" name="students[]">' + 
              '<input type="hidden" class="checkstatus" value="1" name="checkStatus1[]">' + 
              '<input type="hidden" value="' + data.paid[i].id + '" name="feeheadid1[]">' + 
              '</td>' +
            '</tr>');
          j++;
        }
        $('#paidSum').val(paidSum);


        var reversedSum = 0;
        // $("#allStudents").DataTable().destroy();
        $("#ReversedFeeBody").empty();
        var j = 1;
        for (i = 0; i < data.rev.length; ++i) {
          var rcvDate = data.rev[i].recievedate;
          var [yyyy, mm, dd] = rcvDate.split("-");
          var rcvDate = `${mm}-${dd}-${yyyy}`;

          reversedSum += parseInt(data.rev[i].amount);
          $('#ReversedFeeBody').append('<tr>' +
            '<td>' + j + '</td>' +
            '<td>' + data.rev[i].classname + '</td>' +
            '<td>' + data.rev[i].subhead + '</td>' +
            '<td>' + months[data.rev[i].month - 1] + " " + data.rev[i].year + '</td>' +
            '<td>' + rcvDate + '</td>' + 
            '<td>' + data.rev[i].comment + '</td>' + 
            '<td>' + data.rev[i].amount + '</td>' + 
            '<td >' + 
              '<input type="checkbox" onclick="IncDecReversedSum(event)" data-valu="' + data.rev[i].amount + '"  checked onchange="changeCheckValue(event)" value="1" name="students[]">' + 
              '<input type="hidden" class="checkstatus" value="1" name="checkStatus2[]">' + 
              '<input type="hidden" value="' + data.rev[i].id + '" name="feeheadid2[]">' + 
              '</td>' +
            '</tr>');
          j++;
        }
        $('#reversedSum').val(reversedSum);
      },
      error: function() {
      }
    });
  }

  $("#checkallispaid").click(function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
    $('input:checkbox').each(function (indexInArray, valueOfElement) {
      if(this.checked){
        this.nextSibling.value = 1;
      }else{
        this.nextSibling.value = 0;
      }
    });
  });

  function changeCheckValue(e){
    if(e.target.nextSibling.value == 1){
      e.target.nextSibling.value = 0;
    }else{
      e.target.nextSibling.value = 1;
    }
  }

  function IncDecUnpaidSum(e){
    if(e.target.nextSibling.value == 1){
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#unpaidsum").val(parseInt($("#unpaidsum").val()) - vale);
    }else{
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#unpaidsum").val(parseInt($("#unpaidsum").val()) + vale);
    }
  }

  function IncDecPaidSum(e){
    if(e.target.nextSibling.value == 1){
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#paidSum").val(parseInt($("#paidSum").val()) - vale);
    }else{
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#paidSum").val(parseInt($("#paidSum").val()) + vale);
    }
  }
  function IncDecModifySum(e){
    if(e.target.nextSibling.value == 1){
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#modifySum").val(parseInt($("#modifySum").val()) - vale);
    }else{
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#modifySum").val(parseInt($("#modifySum").val()) + vale);
    }
  }
  
  function IncDecReversedSum(e){
    if(e.target.nextSibling.value == 1){
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#reversedSum").val(parseInt($("#reversedSum").val()) - vale);
    }else{
      var vale = parseInt(e.target.getAttribute("data-valu"));
      $("#reversedSum").val(parseInt($("#reversedSum").val()) + vale);
    }
  }

  function PayFees(){
    swal({
      title: "Are you sure?",
      text: "Are you sure to pay fees ?",
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
          url: "{{ route('admin.PayUnpaidFees') }}",
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

  
  function UnPayFees(){
    swal({
      title: "Are you sure?",
      text: "Are you sure to pay fees ?",
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
          url: "{{ route('admin.UnpaidPaidFees') }}",
          method: 'post',
          data: $("#ListPaidFees").serialize(),
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


  function UnReversedFee(){
    swal({
      title: "Are you sure?",
      text: "Are you sure to UnReversed fees ?",
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
          url: "{{ route('admin.UnRevereddPaidFees') }}",
          method: 'post',
          data: $("#UnReversedFeeForm").serialize(),
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
    if(comment.length < 5){
      swal({
        title: "Comment please",
        text: "Please provide comment",
        icon: "warning",
        buttons: true,
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

      }
    });
  }


</script>



@endsection