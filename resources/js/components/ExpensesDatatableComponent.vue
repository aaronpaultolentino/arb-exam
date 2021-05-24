<template>
    <div>
        <button class="btn btn-primary mb-3" @click="showCreateModal">Create Expense</button>
        <div class="col-xs-12 table-responsive">
            <custom-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage"></custom-datatable>
            <custom-datatable-pager v-model="page" type="abbreviated"></custom-datatable-pager>
        </div>
        <expense-modal-component v-show="isModalVisible" :expenseData="expenseData" :modalTitle="modalTitle" :action="action" :expense_categories="this.$props.expense_categories" @close="closeModal" @closeAndRefreshTable="closeAndRefreshTable"></expense-modal-component>
    </div>
</template>

<script>
    export default {
        props: ['expense_categories'],
        data() {
            return {
                columns: [
                    {
                        label: 'Action',
                        field: 'action',
                        interpolate: true
                    },

                    {
                        label: 'Expense Category',
                        field: 'expense_category.name'
                    },

                    {
                        label: 'Amount',
                        field: 'amount'
                    },

                    {
                        label: 'Entry Date',
                        field: 'entry_date'
                    },
                ],
                rows: [],
                page: 1,
                filter:  '',
                perPage: 12,
                isModalVisible: false,
                expenseData: {},
                modalTitle: "",
                action: "",
            }
        },
        methods: {
            showExpenses: function (callback) {
                axios.get('expenses/all').then(function (res) {
                    let data;
                    for(let i in res.data){
                        data = res.data[i];
                        data['action'] = '<a href="#" onClick="window.vueComponent.showUpdateModal(\''+ res.data[i]['id'] +'\')" style="cursor:pointer">Edit</a> | <a href="#"  onClick="window.vueComponent.showDeleteModal(\''+ res.data[i]['id'] +'\')" style="cursor:pointer")>Delete</a>'
                        this.rows.push(data);    
                    }

                    if(typeof callback == 'function'){
                        callback();
                    }
                    // this.rows = res.data;
                }.bind(this));
            },
            showUpdateModal(id) {
                let self = this;
                self.modalTitle = "Update Expense";
                self.action = 'update';
                axios.get('expenses/'+id).then(function (res) {
                    self.isModalVisible = true;
                    self.expenseData = res.data;
                }.bind(this));
                
            },

            showDeleteModal(id) {
                let self = this;
                self.modalTitle = "Delete Expense";
                self.action = 'delete';
                self.expenseData = {
                    'id': id
                }
                this.isModalVisible = true;
                
            },

            showCreateModal() {
                let self = this;
                self.modalTitle = "Create Expense";
                self.action = 'create';
                self.isModalVisible = true;
                self.expenseData = {};
                
            },

            closeModal() {
                this.isModalVisible = false;
            },

            closeAndRefreshTable() {
                let self = this;
                this.rows = [];
                this.showExpenses(function(){
                    self.isModalVisible = false;
                });
                
            }
        },
        created: function () {
            this.showExpenses()
            window.vueComponent = this;
        }
    }

</script>