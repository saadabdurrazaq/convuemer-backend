<template>
  <Nav />
  <Breadcrumbs />
  <div class="body-content">
    <div class="container">
      <div class="row">
        <ProfileSidebar />
        <div class="col-md-4">
          <form
            role="form"
            name="loginForm"
            class="register-form outer-top-xs"
            @submit.prevent="updatePassword()"
          >
            <div v-if="loadingForm" style="position: absolute; top: 20%; left: 40%">
              <div class="lds-facebook">
                <div></div>
                <div></div>
                <div></div>
              </div>
            </div>
            <div class="form-group">
              <label class="info-title" for="exampleInputEmail1"
                >Current Password <span>*</span></label
              >
              <input
                v-model="form.current_password"
                type="password"
                class="form-control unicase-form-control text-input"
                placeholder="Enter Current Password"
                name="current_password"
                required
                autocomplete="current_password"
                autofocus
                :class="{ 'is-invalid': form.errors.has('current_password') }"
              />
              <div
                style="color: red"
                v-if="form.errors.has('current_password')"
                v-html="form.errors.get('current_password')"
              />
            </div>
            <div class="form-group">
              <label class="info-title" for="exampleInputPassword1"
                >New Password <span>*</span></label
              >
              <input
                v-model="form.new_password"
                type="password"
                class="form-control unicase-form-control text-input"
                placeholder="New Password"
                name="new_password"
                required
                autocomplete="new_password"
                :class="{ 'is-invalid': form.errors.has('new_password') }"
              />
              <div
                style="color: red"
                v-if="form.errors.has('new_password')"
                v-html="form.errors.get('new_password')"
              />
            </div>
            <div class="form-group">
              <label class="info-title" for="exampleInputPassword1"
                >Confirm New Password <span>*</span></label
              >
              <input
                v-model="form.confirm_new_password"
                type="password"
                class="form-control unicase-form-control text-input"
                placeholder="Confirm New Password"
                name="confirm_new_password"
                required
                autocomplete="confirm_new_password"
                :class="{ 'is-invalid': form.errors.has('confirm_new_password') }"
              />
              <div
                style="color: red"
                v-if="form.errors.has('confirm_new_password')"
                v-html="form.errors.get('confirm_new_password')"
              />
            </div>
            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">
              <div id="loadingCircle" style="display: none; right: 5%" class="lds-ring">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
              </div>
              <div id="loginButtonText">Change Password</div>
            </button>
          </form>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </div>
  <Footer />
</template>
<script>
import { useRouter } from 'vue-router';
//import axios from 'axios';
import swal from 'sweetalert2';
import Breadcrumbs from './partials/Breadcrumbs.vue';
import ProfileSidebar from './partials/ProfileSidebar.vue';
import Nav from './partials/Nav.vue';
import Footer from './partials/Footer.vue';
import { Form } from 'vform';
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
    ProfileSidebar,
    Footer,
    Breadcrumbs,
  },

  data() {
    return {
      form: new Form({
        current_password: '',
        new_password: '',
        confirm_new_password: '',
      }),
      loadingForm: false,
    };
  },

  methods: {
    updatePassword() {
      this.loadingForm = true;
      const router = useRouter();
      const token = localStorage.getItem('token-user');

      // request post
      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .post('api/user/change-password', {
          current_password: this.current_password,
          new_password: this.new_password,
          confirm_new_password: this.confirm_new_password
        })
        .then((response) => {
          if (response.data.success) {
            // sweet alert 2
            swal.fire({
              icon: 'success',
              title: 'Password updated successfully',
            });

            localStorage.removeItem('token-user');
            localStorage.removeItem('user-data');

            //redirect ke halaman login-user
            return router.push({
              name: 'user-login',
            });
          } else {
            console.log(response.data.error);
          }
        })
        .catch(() => {
          // sweet alert fail
          swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href>Why do I have this issue?</a>',
          });
        })
        .finally(() => {
          this.loadingForm = false;
        });
    },
  },
};
</script>

<style>
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/main.css';
</style>
