<template>
    <div>
        <button class="btn btn-primary mb-3" @click="showCreateModal">Create User</button>
        <div class="col-xs-12 table-responsive">
            <custom-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage"></custom-datatable>
            <custom-datatable-pager v-model="page" type="abbreviated"></custom-datatable-pager>
        </div>
        <user-modal-component v-show="isModalVisible" :userData="userData" :modalTitle="modalTitle" :action="action" :roles="this.$props.roles" @close="closeModal" @closeAndRefreshTable="closeAndRefreshTable"></user-modal-component>
    </div>
</template>

<script>
    import Modal from './UserModalComponent.vue';

    export default {
        props: ['roles'],
        components: {
          Modal,
        },
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
                        label: 'Email',
                        field: 'email'
                    },
                ],
                rows: [],
                page: 1,
                filter:  '',
                perPage: 12,
                isModalVisible: false,
                userData: {},
                modalTitle: "",
                action: "",
            }
        },
        methods: {
            showUsers: function (callback) {
                axios.get('users/all').then(function (res) {
                    let data;
                    for(let i in res.data){
                        data = res.data[i];
                        data['action'] = '<a href="#" onClick="window.vueComponent.showUpdateModal(\''+ res.data[i]['id'] +'\')" style="cursor:pointer">Edit</a> | <a href="#"  onClick="window.vueComponent.showDeleteModal(\''+ res.data[i]['id'] +'\')" style="cursor:pointer")>Delete</a>'
                        this.rows.push(data);    
                    }

                    if(typeof callback == 'function'){
                        callback();
                    }
                }.bind(this));
            },

            showUpdateModal(id) {
                let self = this;
                self.modalTitle = "Update User";
                self.action = 'update';
                axios.get('users/'+id).then(function (res) {
                    self.isModalVisible = true;
                    self.userData = res.data;
                }.bind(this));
                
            },

            showDeleteModal(id) {
                let self = this;
                self.modalTitle = "Delete User";
                self.action = 'delete';
                self.userData = {
                    'id': id
                }
                this.isModalVisible = true;
                
            },

            showCreateModal() {
                let self = this;
                self.modalTitle = "Create User";
                self.action = 'create';
                self.isModalVisible = true;
                self.userData = {};
                
            },

            closeModal() {
                this.isModalVisible = false;
            },

            closeAndRefreshTable() {
                let self = this;
                this.rows = [];
                this.showUsers(function(){
                    self.isModalVisible = false;
                });
                
            }
        },
        created: function () {
            this.showUsers()
            window.vueComponent = this;
        }
    }

</script>