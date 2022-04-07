@extends('admin.admin_master')



@section('Admindata')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Create Company</h3>
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
                                    <form id="companyform" onsubmit="return false" method="POST">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-none">
                                                <label for="companyid" class="form-label"><b>Head Id</b></label>
                                                <input type="number" class="form-control form-control-sm" id="companyid"
                                                    name="companyid" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="company_name" class="form-label"><b>Company
                                                        Name</b></label>
                                                <input name="company_name" type="text"
                                                    class="form-control form-control-sm" id="company_name" required
                                                    placeholder="" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control form-control-sm" id="address"
                                                    name="address" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="contact1" class="form-label">Contact 1</label>
                                                <input type="tel" class="form-control form-control-sm" id="contact1"
                                                    name="contact1" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="contact2" class="form-label">Contact 2</label>
                                                <input type="tel" class="form-control form-control-sm" id="contact2"
                                                    name="contact2" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="description" class="form-label">Description</label>
                                                <input type="text" class="form-control form-control-sm" id="description"
                                                    name="description" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="logo" class="form-label">Logo Path</label>
                                                <input type="file" class="form-control-file" id="logo" name="logo" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date_of_registeration" class="form-label">Date of
                                                    Registration</label>
                                                <input type="date" class="form-control form-control-sm"
                                                    id="date_of_registeration" name="date_of_registeration" />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <input type="submit" name="saveCompany" id="saveCompany"
                                                    class="btn btn-sm btn-primary btn-block" value="Save">
                                                <input type="submit" name="updateCompany" id="updateCompany"
                                                    class="btn btn-sm btn-success btn-block" style="display: none;"
                                                    value="Update">
                                                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                                                    class="btn btn-sm btn-danger btn-block" style="display: none;"
                                                    value="Cancel">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="accountsTable" class="table table-responsive-sm accountsTable">
                                        <thead>
                                            <tr>
                                                <th>#.</th>
                                                <th>Company Name</th>
                                                <th>Address</th>
                                                <th>Contact</th>
                                                <th>Description</th>
                                                <th>Reg. Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="accountsTableBody">
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
            {{-- <div class="card card-primary"> --}}
                <div class="card-header" data-card-widget="collapse">
                    <h3 class="card-title">Main Categories</h3>
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
                                            <form id="maincategoriesform" onsubmit="return false" method="POST">
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 d-none">
                                                        <label for="maincategoryid" class="form-label"><b>Head
                                                                Id</b></label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="maincategoryid" name="maincategoryid" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="main_category_name" class="form-label"><b>
                                                                Category Name</b></label>
                                                        <input name="main_category_name" type="text"
                                                            class="form-control form-control-sm" id="main_category_name"
                                                            required placeholder="" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="company_id"
                                                            class="form-label"><b>Company</b></label>
                                                        <select type="text" class="form-control form-control-sm"
                                                            id="company_id" required name="company_id" placeholder="">
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="date" class="form-label">Date</label>
                                                        <input type="date"  value="{{date('Y-m-d')}}"  class="form-control form-control-sm"
                                                            id="date" name="date" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="isdisplay" class="form-label"><b>Is
                                                                Display</b></label>
                                                        <select class=" form-control form-control-sm" required
                                                            name="isdisplay" id="isdisplay">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="sequence" class="form-label">Sequence</label>
                                                        <input type="number" min="1" max="20"
                                                            class="form-control form-control-sm" id="sequence"
                                                            name="sequence" />
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
                                                            id="cancelbtnn" class="btn btn-sm btn-danger btn-block"
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
                                                        <th>Category Name</th>
                                                        <th>Company Name</th>
                                                        <th>Date</th>
                                                        <th>Is Display</th>
                                                        <th>Sequence</th>
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
                <h3 class="card-title">Sub Categories</h3>
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
                                    <form id="subcategoriesform" onsubmit="return false" method="POST">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-none">
                                                <label for="subcategoryid" class="form-label"><b>Head
                                                        Id</b></label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="subcategoryid" name="subcategoryid" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="company_idd" class="form-label"><b>Company</b></label>
                                                <select type="text" onchange="LoadMainCategories(this.value)"  class="form-control form-control-sm"
                                                    id="company_idd" required name="company_id" placeholder="">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="main_category_id" class="form-label"><b>
                                                        Category Name</b></label>
                                                <select type="text" class="form-control form-control-sm"
                                                    id="main_category_id" required name="main_category_id"
                                                    placeholder="">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sub_category_name" class="form-label"><b>
                                                        Sub Category Name</b></label>
                                                <input name="sub_category_name" type="text"
                                                    class="form-control form-control-sm" id="sub_category_name" required
                                                    placeholder="" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="datee" class="form-label">Date</label>
                                                <input type="date" value="{{date('Y-m-d')}}" class="form-control form-control-sm" id="datee"
                                                    name="date" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="isdisplayy" class="form-label"><b>Is
                                                        Display</b></label>
                                                <select class=" form-control form-control-sm" required name="isdisplay"
                                                    id="isdisplayy">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sequencee" class="form-label">Sequence</label>
                                                <input type="number" min="1" max="20"
                                                    class="form-control form-control-sm" id="sequencee"
                                                    name="sequence" />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <input type="submit" name="saveSubCategory" id="saveSubCategory"
                                                    class="btn btn-sm btn-primary btn-block" value="Save">
                                                <input type="submit" name="updateSubCategory" id="updateSubCategory"
                                                    class="btn btn-sm btn-success btn-block" style="display: none;"
                                                    value="Update">
                                                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtnnn"
                                                    class="btn btn-sm btn-danger btn-block" style="display: none;"
                                                    value="Cancel">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="SubCategoryTable" class="table table-responsive-sm SubCategoryTable">
                                        <thead>
                                            <tr>
                                                <th>#.</th>
                                                <th>Category</th>
                                                <th>Main Category</th>
                                                <th>Company Name</th>
                                                <th>Date</th>
                                                <th>Is Display</th>
                                                <th>Sequence</th>
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
    
    $('body').on('click', '.editSubCategory', function () {
        var id = $(this).data('id');
        $.get("/admin/subcategories/" + id +'/edit', function (data) {
            $('#subcategoryid').val(id);
            $('#sub_category_name').val(data.sub_category_name);
            $('#company_idd').val(data.company_id);
            $('#main_category_id').val(data.main_category_id);
            $('#datee').val(data.date);
            $('#isdisplayy').val(data.isdisplay);
            $('#sequencee').val(data.sequence);

            $('#saveSubCategory').hide().prop('type', '');
            $('#updateSubCategory').show();
            $('#cancelbtnnn').show();
            // selected index = 0 jquery
            $('#company_idd').prop('selectedIndex', 0);
            // $("#main_category_id").empty();

        })
    });

    $('body').on('click', '.editMainCategory', function () {
        var id = $(this).data('id');
        $.get("/admin/maincategories/" + id +'/edit', function (data) {
            $('#maincategoryid').val(id);
            $('#main_category_name').val(data.main_category_name);
            $('#company_id').val(data.company_id);
            $('#date').val(data.date);
            $('#isdisplay').val(data.isdisplay);
            $('#sequence').val(data.sequence);

            $('#saveCategory').hide().prop('type', '');
            $('#updateCategory').show();
            $('#cancelbtnn').show();
        })
    });

    $('body').on('click', '.editCompany', function () {
        var id = $(this).data('id');
        $.get("/admin/companies/" + id +'/edit', function (data) {
            $('#modelHeading').html("Edit Book");
            $('#companyid').val(id);
            $('#company_name').val(data.company_name);
            $('#address').val(data.address);
            $('#contact1').val(data.contact1);
            $('#contact2').val(data.contact2);
            $('#description').val(data.description);
            $('#date_of_registeration').val(data.date_of_registeration);

            $('#saveCompany').hide();
            $('#saveCompany').prop('type', '');
            $('#updateCompany').show();
            $('#cancelbtn').show();
        })
    });

    function ResetFormByCancelKey(){
        $("#companyform").trigger('reset');
        $('#updateCompany').hide();
        $('#cancelbtn').hide();
        $('#saveCompany').show().prop('type', 'submit');

        $("#maincategoriesform").trigger('reset');
        $('#updateCategory').hide();
        $('#cancelbtnn').hide();
        $('#saveCategory').show().prop('type', 'submit');

        $("#subcategoriesform").trigger('reset');
        $('#updateSubCategory').hide();
        $('#cancelbtnnn').hide();
        $('#saveSubCategory').show().prop('type', 'submit');
    }
    
    $(document).ready(function(){
        LoadCompany();
    })


    $('#saveSubCategory').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/subcategories",
            method: 'POST',
            data: $("#subcategoriesform").serialize(),
            success: function(result){
            $("#subcategoriesform").trigger('reset');
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
            url: "/admin/maincategories",
            method: 'POST',
            data: $("#maincategoriesform").serialize(),
            success: function(result){
            $("#maincategoriesform").trigger('reset');
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

    $('#saveCompany').click(function(){
        var formData = new FormData(document.getElementById("companyform"));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/companies",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result){
            $("#companyform").trigger('reset');
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

    $('#updateSubCategory').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/subcategories",
            method: 'POST',
            data: $("#subcategoriesform").serialize(),
            success: function(result){
                $("#subcategoriesform").trigger('reset');
                $('#updateSubCategory').hide();
                $('#cancelbtnnn').hide();
                $('#saveSubCategory').show().prop('type', 'submit');
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

    $('#updateCategory').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/maincategories",
            method: 'POST',
            data: $("#maincategoriesform").serialize(),
            success: function(result){
                $("#maincategoriesform").trigger('reset');
                $('#updateCategory').hide();
                $('#cancelbtnn').hide();
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

    $('#updateCompany').click(function(){
        var formData = new FormData(document.getElementById("companyform"));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/companies",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result){
                $("#companyform").trigger('reset');
                $('#updateCompany').hide();
                $('#cancelbtn').hide();
                $('#saveCompany').show().prop('type', 'submit');
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

    const LoadMainCategories = (id) => {
        $.ajax({
            url: "/admin/maincategories/"+id,
            method: 'GET',
            success: function(result){
                $('#main_category_id').html('');
                $('#main_category_id').append('<option value="">Select Category</option>');
                $.each(result, function(key, value){
                    $('#main_category_id').append('<option value="'+value.id+'">'+value.main_category_name+'</option>');
                });
            }
        });
    }

    function LoadCompany() {
        $('.accountsTable').DataTable().destroy();
        var table = $('.accountsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/companies",
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'address', name: 'address'},
                    {data: 'contact1', name: 'contact1'},
                    {data: 'description', name: 'description'},
                    {data: 'date_of_registeration', name: 'date_of_registeration'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                autoWidth: false,
                drawCallback: function (params) {
                    // console.log(params.json.data);
                }
        });

        $('.categoryTable').DataTable().destroy();
        var table = $('.categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/maincategories",
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'main_category_name', name: 'main_category_name'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'date', name: 'date'},
                    {data: 'isdisplay', name: 'isdisplay'},
                    {data: 'sequence', name: 'sequence'},
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
            ajax: "/admin/subcategories",
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sub_category_name', name: 'sub_category_name'},
                    {data: 'main_category_name', name: 'main_category_name'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'date', name: 'date'},
                    {data: 'isdisplay', name: 'isdisplay'},
                    {data: 'sequence', name: 'sequence'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                autoWidth: false,
                drawCallback: function (params) {
                    // console.log(params.json.data);
                }
        });

        axios.get("/admin/companies/1")
        .then(res => {
            let options = '<option value="">Choose company</option>';
            for(let i=0; i<res.data.length; i++){
                options += '<option value="' + res.data[i].id + '" >' + res.data[i].company_name + '</option>';
            }
            $("#company_id").html(options);
            $("#company_idd").html(options);
        })

        // axios.get("/admin/maincategories/0")
        // .then(res => {
        //     let options = '<option value="">Choose main category</option>';
        //     for(let i=0; i<res.data.length; i++){
        //         options += '<option value="' + res.data[i].id + '" >' + res.data[i].main_category_name + '</option>';
        //     }
        //     $("#main_category_id").html(options);
        // })
    }
</script>

@endsection