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
      .pagebreak{
        page-break-before: always;
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


@foreach ($classes as $classs)
<div class="row invoice pagebreak">
  <div class="col-md-2 text-center" style="line-height: 10;">
    <img class="align-middle" style="width: 60%;" src=" {{ asset('CampusLogos/' . $school->Logo_photo_path) }}" alt="">
  </div>
  <div class="col-md-10 text-center">
    <h1>{{ $school->CampusName }}</h1>
    <h3>{{ $school->DefaultAddress }}</h3>
    <p>{{ $school->Phone }}</p>
    @if (!$classes)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif
    <?php
      $sec = \App\Models\StudentInfo::where('campusid', Auth::user()->campusid)
      ->where('admissioninclass', $classs->admissioninclass)
      ->where('status','<>','Slc')
      ->where('admissioninsection', $classs->admissioninsection)->get();
    ?>
    @if (!$sec)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif

    <h3>{{ $classs->ClassName . '(' . $classs->SectionName . ')' }} - {{ date('F j, Y') }}</h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table">
      <thead>
        <tr>
          <th style="width: 20%">S.No</th>
          <th style="width: 20%">Student Id</th>
          <th style="width: 40%">Name</th>
          <th style="width: 20%">Bus Number</th>
        </tr>
      <tbody>
        @foreach ($sec as $se)
        <tr>
          <td>{{ $counter++ }}</td>
          <td>{{ $se->studentid }}</td>
          <td>{{ $se->studentname }}</td>
          <td>{{ $se->busnumber }}</td>
        </tr>
        @endforeach
      </tbody>
      </thead>
    </table>
  </div>
</div>
@endforeach


<script>

</script>