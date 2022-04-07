@extends('admin.admin_master')



@section('Admindata')

<?php

function getRoutesByGroup(array $group = [])
{
    $list = \Route::getRoutes()->getRoutes();
    // dd($group);
    if (empty($group)) {
        return $list;
    }

    $routes = [];
    foreach ($list as $route) {
        $action = $route->getAction();
        foreach ($group as $key => $value) {
            if (empty($action[$key])) {
                continue;
            }
            $actionValues = Arr::wrap($action[$key]);
            $values = Arr::wrap($value);
            foreach ($values as $single) {
                foreach ($actionValues as $actionValue) {
                    if (Str::is($single, $actionValue)) {
                        $routes[] = $route->uri;
                    } elseif($actionValue == $single) {
                        $routes[] = $route->uri;
                    }
                }
            }
        }
    }
    
    return $routes;
}
$campusid = Auth::user()->campusid;
$pages = getRoutesByGroup(['middleware' => 'RolesAndPages']);
foreach ($pages as $page) {
    \App\Models\Pages::firstOrCreate(
        ['page_link' => $page], 
        [ 
            'page_head' => $page,
            'page_title' => $page,
            'page_type' => 0,
            'icon_id' => rand(1,585),
            'page_order' => 100,
            'campusid' => $campusid,
        ]
    );
    // echo $page . '<br>';
}


$iconsArray = DB::select("SELECT * FROM icons ORDER BY icon_name ASC");

// $rowHeads = Array();
$rowHeads = DB::select("SELECT page_head FROM pages
GROUP BY page_head ORDER BY page_head ASC");
// dd($rowHeads);


?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">

            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="page-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="card-header">

                                            <button type="button"
                                                class="pull-right btn btn-primary btn-sm btn-outline-primary waves-effect text-white"
                                                data-backdrop="" data-toggle="modal" data-target="#small-Modal"><i
                                                    class="fa fa-plus"></i> &nbsp;Add Page</button>
                                        </div>
                                        <div class="card-block">
                                            <div class="dt-responsive table-responsive p-4">
                                                <table class="table datatable" id="pagesTable">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Page Title</th>
                                                            <th class="select-filter">Page Head</th>
                                                            <th>Page Link</th>
                                                            <th>Page Icon</th>
                                                            <th>Page Type</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="pagesBody">

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <?php /* Page Adding Modal */ ?>
            <div class="modal fade" id="small-Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Page</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form method="post" onsubmit="return false" id="pagesForm">
                                        <div class="form-group">
                                            <label for="page_title">Page Title</label>
                                            <input required type="text" name="page_title" palceholder="Enter Page Title"
                                                class="form-control" />
                                        </div>

                                        <div class="form-group">
                                            <label for="page_head">Page Head</label>
                                            <input required list="page_heads2" autocomplete="off" type="text"
                                                name="page_head" id="page_head" class="form-control" />
                                            <datalist id="page_heads2">
                                                <?php
                                                    foreach($rowHeads as $heads){
                                                ?>
                                                <option value="<?php echo $heads->page_head; ?>">
                                                    <?php
                                                        }
                                                    ?>
                                            </datalist>
                                        </div>

                                        <div class="form-group">
                                            <label for="page_link">Page Link</label>
                                            <input required type="text" name="page_link" palceholder="Enter Page Link"
                                                class="form-control" />
                                        </div>

                                        <div class="form-group">
                                            <label for="page_icon_id">Page Icon</label>
                                            <select class="form-control" name="page_icon_id" id="page_icon_id">
                                                <option>Select Icon</option>
                                                <?php
                                            foreach($iconsArray as $icon){
                                                ?>
                                                <option value="<?php echo $icon->icon_id; ?>">
                                                    <?php echo $icon->icon_name.' - '.$icon->icon_code; ?>
                                                </option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="page_type">Page Type</label>
                                            <select class="form-control" name="page_type" id="page_type">
                                                <option value="0">Open</option>
                                                <option value="1">Hidden</option>
                                            </select>
                                        </div>

                                        <div class="form-group" style="padding-top: 10px;">
                                            <input type="submit" name="savePage" class="btn btn-primary pull-right" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger text-white btn-outline-danger waves-effect "
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php /* Page Updating Modal */ ?>
            <div class="modal fade" id="update-Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Page</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form onsubmit="return false" id="updateForm">
                                        <input type="hidden" name="page_id_u" id="page_id_u" />
                                        <div class="form-group">
                                            <label for="page_title_u">Page Title</label>
                                            <input required type="text" name="page_title" id="page_title_u"
                                                class="form-control" />
                                        </div>

                                        <div class="form-group">
                                            <label for="page_head_u">Page Head</label>
                                            <input required list="page_heads" autocomplete="off" type="text"
                                                name="page_head" id="page_head_u" class="form-control" />
                                            <datalist id="page_heads">
                                                <?php
                                                    foreach($rowHeads as $heads){
                                                ?>
                                                <option value="<?php echo $heads->page_head; ?>">
                                                    <?php
                                                        }
                                                    ?>
                                            </datalist>
                                        </div>

                                        <div class="form-group">
                                            <label for="page_link_u">Page Link</label>
                                            <input required type="text" name="page_link" id="page_link_u"
                                                class="form-control" />
                                        </div>

                                        <div class="form-group">
                                            <label for="page_icon_id_u">Page Icon</label>
                                            <select class="form-control" name="page_icon_id" id="page_icon_id_u">
                                                <option>Select Icon</option>
                                                <?php
                                                    foreach($iconsArray as $icon){
                                                ?>
                                                <option value="<?php echo $icon->icon_id; ?>">
                                                    <?php echo $icon->icon_name.' - '.$icon->icon_code; ?>
                                                </option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="page_type_u">Page Type</label>
                                            <select class="form-control" name="page_type" id="page_type_u">
                                                <option value="0">Open</option>
                                                <option value="1">Hidden</option>
                                            </select>
                                        </div>

                                        <div class="form-group" style="padding-top: 10px;">
                                            <input type="submit" name="updatePage" class="btn btn-primary pull-right" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /.card-body -->

        </div>

        <!-- /.card -->

    </div>



</div>

<script src="{{ asset('userbackend/plugins/axios/axios.min.js') }}"></script>
<script>
    $("#pagesForm").submit(req => {
        axios.post('/admin/adminpages', $("#pagesForm").serialize())
        .then(res => {
            $('#small-Modal').modal('hide');
            fetchPage();
            swal('Saved', "Successfully saved new page.", 'success');
            $("#pagesForm").trigger('reset');
        })
    });

    $("#updateForm").submit(req => {
        axios.put(`/admin/adminpages/${$("#page_id_u").val()}`, $("#updateForm").serialize())
        .then(res => {
            $('#update-Modal').modal('hide');
            fetchPage();
            swal('Update', "Successfully updated this page.", 'success');
        })
    });

    const EditPage = (page_id, index) => {
        $("#page_id_u").val(page_id);
        $("#page_title_u").val(pages[index].page_title);
        $("#page_head_u").val(pages[index].page_head);
        $("#page_link_u").val(pages[index].page_link);
        $("#page_icon_id_u").val(pages[index].icon_id);
        $("#page_type_u").val(pages[index].page_type);
        $('#update-Modal').modal('show');
    }

    const fetchPage = () => {
        axios.get('/admin/adminpages')
        .then(res => {
            pages = res.data;
            var j=1;
            var html='';
            for (i=0; i < pages.length; i++) {
                html=html+'<tr>'+
                '<td>'+ j +'</td>'+
                '<td>'+pages[i].page_title +'</td>'+
                '<td>'+pages[i].page_head +'</td>'+
                '<td>'+pages[i].page_link +'</td>'+
                '<td><i class="'+ pages[i].icon_fa + '"></i> ' + pages[i].icon_fa +'</td>'+
                '<td>'+ (pages[i].page_type == 0 ? "Open" : "Hidden") +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditPage(' + pages[i].page_id+','+ i +')"></i></a></td>'
                +'</tr>';
                    j++;
            }
            $('#pagesBody').html(html);
            $('#pagesTable').DataTable( {
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

    function ResetFormByCancelKey(){
        $("#AddConfigForm").trigger("reset");
        $('#update').hide();
        $('#cancelbtn').hide();
        $('#insert').show();
        $('#insert').prop('type', 'submit');
    }
    $(document).ready(function(){
        fetchPage();
    });





</script>



@endsection