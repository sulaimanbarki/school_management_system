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
              $feeheads = \App\Models\FeeSubHead::where('campusid', Auth::user()->campusid)->get();
              $sss = \App\Models\Scholarship::where('campusid', Auth::user()->campusid)->get();
              $classes = \App\Models\addClass::where('CampusID', Auth::user()->campusid)->where('Isdisplay', 1)->get();
            ?>
      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-4" style="display: none">
          <label for="id" class="form-label"><b>Head Id</b></label>
          <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="">
        </div>
        <div class="col-md-4">
          <label for="classid" class="form-label"><b>Class </b></label>
          <select class="form-control form-control-sm" onchange="LoadClassWiseStudents(this.value)" id="classid"
            required name="classid" placeholder="">
            <option value="">Choose Class</option>
            @foreach ($classes as $classe)
            <option value="{{ $classe->C_id }}">{{ $classe->ClassName }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label for="monthfrom" class="form-label"><b>Month From</b></label>
          <input type="month" class="form-control form-control-sm" id="monthfrom" required name="monthfrom"
            placeholder="">
        </div>
        <div class="col-md-4">
          <label for="monthto" class="form-label"><b>Month To</b></label>
          <input type="month" class="form-control form-control-sm" id="monthto" required name="monthto" placeholder="">
        </div>
      </div>

      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-4">
          <input type="hidden" class="form-control form-control-sm" id="searchStudent2" name="searchStudent2"
            placeholder="">
          <label for="section" class="form-label"><b>Section</b></label>
          <select class="form-control form-control-sm" onchange="ClassSectionWiseStudents(this.value)" id="SectionData"
            required name="section" placeholder="">

          </select>
        </div>
        <div class="col-md-4">
          <label for="issuedate" class="form-label"><b>Issue date</b></label>
          <input type="date" onchange="checkDate()" value="<?php echo date('Y-m-d'); ?>"
            class="form-control form-control-sm" id="issuedate" required name="issuedate" placeholder="">
        </div>
        <div class="col-md-4">
          <label for="lastdate" class="form-label"><b>Last Date</b></label>
          <input type="date" class="form-control form-control-sm" id="lastdate" value="<?php echo date('Y-M'); ?>"
            required name="lastdate" placeholder="">
        </div>
      </div>

      <div class="row align-items-center  pt-1 pb-1">
        <div class="col-md-4">
          <a href="#"><label for="" onclick="LoadAllStudent()" class="form-label"><b>Load all active
                students</b></label></a>
          <input type="hidden" class="form-control form-control-sm" id="All" name="All">
        </div>
        <div class="col-md-4">
          {{-- <label for="section" class="form-label"><b>Fee Slip Format</b></label>
          <select class="form-control form-control-sm" id="section" required name="section" placeholder="">

          </select> --}}
        </div>
        <div class="col-md-2">
          <label for="">&nbsp;</label>
          <a href="#" onclick="StoreData(event)" id="printBtn" class="btn btn-sm btn-block btn-success">Print All
            Slip</a>
        </div>
        <div class="col-md-2">
          <label for="">&nbsp;</label>
          <button type="button" class="btn btn-sm btn-block btn-success" onclick="generateFee()">Generate Fee</button>
        </div>
      </div>

      <div class="row  pt-1 pb-1">
        <div class="table-responsive col-md-9 ">
          <table id="allStudents" class="table">
            <thead>
              <tr>
                <th style="width:10px"></th>
                <th id="customwidth1">StdId</th>
                <th id="customwidth">Name</th>
                <th id="customwidth">F/Name</th>
                <th id="customwidth1">Class</th>
                <th id="customwidth1">Section</th>
                <th id="customwidth1">Transport</th>
              </tr>
            </thead>
            <tbody id="allStudentsBody">
            </tbody>
            <tfoot>
              <th></th>
              <th data-text="Search by Id"></th>
              <th data-text="Search by name"></th>
              <th data-text="Search by father name"></th>
              <th data-text="Search by class"></th>
              <th data-text="Search by section"></th>
              <th></th>
            </tfoot>
          </table>
        </div>
        <div class="table-responsive col-md-3">
          <table id="" class="table">
            <thead>
              <tr>
                <th></th>
                <th>Fee heads</th>
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
            <input type="search" class="form-control form-control-sm" id="searchStudent" name="searchStudent"
              placeholder="">
            <input type="hidden" class="form-control form-control-sm" id="searchStudent1" name="searchStudent1"
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
          <label for="">&nbsp;</label>
          <button type="button" class="btn btn-sm btn-block btn-success d-none">Print Slip</button>
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
             var classid=$('#classid').val();
             var searchStudent2=$('#searchStudent2').val();
             var stdid=$('#stdid').val();
             var monthto=$('#monthto').val();
        
          $.ajax({
            dataType: "json",
            // FeeGenerationsCalculate fetchUnpaidSubheads()
            data: {classid:classid,sectionid:sectionid,searchStudent2:searchStudent2,stdid:stdid,monthto:monthto},
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
            data: {classid:classid,sectionid:sectionid,searchStudent2:searchStudent2,stdid:stdid,monthto:monthto},
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
  function checkDate() {
    var dtToday = new Date($("#issuedate").val());
    dtToday.setDate(dtToday.getDate() + 10);
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#lastdate').attr('min', maxDate);
    $('#lastdate').val(maxDate);
  }
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
    checkDate();
    // console.log($("#issuedate").val());
    // LoadCompany();
    // FetchSWSH();
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

    $("#printBtn").hide();
    $("#All").val('All');
    $("#searchStudent").val('');
    $("#searchStudent1").val('');
    $("#classid").val('');
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
        var title = $(this).attr('data-text');     
        $(this).html( '<input class="form-control form-control-sm" type="text" id="" placeholder="'+title+'" />' );
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

  function LoadClassWiseStudents(val){
    $("#printBtn").show();
    $("#All").val('');
    $("#SectionData").val('');
    $("#searchStudent1").val('');

   // alert(val);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewClassWiseStudents') }}",
      method: 'post',
      data: { classid : val},
      success: function(d) {
        data = d;
        feesheads = JSON.parse(d);
        $("#allStudents").DataTable().destroy();
        $("#allStudentsBody").empty();
        var j = 1;
        for (i = 0; i < feesheads.length; ++i) {
          $('#allStudentsBody').append('<tr onclick=CheckPaymentStatus(\'' + feesheads[i].studentid + '\')>' +
            '<td>' + '<input type="checkbox" checked value="' + feesheads[i].studentid + '" name="students[]">' + '</td>' +
            '<td>' + feesheads[i].studentid + '</td>' +
            '<td>' + feesheads[i].studentname + '</td>' +
            '<td id="customwidth">' + feesheads[i].fathername + '</td>' +
            '<td>' + feesheads[i].classname + '</td>' +
            '<td>' + feesheads[i].sectionname + '</td>' +
            '<td>' + feesheads[i].transportstatus + '</td>');
          j++;
        }
        $("#allStudents").DataTable();
      },
      error: function() {
      }
      });


      $.ajax({
      dataType: "json",
      url: "{{ route('admin.GetSectionClassWise') }}",
      method: 'post',
      data: { classid : val},
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

  function ClassSectionWiseStudents(Section){
    $("#All").val('');

      var classid=$('#classid').val();
      $("#searchStudent1").val('');
  
        $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
      });

      $.ajax({
        dataType: "json",
        url: "{{ route('admin.ViewStudentsClassANDsectionsWise') }}",
        method: 'post',
        data: { sectionid :Section,classid:classid},
        success: function(d) {
         // alert(d);
          feesheads = JSON.parse(d);
          data = d;
          $("#allStudents").DataTable().destroy();
          $("#allStudentsBody").empty();
          var j = 1;
          for (i = 0; i < feesheads.length; ++i) {
            $('#allStudentsBody').append('<tr onclick=CheckPaymentStatus(\'' + feesheads[i].studentid + '\')>' +
              '<td>' + '<input type="checkbox" checked value="' + feesheads[i].studentid + '" name="students[]">' + '</td>' +
              '<td>' + feesheads[i].studentid + '</td>' +
              '<td>' + feesheads[i].studentname + '</td>' +
              '<td id="customwidth">' + feesheads[i].fathername + '</td>' +
              '<td>' + feesheads[i].classname + '</td>' +
              '<td>' + feesheads[i].sectionname + '</td>' +
              '<td>' + feesheads[i].transportstatus + '</td>');
            j++;
          }
          $("#allStudents").DataTable();
          $(".searchedStudent").html(feesheads[0].studentname + '(' + feesheads[0].admissioninclass + ')');
        },
        error: function() {
        }
      });
    
  }
  function loadStudent(){

    $("#All").val('All');
    $("#classid").val('');
    $("#SectionData").val('');

    if($("#searchStudent").val()){ prefix
      var val = $("#prefix").html() + $("#searchStudent").val();
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
      });

      $.ajax({
        dataType: "json",
        url: "{{ route('admin.ViewSingleStudent') }}",
        method: 'post',
        data: { studentid : val},
        success: function(d) {
          $("#printBtn").show();
          feesheads = JSON.parse(d);
          data = d;
          $("#allStudents").DataTable().destroy();
          $("#allStudentsBody").empty();
          var j = 1;
          // console.log(data);
          for (i = 0; i < feesheads.length; ++i) {
            $('#allStudentsBody').append('<tr onclick=CheckPaymentStatus(\'' + feesheads[i].studentid + '\')>' +
              '<td>' + '<input type="checkbox" checked value="' + feesheads[i].studentid + '" name="students[]">' + '</td>' +
              '<td>' + feesheads[i].studentid + '</td>' +
              '<td>' + feesheads[i].studentname + '</td>' +
              '<td id="customwidth">' + feesheads[i].fathername + '</td>' +
              '<td>' + feesheads[i].ClassName + '</td>' +
              '<td>' + feesheads[i].SectionName + '</td>' +
              '<td>' + feesheads[i].transportstatus + '</td>');
            j++;
          }
          $("#All").val('');
          $("#classid").val('');
          $("#SectionData").val('');
          $("#stdid").val(val);
          $("#searchStudent2").val(2);
          $("#searchStudent1").val(2);
          $("#allStudents").DataTable();
          $(".searchedStudent").html(feesheads[0].studentname + '(' + feesheads[0].admissioninclass + ')');
        },
        error: function() {
        }
      });
    }else{
      alert("Insert student Id")
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
      url: "{{ route('admin.GenerateFees') }}",
      method: 'post',
      data: $("#FeesForm").serialize(),
      success: function(d) {
        if(d.result=="save"){
          swal('Success','Fee Generated SuccessFully', 'success');
        }else{
          swal('Warning','Issue While Generation Fee', 'warning');
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