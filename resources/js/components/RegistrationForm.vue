<template>
  <form class="row" @submit.prevent="onSubmit">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Please fill-up the following:</h5>

          <!-- Floating Labels Form -->
          <div class="row g-3">
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
                <select v-model="form.title" class="form-select" id="title" aria-label="Title">
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
                <select v-model="form.marital_status" class="form-select" id="marital_status" aria-label="Title">
                  <option value="married" selected>Married</option>
                  <option value="single">Single</option>
                </select>
                <label for="title">Marital Status</label>
              </div>
            </div>
          </div><!-- End floating Labels Form -->

        </div>
      </div>

    </div>
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Your Guest/s:</h5>

          <!-- Floating Labels Form -->
          <div class="row g-3">
            <div class="col-md-4">
              <div class="form-floating">
                <select v-model="guest_no" id="numberOfGuest" class="form-control" @change="addGuest">
                  <option v-for="(n, i) in 10" :key="i" :value="i" :selected="i === 0 ? 'selected' : ''">{{ i }}</option>
                </select>
                <label for="numberOfGuest">Number of Guests</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-0" v-for="(n, i) in guest_no" :key="n">
            <div class="col-md-4">
              <div class="form-floating">
                <select v-model="form.guests[i].relation" :id="'relationship-'+i" class="form-control">
                  <option value="ate" selected="selected">Ate</option>
                  <option value="kuya">Kuya</option>
                  <option value="bunso">Bunso</option>
                  <option value="aspirant">Aspirant</option>
                  <option value="other">Other</option>
                </select>
                <label :for="'relationship-'+i">Relationship</label>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-floating">
                <input v-model="form.guests[i].name"  type="text" class="form-control" :id="'guestName'+i" placeholder="Full Name">
                <label :for="'guestName'+i">Full Name</label>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-12 pt-3 text-center">
              <button type="submit" class="btn btn-primary btn-lg px-xxl-5">Register</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  name: 'RegistrationForm',
  methods: {
    getClubs: async function () {
      await this.axios.get('/api/clubs/all').then((response) => {
        this.clubs = response.data;
      });
    },
    addGuest: function () {
      this.form.guests = [];
      for(let i=0; i< this.guest_no; i++) {
        this.form.guests.push({relation: 'ate', name:''});
      }
    },
    onSubmit(){
      this.axios.post('/registration', this.form).then(response => {
      }).catch(error => {

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
        title: "kuya",
        club: "DFEC",
        marital_status: "married",
        guests: []
      },
      clubs: [],
      guest_no: 0
    }
  },
  async mounted() {
    this.getClubs();
  }
}
</script>
