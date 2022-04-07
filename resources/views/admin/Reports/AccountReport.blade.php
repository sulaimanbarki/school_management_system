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
    @if (!$results)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif
    <h3>Accounts Report</h3>
    <h6>From Date: {{ date("d-m-Y", strtotime($request->fromdate)) }} -- To Date: {{ date("d-m-Y", strtotime($request->todate)) }}</h6>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table">
      <thead>
        <tr>
          <th>#.</th>
          <th>Account Name</th>
          <th>Description</th>
          <th>Date</th>
          <th>Type</th>
          <th>Credit</th>
          <th>Debit</th>
          <th>Total</th>
        </tr>
      <tbody>
        <?php
          $sum = 0;
          $stdddid = '';
          $iterator = 1;
          $netsum = 0;
          $total=0;

        ?>

        @foreach ($results as $result)
        <tr>
          <td>{{ $iterator }}</td>
          <td>{{ $result->accountname }}</td>
          <td>{{ $result->account_desc }}</td>
          <td>{{ $result->transactiondate }}</td>
          <td>{{ $result->type }}</td>
          <td><?php if($result->type == "Asset") {
              echo $result->amount;
              $total= $total+$result->amount;

        } else{ echo "0";} ?></td>
          <td><?php if($result->type == "Expense") {
              echo $result->amount;
              $total= $total-$result->amount;

            } else{ echo "0";} ?></td>
          <td>{{ $total }}</td>
        </tr>
        <?php $iterator++; $netsum += $result->amount; ?>
        @endforeach
        <tr>
          <th><h4>Net total</h4></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <th><h4>{{ $netsum }}</h4></th>
        </tr>
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>
