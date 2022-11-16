<template>
  <div class="row">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Please fill-up the following:</h5>

          <!-- Floating Labels Form -->
          <form class="row g-3">
            <div class="col-md-6">
              <div class="form-floating">
                <input v-model="form.first_name" type="text" class="form-control" id="first_name" placeholder="First Name" required>
                <label for="first_name">First Name</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input v-model="form.last_name" type="text" class="form-control" id="last_name" placeholder="Last Name" required>
                <label for="last_name">Last Name</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input v-model="form.email" type="email" class="form-control" id="email" placeholder="Your Email" required>
                <label for="email">Your Email</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input v-model="form.phone" type="text" class="form-control" id="phone" placeholder="Mobile #" required>
                <label for="phone">Mobile #</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <select v-model="form.club" class="form-select" id="club" aria-label="Club">
                  <option v-for="(club) in clubs" :value="club.code">{{ club.name }}</option>
                </select>
                <label for="club">Club</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating mb-3">
                <select class="form-select" id="title" aria-label="Title">
                  <option value="kuya" selected>Kuya</option>
                  <option value="ate">Ate</option>
                  <option value="bunso">Bunso</option>
                  <option value="aspirant">Aspirant</option>
                </select>
                <label for="title">Title</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <select class="form-select" id="marital_status" aria-label="Title">
                  <option value="married" selected>Married</option>
                  <option value="single">Single</option>
                </select>
                <label for="title">Marital Status</label>
              </div>
            </div>
          </form><!-- End floating Labels Form -->

        </div>
      </div>

    </div>
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Please fill-up the following for your guest/s:</h5>

          <!-- Floating Labels Form -->
          <form class="row g-3">
            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Relation</label>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Full Name</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Relation</label>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Full Name</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Relation</label>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Full Name</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Relation</label>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                <label for="floatingName">Full Name</label>
              </div>
            </div>

          </form><!-- End floating Labels Form -->

        </div>
      </div>

    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-12 pt-3 text-center">
              <button type="button" class="btn btn-primary btn-lg px-lg-5">Register</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RegistrationForm',
  components: {},
  methods: {
    getClubs: async function () {
      await this.axios.get('/api/clubs/all').then((response) => {
        this.clubs = response.data;
      });
    }
  },
  data(){
    return{
      form: {
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
        title: "",
        club: "DFEC",
        marital_status: ""
      },
      clubs: []
    }
  },
  async mounted() {
    this.getClubs();
  }
}
</script>