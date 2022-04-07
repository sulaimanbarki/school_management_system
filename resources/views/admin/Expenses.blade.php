@extends('admin.admin_master')



@section('Admindata')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Expense Heads</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse" >
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
                                    <form id="expenseHeadForm" onsubmit="return false" method="POST" >
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-none">
                                                <label for="expense_head_id" class="form-label" ><b>Head Id</b></label >
                                                <input type="number" class="form-control form-control-sm" id="expense_head_id" name="expense_head_id" />
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    for="expense_head"
                                                    class="form-label"
                                                    ><b>Head Name</b></label
                                                >
                                                <input
                                                    name="expense_head"
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    id="expense_head"
                                                    required
                                                    placeholder=""
                                                />
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    for="expense_desc"
                                                    class="form-label"
                                                    >Description</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    id="expense_desc"
                                                    name="expense_desc"
                                                    placeholder=""
                                                />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                    <input type="submit" name="saveHeads" id="saveHeads"
                                                           class="btn btn-sm btn-primary btn-block"
                                                           value="Save">
                                                    <input type="submit" name="updateHead" id="updateHead"
                                                           class="btn btn-sm btn-success btn-block"
                                                           style="display: none;" value="Update Head">
                                                    <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                                                           class="btn btn-sm btn-danger btn-block"
                                                           style="display: none;" value="Cancel">
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="expenseHeadTable" class="table table-responsive-sm" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>#.</th>
                                                <th>Head Name</th>
                                                <th>Description</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="expenseHeadeBody" >
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
            <div class=" card-header" data-card-widget="collapse">
                <h3 class="card-title">Add Expenses<Section></Section>
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
                    <form id="ExpensesForm" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-4" style="display: none">
                                <label for="expenseid" class="form-label"><b>Campus Id</b></label>
                                <input type="number" class="form-control form-control-sm" id="expenseid" value="0"
                                    name="expenseid" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="expense_head_idd" class="form-label"><b>Expense</b></label>
                                <select type="text" class="form-control form-control-sm" id="expense_head_idd" required
                                    name="expense_head_idd" placeholder="">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="expense_desc" class="form-label"><b>Description</b></label>
                                <input type="text" class="form-control form-control-sm" id="expense_descc" required
                                    name="expense_desc" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="expense_date" class="form-label"><b>Date</b></label>
                                <input type="date" value="{{date('Y-m-d')}}" class="form-control form-control-sm" id="expense_date" required
                                    name="expense_date" placeholder="">
                            </div>
                            <div class="col-md-3">
                                    <label for="expense_amount" class="form-label"><b>Amount</b></label>
                                    <input type="number" class="form-control form-control-sm" id="expense_amount"
                                        required name="expense_amount" placeholder="">
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
                                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtnn"
                                    class="btn btn-sm btn-danger btn-block" style="display: none;" value="Cancel">
                            </div>
                        </div>


                    </form>
                    <hr>
                    <form id="searchExpenses" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-3">
                                <label for="expense_head_idd" class="form-label"><b>Expense Head</b></label>
                                <select type="text" class="form-control form-control-sm" id="expense_head_iddd"
                                    name="expense_head_idd" placeholder="">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="fromdate" class="form-label"><b>From Date</b></label>
                                <input type="date" value="{{date('Y-m-d')}}" class="form-control form-control-sm" id="fromdate" required
                                    name="fromdate" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="todate" class="form-label"><b>To Date</b></label>
                                <input type="date" value="{{date('Y-m-d')}}" class="form-control form-control-sm" id="todate" required
                                name="todate" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <label for="" class="form-label"><b>&nbsp;</b></label>
                                <input name="submit" id="insert" class="btn btn-sm btn-success btn-block" type="submit"
                                    value="Search">
                            </div>
                        </div>
                        <br>


                    </form>
                    <div class="row">
                        <div class="col-md-12" style="overflow-x:auto;overflow-y:auto;">
                            <hr>
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Expense</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="CampusData">
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
<script>
    $("#searchExpenses").submit(function(){
        axios.post('/admin/searchExpenses', $("#searchExpenses").serialize())
        .then(res => {
            expenses = res.data;
            var j=1;
            var html='';
            let sum = 0;
            $("#example1").DataTable().destroy();
            for (i=0; i < expenses.length; ++i) {
                sum += expenses[i].expense_amount;
                html=html+'<tr  ondblclick="EditExpenses('+expenses[i].id+','+ i +')">'+
                '<td>'+ j +'</td>'+
                '<td>'+expenses[i].expense_head +'</td>'+
                '<td>'+expenses[i].expense_desc +'</td>'+
                '<td>'+expenses[i].expense_date +'</td>'+
                '<td>'+expenses[i].expense_amount +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditExpenses('+expenses[i].id+','+ i +')"></i></a></td>'
                +'</tr>';
                    j++;
            }
            html += '<tr><td>Total</td><td></td><td></td><td></td><td>' + sum + '</td><td></td></tr>';
            $('#CampusData').html(html);
            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        }).catch(err => {

        })
    });

    function ResetFormByCancelKey(){
        $("#expenseHeadForm").trigger('reset');
        $('#updateHead').hide();
        $('#cancelbtn').hide();
        $('#saveHeads').show();
        $('#saveHeads').prop('type', 'submit');

        $("#ExpensesForm").trigger('reset');
        $('#update').hide();
        $('#cancelbtnn').hide();
        $('#insert').show();
        $('#insert').prop('type', 'submit');
  }

    var expenses = "";
    var heads = "";
    $(document).ready(function(){
        LoadCompany();
    })
    $('#insert').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
          url: "/admin/expenses",
          method: 'POST',
          data: $("#ExpensesForm").serialize(),
          success: function(result){
            $("#ExpensesForm").trigger('reset');
            LoadCompany();
            swal("Good job!", "Successfully added!", "success");
            // $("#AddConfigForm").trigger("reset");
          },
          error: function(error) {
            $.each(error.responseJSON.errors, function(field_name,error){
              swal('Warning', error[0], 'warning');
                // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            });
          }
        });
      });

    $('#saveHeads').click(function(){
        axios.post("/admin/expenseheads", $("#expenseHeadForm").serialize())
        .then(res => {
            $("#expenseHeadForm").trigger('reset');
            LoadCompany();
            swal("Good job!", "Successfully added!", "success");
        })
      });

    $('#updateHead').click(function(){
        let id = $("#expense_head_id").val();
        axios.put(`/admin/expenseheads/${id}`, $("#expenseHeadForm").serialize())
        .then(res => {
            if(res.data == 'duplicate'){
                swal("Warning!", "Duplicate entry.", "warning");
                return;
            }
            $("#expenseHeadForm").trigger('reset');
            $('#updateHead').hide();
            $('#cancelbtn').hide();
            $('#saveHeads').show();
            $('#saveHeads').prop('type', 'submit');
            LoadCompany();
            swal("Good job!", "Successfully added!", "success");
        }).catch((error) => {
            for (let key in error.response.data.errors) {
                swal('warning', error.response.data.errors[key][0], 'warning');
            }
        });
    });

    $('#update').click(function(){
        let id = $("#expenseid").val();
        axios.put(`/admin/expenses/${id}`, $("#ExpensesForm").serialize())
        .then(res => {
            $("#ExpensesForm").trigger('reset');
            $('#update').hide();
            $('#cancelbtnn').hide();
            $('#insert').show();
            $('#insert').prop('type', 'submit');
            LoadCompany();
            swal("Good job!", "Successfully updated!", "success");
        }).catch((error) => {
            for (let key in error.response.data.errors) {
                swal('warning', error.response.data.errors[key][0], 'warning');
            }
        });
    });


      function LoadCompany() {
        $.ajax({
        dataType: "json",
        url: "/admin/expenses/1",
        success: function(d)
        {
            expenses = d;
            var j=1;
            var html='';
            let sum = 0;
            $("#example1").DataTable().destroy();
            for (i=0; i < expenses.length; ++i) {
                sum += expenses[i].expense_amount;
                html=html+'<tr  ondblclick="EditExpenses('+expenses[i].id+','+ i +')">'+
                '<td>'+ j +'</td>'+
                '<td>'+expenses[i].expense_head +'</td>'+
                '<td>'+expenses[i].expense_desc +'</td>'+
                '<td>'+expenses[i].expense_date +'</td>'+
                '<td>'+expenses[i].expense_amount +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditExpenses('+expenses[i].id+','+ i +')"></i></a></td>'
                +'</tr>';
                    j++;
            }
            html += '<tr><td>Total</td><td></td><td></td><td></td><td>' + sum + '</td><td></td></tr>';
            $('#CampusData').html(html);
            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        },
        error: function(error) {
                $.each(error.responseJSON.errors, function(field_name,errorr){
                    swal('Warning', errorr[0], 'warning');
                    // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                });
            }
        });

        // load expense for
        $.ajax({
            dataType: "json",
            url: "/admin/expenseheads",
            success: function(d)
            {
                heads = d;
                let html='<option value="">Select Expense Head</option>';
                for (i=0; i < heads.length; i++) {
                    html=html+'<option  value="' + heads[i].id + '">' + heads[i].expense_head + '</option>';
                }
                $('#expense_head_idd').html(html);
                $('#expense_head_iddd').html(html);
                
                $("#expenseHeadTable").DataTable().destroy();
                let expenseheads = "";
                let j = 1;
                for (i=0; i < heads.length; ++i) {
                    expenseheads=expenseheads+'<tr  ondblclick="EditExpenseHeads('+heads[i].id+','+ i +')">'+
                        '<td>'+ j +'</td>'+
                        '<td>'+heads[i].expense_head +'</td>'+
                        '<td>'+heads[i].expense_desc +'</td>'+
                        '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditExpenseHeads(' + heads[i].id+ ',' + i + ')"></i></a></td>'
                        +'</tr>';
                        j++;
                    }
                    $('#expenseHeadeBody').html(expenseheads);
                    $('#expenseHeadTable').DataTable();
            },
        });
    }
    
    const EditExpenseHeads = (id, index) => {
        $('#saveHeads').hide();
        $('#saveHeads').prop('type', ''); 
        $('#updateHead').show();
        $('#cancelbtn').show();
        
        $('#expense_head_id').val(id);
        $('#expense_head').val(heads[index].expense_head);
        $('#expense_desc').val(heads[index].expense_desc);

    }
    function EditExpenses(id, index) {
        $('#insert').hide();
        $('#insert').prop('type', ''); 
        $('#update').show();
        $('#cancelbtnn').show();
        $('#expenseid').val(id);
        $('#expense_head_idd').val(expenses[index].expense_head_id);
        $('#expense_descc').val(expenses[index].expense_desc);
        $('#expense_date').val(expenses[index].expense_date);
        $('#expense_amount').val(expenses[index].expense_amount);
    }
</script>

@endsection