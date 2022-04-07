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
      $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
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
    <h2>Award List</h2>
    @if (!$StudentData)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif

    {{-- {{dd($StudentData)}} --}}
    <?php
      // $sec = \App\Models\addsection::where('campusid', Auth::user()->campusid)->where('Sec_ID', $StudentData[0]->admissioninsection)->first();
      // $class = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('C_id', $StudentData[0]->admissioninclass)->first();
      // $session = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('id', $StudentData[0]->sessionid)->first();
      // $termm = \App\Models\TermName::where('campusid', Auth::user()->campusid)->where('id', $StudentData[0]->termid)->first();
      // $subjectt = \App\Models\Subject::where('campusid', Auth::user()->campusid)->where('id', $StudentData[0]->subjectid)->first();
    ?>
    {{-- @if (!$sec)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif --}}

    {{-- <h3>{{ $StudentDataArray->ClassName . '(' . $classs->SectionName . ')' }}</h3> --}}
  </div>
</div>
<div class="row m-2">
  <div class="col-md-3">
    <p><b>Exam:
        {{-- <u>{{ $termm->termname }} - {{$session->Session}} </u></b> --}}
    </p>
  </div>
  <div class="col-md-3">
    {{-- <p><b>Class: &nbsp; <u>{{ $class->ClassName }}</u></b></p> --}}
  </div>
  <div class="col-md-3">
    {{-- <p><b>Section: &nbsp; <u>{{ $sec->SectionName }}</u></b></p> --}}
  </div>
  <div class="col-md-3">
    <p><b>Date:
        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b>
    </p>
  </div>
</div>
<div class="row m-2">
  <div class="col-md-3">
    <p><b>Subject:
        {{-- <u>{{ $subjectt->name }}</u></b> --}}
    </p>
  </div>
  <div class="col-md-3">
    <p><b>Total Marks:
        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b>
    </p>
  </div>
  <div class="col-md-3">
    <p><b>Teacher's Sign:
        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b>
    </p>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S#</th>
          <th>Std Id</th>
          <th>Student Name</th>
          <th>Writen/A/Theory</th>
          <th>Oral/B/Practical</th>
          <th>Total</th>
          {{-- <th>Position</th> --}}
        </tr>
      </thead>
      <tbody>
        {{-- @foreach ($StudentData as $std)
        <tr>
          <td>{{ $counter++ }}</td>
          <td>{{ $std->studentid }}</td>
          <td>{{ $std->studentname }}</td>
          <td>{{ $std->obtain_marks_theory }}</td>
          <td>{{ $std->obtain_marks_practical }}</td>
          <td>{{ $std->obtain_marks_practical + $std->obtain_marks_theory }}</td>
          {{-- <td></td> --}}
        </tr>
        {{-- @endforeach --}}
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>
