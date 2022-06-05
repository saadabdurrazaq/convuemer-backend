<template>
  <Nav />
  <Breadcrumbs />
  <div class="body-content outer-top-xs" id="top-banner-and-menu">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 shopping-cart" style="margin-bottom: 30px">
          <div class="shopping-cart-table">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr style="background-color: rgba(0, 0, 0, 0.03)">
                    <th class="cart-romove item">Remove</th>
                    <th class="cart-description item">Image</th>
                    <th class="cart-product-name item">Product Name</th>
                    <th class="cart-qty item">Quantity</th>
                    <th class="cart-sub-total item">Total</th>
                  </tr>
                </thead>
                <!-- /thead -->
                <tfoot>
                  <tr>
                    <th colspan="7" style="background-color: rgba(0, 0, 0, 0.03); font-size: 16px">
                      <span class="pull-right outer-right-xs">
                        Subtotal: Rp.{{ totalPrice.toLocaleString() }}
                      </span>
                    </th>
                  </tr>
                  <tr>
                    <td colspan="7">
                      <div class="shopping-cart-btn">
                        <span style="margin-right: -25px">
                          <a
                            class="btn btn-upper btn-primary pull-right outer-right-xs"
                            :href="$router.resolve({ name: 'checkout' }).href"
                            >Checkout</a
                          >
                        </span>
                      </div>
                      <!-- /.shopping-cart-btn -->
                    </td>
                  </tr>
                </tfoot>
                <tbody>
                  <tr v-for="(item, index) in carts" :key="'cart' + index">
                    <td class="romove-item">
                      <a href="#" title="cancel" class="icon" @click.stop.prevent="deleteProd(item)"
                        ><i class="fa fa-trash-o"></i
                      ></a>
                    </td>
                    <td class="cart-image">
                      <img
                        :src="`${BASE_URL}/storage/app/public/products/${item.cover}`"
                        alt=""
                        style="margin-left: 40px"
                      />
                    </td>
                    <td class="cart-product-name-info" style="margin-left: 10px">
                      <h4 class="cart-product-description" style="text-align: center">
                        <router-link
                          :to="{
                            name: 'product-show',
                            params: {
                              id: item.url_id,
                              slug: item.url,
                            },
                          }"
                        >
                          {{ item.product_name }}
                        </router-link>
                      </h4>
                    </td>
                    <td class="cart-product-quantity">
                      <!-- 
                          npm install vue@3 @chenfengyuan/vue-number-input@2 (https://github.com/fengyuanchen/vue-number-input)
                       -->
                      <vue-number-input
                        :model-value="item.quantity"
                        @update:model-value="onUpdate"
                        @click="getItem(item)"
                        @change="changeItem(item)"
                        :min="1"
                        :max="item.available_stock"
                        inline
                        controls
                      ></vue-number-input>
                    </td>
                    <td class="cart-product-sub-total">
                      <span class="cart-sub-total-price"
                        >Rp.{{ (item.price * item.quantity).toLocaleString() }}</span
                      >
                    </td>
                  </tr>
                </tbody>
                <!-- /tbody -->
              </table>
              <!-- /table -->
            </div>
          </div>
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
import Nav from './partials/Nav.vue';
import Footer from './partials/Footer.vue';
import { mapGetters, mapActions } from 'vuex';
// import swal from 'sweetalert2';
import { BASE_URL } from '@/assets/js/base-url.js';
import Breadcrumbs from './partials/Breadcrumbs.vue';

export default {
  beforeCreate: function () {
    document.body.className = 'welcome';
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
      BASE_URL: BASE_URL,
      quantity: 1,
      item: {},
      newValue: 0,
      oldValue: 0,
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
    }),
    addOrRemoveCart() {
      if (this.newValue > this.oldValue) {
        this.addCart(this.item);
        this.newValue = 0;
        this.oldValue = 0;
      } else if (this.newValue < this.oldValue) {
        this.removeCart(this.item);
        this.newValue = 0;
        this.oldValue = 0;
      }
    },
    onUpdate(newValue, oldValue) {
      this.newValue = newValue;
      this.oldValue = oldValue;
    },
    onInput(event) {
      console.log(event);
    },
    getItem(item) {
      this.item = item;
      var self = this;
      setTimeout(function () {
        self.addOrRemoveCart();
      }, 300);
    },
    changeItem(item) {
      if (this.newValue > this.oldValue) {
        for (let i = this.oldValue; i < this.newValue; i++) { 
          this.addCart(item);
          if (i == this.newValue - 1) {
            this.newValue = 0;
            this.oldValue = 0;
          }
        }
      } else if (this.newValue < this.oldValue) {
        for (let i = this.newValue; i < this.oldValue; i++) {
          this.removeCart(item);
          if (i == this.oldValue - 1) {
            this.newValue = 0;
            this.oldValue = 0;
          }
        }
      } else if (this.newValue == this.oldValue) {
        console.log('same value');
      }
    },
  },
  created() {},
  mounted() {
    //
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

.vue-number-input {
  width: 9rem;
}

.vue-number-input input {
  text-align: center;
  font-size: medium;
}
</style>
