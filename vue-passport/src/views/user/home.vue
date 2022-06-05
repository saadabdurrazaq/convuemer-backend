<template v-if="isLoggedIn">
  <Nav />
  <div class="body-content outer-top-xs" id="top-banner-and-menu" >
    <div class="container">
      <div class="row">
        <ProfileSidebar />
        <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
          <div class="row">
            <div class="col-md-12">
              <div
                class="card"
                style="
                  background-color: white;
                  margin-top: 20px;
                  margin-bottom: 20px;
                "
              >
                <br />
                <ul class="nav nav-tabs" style="margin-left:10px;">
                  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                  <li><a data-toggle="tab" href="#menu1">Profile</a></li>
                  <li><a data-toggle="tab" href="#menu2">List Addresses</a></li>
                  <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
                </ul>

                <div class="tab-content">
                  <div id="home" class="tab-pane fade in active">
                    <h3>Home</h3>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                  </div>
                  <div id="menu1" class="tab-pane fade">
                    <h3>Profile</h3>
                    <p>
                      Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                      aliquip ex ea commodo consequat.
                    </p>
                  </div>
                  <div id="menu2" class="tab-pane fade">
                    <h3></h3>
                    <ShippingAddresses />
                  </div>
                  <div id="menu3" class="tab-pane fade">
                    <h3>Menu 3</h3>
                    <p>
                      Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
                      dicta sunt explicabo.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </div>
  <Footer />
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import { useRouter } from 'vue-router';
import axios from 'axios';
import ProfileSidebar from './partials/ProfileSidebar.vue';
import Nav from './partials/Nav.vue';
import Footer from './partials/Footer.vue';
import ShippingAddresses from './partials/ShippingAddresses.vue';

export default {
  beforeCreate: function () {
    document.body.className = 'home-user';
  },
  components: {
    Nav,
    ProfileSidebar,
    Footer,
    ShippingAddresses,
  },
  data() {
    return {
      user: '',
    };
  },
  methods: {
    checkAuth() {
      // state token
      const token = localStorage.getItem('token-user');

      const router = useRouter();
      if (!token) {
        return router.push({
          name: 'user-login',
        });
      } 

      //get data user
      axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      axios
        .get('http://localhost/my-project/laravue/api/user')
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error.response.data);
          if (error.response.status === 403) {
            router.push('/user/login');
          }
          return Promise.reject(error);
        });
    },
    logout() {
      const token = localStorage.getItem('token-user');

      //logout
      axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      axios
        .post('http://localhost/my-project/laravue/api/user/logout')
        .then((response) => {
          if (response.data.success) {
            //remove localStorage
            localStorage.removeItem('token');

            //redirect ke halaman login-user
            const router = useRouter();
            return router.push({
              name: 'user-login',
            });
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
  },
  beforeMount() {},
  created() {},
  mounted() {
    this.checkAuth();
  },
};
</script>

<style>
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/main-blue-green.css'; /* header */
@import '~@/assets/frontend/css/blue-green.css'; /* .header-style-1 .header-nav */
@import '~@/assets/frontend/css/animate.min.css';
@import '~@/assets/frontend/css/bootstrap-select.min.css';
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/font-awesome.css';
@import '~@/assets/frontend/css/lightbox.css';
@import '~@/assets/frontend/css/loading.css';
@import '~@/assets/frontend/css/owl.carousel.css';
@import '~@/assets/frontend/css/owl.transitions.css';
@import '~@/assets/frontend/css/rateit.css';
</style>
