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
    <h4>Classwise strength - {{ date('F j, Y') }}</h4>
    @if (!$classes)
    <h2>
      <?php die("No data Found!");
      ?>
    </h2>
    @endif
    {{-- <h3>{{ $students[0]->ClassName . '(' . $students[0]->SectionName . ')' }}</h3> --}}
  </div>
</div>
<?php $netsum = 0; ?>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Class</th>
          <th>Section</th>
          <th>Strength</th>
        </tr>
      <tbody>
        @foreach ($classes as $class)
        <tr>
          <?php
            $id = $class->ClassID;
            $sectiiiions = Illuminate\Support\Facades\DB::select("SELECT COUNT(s.studentid) AS
             total, sec.SectionName FROM `studentinfo` s, sections sec 
             WHERE s.status in ('Active') and admissioninclass = '$id' AND sec.Sec_ID = s.admissioninsection 
             GROUP BY admissioninsection order by admissioninclass asc");
            $rs = count($sectiiiions);
            $rs++;
            $j = 1;
            $sum = 0;
            ?>
          <td rowspan="{{ $rs }}">{{ $class->ClassName }}</td>
          @foreach ($sectiiiions as $sectiiiion)
          <td>{{ $sectiiiion->SectionName }}</td>
          <td>{{ $sectiiiion->total }}</td>
          <?php $sum += $sectiiiion->total; 
          $netsum += $sectiiiion->total; ?>
        </tr>
        @endforeach
        <tr>
          <th colspan=""> Total</th>
          <th>{{ $sum }} </th>
        </tr>
        @endforeach
        <tr>
          <th></th>
          <th><h6><b>Net Total</b></h6></th>
          <th><h6><b>{{ $netsum }}</b></h6></th>
        </tr>
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>