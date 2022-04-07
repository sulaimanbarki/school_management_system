@extends('admin.admin_master')



@section('Admindata')


<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            {{-- <div class="card card-primary"> --}}
                <div class="card-header" data-card-widget="collapse">
                    <h3 class="card-title">Company Payment</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body collapse in">
                    {{-- <div class="card-body"> --}}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form id="companywalletform" onsubmit="return false" method="POST">
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 d-none">
                                                        <label for="walletid" class="form-label"><b>Head
                                                                Id</b></label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="walletid" name="walletid" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="company_id"
                                                            class="form-label"><b>Company</b></label>
                                                        @php
                                                        $companies = DB::table('companies')
                                                        ->where('campusid', Auth::user()->campusid)
                                                        ->get();
                                                        @endphp
                                                        <select type="text" class="form-control form-control-sm"
                                                            id="company_id" required name="company_id" placeholder="">
                                                            <option value="">Select Company</option>
                                                            @foreach ($companies as $company)
                                                            <option value="{{$company->id}}">{{$company->company_name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="description" class="form-label"><b>
                                                                Description</b></label>
                                                        <input name="description" type="text"
                                                            class="form-control form-control-sm" id="description"
                                                            required placeholder="" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="date" class="form-label">Date</label>
                                                        <input type="date" value="{{date('Y-m-d')}}"
                                                            class="form-control form-control-sm" id="date"
                                                            name="date" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="amount" class="form-label">Amount</label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="amount" name="amount" />
                                                    </div>
                                                </div>
                                                <br />
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <input type="submit" name="saveCategory" id="saveCategory"
                                                            class="btn btn-sm btn-primary btn-block" value="Save">
                                                        <input type="submit" name="updateCategory" id="updateCategory"
                                                            class="btn btn-sm btn-success btn-block"
                                                            style="display: none;" value="Update">
                                                        <input type="submit" onclick="ResetFormByCancelKey()"
                                                            id="cancelbtn" class="btn btn-sm btn-danger btn-block"
                                                            style="display: none;" value="Cancel">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="categoryTable" class="table table-responsive-sm categoryTable">
                                                <thead>
                                                    <tr>
                                                        <th>#.</th>
                                                        <th>Company Name</th>
                                                        <th>Description</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="categoryTableBody">
                                                </tbody>
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


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary collapsed-card">
                    <div class="card-header" data-card-widget="collapse">
                        <h3 class="card-title">User Payment</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body collapse in">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form id="userwalletform" onsubmit="return false" method="POST">
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 d-none">
                                                        <label for="userwalletid" class="form-label"><b>Head
                                                                Id</b></label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="userwalletid" name="userwalletid" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        @php
                                                        // select roleid from role where role = teacher
                                                        $roleid = DB::table('roles')->where('Role', '=',
                                                        'teacher')->value('RoleId');
                                                        // select all from admins where roleid = $roleid
                                                        $teachers = DB::table('admins')->where('roleid', '=',
                                                        $roleid)->get();
                                                        @endphp
                                                        <label for="user_id" class="form-label"><b>Users</b></label>
                                                        <select type="text" class="form-control form-control-sm"
                                                            id="user_id" required name="user_id" placeholder="">
                                                            <option value="">Select User</option>
                                                            @foreach ($teachers as $teacher)
                                                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="userdescription" class="form-label"><b>
                                                                Description</b></label>
                                                        <input name="description" type="text"
                                                            class="form-control form-control-sm" id="userdescription"
                                                            required placeholder="" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="useramount" class="form-label"><b>
                                                                Amount</b></label>
                                                        <input name="amount" type="number"
                                                            class="form-control form-control-sm" id="useramount"
                                                            required placeholder="" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="datee" class="form-label">Date</label>
                                                        <input type="date" value="{{date('Y-m-d')}}"
                                                            class="form-control form-control-sm" id="datee"
                                                            name="date" />
                                                    </div>
                                                </div>
                                                <br />
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <input type="submit" name="saveuserwallet" id="saveuserwallet"
                                                            class="btn btn-sm btn-primary btn-block" value="Save">
                                                        <input type="submit" name="updateuserwallet"
                                                            id="updateuserwallet"
                                                            class="btn btn-sm btn-success btn-block"
                                                            style="display: none;" value="Update">
                                                        <input type="submit" onclick="ResetFormByCancelKey()"
                                                            id="cancelbtnnn" class="btn btn-sm btn-danger btn-block"
                                                            style="display: none;" value="Cancel">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="SubCategoryTable"
                                                class="table table-responsive-sm SubCategoryTable">
                                                <thead>
                                                    <tr>
                                                        <th>#.</th>
                                                        <th>User</th>
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="SubCategoryTableBody">
                                                </tbody>
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




        <script src="{{ asset('userbackend/plugins/axios/axios.min.js')}}"></script>
        <script>
            $('body').on('click', '.editCompany', function () {
                var id = $(this).data('id');
                $.get("/admin/companywallet/" + id +'/edit', function (data) {
                    $('#walletid').val(id);
                    $('#company_id').val(data.company_id);
                    $('#company_name').val(data.company_name);
                    $('#date').val(data.date);
                    $('#description').val(data.description);
                    $('#amount').val(data.amount);

                    $('#saveCategory').hide().prop('type', '');
                    $('#updateCategory').show();
                    $('#cancelbtn').show();
                })
            });

            $('body').on('click', '.edituserwallet', function () {
                var id = $(this).data('id');
                $.get("/admin/userwallet/" + id +'/edit', function (data) {
                    $('#userwalletid').val(id);
                    $('#user_id').val(data.user_id);
                    $('#datee').val(data.date);
                    $('#userdescription').val(data.description);
                    $('#useramount').val(data.amount);

                    $('#saveuserwallet').hide().prop('type', '');
                    $('#updateuserwallet').show();
                    $('#cancelbtnnn').show();
                })
            });

    function ResetFormByCancelKey(){
        $("#companywalletform").trigger('reset');
        $('#updateCategory').hide();
        $('#cancelbtn').hide();
        $('#saveCategory').show().prop('type', 'submit');

        $("#userwalletform").trigger('reset');
        $('#updateuserwallet').hide();
        $('#cancelbtnnn').hide();
        $('#saveuserwallet').show().prop('type', 'submit');
    }
    
    $(document).ready(function(){
        LoadCompany();
    })

    $('#saveuserwallet').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/userwallet",
            method: 'POST',
            data: $("#userwalletform").serialize(),
            success: function(result){
            $("#userwalletform").trigger('reset');
            LoadCompany();
            swal("Good job!", "Successfully added!", "success");
            // $("#AddConfigForm").trigger("reset");
            },
            error: function(error) {
                if(error.responseJSON.success == 'Duplicate Entry.'){
                    swal('Warning', error.responseJSON.success, 'warning');
                }
                $.each(error.responseJSON.errors, function(field_name,error){
                    swal('Warning', error[0], 'warning');
                    // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                });
            }
        });
    });

    $('#saveCategory').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/companywallet",
            method: 'POST',
            data: $("#companywalletform").serialize(),
            success: function(result){
            $("#companywalletform").trigger('reset');
            LoadCompany();
            swal("Good job!", "Successfully added!", "success");
            // $("#AddConfigForm").trigger("reset");
            },
            error: function(error) {
                if(error.responseJSON.success == 'Duplicate Entry.'){
                    swal('Warning', error.responseJSON.success, 'warning');
                }
                $.each(error.responseJSON.errors, function(field_name,error){
                    swal('Warning', error[0], 'warning');
                    // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                });
            }
        });
    });

    $('#updateCategory').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/companywallet",
            method: 'POST',
            data: $("#companywalletform").serialize(),
            success: function(result){
                $("#companywalletform").trigger('reset');
                $('#updateCategory').hide();
                $('#cancelbtn').hide();
                $('#saveCategory').show().prop('type', 'submit');
                LoadCompany();
                swal("Good job!", "Successfully updated!", "success");
            },
            error: function(error) {
                if(error.responseJSON.success == 'Duplicate Entry.'){
                    swal('Warning', error.responseJSON.success, 'warning');
                }
                $.each(error.responseJSON.errors, function(field_name,error){
                    swal('Warning', error[0], 'warning');
                    // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                });
            }
        });
    });

    $('#updateuserwallet').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/userwallet",
            method: 'POST',
            data: $("#userwalletform").serialize(),
            success: function(result){
                $("#userwalletform").trigger('reset');
                $('#updateuserwallet').hide();
                $('#cancelbtnnn').hide();
                $('#saveuserwallet').show().prop('type', 'submit');
                LoadCompany();
                swal("Good job!", "Successfully updated!", "success");
            },
            error: function(error) {
                if(error.responseJSON.success == 'Duplicate Entry.'){
                    swal('Warning', error.responseJSON.success, 'warning');
                }
                $.each(error.responseJSON.errors, function(field_name,error){
                    swal('Warning', error[0], 'warning');
                    // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                });
            }
        });
    });


    function LoadCompany() {

        $('.categoryTable').DataTable().destroy();
        var table = $('.categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/companywallet",
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'description', name: 'description'},
                    {data: 'date', name: 'date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                autoWidth: false,
                drawCallback: function (params) {
                    // console.log(params.json.data);
                }
        });

        $('.SubCategoryTable').DataTable().destroy();
        var table = $('.SubCategoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/userwallet",
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                autoWidth: false,
                drawCallback: function (params) {
                    // console.log(params.json.data);
                }
        });
    }
        </script>

        @endsection