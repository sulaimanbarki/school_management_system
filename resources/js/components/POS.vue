<template>
    <div>
        <div
            class="card"
            >
            <div class="row">
                <div class="col-md-3 ml-3">
                    <label for="itemcode" class="form-label"
                        >Select User</label
                    >
                    <select
                        class="form-control form-control-sm"
                        required
                        list="customerlist"
                        placeholder="Search item by code..."
                        v-model="user"
                    >
                        <option
                            v-for="user in users"
                            :value="user.id"
                            :key="user.id"
                        >{{ user.name }}</option>
                    </select>
                </div>
                <div class="col-md-3 ml-3">
                    <label for="itemcode" class="form-label"
                        >Date</label
                    >
                    <input
                        class="form-control form-control-sm"
                        v-model="date"
                        type="date"                        
                    />
                </div>
                <div class="col-md-3 ml-3">
                    <label for="itemcode" class="form-label"
                        >The next bill number will be : {{billno}}</label
                    >
                </div>
            </div>
            <div class="card-body">
                <div class="row" v-show="showhide">
                    <div class="col-md-2">
                        <label for="itemcode" class="form-label"
                            >Item Code</label
                        >
                    </div>
                    <div class="col-md-2">
                        <label for="itemname" class="form-label"
                            >Item Name</label
                        >
                    </div>
                    <div class="col-md-2">
                        <label for="purchase_price" class="form-label"
                            >Purchase Price</label
                        >
                    </div>
                    <div class="col-md-2">
                        <label for="selling_price" class="form-label"
                            >Selling Price</label
                        >
                    </div>
                    <div class="col-md-1">
                        <label for="qty" class="form-label">Quantity</label>
                    </div>
                    <div class="col-md-2">
                        <label for="total" class="form-label">Total</label>
                    </div>
                </div>
                <div class="row mb-2" 
                    v-for="(itemslist, index) in itemslists"
                    :key="itemslist.id">
                    <div class="col-md-2">
                        <input
                            class="form-control form-control-sm"
                            @change="LoadItemDetails($event, index)"
                            name="itemcode"
                            v-model="itemslist.itemcode"
                            required
                            list="datalistOptions"
                            id="itemcode"
                            placeholder="Search item by code..."
                        />
                        <datalist id="datalistOptions">
                            <option
                                v-for="item in items"
                                :value="item.itemcode"
                                :key="item.id"
                            />
                        </datalist>
                    </div>
                    <div class="col-md-2">
                        <input
                            class="form-control form-control-sm"
                            v-bind:value="itemslist.item_name"
                            readonly
                            data-id="item.id"
                            type="text"
                        />
                    </div>
                    <!-- item purchase price -->
                    <div class="col-md-2">
                        <input
                            class="form-control form-control-sm"
                            v-bind:value="itemslist.purchase_price"
                            readonly
                            type="number"
                        />
                    </div>
                    <!-- item sale price -->
                    <div class="col-md-2">
                        <input
                            class="form-control form-control-sm"
                            v-model="itemslist.sale_price"
                            type="number"
                        />
                    </div>
                    <!-- item quantity -->
                    <div class="col-md-1">
                        <input
                            class="form-control form-control-sm"
                            type="number"
                            v-model="itemslist.qty"
                            :change="calculateTotal(index)"
                        />
                    </div>
                    <div class="col-md-2">
                        <input
                            class="form-control form-control-sm"
                            name="qty"
                            type="number"
                            v-model="total"
                            required
                            readonly
                            id="qty"
                            placeholder="Quantity"
                        />
                    </div>
                    <div class="col-md-1">
                        <button @click="deleteRow(index)" class="btn btn-danger btn-sm">
                            <i
                            class="far fa-trash-alt "
                        ></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-show="showhide">
            <div class="col-md-7"></div>
            <div class="col-md-2">
                <label for="total" class="form-label">Paid</label>
                <input
                    class="form-control form-control-sm"
                    name="total"
                    type="number"
                    v-model="paid"
                    required
                    id="total"
                    placeholder="Total"
                />
            </div>
            <div class="col-md-2">
                <label for="total" class="form-label">Net Total</label>
                <input
                    class="form-control form-control-sm"
                    name="total"
                    type="number"
                    v-model="netTotal"
                    required
                    readonly
                    id="total"
                    placeholder="Total"
                />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 text-center">
                <button
                    class="btn btn-primary mr-2"
                    type="button"
                    name="button"
                    @click="addRow"
                >
                    Add Items
                </button>
                <button
                    class="btn btn-primary mr-2"
                    type="button"
                    name="button"
                    @click="saveItems" v-show="showhide"
                >
                    Save Items
                </button>
                <button
                    class="btn btn-success mr-2"
                    type="button"
                    name="button"
                    @click="saveItems" v-show="showhide"
                >
                    Save and Print
                </button>                
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name: "POS",
    data() {
        return {
            itemslists: [],
            total: 0,
            showhide: false,
            netTotal: 0,
            users: "",
            user: "",
            paid: 0,
            billno: 0,
            date: "",
        };
    },
    methods: {
        addRow() {
            this.itemslists.push({
                itemcode: "",
                item_name: "",
                purchase_price: "",
                sale_price: "",
                sale_price: "",
                qty: "",
                stock: "",
            });
            this.showhide = true;
        },
        deleteRow(index) {
            this.itemslists.splice(index, 1);
            if (this.itemslists.length == 0) {
                this.showhide = false;
            }
        },
        loadAllItems() {
            axios.get("/admin/items").then((response) => {
                this.items = response.data.data;
            });
        },
        LoadItemDetails(e, index) {
            // prevent duplication of itemcode
            if (this.itemslists.length > 1) {
                for (let i = 0; i < this.itemslists.length; i++) {
                    if (i != index) {
                        if (
                            this.itemslists[i].itemcode == e.target.value
                        ) {
                            e.target.value = "";
                            return;
                        }
                    }
                }
            }
            const itemcode = e.target.value;
            axios.get("/admin/items/" + itemcode).then((response) => {
                this.itemslists[index].item_name = response.data.item_name;
                this.itemslists[index].itemcode = response.data.itemcode;
                this.itemslists[index].purchase_price = response.data.purchase_price;
                this.itemslists[index].sale_price = response.data.sale_price;
                this.itemslists[index].stock = response.data.qty;
            });
        },
        saveItems(e) {
            // get event innerhtml
            let buttonpressed = e.target.innerHTML;
            this.checkUser();
            buttonpressed = buttonpressed.replace(/\s/g, "");
            for (let i = 0; i < this.itemslists.length; i++) {
                if (
                    this.itemslists[i].itemcode == "" ||
                    this.itemslists[i].purchase_price == "" ||
                    this.itemslists[i].sale_price == "" ||
                    this.itemslists[i].qty == "" ||
                    this.itemslists[i].qty < 1
                ) {
                    swal('Warning', "Please fill all the fields.", 'warning');
                    return;
                }
            }
            // swal confirm to commit this transaction
            swal({
                title: "Are you sure?",
                text: "You want to commit this transaction?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    const formData = {
                        user: this.user,
                        itemslists: this.itemslists,
                        paid: this.paid,
                        date: this.date,
                    };

                    axios.post("/admin/dispatches/", formData).then((response) => {
                        // swal success message
                        if(buttonpressed == "SaveandPrint"){
                            localStorage.setItem("itemslists", JSON.stringify(this.itemslists));
                            window.open("/admin/dispatchesprint", "_blank");
                        }
                        swal('Success', "Items saved successfully", 'success');
                        this.itemslists = [];
                        this.showhide = false;
                        this.getBillNumber();
                        this.paid = 0;
                    });
                }
            });
            
        },
        calculateTotal(index) {
            this.calculateNetTotal();
            // qty should not be greater than stock
            if (this.itemslists[index].qty > this.itemslists[index].stock) {
                this.itemslists[index].qty = this.itemslists[index].stock;
            }
            this.total = this.itemslists[index].sale_price * this.itemslists[index].qty;
        },
        // on sale_price change calculate net total
        calculateNetTotal() {
            this.netTotal = 0;
            for (let i = 0; i < this.itemslists.length; i++) {
                this.netTotal += this.itemslists[i].sale_price * this.itemslists[i].qty;
            }
        },
        // load customers from database and show in customer
        loadUsers() {
            axios.get("/admin/loadUsers").then((response) => {
                this.users = response.data;
            });
        },
        // before every save check if customer is selected  or not
        checkUser() {
            if (this.user == "") {
                swal('Warning', "Please select a customer.", 'warning');
                return false;
            }
            return true;
        },
        // get the next bill number from database
        getBillNumber() {
            axios.get("/admin/getUserBillNumber").then((response) => {
                this.billno = response.data;
            });
        },

    },
    mounted() {
        this.loadAllItems();
        this.loadUsers();
        this.getBillNumber();
    },
};
</script>
