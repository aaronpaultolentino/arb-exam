<template>
    <div>
        <div class="col-xs-12 table-responsive">
            <custom-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage"></custom-datatable>
            <custom-datatable-pager v-model="page" type="abbreviated"></custom-datatable-pager>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                columns: [
                    {
                        label: 'Date Ping',
                        field: 'created_at'
                    },

                    {
                        label: 'Date',
                        field: 'date'
                    },

                    {
                        label: 'Time',
                        field: 'time'
                    },

                    {
                        label: 'Server response',
                        field: 'full_response'
                    },
                ],
                rows: [],
                page: 1,
                filter:  '',
                perPage: 12,
            }
        },
        methods: {
            showPings: function () {
                axios.get('/api/v1/ping-list').then(function (res) {
                    this.rows = res.data;
                }.bind(this));
            },
            ping: function (){
                axios.get('/api/v1/ping').then(function (res) {
                    this.showPings();
                }.bind(this))
                .catch(function (error) {
                    alert('Something went wrong. This may be a connection issue to a server. Please contact your administrator');
                });;
            }
        },
        created: function () {
            // this.showPings()
        }
    }

</script>