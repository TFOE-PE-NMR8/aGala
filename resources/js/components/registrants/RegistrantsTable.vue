<template>

    <div className="card" v-show="reg_table">
        <div className="card-body">
            <!-- Table with stripped rows -->
            <table className="table table-striped" id="data-table">
                <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Phone</th>
                      <th scope="col">Email</th>
                      <th scope="col">Club</th>
                      <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody v-if="items.length">

                  <tr  v-for="(item, i) in items" :key="item">
                    <td>{{ i+1 }}</td>
                    <td>{{ item.first_name + item.last_name }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.club }}</td>
                    <td>
                      <button type="button" class="btn btn-primary btn-sm">Details</button>
                      <button type="button" style="margin-left: 4px" class="btn btn-success btn-sm" @click="viewPaid(item.id)">Paid</button>
                    </td>
                  </tr>
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>

    <div className="card" v-show="guest_table">
        <div className="card-body">
            <!-- Table with stripped rows -->
            <table className="table table-striped" id="data-table-guest">
                <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Phone</th>
                      <th scope="col">Email</th>
                      <th scope="col">Club</th>
                      <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody v-if="items.length">

                  <tr  v-for="(item, i) in items" :key="item">
                    <td>{{ i+1 }}</td>
                    <td>{{ item.first_name + item.last_name }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.club }}</td>
                    <td>
                      <button type="button" class="btn btn-primary btn-sm">Details</button>
                      <button type="button" style="margin-left: 4px" class="btn btn-success btn-sm" @click="viewPaid(item.id)">Paid</button>
                    </td>
                  </tr>
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>
   
</template>

<script>
import {DataTable} from "simple-datatables"
import PaidModal from './PaidModal';

export default {
    props: {
        url: String,
    },
    components: {
      PaidModal
    },
    data() {
      return {
        items: [],
        view_paidmodal: false,
        reg_id: '',
        reg_table: true,
        guest_table: false
      }
    },
    mounted() {
        console.log(this.url);
        this.getRegistrants();
    },
    methods: {
        getRegistrants() {
            axios.get("/api/registrants/datatable", {})
                .then(response => {
                    this.items = Object.freeze(response.data.data);
                    this.initTable();

                })
                .catch(error => {
                    console.log(error)
                });
        },
        getGuest() {
            axios.get("/api/registrants/datatable", {})
                .then(response => {
                    this.items = Object.freeze(response.data.data);
                    this.initTable();

                })
                .catch(error => {
                    console.log(error)
                });
        },
        initTable() {
            new DataTable("#data-table");
            new DataTable("#data-table-guest");
        },
        viewPaid(id) {
          this.reg_table = false;
          this.guest_table = true;
          this.getGuest();
        },
    }
}
</script>

<style scoped>

</style>