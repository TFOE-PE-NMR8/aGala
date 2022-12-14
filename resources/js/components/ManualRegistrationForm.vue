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
                <input v-model="form.email" type="email" class="form-control" id="email" placeholder="Your Email">
                <label for="email">Your Email</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input v-model="form.phone" type="tel" class="form-control" id="phone" placeholder="Mobile #" v-mask="'09#########'">
                <label for="phone">Mobile #</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <select v-model="form.club" class="form-select" id="club" aria-label="Club" @change="changeClub">
                  <option v-for="(club) in clubs" :value="club.code">{{ club.name }}</option>
                  <option value="other">Other</option>
                </select>
                <label for="club">Club</label>
              </div>
            </div>
            <div class="col-md-12" v-if="form.club === 'other'">
              <div class="form-floating">
                <input v-model="form.other_club" type="text" class="form-control" id="other_club" placeholder="Club Name" required>
                <label for="phone">Club Name</label>
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
                  <option value="widow">Widow</option>
                  <option value="widower">Widower</option>
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
                <input v-model="form.guests[i].name"  type="text" class="form-control" :id="'guestName'+i" placeholder="Full Name" required>
                <label :for="'guestName'+i">Full Name</label>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="mt-3">
            <div class="form-check form-switch">
              <input v-model="form.paying" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
              <label class="form-check-label" for="flexSwitchCheckDefault">Paying</label>
            </div>
          </div>
          <h5 v-if="form.paying" class="card-title mb-2">Payment</h5>
          <div v-if="form.paying" class="row g-3">
            <div class="col-12">
              <label class="form-label">Amount</label>
              <input type="number" class="form-control" v-model="form.payment.amount" required>
            </div>
            <div class="col-12">
              <label class="form-label">Payment Date</label>
              <Datepicker v-model="form.payment.payment_date" required></Datepicker>
            </div>
            <div class="col-12">
              <label class="form-label">Payment Method</label>
              <select v-model="form.payment.payment_method" class="form-control">
                <option value="gcash">GCash</option>
                <option value="palawan">Palawan</option>
                <option value="manual">Manual</option>
              </select>
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
              <div class="form-check form-switch mb-3" style="width: 120px; margin:auto">
                <input v-model="form.attending" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault2">
                <label class="form-check-label" for="flexSwitchCheckDefault2">Attending</label>
              </div>
              <button v-if="!submitting" type="submit" class="btn btn-primary btn-lg px-xxl-5 px-5">Register</button>
              <button v-if="submitting" type="button" class="btn btn-primary disabled btn-lg px-xxl-3 px-3" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Registering...
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import {mask} from 'vue-the-mask';
import moment from 'moment';
export default {
  name: 'RegistrationForm',
  directives: {mask},
  methods: {
    getClubs: async function () {
      await this.axios.get('/api/clubs/all').then((response) => {
        this.clubs = response.data;
      });
    },
    changeClub: function(){

    },
    addGuest: function () {

      this.form.payment.amount = (1 + this.guest_no) * 500;

      this.form.guests = [];
      for(let i=0; i< this.guest_no; i++) {
        this.form.guests.push({relation: 'ate', name:''});
      }
    },
    onSubmit(){

      if(this.submitting){
        return
      }

      this.submitting = true;

      this.axios.post('/registration/manual', this.form).then(response => {

      }).catch(error => {
        this.submitting = false;
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
        guests: [],
        other_club: '',
        paying: true,
        attending: true,
        payment: {
          amount: 500,
          payment_date: moment().format(),
          payment_method: 'manual'
        }
      },
      clubs: [],
      guest_no: 0,
      submitting: false
    }
  },
  async mounted() {
    this.getClubs();
  }
}
</script>
