<template>
    <div class="col-md-12">
        <div class="card card-primary collapsed-card">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Expense Heads</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-tool"
                        data-card-widget="collapse"
                        title="Collapse"
                    >
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
                                    <form
                                        id="AddConfigForm"
                                        onsubmit="return false"
                                        method="POST"
                                    >
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-none">
                                                <label
                                                    for="campusid"
                                                    class="form-label"
                                                    ><b>Campus Id</b></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    id="campusid"
                                                    value="0"
                                                    name="campusid"
                                                    placeholder=""
                                                />
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    for="expense_head"
                                                    class="form-label"
                                                    ><b>Head Name</b></label
                                                >
                                                <input
                                                    v-model="item.expense_head"
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    id="expense_head"
                                                    required
                                                    name="expense_head"
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
                                                    v-model="item.expense_desc"
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
                                                <button @click="save" 
                                                class='btn btn-sm btn-block' 
                                                v-bind:class=" isEditing ? 'btn-success' : 'btn-primary'" > {{isEditing ? 'Update' : 'Save'}} </button>
                                            </div>
                                            <!-- <div class="col-md-12">
                                                    <input type="submit" name="submit" id="update"
                                                           class="btn btn-sm btn-success btn-block"
                                                           style="display: none;" value="Update">
                                                    <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn"
                                                           class="btn btn-sm btn-danger btn-block"
                                                           style="display: none;" value="Cancel">
                                                </div> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <table
                                    id=""
                                    class="table table-responsive-sm"
                                    style="width: 100%"
                                >
                                    <thead>
                                        <tr>
                                            <th>Head Name</th>
                                            <th>Description</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        id="CampusData"
                                        v-if="heads.length > 0"
                                    >
                                        <tr v-for="head in heads" :key="head.id">
                                            <td>{{ head.expense_head }}</td>
                                            <td>{{ head.expense_desc }}</td>
                                            <td><i class="fas fa-edit" @click="editHead(head)"  title="Edit"></i></td>
                                        </tr>
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
// var dT = $('#example1').DataTable();
// dT.destroy();
// this.$nextTick(function() {
//    $('#example1').DataTable({
//       // DataTable options here...
//    });
// })
export default {
    name: "Expense Head",
    data() {
        return {
            heads: [],
            item: {
                expense_head: "",
                expense_desc: "",
            },
            temp_id: null,
            isEditing: false,
        };
    },
    methods: {
        fetchHeads() {
            // $("#example1").DataTable().destroy();
            axios
                .get("/admin/expenseheads")
                .then((res) => (this.heads = res.data));
            // $("#example1").DataTable();
        },
        editHead(head){
            this.item = {
                expense_head: head.expense_head,
                expense_desc: head.expense_desc,
            }
            this.temp_id = head.id;
            this.isEditing = true;
        },
        save() {
            let method = axios.post;
            let url = '/admin/expenseheads';
            if(this.isEditing){
                method = axios.put;
                url = `/admin/expenseheads/${this.temp_id}`;
            }
            try {
                method(url, this.item)
                    .then((res) => {
                        // console.log(res);
                        if(this.isEditing && res.data == 'duplicate'){
                            swal("Warning", "Duplicate entry.", "warning");
                        }else{
                            this.item = {
                                expense_head: "",
                                expense_desc: "",
                            };
                            this.fetchHeads();
                            this.temp_id = "";
                            this.isEditing = false;
                            swal("Good Job", "Successfully added.", "success");
                        }
                    })
                    .catch((error) => {
                        for (let key in error.response.data.errors) {
                            // console.log(key, error.response.data.errors[key]);
                            // swal('warning', error.response.data.errors[key], 'warning');
                            // swal(
                            //     "Saved",
                            //     error.response.data.errors[key],
                            //     "success"
                            // );
                            alert(error.response.data.errors[key]);
                        }
                        // console.log(error.response.data.errors);
                    });
            } catch (error) {
                // this.xdataa = error.response;
                console.log(error);
            }
        },
    },
    mounted() {
        // console.log("Component mounted.");
        this.fetchHeads();
        $("#example1").DataTable();
    },
};
</script>
