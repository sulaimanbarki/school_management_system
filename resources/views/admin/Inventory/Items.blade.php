@extends('admin.admin_master')



@section('Admindata')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Items</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form id="itemform" onsubmit="return false" method="POST">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-none">
                                                <label for="itemid" class="form-label"><b>Head Id</b></label>
                                                <input type="number" class="form-control form-control-sm" id="itemid"
                                                    name="itemid" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="itemcode" class="form-label"><b>Item Code</b></label>
                                                <input name="itemcode" type="text" class="form-control form-control-sm"
                                                    id="itemcode" required placeholder="" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="item_name" class="form-label">Item Name</label>
                                                <input type="text" required class="form-control form-control-sm"
                                                    id="item_name" name="item_name" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="company_idd" class="form-label"><b>Company</b></label>
                                                <select type="text" onchange="LoadMainCategories(this.value)"
                                                    class="form-control form-control-sm" id="company_idd" required
                                                    name="company_id" placeholder="">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="main_category_id" class="form-label"><b>Main
                                                        Category</b></label>
                                                <select type="text" onchange="LoadSubCategories(this.value)"
                                                    class="form-control form-control-sm" id="main_category_id" required
                                                    name="main_category_id" placeholder="">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sub_category_id" class="form-label"><b>Category
                                                        Name</b></label>
                                                <select type="text" class="form-control form-control-sm"
                                                    id="sub_category_id" required name="sub_category_id" placeholder="">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="unit" class="form-label"><b>Unit</b></label>
                                                <select type="text" class="form-control form-control-sm" id="units"
                                                    required name="unit" placeholder="">
                                                    <option value="No.">No.</option>
                                                    <option value="Kg" selected>Kg</option>
                                                    <option value="Bowl">Bowl</option>
                                                    <option value="Ltr">Ltr</option>
                                                    <option value="Bottle">Bottle</option>
                                                    <option value="ml">ml</option>
                                                    <option value="Gram">Gram</option>
                                                    <option value="Pkt">Pkt</option>
                                                    <option value="Plate">Plate</option>
                                                    <option value="Cup">Cup</option>
                                                    <option value="Piece">Piece</option>
                                                    <option value="Box">Box</option>
                                                    <option value="Bundle">Bundle</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                                <input type="number" required class="form-control form-control-sm"
                                                    id="purchase_price" name="purchase_price" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sale_price" class="form-label">Sale Price</label>
                                                <input type="number" required class="form-control form-control-sm"
                                                    id="sale_price" name="sale_price" />
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <label for="qty" class="form-label">Quantity</label>
                                                <input type="number" required value="0"
                                                    class="form-control form-control-sm" id="qty" name="qty" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="isdisplay" class="form-label"><b>Is
                                                        Display</b></label>
                                                <select class=" form-control form-control-sm" required name="isdisplay"
                                                    id="isdisplay">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sequence" class="form-label">Sequence</label>
                                                <input type="number" required min="1" max="20"
                                                    class="form-control form-control-sm" id="sequence"
                                                    name="sequence" />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <input type="submit" name="saveitem" id="saveitem"
                                                    class="btn btn-sm btn-primary btn-block" value="Save">
                                                <input type="submit" name="updateitem" id="updateitem"
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
                                    <table id="itemstable" class="table table-responsive-sm itemstable">
                                        <thead>
                                            <tr>
                                                <th>#.</th>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Category</th>
                                                <th>Sub Cat.</th>
                                                <th>Unit</th>
                                                <th>PP.</th>
                                                <th>SP.</th>
                                                {{-- <th>Qty</th> --}}
                                                <th>Is Display</th>
                                                <th>Sequence</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemstableBody">
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
    // sale price must be greater than purchase price
    $('#sale_price').on('change', function () {
        var purchase_price = $('#purchase_price').val();
        var sale_price = $('#sale_price').val();
        if (sale_price < purchase_price) {
            $('#sale_price').val('');
            swal('Warning!', 'Sale Price must be greater than Purchase Price', 'warning')
            .then((value) => {
                $('#sale_price').focus();
            });
        }
    });

    // on input change case and remove spaces jquery
    $(document).ready(function() {
        $('#itemcode').on('input', function() {
            this.value = this.value.toUpperCase();
        });
        $('#itemcode').on('input', function() {
            this.value = this.value.replace(/\s/g, '');
        });
    });
    

    $('body').on('click', '.editItem', function () {
        var id = $(this).data('id');
        $.get("/admin/items/" + id +'/edit', function (data) {
            $('#itemid').val(id);
            $('#itemcode').val(data.itemcode);
            $('#item_name').val(data.item_name);
            $('#company_id').val(data.company_id);
            $('#main_category_id').empty();
            $('#sub_category_id').empty();
            $('#unit').val(data.unit);
            $('#purchase_price').val(data.purchase_price);
            $('#sale_price').val(data.sale_price);
            // $('#qty').val(data.qty);
            $('#isdisplay').val(data.isdisplay);
            $('#sequence').val(data.sequence);

            $('#saveitem').hide().prop('type', '');
            $('#updateitem').show();
            $('#cancelbtn').show();
        })
    });

    function ResetFormByCancelKey(){
        $("#itemform").trigger('reset');
        $('#updateitem').hide();
        $('#cancelbtn').hide();
        $('#saveitem').show().prop('type', 'submit');
        $('#main_category_id').empty();
        $('#sub_category_id').empty();
    }
    
    $(document).ready(function(){
        LoadCompany();
    })


    $('#saveitem').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/items",
            method: 'POST',
            data: $("#itemform").serialize(),
            success: function(result){
            $("#itemform").trigger('reset');
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

    $('#updateitem').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/items",
            method: 'POST',
            data: $("#itemform").serialize(),
            success: function(result){
                $("#itemform").trigger('reset');
                $('#updateitem').hide();
                $('#cancelbtn').hide();
                $('#saveitem').show().prop('type', 'submit');
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

    const LoadSubCategories = (id) => {
        $.ajax({
            url: "/admin/subcategories/"+id,
            method: 'GET',
            success: function(result){
                $('#sub_category_id').html('');
                $('#sub_category_id').append('<option value="">Select Sub Category</option>');
                $.each(result, function(key, value){
                    $('#sub_category_id').append('<option value="'+value.id+'">'+value.sub_category_name+'</option>');
                });
            }
        });
    }

    function LoadCompany() {
        $('.itemstable').DataTable().destroy();
        var table = $('.itemstable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/items",
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'itemcode', name: 'itemcode'},
                    {data: 'item_name', name: 'item_name'},
                    {data: 'company', name: 'company'},
                    {data: 'maincategory', name: 'maincategory'},
                    {data: 'subcategory', name: 'subcategory'},
                    {data: 'unit', name: 'unit'},
                    {data: 'purchase_price', name: 'purchase_price'},
                    {data: 'sale_price', name: 'sale_price'},
                    // {data: 'qty', name: 'qty'},
                    {data: 'isdisplay', name: 'isdisplay'},
                    {data: 'sequence', name: 'sequence'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                autoWidth: false,
                drawCallback: function (params) {
                    console.log(params.json.data);
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
    }
</script>

@endsection