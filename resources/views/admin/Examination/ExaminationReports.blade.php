@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $asessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('IsActive', 1)->get();
      $classes = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->where('SchoolStatus', 'Active')->first();
      // $subjects = \App\Models\Subject::where('campusid', Auth::user()->campusid)->where('isdisplay', 1)->get();
      $checkSessionwhise = "";
    ?>

    <form id="ExamReportsForm" action="/admin" method="POST">
      @csrf
      <div class="row  pt-1 pb-1">
        <div class="col-md-2">
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
        <div class="col-md-2">
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
        <div class="col-md-2">
          <label for="class" class="form-label"><b>Class</b></label>
          <select type="date" name="class" id="class" onchange="FetchSections(this.value)"
            class="form-control form-control-sm">
            <option ">Select Class</option>
            @foreach ($classes as $class)
            <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label for="section" class="form-label"><b>Sections</b></label>
          <select name="section" id="section" onchange="ResetSubject()" class="form-control form-control-sm" required>
          </select>
        </div>
        <div class="col-md-2">
          <label for="subject" class="form-label"><b>Subject</b></label>
          <select name="subject" id="subject" class="form-control form-control-sm" required>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="exampleInputPassword1">Student Id</label>
            <input type="search" onkeyup="ClearFields(event)" value="{{ $campus->CampusPrefix }}" id="studentid"
              class="form-control form-control-sm" name="studentid">
          </div>
        </div>
        <div class="col-md-1">
          <div class="form-group">
            <label for="exampleInputPassword1">&nbsp;</label>
            <input type="submit" form="studentMarks" onclick="SeachStudent(this.value)"
              class="form-control form-control-sm bg-primary" value="Search" name="attendancemonth">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="exampleInputPassword1">Name</label>
            <input type="text" form="ExamReportsForm" readonly class="form-control form-control-sm" id="studentname"
              name="attendancemonth">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="exampleInputPassword1">Class</label>
            <input type="text" form="ExamReportsForm" readonly id="fathername" class="form-control form-control-sm"
              name="attendancemonth">
          </div>
        </div>
        <div class="col-md-2 d-none buttonColomn">
          <br>
          <button formtarget='_blank' formaction="/admin/ExamRptSinglStudent" type="submit" form="ExamReportsForm"
            class="btn btn-sm btn-primary btn-block mt-2" onclick="DisableFormSectionAndSubject(event)" >Print DMC</button>
        </div>
      </div>
    </form>

    {{-- <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="subject" class="form-label"><b>Subject</b></label>
          <select name="subject" id="subject" class="form-control form-control-sm">
          </select>
        </div>
        <div class="form-check ml-2">
          <input class="form-check-input" type="checkbox" value="" id="transport">
          <label class="form-check-label" for="transport">
            All Subjects
          </label>
        </div>
      </div>
    </div> --}}

    <hr>
    <div class="row">
      <div class="col-md-4">
        <button formtarget='_blank' formaction="/admin/AwardListWithoutdata" type="submit" form="ExamReportsForm"
          class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">
          Award List Without data</button>

        <button formtarget='_blank' formaction="/admin/AwardListWithdata" type="submit" form="ExamReportsForm"
          class="btn btn-sm btn-primary btn-block" onclick="DisableFormBothAttribute(event)">Award List with
          data</button>

        <hr>
        <button formtarget='_blank' formaction="/admin/ClassandSectionWiseWithoutData"
          onclick="DisableFormSubject(event)" type="submit" form="ExamReportsForm"
          class="btn btn-sm btn-primary btn-block">Class & Section Wise Award List
          without data</button>

        <button formtarget='_blank' formaction="/admin/ClassandSectionWiseWithData" onclick="DisableFormSubject(event)"
          type="submit" form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Class & Section Wise Award List
          with data</button>

        <hr>
        <button formtarget='_blank' formaction="/admin/ClassWiseAwardListWithoutData"
          onclick="DisableFormSectionAndSubject(event)" type="submit" form="ExamReportsForm"
          class="btn btn-sm btn-primary btn-block">ClassWise Award List Without Data</button>
        <button formtarget='_blank' formaction="/admin/ClassWiseAwardListWithData"
          onclick="DisableFormSectionAndSubject(event)" type="submit" form="ExamReportsForm"
          class="btn btn-sm btn-primary btn-block">ClassWise Award List With Data</button>
        <hr>

        <button formtarget='_blank' formaction="{{ route('admin.AllSubjectAwardList') }}"
          onclick="DisableFormSubject(event)" type="submit" form="ExamReportsForm"
          class="btn btn-sm btn-primary btn-block">All subjects award list ordered by Student ID</button>

        {{-- <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit"
          form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Class Top 10 positions</button> --}}
      </div>


      <div class="col-md-4">
        <button formtarget='_blank' formaction="/admin/PersonalDevelopmentWithoutData" type="submit"
          form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Personal Development Without Data</button>

        <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit"
          form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Personal Development with Data</button>

        {{-- <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit"
          form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Class Test List</button> --}}

      </div>


      <div class="col-md-4">
        {{-- <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit"
          form="ExamReportsForm" onclick="DisableFormSubject(event)" class="btn btn-sm btn-primary btn-block">Result Card</button> --}}

        <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseResult" type="submit" form="ExamReportsForm"
          class="btn btn-sm btn-primary btn-block" onclick="DisableFormSubject(event)" >All Result Card</button>
{{-- 
        <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit"
          form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Calculate Position Grade</button>

        <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit"
          form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Calculate Mid Term Marks</button>

        <button formtarget='_blank' formaction="/admin/ClassAndSectionWiseOutstanding" type="submit"
          form="ExamReportsForm" class="btn btn-sm btn-primary btn-block">Attendence Subjects Award List Ordered
          by</button> --}}

      </div>
    </div>
  </div>
</div>

<script>
  var prefix = "{{$campus->CampusPrefix}}";
  var camspusPrefixLength = "{{$campus->CampusPrefix}}".length;
  function ClearFields(e){
    $("#studentname").val("");
    $("#fathername").val("");
    $(".buttonColomn").addClass('d-none');
    // alert(e.target.value.length);
    if(e.target.value.length <= camspusPrefixLength){
      e.target.value = prefix;
    }
  }
  function SeachStudent(e){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ route('admin.ExamResultFetchStudentInfo') }}",
      method: 'POST',
      data: { studentid: $("#studentid").val()},
      success: function(d){
        if(d == 'null'){
          swal('Warning', 'No record found with this id.', 'warning');
          $("#studentname").val("");
          $("#fathername").val("");
          $(".buttonColomn").addClass('d-none');
          return;
        }
        var std = JSON.parse(d);
        $("#studentname").val(std.studentname);
        $("#fathername").val(std.fathername);
        $(".buttonColomn").removeClass('d-none');
      },
      error: function(error) {
        $.each(error.responseJSON.errors, function(field_name,error){
          swal('Warning', error[0], 'warning');
            // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
        });
      }
    });


  }
  $(document).ready(function() {
    $('#insertSubject').show();
    $("#updateRole").hide();
    $('#UpdateTerm').hide();
    var dataa = '';
    var examTerms = '';

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
          // console.log(sessionData);
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

  function DisableFormSubject(e){
    $("#subject").removeAttr('required');
    setTimeout(() => {
      $("#subject").attr('required', 'required');
    }, 1000);
  }

  function DisableFormSectionAndSubject(e){
    $("#subject").removeAttr('required');
    $("#section").removeAttr('required');
    setTimeout(() => {
      $("#subject").attr('required', 'required');
      $("#section").attr('required', 'required');
    }, 1000);
  }

</script>



@endsection