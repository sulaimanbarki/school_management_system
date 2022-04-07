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
    <script src="{{ asset('userbackend/plugins/jquery/jquery.min.js')}}"></script>
    <script>
        var data = JSON.parse(localStorage.getItem('itemslists'));
    
        var output="";  
        let netTotal = 0;
        for(var i = 0; i < data.length; i++){
            netTotal += data[i].purchase_price * data[i].qty;
            output += `<tr>
                <td>${i+1}</td>
                <td>${data[i].itemcode}</td>
                <td>${data[i].item_name}</td>
                <td>${data[i].qty}</td>
                <td>${data[i].purchase_price * data[i].qty}</td>
            </tr>`;
        }
        console.log(output);
        
    </script>
</head>
<?PHP
    $school = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->where('SchoolStatus', 'Active')->first();
    $sections = \App\Models\addsection::where('campusid', Auth::user()->campusid)->get();
    $counter = 1;
?>

<a href="#" rel="noopener" id="printbtn" onclick="window.print();" class="btn btn-success pull-right"><i
        class="fas fa-print"></i> Print</a>
<div class="row invoice">
    <div class="col-md-2 text-center" style="line-height: 10;">
        <img class="align-middle" style="width: 60%;" src=" {{ asset('CampusLogos/' . $school->Logo_photo_path) }}"
            alt="">
    </div>
    <div class="col-md-10 text-center">
        <h1>{{ $school->CampusName }}</h1>
        <h3>{{ $school->DefaultAddress }}</h3>
        <p>{{ $school->Phone }}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {{-- table dataTables --}}
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%">S.No</th>
                    <th style="width: 10%">Item code</th>
                    <th style="width: 20%">Item Name</th>
                    <th style="width: 20%">Qty</th>
                    <th style="width: 15%">Total</th>
                </tr>
            </thead>
            <tbody id="slips">
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Net Total</th>
                    <th id="netTotal"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<script>
    $("#slips").append(output);
    $("#netTotal").text(netTotal);
</script>