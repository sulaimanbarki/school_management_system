@extends('admin.admin_master')



@section('Admindata')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Add Stock</h3>
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
                                    <form id="stockform" onsubmit="return false" method="POST">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-none">
                                                <label for="stockid" class="form-label"><b>id</b></label>
                                                <input type="number" class="form-control form-control-sm" id="stockid"
                                                    name="stockid" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="itemcode" class="form-label">Item Code</label>
                                                <input class="form-control form-control-sm"
                                                    onchange="LoadItemDetail(this.value)" name="itemcode" required
                                                    list="datalistOptions" id="itemcode"
                                                    placeholder="Search item by code...">
                                                @php
                                                $item_code = DB::table('items')->where('campusid',
                                                Auth::user()->campusid)->get();
                                                @endphp
                                                <datalist id="datalistOptions">
                                                    @foreach ($item_code as $item)
                                                    <option value="{{$item->itemcode}}">
                                                        @endforeach
                                                </datalist>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="itemname" class="form-label">Name</label>
                                                <input type="text" readonly class="form-control form-control-sm"
                                                    id="itemname" name="itemname" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="purchase_price" name="purchase_price" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sale_price" class="form-label">Sale price</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="sale_price" name="sale_price" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="qty" class="form-label">Quantity</label>
                                                <input type="number" class="form-control form-control-sm" id="qty"
                                                    name="qty" />
                                            </div>


                                            <div class="col-md-4">
                                                <label for="date" class="form-label">Stock In
                                                    Date</label>
                                                <input value="{{ date('Y-m-d') }}" type="date"
                                                    class="form-control form-control-sm" id="date" name="date" />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <input type="submit" name="addstock" id="addstock"
                                                    class="btn btn-sm btn-primary btn-block" value="Save">
                                                <input type="submit" name="updatestock" id="updatestock"
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
                                <div class="col-md-12">
                                    {{-- bootstrap table --}}
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Stock List</h3>
                                        </div>
                                        <div class="card-body">
                                            <table id="stocktable" class="table table-striped stocktable">
                                                <thead>
                                                    <tr>
                                                        <th>#.</th>
                                                        <th>Item Code</th>
                                                        <th>Name</th>
                                                        <th>Purchase Price</th>
                                                        <th>Sale Price</th>
                                                        <th>Quantity</th>
                                                        <th>Stock In Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
    </div>
    {{-- bootstrap modal with edit options --}}
    <div class="modal fade" id="stockmodal" tabindex="-1" role="dialog" aria-labelledby="stockmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockmodal">Edit Stock</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="stockupdateform" onsubmit="return false" method="POST">
                        <div class="row align-items-center">
                            <div class="col-md-4 d-none">
                                <label for="stockidd" class="form-label"><b>id</b></label>
                                <input type="number" class="form-control form-control-sm" id="stockidd"
                                    name="stockid" />
                            </div>
                            <div class="col-md-12">
                                <label for="itemcodee" class="form-label">Item Code</label>
                                <input class="form-control form-control-sm" name="itemcode" required readonly
                                    type="text" id="itemcodee">
                            </div>
                            <div class="col-md-12">
                                <label for="itemnamee" class="form-label">Name</label>
                                <input type="text" readonly class="form-control form-control-sm" id="itemnamee"
                                    name="itemname" />
                            </div>
                            <div class="col-md-12">
                                <label for="purchase_pricee" class="form-label">Purchase Price</label>
                                <input type="number" class="form-control form-control-sm" id="purchase_pricee"
                                    name="purchase_price" />
                            </div>
                            <div class="col-md-12">
                                <label for="sale_pricee" class="form-label">Sale price</label>
                                <input type="number" class="form-control form-control-sm" id="sale_pricee"
                                    name="sale_price" />
                            </div>
                            <div class="col-md-12">
                                <label for="qtyy" class="form-label">Quantity (<span id="oldvalue"></span>)</label>
                                <input type="hidden" name="oldvalue" id="OldValue">
                                <input type="number" class="form-control form-control-sm" id="qtyy" name="qty"
                                    placeholder="if you want to decrase then insert - with quantity" />
                            </div>
                            <div class="col-md-12">
                                <label for="datee" class="form-label">Stock In Date</label>
                                <input value="{{ date('Y-m-d') }}" type="date" class="form-control form-control-sm"
                                    id="datee" name="date" />
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="submit" name="updatestock" id="updatestock"
                                    class="btn btn-sm btn-success btn-block" value="Update">
                            </div>
                        </div>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>










    <script src="{{ asset('userbackend/plugins/axios/axios.min.js')}}"></script>
    <script>
        $('body').on('click', '.deleteTransaction', function () {
        var id = $(this).data('id');
        // ajax delete request jquery
        // swal warning
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this record!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/admin/stocktransactions/" + id,
                    method: 'DELETE',
                    success: function (data) {
                        swal("Poof! Your record has been deleted!", {
                            icon: "success",
                        });
                        $('#stocktable').DataTable().ajax.reload();
                    }
                });
            } else {
                swal("Your record is safe!");
            }
        });
    });

    $('body').on('click', '.editTransaction', function () {
        var id = $(this).data('id');
        $.get("/admin/stocktransactions/" + id +'/edit', function (data) {
            // console.log(data);
            $('#stockidd').val(id);
            $('#itemcodee').val(data[0].itemcode);
            $('#itemnamee').val(data[0].item_name);
            $('#purchase_pricee').val(data[0].purchase_price);
            $('#sale_pricee').val(data[0].sale_price);
            $('#OldValue').val(data[0].qty);
            $('#datee').val(data[0].date);
            
            $("#oldvalue").text(data[0].qty);
            $('#stockmodal').modal('show');
        })
    });
    
    $('#stockupdateform').on('submit', function (e) {
        e.preventDefault();
        var id = $('#stockidd').val();
        var qty = $('#qtyy').val();
        var oldvalue = $('#OldValue').val();
        var date = $('#datee').val();
        var purchase_price = $('#purchase_pricee').val();
        var sale_price = $('#sale_pricee').val();
        var itemcode = $('#itemcodee').val();
        var itemname = $('#itemnamee').val();
        var data = {
            id: id,
            qty: qty,
            oldvalue: oldvalue,
            date: date,
            purchase_price: purchase_price,
            sale_price: sale_price,
            itemcode: itemcode,
            itemname: itemname
        }
        axios.put('/admin/stocktransactions/' + id, data)
            .then(function (response) {
                // console.log(response);
                // OldValue is reset
                $('#OldValue').val('');
                
                $('#stockmodal').modal('hide');
                $('#stocktable').DataTable().ajax.reload();
            })
            .catch(function (error) {
                console.log(error);
            });
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
  }

    $(document).ready(function(){
        LoadCompany();
    })


    $('#addstock').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/stocktransactions",
            method: 'POST',
            data: $("#stockform").serialize(),
            success: function(result){
            $("#stockform").trigger('reset');
            LoadCompany();
            swal("Good job!", "Successfully added!", "success");
            // $("#AddConfigForm").trigger("reset");
            },
            error: function(error) {
                if(error.responseJSON.success == 'Duplicate Entry.'){
                    swal('Warning', error.responseJSON.success, 'warning');
                }else{
                    for (let key in error.response.data.errors) {
                        swal('warning', error.response.data.errors[key][0], 'warning');
                    }
                }
            $.each(error.responseJSON.errors, function(field_name,error){
                swal('Warning', error[0], 'warning');
                // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            });
            }
        });
    });

      function LoadCompany() {
        $('.stocktable').DataTable().destroy();
        var table = $('.stocktable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/stocktransactions",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'itemcode', name: 'itemcode'},
                {data: 'item_name', name: 'item_name'},
                {data: 'purchase_price', name: 'purchase_price'},
                {data: 'sale_price', name: 'sale_price'},
                {data: 'qty', name: 'qty'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            drawCallback: function (params) {
                // console.log(params.json.data);
            }
        });

        // axios.get("/admin/companies/1")
        // .then(res => {
        //     let options = '<option value="">Choose company</option>';
        //     for(let i=0; i<res.data.length; i++){
        //         options += '<option value="' + res.data[i].id + '" >' + res.data[i].company_name + '</option>';
        //     }
        //     $("#company_id").html(options);
        // })
    }

    const LoadItemDetail = (id) => {
        axios.get("/admin/items/" + id)
        .then(res => {
            $('#itemname').val(res.data.item_name);
            $('#purchase_price').val(res.data.purchase_price);
            $('#sale_price').val(res.data.sale_price);
        })
    }
    </script>

    @endsection