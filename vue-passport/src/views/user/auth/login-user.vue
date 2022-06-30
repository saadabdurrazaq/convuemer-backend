<template>
  <Nav />
  <Breadcrumbs />
  <div class="body-content">
    <div class="container">
      <div class="sign-in-page" style="margin-bottom: 20px">
        <div class="row">
          <!-- Sign-in -->
          <div class="col-md-6 col-sm-6 sign-in">
            <div class="col-md-12 col-sm-12">
              <h4 class="">Sign in</h4>
              <p class="">Hello, Welcome to your account.</p>
              <div class="social-sign-in outer-top-xs">
                <a href="#" class="facebook-sign-in"
                  ><i class="fa fa-facebook"></i> Sign In with Facebook</a
                >
                <a href="#" class="twitter-sign-in"
                  ><i class="fa fa-twitter"></i> Sign In with Twitter</a
                >
              </div>
              <br />
              <div style="display: none" id="errMsg" class="box no-border errMsg">
                <div class="box-tools">
                  <p class="alert alert-warning alert-dismissible">
                    {{ userField.error }}
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
              <form
                role="form"
                name="loginForm"
                class="register-form outer-top-xs"
                @submit.prevent="login"
              >
                <div class="form-group">
                  <label class="info-title" for="exampleInputEmail1"
                    >Email Address <span>*</span></label
                  >
                  <input
                    type="email"
                    class="form-control unicase-form-control text-input"
                    id="exampleInputEmail1"
                    placeholder="Enter Email Address"
                    name="email"
                    v-model="userField.email"
                    required
                    autocomplete="email"
                    autofocus
                  />
                  <small class="text-danger" v-if="validation.email">
                    {{ validation.email[0] }}
                  </small>
                </div>
                <div class="form-group">
                  <label class="info-title" for="exampleInputPassword1"
                    >Password <span>*</span></label
                  >
                  <input
                    type="password"
                    class="form-control unicase-form-control text-input"
                    id="exampleInputPassword1"
                    placeholder="Password"
                    name="password"
                    v-model="userField.password"
                    required
                    autocomplete="current-password"
                  />
                  <small class="text-danger" v-if="validation.password">
                    {{ validation.password[0] }}
                  </small>
                </div>
                <div class="radio outer-xs">
                  <label>
                    <input
                      type="radio"
                      name="optionsRadios"
                      id="optionsRadios2"
                      value="option2"
                    />Remember me!
                  </label>
                  <a href="#" class="forgot-password pull-right">Forgot your Password?</a>
                </div>
                <button
                  type="submit"
                  @click="submit"
                  class="btn-upper btn btn-primary checkout-page-button"
                >
                  <div id="loadingCircle" style="display: none; right: 5%" class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                  </div>
                  <div id="loginButtonText">Login</div>
                </button>
              </form>
            </div>
          </div>
          <!-- Sign-in -->

          <!-- create a new account -->
          <div class="col-md-6 col-sm-6 create-new-account">
            <div class="col-md-12 col-sm-12" style="margin-bottom: 20px">
              <h4 class="checkout-subtitle">Create a new account</h4>
            </div>

            <form class="register-form outer-top-xs" role="form">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label class="info-title" for="exampleInputEmail2"
                    >Email Address <span>*</span></label
                  >
                  <input
                    type="email"
                    class="form-control unicase-form-control text-input"
                    id="exampleInputEmail2"
                  />
                </div>

                <div class="form-group">
                  <label class="info-title" for="exampleInputEmail1"
                    >Phone Number <span>*</span></label
                  >
                  <input
                    type="email"
                    class="form-control unicase-form-control text-input"
                    id="exampleInputEmail1"
                  />
                </div>

                <div class="form-group">
                  <label class="info-title" for="exampleInputEmail1"
                    >Confirm Password <span>*</span></label
                  >
                  <input
                    type="email"
                    class="form-control unicase-form-control text-input"
                    id="exampleInputEmail1"
                  />
                </div>
              </div>

              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label class="info-title" for="exampleInputEmail1">Name <span>*</span></label>
                  <input
                    type="email"
                    class="form-control unicase-form-control text-input"
                    id="exampleInputEmail1"
                  />
                </div>

                <div class="form-group">
                  <label class="info-title" for="exampleInputEmail1">Password <span>*</span></label>
                  <input
                    type="email"
                    class="form-control unicase-form-control text-input"
                    id="exampleInputEmail1"
                  />
                </div>
              </div>

              <div style="margin-left: 15px; margin-right: 15px" class="form-group">
                <button
                  type="submit"
                  class="
                    form-control
                    unicase-form-control
                    btn-upper btn btn-primary
                    checkout-page-button
                  "
                >
                  Sign Up
                </button>
              </div>
            </form>
          </div>
          <!-- create a new account -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.sigin-in-->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.body-content -->
  <Footer />
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Nav from '../partials/Nav.vue';
import Footer from '../partials/Footer.vue';
import Breadcrumbs from '../partials/Breadcrumbs.vue';
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import '@/assets/frontend/css/loading.css';
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;

export default {
  beforeCreate: function () {
    document.body.className = 'login';
    document.body.classList.remove('login', 'hold-transition', 'sidebar-mini');
    document.body.classList.add('cnt-home');
  },
  components: {
    Nav,
    Footer,
    Breadcrumbs,
  },
  data() {
    return {
      userField: reactive({
        email: '',
        password: '',
        error: '',
      }),
      router: useRouter(),
      validation: ref([]),
    };
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
      prevUrl: 'prevUrl', // <= ini
    }),
  },
  methods: {
    ...mapActions({
      setAuth: 'auth/set',
    }),
    closeMsg() {
      $('#errMsg').hide('slow');
    },
    submit() {
      var a = document.forms['loginForm']['email'].value;
      var b = document.forms['loginForm']['password'].value;
      var emailReg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

      if (emailReg.test(a) && b != '') {
        $('#loadingCircle').show();
        $('#loginButtonText').hide();
      }
    },
    login() {
      //define variable
      let email = this.userField.email;
      let password = this.userField.password;

      //send server with axios
      axios
        .post('api/user/login', {
          email,
          password,
        })
        .then((response) => {
          if (response.data.success) {
            this.setAuth(response.data);

            let searchParams = new URLSearchParams(window.location.search);
            if (searchParams.has('redirect')) {
              return this.router.push({
                path: searchParams.get('redirect'),
              });
            } else {
              //redirect ke halaman dashboard
              return this.router.push({
                name: 'user-home',
              });
            }
          } else {
            $('#loadingCircle').hide();
            $('#loginButtonText').show();
            $('#errMsg').show('fast');
            this.validation.value = response.data.error;
            this.userField.error = response.data.error[0];
            console.log(this.userField.error);
          }
        })
        .catch((error) => {
          //set validation dari error response
          console.log(error);
          this.validation.value = error.response.data;
        });
    },
  },
  mounted() {
    const token = this.user.token;
    const body = document.body;

    let searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has('redirect')) {
      $('#errMsg').show('fast');
      this.userField.error = 'You must login to access the page!';
    }

    //get data user
    axios.defaults.headers.common.Authorization = `Bearer ${token}`;
    axios
      .get('api/user')
      .then((response) => {
        console.log(response.data.name);
        this.userField.value = response.data;

        document.body.classList.add('hold-transition');
        document.body.classList.add('sidebar-mini');

        return this.router.push({
          name: 'user-home',
        });
      })
      .catch((error) => {
        console.log(error.response.data);

        body.classList.remove('login', 'hold-transition', 'sidebar-mini');
        document.body.classList.add('login-page');

        if (error.response.status === 403) {
          this.router.push('/user/login');
        }
        return Promise.reject(error);
      });
  },
};
</script>

<style>
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/main-blue-green.css';
@import '~@/assets/frontend/css/animate.min.css';
@import '~@/assets/frontend/css/blue-green.css';
@import '~@/assets/frontend/css/bootstrap-select.min.css';
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/font-awesome.css';
@import '~@/assets/frontend/css/lightbox.css';
@import '~@/assets/frontend/css/loading.css';
@import '~@/assets/frontend/css/owl.carousel.css';
@import '~@/assets/frontend/css/owl.transitions.css';
@import '~@/assets/frontend/css/rateit.css';
</style>
