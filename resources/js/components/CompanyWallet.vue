<template>
    <div>
        <div
            class="card"
            >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="company" class="form-label"
                            >Company</label
                        >
                        <select
                            class="form-control form-control-sm"
                            required
                            list="customerlist"
                            placeholder="Search item by code..."
                            v-model="user"
                            id="company"
                        >
                            <option
                                v-for="user in users"
                                :value="user.id"
                                :key="user.id"
                            >{{ user.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="description" class="form-label"
                            >Description</label
                        >
                        <input
                            class="form-control form-control-sm"
                            type="number"
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="amount" class="form-label"
                            >Amount</label
                        >
                        <input
                            class="form-control form-control-sm"
                            type="number"
                            id="amount"
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="date" class="form-label"
                            >Date</label
                        >
                        <input
                            class="form-control form-control-sm"
                            type="date"
                            id="date"
                        />
                    </div>
                </div>
            </div>
        </div>
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
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name: "POS",
    data() {
        return {
            company_wallet: [],
        };
    },
    methods: {
        storeWallet() {
            axios
                .post("/api/company_wallet", {
                    company_id: this.user,
                    description: this.description,
                    amount: this.amount,
                    date: this.date,
                })
                .then(response => {
                    this.loadAllItems();
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.loadAllItems();
        this.loadUsers();
    },
};
</script>
