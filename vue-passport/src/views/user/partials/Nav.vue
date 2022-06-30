<template>
  <header class="header-style-1">
    <!-- ============================================== TOP MENU ============================================== -->
    <div class="top-bar animate-dropdown">
      <div class="container">
        <div class="header-top-inner">
          <div class="cnt-account">
            <ul class="list-unstyled">
              <li>
                <a href="#"><i class="icon fa fa-heart"></i>Wishlist</a>
              </li>
              <li>
                <router-link :to="{ name: 'cart' }" href="#"
                  ><i class="icon fa fa-shopping-cart"></i>My Cart</router-link
                >
              </li>
              <li>
                <router-link :to="{ name: 'checkout' }" href="#"
                  ><i class="icon fa fa-check"></i>Checkout</router-link
                >
              </li>
              <li>
                <template v-if="token === null">
                  <router-link :to="{ name: 'user-login' }" class="nav-link" href="#"
                    ><i class="icon fa fa-lock"></i>Login</router-link
                  >
                </template>
                <template v-else>
                  <router-link :to="{ name: 'user-home' }" href="#"
                    ><i class="icon fa fa-home"></i>My Account</router-link
                  >
                </template>
              </li>
            </ul>
          </div>
          <!-- /.cnt-account -->

          <div class="cnt-block">
            <ul class="list-unstyled list-inline">
              <li class="dropdown dropdown-small">
                <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"
                  ><span class="value">USD </span><b class="caret"></b
                ></a>
                <ul class="dropdown-menu">
                  <li><a href="#">USD</a></li>
                  <li><a href="#">INR</a></li>
                  <li><a href="#">GBP</a></li>
                </ul>
              </li>
              <li class="dropdown dropdown-small">
                <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"
                  ><span class="value">English </span><b class="caret"></b
                ></a>
                <ul class="dropdown-menu">
                  <li><a href="#">English</a></li>
                  <li><a href="#">French</a></li>
                  <li><a href="#">German</a></li>
                </ul>
              </li>
            </ul>
            <!-- /.list-unstyled -->
          </div>
          <!-- /.cnt-cart -->
          <div class="clearfix"></div>
        </div>
        <!-- /.header-top-inner -->
      </div>
      <!-- /.container -->
    </div>
    <!-- ============================================== TOP MENU : END ============================================== -->

    <!-- ============================================== LOGO, SEARCH, CART ============================================== -->
    <div class="main-header">
      <div class="container">
        <div class="row">
          <!-- ============================================================= LOGO ============================================================= -->
          <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
            <div class="logo">
              <a style="color: white; font-weight: bold; font-size: 28px" href="home.html">
                ConVuemer
              </a>
            </div>
            <!-- /.logo -->
          </div>
          <!-- ============================================================= LOGO : END ============================================================= -->

          <!-- ============================================================= SEARCH AREA ============================================================= -->
          <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
            <div class="search-area">
              <form>
                <div class="control-group">
                  <ul class="categories-filter animate-dropdown">
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="category.html"
                        >Categories <b class="caret"></b
                      ></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="menu-header">Computer</li>
                        <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="category.html">- Clothing</a>
                        </li>
                        <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="category.html">- Electronics</a>
                        </li>
                        <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="category.html">- Shoes</a>
                        </li>
                        <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="category.html">- Watches</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <input class="search-field" placeholder="Search here..." />
                  <a class="search-button" href="#"></a>
                </div>
              </form>
            </div>
          </div>
          <!-- ============================================================= SEARCH AREA : END ============================================================= -->

          <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
          <div class="col-xs-12 col-sm-12 col-md-2 top-cart-row animate-dropdown">
            <div class="dropdown dropdown-cart">
              <a
                href="#"
                class="dropdown-toggle lnk-cart dropdown dropdown-cart"
                data-toggle="dropdown"
              >
                <div class="items-cart-inner">
                  <div class="basket">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                  </div>
                  <div class="basket-item-count">
                    <span class="count">{{ countCart }}</span>
                  </div>
                  <div class="total-price-basket">
                    <span class="total-price">
                      <span class="sign">Rp. </span
                      ><span class="value">{{ totalPrice.toLocaleString('id-ID') }}</span>
                    </span>
                  </div>
                </div>
              </a>
              <!-- show products inside cart summary -->
              <ul class="dropdown-menu">
                <ul style="height: 220px; width: 110%; overflow: hidden; overflow-y: scroll">
                  <div class="cart-item product-summary">
                    <template v-for="(item, index) in carts" :key="'cart' + index">
                      <div class="row" style="margin-bottom: 20px">
                        <div class="col-xs-4">
                          <div class="image">
                            <img
                              :src="`${BASE_URL}/storage/app/public/products/${item.cover}`"
                              alt=""
                            />
                          </div>
                        </div>
                        <div class="col-xs-7" style="margin-left: -15px">
                          <h3 class="name">
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
                          </h3>
                          <div class="price">
                            Rp. {{ item.quantity }} x
                            {{ item.price.toLocaleString() }}
                          </div>
                        </div>
                        <div class="col-xs-1 action">
                          <a href="#" @click.stop.prevent="removeCart(item)"
                            ><i class="fa fa-trash"></i
                          ></a>
                        </div>
                      </div>
                    </template>
                  </div>
                </ul>
                <li>
                  <!-- /.cart-item -->
                  <div class="clearfix"></div>
                  <hr />
                  <div class="clearfix cart-total">
                    <div class="pull-right">
                      <span class="text">Sub Total :</span
                      ><span class="price">Rp. {{ totalPrice.toLocaleString('id-ID') }}</span>
                    </div>
                    <div class="clearfix"></div>
                    <router-link
                      :to="{
                        name: 'cart',
                      }"
                      class="btn btn-upper btn-block m-t-20"
                    >
                      Show All ({{ countCart }})
                    </router-link>
                    <router-link
                      :to="{
                        name: 'checkout',
                      }"
                      class="btn btn-upper btn-block m-t-20"
                    >
                      Checkout
                    </router-link>
                  </div>
                  <!-- /.cart-total-->
                </li>
              </ul>
              <!-- /.dropdown-menu-->
            </div>
            <!-- /.dropdown-cart -->

            <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
          </div>
          <!-- ============================================================= SHOPPING CART DROPDOWN : END ============================================================= -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- ============================================== LOGO, SEARCH, CART : END ============================================== -->

    <!-- ============================================== NAVBAR ============================================== -->
    <div class="header-nav animate-dropdown">
      <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button
              data-target="#mc-horizontal-menu-collapse"
              data-toggle="collapse"
              class="navbar-toggle collapsed"
              type="button"
            >
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span> <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="nav-bg-class">
            <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
              <div class="nav-outer">
                <ul class="nav navbar-nav">
                  <li class="active dropdown yamm-fw">
                    <router-link
                      :to="{
                        name: 'welcome',
                      }"
                    >
                      Home
                    </router-link>
                  </li>
                  <li
                    class="dropdown yamm mega-menu"
                    v-for="data_menu in data_menus"
                    :key="data_menu.id"
                  >
                    <a
                      href="home.html"
                      data-hover="dropdown"
                      class="dropdown-toggle"
                      data-toggle="dropdown"
                      >{{ data_menu.category_name }}</a
                    >
                    <ul class="dropdown-menu container">
                      <li>
                        <div class="yamm-content">
                          <div class="row">
                            <div
                              class="col-xs-12 col-sm-6 col-md-2 col-menu"
                              v-for="sub_cat in data_menu.sub_category"
                              :key="sub_cat.id"
                            >
                              <h2 class="title">
                                {{ sub_cat.subcategory_name }}
                              </h2>

                              <ul
                                class="links"
                                v-for="(sub_sub_cat, index) in sub_cat.sub_sub_category"
                                :key="sub_sub_cat.id"
                              >
                                <li
                                  :style="[
                                    index == sub_cat.sub_sub_category.length - 1
                                      ? {
                                          marginBottom: '20px',
                                        }
                                      : {
                                          marginBottom: 0,
                                        },
                                  ]"
                                >
                                  <a href="#">{{ sub_sub_cat.subsubcategory_name }}</a>
                                </li>
                              </ul>
                            </div>
                            <!-- /.col -->

                            <!-- /.yamm-content -->
                          </div>
                        </div>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown navbar-right special-menu">
                    <a href="#">Todays offer</a>
                  </li>
                </ul>
                <!-- /.navbar-nav -->
                <div class="clearfix"></div>
              </div>
              <!-- /.nav-outer -->
            </div>
            <!-- /.navbar-collapse -->
          </div>
          <!-- /.nav-bg-class -->
        </div>
        <!-- /.navbar-default -->
      </div>
      <!-- /.container-class -->
    </div>
    <!-- ============================================== NAVBAR : END ============================================== -->
  </header>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import 'jquery/dist/jquery.js';
import 'bootstrap-hover-dropdown/bootstrap-hover-dropdown.js';
import { BASE_URL } from '@/assets/js/base-url.js';

export default {
  data() {
    return {
      data_menus: [],
      BASE_URL: BASE_URL,
      token: '',
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
      setAlert: 'alert/set',
      addCart: 'cart/add',
      removeCart: 'cart/remove',
      setCart: 'cart/set',
    }),
    showData() {
      if (this.user !== undefined) {
        const token = this.user.token;
        this.token = token;
      }

      this.axios
        .get('api/mega-menu/get-menu-data', {})
        .then((response) => {
          let responseData = response.data;
          this.data_menus = responseData.mega_menu;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          $('.dropdown-toggle').dropdownHover();
        });
    },
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
  watch: {
    // It will reload the request page.
    // $route() {
    //     this.$router.go();
    // },
  },
  created() {
    this.showData();
  },
  mounted() {},
};
</script>

<style>
</style>
