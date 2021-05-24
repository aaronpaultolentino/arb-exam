<template>
    <div>
        <button class="btn btn-primary mb-3" @click="showCreateModal">Create Role</button>
        <div class="col-xs-12 table-responsive">
            <custom-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage"></custom-datatable>
            <custom-datatable-pager v-model="page" type="abbreviated"></custom-datatable-pager>
        </div>
        <role-modal-component v-show="isModalVisible" :roleData="roleData" :modalTitle="modalTitle" :action="action" @close="closeModal" @closeAndRefreshTable="closeAndRefreshTable"></role-modal-component>
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
                roleData: {},
                modalTitle: "",
                action: "",
            }
        },
        methods: {
            showRoles: function (callback) {
                axios.get('roles/all').then(function (res) {
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
                self.modalTitle = "Update Role";
                self.action = 'update';
                axios.get('roles/'+id).then(function (res) {
                    self.isModalVisible = true;
                    self.roleData = res.data;
                }.bind(this));
                
            },

            showDeleteModal(id) {
                let self = this;
                self.modalTitle = "Delete Role";
                self.action = 'delete';
                self.roleData = {
                    'id': id
                }
                this.isModalVisible = true;
                
            },

            showCreateModal() {
                let self = this;
                self.modalTitle = "Create Role";
                self.action = 'create';
                self.isModalVisible = true;
                self.roleData = {};
                
            },

            closeModal() {
                this.isModalVisible = false;
            },

            closeAndRefreshTable() {
                let self = this;
                this.rows = [];
                this.showRoles(function(){
                    self.isModalVisible = false;
                });
                
            }
        },
        created: function () {
            this.showRoles();
            window.vueComponent = this;
        }
    }

</script>