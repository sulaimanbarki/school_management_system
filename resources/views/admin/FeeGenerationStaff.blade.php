@extends('admin.admin_master')
<style>
  #customwidth {

    width: 100px;
  }

  #customwidth1 {

    width: 70px;
  }
</style>
@section('Admindata')
<div class="row">
  {{-- {{dd(Auth::user()->role())}} --}}
  <div class="container-fluid pl-1 pr-1 pt-2 pb-2">
    <form id="FeesForm" onsubmit="return false" method="POST" enctype="multipart/form-data">
      <?php
              $feeheads = \App\Models\FeeSubHead::where('campusid', Auth::user()->campusid)->where('isdefault', 'Yes')->get();
              $currentsession = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsActive', 1)->where('IsCurrent', 1)->value('id');
              $scales = \App\Models\Scale::where('campusid', Auth::user()->campusid)->where('isactive', 1)->where('academicsession', $currentsession)->get();
              $departments = \App\Models\Department::where('campusid', Auth::user()->campusid)->where('isdisplay', 1)->get();
            ?>
      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-4" style="display: none">
          <label for="id" class="form-label"><b>Head Id</b></label>
          <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="">
        </div>
        <div class="col-md-4">
          <label for="departmentid" class="form-label"><b>Select Department </b></label>
          <select class="form-control form-control-sm" onchange="LoadDepartmentWiseStaff(this.value)" id="departmentid"
            required name="departmentid" placeholder="">
            <option value="">Choose Department</option>
            @foreach ($departments as $department)
            <option value="{{ $department->id }}">{{ $department->title }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label for="monthfrom" class="form-label"><b>Month</b></label>
          <input type="month" class="form-control form-control-sm" id="monthfrom" required name="monthfrom"
            placeholder="">
        </div>
        <div class="col-md-4">
          <label for="issuedate" class="form-label"><b>Issue date</b></label>
          <input type="date" value="<?php echo date('Y-m-d'); ?>"
            class="form-control form-control-sm" id="issuedate" required name="issuedate" placeholder="">
        </div>
      </div>

      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-4">
          <input type="hidden" class="form-control form-control-sm" id="searchStudent2" name="searchStudent2"
            placeholder="">
          <label for="section" class="form-label"><b>Select Scale</b></label>
          <select class="form-control form-control-sm" onchange="LoadDepartmentAndScaleWiseStaff(this.value)" id="SectionData"
            required name="section" placeholder="">
            <option value="">Choose Scale</option>
            @foreach ($scales as $scale)
            <option value="{{ $scale->id }}">{{ $scale->name }}</option>
            @endforeach
          </select>
        </div>

        {{-- <div class="col-md-4">
          <label for="lastdate" class="form-label"><b>Last Date</b></label>
          <input type="date" class="form-control form-control-sm" id="lastdate" value="<?php echo date('Y-M'); ?>"
            required name="lastdate" placeholder="">
        </div> --}}
      </div>

      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-4">
          {{-- <a href="#"><label for="" onclick="LoadAllStudent()" class="form-label"><b>Load all active
                students</b></label></a> --}}
          <input type="hidden" class="form-control form-control-sm" id="All" name="All">
        </div>
        <div class="col-md-4">
          {{-- <label for="section" class="form-label"><b>Fee Slip Format</b></label>
          <select class="form-control form-control-sm" id="section" required name="section" placeholder=""> --}}

          </select>
        </div>
        <div class="col-md-2">
          {{-- <label for="">&nbsp;</label>
          <a href="#" onclick="StoreData(event)" class="btn btn-sm btn-block btn-success">Print All
            Slip</a> --}}
        </div>
        <div class="col-md-2">
          <label for="">&nbsp;</label>
          <button type="button" class="btn btn-sm btn-block btn-success" onclick="generateFee()">Generate Salary</button>
        </div>
      </div>

      <div class="row  pt-1 pb-1">
        <div class="table-responsive col-md-9 ">
          <table id="allStudents" class="table">
            <thead>
              <tr>
                <th style="width:10px"></th>
                <th id="customwidth1">Id</th>
                <th id="customwidth">Name</th>
                <th id="customwidth">F/Name</th>
                <th id="customwidth1">Scale</th>
                <th id="customwidth1">Dept</th>
                {{-- <th id="customwidth1">Transport</th> --}}
              </tr>
            </thead>
            <tbody id="allStudentsBody">
            </tbody>
            {{-- <tfoot>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tfoot> --}}
          </table>
        </div>
        <div class="table-responsive col-md-3 d-none">
          <table id="" class="table">
            <thead>
              <tr>
                <th></th>
                <th>Subhead</th>
                <th>Select</th>
              </tr>
            </thead>
            <tbody id="FeesHead">
              <?php
                      $j = 1;
                    ?>
              @foreach ($feeheads as $feehead)
              <tr>
                <td sytle='width: 10%;'>
                  <?php echo $j;
                        $j++;
                        ?>
                </td>
                <td sytle="width: 60%;"><label for="{{ $feehead->id }}">{{ $feehead->subhead }}</label></td>
                @if ($feehead->isdefault == "No")
                <td sytle="width: 30%;"><input type="checkbox" name="feeheads[]" value="{{ $feehead->id }}"
                    id="{{ $feehead->id }}" value="{{ $feehead->id }}">
                  @else
                <td sytle="width: 30%;"><input type="checkbox" name="feeheads[]" checked value="{{ $feehead->id }}"
                    id="{{ $feehead->id }}" value="{{ $feehead->id }}">
                  @endif

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>


        </div>
      </div>

      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-3">
          <label for="searchEmployee" class="form-label"><b>Employee Id</b></label>
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
            <input type="search" class="form-control form-control-sm" id="searchEmployee" name="searchEmployee"
              placeholder="">
            <input type="hidden" class="form-control form-control-sm" id="searchbystaffid" name="searchbystaffid"
              placeholder="">
            <input type="hidden" class="form-control form-control-sm" id="stdid" name="stdid" placeholder="">
          </div>


        </div>
        <div class="col-md-1">
          <label for="">&nbsp;</label>
          <button type="button" class="btn btn-block btn-sm btn-success" onclick="loadStudent()">Search</button>
        </div>
        <div class="col-md-4">
          {{-- <label for="section" class="form-label"><b>Fee Slip Format</b></label>
          <select class="form-control form-control-sm" id="section" required name="section" placeholder="">
          </select> --}}
        </div>
        <div class="col-md-2">
          {{-- <label for="">&nbsp;</label>
          <button type="button" class="btn btn-sm btn-block btn-success d-none">Print Slip</button> --}}
        </div>
      </div>

      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-12">
          <p><span class="searchedStudent"></span></p>
        </div>
      </div>
    </form>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student's Fees Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row p-2">
          <div class="col-md-2">
            <label for="section" class="form-label"><b>Id</b></label>
            <input type="text" class="form-control form-control-sm" readonly id="student-id" required placeholder="">
          </div>
          <div class="col-md-5">
            <label for="section" class="form-label"><b>Name</b></label>
            <input type="text" class="form-control form-control-sm" readonly id="student-Name" required placeholder="">
          </div>
          <div class="col-md-5">
            <label for="section" class="form-label"><b>Father Name</b></label>
            <input type="text" class="form-control form-control-sm" readonly id="student-Father" required
              placeholder="">
          </div>
        </div>
        <div class="row p-2">
          <div class="col-md-5">
            <label for="section" class="form-label"><b>Class</b></label>
            <input type="text" class="form-control form-control-sm" readonly id="student-class" required placeholder="">
          </div>
          <div class="col-md-5">
            <label for="section" class="form-label"><b>Section</b></label>
            <input type="text" class="form-control form-control-sm" readonly id="student-section" required
              placeholder="">
          </div>
          <div class="col-md-2">
            <label for="section" class="form-label"><b>Amount</b></label>
            <input type="text" class="form-control form-control-sm" readonly id="student-amount" required
              placeholder="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>




<script>
  var feaheads = 0;
  $(document).ready(function() {
    // let now = new Date();
    // let today =  now.getFullYear()+ '-' + (now.getMonth() + 1);
    // alert(today);
    // $('#issuedate').val(today);
});

  function StoreData(e){
    e.preventDefault();
    swal({
      title: "Are you sure?",
      text: "Are you sure to print slips ?",
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
          var sectionid=$('#SectionData').val();
             var departmentid=$('#departmentid').val();
             var searchStudent2=$('#searchStudent2').val();
             var stdid=$('#stdid').val();
             var monthto=$('#monthto').val();

          $.ajax({
            dataType: "json",
            // FeeGenerationsCalculate fetchUnpaidSubheads()
            data: {departmentid:departmentid,sectionid:sectionid,searchStudent2:searchStudent2,stdid:stdid,monthto:monthto},
            url: "{{ route('admin.TotalUnpaidStudents') }}",
            method: 'post',
            success: function(da) {
              feaheads = da;
              // alert(feaheads);
              localStorage.setItem('Students', feaheads);

            //  window.open("{{ route('adminbackend.PrintSlip.page') }}", '_blank');
            }
          });


          $.ajax({
            dataType: "json",
            // FeeGenerationsCalculate fetchUnpaidSubheads()
            url: "{{ route('admin.fetchUnpaidSubheads') }}",
            method: 'post',
            data: {departmentid:departmentid,sectionid:sectionid,searchStudent2:searchStudent2,stdid:stdid,monthto:monthto},
            success: function(d) {
              feaheads = d;
              //  alert(feaheads);
              localStorage.setItem('data', data);
              localStorage.setItem('feeheads', feaheads);
              var localdata = { 'monthfrom': $('#monthfrom').val(), 'monthto': $('#monthto').val(), 'issuedate': $('#issuedate').val(), 'lastdate': $('#lastdate').val(),  };
              localStorage.setItem('localdata', JSON.stringify(localdata));
            // alert(data);
              window.open("{{ route('adminbackend.PrintSlip.page') }}", '_blank');
            }
          });

      } else {
        e.preventDefault();
      }
    });


  }

  var data;
  $(document).ready(function() {
    // set current month for month input type
    const fromMonth = document.getElementById('monthfrom');
    const toMonth = document.getElementById('monthto');
    const date= new Date()
    const month=("0" + (date.getMonth() + 1)).slice(-2)
    const year=date.getFullYear()
    fromMonth.value = `${year}-${month}`;
    toMonth.value = `${year}-${month}`;


    $("#allStudents").DataTable();
    var dataa = '';
  });


  function CheckPaymentStatus(id){
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewStudentFeesDetails') }}",
      method: 'get',
      data: {stdid: id},
      success: function(d) {
        // TODO:
        det = JSON.parse(d);
        $("#student-id").val(det[0].studentid);
        $("#student-Name").val(det[0].studentname);
        $("#student-Father").val(det[0].fathername);
        $("#student-class").val(det[0].classname);
        $("#student-section").val(det[0].sectionname);
        $("#student-amount").val(det[0].amount);
        // show modal
        $('#exampleModal').modal('show');
      },error: function(e){
        console.log(e);
      }
    });
  }

  function LoadAllStudent() {
    $("#All").val('All');
    $("#searchEmployee").val('');
    $("#searchbystaffid").val('');
    $("#departmentid").val('');
    $("#SectionData").val('');
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewAllStudents') }}",
      method: 'post',
      success: function(d) {
        data = d;
        feesheads = JSON.parse(d);
        $("#allStudents").DataTable().destroy();
        $("#allStudentsBody").empty();
        var j = 1;
        for (i = 0; i < feesheads.length; ++i) {
          $('#allStudentsBody').append('<tr onclick=CheckPaymentStatus(\'' + feesheads[i].studentid + '\')>' +
            '<td >' + '<input type="checkbox" checked value="' + feesheads[i].studentid + '" name="students[]">' + '</td>' +
            '<td id="customwidth1" >' + feesheads[i].studentid + '</td>' +
            '<td id="customwidth">' + feesheads[i].studentname + '</td>' +
            '<td id="customwidth">' + feesheads[i].fathername + '</td>' +
            '<td id="customwidth1" >' + feesheads[i].classname + '</td>' +
            '<td id="customwidth1">' + feesheads[i].sectionname + '</td>' +
            '<td id="customwidth1">' + feesheads[i].transportstatus + '</td>');
          j++;
        }
        //alert();
        $('#allStudents tfoot th:not(:first-child, :last-child)').each( function () {
        var title = $(this).text();
        //alert(title);


        $(this).html( '<input type="text" id="customwidth1" placeholder="Search '+title+'" />' );



    } );

        $("#allStudents").DataTable({
          initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },  "lengthMenu": [ 10, 25, 50, 75, 10000 ]
        });
      },
      error: function() {
      }
    });
  }

  function LoadDepartmentWiseStaff(val){
    $("#All").val('');
    $("#SectionData").val('');
    $("#searchbystaffid").val('');

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      url: "{{ route('admin.DepartmentWiseStaff') }}",
      method: 'post',
      data: { departmentid : val},
      success: function(d) {
        data = d;
        feesheads = JSON.parse(d);
        $("#allStudents").DataTable().destroy();
        $("#allStudentsBody").empty();
        var j = 1;
        for (i = 0; i < feesheads.length; ++i) {
          $('#allStudentsBody').append('<tr onclick=CheckPaymentStatus(\'' + feesheads[i].empid + '\')>' +
            '<td>' + '<input type="checkbox" checked value="' + feesheads[i].empid + '" name="students[]">' + '</td>' +
            '<td>' + feesheads[i].empid + '</td>' +
            '<td>' + feesheads[i].empname + '</td>' +
            '<td id="customwidth">' + feesheads[i].fname + '</td>' +
            '<td>' + feesheads[i].scalename + '</td>' +
            '<td>' + feesheads[i].title + '</td>' +
            '</tr>');
          j++;
        }
        $("#allStudents").DataTable();
      },
      error: function() {
      }
      });

      return;


      $.ajax({
      dataType: "json",
      url: "{{ route('admin.GetSectionClassWise') }}",
      method: 'post',
      data: { departmentid : val},
      success: function(d) {
        Sections = JSON.parse(d);
        $("#SectionData").empty();
        $('#SectionData').append('<option selected value="0">Chosse Section</option>');
          for (i = 0; i < Sections.length; ++i) {
            // alert(Sections[i].sec_id);
            $('#SectionData').append('<option value="'+ Sections[i].sec_id  +'">'+
            Sections[i].sectionname+'</option>');
        }
      },
      error: function() {
      }
      });


  }

  function LoadDepartmentAndScaleWiseStaff(scale){
    $("#All").val('');

      let departmentid=$('#departmentid').val();
      $("#searchbystaffid").val('');

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        dataType: "json",
        url: "{{ route('admin.showDepartmentAndScaleWiseStaff') }}",
        method: 'post',
        data: { scaleid: scale, departmentid: departmentid},
        success: function(d) {
          feesheads = JSON.parse(d);
          data = d;
          $("#allStudents").DataTable().destroy();
          $("#allStudentsBody").empty();
          var j = 1;
          for (i = 0; i < feesheads.length; ++i) {
            $('#allStudentsBody').append('<tr onclick=CheckPaymentStatus(\'' + feesheads[i].empid + '\')>' +
            '<td>' + '<input type="checkbox" checked value="' + feesheads[i].empid + '" name="students[]">' + '</td>' +
            '<td>' + feesheads[i].empid + '</td>' +
            '<td>' + feesheads[i].empname + '</td>' +
            '<td id="customwidth">' + feesheads[i].fname + '</td>' +
            '<td>' + feesheads[i].scalename + '</td>' +
            '<td>' + feesheads[i].title + '</td>' +
            '</tr>');
            j++;
          }
          $("#allStudents").DataTable();
          // $(".searchedStudent").html(feesheads[0].studentname + '(' + feesheads[0].admissioninclass + ')');
        },
        error: function() {
        }
      });

  }
  function loadStudent(){

    $("#All").val('All');
    $("#departmentid").val('');
    $("#SectionData").val('');

    if($("#searchEmployee").val()){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        dataType: "json",
        url: "{{ route('admin.ViewSingleEmployee') }}",
        method: 'post',
        data: { empid : $("#searchEmployee").val() },
        success: function(d) {
          feesheads = JSON.parse(d);
          data = d;
          $("#allStudents").DataTable().destroy();
          $("#allStudentsBody").empty();
          var j = 1;
          // console.log(data);
          if(feesheads.length > 0){
            for (i = 0; i < feesheads.length; ++i) {
              $('#allStudentsBody').append('<tr onclick=CheckPaymentStatus(\'' + feesheads[i].empid + '\')>' +
              '<td>' + '<input type="checkbox" checked value="' + feesheads[i].empid + '" name="students[]">' + '</td>' +
              '<td>' + feesheads[i].empid + '</td>' +
              '<td>' + feesheads[i].empname + '</td>' +
              '<td id="customwidth">' + feesheads[i].fname + '</td>' +
              '<td>' + feesheads[i].scalename + '</td>' +
              '<td>' + feesheads[i].title + '</td>' +
              '</tr>');
              j++;
            }
          }else{
            swal('Error','No record found for this id', 'error');
          }
          $("#allStudents").DataTable();
          $("#All").val('');
          $("#departmentid").val('');
          $("#SectionData").val('');
          $("#stdid").val($("#searchEmployee").val());
          $("#searchStudent2").val(2);
          $("#searchbystaffid").val(2);
          // $(".searchedStudent").html(feesheads[0].studentname + '(' + feesheads[0].admissioninclass + ')');
        },
        error: function() {
        }
      });
    }else{
      swal('Error','Please select employee id.', 'error');
    }
  }

  function generateFee(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    $.ajax({
      dataType: "json",
      url: "{{ route('admin.GenerateSalary') }}",
      method: 'post',
      data: $("#FeesForm").serialize(),
      success: function(d) {

        // debugger;
        if(d>0){

          swal('Success','Salary Generated SuccessFully Aganist : '+d, 'success');
        }else{
          swal('Warning','Issue While Gener/ation Fee', 'warning');
        }
      },
      error: function(error) {
        $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });

      }
    });
  }


</script>



@endsection
