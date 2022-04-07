<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('userbackend/dist/css/adminlte.min.css')}}">
    <style>
        .decpad {
            margin-bottom: -12px;
        }

        * {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        table,
        ul,
        .col-sm-3,
        th,
        input,
        h6,
        .col-sm-2 {
            font-size: 12px !important;
        }
        input{
            padding-top: 0% !important;
            padding-bottom: 0% !important;
            padding-left: 0% !important;
            padding-right: 0% !important;
        }

        .form-control-sm {
            height: calc(1em + .375rem + 2px) !important;
            /* padding: .125rem .25rem !important; */
            /* font-size: .75rem !important; */
            line-height: 1.5;
            border-radius: .2rem;
        }

        @media print {
            @page {
                size: A4 landscape;
                /* this affects the margin in the printer settings */

                /* size: landscape */
            }

            #breakpage {

                margin: 1px;
                clear: both;
                /* page-break-after: always; */
                /* page-break-before: always; */
                width: 100%;
                ;


            }
        }
    </style>

    <title>Print Slips</title>
</head>
{{--
<?php if(! empty($campus->banklogo)){ echo $campus->banklogo; }  ?> --}}

<body onload="window.print()">
    <?php
            $campus = Auth::user()->campusid;
            $campus = \App\Models\addCampus::where('CampusID', '=',$campus)->first();
    ?>
    <div class="container-fluid">
        <div class="" id="slips">
        </div>
    </div>
</body>
<script src="{{ asset('userbackend/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('userbackend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script>
    var data = JSON.parse(localStorage.getItem('data'));
    var campus = {!! json_encode($campus) !!};

    var localdata = JSON.parse(localStorage.getItem('localdata'));
    var feeheads = JSON.parse(localStorage.getItem('feeheads'));
    var Students = JSON.parse(localStorage.getItem('Students'));

    console.log(Students);

    var months = [ "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December" ];

    // console.log(data);
    // console.log(localdata);

    var output="";
    for(var i = 0; i < Students.length; i++){
        // alert(Students[i].studentid);
        // alert(Students[i].studentname);
        output = output+`

        <div class="row" id="breakpage" style="page-break-after: always">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-3 col-sm-3">
                        <img height="80" width="80" src="https://icon2.cleanpng.com/20180409/hte/kisspng-monogram-letter-arabesco-5acb8b28bb7a22.4235139215232888727679.jpg" alt="">
                    </div>
                    <div class="col-9 col-sm-9">
                        <?php


                            ?>
                        <h5> ` + campus.CampusName + `</h5>
                        <h6> ` + campus.DefaultAddress + ` </h6>
                        <p>Tel:  ` + campus.Phone + ` </p>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-3 col-sm-3">
                        <img src="" alt="">
                    </div>
                    <div class="col-9 col-sm-9">
                        <h6>(Bank Copy)</h6>
                        <h6> ` + campus.BankName + ` </h6>
                        <h6> ` + campus.AccountNumber + ` </h6>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Std Id</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].studentid + `" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-2 col-sm-2">Class</div>
                    <div class="col-4 col-sm-4">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].classname + ' ' + Students[i].sectionname + `"  class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Std Name</div>
                    <div class="col-9 col-sm-9">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].studentname + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Father Name</div>
                    <div class="col-9 col-sm-9">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].fathername + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Issue Date</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + localdata.issuedate + `" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-3 col-sm-3">Due Date</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + localdata.lastdate + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 col-sm-12">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width="55%">Particular</th>
                                    <th width="35%">Month(s)</th>
                                    <th width="10%">Amount</th>
                                </tr>
                            </thead>
                            <tbody>`;
                            var sum = 0;
                            for(var j = 0; j < feeheads.length; j++){
                            if( Students[i].studentid==feeheads[j].studentid)
                            {
                                output += `<tr><td> `;
                                output += feeheads[j].subhead;
                                output += `</td> <td>`;
                                output += months[feeheads[j].month - 1] + " (" + feeheads[j].year + ")";
                                output += `</td><td>`;
                                output += feeheads[j].feeamount;
                                sum += feeheads[j].feeamount;
                                output += `</td></tr>`;
                            }
                            }
                            output += `
                            <tr>
                                    <td colspan="2"><b>Grand Sum</b></td>
                                    <td><b>`;
                                    output += sum;
                                    output +=  `</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3 col-sm-3">
                        <hr>
                        <h6>Date Recieved</h6>
                    </div>
                    <div class="col-3 col-sm-3"></div>
                    <div class="col-6 col-sm-6">
                        <hr>
                        <h6>Bank Signature/ Stamp</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-sm-2">
                        Note:
                    </div>
                    <div class="col-10 col-sm-10">
                        <ul>
                            <li><i style='font-size:13px;' >All dues are required to be paid on or before due date.</i></li>
                            <li><i style='font-size:13px;'>Cutting is not allowed in the fee slip.</i></li>
                            <li><i style='font-size:13px;'>Students / Parents are requested to keep the paid student fee slip copy / copies as
                                    an evidence of fee payment</i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-3 col-sm-3">
                        <img height="80" width="80" src="https://icon2.cleanpng.com/20180409/hte/kisspng-monogram-letter-arabesco-5acb8b28bb7a22.4235139215232888727679.jpg" alt="">
                    </div>
                    <div class="col-9 col-sm-9">
                        <?php


                            ?>
                        <h5> ` + campus.CampusName + `</h5>
                        <h6> ` + campus.DefaultAddress + ` </h6>
                        <p>Tel:  ` + campus.Phone + ` </p>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-3 col-sm-3">
                        <img src="" alt="">
                    </div>
                    <div class="col-9 col-sm-9">
                        <h6>(School Copy)</h6>
                        <h6> ` + campus.BankName + ` </h6>
                        <h6> ` + campus.AccountNumber + ` </h6>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Std Id</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].studentid + `" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-2 col-sm-2">Class</div>
                    <div class="col-4 col-sm-4">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].classname + ' ' + Students[i].sectionname + `"  class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Std Name</div>
                    <div class="col-9 col-sm-9">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].studentname + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Father Name</div>
                    <div class="col-9 col-sm-9">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].fathername + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Issue Date</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + localdata.issuedate + `" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-3 col-sm-3">Due Date</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + localdata.lastdate + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 col-sm-12">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width="55%">Particular</th>
                                    <th width="35%">Month(s)</th>
                                    <th width="10%">Amount</th>
                                </tr>
                            </thead>
                            <tbody>`;
                            var sum = 0;
                            for(var j = 0; j < feeheads.length; j++){
                            if( Students[i].studentid==feeheads[j].studentid)
                            {
                                output += `<tr><td> `;
                                output += feeheads[j].subhead;
                                output += `</td> <td>`;
                                output += months[feeheads[j].month - 1] + " (" + feeheads[j].year + ")";
                                output += `</td><td>`;
                                output += feeheads[j].feeamount;
                                sum += feeheads[j].feeamount;
                                output += `</td></tr>`;
                            }
                            }
                            output += `
                            <tr>
                                    <td colspan="2"><b>Grand Sum</b></td>
                                    <td><b>`;
                                    output += sum;
                                    output +=  `</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3 col-sm-3">
                        <hr>
                        <h6>Date Recieved</h6>
                    </div>
                    <div class="col-3 col-sm-3"></div>
                    <div class="col-6 col-sm-6">
                        <hr>
                        <h6>Bank Signature/ Stamp</h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2 col-sm-2">
                        Note:
                    </div>
                    <div class="col-10 col-sm-10">
                        <ul>
                            <li><i style='font-size:13px;' >All dues are required to be paid on or before due date.</i></li>
                            <li><i style='font-size:13px;'>Cutting is not allowed in the fee slip.</i></li>
                            <li><i style='font-size:13px;'>Students / Parents are requested to keep the paid student fee slip copy / copies as
                                    an evidence of fee payment</i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-3 col-sm-3">
                        <img height="80" width="80" src="https://icon2.cleanpng.com/20180409/hte/kisspng-monogram-letter-arabesco-5acb8b28bb7a22.4235139215232888727679.jpg" alt="">
                    </div>
                    <div class="col-9 col-sm-9">
                        <?php


                            ?>
                        <h5> ` + campus.CampusName + `</h5>
                        <h6> ` + campus.DefaultAddress + ` </h6>
                        <p>Tel:  ` + campus.Phone + ` </p>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-3 col-sm-3">
                        <img src="" alt="">
                    </div>
                    <div class="col-9 col-sm-9">
                        <h6>(Student Copy)</h6>
                        <h6> ` + campus.BankName + ` </h6>
                        <h6> ` + campus.AccountNumber + ` </h6>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Std Id</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].studentid + `" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-2 col-sm-2">Class</div>
                    <div class="col-4 col-sm-4">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].classname + ' ' + Students[i].sectionname + `"  class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Std Name</div>
                    <div class="col-9 col-sm-9">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].studentname + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Father Name</div>
                    <div class="col-9 col-sm-9">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + Students[i].fathername + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row decpad">
                    <div class="col-3 col-sm-3">Issue Date</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + localdata.issuedate + `" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-3 col-sm-3">Due Date</div>
                    <div class="col-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" readonly value=" ` + localdata.lastdate + `" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 col-sm-12">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width="55%">Particular</th>
                                    <th width="35%">Month(s)</th>
                                    <th width="10%">Amount</th>
                                </tr>
                            </thead>
                            <tbody>`;
                            var sum = 0;
                            for(var j = 0; j < feeheads.length; j++){
                            if( Students[i].studentid==feeheads[j].studentid)
                            {
                                output += `<tr><td> `;
                                output += feeheads[j].subhead;
                                output += `</td> <td>`;
                                output += months[feeheads[j].month - 1] + " (" + feeheads[j].year + ")";
                                output += `</td><td>`;
                                output += feeheads[j].feeamount;
                                sum += feeheads[j].feeamount;
                                output += `</td></tr>`;
                            }
                            }
                            output += `
                            <tr>
                                    <td colspan="2"><b>Grand Sum</b></td>
                                    <td><b>`;
                                    output += sum;
                                    output +=  `</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 col-sm-3">
                        <hr>
                        <h6>Date Recieved</h6>
                    </div>
                    <div class="col-3 col-sm-3"></div>
                    <div class="col-6 col-sm-6">
                        <hr>
                        <h6>Bank Signature/ Stamp</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-sm-2">
                        Note:
                    </div>
                    <div class="col-10 col-sm-10">
                        <ul>
                            <li><i style='font-size:13px;' >All dues are required to be paid on or before due date.</i></li>
                            <li><i style='font-size:13px;'>Cutting is not allowed in the fee slip.</i></li>
                            <li><i style='font-size:13px;'>Students / Parents are requested to keep the paid student fee slip copy / copies as
                                    an evidence of fee payment</i></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        `;
    }
    $("#slips").append(output);
    document.getElementById("breaker").style.pageBreakAfter = "always";

</script>

</html>
