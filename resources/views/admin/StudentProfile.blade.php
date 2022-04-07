@extends('admin.admin_master')
@section('Admindata')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-3">
        <h1>Profile</h1>
      </div>
      <?php 
        $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
      ?>
      <div class="col-sm-4">
        <form onsubmit="return false" id="searchStudentProfile">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">{{$campus->CampusPrefix}}</span>
            </div>
            <input type="text" id="stdid" name="stdid" class="form-control" placeholder="Enter students roll no."
              aria-label="Username" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
      <div class="col-sm-1">
        <button type="submit" class="btn btn-primary btn-block" form="searchStudentProfile">Search</button>
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
                <b>Class</b> <a class="float-right" id="class">Class 22</a>
              </li>
              <li class="list-group-item">
                <b>Section</b> <a class="float-right" id="section">Section AA</a>
              </li>
              <li class="list-group-item">
                <b>Form B</b> <a class="float-right" id="formb">1730112345679</a>
              </li>
              <li class="list-group-item">
                <b>Father CNIC</b> <a class="float-right" id="fcnic">1730112345679</a>
              </li>
              <li class="list-group-item">
                <b>Bus Status</b> <a class="float-right" id="busstatus">123</a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b id="student_status">---</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">About</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-book mr-1"></i>Contact(s)</strong>

            <p class="text-muted contact">
              0321-1234567
            </p>

            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

            <p class="text-muted address1"> Some address</p>

            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Remarks</strong>

            <p class="text-muted remarks"></p>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Comments</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Remaining Fees</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Sibling Search</a></li>
              <li class="nav-item"><a class="nav-link" href="#concessionComment" data-toggle="tab">Concession
                  Comments</a></li>
              {{-- <li class="nav-item"><a class="nav-link" href="#promotionComment" data-toggle="tab">Promotion Comments</a> --}}
              <li class="nav-item"><a class="nav-link" href="#SLC" data-toggle="tab">SLC Status</a>
              </li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post clearfix commentbox">
                </div>
                <p>Comments about student</p>
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
                    <label for="inputName" class="col-sm-5 col-form-label">Search siblings by father CNIC</label>
                    <div class="col-sm-5">
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
              <div class="tab-pane" id="SLC">
                <div class="form-group row">
                  <table class="table table-responsive-sm">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="SLCTable"></tbody>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<script src="{{ asset('userbackend/plugins/axios/axios.min.js') }}"></script>
<script>
  var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
  $(document).ready(function(){
    var localdata = localStorage.getItem('studentid');
    if(localdata){
      $("#stdid").val(localdata);
      let stdid = $("#basic-addon1").html() + $("#stdid").val();
      LoadStudentInfo(stdid);
      LoadStudentFees(stdid);
      LoadStudentComment(stdid);
      // CheckSLCStatus(stdid);
      localStorage.removeItem("studentid");
    }
    // alert(localdata);
    $("#searchStudentProfile").submit(function () {
      let stdid = $("#basic-addon1").html() + $("#stdid").val();
      LoadStudentInfo(stdid);
      LoadStudentFees(stdid);
      LoadStudentComment(stdid);
      LoadPromotionComments(stdid);
      LoadConsessionComments(stdid);
      CheckSLCStatus(stdid);
    });
  });

  function deActiveStatus(stdid, id){
    swal('Confirm', "Are you shure to cancel this certificate?", 'info')
    .then(res => {
      if(res){
        axios.post('/admin/CancelCertificate', {stdid: stdid, id: id})
        .then(res => {
          swal("Cancelled", "SLC cancelled successfully.", 'success');
          CheckSLCStatus(stdid);
        })
      }
    })
  }

  function CheckSLCStatus(stdid){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.CheckSLCStatus') }}",
      method: 'POST',
      data: {stdid: stdid},
      success: function(d) {
        d = JSON.parse(d);
        if(d){
          let html = "";
          for(let i = 0; i < d.length; i++){
            html += '<tr>'+
              '<td>'+d[i].slcno+'</td><td>'+ d[i].leavingdate +'</td><td>' + (d[i].type == "SLC" ? "Certificate issued" : "Cancelled") + '</td><td><button class="btn btn-danger btn-sm" ' + (d[i].type=="SLC" ? 'onclick=deActiveStatus("'+d[i].studentid+'",'+ d[i].id +')' : "") + '>'+ (d[i].type=="SLC" ? 'Cancel' : "Cancelled") +'</button></td></tr>'
          }
          $("#SLCTable").html(html);
        }else{
          $("#SLCTable").empty();
        }
      },
      error: function() {
      }
    });
  }

  function LoadConsessionComments(stdid){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewConsessionComments') }}",
      method: 'POST',
      data: {stdid: stdid},
      success: function(d) {
        $("#concessionCommentTable").empty();
        result = JSON.parse(d);
        for (i = 0; i < result.length; ++i) {
          $('#concessionCommentTable').append('<tr>' +
          '<td>' + result[i].comment + '</td>' +
          '</tr>');
        }
      },
      error: function() {
      }
    });
  }

  function LoadPromotionComments(id){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewPromotionComments') }}",
      method: 'POST',
      data: {stdid: id},
      success: function(d) {
        $("#promotionCommentTable").empty();
        result = JSON.parse(d);
        for (i = 0; i < result.length; ++i) {
          $('#promotionCommentTable').append('<tr>' +
          '<td>' + result[i].type + '</td>' +
          '</tr>');
        }
      },
      error: function() {
      }
    });
  }

$("#studentCommentForm").submit(function (e) { 
  e.preventDefault();
  let des = $("#StudentComment").val();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });
  $.ajax({
    dataType: "json",
    url: "{{ route('admin.StoreStudentsComment') }}",
    method: 'POST',
    data: $("#studentCommentForm").serialize(),
    success: function(d) {
      swal("Good job!", "Comment successfully added!", "success");
      $("#StudentComment").val("");
      let stdid = $("#basic-addon1").html() + $("#stdid").val();
      LoadStudentComment(stdid);
    },
    error: function() {
    }
  });
});

$("#fetchStudentsRelatives").submit(function (e) { 
  e.preventDefault();
  let fatherCNIC = $("#fatherCNIC").val();
  let stdid = $("#basic-addon1").html() + $("#stdid").val();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });
  $.ajax({
    dataType: "json",
    url: "{{ route('adminbackend.RelativesData') }}",
    method: 'post',
    data: {fatherCNIC: fatherCNIC},
    success: function(d) {
      data = JSON.parse(d);
      $("#retlativeData").empty();
      for (i = 0; i < data.length; ++i) {
        $('#retlativeData').append('<tr>' +
          '<td>' + data[i].studentid + '</td>' +
          '<td>' + data[i].studentname + '</td>' +
          '<td>' + data[i].ClassName + '</td>' +
          '<td>' + data[i].SectionName + '</td>' +
          '<td>' + data[i].summ + '</td>' +
          '</tr>');
      }
    },
    error: function() {
    }
  });
});

function LoadStudentInfo(stdid) {
  var id = stdid;
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
  $.ajax({
    dataType: "json",
    url: "{{ route('adminbackend.LoadStudenInfo') }}",
    method: 'post',
    data: {stdid: id},
    success: function(d) {
      feesheads = JSON.parse(d);
      if(feesheads.length < 1){
          swal('Warning', 'No record found with this id.', 'warning');
          return;
        }
      // console.log(feesheads);
      $("#studentName").html(feesheads[0].studentname + "<a href='/admin/NewAdmissionEdit/" + stdid + "'>(Edit)</a>");
      $("#fatherName").html("Father : " + feesheads[0].fathername);
      $("#class").html(feesheads[0].ClassName);
      $("#section").html(feesheads[0].SectionName);
      $("#formb").html(feesheads[0].formb);
      $("#fcnic").html(feesheads[0].cnic);
      $("#busstatus").html(feesheads[0].busnumber);
      $("#student_status").html(feesheads[0].status);
      $(".address1").html(feesheads[0].address1);
      $(".contact").html(feesheads[0].fathercontact);
      $(".remarks").html(feesheads[0].admissionremarks);

      let path = "{{ asset('studentprofilepicture/')}}";
      if(feesheads[0].picturepath){
        $("#profilePicture").attr("src", path + "/" + feesheads[0].picturepath);
      }else{
        $("#profilePicture").attr("src", "{{ asset('userbackend/dist/img/AdminLTELogo.png') }}");
      }

      $("#classIdd").val(feesheads[0].C_id);
      $("#sectionIdd").val(feesheads[0].Sec_ID);
      $("#studentIdd").val(feesheads[0].studentid);
    },
    error: function() {
    }
  });
}
function LoadStudentFees(stdid) {
  var id = stdid;
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
      var sum = 0;
      $("#allStudentsBody").empty();
      var j = 1;
      for (i = 0; i < data.unpaid.length; ++i) {
        sum += parseInt(data.unpaid[i].amount);
        $('#allStudentsBody').append('<tr>' +
          '<td>' + j + '</td>' +
          '<td>' + data.unpaid[i].subhead + '</td>' +
          '<td>' + months[data.unpaid[i].month - 1] + " " + data.unpaid[i].year + '</td>' +
          '<td>' + data.unpaid[i].amount + '</td>' +
          '</tr>');
        j++;
      }
      $('#allStudentsBody').append('<tr>' +
          '<td colspan="3">Total</td>' +
          '<td>' + sum + '</td>' + '</tr>');
    },
    error: function() {
    }
  });
}
function LoadStudentComment(stdid){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });

  $.ajax({
    dataType: "json",
    url: "{{ route('admin.LoadStudentComment') }}",
    method: 'post',
    data: {stdid: stdid},
    success: function(d) {
      data = JSON.parse(d);
      $(".commentbox").empty();
      for (i = 0; i < data.length; ++i) {
        const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
        let firstDate = data[i].date;
        let today = new Date().toISOString().slice(0, 10);
        firstDate = new Date(firstDate);
        today = new Date(today);
        const diffDays = Math.round(Math.abs((firstDate - today) / oneDay));
        $(".commentbox").append(`
          <div class="user-block">
            <small><span class="">Date : ` + data[i].date + ` - ` + diffDays + ` day(s) before </span></small>
          </div>
          <!-- /.user-block -->
          <p> <b>` + data[i].description + `</b></p><hr>
          `);
      }
    },
    error: function() {
    }
  });
}

</script>

@endsection