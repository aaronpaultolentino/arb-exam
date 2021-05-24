<template>
    <div>
        <button class="btn btn-primary mb-3" @click="showCreateModal">Create Expense Category</button>
        <div class="col-xs-12 table-responsive">
            <custom-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage"></custom-datatable>
            <custom-datatable-pager v-model="page" type="abbreviated"></custom-datatable-pager>
        </div>

        <expense-category-modal-component v-show="isModalVisible" :expenseCategoryData="expenseCategoryData" :modalTitle="modalTitle" :action="action" @close="closeModal" @closeAndRefreshTable="closeAndRefreshTable"></expense-category-modal-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                columns: [
                    {
                        label: 'Action',
                        field: 'action',
                        interpolate: true
                    },

                    {
                        label: 'Name',
                        field: 'name'
                    },

                    {
                        label: 'Description',
                        field: 'description'
                    },
                ],
                rows: [],
                page: 1,
                filter:  '',
                perPage: 12,
                isModalVisible: false,
                expenseCategoryData: {},
                modalTitle: "",
                action: "",
            }
        },
        methods: {
            showExpenseCategories: function (callback) {
                axios.get('expense_categories/all').then(function (res) {
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
                self.modalTitle = "Update Expense Category";
                self.action = 'update';
                axios.get('expense_categories/'+id).then(function (res) {
                    self.isModalVisible = true;
                    self.expenseCategoryData = res.data;
                }.bind(this));
                
            },

            showDeleteModal(id) {
                let self = this;
                self.modalTitle = "Delete Expense Category";
                self.action = 'delete';
                self.expenseCategoryData = {
                    'id': id
                }
                this.isModalVisible = true;
                
            },

            showCreateModal() {
                let self = this;
                self.modalTitle = "Create Expense Category";
                self.action = 'create';
                self.isModalVisible = true;
                self.expenseCategoryData = {};
                
            },

            closeModal() {
                this.isModalVisible = false;
            },

            closeAndRefreshTable() {
                let self = this;
                this.rows = [];
                this.showExpenseCategories(function(){
                    self.isModalVisible = false;
                });
                
            }
        },
        created: function () {
            this.showExpenseCategories();
            window.vueComponent = this;
        }
    }

</script>