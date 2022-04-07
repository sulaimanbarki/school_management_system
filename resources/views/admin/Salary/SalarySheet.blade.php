@extends('admin.admin_master')
@section('Admindata')
{{-- {{
$name = Route::currentRouteName();
}} --}}
<div class="row">
  <div class="container-fluid pl-1 pr-1 pt-2 pb-2">
    <?php
    $campusid=Auth::user()->campusid;
    $campus = \App\Models\addCampus::where('campusid',$campusid)->first();
    $month=date('m');
    $year=date('Y');
    if(isset($request)){
      $month = date("m",strtotime($request->date));
      $year = date("Y",strtotime($request->date));
    }
    $AllStaffData = DB::select("
    SELECT  n.empid,a.name as empname,a.departmentid, d.title,n.campusid,n.eobiamount,n.basicpay,sum(n.allowanceamount) as allowanceamount,
    n.deductionamount,n.basicpay
    ,n.grosssalary,n.netsalary,n.year,n.month,n.leaveamount
    FROM net_salaries n, admins a,scales sc,departments d where  d.id=a.departmentid
    and d.campusid=a.campusid and n.empid=a.id and a.campusid=n.campusid and
    sc.campusid=n.campusid and a.scaleid=sc.id and a.campusid=? and a.isactive=1 and month=? and year=?
    group by n.empid,year,month;
    ",[$campusid,$month,$year]);
            // print_r($AllStaffData);


        // dd($month);

    ?>




    <div class="row pt-1 pb-1">
      <div class="col-md-6">
        {{-- <form id="searchForm" action="#" onsubmit="return false"> --}}
          <form id="myfrom" method="post" action="/admin/NetSalarySheet">
            @csrf
            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" @if (isset($request)) value="{{ $request->date }}" @else value="{{ date('Y-m-d') }}"
                @endif class="form-control form-control-sm" id="date" name="date">
            </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="search">Search</label>
          <input type="submit" formaction="/admin/NetSalarySheet"
            class="form-control bg-primary text-white form-control-sm" id="search" name="search">
        </div>
        </form>
      </div>
    </div>
    <div class="row  pt-1 pb-1">
      <div class="table-responsive col-md-12 ">
        <table id="allStudents" class="table table-responsive-sm">
          <thead>
            <tr>
              <th>EmpId</th>
              <th>Name</th>
              <th>Department</th>
              <th>Basic Pay.</th>
              <th>All. Am.</th>
              <th>Gross</th>
              <th>Ded. Am.</th>
              <th>leaveamount</th>
              <th>EOBI</th>
              <th>Net</th>
              <th>Paid</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="allStudentsBody">
            <?php
            foreach($AllStaffData as $student){
              $empid=$student->empid;
              $val = DB::select("
              SELECT sum(debitamount) as debitamount FROM `advance_salaries`
              WHERE YEAR(date) =? AND MONTH(`date`) = ? and empid = ?
              and campusid = ?
              ", [$year, $month,$empid, Auth::user()->campusid]);
                $advancePaid = (int)$val[0]->debitamount;
            ?>
            <tr>
              <td>{{ $student->empid }}</td>
              <td>{{ $student->empname }}</td>
              <td>{{ $student->title }}</td>
              <td>{{ $student->basicpay }}</td>
              <td onclick="AllowancesAmount({{ $student->empid }}, 1)"><a href="#">{{ $student->allowanceamount }}</a>
              </td>
              <td>{{ $student->grosssalary }}</td>
              <td onclick="AllowancesAmount({{ $student->empid }}, 0)"><a href="#">{{ $student->deductionamount }}</a>
              </td>
              <td>{{ $student->eobiamount }}</td>
              <td>{{ $student->leaveamount }}</td>
              <td>{{ $student->netsalary }}</td>
              <td>{{ $advancePaid }}</td>
              <td>
                @if ($student->netsalary > $advancePaid)
                <button type="button" class="btn btn-primary btn-xs text-white" data-backdrop="" data-toggle="modal"
                  onclick="payBalance('{{$student->empid}}', {{ $student->netsalary - $advancePaid }})"
                  data-target="#small-Modal">Pay Salary</button>
              </td>
              @else
              <span style="color:blue">Already paid!</span>
              @endif
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Allowances</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <th>Allowance</th>
            <th>Amount</th>
          </thead>
          <tbody id="allowanceModalBody">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="DeductionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deduction Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <th>Deductions</th>
            <th>Amount</th>
          </thead>
          <tbody id="deductionModalBody">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<input class="d-none" type="date" name="" id="currentdate" @if (isset($request)) value="{{ $request->date }}" @else
  value="{{ date('Y-m-d') }}" @endif>


<script src="{{ asset('userbackend/plugins/axios/axios.min.js')}}"></script>
<script>
  var months = [ "January", "February", "March", "April", "May", "June",
          "July", "August", "September", "October", "November", "December" ];
  $(document).ready(function() {

});

  const payBalance = (id, amount) => {
    swal({
      title: "Shure ?",
      text: "Are you sure to pay this?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        axios.post('/admin/advanceSalary', {employeeidadvancesalary: id, debitamount: amount, status: 1, advancesalarydate: $("#currentdate").val()}).
          then(function (response) {
            swal("Saved", "Successfully paid.", "success");
            setTimeout(() => {
              $("#myfrom").submit();
            }, 1000);
          })
          .catch(function (error) {
            console.log(error);
          });
      }
  });
  }
  const AllowancesAmount = (id, type) => {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.FetchStaffDeductionsAndAllowances') }}",
      method: 'post',
      data: {staffid: id, date: $("#date").val()},
      success: function(d) {
        //   alert(d);
        // console.log(d);
        let allowances = JSON.parse(d);
        $('#allowanceModalBody').empty();
        $('#deductionModalBody').empty();

        for(let i = 0; i < allowances.length; i++){
          if(allowances[i].type === 'PLUS'){
            $('#allowanceModalBody').append('<tr>' +
              '<td>' + allowances[i].name + '</td>' +
              '<td>' + allowances[i].allowanceamount + '</td>' +
            '</tr>');
            console.log(allowances[i].name, allowances[i].allowanceamount);
          }else{
            $('#deductionModalBody').append('<tr>' +
              '<td>' + allowances[i].name + '</td>' +
              '<td>' + allowances[i].allowanceamount + '</td>' +
            '</tr>');
          }
        }
        if(type == 1)
          $('#exampleModal').modal('show');
        else
          $('#DeductionModal').modal('show');

      },
      error: function() {
      }
    });
  }

  $("#searchForm").submit(() => {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

    $.ajax({
      dataType: "json",
      url: "{{ route('admin.FetchStaffSalaries') }}",
      method: 'post',
      data: $("#searchForm").serialize(),
      success: function(d) {
        staff = JSON.parse(d);
        // console.log(feesheads);
        // $("#allStudents").DataTable().destroy();
        var sum = 0;
        $("#allStudentsBody").empty();
        var j = 1;
        for (i = 0; i < staff.length; ++i) {
          $('#allStudentsBody').append('<tr>' +
              '<td >' + staff[i].empid + '</td>' +
              '<td >' + staff[i].empname + '</td>' +
              '<td >' + staff[i].title + '</td>' +
              '<td >' + staff[i].basicpay + '</td>' +
              '<td onclick="AllowancesAmount(' + staff[i].empid + ', 1)"><a href="#">' + staff[i].allowanceamount + '</a></td>' +
              '<td >' + staff[i].grosssalary + '</td>' +
              '<td onclick="AllowancesAmount(' + staff[i].empid + ', 0)"><a href="#">' + staff[i].deductionamount + '</a></td>' +
              '<td >' + staff[i].leaveamount + '</td>' +
              '<td >' + staff[i].eobiamount + '</td>' +
              '<td >' + staff[i].netsalary + '</td>' +
            '</tr>');
          j++;
        }
      },
      error: function() {
      }
    });
  });




</script>



@endsection