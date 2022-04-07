@extends('admin.admin_master')



@section('Admindata')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class=" card-header" data-card-widget="collapse">
                <h3 class="card-title">Locations<Section></Section>
                    <Section></Section>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>



            <div class="card-body collapse in">
                <div class="container-fluid">
                    <form id="locationform" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-4" style="display: none">
                                <label for="locationid" class="form-label"><b>location Id</b></label>
                                <input type="text" class="form-control form-control-sm" id="locationid" value="0"
                                    name="locationid" placeholder="">
                            </div>
                            <div class="col-md-4">
                                <label for="locationname" class="form-label"><b>Location Name</b></label>
                                <input type="text" class="form-control form-control-sm" id="locationname" required
                                    name="locationname" placeholder="">
                            </div>
                            <div class="col-md-4">
                                <label for="sequence" class="form-label"><b>Sequence</b></label>
                                <input type="number" max="20" min="1" class="form-control form-control-sm" id="sequence"
                                    required name="sequence" placeholder="">
                            </div>
                            <div class="col-md-4">
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
                            <table id="locationsTable" class="table table-striped" style="margin:20px">
                                <thead>
                                    <tr>
                                        <th>S.No </th>
                                        <th>Location Name</th>
                                        <th>Sequence</th>
                                        <th>Is Display</th>
                                        <th></th>

                                        <!-- <th>SubCat_name</th> -->
                                    </tr>
                                </thead>
                                <tbody id="locationsbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class=" card-header" data-card-widget="collapse">
                <h3 class="card-title">Times<Section></Section>
                    <Section></Section>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>



            <div class="card-body collapse in">
                <div class="container-fluid">
                    <form id="timeform" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-4" style="display: none">
                                <label for="timeid" class="form-label"><b>location Id</b></label>
                                <input type="text" class="form-control form-control-sm" id="timeid" value="0"
                                    name="timeid" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="starttime" class="form-label"><b>Starting Time</b></label>
                                <input type="time" class="form-control form-control-sm" id="starttime" required
                                    name="starttime" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="endtime" class="form-label"><b>Ending Time</b></label>
                                <input type="time" class="form-control form-control-sm" id="endtime" required
                                    name="endtime" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="timesequence" class="form-label"><b>Sequence</b></label>
                                <input type="number" max="20" min="1" class="form-control form-control-sm"
                                    id="timesequence" required name="sequence" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="timeisdisplay" class="form-label"><b>Is Display</b></label>
                                <select class="form-control form-control-sm" id="timeisdisplay" required
                                    name="isdisplay" placeholder="">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center   ">
                            <div class="col-md-12">
                                <input name="submit" id="insertTime" class="btn btn-sm btn-primary btn-block"
                                    type="submit" value="Save">
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="submit" id="updateTime"
                                    class="btn btn-sm btn-success btn-block" style="display: none;" value="Update">
                                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtnn"
                                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                            </div>
                        </div>


                    </form>
                    <hr>
                    <div class="row" style="overflow-x:auto;overflow-y:auto;">
                        <div class="col-md-12">
                            <table id="timesTable" class="table table-striped" style="margin:20px">
                                <thead>
                                    <tr>
                                        <th>S.No </th>
                                        <th>Starting Time</th>
                                        <th>Ending Time</th>
                                        <th>Sequence</th>
                                        <th>Is Display</th>
                                        <th></th>

                                        <!-- <th>SubCat_name</th> -->
                                    </tr>
                                </thead>
                                <tbody id="timesbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class=" card-header" data-card-widget="collapse">
                <h3 class="card-title">Class Wise Teacher<Section></Section>
                    <Section></Section>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
<?php

// $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();

// foreach ($routeCollection as $value) {
//     echo $value->getPath();
// }

// dd(Route::getRoutes()->getRoutes());

// function getRoutesByGroup(array $group = [])
// {
//     $list = \Route::getRoutes()->getRoutes();
//     // dd($group);
//     if (empty($group)) {
//         return $list;
//     }

//     $routes = [];
//     foreach ($list as $route) {
//         $action = $route->getAction();
//         foreach ($group as $key => $value) {
//             if (empty($action[$key])) {
//                 continue;
//             }
//             $actionValues = Arr::wrap($action[$key]);
//             $values = Arr::wrap($value);
//             foreach ($values as $single) {
//                 foreach ($actionValues as $actionValue) {
//                     if (Str::is($single, $actionValue)) {
//                         $routes[] = $route->uri;
//                     } elseif($actionValue == $single) {
//                         $routes[] = $route->uri;
//                     }
//                 }
//             }
//         }
//     }
    
//     return $routes;
// }
// $campusid = Auth::user()->campusid;
// $pages = getRoutesByGroup(['middleware' => 'RolesAndPages']);
// foreach ($pages as $page) {
//     \App\Models\Pages::updateOrCreate(
//         ['page_head' => $page], 
//         [ 
//             'page_link' => $page,
//             'page_title' => $page,
//             'page_type' => 0,
//             'icon_id' => 5,
//             'page_order' => 100,
//             'campusid' => $campusid,
//         ]
//     );
//     // echo $page . '<br>';
// }

?>


            <div class="card-body collapse in">
                <div class="container-fluid">
                    <form id="classwiseteacher" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-4" style="display: none">
                                <label for="tableid" class="form-label"><b>location Id</b></label>
                                <input type="number" class="form-control form-control-sm" id="tableid" value="0"
                                    name="tableid" placeholder="">
                            </div>
                            <?php 
                                $classes = \App\Models\addClass::where('campusid', Auth::user()->campusid)->where('Isdisplay', 1)->get();
                            ?>
                            <div class="col-md-4">
                                <label for="classid" class="form-label"><b>Class</b></label>
                                <select class="form-control form-control-sm"
                                    onchange="fetchSectionForClass(this, this.selectedIndex)" id="classid" required
                                    name="classid" placeholder="">
                                    <option value="">Select class</option>
                                    @foreach ($classes as $class)
                                    <option value="{{ $class->C_id }}">{{ $class->ClassName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="section" class="form-label"><b>Section</b></label>
                                <select class="form-control form-control-sm" id="section" required name="section"
                                    placeholder="">
                                </select>
                            </div>
                            <?php 
                                $teachers = \App\Models\admin::where('admins.campusid', Auth::user()->campusid)->where('roles.campusid', Auth::user()->campusid)
                                ->where('admins.isactive', 1)->join('roles', 'roles.RoleId', '=', 'admins.roleid')->where('roles.IsActive', 1)
                                ->where('roles.Role', 'Teacher')->get();
                                // dd($teachers);
                            ?>
                            <div class="col-md-4">
                                <label for="empid" class="form-label"><b>Teacher</b></label>
                                <select class="form-control form-control-sm" id="empid" required name="empid"
                                    placeholder="">
                                    <option value="">Select teacher</option>
                                    @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center   ">
                            <div class="col-md-12">
                                <input name="submit" id="insertClassWiseTeacher"
                                    class="btn btn-sm btn-primary btn-block" type="submit" value="Save">
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="submit" id="updateClassWiseTeacher"
                                    class="btn btn-sm btn-success btn-block" style="display: none;" value="Update">
                                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtnnn"
                                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                            </div>
                        </div>


                    </form>
                    <hr>
                    <div class="row" style="overflow-x:auto;overflow-y:auto;">
                        <div class="col-md-12">
                            <table id="classWiseTeachersTable" class="table table-striped" style="margin:20px">
                                <thead>
                                    <tr>
                                        <th>S.No </th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Teacher</th>
                                        <th></th>

                                        <!-- <th>SubCat_name</th> -->
                                    </tr>
                                </thead>
                                <tbody id="classWiseTeachersBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<script src="{{ asset('userbackend/plugins/axios/axios.min.js') }}"></script>

{{-- Class wise teacher script --}}
<script>
    $("#updateClassWiseTeacher").click(req => {
        axios.put(`/admin/classwiseteachers/${$("#tableid").val()}`, $("#classwiseteacher").serialize())
        .then(res => {
            fetchClassWiseTeachers();
            swal('Update', "Successfully updated.", 'success');
            $("#classwiseteacher").trigger("reset");
            $('#updateClassWiseTeacher').hide();
            $('#cancelbtnnn').hide();
            $('#insertClassWiseTeacher').show();
            $('#insertClassWiseTeacher').prop('type', 'submit');
        }).catch((error) => {
            swal('Warning', error.response.data.success, 'warning');
        });
    });

    $("#insertClassWiseTeacher").click(req => {
        axios.post('/admin/classwiseteachers', $("#classwiseteacher").serialize())
        .then(res => {
            swal('Saved', "Successfully saved.", 'success');
            $("#classwiseteacher").trigger('reset');
            fetchClassWiseTeachers();
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

    const fetchClassWiseTeachers = () => {
        axios.get('/admin/classwiseteachers/1')
        .then(res => {
            classwiseteachers = res.data;
            var j=1;
            let html='';
            $('#classWiseTeachersTable').DataTable().destroy();
            for (i=0; i < classwiseteachers.length; i++) {
                html=html+'<tr ondblclick="EditClassWiseTeachers(' + classwiseteachers[i].tableid+','+ i +')">'+
                '<td>'+ j +'</td>'+
                '<td>'+classwiseteachers[i].ClassName +'</td>'+
                '<td>'+classwiseteachers[i].SectionName +'</td>'+
                '<td>'+classwiseteachers[i].name +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditClassWiseTeachers(' + classwiseteachers[i].tableid+','+ i +')"></i></a></td>'
                +'</tr>';
                j++;
            }
            $('#classWiseTeachersBody').html(html);
            $('#classWiseTeachersTable').DataTable();
        })
        .catch();
    }
    
    
    const EditClassWiseTeachers = (tableid, index) => {
        $('#updateClassWiseTeacher').show();
        $('#cancelbtnnn').show();
        $('#insertClassWiseTeacher').hide();
        $('#insertClassWiseTeacher').prop('type', '');
        
        $("#tableid").val(tableid);
        $("#classid").val(classwiseteachers[index].C_id);
        fetchSectionForClass(classwiseteachers[index].C_id, classwiseteachers[index].C_id);
        $("#section").val(classwiseteachers[index].Sec_ID);
        $("#empid").val(classwiseteachers[index].id);
    }
    
    function fetchSectionForClass(e, vall){
        if(vall == 0){
            $("#section").prop("disabled", true);
            document.getElementById("section").selectedIndex = 0;
        }else{
            $("#section").prop("disabled", false);
        }

        $.ajax({
            dataType: "json",
            type: 'GET',
            url: "{{ route('admin.FetchSectionForClassConfigration') }}",
            data: {classId: vall},
            success: function(SessionData)
            {
                sessionData=JSON.parse(SessionData);
                $("#section").empty();
                var j=1;
                $('#section').append("<option value=''>Select section</option>");
                for (i=0; i < sessionData.length; ++i) {
                    $('#section').append('<option value='+sessionData[i].SectionID+'>'+ sessionData[i].SectionName +'</option>');
                    j++;
                }
                // $("#section").prop('disabled', false);
            },
            error: function()
            {
                alert('internet issue');
            }
        });
    }
</script>
<script>
    $("#insertTime").click(req => {
        axios.post('/admin/times', $("#timeform").serialize())
        .then(res => {
            fetchTimes();
            swal('Saved', "Successfully saved.", 'success');
            $("#timeform").trigger('reset');
        }).catch((error) => {
            for (let key in error.response.data.errors) {
                swal('warning', error.response.data.errors[key][0], 'warning');
            }
        });
    });

    $("#insert").click(req => {
        axios.post('/admin/locations', $("#locationform").serialize())
        .then(res => {
            fetchLocations();
            swal('Saved', "Successfully saved.", 'success');
            $("#locationform").trigger('reset');
        }).catch((error) => {
            for (let key in error.response.data.errors) {
                swal('warning', error.response.data.errors[key][0], 'warning');
            }
        });
    });

    $("#updateTime").click(req => {
        axios.put(`/admin/times/${$("#timeid").val()}`, $("#timeform").serialize())
        .then(res => {
            if(res.data == 'duplicate'){
                swal('Duplicate', "Duplicate location.", 'info');
            }else{
                fetchTimes();
                swal('Update', "Successfully updated this location.", 'success');
                $("#timeform").trigger("reset");
                $('#updateTime').hide();
                $('#cancelbtnn').hide();
                $('#insertTime').show();
                $('#insertTime').prop('type', 'submit');
            }
        }).catch((error) => {
            for (let key in error.response.data.errors) {
                swal('warning', error.response.data.errors[key][0], 'warning');
            }
        });
    });

    $("#update").click(req => {
        axios.put(`/admin/locations/${$("#locationid").val()}`, $("#locationform").serialize())
        .then(res => {
            if(res.data == 'duplicate'){
                swal('Duplicate', "Duplicate location.", 'info');
            }else{
                fetchLocations();
                swal('Update', "Successfully updated this location.", 'success');
                $("#locationform").trigger("reset");
                $('#update').hide();
                $('#cancelbtn').hide();
                $('#insert').show();
                $('#insert').prop('type', 'submit');
            }
        }).catch((error) => {
            for (let key in error.response.data.errors) {
                swal('warning', error.response.data.errors[key][0], 'warning');
            }
        });
    });

    const EditLocation = (locationid, index) => {
        $('#update').show();
        $('#cancelbtn').show();
        $('#insert').hide();
        $('#insert').prop('type', '');
        
        $("#locationid").val(locationid);
        $("#locationname").val(locations[index].locationname);
        $("#sequence").val(locations[index].sequence);
        $("#isdisplay").val(locations[index].isdisplay);
    }

    const EditTime = (timeid, index) => {
        $('#updateTime').show();
        $('#cancelbtnn').show();
        $('#insertTime').hide();
        $('#insertTime').prop('type', '');
        
        // console.log(times[index].starttime.slice(0, -3));
        $("#timeid").val(timeid);
        $("#starttime").val(times[index].starttime.slice(0, -3));
        $("#endtime").val(times[index].endtime.slice(0, -3));
        $("#timesequence").val(times[index].sequence);
        $("#timeisdisplay").val(times[index].isdisplay);
    }

    const fetchTimes = () => {
        axios.get('/admin/times/1')
        .then(res => {
            times = res.data;
            var j=1;
            let html='';
            for (i=0; i < times.length; i++) {
                html=html+'<tr ondblclick="EditTime(' + times[i].id+','+ i +')">'+
                '<td>'+ j +'</td>'+
                '<td>'+times[i].starttime.slice(0, -3) +'</td>'+
                '<td>'+times[i].endtime.slice(0, -3) +'</td>'+
                '<td>'+times[i].sequence +'</td>'+
                '<td>'+ (times[i].isdisplay == 0 ? "No" : "Yes") +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditTime(' + times[i].id+','+ i +')"></i></a></td>'
                +'</tr>';
                j++;
            }
            $('#timesbody').html(html);
            $('#timesTable').DataTable();
        })
        .catch();
    }

    const fetchLocations = () => {
        axios.get('/admin/locations/1')
        .then(res => {
            locations = res.data;
            var j=1;
            var html='';
            $('#locationsTable').DataTable().destroy();
            for (i=0; i < locations.length; i++) {
                html=html+'<tr ondblclick="EditLocation(' + locations[i].id+','+ i +')">'+
                '<td>'+ j +'</td>'+
                '<td>'+locations[i].locationname +'</td>'+
                '<td>'+locations[i].sequence +'</td>'+
                '<td>'+ (locations[i].isdisplay == 0 ? "No" : "Yes") +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditLocation(' + locations[i].id+','+ i +')"></i></a></td>'
                +'</tr>';
                j++;
            }
            $('#locationsbody').html(html);
            $('#locationsTable').DataTable();
        })
        .catch();
    }
    
    function ResetFormByCancelKey(){
        $("#locationform").trigger("reset");
        $('#update').hide();
        $('#cancelbtn').hide();
        $('#insert').show();
        $('#insert').prop('type', 'submit');

        $("#timeform").trigger("reset");
        $('#updateTime').hide();
        $('#cancelbtnn').hide();
        $('#insertTime').show();
        $('#insertTime').prop('type', 'submit');

        $("#classwiseteacher").trigger("reset");
        $('#updateClassWiseTeacher').hide();
        $('#cancelbtnnn').hide();
        $('#insertClassWiseTeacher').show();
        $('#insertClassWiseTeacher').prop('type', 'submit');
    }
    $(document).ready(function(){        
        fetchLocations();
        fetchTimes();
        fetchClassWiseTeachers();
    });





</script>



@endsection