@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary  collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Class And Section</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid  col-md-12">
          <form id="AddConfigForm" onsubmit="return false" method="POST">
            <div class="row align-items-center  ">
              <div class="col-md-12">
                <p class="text-danger">Please consider the sequence of classes. Select same sequence for same classes. Make higher sequence for higher classes
                  and lower sequence for lower classes.</p>
              </div>
              <div class="col-md-4" style="display: none">
                {{-- style="display: none" --}}
                <label for="Classid" class="form-label"><b>Class Id</b></label>
                <input type="text" class=" form-control form-control-sm" id="Classid" name="Classid" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="ClassName" class="form-label"><b>Class Name</b></label>
                <input type="text" class=" form-control form-control-sm" id="ClassName" required name="ClassName"
                  placeholder="Class Name">
              </div>
              <div class="col-md-6">
                <label for="ClassSequence" class="form-label"><b>Class Sequence</b></label>
                <input type="number" min="1" max="20" class=" form-control form-control-sm" id="ClassSequence" required
                  name="ClassSequence" placeholder="Class Sequence">
              </div>
            </div>
            <div class="row align-items-center pt-2">
              <div class="col-md-12">
                <input type="submit" name="submit" id="insertClass" class="btn btn-sm btn-primary btn-block"
                  value="Add Class">
              </div>
              <div class="col-md-12">
                <input type="submit" name="submit" id="updateClass" class="btn btn-sm btn-success btn-block"
                  value="Update Class">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelAddClassbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>
          </form>
          <hr>
          <h4>Classes</h4>
          <table id="example3" class="table table-responsive-sm" style="">
            <thead>
              <tr>
                <th>S.No</th>
                <th>ClassName</th>
                <th>Class Sequence</th>
                <th>Actions</th>
                <!-- <th>SubCat_name</th> -->
              </tr>
            </thead>
            <tbody id="ClassData">




              {{-- <td>
                <a style="color: #FFC107;" id="EditItem"><i class="fas fa-edit" title="Edit"></i></a>
                <span style="color: red;" class="fas fa-trash-alt DeleteSubcat" data-id="">
                </span>
              </td> --}}



            </tbody>
          </table>
          <form id="sectionForm" onsubmit="return false" method="POST">
            <br>
            <div class="col-md-12">
              <p class="text-danger">Please consider the sequence of sections. Select same sequence for same sections. Make higher sequence for higher sections and
                lower sequence for lower sections and higher sequence for higher sections.</p>
            </div>
            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                <label for="SectionId" class="form-label"><b>Section Id</b></label>
                <input type="text" class=" form-control form-control-sm" id="SectionId" value="0" name="SectionId"
                  placeholder="">
              </div>
              <div class="col-md-6">
                <label for="SectionName" class="form-label"><b>Section Name</b></label>
                <input type="text" class=" form-control form-control-sm" id="SectionName" required name="SectionName"
                  placeholder="Section Name">
              </div>
              <div class="col-md-6">
                <label for="SectionSequence" class="form-label"><b>Section Sequence</b></label>
                <input type="number" class=" form-control form-control-sm" id="SectionSequence" required
                  name="SectionSequence" placeholder="Section Sequence">
              </div>

            </div>
            <div class="row align-items-center pt-2">
              <div class="col-md-12">
                <input type="submit" name="submit" id="insertSection" class="btn btn-sm btn-primary btn-block"
                  value="Add Section">
              </div>
              <div class="col-md-12">
                <input type="submit" name="submit" style="display:none" id="updateSection"
                  class="btn btn-sm btn-success btn-block" value="Update">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelSectionFormbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>
          </form>
        </div>
        <hr>
        <div class="container-fluid  col-md-12">
          <div class="row">
            <div class="col-md-12">
              <h4>Sections</h4>
              <table id="example33" class="table table-responsive-sm" style="">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Section Name</th>

                    <th>Sequence</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="SectionData">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div>
      <div class="card card-primary collapsed-card">
        <div class="card-header" data-card-widget="collapse">
          <h3 class="card-title">Assign Sections to Classes</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="card-body collapse in">
          <form id="SectionAssignmentForm" onsubmit="return false">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="ClassId" class="form-label"><b>Select Class</b></label>
                  <select class=" form-control form-control-sm select2bs4" required="" name="CWSectionClass"
                    id="CWSectionClass">
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="Section" class="form-label"><b>Select Section</b></label>
                  <select class=" form-control form-control-sm" required="" name="CWSectionSection"
                    id="CWSectionSection">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="CWSectionSequence" class="form-label"><b>Sequence</b></label>
                  <input type="number" min="1" max="20" class=" form-control form-control-sm select2bs4" required
                    name="CWSectionSequence" id="CWSectionSequence">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="CWSectionDate" class="form-label"><b>Date</b></label>
                  <input type="date" value="<?php echo date('Y-m-d'); ?>"
                    class="form-control form-control-sm select2bs4" required name="CWSectionDate" id="CWSectionDate">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="IsDisplay" class="form-label"><b>Is Display</b></label>
                  <select class=" form-control form-control-sm" required name="IsDisplay" id="IsDisplay">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="submit" name="CWSectionInsert" id="AssignSection"
                    class="btn btn-sm btn-primary btn-block" value="Assign">
                </div>
              </div>
            </div>
          </form>
          <hr>
          <div class="container-fluid  col-md-12">
            <div class="row">
              <div class="col-md-12">
                <h4>Classes with Sections Assigned</h4>
                <table id="example333" class="table table-responsive-sm" style="">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Class Name</th>
                      <th>Section</th>
                      <th>Is Display</th>
                      <th>Action</th>
                      <!-- <th>SubCat_name</th> -->
                    </tr>
                  </thead>
                  <tbody id="ViewClassWiseSection">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- /.card -->
    <div class="card card-primary  collapsed-card">
      <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Academic Session</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="container-fluid  col-md-12">
          <form id="SessionForm" onsubmit="return false">
            <div class="row align-items-center  ">
              <div class="col-md-4" style="display: none">
                {{-- style="display: none" --}}
                <label for="SessionID" class="form-label"><b>Session Id</b></label>
                <input type="text" class=" form-control form-control-sm" id="SessionID" name="SessionID" placeholder="">
              </div>
              <div class="col-md-6">
                <label for="Session" class="form-label"><b>Session</b></label>
                <input type="text" class=" form-control form-control-sm" id="Session" required name="Session"
                  placeholder="Session">
              </div>
              <div class="col-md-6">
                <label for="SessionType" class="form-label"><b>Session Type</b></label>
                <input type="text" class=" form-control form-control-sm" id="SessionType" required name="SessionType"
                  placeholder="Session Type">
              </div>
            </div>
            <div class="row align-items-center  ">
              <div class="col-md-6">
                <label for="StartDate" class="form-label">Start Date<b></b></label>
                <input type="date" class=" form-control form-control-sm" id="StartDate" required name="StartDate"
                  placeholder="">
              </div>
              <div class="col-md-6">
                <label for="End Date" class="form-label"><b>End Date</b></label>
                <input type="date" class=" form-control form-control-sm" id="EndDate" required name="EndDate"
                  placeholder="">
              </div>
            </div>
            <div class="row align-items-center  ">
              <div class="col-md-6">
                <label for="IsActive" class="form-label">Active Status<b></b></label>
                <select class=" form-control form-control-sm" id="IsActive" required name="IsActive" placeholder="">
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="IsCurrent" class="form-label"><b>Current Year</b></label>
                <select class=" form-control form-control-sm" id="IsCurrent" required name="IsCurrent" placeholder="">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>
            </div>
            <div class="row align-items-center pt-2">
              <div class="col-md-12 sessionSubmitButtonContainer">
                <input type="submit" name="submit" id="insertSession" class="btn btn-sm btn-primary btn-block"
                  value="Add Session">
              </div>
              <div class="col-md-12">
                <input type="submit" name="submit" style="display:none" id="updateSession"
                  class="btn btn-sm btn-success btn-block" value="Update Session">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelAcademincSessionbtn"
                  class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
              </div>
            </div>
          </form>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <h3>Academic Sessions</h3>
              <table id="example3333" class="table table-responsive-sm" style="">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Session</th>
                    <th>Session Type</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Active Status</th>
                    <th>Current Year</th>
                    <th></th>
                    <!-- <th>SubCat_name</th> -->
                  </tr>
                </thead>
                <tbody id="SessionData">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="card card-primary collapsed-card">
        <div class="card-header" data-card-widget="collapse">
          <h3 class="card-title">Add Buses</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="card-body collapse in">
          <form id="AddBusForm" method="POST" onsubmit="return false">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="busnumber">Bus Number</label>
                    <input type="text" class=" form-control form-control-sm select2bs4" id="busnumber" name="busnumber">
                    <input type="text" class=" form-control form-control-sm d-none" id="oldbusnumber" name="oldbusnumber">
                    <input type="number" class=" form-control form-control-sm d-none" id="busid" name="busid">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="drivername">Driver Name</label>
                    <input type="text" required class=" form-control form-control-sm select2bs4" name="drivername"
                      id="drivername">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="drivercontact">Driver Contact</label>
                    <input type="tel" maxlength="11" required class=" form-control form-control-sm select2bs4"
                      name="drivercontact" id="drivercontact">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="conductorname">Conductor Name</label>
                    <input type="text" required="" class=" form-control form-control-sm select2bs4" name="conductorname"
                      id="conductorname">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="route">Route</label>
                    <input type="text" required="" class=" form-control form-control-sm select2bs4" name="route"
                      id="route">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="busisdisplay" class="form-label"><b>Is Display</b></label>
                    <select class=" form-control form-control-sm" required name="busisdisplay" id="busisdisplay">
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="bussequence" class="form-label"><b>Sequence</b></label>
                    <input type="number" min="1" max="20" class=" form-control form-control-sm" required
                      name="bussequence" id="bussequence">
                  </div>
                </div>
                <div class="col-md-12">
                  <input type="submit" name="submit" id="saveBus" class="btn btn-sm btn-primary btn-block"
                    value="Save Bus">
                </div>
                <div class="col-md-12">
                  <input type="submit" name="submit" style="display:none" id="updateBus"
                    class="btn btn-sm btn-success btn-block" value="Update Bus">
                  <input type="submit" onclick="ResetFormByCancelKey()" id="cancelBusFormbtn"
                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                </div>
              </div>
            </div>
          </form>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <h4>Busses</h4>
              <table id="example33333" class="table table-responsive-sm">
                <thead>
                  <tr>
                    <th>Bus Number</th>
                    <th>Driver Name</th>
                    <th>Driver Contact</th>
                    <th>Conductor Name</th>
                    <th>Route</th>
                    <th>Is Display</th>
                    <th>Sequence</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="BusData">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function ResetFormByCancelKey(){
    $("#AddConfigForm").trigger("reset");
    $('#updateClass').hide();
    $('#cancelAddClassbtn').hide();
    $('#insertClass').show();
    $('#insertClass').prop('type', 'submit');

    $("#sectionForm").trigger("reset");
    $('#updateSection').hide();
    $('#cancelSectionFormbtn').hide();
    $('#insertSection').show();
    $('#insertSection').prop('type', 'submit');

    $("#SessionForm").trigger("reset");
    $('#updateSession').hide();
    $('#cancelAcademincSessionbtn').hide();
    $('#insertSession').show();
    $('#insertSession').prop('type', 'submit');

    $("#AddBusForm").trigger("reset");
    $("#updateBus").hide();
    $('#cancelBusFormbtn').hide();
    $('#saveBus').show();
    $('#saveBus').prop('type', 'submit')
  }

  var sessionInsertButton = "";
  var dataa = '';
  var classes = '';
  var sections = '';
  $("#updateClass").hide();
  $('#updateSection').hide();
  function FetchClasseswiseSection(){
    // alert();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: "{{ route('admin.ViewClasssWiseSection') }}",
      success: function(ViewClasssWiseSection){
        dataa=JSON.parse(ViewClasssWiseSection);
        // console.log(dataa);
        $("#example333").DataTable().destroy();
        $("#ViewClassWiseSection").empty();
        var j=1;
        for (i=0; i < dataa.length; ++i) {
          $('#ViewClassWiseSection').append('<tr>'+
          '<td>'+ j +'</td>'+
          '<td>'+dataa[i].ClassName +'</td>'+
          '<td>'+dataa[i].SectionName+'</td>'+
          '<td>'+ (dataa[i].isDisplay == 1 ? 'Yes' : 'No') +'</td>'+
          '<td onclick="DeleteClassWiseSection('+dataa[i].id+',' + dataa[i].ClassID + ',' + dataa[i].Sec_ID + ')"  style="color:red">Delete</td>'+
          '</tr>');
          j++;
        }
        $("#example333").DataTable();
          },
      error: function(){
        alert('error');
      }
    });
  }

  function FetchClasses(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: "{{ route('admin.ViewClasss') }}",
      success: function(ClassData){
        dataa=JSON.parse(ClassData);
        $("#CWSectionClass").empty();
        var j=1;
        $('#CWSectionClass').append("<option value=''>Select Class</option>");
        for (i=0; i < dataa.length; ++i) {
          $('#CWSectionClass').append('<option value='+dataa[i].C_id+'>'+ dataa[i].ClassName +'</option>');
          j++;
        }
      },
      error: function(){
        alert('error');
      }
    });
  }


  function DeleteClassWiseSection(classwisesectionid, classid, sectionid) {
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this record!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        $.ajax({
            url: "{{ route('admin.DeleteClasswiseSecion') }}",
            method: 'POST',
            data:{classwisesectionid, classid, sectionid},
            success: function(result){
              if(result == 'exists'){
                swal("Warning!", "Section already assigned.", "warning");
                return;
              }
              FetchClasses();
              // ViewClasses();
              FetchSections();
              FetchClasseswiseSection();
              swal("Success!", "Record deleted successfully", "success");
              //   alert(result.result);
            },
            error: function(error){
            $.each(error.responseJSON.errors, function(field_name,error){
              swal('Warning', error[0], 'warning');
                // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            });
          }
        });
      }
  });
  }


  function FetchSections() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: "{{ route('admin.ViewSections') }}",
      success: function(ClassData){
        dataa=JSON.parse(ClassData);
        $("#CWSectionSection").empty();
        var j=1;
        $('#CWSectionSection').append("<option value=''>Select Section</option>");
        for (i=0; i < dataa.length; ++i) {
          $('#CWSectionSection').append('<option value='+dataa[i].Sec_ID+'>'+ dataa[i].SectionName +'</option>');
          j++;
        }
      },
      error: function()
      {
        alert('error');
      }
    });
  }

  function FetchBuses(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
      dataType: "json",
      type: 'GET',
      url: "{{ route('admin.ViewBusesConfigration') }}",
      success: function(beses){
        busess=JSON.parse(beses);
        $("#example33333").DataTable().destroy();
        $("#BusData").empty();
        var j=1;
        for (i=0; i < busess.length; i++) {
          $('#BusData').append('<tr ondblclick="EditBus(\'' + busess[i].id + '\',' + i + ')">'+
          '<td>'+ busess[i].busnumber+'</td>'+
          '<td>'+busess[i].drivername +'</td>'+
          '<td>'+busess[i].drivercontact+'</td>'+
          '<td>'+busess[i].conductorname+'</td>'+
          '<td>'+busess[i].route+'</td>'+
          '<td>'+ (busess[i].busisdisplay == 1 ? "Yes" : "No") +'</td>'+
          '<td>'+busess[i].bussequence+'</td>'+
          '<td style="color:red"><i class="fas fa-edit"  title="Edit"></i></td>'+
          '</tr>');
          j++;
        }
        $("#example33333").DataTable({
          responsive: true
        });
      },
      error: function(){
        alert('error');
      }
    });
  };

  function EditBus(busid, i) {
    $('#saveBus').hide();
    $('#saveBus').prop('type', '');
    $('#updateBus').show();
    $('#cancelBusFormbtn').show();
    $('#busid').val(busid);
    $('#busnumber').val(busess[i].busnumber);
    $('#oldbusnumber').val(busess[i].busnumber);
    $('#drivername').val(busess[i].drivername);
    $('#drivercontact').val(busess[i].drivercontact);
    $('#conductorname').val(busess[i].conductorname);
    $('#route').val(busess[i].route);
    $('#busisdisplay').val(busess[i].busisdisplay);
    $('#bussequence').val(busess[i].bussequence);
  }

  function EditClass(i, id) {
    // alert(i)
    $('#insertClass').hide();
    $('#insertClass').prop('type', '');
    $('#updateClass').show();
    $('#cancelAddClassbtn').show();
    $('#Classid').val(id);
    $('#ClassName').val(classes[i].ClassName);
    $('#ClassSequence').val(classes[i].Sequence);
  }

  function EditSection(i) {
    $('#insertSection').hide();
    $('#insertSection').prop('type', '');
    $('#updateSection').show();
    $('#cancelSectionFormbtn').show();

    $('#SectionId').val(dataaa[i].Sec_ID);
    $('#SectionName').val(dataaa[i].SectionName);
    $('#SectionSequence').val(dataaa[i].SectionSequence);
  }

  function EditSession(i) {
    $('#insertSession').hide();
    $('#insertSession').prop("type", '');
    $('#updateSession').show();
    $('#cancelAcademincSessionbtn').show();

    $('#SessionID').val(sessionData[i].id);
    $('#Session').val(sessionData[i].Session);
    $('#SessionType').val(sessionData[i].SessionType);
    $('#StartDate').val(sessionData[i].StartDate);
    $('#EndDate').val(sessionData[i].EndDate);
    $('#IsActive').val(sessionData[i].IsActive);
    $('#IsCurrent').val(sessionData[i].IsCurrent);
  }

  $(document).ready(function(e) {
    FetchBuses();
    FetchClasses();
    FetchSections();
    FetchClasseswiseSection();
    $('#insert').show();
    $("#updateBus").hide();
    ViewClasses();

    $('#saveBus').click(function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('admin.AddBusConfigration') }}",
        method: 'POST',
        data: $("#AddBusForm").serialize(),
        success: function(result){
          ViewClasses();
          FetchClasses();
          FetchSections();
          FetchBuses();
          swal("Good job!", "Bus is successfully added!", "success");
          $("#AddBusForm").trigger("reset");
        },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });
// update bus
    $("#updateBus").click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
          url: "{{ route('admin.UpdateBusConfigration') }}",
          method: 'POST',
          data: $("#AddBusForm").serialize(),
          success: function(result){
            if(result == 'duplicate'){
              swal("Warning!", "Bus number is already used.!", "warning");
              return;
            }
            FetchClasses();
            ViewClasses();
            FetchSections();
            FetchBuses();
            FetchClasseswiseSection();
            swal("Good job!", "Bus successfully updated!", "success");
            $("#AddBusForm").trigger("reset");
            $("#updateBus").hide();
            $('#cancelBusFormbtn').hide();
            $('#saveBus').show();
            $('#saveBus').prop('type', 'submit');

          },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // insert class
    $('#insertClass').click(function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.StoreClass') }}",
        method: "POST",
        data: $("#AddConfigForm").serialize(),
        success: function(result){
          ViewClasses();
          FetchClasses();
          FetchSections();
          if(result.result=="true")
          {
            swal("Warning!", "Class Already Exist!", "error");
          }else if(result.result=="save"){
          swal("Good job!", "Class is successfully added!", "success");
          $("#AddConfigForm").trigger("reset");
          }else{
            swal("Warning!", "Issue Whiling Adding Class!", "error");
          }

        },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    $("#updateClass").click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
          url: "{{ route('admin.UpdateClassConfigration') }}",
          method: 'POST',
          data: $("#AddConfigForm").serialize(),
          success: function(result){
            FetchClasses();
            ViewClasses();
            FetchSections();
            FetchClasseswiseSection();
            $('#updateClass').hide();
            $('#cancelAddClassbtn').hide();
            $('#insertClass').show();
            $('#insertClass').prop('type', 'submit');
            swal("Good job!", "Class is successfully Updated!", "success");
            $("#AddConfigForm").trigger("reset");
          },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


    function ViewClasses() {
     // alert();
      $.ajax({
      dataType: "json",
      type: 'POST',
      url: "{{ route('admin.ViewClass') }}",
      success: function(ClassData){
        classes = JSON.parse(ClassData);
        $("#example3").DataTable().destroy();
        $("#ClassData").empty();
        var j=1;
        for (i=0; i < classes.length; ++i) {
          $('#ClassData').append('<tr ondblclick="EditClass(' + i + "," + classes[i].C_id + ')">'+
            '<td>'+ j +'</td>'+
            '<td>'+classes[i].ClassName +'</td>'+
            '<td>'+classes[i].Sequence +'</td>'+
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a>'+
            '</span></td></tr>');
            j++;
        }
        $("#example3").DataTable();
      },
      error: function(errors)
      {
        alert('errors Controller not hid by route')
      }
      });

      $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.ViewSectionConfigration') }}",
        success: function(SectionData)
        {
        dataaa=JSON.parse(SectionData);
        $("#example33").DataTable().destroy();
        $("#SectionData").empty();
        var j=1;
        for (i=0; i < dataaa.length; ++i) {
          $('#SectionData').append('<tr ondblclick="EditSection('+i+')">'+
            '<td>'+ j +'</td>'+
            '<td>'+dataaa[i].SectionName +'</td>'+
            '<td>'+dataaa[i].SectionSequence +'</td>'+
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a>'+
            '</span></td></tr>');
            j++;
          }
          $("#example33").DataTable();
          },
          error: function()
          {
            alert('djsslk');
          }
        });


      $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.ViewSessionConfigration') }}",
        success: function(SessionData)
        {
        sessionData=JSON.parse(SessionData);
        $("#example3333").DataTable().destroy();
        $("#SessionData").empty();
        var j=1;
        for (i=0; i < sessionData.length; ++i) {
          $('#SessionData').append('<tr ondblclick="EditSession('+i+')">'+
            '<td>'+ j +'</td>'+
            '<td>'+sessionData[i].Session +'</td>'+
            '<td>'+sessionData[i].SessionType +'</td>'+
            '<td>'+sessionData[i].StartDate +'</td>'+
            '<td>'+sessionData[i].EndDate +'</td>'+
            '<td>'+ (sessionData[i].IsActive == 1 ? "Yes" : "No") +'</td>'+
            '<td>'+ (sessionData[i].IsCurrent == 1 ? "Yes" : "No") +'</td>'+
            '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a>'+
            '</span></td></tr>');
            j++;
          }
          $("#example3333").DataTable();
          },
          error: function()
          {
          }
        });
    }

    // section
    $('#insertSection').click(function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.AddSectionConfigration') }}",
        method: 'POST',
        data: $("#sectionForm").serialize(),
        success: function(result){
          //alert(result.result);
          if(result.result=="true")
          {
            swal("Warning!", "Section Already Exist!", "error");
          }else if(result.result=="save"){

          swal("Good job!", "Section is successfully added!", "success");
          $("#sectionForm").trigger("reset");
          }else{
            swal("Warning!", "Issue Whiling Adding Section!", "error");
          }


          ViewClasses();
          FetchClasses();
          FetchSections();

          // swal("Good job!", "Campus is successfully added!", "success");



        },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    $("#updateSection").click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
          url: "{{ route('admin.UpdateSectionConfigration') }}",
          method: 'POST',
          data: $("#sectionForm").serialize(),
          success: function(result){
              ViewClasses();
              FetchClasses();
              FetchSections();
              FetchClasseswiseSection();
              swal("Good job!", "Section successfully updated!", "success");
              $("#sectionForm").trigger("reset");
              $('#updateSection').hide();
              $('#cancelSectionFormbtn').hide();
              $('#insertSection').show();
              $('#insertSection').prop('type', 'submit');
          },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });


    // academic sessions
    $('#insertSession').click(function(){
      alert();
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.AddSessionConfigration') }}",
        method: 'POST',
        data: $("#SessionForm").serialize(),
        success: function(result){
          if(result == 'duplicate'){
            swal("Duplicate!", "Session already exists!", "warning");
          }else{
            ViewClasses();
            swal("Good job!", "Session is successfully added!", "success");
            $("#SessionForm").trigger('reset');
          }
        },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    $("#updateSession").click(function(){
      // $('#insertSession').remove();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
          url: "{{ route('admin.UpdateSessionConfigration') }}",
          method: 'POST',
          data: $("#SessionForm").serialize(),
          success: function(result){
            if(result == 'duplicate'){
              swal("Duplicate!", "Session already exists!", "warning");
            }else if(result == 'disable'){
            swal("Error!", "There should be only one session active at a time. Please disable another academic session first.!", "warning");
            }else{
              ViewClasses();
              swal("Good job!", "Section successfully updated!", "success");
              $("#SessionForm").trigger("reset");
              $('#updateSession').hide();
              $('#cancelAcademincSessionbtn').hide();
              $('#insertSession').show();
              $('#insertSession').prop('type', 'submit');
            }
          },error: function(error){
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    // academic sessions
    $('#AssignSection').click(function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.SectionAssign') }}",
        method: 'POST',
        data: $("#SectionAssignmentForm").serialize(),
        success: function(result){
          if(result.result=="Exist")
          {
            swal("Warning!", "Section Against Class Already Exist!", "error");
          }else if(result.result=="save"){
            swal("Good job!", "Section is successfully Assigned to Class!", "success");
            $("#SectionAssignmentForm").trigger("reset");
          }else{
            swal("Warning!", "Issue Whiling Assinging Section!", "error");
          }
          FetchClasseswiseSection();
        },error: function(error){
          // console.log(error);
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });
    });

    $('#btn').attr("disabled", true);
    $("#uploadForm").on('submit', (function(e) {
      e.preventDefault();
    }));



  });


</script>


@endsection
