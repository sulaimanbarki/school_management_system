@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $classes = \App\Models\addClass::where('CampusID', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
      $sessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsActive', '1')->where("IsCurrent", '1')->get();
      // dd($sessions);
    ?>

    <form id="StudentPromotionFrom" action="#" method="POST">
      @csrf
      <div class="row  pt-1 pb-1">
        <div class="col-md-2">
          <label for="academicsession" class="form-label"><b>Academic Session</b></label>
          <select class="form-control form-control-sm" id="academicsession" required name="academicsession"
            placeholder="">
            <option value="">Choose session</option>
            @foreach ($sessions as $session)
            <option {{ ($session->IsActive and $session->IsCurrent) ? "selected" : "" }} value="{{ $session->id }}">{{
              $session->Session }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="formClass" class="form-label"><b>From Class</b></label>
          <select name="formClass" class="form-control form-control-sm" onchange="FetchSections(this.value)" required
            name="formClass" id="formClass">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
            <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label for="formSection" class="form-label"><b>From Section</b></label>
          <select name="formSection" onchange="ClassSectionWiseStudents(this.value)" required
            class="form-control form-control-sm" id="formSection">

          </select>
        </div>
        <div class="col-md-3">
          <label for="toClass" class="form-label"><b>To Class</b></label>
          <select name="toClass" class="form-control form-control-sm" onchange="FetchSectionsForPromotion(this.value)"
            required name="toClass" id="toClass">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
            <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label for="toSection" class="form-label"><b>To Section</b></label>
          <select name="toSection" class="form-control form-control-sm" id="toSection" required>
          </select>
        </div>
      </div>
    </form>
  </div>

</div>
<form action="#" onsubmit="return false" id="submitFrom">
<div class="row">
  <div class="col-md-12">
    <table class="table table-responsive-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" class="checkbox" value="" id="checkall">
                <label class="form-check-label" for="checkall">Check</label>
              </div>
            </th>
            <th>Std. Id</th>
            <th>Student Name</th>
            <th>Father Name</th>
          </tr>
        </thead>
        <tbody id="tablebody">

        </tbody>
    </table>
  </div>
</div>
</form>
<script>
  const PromoteStudents = e => {
    if(!$("#formClass").val() || !$("#formSection").val() || !$("#toClass").val() || !$("#toSection").val()){
      swal({
        title: "Error",
        text: "Please select classes and sections for promotion",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      });
    }else{;
      $.ajax({
        dataType: "text",
        url: "{{ route('admin.PromoteStudents') }}",
        method: 'post',
        data: $("#StudentPromotionFrom, #submitFrom").serialize(),
        success: function(d) {
          if(d == 'empty'){
            swal({
              title: "Warning",
              text: "Please select student(s) for promotion.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            });
            return;
          }
          swal({
            title: "Success",
            text: "Succussfully promoted",
            icon: "success",
            buttons: true,
            dangerMode: true,
          });
          // data = d;
          // students = JSON.parse(d);
          // $("#allStudents").DataTable().destroy();
          ClassSectionWiseStudents($("#formSection").val());
          // $("#tablebody").empty();
        },
        error: function(err) {
          console.log(err);
        }
      });
    }
  }

  function ClassSectionWiseStudents(Section){
      $("#All").val('');
      var classid = $('#formClass').val();
      $("#searchStudent1").val('');
  
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        dataType: "json",
        url: "{{ route('admin.FetchStudentForStudentPromotion') }}",
        method: 'post',
        data: { sectionid :Section,classid:classid},
        success: function(d) {
        data = d;
        students = JSON.parse(d);
        // $("#allStudents").DataTable().destroy();
        $("#tablebody").empty();
        // console.log(students);
        var j = 1;
        for (i = 0; i < students.length; i++) {
          $('#tablebody').append('<tr>' +
            '<td>' + j + '</td>' +
            '<td>' + '<input type="checkbox" onchange="changeCheckValue(event)" value="' + students[i].studentid + '" name="students[]"><input type="hidden" class="checkstatus" value="0" name="checkStatus[]">' + '</td>' +
            '<td>' + students[i].studentid + '</td>' +
            '<td>' + students[i].studentname + '</td>' +
            '<td>' + students[i].fathername + '</td>');
          j++;
        }
        $('#tablebody').append('<tr><td colspan="2"><button onclick="PromoteStudents()" type="submit" class="btn btn-primary btn-sm">Promote Students</button></td><td></td><td></td><td></td></tr>');
        // $("#allStudents").DataTable();
        },
        error: function() {
        }
      });
    
  }
  
  function FetchSectionsForPromotion(e){
    $.ajax({
      dataType: "json",
      type: 'GET',
      url: "{{ route('admin.FetchSectionForClassConfigration') }}",
      data: {classId: e},
      success: function(SessionData)
      {
        sessionData=JSON.parse(SessionData);
        $("#toSection").empty();
        var j=1;
        $('#toSection').append("<option value=''>Select section</option>");
        for (i=0; i < sessionData.length; ++i) {
          $('#toSection').append('<option value='+sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
          j++;
        }
      },
      error: function()
      {
        alert('internet issue');
      }
    });
  }

  function FetchSections(e){
    $.ajax({
      dataType: "json",
      type: 'GET',
      url: "{{ route('admin.FetchSectionForClassConfigration') }}",
      data: {classId: e},
      success: function(SessionData)
      {
        $("#tablebody").empty();
        sessionData=JSON.parse(SessionData);
        $("#formSection").empty();
        // $("#toSection").empty();
        var j=1;
        $('#formSection').append("<option value=''>Select section</option>");
        for (i=0; i < sessionData.length; ++i) {
          $('#formSection').append('<option value='+sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
          j++;
        }
      },
      error: function()
      {
        alert('internet issue');
      }
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      dataType: "json",
      type: 'POST',
      url: "{{ route('admin.ViewClass') }}",
      success: function(SessionData)
      {
        $("#toClass").empty();
        sessionData=JSON.parse(SessionData);
        $('#toClass').append("<option value=''>Select class</option>");
        for (i=0; i < sessionData.length; ++i) {
          // if($("#formClass").val() == sessionData[i].C_id)
          //   continue;
          $('#toClass').append('<option value='+sessionData[i].C_id+'>'+ sessionData[i].ClassName +'</option>');
        }
      },
      error: function()
      {
        alert('internet issue');
      }
    });
  }

  $("#checkall").click(function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
    $('input:checkbox').each(function (indexInArray, valueOfElement) {
      if(this.checked){
        this.nextSibling.value = 1;
      }else{
        this.nextSibling.value = 0;
      }
    });
  });

  $(document).on("click", "#tablebody tr",function() {
    // console.log(this);
    // $(this).find(".checkbox").prop('checked', true);
    if($(this).find("input[type='checkbox']").prop('checked'))
      $(this).find("input[type='checkbox']").prop('checked', false);
    else
      $(this).find("input[type='checkbox']").prop('checked', true);
      
  });

  function changeCheckValue(e){
    if(e.target.nextSibling.value == 1){
      e.target.nextSibling.value = 0;
      e.target.checked = false;
    }else{
      e.target.nextSibling.value = 1;
      e.target.checked = true;
    }
  }
</script>



@endsection