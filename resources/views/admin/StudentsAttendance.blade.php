@extends('admin.admin_master')



@section('Admindata')

<form action="" onsubmit="return false" id="attendanceForm">
  <div class="row">

    <div class="col-md-3">
      <label for="date"><b>Date</b></label>
      <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm" id="date" required
        name="date" placeholder="">
    </div>
    <div class="col-md-3">
      <label for="class"><b>Class</b></label>
      <select name="class" id="class" onchange="fetchSectionForClass(this, this.selectedIndex)" required
        class="form-control form-control-sm">

      </select>
    </div>
    <div class="col-md-3">
      <label for="section"><b>Section</b></label>
      <select name="section" disabled required class="form-control form-control-sm" id="section">

      </select>
    </div>
    <div class="col-md-3">
      <label for="admissiondate"><b>&nbsp;</b></label>
      <input type="submit" value="Search" class="form-control form-control-sm bg-primary text-white" id="admissiondate"
        required name="admissiondate" placeholder="">
    </div>
  </div>
</form>
<br>

<form action="" id="attendantForm" onsubmit="return false">
  <div class="row">
    <div class="col-md-12">
      <table class="table">
        <thead>
          <th>Std. No.</th>
          <th>Std. Name</th>
          <th>Attendance</th>
          <th>Note</th>
        </thead>
        <tbody id="body">

        </tbody>
      </table>
    </div>
  </div>
</form>



</div>
<script src="{{ asset('userbackend/plugins/axios/axios.min.js') }}"></script>
<script>
  // const changeAttendance = e => {
  //   let description = e.parentNode.parentNode.nextSibling.childNodes[0].value;
  //   console.log(description);
  // }

  $("#attendantForm").submit(() => {
    axios.post('{{ route("admin.saveAttendance") }}', $("#attendantForm").serialize())
    .then(res => swal('Success', 'Attendance saved successfully', 'success'))
    .catch();
  });
  $("#attendanceForm").submit(() => {
    if($("#class").length && $("#section").length){
      axios.post("{{ route('admin.fetchStudentForAttendance') }}",
      $("#attendanceForm").serialize())
      .then(res => {
        res = JSON.parse(res.data);
        let content = "";
        let present = "present";
        let absent = "absent";
        let late = "late";
        let shortleave = "shortleave";
        for(let i = 0; i < res.length; i++){
          content += '<tr>' +
          '<td>' + res[i].studentid + '<input type="hidden" name="tableid[]" value="' + res[i].id + '" /></td>' +
          '<td>' + res[i].studentname + '</td>' +
          '<td>' +
            '<div class="form-check form-check-inline"><input  class="form-check-input" ' + (res[i].status == 'Present' ? 'checked' : '') + ' type="radio" name="attendence['+i+']" id="' + present + i + '" value="Present">' +
            '<label class="form-check-label" for="' + present + i + '">Present</label></div>' +
            '<div class="form-check form-check-inline"><input class="form-check-input" ' + (res[i].status == 'Absent' ? 'checked' : '') + '  type="radio" name="attendence['+i+']" id="' + absent + i + '" value="Absent">' +
            '<label class="form-check-label" for="' + absent + i + '">Absent</label></div>' +
            '<div class="form-check form-check-inline"><input  class="form-check-input" ' + (res[i].status == 'Late' ? 'checked' : '') + ' type="radio" name="attendence['+i+']" id="' + late + i + '" value="Late">' +
            '<label class="form-check-label" for="' + late + i + '">Late</label></div>' +
            '<div class="form-check form-check-inline"><input  class="form-check-input" ' + (res[i].status == 'Shortleave' ? 'checked' : '') + '  type="radio" name="attendence['+i+']" id="' + shortleave + i + '" value="Shortleave">' +
            '<label class="form-check-label" for="' + shortleave + i + '">Shortleave</label></div>'
            + '</td>' +
          '<td><input class="form-control form-control-sm" type="text" placeholder="Comment here" name="description[]" value="' + res[i].description + '" /></td>' +
          '</tr>';
        }
        content += '<tr><td><input class="form-control form-control-sm text-white bg-primary" type="submit" value="Save Attendance" /></td><td></td><td></td><td></td></tr>';
        $("#body").html(content);
      })
      .catch();
    }
  });
  $(() => {
    FetchClasses();
  });
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
        $("#class").empty();
        $("#admissioninclass").empty();
        var j=1;
        $('#class').append("<option value=''>Select Class</option>");
        $('#admissioninclass').append("<option value=''>Select Class</option>");
        for (i=0; i < dataa.length; ++i) {
          $('#class').append('<option value='+dataa[i].C_id+'>'+ dataa[i].ClassName +'</option>');
          $('#admissioninclass').append('<option value='+dataa[i].C_id+'>'+ dataa[i].ClassName +'</option>');
          j++;
        }
      },
      error: function(){
        alert('Internet Issue');
      }
    });
  }
  function fetchSectionForClass(e, vall){
    $("#body").empty();
    if(vall == 0){
      $("#section").prop("disabled", true);
      document.getElementById("section").selectedIndex = 0;
    }else{
      $("#section").prop("disabled", false);
    }

    $.ajax({
        dataType: "json",
        type: 'GET',
        url: "{{ route('admin.FetchSectionForClassConfigration') }}",
        data: {classId: e.value},
        success: function(SessionData)
        {
          sessionData=JSON.parse(SessionData);
          $("#section").empty();
          var j=1;
          $('#section').append("<option value=''>Select section</option>");
          for (i=0; i < sessionData.length; ++i) {
            $('#section').append('<option value='+sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
            j++;
          }
          // $("#section").prop('disabled', false);
        },
        error: function()
        {
          alert('internet issue');
        }
      });
  }
</script>



@endsection