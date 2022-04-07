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
      $school = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->where('SchoolStatus', 'Active')->first();
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
    @if (!$classes)
    <h2>
      <?php die("No data Found!"); ?>
    </h2>
    @endif
    <h3>{{ $classes[0]->classname . ' - ' . $classes[0]->sectionname }} Outstanding Fee Statement</h3>
    <h6>From Date: {{ date("d-m-Y", strtotime($request->fromdate)) }} -- To Date: {{ date("d-m-Y", strtotime($request->todate)) }}</h6>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table">
      <thead>
        <tr>
          <th>Class</th>
          <th>Student Name</th>
          <th>Month</th>
          <th>Amount</th>
        </tr>
      <tbody>
        <?php
          $sum = 0;
          $stdddid = '';
          $iterator = 1;
          $netsum = 0;
        ?>

        @foreach ($classes as $class)
        <tr>
          <?php
            $monthNum  = $class->month;
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F');
            $clas = $class->classname . ' ' . $class->sectionname;
            $std = $class->studentid . ' ' . $class->studentname;
          ?>
          @if ($clas == $classSection)
          <td></td>
          @else
          <?php
            $classSection = $clas;
            ?>
          <td>{{ $class->classname . ' ' . $class->sectionname }}</td>
          @endif

          @if ($std == $studentIdd)
          <td></td>
          @else
          <?php
            $studentIdd = $std;
            ?>
          <td>{{ $class->studentid . ' - ' . $class->studentname }}</td>
          @endif
          <td>{{ $monthName . ' ' . $class->year }}</td>
          <td>{{ $class->sum }}
            <?php
              $sum += $class->sum;
              $netsum += $class->sum;
            ?>
          </td>
        </tr>

        @if (!empty($classes[$iterator]))
        @if ($classes[$iterator]->studentid != $class->studentid )
        <tr>
          <th></th>
          <th></th>
          <th colspan=""><h6>Total</h6></th>
          <th>{{ $sum }}</th>
          <?php
                    
                    $sum = 0;
                  ?>
        </tr>
        @endif
        @else
        <tr>
          <th></th>
          <th></th>
          <th colspan=""><h6>Total</h6></th>
          <th>{{ $sum }}</th>
          <?php
                  
                  $sum = 0;
                ?>
        </tr>
        @endif

        <?php 
          $iterator++;
        ?>
        @endforeach
        <tr>
          <th></th>
          <th></th>
          <th><h4>Net total</h4></th>
          <th>{{ $netsum }}</th>
        </tr>
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>