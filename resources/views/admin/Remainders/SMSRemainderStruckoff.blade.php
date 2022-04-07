<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('userbackend/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/css/prettify.css">
    <link rel="stylesheet" type="text/css"
        href="https://jhollingworth.github.io/bootstrap-wysihtml5//src/bootstrap-wysihtml5.css">
    <style>
        @media print {

            /* All your print styles go here */
            .wysihtml5-toolbar {
                display: none !important;
            }
            #exampleFormControlTextarea1{
                border: 1px solid black !important;
            }
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

<body>
    <?PHP
    $school = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->where('SchoolStatus', 'Active')->first();
    $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
    $counter = 1;
      // print_r($school); die(); 
    $checkStudent = $students;
?>
    <a href="#" rel="noopener" id="printbtn" onclick="window.print();" class="btn btn-success"><i
            class="fas fa-print"></i>
        Print</a>
    {{-- {{dd($students)}} --}}

    <div class="container-fluid">
        @foreach ($students as $student)
        <?php
            // dd($months);
            if($student->monthcount <= 2){
                continue;
            }
        ?>
        <div class="row">
            <div class="col-md-2 text-center" style="">
                <img class="align-middle" style="width: 60%;"
                    src=" {{ asset('CampusLogos/' . $school->Logo_photo_path) }}" alt="">
            </div>
            <div class="col-md-10">
                <h1>{{ $school->CampusName }}</h1>
                <h3>{{ $school->DefaultAddress }}</h3>
                <p>{{ $school->Phone }}</p>
                @if (!$checkStudent)
                <h2>
                    <?php die("No data Found!"); ?>
                </h2>
                @endif

                {{-- <h3>{{ $classs->ClassName . '(' . $classs->SectionName . ')' }}</h3> --}}
                <?php 
                // dd($student->monthcount);
                // $message = $request->message;
                // $search = "$$$";
                
                
                // $message = str_replace($search, $months, $message);
            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <textarea class="form-control textarea" id="exampleFormControlTextarea1"
                        rows="4">Dear Parents, your child has been strucked off due to not submitting fees of {{ $student->monthcount }} months.</textarea>
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-4">
                {{-- table dataTables --}}
                <table class="table">
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
                            <td>{{ $student->classname . ' ' . $student->sectionname }}
                                {{-- {{ $request->lastWarning ? " (Last Warning)" : "" }} --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>

    <script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/wysihtml5-0.3.0.js"></script>
    <script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/jquery-1.7.2.min.js"></script>
    <script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/prettify.js"></script>
    <script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/bootstrap.min.js"></script>
    <script src="https://jhollingworth.github.io/bootstrap-wysihtml5//src/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.textarea').wysihtml5();
        });
    </script>

</body>

</html>