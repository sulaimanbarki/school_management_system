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
      $t=0;
      $school = \App\Models\addCampus::where('campusid', Auth::user()->campusid)
      ->where('SchoolStatus', 'Active')->first();
      $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
      $counter = 1;
      $classSection = '';
      $studentIdd = '';
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
    {{-- @if (!$results)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif --}}
    <h3>Net Profit</h3>
    <h6>From Date: {{ date("d-m-Y", strtotime($request->fromdate)) }} -- To Date: {{ date("d-m-Y", strtotime($request->todate)) }}</h6>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table">
      <tbody>
        <tr>
          <th>Profit</th>
          <td>{{ $profit }}</td>
        </tr>
        <tr>
          <th>Expenses</th>
          <td>{{ $expense }}</td>
        </tr>
        <tr>
          <th><h4>Net Profit</h4></th>
          <td><h4>{{ $profit - $expense }}</h4></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


<script>

</script>
