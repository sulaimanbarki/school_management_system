@extends('admin.admin_master')
@section('Admindata')
<div class="row">
  <div class="col-md-12">
    <?php
      $classes = \App\Models\addClass::where('CampusID', Auth::user()->campusid)->where('Isdisplay', 1)->get();
      $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
      $counter = 1;
    ?>
    <br>
    <table id="example1" class="table table-striped">
      <thead>
        <tr>
          <th>S.No </th>
          <th>Id</th>
          <th>Name</th>
          <th>F Name</th>
          <th>Class</th>
          <th>Section</th>
        </tr>
      </thead>
      <tbody id="CampusData">
        @foreach ($students as $student)
        <tr>
          <td>{{ $counter }} </td>
          <td>{{ $student->studentid }}</td>
          <td>{{ $student->studentname }}</td>
          <td>{{ $student->fathername }}</td>
          <td>{{ $student->ClassName }}</td>
          <td>{{ $student->SectionName }}</td>
        </tr>
        <?php  $counter++; ?>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<script>
  $(document).ready(function(){
    // $("#example1").dataTable();
  });
</script>



@endsection