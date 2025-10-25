require('./bootstrap');
import { createApp } from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Test from './components/Test.vue';
import BatchComponent from './components/BatchComponent.vue';
import CertificateComponent from './components/CertificateComponent.vue';

const app = createApp({});
app.use(VueSweetalert2);
app.component('Test', Test);
app.component('BatchComponent', BatchComponent);
app.component('CertificateComponent', CertificateComponent);
app.mount('#app');
