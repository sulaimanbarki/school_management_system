<template>
        <div class="col-md-12">
            <div class="card card-primary collapsed-card">
                <div class=" card-header" data-card-widget="collapse">
                    <h3 class="card-title">Expense Heads
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="card-body collapse in" style="display: block;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form id="AddConfigForm" onsubmit="return false" method="POST">
                                            <div class="row align-items-center ">
                                                <div class="col-md-4 d-none">
                                                    <label for="campusid" class="form-label"><b>Campus Id</b></label>
                                                    <input
                                                      type="text"
                                                      class="form-control form-control-sm"
                                                      id="campusid"
                                                      value="0"
                                                      name="campusid"
                                                      placeholder="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="expense_head" class="form-label"><b>Head Name</b></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="expense_head" required
                                                           name="expense_head"
                                                           placeholder="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="expense_desc" class="form-label">Description</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="expense_desc"
                                                           name="expense_desc"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row align-items-center   ">
                                                <div class="col-md-12">
                                                    <input name="submit" id="insert"
                                                           class="btn btn-sm btn-primary btn-block" type="submit"
                                                           value="Save">
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="submit" name="submit" id="update"
                                                           class="btn btn-sm btn-success btn-block"
                                                           style="display: none;" value="Update">
                                                    <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                                                           class="btn btn-sm btn-danger btn-block"
                                                           style="display: none;" value="Cancel">
                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                                <div class="row" style="overflow-x:auto;overflow-y:auto;">
                                    <table id="example1" class="table table-striped" style="">
                                        <thead>
                                        <tr>
                                            <th>Head Name</th>
                                            <th>Description</th>
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
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
