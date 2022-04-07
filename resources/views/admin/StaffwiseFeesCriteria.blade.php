@extends('admin.admin_master')

@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Set Staffwise Allowances Criteria<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="row">
          <div class="col-md">
            <form id="StaffWiseFeeCriteriaForm" onsubmit="return false" method="POST">
              <div class="row align-items-center  ">
                <div class="col-md-4" style="display: none">
                  <label for="staffwisefeeid" class="form-label"><b></b></label>
                  <input type="text" class="form-control form-control-sm" id="staffwisefeeid" name="staffwisefeeid"
                    placeholder="">
                </div>
                <div class="col-md-12">
                  <?php
                    $campusid = Auth::user()->campusid;
                    $employees = \App\Models\Admin::where('campusid', $campusid)->get();
                    $allowances = \App\Models\Allowance::where('campusid', $campusid)->get();
                    $subheads = \App\Models\FeeSubHead::where('campusid',$campusid)->get();
                    $sessions = \App\Models\academicsessions::where('CampusID',$campusid )->where('IsActive', '1')->where("IsCurrent", '1')->get();
                  ?>
                  <label for="employeeid" class="form-label"><b>Employee</b></label>
                  {{-- {{dd($employees)}} --}}
                  <select style="width: 100%" class="form-control form-control-sm select2" id="employeeid" required
                    name="employeeid" placeholder="">
                    <option value="">Choose employee</option>
                    @foreach ($employees as $employee)
                    <?php 
                      $scale = \App\Models\Scale::where('campusid', Auth::user()->campusid)->where('id', $employee->scaleid)->value('name');
                    ?>
                    <option value="{{ $employee->id }}">{{ $employee->name . " - " . $employee->fname}} - {{ $scale }}
                    </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <?php
                    $sss = \App\Models\Scholarship::where('campusid',$campusid)->get();
                    $subheads = \App\Models\FeeSubHead::where('campusid',$campusid)->get();
                  ?>
                  <label for="allowanceid" class="form-label"><b>Allowance</b></label>
                  {{-- {{dd($allowances)}} --}}
                  <select class="form-control form-control-sm" id="allowanceid" required name="allowanceid"
                    placeholder="">
                    <option value="">Choose allowance</option>
                    @foreach ($allowances as $allowance)
                    <?php 
                      $scale = \App\Models\Scale::where('campusid', Auth::user()->campusid)->where('id', $allowance->scaleid)->value('name');
                    ?>
                    <?php
                      $sesssion = \App\Models\academicsessions::where('campusid', $campusid)
                      ->where('id', $allowance->scaleid)->where('IsActive', 1)->where('IsCurrent', 1)->value('id');
                      if($sesssion != $allowance->sessionid)
                        continue;
                    ?>
                    <option value="{{ $allowance->id }}">{{ $allowance->name }} - {{ $scale }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="amount" class="form-label"><b>Amount</b></label>
                  <input type="number" class="form-control form-control-sm" id="amount" required name="amount"
                    placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="type" class="form-label"><b>Type</b></label>
                  <select class="form-control form-control-sm" id="type" required name="type" placeholder="">
                    <option value="PLUS">Allowance</option>
                    <option value="MINUS">Deduction</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <label for="date" class="form-label"><b>Date</b></label>
                  <input type="date" value="{{ date('Y-m-d') }}" class="form-control form-control-sm" id="date" required
                    name="date" placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="description" class="form-label"><b>Description</b></label>
                  <input type="text" class="form-control form-control-sm" id="description" required name="description"
                    placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="isactive" class="form-label"><b>Is Active</b></label>
                  <select class="form-control form-control-sm" id="isactive" required name="isactive" placeholder="">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>
              </div>

              <div class="row align-items-center  pt-3 pb-3">
                <div class="col-md-12">
                  <input name="submit" id="addstaffwisefeecriteria" class="btn btn-sm btn-primary btn-block"
                    type="submit" value="Save">
                </div>
                <div class="col-md-12">
                  <input type="submit" style="display:none" id="updateSWSH" class="btn btn-sm btn-success btn-block"
                    value="Update">
                  <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                </div>
              </div>


            </form>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Staff Wise Fee Criterias</h4>
            <table id="StaffewiseFeesCriteria" class="table table-hover table-responsive-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th class="select-filter">Employee</th>
                  <th class="select-filter">Allowance</th>
                  <th>Amount</th>
                  <th>Is Active</th>
                  <th>Description</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th></th>
                  <!-- <th>SubCat_name</th> -->
                </tr>
              </thead>
              <tbody id="StaffewiseFeesCriteriaBody">
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

  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Advance Salary<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="row">
          <div class="col-md">
            <form id="advanceSalaryForm" onsubmit="return false" method="POST">
              <div class="row align-items-center  ">
                <div class="col-md-4" style="display: none">
                  <label for="advancesalaryid" class="form-label"><b></b></label>
                  <input type="text" class="form-control form-control-sm" id="advancesalaryid" name="advancesalaryid"
                    placeholder="">
                </div>
                <div class="col-md-12">
                  <label for="employeeidadvancesalary" class="form-label"><b>Employee</b></label>
                  <select style="width: 100%" class="form-control form-control-sm select2" id="employeeidadvancesalary"
                    required name="employeeidadvancesalary" placeholder="">
                    <option value="">Choose employee</option>
                    @foreach ($employees as $employee)
                    <?php 
                      $scale = \App\Models\Scale::where('campusid', Auth::user()->campusid)->where('id', $employee->scaleid)->value('name');
                    ?>
                    <option value="{{ $employee->id }}">{{ $employee->name . " - " . $employee->fname}} - {{$scale}}
                    </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="advancesalarydate" class="form-label"><b>Date</b></label>
                  <input type="date" value="{{ date('Y-m-d') }}" class="form-control form-control-sm"
                    id="advancesalarydate" required name="advancesalarydate" placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="debitamount" class="form-label"><b>Debit Amount</b></label>
                  <input type="number" onchange="checkRestrinction()" class="form-control form-control-sm"
                    id="debitamount" required name="debitamount" placeholder="">
                </div>
                <div class="col-md-4">
                  <label for="status" class="form-label"><b>Status</b></label>
                  <select class="form-control form-control-sm" id="status" required name="status" placeholder="">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>
              </div>

              <div class="row align-items-center  pt-3 pb-3">
                <div class="col-md-12">
                  <input name="submit" id="saveAdvanceSalary" class="btn btn-sm btn-primary btn-block" type="submit"
                    value="Save">
                </div>
                <div class="col-md-12">
                  <input type="submit" style="display:none" id="updateAdvanceSalary"
                    class="btn btn-sm btn-success btn-block" value="Update">
                  <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbbtn"
                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                </div>
              </div>


            </form>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Advance Salaries</h4>
            <table id="advanceSalaryTable" class="table table-hover table-responsive-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Emp Name</th>
                  <th>Debit Amount</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th></th>
                  <!-- <th>SubCat_name</th> -->
                </tr>
              </thead>
              <tbody id="advanceSalaryTableBody">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="card card-primary collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Staff Attendance<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="row">
          <div class="col-md">
            <form id="attendanceForm" onsubmit="return false" method="POST">
              <div class="row align-items-center  ">
                <div class="col-md-4" style="display: none">
                  <label for="attendanceId" class="form-label"><b></b></label>
                  <input type="text" class="form-control form-control-sm" id="attendanceId" name="attendanceId"
                    placeholder="">
                </div>
                <div class="col-md-12">
                  <label for="employeeidattendance" class="form-label"><b>Employee</b></label>
                  <select style="width: 100%" class="form-control form-control-sm select2" id="employeeidattendance"
                    required name="empid" placeholder="">
                    <option value="">Choose employee</option>
                    @foreach ($employees as $employee)
                    <?php 
                      $scale = \App\Models\Scale::where('campusid', Auth::user()->campusid)->where('id', $employee->scaleid)->value('name');
                    ?>
                    <option value="{{ $employee->id }}">{{ $employee->name . " - " . $employee->fname}} - {{$scale}}
                    </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="attendancedate" class="form-label"><b>Date</b></label>
                  <input type="date" value="{{ date('Y-m-d') }}" class="form-control form-control-sm"
                    id="attendancedate" required name="date" placeholder="">
                </div>
                <div class="col-md-6">
                  <label for="attendancedescription" class="form-label"><b>Description</b></label>
                  <input type="text" onchange="checkRestrinction()" class="form-control form-control-sm"
                    id="attendancedescription"  name="description" placeholder="">
                </div>
              </div>

              <div class="row align-items-center  pt-3 pb-3">
                <div class="col-md-12">
                  <input name="submit" id="saveattendance" class="btn btn-sm btn-primary btn-block" type="submit"
                    value="Save">
                </div>
                {{-- <div class="col-md-12">
                  <input type="submit" style="display:none" id="updateAdvanceSalary"
                    class="btn btn-sm btn-success btn-block" value="Update">
                  <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbbtn"
                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                </div> --}}
              </div>


            </form>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Staff Attendance</h4>
            <table id="staffAttendanceTable" class="table table-hover table-responsive-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Employee</th>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Action</th>
                  <!-- <th>SubCat_name</th> -->
                </tr>
              </thead>
              <tbody id="attendanceTableBody">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>



<script src="{{asset('userbackend/plugins/axios/axios.min.js')}}"></script>
<script>
  $("#attendanceForm").submit(()=>{
    axios.post('/admin/staffattendance', $("#attendanceForm").serialize())
    .then(res => {
      if(res.data == 'duplicate'){
        swal('Information', 'Attendance for this staff already exists', 'info');
      }else{
        swal('Success', 'Added successfully.', 'success');
        $("#attendanceForm").trigger('reset');
        LoadAttendance();
      }
    })
  })

  const LoadAttendance = () => {
    axios.get('/admin/staffattendance')
    .then(res => {
      let html = "";
      let j = 1;
      $("#staffAttendanceTable").DataTable().destroy();
      res.data.forEach((item, i) => {
        html += '<tr>' +
          '<td>' + j + '</td>' +
          '<td>' + item.name + '</td>' +
          '<td>' + item.date + '</td>' +
          '<td>' + item.description + '</td>' +
          '<td><span  style="color: red;" class="fas fa-trash-alt" onclick="DeleteAttendance(' + item.id + ')"></span></td>' +
          '</tr>';
        j++;
      });
      $("#attendanceTableBody").html(html);
      $("#staffAttendanceTable").DataTable();
    })
  }

  const DeleteAttendance = (id) => {
    swal('Shure ?', "Are you shure to delete this record ?", 'info')
    .then(deleteOrNot => {
      if(deleteOrNot){
        axios.delete(`/admin/staffattendance/${id}`)
        .then(res => {
          swal('Success', 'Deleted successfully.', 'success');
          LoadAttendance();
        })
      }
    })
  }

  function checkRestrinction() {
    if(!$("#employeeidadvancesalary").val()){
      return;
    }
    axios.post('/admin/ChechAdvanceSalry', $("#advanceSalaryForm").serialize())
    .then(res => {
      // console.log(res);
      if(res.data == 'larger'){
        swal("Error", "Employee cannot have take much salary", "error");
        $("#debitamount").val("");
      }
    })
    .catch(err => {

    })
  }
  function ResetFormByCancelKey(){
    $("#StaffWiseFeeCriteriaForm").trigger("reset");
    $('#updateSWSH').hide();
    $('#addstaffwisefeecriteria').show();
    $('#addstaffwisefeecriteria').prop('type', 'submit');
    $('#cancelbtn').hide();
    $("#employeeid").val("").trigger("change");

    $("#advanceSalaryForm").trigger("reset");
    $('#updateAdvanceSalary').hide();
    $('#saveAdvanceSalary').show();
    $('#saveAdvanceSalary').prop('type', 'submit');
    $('#cancelbbtn').hide();
    $("#employeeidadvancesalary").val("").trigger("change");
  }

  function EditRow(id, index){
    $("#updateSWSH").show();
    $("#addstaffwisefeecriteria").hide();
    $('#addstaffwisefeecriteria').prop('type', '');
    $('#updateSWSH').show();
    $('#cancelbtn').show();

    $("#staffwisefeeid").val(data[index].detailid);
    $("#employeeid").select2().val(data[index].empidd).trigger("change");
    // console.log(data[index].empidd);
    $("#allowanceid").val(data[index].allowanceid);
    $("#description").val(data[index].staffdesc);
    $("#isactive").val(data[index].staffisactive);
    $("#amount").val(data[index].detailamount);
    $("#type").val(data[index].stafftype);
    $("#date").val(data[index].detailsdate);
  }
  var data;
  $(document).ready(function() {
    $('#insertFeeHead').show();
    FetchSWSH();
    var dataa = '';
    LoadAttendance();

    $("#updateAdvanceSalary").click(function() {
      axios.put(`/admin/advanceSalary/${$("#advancesalaryid").val()}`, $("#advanceSalaryForm").serialize())
      .then(res => {
        FetchSWSH();
        swal("Good job!", "Record is successfully updated!", "success");
        $("#advanceSalaryForm").trigger("reset");
        $("#updateAdvanceSalary").hide();
        $("#saveAdvanceSalary").show();
        $('#saveAdvanceSalary').prop('type', 'submit');
        $('#cancelbbtn').hide();
        $("#employeeidadvancesalary").val("").trigger("change");
      });
      return;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateStaffwiseFeesCriteria') }}",
        method: 'POST',
        data: $("#StaffWiseFeeCriteriaForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Duplicate Entry", "Allowance already assigned.", "warning");
          }else{
            swal("Good job!", "Employee is successfully updated!", "success");
            $("#StaffWiseFeeCriteriaForm").trigger("reset");
            $("#employeeid").val("").trigger("change");
            $('#updateSWSH').hide();
            $('#addstaffwisefeecriteria').show();
            $('#addstaffwisefeecriteria').prop('type', 'submit');
            $('#cancelbtn').hide();
            FetchSWSH();
          }
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
          });
        }
      });
    });

    $("#updateSWSH").click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.UpdateStaffwiseFeesCriteria') }}",
        method: 'POST',
        data: $("#StaffWiseFeeCriteriaForm").serialize(),
        success: function(result) {
          if(result == 'duplicate'){
            swal("Duplicate Entry", "Allowance already assigned.", "warning");
          }else{
            swal("Good job!", "Employee is successfully updated!", "success");
            $("#StaffWiseFeeCriteriaForm").trigger("reset");
            $("#employeeid").val("").trigger("change");
            $('#updateSWSH').hide();
            $('#addstaffwisefeecriteria').show();
            $('#addstaffwisefeecriteria').prop('type', 'submit');
            $('#cancelbtn').hide();
            FetchSWSH();
          }
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
          });
        }
      });
    });

    $('#saveAdvanceSalary').click(function() {
      axios.post('/admin/ChechAdvanceSalry', $("#advanceSalaryForm").serialize())
      .then(res => {
        // console.log(res);
        if(res.data == 'larger'){
          swal("Error", "Employee cannot have take much salary", "error");
          $("#debitamount").val("");
          return;
        }else{
          axios.post('/admin/advanceSalary', $("#advanceSalaryForm").serialize()).
          then(function (response) {
            FetchSWSH();
            swal("Saved", "Record successfully added.", "success");
            $("#advanceSalaryForm").trigger("reset");
            $("#employeeidadvancesalary").val("").trigger("change");
            $("#employeeid").val("").trigger("change");
          })
          .catch(function (error) {
            console.log(error);
          });
        }
      })
      .catch(err => {

      })
    });

    $('#addstaffwisefeecriteria').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.StoreStaffwiseFeesCriteria') }}",
        method: 'POST',
        data: $("#StaffWiseFeeCriteriaForm").serialize(),
        success: function(result) {
          FetchSWSH();
          if(result == 'duplicate'){
            swal("Duplicate Entry", "Allowance already assigned.", "warning");
          }else{
          swal("Good job!", "Successfully assigned!", "success");
            $("#StaffWiseFeeCriteriaForm").trigger("reset");
            $("#employeeid").val("").trigger("change");
          }
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
          });
        }
      });
    });
  });

  var salaries = "";

  const EditAS = function(id, index){
    $("#updateAdvanceSalary").show();
    $("#saveAdvanceSalary").hide();
    $('#saveAdvanceSalary').prop('type', '');
    $('#cancelbbtn').show();

    $("#advancesalaryid").val(id);
    $("#employeeidadvancesalary").select2().val(salaries[index].empid).trigger("change");
    $("#debitamount").val(salaries[index].debitamount);
    $("#advancesalarydate").val(salaries[index].date);
    $("#status").val(salaries[index].status);
  }

  const DeleteAS = (id) => {
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this record!",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        axios.delete(`/admin/advanceSalary/${id}`)
          .then(res => {
            FetchSWSH();
            swal("Good job!", "Record is successfully deleted!", "success");
          })
          .catch((e => {

          }))
      }
    });
  };

  function FetchSWSH() {
    axios.get('/admin/advanceSalary')
    .then(function(data){
      salaries = JSON.parse(data.data)
      $("#advanceSalaryTable").DataTable().destroy();
      $("#advanceSalaryTableBody").empty();
      var j = 1;
      for (i = 0; i < salaries.length; ++i) {
        $('#advanceSalaryTableBody').append('<tr ondblclick="EditRow(' + salaries[i].salid + ', ' + i +')">' +
          '<td>' + j + '</td>' +
          '<td>' + salaries[i].name + '</td>' +
          '<td>' + salaries[i].debitamount + '</td>' +
          '<td>' + salaries[i].date + '</td>' +
          '<td>' + (salaries[i].status ? "Yes" : "No") + '</td>' +
          '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditAS(' + salaries[i].salid + "," + i + ')"></i></a> | <span  style="color: red;" class="fas fa-trash-alt" onclick="DeleteAS(' + salaries[i].salid + "," + i + ')"></span></td>' +
          '</tr>');
        j++;
      }
      $("#advanceSalaryTable").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
      });
    })
    .catch();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      type: "POST",
      url: "{{ route('admin.ViewStaffWiseFeeCriteria') }}",
      success: function(d) {
        SWfeesheads = JSON.parse(d);
        $("#StaffewiseFeesCriteria").DataTable().destroy();
        $("#StaffewiseFeesCriteriaBody").empty();
        data = SWfeesheads;
        var j = 1;
        for (i = 0; i < SWfeesheads.length; ++i) {
          $('#StaffewiseFeesCriteriaBody').append('<tr ondblclick="EditRow(' + SWfeesheads[i].detailid + ', ' + i +')">' +
            '<td>' + j + '</td>' +
            '<td>' + SWfeesheads[i].empname + '</td>' +
            '<td>' + SWfeesheads[i].allowancename + ' - ' + SWfeesheads[i].Session + '</td>' +
            '<td>' + SWfeesheads[i].detailamount + '</td>' +
            '<td>' + (SWfeesheads[i].staffisactive ? "Yes" : "No") + '</td>' +
            '<td>' + SWfeesheads[i].staffdesc + '</td>' +
            '<td>' + SWfeesheads[i].stafftype + '</td>' +
            '<td>' + SWfeesheads[i].detailsdate + '</td>' +
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>' +
            '</tr>');
          j++;
        }
        // $("#StaffewiseFeesCriteria").DataTable();
        $('#StaffewiseFeesCriteria').DataTable( {
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
      } );
      },
      error: function() {
      }
    });
  }
</script>




@endsection
