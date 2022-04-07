@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $asessions = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->get();
      $classes = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      // $subjects = \App\Models\Subject::where('campusid', Auth::user()->campusid)->where('isdisplay', 1)->get();
      $checkSessionwhise = "";
    ?>

    <form id="studentMarks" action="/admin" method="POST" onsubmit="return false">
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
          <select name="term" class="form-control form-control-sm" onchange="$('#RoleData').empty()" id="term" required>
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
          <select name="section" id="section" onchange="FetchPersonalDevelopment()"
            class="form-control form-control-sm">
          </select>
        </div>

        <div class="col-md-3">
          <label for="subject" class="form-label"><b>Personal Development Tag</b></label>
          <select name="subject" onchange="FetchStudents(this.value)" id="subject" class="form-control form-control-sm">
          </select>
        </div>
      </div>




      <div class="row">
        <div class="col-md-12">
          <table class="table table-sm table-responsive-sm" id="example3">
            <thead>
              <tr>
                <th>#.</th>
                <th>Std ID</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>Comment</th>
                {{-- <th>Theory</th>
                <th>IsAbsent</th>
                <th>PT</th>
                <th>Practical</th>
                <th>IsAbsent</th> --}}
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
        url: "{{ route('admin.AddStudentPersonalDevelopment') }}",
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

  function FetchStudents(e){
    if(!e){
      $("#RoleData").empty();
      return;
    }
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
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
        dataType: "json",
        type: 'POST',
        url: "{{ route('admin.FetchStudentsForPersonalDevelopment') }}",
        data: {classid: classid, sectionid: section, Pd_id: e,termID:termID,sessionID},
        success: function(d)
        {
          dataa = JSON.parse(d);
          console.log(dataa);
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
              '<td>' + dataa[i].fathername + '</td>' +
              '<td>' + 
                '<input type="hidden" value="' + dataa[i].sessionid + '" name="sessionid[]"/>' +
                '<input type="hidden" value="' + dataa[i].termid + '" name="termid[]"/>' +
                '<input type="hidden" value="' + dataa[i].classid + '" name="classid[]"/>' +
                '<input type="hidden" value="' + dataa[i].sectionid + '" name="sectionid[]"/>' +
                '<input type="hidden" value="' + dataa[i].studentid + '" name="studentid[]"/>' +
                '<input type="hidden" value="' + dataa[i].pdid + '" name="pdid[]"/>' +
                '<select name="comment[]" class="form-control form-control-sm"><option value="">Select Tag</option><option ' + (dataa[i].comment == 'S' ? 'selected' : dataa[i].comment) + '  value="S">Satisfactory</option><option  ' + (dataa[i].comment == 'G' ? 'selected' : dataa[i].comment) + ' value="G">Good</option><option  ' + (dataa[i].comment == 'E' ? 'selected' : dataa[i].comment) + '  value="E">Excellent</option></td>' +
              +'</tr>');
              theory = theory + j;
              practical = practical + j;
            j++;

            $('#subjectid').append('<option value="' + dataa[i].id + '">'+
            dataa[i].name +'</option>');        
          }
          $('#RoleData').append('<tr><td colspan="2"><button id="submitFrom" type="submit" class="btn btn-primary btn-sm btn-block">Save Development</button><td><td></td><td></td></tr>');
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
  }

  function FetchPersonalDevelopment(){
    $("#RoleData").empty();
    let e = $("#class").val();
    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchPersonalDevelopment') }}",
        data: {classId: e},
        success: function(SessionData)
        {
          sessionData=JSON.parse(SessionData);
          $("#subject").empty();
          var j=1;
          $('#subject').append("<option value=''>Select Personal Dev Tag</option>");
          for (i=0; i < sessionData.length; ++i) {
            $('#subject').append('<option value=' + sessionData[i].pdid+'>'+ sessionData[i].pname +'</option>');
            j++;
          }
        },
        error: function()
        {
          alert('Error');
        }
      });
  }

  function CheckTheoryMarks(e, event){
    if(e > theorymarks){
      event.target.value = 0;
      swal("Warning!", "Obtain marks should no be greator than total marks!", "error");
    }
  }

  function CheckPracticalMarks(e, event){
    if(e > practicalmarks){
      event.target.value = 0;
      swal("Warning!", "Obtain marks should no be greator than total marks!", "error");
    }
  }

</script>



@endsection