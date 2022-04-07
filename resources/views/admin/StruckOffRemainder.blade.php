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
            .col-md-12{
                border: 1px solid black !important;
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


@foreach ($students as $student)
<div class="row invoice">
    <div class="col-md-2 text-center" style="line-height: 10;">
        <img class="align-middle" style="width: 60%;" src=" {{ asset('CampusLogos/' . $school->Logo_photo_path) }}"
            alt="">
    </div>
    <div class="col-md-10">
        <h1>{{ $school->CampusName }}</h1>
        <h3>{{ $school->DefaultAddress }}</h3>
        <p>{{ $school->Phone }}</p>
        @if (!$student)
        <h2>
            <?php die("No data Found!"); ?>
        </h2>
        @endif

        {{-- <h3>{{ $classs->ClassName . '(' . $classs->SectionName . ')' }}</h3> --}}
    </div>
</div>
<div class="row">
    <div class="col-md-7"></div>
    <div class="col-md-5">
        {{-- table dataTables --}}
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td>Adm.#: </td>
                    <td>{{ $student->studentid }}</td>
                </tr>
                <tr>
                    <td>Name: </td>
                    <td>{{ $student->studentname }}</td>
                </tr>
                <tr>
                    <td>Class: </td>
                    <td>{{ $student->ClassName . ' ' . $student->SectionName }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>Dear Parents</p>
        <p>You have not paid your child/son school fee <u>for 1 </u></p>
    </div>
</div>
@endforeach


<script>

</script>