@extends('admin.admin_master')



@section('Admindata')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Create Accounts</h3>
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
                                    <form id="accountForm" onsubmit="return false" method="POST" >
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-none">
                                                <label for="accountid" class="form-label" ><b>Head Id</b></label >
                                                <input type="number" class="form-control form-control-sm" id="accountid" name="accountid" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="accountname" class="form-label"  ><b>Account Name</b></label>
                                                <input name="accountname" type="text" class="form-control form-control-sm" id="accountname" required placeholder=""/>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="accountnumber" class="form-label" >Account Number</label >
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    id="accountnumber"
                                                    name="accountnumber"
                                                    placeholder=""
                                                />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="account_desc" class="form-label" >Description</label >
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    id="account_desc"
                                                    name="account_desc"
                                                    placeholder=""
                                                />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                    <input type="submit" name="saveAccount" id="saveAccount"
                                                           class="btn btn-sm btn-primary btn-block"
                                                           value="Save">
                                                    <input type="submit" name="updateAccount" id="updateAccount"
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
                                    <table id="accountsTable" class="table table-responsive-sm" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>#.</th>
                                                <th>Account Name</th>
                                                <th>Account Number</th>
                                                <th>Description</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="accountsTableBody" >
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
                <h3 class="card-title">Insert Account Details<Section></Section>
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
                    <form id="accountDetailsForm" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-4" style="display: none">
                                <label for="detailsid" class="form-label"><b>Detail Id</b></label>
                                <input type="number" class="form-control form-control-sm" id="detailsid" value="0"
                                    name="detailsid" placeholder="">
                            </div>
                            <div class="col-md-4">
                                <label for="account_idd" class="form-label"><b>Account</b></label>
                                <select type="text" class="form-control form-control-sm" id="account_idd" required
                                    name="account_idd" placeholder="">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="account_descc" class="form-label"><b>Description</b></label>
                                <input type="text" class="form-control form-control-sm" id="account_descc" required
                                    name="account_descc" placeholder="">
                            </div>
                            <div class="col-md-4">
                                <label for="transactiondate" class="form-label"><b>Transaction Date</b></label>
                                <input type="date" value="{{date('Y-m-d')}}" class="form-control form-control-sm" id="transactiondate" required
                                    name="transactiondate" placeholder="">
                            </div>
                            <div class="col-md-4">
                                    <label for="amount" class="form-label"><b>Amount</b></label>
                                    <input type="number" class="form-control form-control-sm" id="amount"
                                        required name="amount" placeholder="">
                            </div>
                            <div class="col-md-4">
                                <label for="type" class="form-label"><b>Type</b></label>
                                <select type="text" class="form-control form-control-sm" id="type" required
                                    name="type" placeholder="">
                                    <option value="">Option</option>
                                    <option value="Asset">Asset</option>
                                    <option value="Expense">Expense</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center">
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
                    <div class="row">
                        <div class="col-md-12" style="overflow-x:auto;overflow-y:auto;">
                            <hr>
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#.</th>
                                    <th>Account</th>
                                    <th>Description</th>
                                    <th>Transaction Date</th>
                                    <th>Amount</th>
                                    <th>Type</th>
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

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class=" card-header" data-card-widget="collapse">
                <h3 class="card-title">Show Details<Section></Section>
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
                    <form id="searchAccountDetails" onsubmit="return false" method="POST">
                        <div class="row align-items-center ">
                            <div class="col-md-3">
                                <label for="account_iddd" class="form-label"><b>Account</b></label>
                                <select type="text" class="form-control form-control-sm" id="account_iddd"
                                    name="account_iddd" placeholder="">
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
                                <input name="submit" id="insert" class="btn btn-sm btn-primary btn-block" type="submit"
                                    value="Search">
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12" style="overflow-x:auto;overflow-y:auto;">
                            <hr>
                        <table id="searchTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Account Name</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Total</th>

                                </tr>
                            </thead>
                            <tbody id="searchBody">
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('userbackend/plugins/axios/axios.min.js')}}"></script>
<script>
    function ResetFormByCancelKey(){
        $("#accountForm").trigger('reset');
        $('#updateAccount').hide();
        $('#cancelbtn').hide();
        $('#saveAccount').show();
        $('#saveAccount').prop('type', 'submit');

        $("#accountDetailsForm").trigger('reset');
        $('#update').hide();
        $('#cancelbtnn').hide();
        $('#insert').show();
        $('#insert').prop('type', 'submit');
  }

    $("#searchAccountDetails").submit(function(){
        axios.post('/admin/seachAccountDetails', $("#searchAccountDetails").serialize())
        .then(res => {
            
            let data = res.data;
            $("#searchTable").DataTable().destroy();
            let html = "";
            let credit = debit = total = 0;
            for (i=0; i < data.length; ++i) {
                if(data[i].type == 'Asset'){
                    total += data[i].amount;
                    credit += data[i].amount;
                }else{
                    total -= data[i].amount;
                    debit += data[i].amount;
                }
                html = html+'<tr >'+
                    '<td>'+data[i].accountname +'</td>'+
                    '<td>'+data[i].account_desc +'</td>'+
                    '<td>'+data[i].transactiondate +'</td>'+
                    '<td>'+data[i].type +'</td>'+
                    '<td>' + ( data[i].type == 'Asset' ? data[i].amount  : 0 ) + '</td>' +
                    '<td>' + ( data[i].type == 'Expense' ? data[i].amount  : 0 ) + '</td>' +
                    '<td>' +  total + '</td>' +
                    '</tr>';
            }
            html += '<tr class="no-sort"><td><b>Total</b></td><td></td><td></td><td></td><td><b>'+ credit +'</b></td><td><b>'+ debit +'</b></td><td><b>'+ (credit + debit) +'</b></td></tr>';
            $('#searchBody').html(html);
            // $('#searchTable').DataTable();
            $('#searchTable').DataTable( {
                ordering: false,
                // order: [[ 2, "asc" ]],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        }).catch(err => {

        })
    });
    var details = "";
    var accounts = "";
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
          url: "/admin/accountdetails",
          method: 'POST',
          data: $("#accountDetailsForm").serialize(),
          success: function(result){
            $("#accountDetailsForm").trigger('reset');
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

    $('#saveAccount').click(function(){
        axios.post("/admin/accounts", $("#accountForm").serialize())
        .then(res => {
            $("#accountForm").trigger('reset');
            LoadCompany();
            swal("Good job!", "Successfully added!", "success");
        })
      });

    $('#updateAccount').click(function(){
        let id = $("#accountid").val();
        axios.put(`/admin/accounts/${id}`, $("#accountForm").serialize())
        .then(res => {
            if(res.data == 'duplicate'){
                swal("Warning!", "Duplicate entry.", "warning");
                return;
            }
            $("#accountForm").trigger('reset');
            $('#updateAccount').hide();
            $('#cancelbtn').hide();
            $('#saveAccount').show();
            $('#saveAccount').prop('type', 'submit');
            LoadCompany();
            swal("Good job!", "Successfully Updated!", "success");
        }).catch((error) => {
            for (let key in error.response.data.errors) {
                swal('warning', error.response.data.errors[key][0], 'warning');
            }
        });
    });

    $('#update').click(function(){
        let id = $("#detailsid").val();
        axios.put(`/admin/accountdetails/${id}`, $("#accountDetailsForm").serialize())
        .then(res => {
            $("#accountDetailsForm").trigger('reset');
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
        // load expense for
        $.ajax({
            dataType: "json",
            url: "/admin/accounts/1",
            success: function(d)
            {
                accounts = d;
                let html='<option value="">Select Account</option>';
                for (i=0; i < accounts.length; i++) {
                    html=html+'<option  value="' + accounts[i].id + '">' + accounts[i].accountname + '</option>';
                }
                $('#account_idd').html(html);
                $('#account_iddd').html(html);

                $("#accountsTable").DataTable().destroy();
                let expenseheads = "";
                let j = 1;
                for (i=0; i < accounts.length; ++i) {
                    expenseheads=expenseheads+'<tr  ondblclick="EditAccounts('+accounts[i].id+','+ i +')">'+
                        '<td>'+ j +'</td>'+
                        '<td>'+accounts[i].accountname +'</td>'+
                        '<td>'+accounts[i].accountnumber +'</td>'+
                        '<td>'+accounts[i].account_desc +'</td>'+
                        '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditAccounts(' + accounts[i].id+ ',' + i + ')"></i></a></td>'
                        +'</tr>';
                        j++;
                    }
                    $('#accountsTableBody').html(expenseheads);
                    $('#accountsTable').DataTable();
            },
        });

        $.ajax({
        dataType: "json",
        url: "/admin/accountdetails/1",
        success: function(d)
        {
            details = d;
            var j=1;
            var html='';
            $("#example1").DataTable().destroy();
            for (i=0; i < details.length; ++i) {
                html=html+'<tr  ondblclick="EditAccountDetails('+details[i].id+','+ i +')">'+
                '<td>'+ j +'</td>'+
                '<td>'+details[i].accountname +'</td>'+
                '<td>'+details[i].account_desc +'</td>'+
                '<td>'+details[i].transactiondate +'</td>'+
                '<td>'+details[i].amount +'</td>'+
                '<td>'+details[i].type +'</td>'+
                '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit" onclick="EditAccountDetails('+details[i].id+','+ i +')"></i></a></td>'
                +'</tr>';
                    j++;
            }
            $('#CampusData').html(html);
            $('#example1').DataTable();
        },
        error: function(error) {
                $.each(error.responseJSON.errors, function(field_name,errorr){
                    swal('Warning', errorr[0], 'warning');
                    // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                });
            }
        });
    }

    const EditAccounts = (id, index) => {
        $('#saveAccount').hide();
        $('#saveAccount').prop('type', '');
        $('#updateAccount').show();
        $('#cancelbtn').show();

        $('#accountid').val(id);
        $('#accountname').val(accounts[index].accountname);
        $('#accountnumber').val(accounts[index].accountnumber);
        $('#account_desc').val(accounts[index].account_desc);
    }
    function EditAccountDetails(id, index) {
        $('#insert').hide();
        $('#insert').prop('type', '');
        $('#update').show();
        $('#cancelbtnn').show();
        $('#detailsid').val(id);
        $('#account_idd').val(details[index].account_id);
        $('#account_descc').val(details[index].account_desc);
        $('#transactiondate').val(details[index].transactiondate);
        $('#amount').val(details[index].amount);
        $('#type').val(details[index].type);
    }
</script>

@endsection
