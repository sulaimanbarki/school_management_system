@extends('admin.admin_master')

@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Set Student Wise Fees Criterias<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      {{-- <div class="card-body collapse in"> --}}
      <div class="card-body">
        <div class="row">
          <div class="col-md">
            <form id="ScholarshipWSHForm" onsubmit="return false" method="POST" enctype="multipart/form-data">
              <div class="row align-items-center  ">
                <div class="col-md-4" style="display: none">
                  <label for="swfhid" class="form-label"><b>Scholarship wise fee head</b></label>
                  <input type="text" class="form-control form-control-sm" id="swfhid" name="swfhid" placeholder="">
                </div>
                <div class="col-md-12">
                  <?php
                  $campusid = Auth::user()->campusid;
                    $sss = \App\Models\Scholarship::where('campusid',$campusid)->get();
                    $subheads = \App\Models\FeeSubHead::where('campusid',$campusid)->get();
                    $students = \App\Models\StudentInfo::where('campusid',$campusid)->where('status', '!=', 'Slc')->get();
                    $sessions = \App\Models\academicsessions::where('CampusID',$campusid )->where('IsActive', '1')->where("IsCurrent", '1')->get();
                  ?>
                  <label for="studentid" class="form-label"><b>Student</b></label>
                  <select style="width: 100%" class="form-control form-control-sm select2" id="studentid" required
                    name="studentid" placeholder="">
                    <option value="">Choose Student</option>
                    @foreach ($students as $student)
                    <option value="{{ $student->studentid }}">{{ $student->studentid . " " . $student->studentname}}
                    </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <?php
                    $sss = \App\Models\Scholarship::where('campusid',$campusid)->get();
                    $subheads = \App\Models\FeeSubHead::where('campusid',$campusid)->get();
                  ?>
                  <label for="subheadid" class="form-label"><b>Scholarship Wise Sub head</b></label>
                  <select class="form-control form-control-sm" id="subheadid" required name="subheadid" placeholder="">
                    <option value="">Choose subhead</option>
                    @foreach ($subheads as $subhead)
                    <option value="{{ $subhead->id }}">{{ $subhead->subhead }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="issuedate" class="form-label"><b>Issue Date</b></label>
                  <input type="date" class="form-control form-control-sm" id="issuedate" required name="issuedate"
                    placeholder="">
                </div>
                <div class="col-md-3">
                  <label for="lastdate" class="form-label"><b>Expiry Date</b></label>
                  <input type="date" class="form-control form-control-sm" id="lastdate" required name="lastdate"
                    placeholder="">
                </div>
                <div class="col-md-2">
                  <label for="amount" class="form-label"><b>Amount in %</b></label>
                  <input type="number" min=1 max=100 class="form-control form-control-sm" id="amount" required
                    name="amount" placeholder="">
                </div>
              </div>

              <div class="row align-items-center  ">
                <div class="col-md-3">
                  <label for="academicsession" class="form-label"><b>Academic Session</b></label>
                  <select class="form-control form-control-sm" id="academicsession" required name="academicsession"
                    placeholder="">
                    <option value="">Choose session</option>
                    @foreach ($sessions as $session)
                    <option @if ($session->IsCurrent)
                      {{ "selected" }}
                    @endif value="{{ $session->id }}">{{ $session->Session }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="scholarshipid" class="form-label"><b>Scholarship</b></label>
                  <select class="form-control form-control-sm" id="scholarshipid" required name="scholarshipid"
                    placeholder="">
                    <option value="">Choose scholarship</option>
                    @foreach ($sss as $ss)
                    <option value="{{ $ss->id }}">{{ $ss->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="isactive" class="form-label"><b>Is Active</b></label>
                  <select class="form-control form-control-sm" id="isactive" required name="isactive" placeholder="">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="SWsequence" class="form-label"><b>Sequence</b></label>
                  <input type="number" min="1" max="20" class="form-control form-control-sm" id="SWsequence" required
                    name="SWsequence" placeholder="">
                </div>
              </div>
              <div class="row align-items-center  pt-3 pb-3">
                <div class="col-md-12">
                  <input name="submit" id="addSWSH" class="btn btn-sm btn-primary btn-block" type="submit" value="Save">
                </div>
                <div class="col-md-12">
                  <input type="submit" name="submit" style="display:none" id="updateSWSH"
                    class="btn btn-sm btn-success btn-block" value="Update">
                </div>
              </div>


            </form>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <h4>Student Wise Fee Criterias</h4>
            <table id="SubheadTable" class="table table-hover table-responsive-sm">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Student</th>
                  <th>Amount %</th>
                  <th>Subhead</th>
                  <th>Scholarship</th>
                  <th>Session</th>
                  <th>Sequence</th>
                  <th>Is Active</th>
                  <th>Issue</th>
                  <th>Expires</th>
                  <!-- <th>SubCat_name</th> -->
                </tr>
              </thead>
              <tbody id="SWFeesHead">
              </tbody>
            </table>
          </div>
        </div>
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
        <h5 class="modal-title" id="exampleModalLabel">School Leaving Certificate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" onsubmit="return false" id="slcModalForm">
          <div class="row p-2">
            <div class="col-md-12">
              <label for="changesAmount" class="form-label"><b>Amount in percentage</b></label>
              <input type="number" class="form-control form-control-sm" id="changesAmount" name="changesAmount" required
                placeholder="">
              <input type="number" readonly class="form-control form-control-sm d-none" id="changesAmountId"
                name="changesAmountId" required placeholder="">
            </div>
            <div class="col-md-12">
              <label for="isActiveUpdate" class="form-label"><b>Is Active</b></label>
              <select class="form-control form-control-sm" id="isActiveUpdate" required name="isActiveUpdate"
                placeholder="">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="issueDateUpdate" class="form-label"><b>Issued Date</b></label>
              <input type="date" class="form-control form-control-sm" id="issueDateUpdate" required
                name="issueDateUpdate" placeholder="">
            </div>
            <div class="col-md-6">
              <label for="expiryDateUpdate" class="form-label"><b>Expiry Date</b></label>
              <input type="date" class="form-control form-control-sm" id="expiryDateUpdate" required
                name="expiryDateUpdate" placeholder="">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="SaveChanges()">Save Changes</button>
      </div>
    </div>
  </div>
</div>


<script>
  function SaveChanges(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ route('admin.UpdateStudentWiseFeeAmount') }}",
      method: 'POST',
      data: $("#slcModalForm").serialize(),
      success: function(result) {
        $('#exampleModal').modal('hide');
        swal("Good job!", "Amount successfully updated!", "success");
        $("#slcModalForm").trigger("reset");
        // LoadCompany();
        FetchSWSH();
      },
      error: function(error) {
        $.each(error.responseJSON.errors, function(field_name,error){
          swal('Warning', error[0], 'warning');
        });
      }
    });
  }

  function EditRow(id, index){
    $("#changesAmount").val(data[index].amountparentage);
    $("#changesAmountId").val(id);
    $("#isActiveUpdate").val(data[index].isactive);
    $("#issueDateUpdate").val(data[index].issuedate);
    $("#expiryDateUpdate").val(data[index].lastdate);

    $('#exampleModal').modal('show');
  }
  var data;
  $(document).ready(function() {
    $('#insertFeeHead').show();
    FetchSWSH();
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
          swal("Good job!", "Employee is successfully updated!", "success");
          $("#FeesForm").trigger("reset");
          $('#insertFeeHead').show();
          $('#updateFeeHead').hide();
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
          });
        }
      });
    });

    $('#addSWSH').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddSholarshipWiseSubheads') }}",
        method: 'POST',
        data: $("#ScholarshipWSHForm").serialize(),
        success: function(result) {
          // LoadCompany();
          FetchSWSH();
          if(result == 'Error'){
            swal("Duplicate Entry", "Subhead duplicate", "warning");
          }else{
          swal("Good job!", "Successfully added!", "success");
          $("#ScholarshipWSHForm").trigger("reset");
          }
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
          });
        }
      });
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
          FetchSWSH();
          if(result == 'Error'){
            swal("Duplicate Entry", "Subhead duplicate", "warning");
          }else{
          swal("Good job!", "Successfully added!", "success");
          $("#FeesForm").trigger("reset");
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

  function FetchSWSH() {
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewSholarshipWiseSubheads') }}",
      success: function(d) {
        SWfeesheads = JSON.parse(d);
        $("#SubheadTable").DataTable().destroy();
        $("#SWFeesHead").empty();
        data = SWfeesheads;
        var j = 1;
        for (i = 0; i < SWfeesheads.length; ++i) {
          $('#SWFeesHead').append('<tr ondblclick="EditRow(' + SWfeesheads[i].id + ', ' + i +')">' +
            '<td>' + j + '</td>' +
            '<td>' + SWfeesheads[i].studentid + " " + SWfeesheads[i].studentname+ '</td>' +
            '<td>' + SWfeesheads[i].amountparentage + ' %' + '</td>' +
            '<td>' + SWfeesheads[i].subhead + '</td>' +
            '<td>' + SWfeesheads[i].name + '</td>' +
            '<td>' + SWfeesheads[i].session + '</td>' +
            '<td>' + SWfeesheads[i].sequence + '</td>' +
            '<td>' + SWfeesheads[i].isactive + '</td>' +
            '<td>' + SWfeesheads[i].issuedate + '</td>' +
            '<td>' + SWfeesheads[i].lastdate + '</td>' +
            '</tr>');
          j++;
        }
        $("#SubheadTable").DataTable();
      },
      error: function() {
      }
    });
  }
</script>




@endsection