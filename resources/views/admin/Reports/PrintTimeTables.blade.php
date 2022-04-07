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
      $section = \App\Models\addsection::where('campusid', Auth::user()->campusid)->where('Sec_ID', $request->section)->value('SectionName');
      $class = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('C_id', $request->class)->value('ClassName');
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
    <h3>Time table {{ $class . '(' . $section . ')' }}</h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- table dataTables --}}
    <table class="table">
      <thead>

        <tr>
          <th>Classes</th>
          <?php
              $campusid=Auth::user()->campusid;
            $c=App\Models\time::where('campusid',$campusid)->count();
            $aa=1;
                while ($aa <=$c) {
            ?>
          <th>Period {{ $aa }}</th>
          <?php $aa++;} ?>
        </tr>
        <tr>
          {{-- <th>Timing</th> --}}
          <?php


                    //  $times =DB::select("SELECT * FROM times where campusid = ?",[$campusid]);
                            // foreach ($times  as $value) {?>
          {{-- <th>{{ $value->starttime}}-{{ $value->endtime}}</th> --}}
          <?php // } ?>
          {{--
        </tr> --}}

        <?php
            $timetable =DB::select("
            SELECT distinct (t.classid),t.sectionid,c.classname as classname, s.sectionname from classwisesection cw inner join classes c
            on cw.classid=c.c_id inner join sections s on cw.sectionid=sec_id inner join time_tables t on t.classid=c.c_id
            and c.campusid=t.campusid and s.sec_id=t.sectionid and t.campusid=s.campusid inner join subjects sb on
            sb.campusid=t.campusid and sb.id=t.subjectid
            where cw.campusid=c.campusid and cw.campusid=s.campusid and  t.campusid = ? AND t.classid = ? AND t.sectionid = ? order by t.classid,t.sectionid
            ",[$campusid, $request->class, $request->section]);
            foreach ($timetable  as $value1) {
            ?>
          <tr>
            <td>{{ $value1->classname }}-{{ $value1->sectionname }}</td>
          <?php
            $timetabled =DB::select("select * from classwisesection cw inner join classes c
              on cw.classid=c.c_id inner join sections s on cw.sectionid=sec_id inner join time_tables t on t.classid=c.c_id
              and c.campusid=t.campusid and s.sec_id=t.sectionid and t.campusid=s.campusid inner join subjects sb on
              sb.campusid=t.campusid and sb.id=t.subjectid inner join times tm on tm.campusid=t.campusid  and t.timeid=tm.id
              where cw.campusid=c.campusid and cw.campusid=s.campusid 
              and  t.campusid = ? and t.classid=? and t.sectionid=?
              order by tm.sequence
            ",[$campusid, $value1->classid, $value1->sectionid]);
            foreach ($timetabled  as $value2) {
          ?>
            <th>
              {{ substr_replace($value2->starttime ,"",-3) }} - {{ substr_replace($value2->endtime ,"",-3) }}
              <br>
              {{ $value2->name }}

            </th>
          <?php  }  ?>

        </tr>
        <?php  }  ?>





      <tbody>
      </tbody>
      </thead>
    </table>
  </div>
</div>


<script>

</script>