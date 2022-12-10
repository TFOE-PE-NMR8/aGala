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
                                &nbsp;
                                <button
                                    type="button"
                                    class="btn btn-info btn-sm"
                                    @click="viewAttendance(item, i)">
                                    Attendance
                                </button>
                                <!-- &nbsp;
                                <button
                                    type="button"
                                    class="btn btn-warning btn-sm"
                                    @click="editAndDelete(item, i)">
                                    Edit
                                </button> -->
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

    <Teleport to="body">
        <!-- use the modal component, pass in the prop -->
        <modal :show="showModalAttendance"
               @close="showModalAttendance = false"
        >
            <template #header>
                <button type="button" class="btn btn-primary">Edit</button>
                <button type="button" class="btn btn-success">Pay</button>
            </template>
            <template #body>
                <h5 class="modal-title">Registrant Name: {{ registrant.registration.reference_number }}: {{ registrant.first_name }} {{ registrant.last_name}}</h5>
                <h5 class="modal-title">Total Amount: ₱ {{ registrant.registration.total_amount }}</h5>
                <h5 class="modal-title">Paid Amount: ₱ {{ registrant.registration.paid_amount }}</h5>
                <h5 class="modal-title">Balance Amount: ₱ {{ balance }}.00</h5>
                <table class="table table-separate table-head-custom dataTable no-footer dtr-inline table-hover mt-4"
                        id="data-table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Relation</th>
                        <th scope="col">Action</th>
                        <!--                    <th></th>-->
                    </tr>
                    </thead>
                    <tbody v-if="guests.length">

                        <tr v-for="(guest, i) in guests" :key="guest.id">
                            <td class="text-capitalize">
                                
                                <div v-if="guest.name">
                                    {{ guest.name }}
                                </div>
                                <div v-else>
                                    {{ guest.first_name }} {{ guest.last_name }}
                                </div>
                            </td>
                            <td>
                                <div v-if="guest.name">
                                    Guest
                                </div>
                                <div v-else>
                                    Registrant
                                </div>
                            </td>
                            <td>
                                <div v-if="guest.name">
                                    {{ guest.relation  }}
                                </div>
                                <div v-else>
                                    N/A
                                </div>
                            </td>
                            <td>
                                <div v-if="(i+1 <= countNotYetPaid)"> 
                                    <button
                                        v-if="(guest.is_attend != 'Attend')"
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        @click="attendance(guest, i, passItem)">
                                        Attend
                                    </button>
                                    <button
                                        v-else
                                        type="button"
                                        class="btn btn-success btn-sm">
                                        Attended
                                    </button>
                                </div>
                                <div v-else>
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm">
                                        Not Yet Paid
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template #footer>
                <button
                    class="btn btn-secondary"
                    @click="showModalAttendance = false"
                >Close
                </button>
                <!-- <button v-if="!enableButton"
                        class="btn btn-primary ms-2 disabled"  disabled>Save
                </button>
                <button v-if="enableButton"
                    class="btn btn-primary ms-2"
                    @click="savePaidData"
                >Save
                </button> -->
            </template>
        </modal>
    </Teleport>

    <!-- <Teleport to="body">
        <modal :show="showModalEditDelete"
               @close="showModalEditDelete = false"
        >
            <template #header>
            </template>
            <template #body>
                <h5 class="modal-title">Registrant Name: {{ registrant.registration.reference_number }}: {{ registrant.first_name }} {{ registrant.last_name}}</h5>
                <form>
                    <table class="table table-separate table-head-custom dataTable no-footer dtr-inline table-hover mt-4"
                        id="data-table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody v-if="guestAndRegistrants.length">

                        <tr v-for="(guestAndRegistrant, index) in guestAndRegistrants" :key="guestAndRegistrant.id">
                            <td class="text-capitalize">
                                <div v-if="guestAndRegistrant.name">
                                    <input type="text" class="form-control" v-bind:value="guestAndRegistrant.id"  required>
                                    <input type="text" class="form-control" v-model="dataForm.guestName[index]" required v-bind:placeholder="guestAndRegistrant.name" style="width:60%">
                                </div>
                                <div v-else style="display: flex;">
                                    <input type="text" class="form-control" v-model="dataForm.registrant_id" required>
                                    <input type="text" class="form-control" v-model="dataForm.first_name" required v-bind:placeholder="guestAndRegistrant.first_name" style="width:50%;">&nbsp;&nbsp; <input type="text" class="form-control" v-model="dataForm.last_name" v-bind:placeholder="guestAndRegistrant.last_name" style="width:50%;">
                                </div>
                            </td>
                            <td>
                                {{index}}
                            </td>
                        </tr>
                    </tbody>
                </table>

                </form>
            </template>
            <template #footer>
                <button
                    class="btn btn-secondary"
                    @click="showModalEditDelete = false"
                >Close
                </button>
                <button 
                    class="btn btn-primary ms-2"
                    @click="saveChanges"
                >Save
                </button>
            </template>
        </modal>
    </Teleport> -->
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
    total_collection() {
      const collection = this.items.reduce((acc, ele) => {
        const amount = ele.registration.paid_amount ? ele.registration.paid_amount : 0;
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
          const paid_amount = ele.registration.paid_amount ? ele.registration.paid_amount : 0;
          if(total_amount === paid_amount) {
              return acc + parseInt(qty);
          }
          if(paid_amount >= 500){
            return acc + (paid_amount / 500)
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
            items: [],
            passItem: [],
            passItemEdit: [],
            registrant: null,
            registrantEdit: null,
            guests: [],
            guestAndRegistrants: [],
            showModal: false,
            showModalAttendance: false,
            // showModalEditDelete: false,
            max_amount: 0,
            current_index: 0,
            data: {
                amount: 0,
                payment_date: "",
                payment_method: "gcash",
                registration_id: ""
            },
            dataForm: {
                first_name: "",
                last_name: "",
                registrant_id: "",
                guestId: [],
                guestName: [],
            },
            disable: false,
            countNotYetPaid: null,
            balance: null, 
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

        },
        viewAttendance(item) {
            // console.log(item.registration.reference_number);
            this.guests = [];

            axios.post("/api/registration/registrant_guest/", {qr_code: item.registration.reference_number,
                item: item,
                })
                .then(async response => {
                    this.guests = response.data;
                })
                .catch(error => {
                    console.log(error)
                });

            console.log(this.guests);   
            this.passItem = item;
            this.registrant = item;
            this.balance = item.registration.total_amount - item.registration.paid_amount;
            this.countNotYetPaid = item.registration.paid_amount / 500;
            this.resetData();
            this.data.registration_id = item.registration.id;
            this.max_amount = item.registration.total_amount - item.registration.paid_amount;
            this.showModalAttendance = true;
        },
        attendance(guest, i, passItem) {
           
            axios.post("/api/registration/attendance", guest)
                .then(async response => {
                    this.showModalAttendance = true;
                    // console.log(passItem);
                    // await this.getRegistrants();
                    this.viewAttendance(passItem);
                })
                .catch(error => {
                    console.log(error)
                });
        },
        // editAndDelete(item, index) {
        //     this.guestAndRegistrants = [];
            
        //     axios.post("/api/registration/registrant_guest/", {qr_code: item.registration.reference_number,
        //         item: item,
        //         })
        //         .then(async response => {
        //             // console.log(response.data);
        //             this.guestAndRegistrants = response.data;
        //             console.log(this.guestAndRegistrants);
        //         })
        //         .catch(error => {
        //             console.log(error)
        //         });
            
        //     this.passItem = item;
        //     this.registrant = item;
        //     this.balance = item.registration.total_amount - item.registration.paid_amount;
        //     this.countNotYetPaid = item.registration.paid_amount / 500;
        //     // console.log(item.registration.reference_number);

        //     this.showModalEditDelete = true;
        // },
        // saveChanges () {
        //     console.log(this.dataForm);
        // },

    }
}
</script>

<style>
    .dataTables_wrapper {
        margin-top: 25px
    }
</style>
