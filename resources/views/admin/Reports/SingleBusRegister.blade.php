<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('userbackend/dist/css/adminlte.min.css')}}">
  <style>
    @media print {
      @page {
          size: A4 landscape;
          /* this affects the margin in the printer settings */

          /* size: landscape */
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
        font-size: 12px !important;
      }
    }

    td,
    tr,
    th,
    table {
      font-size: .70rem !important;
      margin: 0px;
    }

    th,
    td {
      padding: 2px !important;
      text-align: center !important;
    }

    hr {
      padding: 0 !important;
      margin: 0 !important;
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
    <?php 
      $old = $request->attendancemonthh;
      $index = (int)date("m",strtotime($old));
      $year = (int)date("Y",strtotime($old));
      $months = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July ',
        'August',
        'September',
        'October',
        'November',
        'December',
      );
    ?>
    {{-- {{$request}} --}}
    <h2>Bus Number : {{ $request->busnumber }} - {{ $months[$index-1] . " " . $year }}</h2>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th colspan="4">
            Class & Sections
          </th>
          <th colspan="30"></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th>S#</th>
          <th>STDID</th>
          <th>Student Name</th>
          <th>Bus</th>
          <?php 
            $date = $request->attendancemonthh . '-01';
            $end = $request->attendancemonthh . '-' . date('t', strtotime($date)); //get end date of month
          ?>
          <?php while(strtotime($date) <= strtotime($end)) {
            $day_num = date('d', strtotime($date));
            $day_name = substr(date('l', strtotime($date)), 0, 2);
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            echo "<th rowspan='2'>$day_num <hr/> $day_name</th>";
        }
        ?>
          <th colspan="3">Attendence
          </th>
          <th>TWD</th>
          <th>AWL</th>
        </tr>
        <tr>
          <th colspan="4">
            &nbsp;
          </th>
          <th>B.F</th>
          <th>D.M</th>
          <th>Tot</th>
          <th></th>
          <th></th>
        </tr>
      <tbody>
        @foreach ($emps as $emp)
        <tr>
          <td>{{ $counter++ }}</td>
          <td>Emp-{{ $emp->id }}</td>
          <td>{{ $emp->name }}</td>
          <td>{{ $request->busnumber }}</td>
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
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        @endforeach
        @foreach ($students as $student)
        <tr>
          <td>{{ $counter++ }}</td>
          <td>{{ $student->studentid }}</td>
          <td>{{ $student->studentname }}</td>
          <td>{{ $student->busnumber }}</td>
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