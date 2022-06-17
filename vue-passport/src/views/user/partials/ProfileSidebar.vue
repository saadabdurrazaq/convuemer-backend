<template>
  <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
    <br />
    <div class="side-menu animate-dropdown outer-bottom-xs">
      <div style="display:flex; justify-content:center;">
        <img
          class="card-img-top"
          style="border-radius: 50%; margin-top:10px;"
          height="100"
          width="100"
          :src="require('@/assets/avatar/fb-male.jpg')"
          alt="User Image"
        />
      </div> 
      <br />
      <div style="margin-left: 10px; margin-right: 10px; height:250px">
        <ul class="list-group list-group-flush">
          <router-link :to="{ name: 'user-home' }" class="btn btn-sm btn-block" href="#"
            >Home</router-link
          >
          <a href="" class="btn btn-sm btn-block">Profile Update</a>
          <router-link :to="{ name: 'user-change-password' }" class="btn btn-sm btn-block" href="#"
            >Change Password</router-link
          >
          <router-link :to="{ name: 'orders' }" class="btn btn-sm btn-block" href="#"
            >Orders</router-link
          >
          <a href="" class="btn btn-sm btn-block">Return Orders</a>
          <a href="" class="btn btn-sm btn-block">Cancel Orders</a>
          <a @click.prevent="logout" href="" class="btn btn-danger btn-sm btn-block">Logout</a>
        </ul>
      </div>
    </div>
  </div>
  <!-- // end col md 2 -->
</template>
<script>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import image from 'admin-lte/dist/img/AdminLTELogo.png';
import axios from 'axios';

export default {
  data: function () {
    return {
      image: image,
    };
  },
  setup() {
    //state token
    const token = localStorage.getItem('token-user');
    let userData = JSON.parse(localStorage.getItem('user-data'));

    //inisialisasi vue router on Composition API
    const router = useRouter();

    //mounted properti
    onMounted(() => {
      //check Token exist
      if (!token) {
        return router.push({
          name: 'user-login',
        });
      }
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
            localStorage.removeItem('token-user'); 
            localStorage.removeItem('user-data');

            //redirect ke halaman login-staff
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
      userData, // <-- state user
      logout,
    };
  },
};
</script>
