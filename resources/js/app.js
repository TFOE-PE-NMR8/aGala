/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

axios.interceptors.request.use(
    function(config) {
        // Do something before request is sent
        config.withCredentials = true;
        return config;
    },
    function(error) {
        // Do something with request error
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(function(response){
    if(response.data){
        if('redirect' in response.data){
            window.location = response.data['redirect'];
        }
    }
    return response;
}, async err => {
    const status = get(err, 'response.status')

    if (status === 419) {
        // Refresh our session token
        await axios.get('/sanctum/csrf-cookie')

        // Return a new request using the original request's configuration
        return axios(err.response.config)
    }

    return Promise.reject(err)
})

const app = createApp({});
app.use(VueAxios, axios);

import ExampleComponent from './components/ExampleComponent.vue';
import RegistrationForm from './components/RegistrationForm.vue';
import RegistrationButton from './components/RegisteredButton.vue';
import RegistrantsTable from "./components/registrants/RegistrantsTable.vue";
import GuestsTable from "./components/guests/GuestsTable.vue";

app.component('example-component', ExampleComponent);
app.component('Datepicker', Datepicker);
app.component('registration-form', RegistrationForm);
app.component('registered-button', RegistrationButton);
app.component('registrants-table', RegistrantsTable)
app.component('guests-table', GuestsTable)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

import moment from 'moment';
app.config.globalProperties.$filters = {
    dateTimeFormat(value) {
        if (value) {
            return moment(value).format('MM/DD/YYYY hh:mm A');
        }
        return value;
    }
}

app.mount('#app');
