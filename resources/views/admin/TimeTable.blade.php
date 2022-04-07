@extends('admin.admin_master')



@section('Admindata')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class=" card-header" data-card-widget="collapse">
                <h3 class="card-title">Time Table<Section></Section>
                    <Section></Section>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body collapse in" style="display: block">
                <div class="container-fluid">
                    <form id="timetableForm" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-4" style="display: none">
                                <label for="timetableid" class="form-label"><b>location Id</b></label>
                                <input type="number" class="form-control form-control-sm" id="timetableid" value="0"
                                    name="timetableid" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <?php
                                    $classes = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('Isdisplay', 1)->get();
                                ?>
                                <label for="classidd" class="form-label"><b>Class</b></label>
                                <select onchange="fetchSections(this.value)"
                                    class="form-control form-control-sm" id="classidd" required name="classid"
                                    placeholder="">
                                    <option value="">Select class</option>
                                    @foreach ($classes as $class)
                                    <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="sectionn" class="form-label"><b>Section</b></label>
                                <select class="form-control form-control-sm" id="sectionn" required name="sectionid"
                                placeholder="">
                                </select>
                            </div>
                        <div class="col-md-3">
                            <label for="subjectid" class="form-label"><b>Subject</b></label>
                            <select class="form-control form-control-sm" id="subjectid" required name="subjectid"
                            placeholder="">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="timeid" class="form-label"><b>Time</b></label>
                            <?php
                                $times = \App\Models\Time::where('campusid', Auth::user()->campusid)->where('isdisplay', 1)->get();
                            ?>
                            <select class="form-control form-control-sm" id="timeid" required name="timeid">
                                <option value="">Select time</option>
                                @foreach ($times as $time)
                                <option value="{{ $time->id }}">{{ $time->starttime }} - {{ $time->endtime }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <br>
                        <div class="row align-items-center ">
                            <div class="col-md-3">
                                <label for="empidd" class="form-label"><b>Teacher</b></label>
                                <?php
                                    $teachers = \App\Models\admin::where('admins.campusid', Auth::user()->campusid)->where('roles.campusid', Auth::user()->campusid)
                                        ->where('admins.isactive', 1)->join('roles', 'roles.RoleId', '=', 'admins.roleid')->where('roles.IsActive', 1)
                                        ->where('roles.Role', 'Teacher')->get();
                                ?>
                                <select class="form-control form-control-sm" id="empidd" required name="empid"
                                    placeholder="" >
                                    <option value="">Select teacher</option>
                                    @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="locationid" class="form-label"><b>Location</b></label>
                                <?php
                                    $locations = \App\Models\Location::where('campusid', Auth::user()->campusid)->where('isdisplay', 1)->get();
                                ?>
                                <select class="form-control form-control-sm" id="locationid" required name="locationid">
                                    <option value="">Select location</option>
                                    @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->locationname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="sequence" class="form-label"><b>Sequence</b></label>
                                <input type="number" max="20" min="1" class="form-control form-control-sm" id="sequence"
                                    required name="sequence" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="isdisplay" class="form-label"><b>Is Display</b></label>
                                <select class="form-control form-control-sm" id="isdisplay" required name="isdisplay"
                                    placeholder="">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center   ">
                            <div class="col-md-12">
                                <input name="submit" id="insert" class="btn btn-sm btn-primary btn-block" type="submit"
                                    value="Save">
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="submit" id="update" class="btn btn-sm btn-success btn-block"
                                    style="display: none;" value="Update">
                                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row" style="overflow-x:auto;overflow-y:auto;">
                        <div class="col-md-12">
                            <table id="timetabletable" class="table table-striped" style="margin:20px">
                                <thead>
                                    <tr>
                                        <th>S.No </th>
                                        <th class="select-filter">Teacher</th>
                                        <th class="select-filter">Class</th>
                                        <th class="select-filter">Section</th>
                                        <th class="select-filter">Subject</th>
                                        <th class="select-filter">Location</th>
                                        <th class="select-filter">Time</th>
                                        <th>Sequence</th>
                                        <th>Is Display</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="timetablebody">
                                </tbody>
                                <tfoot>
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
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script src="{{ asset('userbackend/plugins/axios/axios.min.js') }}"></script>
{{-- CRUD operation --}}
<script>
    $("#update").click(req => {
        axios.put(`/admin/timetables/${$("#timetableid").val()}`, $("#timetableForm").serialize())
        .then(res => {
            fetchTimeTables();
            swal('Update', "Successfully updated.", 'success');
            $("#timetableForm").trigger("reset");
            $('#update').hide();
            $('#cancelbtn').hide();
            $('#insert').show();
            $('#insert').prop('type', 'submit');
        }).catch((error) => {
            if(error.response.data.success == 'Duplicate Entry.'){
                swal('Warning', error.response.data.success, 'warning');
            }else{
                for (let key in error.response.data.errors) {
                    swal('warning', error.response.data.errors[key][0], 'warning');
                }
            }
        });
    });

    $("#insert").click(() => {
        axios.post('/admin/timetables', $("#timetableForm").serialize())
        .then(res => {
            swal('Saved', "Successfully saved.", 'success');
            $("#timetableForm").trigger('reset');
            fetchTimeTables();
        }).catch((error) => {
            if(error.response.data.success == 'Duplicate Entry.'){
                swal('Warning', error.response.data.success, 'warning');
            }else{
                for (let key in error.response.data.errors) {
                    swal('warning', error.response.data.errors[key][0], 'warning');
                }
            }
        });
    })

    const EditTimeTable = (tableid, index) => {
        $('#update').show();
        $('#cancelbtn').show();
        $('#insert').hide();
        $('#insert').prop('type', '');

        $("#timetableid").val(tableid);
        $("#empidd").val(timetables[index].empid);
        new Promise( (res, rej) => {
            fetchClassesForTeacher(timetables[index].empid);
            alert();
        }).then( (res) => {
            $("#classid").val(timetables[index].C_id);
            alert();
        })
        // fetchClassesForTeacher(timetables[index].empid);
        $("#classid").val(timetables[index].C_id);
        $("#sectionid").val(timetables[index].Sec_ID);
        $("#subjectid").val(timetables[index].subjectid);
        $("#locationid").val(timetables[index].locationid);
        $("#timeid").val(timetables[index].timeid);
        $("#sequence").val(timetables[index].sequence);
        $("#isdisplay").val(timetables[index].isdisplay);
    }

    const fetchTimeTables = () => {
        axios.get('/admin/timetables/1')
        .then(res => {
            timetables = res.data;
            var j=1;
            let html='';
            $('#timetabletable').DataTable().destroy();
            for (i=0; i < timetables.length; i++) {
                html=html+'<tr>'+
                '<td>'+ j +'</td>'+
                '<td>'+timetables[i].name +'</td>'+
                '<td>'+timetables[i].ClassName +'</td>'+
                '<td>'+timetables[i].SectionName +'</td>'+
                '<td>'+timetables[i].subjectname +'</td>'+
                '<td>'+timetables[i].locationname +'</td>'+
                '<td>'+timetables[i].starttime.slice(0, -3) + ' - ' + timetables[i].endtime.slice(0, -3) +'</td>'+
                '<td>'+timetables[i].sequence +'</td>'+
                '<td>'+ (timetables[i].isdisplay ? "Yes" : "No") +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditTimeTable(' + timetables[i].tableid+','+ i +')"></i></a></td>'
                +'</tr>';
                j++;
            }
            $('#timetablebody').html(html);
            $('#timetabletable').DataTable({
                initComplete: function () {
                    this.api().columns(".select-filter").every( function () {
                        var column = this;
                        var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
        
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' );
                        } );
                    } );
                }
            });
        })
        .catch();
    }
</script>
<script>
    const fetchClassesForTeacher = (teacherid) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            dataType: "json",
            type: 'post',
            url: "{{ route('admin.fetchTeacherWiseClasses') }}",
            data: {teacherid: teacherid},
            success: function(classeandsection)
            {
                classeandsection=JSON.parse(JSON.stringify(classeandsection));
                let classes = "<option value=''>Select class</option>";
                let sections = "<option value=''>Select section</option>";
                for (i=0; i < classeandsection.length; ++i) {
                    classes += '<option value='+classeandsection[i].classid+'>'+ classeandsection[i].ClassName +'</option>';
                    // sections += '<option value='+classeandsection[i].sectionid+'>'+ classeandsection[i].SectionName +'</option>';
                }
                $("#classidd").html(classes);
                // $("#sectionn").html(sections);
            },
            error: function()
            {
                alert('internet issue');
            }
        });
    }

    const fetchSections = (classid) => {
        $.ajax({
            dataType: "json",
            type: 'GET',
            url: "{{ route('admin.FetchSectionForClassConfigration') }}",
            data: {classId: classid},
            success: function(SessionData)
            {
            sessionData=JSON.parse(SessionData);
            $("#sectionn").empty();
            var j=1;
            $('#sectionn').append("<option value=''>Select Section</option>");
            for (i=0; i < sessionData.length; ++i) {
                $('#sectionn').append('<option value=' + sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
                j++;
            }
            },
            error: function()
            {
            alert('internet issue');
            }
        });

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //     }
        // });
        // $.ajax({
        //     dataType: "json",
        //     type: 'post',
        //     url: "{{ route('admin.fetchSectionsForTeacher') }}",
        //     data: {teacherid: teacherid, classid: classid},
        //     success: function(classeandsection)
        //     {
        //         classeandsection=JSON.parse(JSON.stringify(classeandsection));
        //         let classes = "<option value=''>Select class</option>";
        //         let sections = "<option value=''>Select section</option>";
        //         for (i=0; i < classeandsection.length; ++i) {
        //             // classes += '<option value='+classeandsection[i].classid+'>'+ classeandsection[i].ClassName +'</option>';
        //             sections += '<option value='+classeandsection[i].sectionid+'>'+ classeandsection[i].SectionName +'</option>';
        //         }
        //         // $("#classidd").html(classes);
        //         $("#sectionn").html(sections);
        //     },
        //     error: function()
        //     {
        //         alert('internet issue');
        //     }
        // });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            dataType: "json",
            type: 'post',
            url: "{{ route('admin.fetchSubjecsForClasses') }}",
            data: {classid: classid},
            success: function(classeandsection)
            {
                allsubjects = JSON.parse(JSON.stringify(classeandsection));
                // console.log(allsubjects);
                let subjects = "<option value=''>Select subject</option>";
                for (i=0; i < allsubjects.length; ++i) {
                    subjects += '<option value='+allsubjects[i].subjectid+'>'+ allsubjects[i].name +'</option>';
                }
                $("#subjectid").html(subjects);
            },
            error: function()
            {
                alert('internet issue');
            }
        });
    }

    function ResetFormByCancelKey(){
        $("#timetableForm").trigger("reset");
        $('#update').hide();
        $('#cancelbtn').hide();
        $('#insert').show();
        $('#insert').prop('type', 'submit');
    }
</script>
<script>
    $(() => {
        fetchTimeTables();
    })
</script>



@endsection
