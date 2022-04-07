<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('userbackend/dist/css/adminlte.min.css')}}">
  <style>
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

    .table th {
      font-size: 0.8rem !important;
      padding: 0 !important;
    }

    .table td {
      font-size: 0.8rem !important;
      padding: 0 !important;
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
    <h2>Personal Development and Attendance</h2>
    @if (!$StudentData)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif
    <?php
      $sec = \App\Models\addsection::where('campusid', Auth::user()->campusid)->where('Sec_ID', $StudentData[0]->admissioninsection)->first();
      $class = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('C_id', $StudentData[0]->admissioninclass)->first();
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
    <p><b>Class: &nbsp; <u>{{ $class->ClassName . " " . '(' . $sec->SectionName . ')' }}</u></b></p>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="smallfont">S#</th>
          <th class="smallfont">Std Id</th>
          <th class="smallfont">Student Name</th>
          <th class="smallfont">Respect for Authority</th>
          <th class="smallfont">Dependability</th>
          <th class="smallfont">Group Cooperation</th>
          <th class="smallfont">Self Control</th>
          <th class="smallfont">Punctuality</th>
          <th class="smallfont">Uniform</th>
          <th class="smallfont">Personal Hygiene</th>
          <th class="smallfont">Works Independently</th>
          <th class="smallfont">Works Neatly</th>
          <th class="smallfont">Follow Direction</th>
          <th class="smallfont">Complete Assignment</th>
          <th class="smallfont">Uses Initiative</th>
          <th class="smallfont">Response in Class</th>
          <th class="smallfont">Attendance</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($StudentData as $std)
        <tr>
          <td>{{ $counter++ }}</td>
          <td>{{ $std->studentid }}</td>
          <td>{{ $std->studentname }}</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        @endforeach
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>