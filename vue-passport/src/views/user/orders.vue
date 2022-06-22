<template v-if="isLoggedIn">
  <Nav />
  <div class="body-content outer-top-xs" id="top-banner-and-menu">
    <div class="container">
      <div class="row">
        <ProfileSidebar />
        <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
          <div class="row">
            <div class="col-md-12">
              <div
                class="container col-md-12"
                style="background-color: white; margin-top: 20px; margin-bottom: 20px"
              >
                <!-- Profile card -->
                <div v-for="item in items" :key="item.id">
                  <template v-if="item.products.length > 0">
                    <div
                      class="container col-md-12"
                      v-for="prod in item.products"
                      :key="prod.id"
                      style="
                        width: 98%;
                        height: 40%;
                        margin-top: 20px;
                        margin-bottom: 20px;
                        margin-left: 5px;
                        margin-right: 13px;
                        background: #fff;
                        border-radius: 5px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                        float: left;
                      "
                    >
                      <div
                        class="img-container"
                        style="
                          width: 25%;
                          height: 100%;
                          float: left;
                          position: relative;
                          margin-left: -15px;
                        "
                      >
                        <div style="overflow: hidden; position: relative">
                          <span
                            style="
                              padding: 5% 0px;
                              padding-left: 10%;
                              top: 16%;
                              right: 25.5%;
                              width: 110%;
                              text-align: center;
                              color: rgb(255, 255, 255);
                              font-size: 1.45vw;
                              font-weight: bold;
                              position: absolute;
                              z-index: 0;
                              transform: rotate(-45deg);
                              background-color: #1b8294;
                            "
                            >{{ item.status }}</span
                          >

                          <img
                            :src="`${BASE_URL}/storage/app/public/products/${prod.cover}`"
                            alt=""
                            style="
                              width: 100%;
                              height: 100%;
                              border-top-left-radius: 5px;
                              border-bottom-left-radius: 5px;
                            "
                          />
                        </div>
                      </div>
                      <div style="float: right; width: 75%">
                        <div style="margin-top: 2%; margin-bottom: 10%; font-size: 1.5vw">
                          {{ new Intl.DateTimeFormat("en-GB", { year: "numeric", month: "long", day: "2-digit" }).format(new Date(item.created_at)) }} | Invoice: {{ item.invoice_number }}

                          <!-- three dot menu -->
                          <div
                            class="dropdown-dots dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <!-- three dots -->
                            <ul class="dropbtn icons">
                              <li></li>
                              <li></li>
                              <li></li>
                            </ul>
                            <!-- menu -->
                            <div
                              id="myDropdown"
                              class="dropdown-content dropdown-menu dropdown-menu-right"
                            >
                              <a href="#home">Home</a>
                              <a href="#about">About</a>
                              <a href="#contact">Print Invoice</a>
                            </div>
                          </div>
                        </div>
                        <div style="float: left; margin-top: -6%">
                          <h4 style="font-size: 2vw">
                          <a
                            :href="
                              $router.resolve({
                                name: 'product-show',
                                params: { id: prod.url_id, slug: prod.url },
                              }).href
                            "
                            >{{ prod.product_name }}</a
                          >
                          </h4>
                        </div>
                        <div style="float: right">
                          Price: <b>Rp. {{ prod.price.toLocaleString() }}</b>
                        </div>
                      </div>
                    </div>
                  </template>
                  <template v-if="item.variants_prod.length > 0">
                    <div
                      class="container col-md-12"
                      v-for="prodComb in item.variants_prod"
                      :key="prodComb.id"
                      style="
                        width: 98%;
                        height: 40%;
                        margin-top: 20px;
                        margin-bottom: 20px;
                        margin-left: 5px;
                        margin-right: 13px;
                        background: #fff;
                        border-radius: 5px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                        float: left;
                      "
                    >
                      <div
                        class="img-container"
                        style="
                          width: 25%;
                          height: 100%;
                          float: left;
                          position: relative;
                          margin-left: -15px;
                        "
                      >
                        <div style="overflow: hidden; position: relative">
                          <span
                            style="
                              padding: 5% 0px;
                              padding-left: 10%;
                              top: 16%;
                              right: 25.5%;
                              width: 110%;
                              text-align: center;
                              color: rgb(255, 255, 255);
                              font-size: 1.45vw;
                              font-weight: bold;
                              position: absolute;
                              z-index: 0;
                              transform: rotate(-45deg);
                              background-color: #1b8294;
                            "
                            >{{ item.status }}</span
                          >

                          <img
                            :src="`${BASE_URL}/storage/app/public/products/${prodComb.cover}`"
                            alt=""
                            style="
                              width: 100%;
                              height: 100%;
                              border-top-left-radius: 5px;
                              border-bottom-left-radius: 5px; 
                            "
                          />
                        </div>
                      </div>
                      <div style="float: right; width: 75%">
                        <div style="margin-top: 2%; margin-bottom: 10%; font-size: 1.5vw">
                          {{ new Intl.DateTimeFormat("en-GB", { year: "numeric", month: "long", day: "2-digit" }).format(new Date(item.created_at)) }} | Invoice: {{ item.invoice_number }}

                          <!-- three dot menu -->
                          <div
                            class="dropdown-dots dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <!-- three dots -->
                            <ul class="dropbtn icons">
                              <li></li>
                              <li></li>
                              <li></li>
                            </ul>
                            <!-- menu -->
                            <div
                              id="myDropdown"
                              class="dropdown-content dropdown-menu dropdown-menu-right"
                            >
                              <a href="#home">Home</a>
                              <a href="#about">About</a>
                              <a href="#contact">Print Invoice</a>
                            </div>
                          </div>
                        </div>
                        <div style="float: left; margin-top: -6%">
                           <h4 style="font-size: 2vw">
                          <a
                            :href="
                              $router.resolve({
                                name: 'product-show',
                                params: { id: prodComb.url_id, slug: prodComb.url },
                              }).href
                            "
                            >{{ prodComb.product_name }}</a
                          >
                          </h4>
                        </div>
                        <div style="float: right">
                          Price: <b>Rp. {{ prodComb.price.toLocaleString() }}</b>
                        </div>
                      </div>
                    </div>
                  </template>
                </div>
                <!-- end profile card -->
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
import { BASE_URL } from '@/assets/js/base-url.js';
import swal from 'sweetalert2';

export default {
  beforeCreate: function () {
    document.body.className = 'home-user';
  },
  components: {
    Nav,
    ProfileSidebar,
    Footer,
  },
  data() {
    return {
      user: '',
      BASE_URL: BASE_URL,
      items: [],
      products: [],
      prodCombs: [],
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
        .get('api/user')
        .then((response) => {
          this.user = response.data; 
        })
        .catch((error) => {
          console.log(error.response.data);
          if (error.response.status === 403) {
            router.push('/user/login');
          }
          return Promise.reject(error);
        })
        .finally(() => {
          this.dataOrder();
        });
    },
    dataOrder() {
      const token = localStorage.getItem('token-user');

      let config = {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      };
      this.axios
        .get('api/user/my-order', config)
        .then((response) => {
          let { data } = response.data;
          this.items = data;
          this.products = data[0].products;
          this.prodCombs = data[0].variants_prod;
        })
        .catch((error) => {
          let { data } = error.response;
          console.log(data.message);
        });
    }, 
  },
  beforeMount() {}, 
  created() {
    //
  },
  mounted() {
    this.checkAuth();
    let data = this.$route.params.dataUser; 
    console.log("data is", data); 
    if (swal.isVisible()) {
      document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
    }
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

.icons li {
  background: none repeat scroll 0 0 #00000099;
  height: 7px;
  width: 7px;
  line-height: 0;
  list-style: none outside none;
  margin-right: 5px;
  margin-top: 3px;
  vertical-align: top;
  border-radius: 50%;
  pointer-events: none;
  float: left;
}

.dropbtn {
  color: white;
  font-size: 16px;
  border: none;
  cursor: pointer;
  margin-right: -5px;
}

.dropdown-dots {
  position: relative;
  right: 0.4em;
  float: right;
  margin-top: 5px;
  cursor: pointer;
}

.dropdown-content {
  display: none;
  position: absolute;
  margin-top: 15px;
  background-color: white;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
  background-color: #f1f1f1;
}

.dropdown a:hover {
  background-color: #f1f1f1;
}

.show {
  display: block;
  right: 0; /* align the dropdown-content into right*/
}
</style>
