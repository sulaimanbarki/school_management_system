@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $asessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->get();
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
      $classes = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      // $subjects = \App\Models\Subject::where('campusid', Auth::user()->campusid)->where('isdisplay', 1)->get();
      $checkSessionwhise = "";
    ?>
    <form id="studentMarks" method="POST" onsubmit="return false" onkeydown="return event.key != 'Enter';">
      @csrf
      <div class="row  pt-1 pb-1">
        <div class="col-md-3">
          <label for="asession" class="form-label"><b>Academic Session</b></label>
          <select class="form-control form-control-sm" onchange="FetchTerms(this.value)" required name="asession"
            id="asession">
            <option value="">Select Session</option>
            @foreach ($asessions as $asession)
            <option {{ $asession->IsCurrent ? "selected" : "" }} value="{{ $asession->id }}">{{ $asession->Session }}</option>
            <?php $checkSessionwhise = $asession->IsCurrent ? $asession->id : $checkSessionwhise; ?>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="term" class="form-label"><b>Terms</b></label>
          <select name="term" class="form-control form-control-sm" id="term" required>
            <?php 
              $terms = \App\Models\TermName::where('campusid', Auth::user()->campusid)->where('sessionid', $checkSessionwhise)->where('isdisplay', 1)->get();
            ?>
            <option value="">Select term</option>
            @foreach ($terms as $term)
            <option {{ $term->isactive ? "selected" : "" }} value="{{ $term->id }}">{{ $term->termname }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 d-none" id="successMessage">
          
            <label for=""  class="form-label">&nbsp;</label>
            <input type="submit" class="btn btn-success btn-sm btn-block" value="Success">
        </div>
      </div>

      <div class="row  pt-1 pb-1">
        <div class="col-md-3">
          <label for="class" class="form-label"><b>Class</b></label>
          <select type="date" name="class" id="class" onchange="FetchSections(this.value)"
            class="form-control form-control-sm">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
            <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label for="section" class="form-label"><b>Sections</b></label>
          <select name="section" id="section" onchange="ResetSubject()" class="form-control form-control-sm">
          </select>
        </div>

        <div class="col-md-3">
          <label for="subject" class="form-label"><b>Subject</b></label>
          <select name="subject" onchange="FetchStudents(this.value)" id="subject" class="form-control form-control-sm">
          </select>
        </div>
      </div>
      @php
          $role = App\Models\Role::where('RoleID', Auth::user()->roleid)->value('Role');
      @endphp
      @if ($role == 'Admin' or $role == 'admin')
      <hr>
      <div class="row">
        <div class="col-md-2">
          {{-- <div class="form-group">
            <label for="studentId">Single Student Search (Student Id)</label>
            <input type="search" class="form-control form-control-sm" id="studentId" name="studentId">
          </div> --}}
          <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">{{$campus->CampusPrefix}}</span>
            </div>
            <input type="text" class="form-control" placeholder="Single Student Search (Student Id)" name="studentId"
              id="studentId">
          </div>
        </div>
        <div class="col-md-1">
          <div class="form-group">
            {{-- <label>&nbsp;</label> --}}
            <input type="button" value="Search" class="form-control bg-primary text-white form-control-sm"
              id="searchStudentByid" onclick="searchStudentById()">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            {{-- <label>&nbsp;</label> --}}
            <input type="text" value="" class="form-control form-control-sm" id="studentStatus" readonly>
          </div>
        </div>
      </div>
      @endif

      <div class="row">
        <div class="col-md-12">
          <table class="table table-sm table-responsive-sm" id="example3">
            <thead>
              <tr>
                <th>#.</th>
                <th>Std ID</th>
                <th>Student Name</th>
                <th>Subject</th>
                <th>TT</th>
                <th>Theory</th>
                <th>IsAbsent</th>
                <th>PT</th>
                <th>Practical</th>
                <th>IsAbsent</th>
              </tr>
            </thead>
            <tbody id="RoleData">

            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function disableMarksBox(e){
    if(e.target.value == 1){
      e.target.parentElement.previousSibling.firstChild.setAttribute('readonly', 'readonly');
      e.target.parentElement.previousSibling.firstChild.value = 0;
    }else{
      e.target.parentElement.previousSibling.firstChild.removeAttribute('readonly');
    }
  }
  $(document).ready(function() {
    $('#insertSubject').show();
    $("#updateRole").hide();
    $('#UpdateTerm').hide();
    var dataa = '';
    var examTerms = '';

    $(document).on("click","#SubmitSinglStudentForm",function() {
      let asession = $("#asession").val();
      let term = $("#term").val();
      if(!asession || !term){
        swal("Warning!", "Pleas select academic session and exam term", "error");
        return;
      }
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.AddSingleStudentMarks') }}",
        method: 'POST',
        data: $("#studentMarks").serialize(),
        success: function(result){
        //  swal("Good job!", "Campus is successfully added!", "success");
        $("#successMessage").removeClass("d-none");
        setTimeout(() => {
          $("#successMessage").addClass("d-none");
        }, 2000);
        },
        error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,error){
            swal('Warning', error[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }
      });

    });
    $(document).on("click","#submitFrom",function() {
      let asession = $("#asession").val();
      let term = $("#term").val();
      if(!asession || !term){
        swal("Warning!", "Pleas select academic session and exam term", "error");
        return;
      }
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        url: "{{ route('admin.AddStudentsMarks') }}",
        method: 'POST',
        data: $("#studentMarks").serialize(),
        success: function(result){
        //  swal("Good job!", "Campus is successfully added!", "success");
        $("#successMessage").removeClass("d-none");
        setTimeout(() => {
          $("#successMessage").addClass("d-none");
        }, 2000);
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
  var theorymarks = 0;
  var practicalmarks = 0;
  function FetchTerms(e){
    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchTermsForClassWiseMarks') }}",
        data: {sessionid: e},
        success: function(SessionData)
        {
          sessionData=JSON.parse(SessionData);
          $("#term").empty();
          var j=1;
          $('#term').append("<option value=''>Select Term</option>");
          for (i=0; i < sessionData.length; ++i) {
            $('#term').append('<option value='+sessionData[i].id+'>'+ sessionData[i].termname +'</option>');
            j++;
          }
        },
        error: function()
        {
          alert('internet issue');
        }
    });
  }

  var theorymarks;
  function FetchStudents(e){
    var subjectt = $("#subject option:selected").html();
    const classid = $("#class").val();
    const section = $("#section").val();
    const sessionID = $("#asession").val();
    const termID = $("#term").val();
  
    if(!classid){
      swal("Warning!", "Please select Class!", "error");
      return;
    }
    if(!section){
      swal("Warning!", "Please select Section!", "error");
      return;
    }
    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchStudentsForSubjectWiseMarks') }}",
        data: {classid: classid, sectionid: section, subjectid: e,termID:termID,sessionID},
        success: function(d)
        {
          dataa = JSON.parse(d);
          // $("#example3").DataTable().destroy();  
          $("#RoleData").empty();
          var j = 1;
          let theory = "theory";
          let practical = "practical";
          for (i = 0; i < dataa.length; ++i) {
            
            theorymarks = dataa[i].theorymarks;
            practicalmarks = dataa[i].practicalmarks;
            $('#RoleData').append('<tr>' +
              '<td>' + j + '</td>' +
              '<td>' + dataa[i].studentid + '</td>' +
              '<td>' + dataa[i].studentname + '</td>' +
              '<td>' + subjectt + '</td>' +
              '<td style="width: 9%"><input name="theorymarkstotal[]" type="number" readonly value="' + dataa[i].theorymarks + '" class="form-control form-control-sm">' + '</td>' +
              '<td style="width: 12%"><input name="theorymarks[]" min="0" id="' + theory + '"  onfocus="this.select()"    onkeydown="javascript:if (event.keyCode == 13) document.getElementById(\'' + theory + j + '\').focus()"    onchange="CheckTheoryMarks(this.value, event, ' + dataa[i].theorymarks + ')" ' + (dataa[i].isabsenct_theory ? 'readonly' : '') + ' type="number" value="' + dataa[i].obtain_marks_theory + '" class="form-control form-control-sm">  <input type="hidden" value="' + dataa[i].studentid + '" class="form-control form-control-sm d-none" name="studentid[]">' + '</td>' +
              '<td style="width: 12%"><select onchange="disableMarksBox(event)" name="isAbsentTheory[]" class="form-control form-control-sm" ><option value="0">No</option><option ' + (dataa[i].isabsenct_theory ? 'selected' : '') + ' value="1">Yes</option></select>' + '</td>' +
              '<td style="width: 7%"><input name="practicalmarkstotal[]" type="number" readonly value="' + dataa[i].practicalmarks + '" class="form-control form-control-sm">' + '</td>' + 
              '<td style="width: 16%"><input name="practicalmarks[]" id="' + practical + '" onfocus="this.select()" onkeydown="javascript:if (event.keyCode == 13) document.getElementById(\'' + practical + j + '\').focus()"  min="0" onchange="CheckPracticalMarkss(this.value, event)" ' + (dataa[i].isabsenct_practical ? 'readonly' : '') + ' type="number" value="' + dataa[i].obtain_marks_practical + '" class="form-control form-control-sm" value="' + dataa[i].obtain_marks_practical + '">' + '</td>' +
              '<td style="width: 12%"><select onchange="disableMarksBox(event)" name="isAbsentPractical[]" class="form-control form-control-sm" ><option value="0">No</option><option ' + (dataa[i].isabsenct_practical ? 'selected' : '') + ' value="1">Yes</option></select></td>' +
              +'</tr>');
              theory = theory + j;
              practical = practical + j;
            j++;

            $('#subjectid').append('<option value="' + dataa[i].id + '">'+
            dataa[i].name +'</option>');        
          }
          $('#RoleData').append('<tr><td colspan="2"><button id="submitFrom" type="submit" class="btn btn-primary btn-sm btn-block">Save Students Marks</button><td><td></td><td></td><td></td><td></td><td></td></tr>');
          // $("#example3").DataTable();


        },
        error: function()
        {
          alert('internet issue');
        }
      });
  }

  function FetchSections(e){
    $("#RoleData").empty();
    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchSectionForClassConfigration') }}",
        data: {classId: e},
        success: function(SessionData)
        {
          sessionData=JSON.parse(SessionData);
          $("#section").empty();
          var j=1;
          $('#section').append("<option value=''>Select Section</option>");
          for (i=0; i < sessionData.length; ++i) {
            $('#section').append('<option value=' + sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
            j++;
          }
        },
        error: function()
        {
          alert('internet issue');
        }
      });

    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchSubjectsForSubjectWiseMarks') }}",
        data: {classId: e},
        success: function(SessionData)
        {
          sessionData=JSON.parse(SessionData);
          $("#subject").empty();
          var j=1;
          $('#subject').append("<option value=''>Select subject</option>");
          for (i=0; i < sessionData.length; ++i) {
            $('#subject').append('<option value=' + sessionData[i].subjectid+'>'+ sessionData[i].name +'</option>');
            j++;
          }
        },
        error: function()
        {
          alert('Error');
        }
      });
  }

  function ResetSubject(){
    $("#RoleData").empty();
    $('#subject').prop('selectedIndex',0);
  }

  function CheckTheoryMarks(e, event){
    // alert(theorymarks);
    if(e > theorymarks){
      event.target.value = 0;
      swal("Warning!", "Obtain marks should no be greator than total marks!", "error");
    }
  }
// single student
  function CheckTheoryMarks(e, event, thmarks){
    if(e > thmarks){
      event.target.value = 0;
      swal("Warning!", "Obtain marks should no be greator than total marks!", "error")
      .then(confirm => {
        if(confirm)
        event.target.focus();
      })
      
    }
  }

  function CheckPracticalMarkss(e, event){
    if(e > practicalmarks){
      event.target.value = 0;
      swal("Warning!", "Obtain marks should no be greator than total marks!", "error")
      .then(confirm => {
        if(confirm)
        event.target.focus();
      })
    }
  }
  function CheckPracticalMarks(e, event, pmarks){
    // console.log(e, pmarks);
    if(parseInt(e) > pmarks){
      event.target.value = 0;
      swal("Warning!", "Obtain marks should no be greator than total marks!", "error");
    }
  }

</script>
<script>
  function searchStudentById() {
    let stdid = $(".input-group-text").html();
    let stdidd = $("#studentId").val();
    let classid = $("#class").val();
    const sessionID = $("#asession").val();
    const termID = $("#term").val();
  
    if(!sessionID){
      swal("Warning!", "Please select session!", "error");
      return;
    }
    if(!termID){
      swal("Warning!", "Please select term!", "error");
      return;
    }
    if(!classid){
      swal("Warning!", "Please select Class...!", "error");
      return;
    }
    if(!stdidd){
      swal("Warning!", "Please insert student id...!", "error");
      return;
    }
    stdidd = stdid + stdidd;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
    $.ajax({
        dataType: "json",
        type: 'POST',
        url: "{{ route('admin.FetchSingleStudentForSubjectWiseMarks') }}",
        data: {studentid: stdidd ,termID:termID, sessionID: sessionID,classid:classid},
        success: function(d)
        {
          dataa = JSON.parse(d);
          // $("#example3").DataTable().destroy();  
          $("#RoleData").empty();
          var j = 1;
          let theory = "theory";
          let practical = "practical";
          for (i = 0; i < dataa.length; ++i) {
            practicalmarks = dataa[i].practicalmarks;
            theorymarks = dataa[i].theorymarks;
            $("#studentStatus").val(dataa[i].status);
            $('#RoleData').append('<tr>' +
              '<td>' + j + '</td>' +
              '<td>' + dataa[i].studentid + '</td>' +
              '<td>' + dataa[i].studentname + '</td>' +
              '<td>' + dataa[i].name + '<input name="subjectidd[]" type="hidden" value="' + dataa[i].subjectid + '" class="form-control form-control-sm"></td>' +
              '<td style="width: 9%">' + '<input name="theorymarkstotal[]" type="number" readonly value="' + dataa[i].theorymarks + '" class="form-control form-control-sm">' + '</td>' +
              '<td style="width: 12%">' + '<input name="theorymarks[]" min="0" id="' + theory + '"  onfocus="this.select()"    onkeydown="javascript:if (event.keyCode == 13) document.getElementById(\'' + theory + j + '\').focus()"   onchange="CheckTheoryMarks(this.value, event, ' + dataa[i].theorymarks + ')" ' + (dataa[i].isabsenct_theory ? 'readonly' : '') + ' type="number" value="' + dataa[i].obtain_marks_theory + '" class="form-control form-control-sm">  <input type="hidden" value="' + dataa[i].studentid + '" class="form-control form-control-sm d-none" name="studentidd[]">' + '</td>' +
              '<td style="width: 12%">' + '<select onchange="disableMarksBox(event)" name="isAbsentTheory[]" class="form-control form-control-sm" ><option value="0">No</option><option ' + (dataa[i].isabsenct_theory ? 'selected' : '') + ' value="1">Yes</option></select>' + '</td>' +
              '<td style="width: 7%">' + '<input name="practicalmarkstotal[]" type="number" readonly value="' + dataa[i].practicalmarks + '" class="form-control form-control-sm">' + '</td>' + 
              '<td style="width: 16%">' + '<input name="practicalmarks[]" id="' + practical + '" onfocus="this.select()" onkeydown="javascript:if (event.keyCode == 13) document.getElementById(\'' + practical + j + '\').focus()"  min="0" onchange="CheckPracticalMarks(this.value, event, ' + dataa[i].practicalmarks + ')" ' + (dataa[i].isabsenct_practical ? 'readonly' : '') + ' type="number" value="' + dataa[i].obtain_marks_practical + '" class="form-control form-control-sm" value="' + dataa[i].obtain_marks_practical + '">' + '</td>' +
              '<td style="width: 12%">' + '<select onchange="disableMarksBox(event)" name="isAbsentPractical[]" class="form-control form-control-sm" ><option value="0">No</option><option ' + (dataa[i].isabsenct_practical ? 'selected' : '') + ' value="1">Yes</option></select>' + '</td>' +
              +'</tr>');
              theory = theory + j;
              practical = practical + j;
            j++;

            $('#subjectid').append('<option value="' + dataa[i].id + '">'+
            dataa[i].name +'</option>');        
          }
          $('#RoleData').append('<tr><td colspan="2"><button id="SubmitSinglStudentForm" type="submit" class="btn btn-primary btn-sm btn-block">Save Student Marks</button><td><td></td><td></td><td></td><td></td><td></td></tr>');
          // $("#example3").DataTable();


        },
        error: function()
        {
          alert('internet issue');
        }
      });
  }
</script>


@endsection