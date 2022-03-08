<template>
  <Nav />
  <!-- Begin breadcrumb -->
  <div class="breadcrumb">
    <div class="container">
      <div class="breadcrumb-inner">
        <ul class="list-inline list-unstyled">
          <li><a href="#">Home</a></li>
          <li><a href="#">Clothing</a></li>
          <li class="active">Floral Print Buttoned</li>
        </ul>
      </div>
      <!-- /.breadcrumb-inner -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.breadcrumb -->

  <div class="body-content outer-top-xs">
    <div class="container">
      <div class="row single-product">
        <FrontSidebar />
        <div class="col-md-9">
          <!-- Begin photo product, short description product, title product, etc-->
          <div class="detail-block">
            <div class="row wow fadeInUp">
              <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                <div class="product-item-holder size-big single-product-gallery small-gallery">
                  <div id="owl-single-product">
                    <agile class="main" ref="main" :options="options1" :as-nav-for="asNavFor1">
                      <div
                        class="slide"
                        v-for="(slide, index) in slides"
                        :key="index"
                        :class="`slide--${index}`"
                      >
                        <div class="single-product-gallery-item" id="slide1">
                          <div v-if="loadingPict" style="position: absolute; top: 35%; left: 35%">
                            <div class="lds-facebook">
                              <div></div>
                              <div></div>
                              <div></div>
                            </div>
                          </div>
                          <img :src="slide" />
                        </div>
                      </div>
                    </agile>
                  </div>

                  <div class="single-product-gallery-thumbs gallery-thumbs">
                    <agile
                      class="thumbnails"
                      ref="thumbnails"
                      :options="options2"
                      :as-nav-for="asNavFor2"
                    >
                      <div
                        class="slide slide--thumbniail"
                        v-for="(slide, index) in slides"
                        :key="index"
                        :class="`slide--${index}`"
                        @click="$refs.thumbnails.goTo(index)"
                      >
                        <div id="owl-single-product-thumbnails">
                          <div class="item">
                            <img :src="slide" />
                          </div>
                        </div>
                        <!-- /#owl-single-product-thumbnails -->
                      </div>
                      <template v-slot:prevButton><i class="fas fa-chevron-left"></i></template>
                      <template v-slot:nextButton><i class="fas fa-chevron-right"></i></template>
                    </agile>
                  </div>
                  <!-- /.gallery-thumbs -->
                </div>
                <!-- /.single-product-gallery -->
              </div>
              <!-- /.gallery-holder -->

              <div class="col-sm-6 col-md-7 product-info-block">
                <div class="product-info">
                  <h1 v-if="prodCombTitle === ''" class="name">
                    {{ product.product_name }}
                  </h1>
                  <h1 v-else>{{ product.product_name }}, {{ prodCombTitle }}</h1>

                  <div class="rating-reviews m-t-20">
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="rating rateit-small"></div>
                      </div>
                      <div class="col-sm-3">
                        <div class="reviews">
                          <a href="#" class="lnk">(13 Reviews)</a>
                        </div>
                      </div>
                      <div class="col-sm-3">Sold : 500</div>
                      <div class="col-sm-3" v-if="prodCombStock === ''">
                        Stock: {{ product.available_stock }}
                      </div>
                      <div v-else>Stock: {{ prodCombStock }}</div>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.rating-reviews -->

                  <div class="price-container info-container m-t-20">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="price-box">
                          <span v-if="prodCombPrice === ''" class="price"
                            >Rp.{{ product.price.toLocaleString() }}</span
                          >
                          <span v-else class="price">Rp.{{ prodCombPrice.toLocaleString() }}</span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div style="margin-top: 10px">
                          <a
                            class="btn btn-primary"
                            data-toggle="tooltip"
                            data-placement="right"
                            title="Wishlist"
                            href="#"
                          >
                            <i class="fa fa-heart"></i>
                          </a>
                          <a
                            style="margin-left: 10px; margin-right: 10px"
                            class="btn btn-primary"
                            data-toggle="tooltip"
                            data-placement="right"
                            title="Add to Compare"
                            href="#"
                          >
                            <i class="fa fa-share"></i>
                          </a>
                          <a
                            class="btn btn-primary"
                            data-toggle="tooltip"
                            data-placement="right"
                            title="E-mail"
                            href="#"
                          >
                            <i class="fa fa-envelope"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.stock-container -->

                  <div class="description-container m-t-20">
                    {{ product.short_desc }}
                  </div>
                  <!-- /.description-container -->

                  <div
                    v-if="this.product.variants.length === 0"
                    style="border-bottom: 1px solid #f2f2f2; margin-top: 20px"
                  ></div>

                  <div v-else class="price-container info-container m-t-20">
                    <div class="row">
                      <div
                        class="col-sm-5"
                        v-for="variant in this.product.variants"
                        :key="variant.id"
                      >
                        {{ variant.variant_name }}
                        <br />
                        <select
                          class="form-control"
                          :required="true"
                          @change="getSelectVal($event)"
                        >
                          <option value="ajg" disabled selected="true">
                            Select {{ variant.variant_name }}
                          </option>
                          <option
                            v-for="prodVar in variant.variant_options"
                            v-bind:value="prodVar.variant_value_name"
                            v-bind:key="prodVar.id"
                            :data-id="prodVar.product_variant_id"
                          >
                            {{ prodVar.variant_value_name }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.price-container -->

                  <div class="quantity-container info-container">
                    <div class="row">
                      <div class="col-sm-3">
                        <a href="#" class="btn btn-primary">Start Order</a>
                      </div>

                      <div class="col-sm-4">
                        <a href="#" class="btn btn-primary" @click.stop.prevent="buy()"
                          ><i class="fa fa-shopping-cart inner-right-vs"></i>Add To Cart</a
                        >
                      </div>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.quantity-container -->
                </div>
                <!-- /.product-info -->
              </div>
              <!-- /.col-sm-7 -->
            </div>
            <!-- /.row -->
          </div>
          <!-- end photo product, short description product, title product, etc -->

          <!-- Begin long description product -->
          <div class="product-tabs inner-bottom-xs wow fadeInUp">
            <div class="row">
              <div class="col-sm-3">
                <ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
                  <li class="active">
                    <a data-toggle="tab" href="#description">DESCRIPTION</a>
                  </li>
                  <li><a data-toggle="tab" href="#review">REVIEW</a></li>
                  <li><a data-toggle="tab" href="#tags">TAGS</a></li>
                </ul>
                <!-- /.nav-tabs #product-tabs -->
              </div>
              <div class="col-sm-9">
                <div class="tab-content">
                  <div id="description" class="tab-pane in active">
                    <div class="product-tab">
                      <p class="text">
                        <span v-html="`${product.long_desc}`"></span>
                      </p>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div id="review" class="tab-pane">
                    <div class="product-tab">
                      <div class="product-reviews">
                        <h4 class="title">Customer Reviews</h4>

                        <div class="reviews">
                          <div class="review">
                            <div class="review-title">
                              <span class="summary">We love this product</span
                              ><span class="date"
                                ><i class="fa fa-calendar"></i><span>1 days ago</span></span
                              >
                            </div>
                            <div class="text">
                              "Lorem ipsum dolor sit amet, consectetur adipiscing elit.Aliquam
                              suscipit."
                            </div>
                          </div>
                        </div>
                        <!-- /.reviews -->
                      </div>
                      <!-- /.product-reviews -->

                      <div class="product-add-review">
                        <h4 class="title">Write your own review</h4>
                        <div class="review-table">
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th class="cell-label">&nbsp;</th>
                                  <th>1 star</th>
                                  <th>2 stars</th>
                                  <th>3 stars</th>
                                  <th>4 stars</th>
                                  <th>5 stars</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="cell-label">Quality</td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="1" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="2" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="3" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="4" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="5" />
                                  </td>
                                </tr>
                                <tr>
                                  <td class="cell-label">Price</td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="1" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="2" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="3" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="4" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="5" />
                                  </td>
                                </tr>
                                <tr>
                                  <td class="cell-label">Value</td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="1" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="2" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="3" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="4" />
                                  </td>
                                  <td>
                                    <input type="radio" name="quality" class="radio" value="5" />
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <!-- /.table .table-bordered -->
                          </div>
                          <!-- /.table-responsive -->
                        </div>
                        <!-- /.review-table -->

                        <div class="review-form">
                          <div class="form-container">
                            <form role="form" class="cnt-form">
                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="exampleInputName"
                                      >Your Name <span class="astk">*</span></label
                                    >
                                    <input
                                      type="text"
                                      class="form-control txt"
                                      id="exampleInputName"
                                      placeholder=""
                                    />
                                  </div>
                                  <!-- /.form-group -->
                                  <div class="form-group">
                                    <label for="exampleInputSummary"
                                      >Summary <span class="astk">*</span></label
                                    >
                                    <input
                                      type="text"
                                      class="form-control txt"
                                      id="exampleInputSummary"
                                      placeholder=""
                                    />
                                  </div>
                                  <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="exampleInputReview"
                                      >Review <span class="astk">*</span></label
                                    >
                                    <textarea
                                      class="form-control txt txt-review"
                                      id="exampleInputReview"
                                      rows="4"
                                      placeholder=""
                                    ></textarea>
                                  </div>
                                  <!-- /.form-group -->
                                </div>
                              </div>
                              <!-- /.row -->

                              <div class="action text-right">
                                <button class="btn btn-primary btn-upper">SUBMIT REVIEW</button>
                              </div>
                              <!-- /.action -->
                            </form>
                            <!-- /.cnt-form -->
                          </div>
                          <!-- /.form-container -->
                        </div>
                        <!-- /.review-form -->
                      </div>
                      <!-- /.product-add-review -->
                    </div>
                    <!-- /.product-tab -->
                  </div>
                  <!-- /.tab-pane -->

                  <div id="tags" class="tab-pane">
                    <div class="product-tag">
                      <h4 class="title">Product Tags</h4>
                      <form role="form" class="form-inline form-cnt">
                        <div class="form-container">
                          <div class="form-group">
                            <label for="exampleInputTag">Add Your Tags: </label>
                            <input type="email" id="exampleInputTag" class="form-control txt" />
                          </div>

                          <button class="btn btn-upper btn-primary" type="submit">ADD TAGS</button>
                        </div>
                        <!-- /.form-container -->
                      </form>
                      <!-- /.form-cnt -->

                      <form role="form" class="form-inline form-cnt">
                        <div class="form-group">
                          <label>&nbsp;</label>
                          <span class="text col-md-offset-3"
                            >Use spaces to separate tags. Use single quotes (') for phrases.</span
                          >
                        </div>
                      </form>
                      <!-- /.form-cnt -->
                    </div>
                    <!-- /.product-tab -->
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- end long description product -->
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import Nav from '../partials/Nav.vue';
import Footer from '../partials/Footer.vue';
import FrontSidebar from '../partials/FrontSidebar.vue';
import { BASE_URL } from '@/assets/js/base-url.js';
import { VueAgile } from 'vue-agile'; // npm install vue-agile
import { groupBy } from 'lodash';
import { mapGetters, mapActions } from 'vuex';
import swal from 'sweetalert2';

export default {
  beforeCreate: function () {
    document.body.className = 'welcome';
    document.body.classList.remove('login', 'hold-transition', 'sidebar-mini');
    document.body.classList.add('cnt-home');
  },

  components: {
    Nav,
    Footer,
    FrontSidebar,
    agile: VueAgile,
  },

  data() {
    return {
      loadingPict: false,
      selectedData: '1',
      BASE_URL: BASE_URL,
      product: {},
      // begin product photo
      asNavFor1: [],
      asNavFor2: [],
      options1: {
        dots: false,
        fade: true,
        navButtons: false,
      },
      options2: {
        autoplay: true,
        centerMode: true,
        dots: false,
        navButtons: false,
        slidesToShow: 3,
        responsive: [
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 4,
            },
          },

          {
            breakpoint: 1000,
            settings: {
              navButtons: true,
            },
          },
        ],
      },
      slides: [],
      // end product photo
      tempStrings: [],
      tempDataIds: [],
      uniqueStrings: '',
      prodCombTitle: '',
      prodCombPrice: '',
      prodCombStock: '',
      prodComb: [],
    };
  },
  computed: {
    ...mapGetters({
      carts: 'cart/carts',
    }),
  },
  methods: {
    ...mapActions({
      addCart: 'cart/add',
      setAlert: 'alert/set',
    }),
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

      console.log(response);
    },
    showErrMsg(res) {
      swal.fire({
        icon: 'error',
        title: 'Oopss...',
        text: res,
        footer: '<a href>Why do I have this issue?</a>',
      });
    },
    buy() {
      var self = this;
      if (this.product.variants.length > 0 && this.prodComb.length > 0) {
        var prodComb = Object.assign({}, this.prodComb[0]);

        var prodCombInCart = this.carts.filter(function (x) {
          return x.product_key === prodComb[0].product_key;
        }); 

        if (this.prodCombStock > 0) {
          if(prodCombInCart.length === 0) {
            this.addCart(prodComb[0]);
            this.showSuccessMsg('Variant product already added to cart!');
          } else if(prodCombInCart.length > 0) {
            if(prodComb[0].available_stock === prodCombInCart[0].quantity) { 
              this.showErrMsg('Oops... You got all the products!'); 
            } else {
              this.addCart(prodComb[0]);
              this.showSuccessMsg('Variant product already added to cart!');
            }
          }
        } else {
          this.showErrMsg('Oops... product out of stock!');
        }
      } else if (this.product.variants.length === 0 && this.prodComb.length === 0) {
        var prodInCart = this.carts.filter(function (x) {
          return x.product_key == self.product.product_key;
        }); 
        
        if (this.product.available_stock > 0) { // check if the product stock in database is available
          // check if the product inside the cart is available or not
          if(prodInCart.length === 0){ 
            this.addCart(this.product);
            this.showSuccessMsg('Product already added to cart!');
          } 
          else if(prodInCart.length > 0) {
            if(this.product.available_stock === prodInCart[0].quantity) {
              this.showErrMsg('Oops... You got all the products!');
            } else {
              this.addCart(this.product);
              this.showSuccessMsg('Product already added to cart!');
            }
          }
        } else {
          this.showErrMsg('Oops... product out of stock!');
        }
      } else {
        this.showErrMsg('Please select product!');
      }
    },
    showData() {
      this.loadingPict = true;
      let id = this.$route.params.id;
      let slug = this.$route.params.slug;

      this.axios
        .get('/api/product/' + id + '/' + slug, {})
        .then((response) => {
          let responseData = response.data;
          this.product = responseData;
          setTimeout(
            JSON.parse(this.product.images).forEach((data) => {
              this.slides.push(data.downloadUrl);
            }),
            500
          );
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.loadingPict = false;
        });
    },
    getSelectVal(event) {
      if (event.target.value !== 'ajg') {
        this.tempStrings.push(event.target.value);
        var dataId = event.target.options[event.target.options.selectedIndex].dataset.id;
        var asu = [];
        asu.push(dataId);
        this.tempDataIds.push(asu);

        var output = this.tempStrings.map((s, i) => ({
          value: s,
          id: this.tempDataIds[i][0],
        }));

        const groupedById = groupBy(output, (item) => item.id);
        const result = Object.values(groupedById);

        var mergeVal = [];
        result.forEach(function (item) {
          var last_element = item[item.length - 1];
          mergeVal = [...mergeVal, last_element.value];
        });

        const mergeValToStr = new Set([].concat(...mergeVal));
        let dStr = '';
        mergeValToStr.forEach((e) => {
          dStr += e + ' ';
        });
        dStr = dStr.replace(/ /g, ''); // remove space
        // dStr = dStr.replace(/\s+/g, '-'); // replace space with dash
        // dStr = dStr.substr(0, dStr.length - 1); // remove the trailing -
        dStr = dStr.replaceAll('-', '');
        dStr = dStr.toLowerCase();
        dStr = dStr.split('').sort().join('');
        this.uniqueStrings = dStr;
        this.getProdComb();
      }
    },
    getProdComb() {
      this.prodComb = []; // empty the prodComb after the product combination added to cart, so that the next another product combination can be added to the cart
      var self = this;
      this.loadingPict = true;
      var prodComb = this.product.variants_prod.filter(function (x) {
        return x.unique_string_id === self.uniqueStrings;
      });

      if (prodComb.length > 0) {
        this.prodComb.push(prodComb);
        this.slides = [];
        prodComb.forEach(function (item) {
          JSON.parse(item.images).forEach((data) => {
            self.slides.push(data.downloadUrl);
          });
          self.prodCombTitle = item.product_variant;
          self.prodCombPrice = item.price;
          self.prodCombStock = item.available_stock;
          self.loadingPict = false;
        });
        //   if(this.slides.length > 0 && this.slides.length <= 4) {
        //       this.options2.responsive[1].settings.navButtons = false;
        //       //this.options2.autoplay = false;
        //   }
      } else {
        console.log('produk tidak ada');
        this.loadingPict = false;
      }
    },
  },
  created() {
    this.showData();
  },
  mounted() {
    this.asNavFor1.push(this.$refs.thumbnails);
    this.asNavFor2.push(this.$refs.main);
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

/* slider */
.main {
  margin-bottom: 30px;
}

.thumbnails {
  margin: 0 -5px;
  width: calc(110% - 25px);
  margin-top: -20px;
}
.slide {
  align-items: center;
  box-sizing: border-box;
  color: #fff;
  display: flex;
  justify-content: center;
}
.slide--thumbniail {
  cursor: pointer;
  height: 100px;
  padding: 0 5px;
  transition: opacity 0.3s;
}
.slide--thumbniail:hover {
  opacity: 0.75;
}
.slide img {
  height: 100%;
  -o-object-fit: cover;
  object-fit: cover;
  -o-object-position: center;
  object-position: center;
  width: 100%;
}
.agile__nav-button {
  background: transparent;
  border: none;
  color: #ccc;
  cursor: pointer;
  font-size: 24px;
  transition-duration: 0.3s;
}
.thumbnails .agile__nav-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}
.thumbnails .agile__nav-button--prev {
  left: 5px;
}
.thumbnails .agile__nav-button--next {
  right: 12px;
}
.agile__nav-button:hover {
  color: #888;
}
.agile__dot {
  margin: 0 10px;
}
.agile__dot button {
  background-color: #eee;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  display: block;
  height: 10px;
  font-size: 0;
  line-height: 0;
  margin: 0;
  padding: 0;
  transition-duration: 0.3s;
  width: 10px;
}
.agile__dot--current button,
.agile__dot:hover button {
  background-color: #888;
}
</style>
