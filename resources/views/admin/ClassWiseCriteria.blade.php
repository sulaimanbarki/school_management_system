@extends('admin.admin_master')



@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary  collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Classwise Fees Criterias<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid">
          <form id="FeeCriteriaForm" onsubmit="return false" method="POST">


            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="id" class="form-label"><b>Fee Criteria</b></label>
                <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="">
              </div>
              <div class="col-md-4">
                <?php
                $campusid = Auth::user()->campusid;
                  $classes = \App\Models\addClass::where('CampusID',$campusid )->where('Isdisplay', 1)->get();
                  $subheads = \App\Models\FeeSubHead::where('campusid',$campusid )->where('isdefault', 'Yes')->get();
                  $sessions = \App\Models\academicsessions::where('CampusID',$campusid )->where('IsActive', '1')->get();
                ?>
                <label for="classid" class="form-label"><b>Class</b></label>
                <select class="form-control form-control-sm" id="classid" required name="classid" placeholder="">
                  <option value="">Choose Class</option>
                  @foreach ($classes as $classe)
                  <option value="{{ $classe->C_id }}">{{ $classe->ClassName }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label for="subheadid" class="form-label"><b>Sub Head</b></label>
                <select class="form-control form-control-sm" id="subheadid" required name="subheadid" placeholder="">
                  <option value="">Choose sub head</option>
                  @foreach ($subheads as $subhead)
                  <option value="{{ $subhead->id }}">{{ $subhead->subhead }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label for="academicsession" class="form-label"><b>Accademic Session</b></label>
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
            </div>
            <div class="row align-items-center  ">
              <div class="col-md-6">
                <label for="amount" class="form-label"><b>Amount</b></label>
                <input type="number" class="form-control form-control-sm" id="amount" required name="amount"
                  placeholder="">
              </div>
              <div class="col-md-6">
                <label for="date" class="form-label"><b>Date</b></label>
                <input type="date" class="form-control form-control-sm" id="date" value="{{ date('Y-m-d') }}" required
                  name="date" placeholder="">
              </div>
            </div>

            <div class="row align-items-center  pt-3 pb-3">
              <div class="col-md-12">
                <input id="insertFeesCriteria" class="btn btn-primary btn-block" type="submit" value="Save">
              </div>
              <div class="col-md-12">
                <input type="submit" style="display:none" id="updateFeeHead" class="btn btn-success btn-block"
                  value="Update">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>


          </form>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table id="example3" class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>Id</th>
                  <th class="select-filter">Class</th>
                  <th class="select-filter">Subhead</th>
                  <th>Amount</th>
                  <th>Session</th>
                  <th>Date</th>
                  <th></th>
                  <!-- <th>SubCat_name</th> -->
                </tr>
              </thead>
              <tbody id="FeesCriteria">
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
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 d-none">
    <div class="card card-primary  collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Store Fee Heads Record Sessionwise<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid">
          <form id="FeeHeadsSessionWise" onsubmit="return false" method="POST">
            <div class="row align-items-center  ">
              <div class="col-md-6">
                <?php
                  $sessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsCurrent', 1)->get();
                ?>
                <label for="sessionid" class="form-label"><b>Class</b></label>
                <select class="form-control form-control-sm" id="sessionid" required name="sessionid" placeholder="">
                  <option value="">Choose session</option>
                  @foreach ($sessions as $session)
                  <option value="{{ $session->id }}">{{ $session->Session }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="date" class="form-label"><b>&nbsp;</b></label>
                <input class="btn btn-primary btn-block btn-sm" type="submit" value="Save">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  function ResetFormByCancelKey(){
    $("#FeeCriteriaForm").trigger("reset");
    $("#updateFeeHead").hide();
    $('#insertFeesCriteria').show();
    $('#insertFeesCriteria').prop('type', 'submit');
    $('#cancelbtn').hide();
  }
  var data;
  $(document).ready(function() {
    $("#FeeHeadsSessionWise").submit(function (e) { 
      e.preventDefault();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
          url: "{{ route('admin.StoreFeeheadsSessionWise') }}",
          method: 'POST',
          data: $("#FeeHeadsSessionWise").serialize(),
          success: function(result){
            LoadCompany();
            swal("Good job!", "Successfully added.", "success");
            $("#FeeHeadsSessionWise").trigger("reset");            
          },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });
    $("#updateFeeHead").click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
          url: "{{ route('admin.UpdateClassWiseFeeCriteria') }}",
          method: 'POST',
          data: $("#FeeCriteriaForm").serialize(),
          success: function(result){
            if(result == 'already'){
              swal("Error", "Already assigned!", "warning");
              return;
            }
            LoadCompany();
            swal("Good job!", "Criteria successfully updated!", "success");
            $("#FeeCriteriaForm").trigger("reset");
            $("#updateFeeHead").hide();
            $('#insertFeesCriteria').show();
            $('#insertFeesCriteria').prop('type', 'submit');
            $('#cancelbtn').hide();
          },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    $('#insertFeesCriteria').show();
    LoadCompany();
    var dataa = '';

    $('#insertFeesCriteria').click(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddFeesHeadConfigrationConfigration') }}",
        method: 'POST',
        data: $("#FeeCriteriaForm").serialize(),
        success: function(result) {
          LoadCompany();
          if(result == 'Error'){
            swal("Duplicate Entry", "Subhead duplicate", "warning");
          }else if(result == 'already'){
            swal("Warning!", "Already assigned!", "warning");
          }else{
          swal("Good job!", "Successfully added!", "success");
          $("#FeeCriteriaForm").trigger("reset");
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
    // alert();
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewFeesCriteriaConfigration') }}",
      success: function(d) {
        //alert(d);
        feesCriteria = JSON.parse(d);
        data = feesCriteria;
        $("#example3").DataTable().destroy();
        $("#FeesCriteria").empty();
        var j = 1;
        for (i = 0; i < feesCriteria.length; ++i) {
          $('#FeesCriteria').append('<tr ondblclick="EditFeesCriteria('+ feesCriteria[i].id + ',' + i + ')">' +
            '<td>' + j + '</td>' +
            '<td>' + feesCriteria[i].classname + '</td>' +
            '<td>' + feesCriteria[i].subhead + '</td>' +
            '<td>' + feesCriteria[i].amount + '</td>' +
            '<td>' + feesCriteria[i].session + '</td>' +
            '<td>' + feesCriteria[i].date + '</td>' +
            '<td><a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'+'</tr>');
          j++;
        }
        // $("#example3").DataTable({});
        $('#example3').DataTable( {
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
        });
      },
      error: function() {
      }
    });
  }

  function EditFeesCriteria(id, i) {
    $('#insertFeesCriteria').hide();
    $('#insertFeesCriteria').prop('type', '');
    $('#updateFeeHead').show();
    $('#cancelbtn').show();
    
    $('#id').val(id);
    $('#classid').val(data[i].c_id);
    $('#subheadid').val(data[i].subheadid);
    $('#academicsession').val(data[i].asessionid);
    $('#amount').val(data[i].amount);
    $('#date').val(data[i].date);
  }

</script>



@endsection