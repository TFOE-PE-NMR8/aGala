<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <div class="row">
                            <div class="col-3">
                                Total Collections: <span class="fs-3 ms-2">{{ total_collection.toLocaleString() }}/{{ total_collectibles.toLocaleString() }}</span>
                            </div>
                            <div class="col-3">
                                Total Paid Tickets: <span class="fs-3 ms-2">{{ total_paid_tickets.toLocaleString() }}/{{ total_tickets.toLocaleString() }}</span>
                            </div>
                        </div>
                    </h5>

                    <!-- Table with stripped rows -->
                    <table class="table table-separate table-head-custom dataTable no-footer dtr-inline table-hover mt-4"
                           id="data-table">
                        <thead>
                        <tr>
                            <th scope="col">Reference #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Club</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Agent</th>
                            <th scope="col">Created At</th>
                        </tr>
                        </thead>
                        <tbody v-if="items.length">

                        <tr v-for="(item, i) in items" :key="item.id">
                            <td>{{ item.registration.reference_number }}</td>
                            <td class="text-capitalize">{{ item.registration.registrant.title }} {{ item.registration.registrant.first_name }} {{ item.registration.registrant.last_name}}</td>
                            <td>{{ item.registration.registrant.club }}</td>
                            <td>{{ item.registration.registrant.phone }}</td>
                            <td>{{ item.amount }}</td>
                            <td>{{ item.agent.name }}</td>
                            <td>{{ $filters.dateTimeFormat(item.created_at) }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from 'jquery';
import Modal from '../Modal'

export default {
    props: {
        url: String,
    },
    components: {
        Modal
    },
    computed: {
        total_collection() {
            const collection = this.items.reduce((acc, ele) => {
                const amount = ele.amount ? ele.amount : 0;
                return acc + parseFloat(amount);
            }, 0);
            return collection ? collection : 0;
        },
        total_collectibles(){
            const collection =  this.items.reduce((acc, ele) => {
                const amount = ele.registration.total_amount ? ele.registration.total_amount : 0;
                return acc + parseFloat(amount);
            }, 0);
            return collection ? collection : 0;
        },
        total_paid_tickets(){
            const tickets =  this.items.reduce((acc, ele) => {
                const qty = ele.registration.quantity ? ele.registration.quantity : 0;
                const total_amount = ele.registration.total_amount ? ele.registration.total_amount : 0;
                const paid_amount = ele.amount ? ele.amount : 0;
                if(total_amount === paid_amount) {
                    return acc + parseInt(qty);
                }
                if(paid_amount >= 500){
                    return acc + parseInt(paid_amount / 500)
                }
                return acc;
            }, 0);
            return tickets ? tickets : 0;
        },
        total_tickets(){
            const tickets = this.items.reduce((acc, ele) => {
                const quantity = ele.registration.quantity ? ele.registration.quantity : 0;
                return acc + parseInt(quantity);
            }, 0);
            return tickets ? tickets : 0;
        },
    },
    data() {
        return {
            items: []
        }
    },
    async mounted() {
        await this.getData();
    },
    methods: {
        getData() {
            axios.get("/api/payment-logs/data", {})
                .then(async response => {
                    this.items = Object.freeze(await response.data);
                    this.initDatatable();
                })
                .catch(error => {
                    console.log(error)
                });
        },
        initDatatable() {
            setTimeout(function () {
                $("#data-table").DataTable({
                    destroy: true,
                    responsive: true,
                    dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'p>>",
                    buttons: ['copy', 'csv', 'excel'],
                    lengthMenu: [25, 50, 100, 200],
                    pageLength: 50,
                    paging: true,
                    searching: true,
                    info: true,
                    language: {
                        'lengthMenu': 'Display _MENU_',
                    },
                    sorting: true,
                    ordering: true,
                    order: [[0, 'asc']],
                    autoWidth: false
                });
            }, 1000)
        },
    }
}
</script>

<style>
.dataTables_wrapper {
    margin-top: 25px
}
</style>
