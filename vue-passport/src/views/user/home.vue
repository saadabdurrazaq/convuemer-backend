<template v-if="isLoggedIn">
  <Nav />
  <div class="body-content">
    <div class="container">
      <div class="row">
        <ProfileSidebar />
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <h3 class="text-center">
                <span class="text-danger">Hi... </span><strong>{{ user.name }}</strong> Welcome To
                Easy Online Shop
              </h3>
            </div>
          </div>
          <!-- // end col md 6 -->
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </div>
  <Footer />
</template>

<script>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import ProfileSidebar from './partials/ProfileSidebar.vue';
import Nav from './partials/Nav.vue';
import Footer from './partials/Footer.vue';

export default {
  beforeCreate: function () {
    document.body.className = 'home-user';
  },
  components: {
    Nav,
    ProfileSidebar,
    Footer,
  },
  setup() {
    //inisialisasi vue router on Composition API
    const router = useRouter();

    //state token
    const token = localStorage.getItem('token-user'); 

    //state user
    const user = ref('');

    //mounted properti
    onMounted(() => {
      //check Token exist
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
          console.log(response.data.name);
          user.value = response.data;
        })
        .catch((error) => {
          console.log(error.response.data);
          if (error.response.status === 403) {
            router.push('/user/login');
          }
          return Promise.reject(error);
        });
    });

    //method logout
    function logout() {
      //logout
      axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      axios
        .post('http://localhost/my-project/laravue/api/user/logout')
        .then((response) => {
          if (response.data.success) {
            //remove localStorage
            localStorage.removeItem('token');

            //redirect ke halaman login-user
            return router.push({
              name: 'user-login',
            });
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    }

    return {
      token, // <-- state token
      user, // <-- state user
      logout, // <-- method logout
    };
  },
};
</script>

<style>
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/main.css';
@import '~@/assets/frontend/css/animate.min.css';
@import '~@/assets/frontend/css/blue.css';
@import '~@/assets/frontend/css/bootstrap-select.min.css';
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/font-awesome.css';
@import '~@/assets/frontend/css/lightbox.css';
@import '~@/assets/frontend/css/loading.css';
@import '~@/assets/frontend/css/main.css';
@import '~@/assets/frontend/css/owl.carousel.css';
@import '~@/assets/frontend/css/owl.transitions.css';
@import '~@/assets/frontend/css/rateit.css';
</style>
