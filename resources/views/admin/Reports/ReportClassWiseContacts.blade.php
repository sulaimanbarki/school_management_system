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
    @if (!$students)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif
    <h3>{{ $students[0]->ClassName . ' (' . $students[0]->SectionName . ')' }}</h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table">
      <thead>
        <tr>
          <th style="width: 5%">S.No</th>
          <th style="width: 10%">Student Id</th>
          <th style="width: 20%">Student Name</th>
          <th style="width: 20%">Father Name</th>
          <th style="width: 30%">Contact No.</th>
          <th style="width: 15%">DOB</th>
        </tr>
      <tbody>
        @foreach ($students as $student)
        <tr>
          <td>{{ $counter++ }}</td>
          <td>{{ $student->studentid }}</td>
          <td>{{ $student->studentname }}</td>
          <td>{{ $student->fathername }}</td>
          <td>{{ $student->fathercontact . ", " . $student->contact1 . ", " . $student->contactwhatsapp }}</td>
          <td>{{ date('d-m-Y', strtotime($student->dob)) }}</td>
        </tr>
        @endforeach
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>