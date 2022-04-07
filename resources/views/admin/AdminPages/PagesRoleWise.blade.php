@extends('admin.admin_master')



@section('Admindata')
<?php
    // $iconsArray = Array();
    $iconsArray = DB::select('SELECT * FROM icons ORDER BY icon_name ASC');
    
    // $rowHeads = Array();
    $rowHeads = DB::select("SELECT page_head FROM pages
    GROUP BY page_head ORDER BY page_head ASC");
    // dd($rowHeads);
    ?>

<?php
    
    //Variable used for page title and left navbar
    $fa = 'file-text-o';
    
    $iconsArray = [];
    
    $iconsArray = DB::select('SELECT * FROM icons ORDER BY icon_name ASC');
    
    // Page List form
    if (isset($_POST['saveRolePage'])) {
        $role_id = $_POST['select_role'];
    
        $checkPage = DB::select("DELETE FROM role_pages WHERE role_id = '$role_id'");
    
        // foreach($_POST['role_page_id'] as $page_id){
        //     $qryInsertPage = $dbo->prepare("INSERT INTO role_pages (pages_id, role_id)
        //                     VALUES (:page_id, :role_id)");
        //     $qryInsertPage->bindParam('page_id', $page_id);
        //     $qryInsertPage->bindParam('role_id', $role_id);
        //     $qryInsertPage->execute();
        // }
    
        // if($qryInsertPage){
        //     echo "<script>window.location = 'role_pages.php?m=1'; </script>";
        // }
        // else{
        //     echo "<script>window.location = 'role_pages.php?m=0'; </script>";
        // }
    }
    ?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">

            <div class="page-wrapper">

                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                            Assign Pages to Role
                                    </h5>
                                </div>
                                <div class="card-block pl-4 pr-4">
                                    <form class="form" method="post">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                <div class="form-group form-group-sm">
                                                    <label for="select_role">Select Role</label>
                                                    <select onchange="LoadRoleWisePages()" name="select_role"
                                                        id="select_role" class="form-control">
                                                        <option value="0">Select Role</option>
                                                        <?php
                                                            $qryRoles = DB::select("SELECT * FROM roles -- WHERE role_name != 'Super Admin'");
                                                            foreach ($qryRoles as  $value) {
                                                            ?>
                                                        <option value="<?php echo $value->RoleId; ?>">
                                                            <?php echo $value->Role; ?>
                                                        </option>
                                                        <?php
                                                                }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="form-group form-group-sm">
                                                    <input form="roleWisePagesForm" type="submit" name="saveRolePage"
                                                        id="saveRolePage" class="btn btn-primary pull-left btn-block"
                                                        value="Save" />
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 show_pages">

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php /* Role Pages Data */ ?>
                    <div class="row role-pages">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Pages List</h5>
                                </div>
                                <div class="card-block p-4">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="" onsubmit="return false" id="roleWisePagesForm">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Page Title</th>
                                                            <th>Page Link</th>
                                                            <th>Page Icon</th>
                                                            <th>Page Type</th>
                                                            <th>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        class="checkbox" value="" id="checkall">
                                                                    <label class="form-check-label" for="checkall">Check
                                                                        All</label>
                                                                </div>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="role_pages_show1">
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>





            <!-- /.card-body -->

        </div>

        <!-- /.card -->

    </div>



</div>

<?php
    //All Scripts
    ?>
<script>
    var role_id;
        function changeCheckValue(e){
            if(e.target.nextSibling.value == 1){
                e.target.nextSibling.value = 0;
            }else{
                e.target.nextSibling.value = 1;
            }
        }

        const LoadRoleWisePages = () => {
            role_id = $("#select_role").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            //   debugger
            $.ajax({
                url: "{{ route('admin.PagesRoleWiseLoad') }}",
                method: 'POST',
                data: { role_id: role_id },
                success: function(result) {
                    dataa = JSON.parse(result);
                    var j = 1;
                    var html = '';
                    for (i = 0; i < dataa.length; ++i) {
                        html = html + '<tr>' +
                            '<td>' + dataa[i].page_title + '</td>' +
                            '<td>' + dataa[i].page_link + '</td>' +
                            '<td><i class="' + dataa[i].icon_fa + '"></i> ' + dataa[i].icon_fa + '</td>' +
                            '<td>' + (dataa[i].page_type ? 'Hidden' : 'Open') + '</td>' +
                            '<td>' + '<input type="checkbox" name="role_page_id[]" id="role_page_id" ' + 
                                (dataa[i].role_id > 0 ? "checked" : "") + ' ' + dataa[i].page_id +
                            ' onchange="changeCheckValue(event)"/>' + 
                            '<input type="hidden" name="checkStatus[]" value="' + (dataa[i].role_id > 0 ? 1 : 0) + '" />' +
                            '<input type="hidden" name="page_id[]" value="' + dataa[i].page_id  + '" />' +
                            '<input type="hidden" name="role_id[]" value="' + role_id  + '" />' +
                            '</td>' +
    
                            // dataa[i].page_id + '>' +
                            // '<i class="' + dataa[i].icon_fa + '"></i> ' + dataa[i].page_title +
                            // '<br/>(' + dataa[i].page_link + ')' +
                            '</tr>';
                        j++;
                    }
                    // alert(html);
                    $('#role_pages_show1').html(html);
    
                },
                error: function(error) {
                    $.each(error.responseJSON.errors, function(field_name, error) {
                        swal('Warning', error[0], 'warning');
                        // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                    });
                }
            });
        }

        $("#roleWisePagesForm").submit(req => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.UpdatePagesRole') }}",
                method: 'POST',
                data: $("#roleWisePagesForm").serialize(),
                success: function(result) {
                    swal("Succeess", 'Roles changed successfully.', 'success');
                    LoadRoleWisePages();
                },
                error: function(error) {
                    $.each(error.responseJSON.errors, function(field_name, error) {
                        swal('Warning', error[0], 'warning');
                        // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                    });
                }
            });
        })

        $(document).ready(function() {

            // $('.role-pages').hide();
            // $('.show-btn').hide();


            $('.table').on('click', '.delete_page', function() {
                var row = $(this).parent().parent();
                var page_id_r = row.find('.page_id_r').val();
                var role_id_r = row.find('.role_id_r').val();
                var page_title_r = row.find('.page_title_r').val();
                var page_link_r = row.find('.page_link_r').val();
                var page_icon_id_r = row.find('.page_icon_id_r').val();

                var txt = "Page Title: " + page_title_r +
                    "\nPage Link: " + page_link_r +
                    "\nPage Icon: " + page_icon_id_r;

                var data = "page_id_r=" + page_id_r + "&role_id_r=" + role_id_r;

                swal({
                    title: "Are you sure to delete?",
                    text: txt,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, function() {
                    $.ajax({
                        type: 'POST',
                        url: 'ajax_delete_role_page.php',
                        data: data,
                        success: function(result) {
                            if (result == "success") {
                                swal("Deleted!", "Page has been deleted.", "success");
                                row.remove();
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax_get_role_pages.php',
                                    data: 'role_id=' + role_id_r,
                                    success: function(result) {
                                        $('.show_pages').html(result);
                                        $('.show-btn').show();

                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajax_get_pages.php',
                                            data: 'role_id=' +
                                                role_id_r,
                                            success: function(
                                                result) {
                                                $('.role-pages')
                                                    .show();
                                                $('.role_pages_show')
                                                    .html(
                                                        result);
                                            }
                                        });
                                    }
                                });
                            } else if (result == "error") {
                                swal("Error Deleting!",
                                    "Page cannot be deleted due to some technical error occured.",
                                    "warning");
                            }
                        }
                    });
                });
            });

            <?php
if(isset($_GET['m']) && $_GET['m'] == 3){
?>
            notify('top', 'right', '', 'success', 'Page updated successfully!!');
            <?php
}
elseif(isset($_GET['m']) && $_GET['m'] == 2){
?>
            notify('top', 'right', '', 'danger', 'Page updation error!!');
            <?php
}
elseif(isset($_GET['m']) && $_GET['m'] == 5){
?>
            notify('top', 'right', '', 'success', 'Page deleted successfully!!');
            <?php
}
elseif(isset($_GET['m']) && $_GET['m'] == 4){
?>
            notify('top', 'right', '', 'danger', 'Page deletion error!!');
            <?php
}
?>
        });

        $("#checkall").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
            $('input:checkbox').each(function (indexInArray, valueOfElement) {
            if(this.checked){
                this.nextSibling.value = 1;
            }else{
                this.nextSibling.value = 0;
            }
            });
        });
</script>
@endsection