import store from './store'
import { createApp } from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router/web-api'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Pagination from 'v-pagination-3';
import VueProgressBar from "@aacassandra/vue3-progressbar";
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueNumberInput from '@chenfengyuan/vue-number-input';

// import adminlte
import 'admin-lte/plugins/fontawesome-free/css/all.min.css' 
import 'admin-lte/plugins/jquery/jquery.min.js'
import '@/assets/js/bootstrap.js';
import 'admin-lte/dist/js/adminlte.min.js' 
import '@/assets/js/bootstrap-switch.js';

const options = {
    color: "#bffaf3",
    failedColor: "red",
    thickness: "5px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300, 
    },
    autoRevert: true,
    location: "top",
    inverse: false, 
};

const app = createApp(App)  
app.use(store)
app.use(vuetify) 
app.use(router)
app.use(VueProgressBar, options)
app.use(CKEditor).mount( /* DOM element */);
axios.defaults.baseURL = 'http://localhost/my-project/laravue';
/*axios.interceptors.request.use(request => {
    console.log(request);
    // Edit request config
    return request;
}, error => {
    console.log(error);
    return Promise.reject(error);
});
axios.interceptors.response.use(response => {
    console.log(response);
    // Edit response config
    return response;
}, error => {
    console.log(error);
    return Promise.reject(error);
});*/
app.use(VueAxios, axios)
app.component('pagination', Pagination); 
app.component(VueNumberInput.name, VueNumberInput);
app.config.globalProperties.$log = console.log; 
app.mount('#app')