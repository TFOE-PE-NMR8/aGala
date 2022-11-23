<template>

    <div class="pagetitle">
      <h1>List of Registrants</h1>
      
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">

              <!-- Table with stripped rows -->
              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Club</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Registered</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Brandon Jacob</td>
                    <td>DFEC</td>
                    <td>Paid (GCash)</td>
                    <td>2016-05-25</td>
                    <td>
                      <button type="button" class="btn btn-primary btn-sm">Details</button>
                    </td>
                  </tr>
                  
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>


        </div>
      </div>
    </section>

</template>

<script>
export default {
  props: {
    url: String,
  },
  data() {
    return {
      columns: [
        {
          label: 'First Name',
          name: 'first_name',
          orderable: true,
        },
        {
          label: 'Last Name',
          name: 'last_name',
          orderable: true,
        },
        {
          label: 'Phone',
          name: 'phone',
          orderable: true,
        },
        {
          label: 'Email',
          name: 'email',
          orderable: true,
        },
        {
          label: 'Club',
          name: 'club',
          orderable: true,
        },
      ],
    }
  },
  mounted(){
    console.log(this.url);
    this.getRegistrants();
  },
  methods: {
    getRegistrants() {
      axios.get("/api/registrants/datatable", {})
        .then(response => {
          console.log(response.data.data)
        })
        .catch(error => {
            console.log(error)
        });
    }
  }
}
</script>

<style scoped>

</style>