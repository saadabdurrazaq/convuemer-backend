<template>
  <Nav />
  <Breadcrumbs />
  <div class="body-content outer-top-xs" id="top-banner-and-menu">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 sidebar">
          <div class="side-menu animate-dropdown outer-bottom-xs" style="background-color: #fff">
            <!-- address card -->
            <div class="row">
              <div v-if="loading" style="position: absolute; top: 50%; left: 50%">
                <div class="lds-facebook">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
              </div>
              <div
                class="col-xs-12 col-sm-12 col-md-12"
                style="margin-right: 10px; margin-top: 18px"
              >
                <div
                  class="container"
                  style="
                    width: 95%;
                    height: 200px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                  "
                >
                  <div class="content" style="width: 100%; float: left; box-sizing: border-box">
                    <h5 style="padding-top: 8px; float: left">Shipping Address</h5>
                    <select
                      id="label_address"
                      class="form-control"
                      @change="changeAddress($event)"
                      style="width: 150px; margin: 10px 0 -10px auto"
                    >
                      <option :value="null" disabled selected>Select Address</option>
                      <option
                        v-for="user_address in user_addresses"
                        :value="user_address.id"
                        :data-index="user_address.id"
                        v-bind:key="user_address.id"
                        :selected="user_address.id === current_user_addresses_id"
                      >
                        {{ user_address.label }}
                      </option>
                    </select>
                    <hr class="class-1" />
                    <template v-if="user_addresses.length > 0">
                      <h3>{{ selectedAddress[0].label }}</h3>
                      <br />
                      {{ selectedAddress[0].address }}, Kel.{{
                        selectedAddress[0].village_residence_name
                      }}, Kec.{{ selectedAddress[0].district_residence_name }},
                      {{ selectedAddress[0].regency_residence_name }},
                      {{ selectedAddress[0].province_residence_name }},
                      {{ selectedAddress[0].kode_pos }}
                    </template>
                    <template v-else>
                      <h3 style="text-align:center; padding-top:20px;">No address found. Please input your address first <a
                      :href="
                        $router.resolve({
                          name: 'user-home',
                        }).href
                      "
                      >here</a>
                      </h3>
                    </template>
                  </div>
                </div>
                <hr class="class-5" />
              </div>
            </div>
            <!-- end address card -->

            <!-- shipping -->
            <div class="row">
              <div
                class="col-xs-12 col-sm-12 col-md-12"
                style="margin-bottom: 20px; margin-left: 15px"
              >
                <div style="margin-right: 30px">
                  <h5 style="float: left; padding-left: 5px">Shipping Courier</h5>
                  <select
                    id="label_address"
                    class="form-control"
                    v-model="service"
                    @change="calculateBill()"
                    style="float: right; width: 150px; margin: auto 5px -10px auto"
                  >
                    <option :value="null" disabled selected>Delivery Time</option>
                    <option
                      v-for="service in services"
                      :value="service.service"
                      :data-index="service.service"
                      v-bind:key="service.service"
                    >
                      {{ service.resume }}
                    </option>
                  </select>
                  <select
                    id="label_address"
                    v-model="courier"
                    class="form-control"
                    @change="checkDataBeforeGetServices()"
                    style="float: right; width: 100px; margin: auto 5px -10px auto"
                  >
                    <option :value="null" disabled selected>Courier</option>
                    <option
                      :disabled="user_addresses.length === 0"
                      v-for="courier in couriers"
                      :value="courier.id"
                      :data-index="courier.id"
                      v-bind:key="courier.id"
                    >
                      {{ courier.text }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <!-- shipping -->

            <!-- product -->
            <div class="row" v-for="cart in carts" :key="cart.id">
              <div class="col col-md-2" style="float: left; width: 20%; margin-top: 10px">
                <img
                  width="100"
                  height="100"
                  style="margin-left: 20px; margin-bottom: 15px"
                  :src="`${BASE_URL}/storage/app/public/products/${cart.cover}`"
                  class="img-responsive wp-post-image"
                  alt=""
                  loading="lazy"
                />
              </div>
              <div
                class="col-md-6"
                style="
                  float: left;
                  margin-bottom: 20px;
                  font-size: 3.25vh;
                  width: 40%;
                  margin-left: -15px;
                "
              >
                <div class="product-info" style="margin-bottom: 15px">
                  <h4 class="name" style="font-size: 3.25vh">
                    <a
                      :href="
                        $router.resolve({
                          name: 'product-show',
                          params: { id: cart.url_id, slug: cart.url },
                        }).href
                      "
                      >{{ cart.product_name }}</a
                    >
                    x {{ cart.quantity }} pcs
                  </h4>
                </div>
                <div>
                  <span style="width: 100%; color: #8e8e8e"
                    >{{ cart.product_weight }} {{ cart.metric_mass }}</span
                  >
                </div>
                <div style="margin-top: 10px">
                  <span style="width: 100%">Rp.{{ cart.price.toLocaleString() }}</span>
                </div>
              </div>
              <div class="col-md-2" style="margin-top: 40px; float: right; margin-right: 2%"></div>
            </div>
            <!-- end product -->
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 homebanner-holder" style="margin-bottom: 30px">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="container col-xs-12 col-sm-12 col-md-12" style="background-color: white">
                <div>
                  <div style="padding-top: 15px">Summary</div>
                  <hr class="class-1" />
                  <p style="float: left">Products</p>
                  <p style="width: 150px; margin: auto 0 auto auto; text-align: right">
                    Rp. {{ totalPrice.toLocaleString('id-ID') }}
                  </p>
                  <br />
                  <p style="float: left">Shipping</p>
                  <p style="width: 150px; margin: auto 0 auto auto; text-align: right">
                    Rp. {{ shippingCost.toLocaleString('id-ID') }}
                  </p>
                  <hr class="class-1" />
                  <p style="float: left; font-weight: bold">Total</p>
                  <p style="width: 150px; margin: auto 0 auto auto; text-align: right">
                    {{ totalBill.toLocaleString('id-ID') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="shopping-cart-btn" style="margin-right: 15px">
          <span>
            <button :disabled="totalBill==0" id="loadingButton" @click.stop.prevent="proceed()" style="margin-bottom: 15px" class="btn btn-upper pull-right outer-right-xs"
              >Proceed</button
            >
          </span>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
//import { useRouter } from 'vue-router';
//import axios from 'axios';
import Nav from './partials/Nav.vue';
import Footer from './partials/Footer.vue';
import Breadcrumbs from './partials/Breadcrumbs.vue';
import axios from 'axios';
import swal from 'sweetalert2';
import { mapGetters, mapActions } from 'vuex';
import { BASE_URL } from '@/assets/js/base-url.js';

export default {
  beforeCreate: function () {
    document.body.className = 'home-user';
  },
  components: {
    Nav,
    Footer,
    Breadcrumbs,
  },
  data() {
    return {
      BASE_URL: BASE_URL,
      user: '',
      user_addresses: {},
      current_user_addresses_id: '',
      selectedAddress: {},
      quantity: 1,
      couriers: [],
      courier: null,
      services: [],
      service: null,
      shippingCost: 0,
      totalBill: 0,
      city_id: 0,
      loading: false,
      successCheckout: false
    };
  },
  computed: {
    ...mapGetters({
      carts: 'cart/carts',
      countCart: 'cart/count',
      totalPrice: 'cart/totalPrice',
      totalQuantity: 'cart/totalQuantity',
      totalWeight: 'cart/totalWeight',
    }),
  },
  methods: {
    ...mapActions({
      deleteProd: 'cart/delete',
      addCart: 'cart/add',
      removeCart: 'cart/remove',
      setCart: 'cart/set',
      setPayment: 'setPayment'
    }),
    removeFirstWord(str) {
      const indexOfSpace = str.indexOf(' ');

      if (indexOfSpace === -1) {
        return '';
      }

      return str.substring(indexOfSpace + 1);
    },
    showSuccessMsg(response) {
      const Toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', swal.stopTimer);
          toast.addEventListener('mouseleave', swal.resumeTimer);
        },
      });

      Toast.fire({
        icon: 'success',
        title: response,
      });
    },
    showErrMsg(response) {
      const Toast = swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', swal.stopTimer);
          toast.addEventListener('mouseleave', swal.resumeTimer);
        },
      });

      Toast.fire({
        icon: 'error',
        title: response,
      });
    },
    checkAuth() {
      // state token 
      const token = localStorage.getItem('token-user'); 

      if (this.carts.length > 0 && token) {
        //get data user
        axios.defaults.headers.common.Authorization = `Bearer ${token}`;
        axios
          .get('http://localhost/my-project/laravue/api/user')
          .then((response) => {
            this.user = response.data;
            this.loadStoredAddresses();
            this.getCouriers();

            console.log(this.carts);
          })
          .catch((error) => {
            console.log(error);
          });
      } else if (this.carts.length === 0) {
        if(this.successCheckout === false) {
          this.showErrMsg('No product in your cart. You will be redirected to previous page!');
        } else {
          this.showSuccessMsg('Your order has been placed!')
        }
        setTimeout(() => {
          window.history.back();
        }, 3000);
      }
    },
    loadStoredAddresses() {
      this.axios
        .get('api/user/shipping-addresses/index/' + this.user.id)
        .then((response) => {
          let responseData = response.data;
          this.user_addresses = responseData.data;
          this.selectedAddress = this.user_addresses;
          this.city_id = this.selectedAddress[0].city_id[0];
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.current_user_addresses_id = this.user_addresses[0].id;
        });
    },
    changeAddress(event) {
      let address_id = event.target.options[event.target.selectedIndex].dataset.index;

      var selectedAddress = this.user_addresses.filter(function (x) {
        return x.id == address_id;
      });
      this.selectedAddress = selectedAddress;

      this.city_id = this.selectedAddress[0].city_id[0];
    },
    getCouriers() {
      if (this.couriers.length == 0) {
        this.axios.get('api/couriers').then((response) => {
          this.couriers = response.data.data;
        });
      }
    },
    getServices() {
      this.loading = true;
      let courier = this.courier;
      let encodedCart = JSON.stringify(this.carts);
      let city = this.removeFirstWord(this.selectedAddress[0].regency_residence_name);
      let formData = new FormData();
      formData.set('courier', courier);
      formData.set('carts', encodedCart);
      formData.set('city', city);
      formData.set('city_id', this.city_id);

      const token = localStorage.getItem('token-user');

      let config = {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      };
      this.axios
        .post('api/user/cart-checkout/services', formData, config)
        .then((response) => {
          let response_data = response.data;
          // jika tidak error maka data service dan cart akan diupdate.
          if (response_data.status != 'error') {
            this.services = response_data.data.services;
            this.setCart(response_data.data.safe_carts);
          }
          this.showSuccessMsg(response_data.message); 
          console.log(response_data);
          this.loading = false;
        })
        .catch((error) => {
          let responses = error.response;
          this.showErrMsg(responses.data.message);
          console.log(error.response);
        });
    },
    checkDataBeforeGetServices() {
      this.service = null;
      this.services = [];
      this.shippingCost = 0;
      this.totalBill = 0;

      const token = localStorage.getItem('token-user');

      if (this.carts.length > 0 && token) {
        this.getServices();
      } else {
        this.showErrMsg('No product in your cart. You will be redirected to previous page!');
        setTimeout(() => {
          window.history.back();
        }, 3000);
      }
    },
    calculateBill() {
      let selectedService = this.services.find((service) => {
        return service.service == this.service;
      });
      console.log(selectedService);
      this.shippingCost = selectedService.cost;
      this.totalBill = parseInt(this.totalPrice) + parseInt(this.shippingCost);
    },
    proceed() {
      $('#loadingButton').html(
        `<div class="proc-regis"><i class='fa fa-circle-o-notch fa-spin'></i> Ordering product(s)...</div>`
      );
      $('#loadingButton').attr('disabled', true);

      let courier = this.courier;
      let service = this.service;
      let safeCart = JSON.stringify(this.carts); 
      let formData = new FormData();
      formData.set('courier', courier);
      formData.set('service', service);
      formData.set('carts', safeCart);
      formData.set('city_id', this.city_id); 
      formData.set('total_quantity', this.totalQuantity);
      const token = localStorage.getItem('token-user');
      let config = {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };
      this.axios
        .post('api/user/cart-checkout/proceed', formData, config)
        .then((response) => {
          let { data } = response;
          if (data && data.status == 'success') {
            this.setPayment(data.data); 
            this.successCheckout = true;
            this.$router.push({ path: '/user/orders' });
            this.setCart([]);
          }

          this.showSuccessMsg(data.message);

          $('#loadingButton').attr('disabled', false);
          $('.proc-regis').remove();
          $('#loadingButton').html(`Proceed`);
        })
        .catch((error) => {
          let { data } = error.response;
          this.showErrMsg(data.message);
          console.log(data.message);
          $('#loadingButton').attr('disabled', false);
          $('.proc-regis').remove();
          $('#loadingButton').html(`Proceed`);
        });
    },
  },
  beforeMount() {},
  watch: {
    carts: {
      handler: function (val) {
        if (val.length === 0) {
          this.checkAuth();
        }
      },
      deep: true,
    }, 
  },
  created() {
    this.checkAuth();
  },
  mounted() {},
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
hr.class-1 {
  border-top: 2px solid #e0dbdb;
}
hr.class-5 {
  background-color: #fff;
  border-top: 2px dashed #8c8b8b;
  margin-right: 20px;
  margin-left: 20px;
}
/* Facebook loading icom */
.lds-facebook {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-facebook div {
  display: inline-block;
  position: absolute;
  left: 8px;
  width: 16px;
  background: #31708f;
  animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
}
.lds-facebook div:nth-child(1) {
  left: 8px;
  animation-delay: -0.24s;
}
.lds-facebook div:nth-child(2) {
  left: 32px;
  animation-delay: -0.12s;
}
.lds-facebook div:nth-child(3) {
  left: 56px;
  animation-delay: 0;
}
@keyframes lds-facebook {
  0% {
    top: 8px;
    height: 64px;
  }
  50%,
  100% {
    top: 24px;
    height: 32px;
  }
}
/* Ring loading */
.lds-ring {
  display: inline-block;
  position: relative;
  width: 20px;
  height: 20px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 24px;
  height: 24px;
  margin: 2px;
  border: 2px solid #fff;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #fff transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
