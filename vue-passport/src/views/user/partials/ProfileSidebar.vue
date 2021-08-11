<template>
  <div class="col-md-2">
    <br />
    <template v-if="userData.data.profile_photo_path != null">
      <img
        class="card-img-top"
        style="border-radius:50%;margin-left:30px;"
        height="100"
        width="100"
        :src="require('@/assets/avatar/fb-male.jpg')"
        alt="User Image"
      />
    </template>
    <template v-if="userData.data.profile_photo_path == null">
      <template v-if="userData.data.gender == 'Male'">
        <img
          class="card-img-top"
          style="border-radius:50%;margin-left:30px;"
          height="100"
          width="100"
          :src="require('@/assets/avatar/fb-male.jpg')"
          alt="User Image"
        />
      </template>
      <template v-else>
        <img
          class="card-img-top"
          style="border-radius:50%;margin-left:30px;"
          height="100"
          width="100"
          :src="require('@/assets/avatar/female-fb.jpg')"
          alt="User Image"
        />
      </template>
    </template>
    <br /><br />

    <ul class="list-group list-group-flush">
      <a href="" class="btn btn-primary btn-sm btn-block">Home</a>
      <a href="" class="btn btn-primary btn-sm btn-block">Profile Update</a> 
      <router-link :to="{name: 'user-change-password'}" class="btn btn-primary btn-sm btn-block" href="#">Change Password</router-link>
      <a href="" class="btn btn-primary btn-sm btn-block">My Orders</a>
      <a href="" class="btn btn-primary btn-sm btn-block">Return Orders</a>
      <a href="" class="btn btn-primary btn-sm btn-block">Cancel Orders</a>
      <a @click.prevent="logout" href="" class="btn btn-danger btn-sm btn-block">Logout</a>
    </ul>
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
