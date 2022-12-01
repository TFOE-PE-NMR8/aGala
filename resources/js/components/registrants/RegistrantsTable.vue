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
                            <th scope="col">No. of Tickets</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col">Options</th>
                            <!--                    <th></th>-->
                        </tr>
                        </thead>
                        <tbody v-if="items.length">

                        <tr v-for="(item, i) in items" :key="item.id">
                            <td>{{ item.registration.reference_number }}</td>
                            <td class="text-capitalize">{{ item.title }} {{ item.first_name }} {{ item.last_name}}</td>
                            <td>{{ item.club }}</td>
                            <td>{{ item.phone }}</td>
                            <td>{{ item.registration.quantity }}</td>
                            <td>{{ item.registration.total_amount - item.registration.paid_amount }}</td>
                            <td>{{ $filters.dateTimeFormat(item.registration.updated_at) }}</td>
                            <td>
                                <button
                                    v-show="(item.registration.total_amount - item.registration.paid_amount) > 0"
                                    type="button"
                                    class="btn btn-success btn-sm"
                                    @click="viewPaid(item, i)">
                                    Pay
                                </button>
                            </td>
                            <!--                    <td class="showData">-->
                            <!--                        <i class="fas fa-angle-down"></i>-->
                            <!--                    </td>-->
                        </tr>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <Teleport to="body">
        <!-- use the modal component, pass in the prop -->
        <modal :show="showModal"
               @close="showModal = false"
        >
            <template #header>
                <h5 class="modal-title">Payment for {{ registrant.registration.reference_number }}: {{ registrant.first_name }} {{ registrant.last_name}}</h5>
            </template>
            <template #body>
                <form class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" v-model="data.amount" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Payment Date</label>
                        <Datepicker v-model="data.payment_date" required></Datepicker>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Payment Method</label>
                        <select v-model="data.payment_method" class="form-control">
                            <option value="gcash">GCash</option>
                            <option value="palawan">Palawan</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>
                </form>
            </template>
            <template #footer>
                <button
                    class="btn btn-secondary"
                    @click="showModal = false"
                >Close
                </button>
                <button v-if="!enableButton"
                        class="btn btn-primary ms-2 disabled"  disabled>Save
                </button>
                <button v-if="enableButton"
                    class="btn btn-primary ms-2"
                    @click="savePaidData"
                >Save
                </button>
            </template>
        </modal>
    </Teleport>
</template>

<script>
import $ from 'jquery';

// import PaidModal from './PaidModal';
import Modal from '../Modal'
import Options from "../../../../public/theme/vendor/chart.js/docs/general/options.html";

export default {
    props: {
        url: String,
    },
    components: {
        Options,
        Modal
    },
  computed: {
    enableButton(){
      return this.data.amount > 0 && this.data.payment_date !== "" && !this.disable;
    },
    total_collection(){
        let collection = this.items.reduce((acc, ele) => {
        return acc + parseFloat(ele.registration.paid_amount);
      }, 0);
        return collection ? collection : 0;
    },
    total_collectibles(){
      let collection =  this.items.reduce((acc, ele) => {
            return acc + parseFloat(ele.registration.total_amount);
        }, 0);
      return collection ? collection : 0;
    },
    total_paid_tickets(){
        let tickets =  this.items.reduce((acc, ele) => {
            if(ele.registration.total_amount === ele.registration.paid_amount) {
                return acc + parseInt(ele.registration.quantity);
            }
        }, 0);
      return tickets ? tickets : 0;
    },
    total_tickets(){
      let tickets =  this.items.reduce((acc, ele) => {
            return acc + parseFloat(ele.registration.quantity);
        }, 0);
      return tickets ? tickets : 0;
    },
  },
    data() {
        return {
            items: [],
            registrant: null,
            showModal: false,
            max_amount: 0,
            current_index: 0,
            data: {
                amount: 0,
                payment_date: "",
                payment_method: "gcash",
                registration_id: ""
            },
            disable: false
        }
    },
    async mounted() {
        await this.getRegistrants();
    },
    methods: {
        getRegistrants() {
            axios.get("/api/registrants/datatable", {})
                .then(async response => {
                    this.items = Object.freeze(await response.data.data);
                    this.initDatatable();
                })
                .catch(error => {
                    console.log(error)
                });
        },
        savePaidData() {
            this.disable = true;
            axios.post("/api/registration/pay", this.data)
                .then(async response => {
                    // var temp = this.items[this.current_index];
                    //
                    // temp.registration.amount = temp.registration.amount + response.data.amount;
                    // temp.registration.updated_at = response.data.updated_at;
                    // this.items[this.current_index] = temp;
                    // this.showModal = false;
                    // this.resetData();
                    // this.current_index = 0;
                    await this.getRegistrants();
                    this.showModal = false;
                    this.initDatatable();
                    this.disable = false;
                    this.resetData();
                    this.current_index = 0;
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
        resetData() {
            this.data = {
                amount: 0,
                payment_date: "",
                payment_method: "gcash",
                registration_id: ""
            };
        },
        viewPaid(item, index) {
            this.current_index = index;
            this.registrant = item;
            this.resetData();
            this.data.registration_id = item.registration.id;
            this.max_amount = item.registration.total_amount - item.registration.paid_amount;
            this.showModal = true;
        },
        getDateTimeFormat(value){

        }
    }
}
</script>

<style>
    .dataTables_wrapper {
        margin-top: 25px
    }
</style>
