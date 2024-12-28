import './bootstrap';
import { createApp } from 'vue';
import CarRental from './components/CarRental.vue';

const app = createApp({});
app.component('car-rental', CarRental);
app.mount('#app');
