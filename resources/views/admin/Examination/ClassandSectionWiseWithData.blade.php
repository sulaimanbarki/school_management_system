<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('userbackend/dist/css/adminlte.min.css')}}">
  <style>
    td,
    tr,
    th {
      padding-top: 0% !important;
      padding-bottom: 0% !important;
      font-size: 14px !important;
    }

    @media print {
      .invoice{
        page-break-after: always;
      }
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
  {{-- <div class="col-md-2 text-center" style="line-height: 10;">
    <img class="align-middle" style="width: 60%;" src=" {{ asset('CampusLogos/' . $school->Logo_photo_path) }}" alt="">
  </div> --}}
  <div class="col-md-10 text-center">
    {{-- <h1>{{ $school->CampusName }}</h1>
    <h3>{{ $school->DefaultAddress }}</h3>
    <p>{{ $school->Phone }}</p>
    <h2>Award List</h2> --}}
    @if (!$StudentData)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif
    <?php
      $classid = $r->class;
      $sectionid = $r->section;
      $subjectid = $r->subject;
      $campusid = Auth::user()->campusid;
      $termID = $r->term;
      $sessionID = $r->asession;

      $sec = \App\Models\addsection::where('campusid', Auth::user()->campusid)->where('Sec_ID', $StudentData[0]->admissioninsection)->first();
      $session = \App\Models\academicsessions::where('CampusID', Auth::user()->campusid)->where('id', $StudentData[0]->sessionid)->first();
      $termm = \App\Models\TermName::where('campusid', Auth::user()->campusid)->where('id', $StudentData[0]->termid)->first();
      
      $i = 0;
        ?>
    {{-- @if (!$sec)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif --}}

    {{-- <h3>{{ $StudentDataArray->ClassName . '(' . $classs->SectionName . ')' }}</h3> --}}
  </div>
</div>

@foreach ($StudentData as $singleStudent)

<?php 
    $subjectIdd = $singleStudent->subjectid;
    $studentt = \DB::select("
        SELECT  s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid
        from studentinfo s,classwisesubjects cl,studentmarks sm WHERE s.admissioninclass=cl.classid
        and
        s.admissioninclass='$classid' and s.admissioninsection='$sectionid'  and
        s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid
        and cl.subjectid='$subjectIdd'
        and s.campusid='$campusid' and status in('Active') and termid='$termID' 
        and sessionid='$sessionID'
        and sm.studentid=s.studentid and sm.subjectid=cl.subjectid order by cl.subjectid
        ");
        if(empty($studentt[$i])){
            return;
          }
        
        $class = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('C_id', $studentt[$i]->admissioninclass)->first();
        $subjectt = \App\Models\Subject::where('campusid', Auth::user()->campusid)->where('id', $studentt[$i]->subjectid)->first();
        $i++;

  ?>
<div class="invoice">
  <div class="row">
    {{-- <div class="col-md-5"></div> --}}
    <div class="col-md-2 text-center" style="line-height: 10;">
      <img class="align-middle" style="width: 60%;" src=" {{ asset('CampusLogos/' . $school->Logo_photo_path) }}" alt="">
    </div>
    <div class="col-md-9 text-center">
      <h1>{{ $school->CampusName }}</h1>
      <h3>{{ $school->DefaultAddress }}</h3>
      <p>{{ $school->Phone }}</p>
      <h2>Award List</h2>
    </div>
  </div>
<div class="row m-2">
  <div class="col-md-3">
    <p><b>Exam:
        <u>{{ $termm->termname }} - {{$session->Session}} </u></b>
    </p>
  </div>
  <div class="col-md-3">
    <p><b>Class: &nbsp; <u>{{ $class->ClassName }}</u></b></p>
  </div>
  <div class="col-md-3">
    <p><b>Section: &nbsp; <u>{{ $sec->SectionName }}</u></b></p>
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
        <u>{{ $subjectt->name }}</u></b>
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
        @foreach ($studentt as $std)
        <tr>
          <td>{{ $counter++ }}</td>
          <td>{{ $std->studentid }}</td>
          <td>{{ $std->studentname }}</td>
          <td>{{ $std->obtain_marks_theory }}</td>
          <td>{{ $std->obtain_marks_practical }}</td>
          <td>{{ $std->obtain_marks_practical + $std->obtain_marks_theory }}</td>
          {{-- <td></td> --}}
        </tr>
        @endforeach
      </tbody>
      </thead>
    </table>
  </div>
</div>
</div>
@endforeach

<script>

</script>