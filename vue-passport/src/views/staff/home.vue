<template>
  <div class="wrapper">
    <Nav />
    <Sidebar />
    <div class="content-wrapper">
      <div class="content-header">
        <div class="content">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <!-- warning -->
                <div v-show="role" id="errMsg" class="box no-border errMsg">
                  <div class="box-tools">
                    <p class="alert alert-warning alert-dismissible">
                      But unfortunately you are not super user. So, you can't perform any actions for some reasons. You can only view the contents, no more than that. 
                      Sorry for your inconvenience!
                      <button
                        type="button"
                        @click.prevent="closeMsg"
                        class="close"
                        data-hide="alert"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </p>
                  </div>
                </div>
                <!-- end warning -->
                <div class="card">
                  <div class="card-header">Dashboard</div>
                  <div class="card-body">
                    Welcome to ConVuemer,  <strong>{{ staffData.data.name }}</strong>
                    <br />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import { useRouter } from 'vue-router';
import Nav from './partials/Nav.vue';
import Sidebar from './partials/Sidebar.vue';
import Footer from './partials/Footer.vue';
//import axios from 'axios';
import { Form } from 'vform';

export default {
  beforeCreate: function () {
    document.body.className = 'home-staff';
  },
  components: {
    Nav,
    Sidebar,
    Footer,
  },
  data() {
    return {
      staffData: '',
      form: new Form({
        name: '',
        url: '',
      }),
      role: false,
    };
  },
  methods: {
    checkAuth() {
      // state token
      const token = localStorage.getItem('token-staff');
      let staffData = JSON.parse(localStorage.getItem('staff-data'));
      this.staffData = staffData;

      //inisialisasi vue router on Composition API
      const router = useRouter();
      if (!token) {
        return router.push({
          name: 'staff-login',
        });
      } else {
        this.checkRoles();
      }
    },
    checkRoles() {
      const token = localStorage.getItem('token-staff');
      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/get-role/user')
        .then((response) => {
          let responseData = response.data;
          if (responseData.data[0] !== 'Super User') {
            this.role = true;
          }
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          //
        });
    }
  },
  created() {
    this.checkAuth();
  },
  mounted() {},
};
</script>

<style lang="scss" scoped>
@import '~admin-lte/dist/css/adminlte.min.css';
</style>
