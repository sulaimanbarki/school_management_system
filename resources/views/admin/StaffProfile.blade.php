@extends('admin.admin_master')
@section('Admindata')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-3">
        <h1>Staff Profile</h1>
      </div>
      <?php 
        $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
      ?>
      <div class="col-sm-4">
        <form onsubmit="return false" id="searchStaffProfile">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Emp Id</span>
            </div>
            <input type="text" id="stdid" name="stdid" class="form-control" placeholder="Enter employee id."
              aria-label="Username" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
      <div class="col-sm-1">
        <button type="submit" class="btn btn-primary btn-block" form="searchStaffProfile">Search</button>
      </div>
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">User Profile</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<?php 
?>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" id="profilePicture"
                src="{{ asset('userbackend/dist/img/AdminLTELogo.png') }}"
                onerror="this.src='{{asset('userbackend/dist/img/AdminLTELogo.png')}}'" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center" id="studentName">Rana Tanner</h3>

            <p class="text-muted text-center" id="fatherName">Father : Unity Baird</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>CNIC</b> <a class="float-right" id="idcard">-----</a>
              </li>
              <li class="list-group-item">
                <b>Gender</b> <a class="float-right" id="section">-----</a>
              </li>
              <li class="list-group-item">
                <b>Email</b> <a class="float-right" id="formb">-----</a>
              </li>
              <li class="list-group-item">
                <b>Address</b> <a class="float-right" id="fcnic">-----</a>
              </li>
              <li class="list-group-item">
                <b>Contact(s)</b> <a class="float-right contact" id="contact">-----</a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b id="student_status">---</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.card -->
      </div>

      <!-- /.col -->
      {{-- <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Comments</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Remaining Fees</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Related</a></li>
              <li class="nav-item"><a class="nav-link" href="#concessionComment" data-toggle="tab">Concession
                  Comments</a></li>
              <li class="nav-item"><a class="nav-link" href="#promotionComment" data-toggle="tab">Promotion Comments</a>
              </li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post clearfix commentbox">
                </div>
                <form class="form-horizontal" id="studentCommentForm">
                  <div class="input-group input-group-sm mb-0">
                    <textarea class="form-control" id="StudentComment" name="StudentComment"></textarea>
                    <input type="hidden" name="classIdd" id="classIdd">
                    <input type="hidden" name="sectionIdd" id="sectionIdd">
                    <input type="hidden" name="studentIdd" id="studentIdd">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-success">Comment</button>
                    </div>
                  </div>
                </form>
                <!-- /.post -->
              </div>
              <div class="tab-pane" id="timeline">
                <table id="PaidFeesTable" class="table table-responsive-sm">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Subhead</th>
                      <th>Month</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="allStudentsBody">
                  </tbody>
                </table>
              </div>

              <div class="tab-pane" id="settings">
                <form class="form-horizontal" action="abc.php" id="fetchStudentsRelatives">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Father CNIC</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="fatherCNIC" placeholder="CNIC">
                    </div>
                    <div class="col-sm-2">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Search</button>
                      </div>
                    </div>
                  </div>
                  <table class="table table-responsive-sm">
                    <thead>
                      <th>St.ID</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Section</th>
                      <th>Unpaid Fees</th>
                    </thead>
                    <tbody id="retlativeData"></tbody>
                  </table>
                </form>
              </div>
              <div class="tab-pane" id="concessionComment">
                <div class="form-group row">
                  <table class="table table-responsive-sm">
                    <tbody id="concessionCommentTable"></tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="promotionComment">
                <div class="form-group row">
                  <table class="table table-responsive-sm">
                    <tbody id="promotionCommentTable"></tbody>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div> --}}
      <div class="col-md-9">

        <!-- About Me Box -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">About</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Scale : </strong>
            <span class="text-muted address1"> ----- </span>

            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Basic Pay Salary : </strong>

            <span class="text-muted bps"> ----- </span>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Allowances</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Deductions</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Advance Salary</a></li>
              <li class="nav-item"><a class="nav-link" href="#concessionComment" data-toggle="tab">Total Salary Paid</a></li>
              {{-- <li class="nav-item"><a class="nav-link" href="#promotionComment" data-toggle="tab">Promotion Comments</a> --}}
               

              </li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post clearfix commentbox">
                  <table class="table table-responsive-sme">
                    <thead>
                      <tr>
                        <th>Allowance</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody id="allowncebody">

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="timeline">
                <table id="PaidFeesTable" class="table table-responsive-sm">
                  <thead>
                    <tr>
                      <th>Deduction</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="deductionbody">
                  </tbody>
                </table>
              </div>

              <div class="tab-pane" id="settings">
                <table id="PaidFeesTable" class="table table-responsive-sm">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Debit Amount</th>
                    </tr>
                  </thead>
                  <tbody id="advancesalarybody">
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="concessionComment">
                <table id="PaidFeesTable" class="table table-responsive-sm">
                  <thead>
                    <tr>
                      <th>Paid Amount</th>
                      <th id="salarybox"></th>
                    </tr>
                  </thead>
                  <tbody id="allPaidSalaryBody">
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="promotionComment">
                <div class="form-group row">
                  <table class="table table-responsive-sm">
                    <tbody id="promotionCommentTable"></tbody>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<script>
  var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
  $(document).ready(function(){
    var localdata = localStorage.getItem('studentid');
    if(localdata){
      $("#stdid").val(localdata);
      let stdid = $("#basic-addon1").html() + $("#stdid").val();
      LoadSfaffInfo(stdid);
      LoadAllowances(stdid);
      LoadStudentComment(stdid);
      localStorage.removeItem("studentid");
    }
    // alert(localdata);
    $("#searchStaffProfile").submit(function () {
      let stdid = $("#stdid").val();
      LoadSfaffInfo(stdid);
      LoadAllowances(stdid);
      LoadAdvanceSalary(stdid);
      TotalSalaryPaid(stdid);
      // LoadConsessionComments(stdid);
    });
  });




function LoadSfaffInfo(stdid) {
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
  $.ajax({
    dataType: "json",
    url: "{{ route('adminbackend.LoadStaffInfo') }}",
    method: 'post',
    data: {stdid: stdid},
    success: function(d) {
      feesheads = JSON.parse(d);
      if(feesheads.length < 1){
          swal('Warning', 'No record found with this id.', 'warning');
          return;
        }
      // console.log(feesheads);
      $("#studentName").html(feesheads[0].adminname + "<a href='/admin/NewAdmissionEdit/" + stdid + "'>(Edit)</a>");
      $("#fatherName").html("Father : " + feesheads[0].fname);
      $("#idcard").html(feesheads[0].cnic);
      $("#section").html(feesheads[0].gender);
      $("#formb").html(feesheads[0].email);
      $("#fcnic").html(feesheads[0].address1);
      $("#student_status").html(feesheads[0].isactive ? "Active" : "Not Active");
      $(".address1").html(feesheads[0].scalename);
      $(".contact").html(feesheads[0].phone1);
      $(".bps").html(feesheads[0].basicpay);
      
      let path = "{{ asset('profilepicture/')}}";
      if(feesheads[0].profile_photo_path){
        $("#profilePicture").attr("src", path + "/" + feesheads[0].profile_photo_path);
      }else{
        $("#profilePicture").attr("src", "{{ asset('userbackend/dist/img/AdminLTELogo.png') }}");
      }
      // $("#classIdd").val(feesheads[0].C_id);
      // $("#sectionIdd").val(feesheads[0].Sec_ID);
      // $("#studentIdd").val(feesheads[0].studentid);
    },
    error: function() {
    }
  });
}
function LoadAllowances(stdid) {
  var id = stdid;
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
  $.ajax({
    dataType: "json",
    url: "{{ route('admin.LoadStaffAllowances') }}",
    method: 'post',
    data: {stdid: id},
    success: function(d) {
      feesheads = JSON.parse(d);
      data = feesheads;
      var sum = 0;
      var deduction = 0;
      $("#allowncebody").empty();
      $("#deductionbody").empty();
      var j = 1;
      for (i = 0; i < data.length; i++) {
        if(data[i].type == 'PLUS'){
          sum += parseInt(data[i].staffwiseamount);
          $('#allowncebody').append('<tr>' +
            '<td>' + data[i].name + '</td>' +
            '<td>' + data[i].staffwiseamount + '</td>' +
            '</tr>');
          j++;
        }
        else{
          deduction += parseInt(data[i].staffwiseamount);
          $('#deductionbody').append('<tr>' +
            '<td>' + data[i].name + '</td>' +
            '<td>' + data[i].staffwiseamount + '</td>' +
            '</tr>');
            j++;
          }
        }
        $('#allowncebody').append('<tr>' +
          '<td colspan=""><b>Total</b></td>' +
          '<td><b>' + sum + '</b></td>' + '</tr>');
          $('#deductionbody').append('<tr>' +
            '<td colspan=""><b>Total</b></td>' +
            '<td><b>' + deduction + '</b></td>' + '</tr>');
          },
    error: function() {
    }
  });
}
function LoadAdvanceSalary(stdid) {
  var id = stdid;
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
  $.ajax({
    dataType: "json",
    url: "{{ route('admin.LoadAdvanceSalary') }}",
    method: 'post',
    data: {stdid: id},
    success: function(d) {
      advancesalary = JSON.parse(d);
      let sum = 0;
      var deduction = 0;
      $("#advancesalarybody").empty();
      $("#advancesalarybody").empty();
      var j = 1;
      for (i = 0; i < advancesalary.length; i++) {
          sum += parseInt(advancesalary[i].debitamount);
          $('#advancesalarybody').append('<tr>' +
            '<td>' + advancesalary[i].date + '</td>' +
            '<td>' + advancesalary[i].debitamount + '</td>' +
            '</tr>');
          j++;
        }
        $('#advancesalarybody').append('<tr>' +
            '<td colspan=""><b>Total</b></td>' +
            '<td><b>' + sum + '</b></td>' + '</tr>');
          },
    error: function() {
    }
  });
}
function TotalSalaryPaid(stdid) {
  var id = stdid;
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
  $.ajax({
    dataType: "json",
    url: "{{ route('admin.TotalSalaryPaid') }}",
    method: 'post',
    data: {stdid: id},
    success: function(d) {
      paidsalary = JSON.parse(d);
      let sum = 0;
      for (i = 0; i < paidsalary.length; i++) {
          sum += parseInt(paidsalary[i].debitamount);
        }
        $('#salarybox').html(sum);
          },
    error: function() {
    }
  });
}

</script>

@endsection