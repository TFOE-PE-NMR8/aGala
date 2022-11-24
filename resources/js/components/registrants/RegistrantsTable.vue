<template>

   

    <div className="card">
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
                <tbody>

                  <tr v-for="item in items">
                      {{item}}
                  </tr>
               
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        <button @click="TestPay">Pay</button>
        </div>
    </div>


                


</template>

<script>
import {DataTable} from "simple-datatables"

export default {
    props: {
        url: String,
    },
    data() {
        return {
            headers: [
                {
                    text: 'First Name',
                    value: 'first_name',
                    sortable: true,
                },
                {
                    text: 'Last Name',
                    value: 'last_name',
                    sortable: true,
                },
                {
                    text: 'Phone',
                    value: 'phone',
                    // sortable: true,
                },
                {
                    text: 'Email',
                    value: 'email',
                    sortable: true,
                },
                {
                    text: 'Club',
                    value: 'club',
                    sortable: true,
                },
            ],
            items: []
        }
    },
    mounted() {
        console.log(this.url);
        this.getRegistrants();
        this.initTable();
    },
    methods: {
        async TestPay() {
          var pay = await this.axios.post("/api/registration/pay", {
            'registration_id': 2,
            'amount': 500,
            'payment_method': 'gcash'
          });
          console.log(pay);
        },
        getRegistrants() {
            axios.get("/api/registrants/datatable", {})
                .then(response => {
                    this.items = response.data.data
                    console.log(response.data.data)
                })
                .catch(error => {
                    console.log(error)
                });
        },
        initTable() {
            new DataTable("#data-table");
        }
    }
}
</script>

<style scoped>

</style>