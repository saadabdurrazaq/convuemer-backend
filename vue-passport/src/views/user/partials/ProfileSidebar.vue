<template>
  <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
    <br />
    <div class="side-menu animate-dropdown outer-bottom-xs">
      <div style="display: flex; justify-content: center">
        <img
          class="card-img-top"
          style="border-radius: 50%; margin-top: 10px"
          height="100"
          width="100"
          :src="require('@/assets/avatar/fb-male.jpg')"
          alt="User Image"
        />
      </div>
      <br />
      <div style="margin-left: 10px; margin-right: 10px; height: 250px">
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
import { mapGetters, mapActions } from 'vuex';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import image from 'admin-lte/dist/img/AdminLTELogo.png';
import axios from 'axios';

export default {
  data: function () {
    return {
      image: image,
      router: useRouter(),
    };
  },
  computed: {
    ...mapGetters({
      guest: 'auth/guest',
      user: 'auth/user',
    }),
  },
  methods: {
    ...mapActions({
      setAuth: 'auth/set',
    }),

    //method logout
    logout() {
      //logout
      let config = {
        headers: {
          Authorization: 'Bearer ' + this.user.token,
        },
      };
      axios
        .post('api/user/logout', {}, config)
        .then((response) => {
          if (response.data.success) {
            this.setAuth({});

            //redirect to login
            return this.router.push({
              name: 'user-login',
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  beforeMount() {},
  created() {},
  mounted() {
    const token = this.user.token;
    if (!token) {
      return this.router.push({
        name: 'user-login',
      });
    }
  },
};
</script>
