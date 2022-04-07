<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('userbackend/dist/css/adminlte.min.css')}}">
  <style>
    td, tr, th{
      padding-top: 0% !important;
      padding-bottom: 0% !important;
      font-size: 14px !important;
    }
    @media print {

      /* All your print styles go here */
      #header,
      #printbtn,
      #nav {
        display: none !important;
      }

      td,
      tr,
      th,
      table {
        border: 2px solid black;
      }
    }
  </style>
</head>
<?PHP
      $school = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->where('SchoolStatus', 'Active')->first();
      $section = \App\Models\addsection::where('campusid', Auth::user()->campusid)->where('Sec_ID', $request->section)->value('SectionName');
      $class = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('C_id', $request->class)->value('ClassName');
      $counter = 1;
      // print_r($school); die(); 
?>

<a href="#" rel="noopener" id="printbtn" onclick="window.print();" class="btn btn-success pull-right"><i
    class="fas fa-print"></i> Print</a>
<div class="row invoice">
  <div class="col-md-2 text-center" style="line-height: 10;">
    <img class="align-middle" style="width: 60%;" src=" {{ asset('CampusLogos/' . $school->Logo_photo_path) }}" alt="">
  </div>
  <div class="col-md-10 text-center">
    <h1>{{ $school->CampusName }}</h1>
    <h3>{{ $school->DefaultAddress }}</h3>
    <p>{{ $school->Phone }}</p>
    @if (!$students)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif
    <h3>Attendance Report</h3>
    {{-- <h3>{{ $students[0]->ClassName . '(' . $students[0]->SectionName . ')' }} - {{ date('D d M, Y', strtotime($request->attendancedate)) }}</h3> --}}
    <h3>{{ $class . '(' . $section . ')' }} - From {{ date('D d M, Y', strtotime($request->fromdate)) }} To {{ date('D d M, Y', strtotime($request->todate)) }}</h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table">
      <thead>
        <tr>
          <th>Student Id</th>
          <th>Student Name</th>
          <th>Total Days</th>
          <th>Present</th>
          <th>Absent</th>
        </tr>
      <tbody>
        @foreach ($students as $student)
        <tr>
          <td>{{ $student->studentid }}</td>
          <td>{{ $student->studentname }}</td>
          <td>{{ $student->Total }}</td>
          <td>{{ $student->Present }}</td>
          <td>{{ $student->Absent }}</td>
        </tr>
        @endforeach
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>