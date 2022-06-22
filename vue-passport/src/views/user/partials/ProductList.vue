<template>
  <section
    class="section latest-blog outer-bottom-vs animation fadeInUp animation-visible"
    data-animation="fadeInUp"
    data-animation-daley="600"
  >
    <h3 class="section-title" style="margin-left: 3px">Products</h3>

    <div class="clearfix filters-container m-t-10">
      <div class="row">
        <!-- /.col -->
        <div class="col col-sm-12 col-md-6">
          <div class="col col-sm-3 col-md-6 no-padding">
            <div class="lbl-cnt">
              <span class="lbl">Sort by</span>
              <div class="fld inline">
                <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                  <button data-toggle="dropdown" type="button" class="btn dropdown-toggle">
                    Position <span class="caret"></span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li role="presentation"><a href="#">position</a></li>
                    <li role="presentation"><a href="#">Price:Lowest first</a></li>
                    <li role="presentation"><a href="#">Price:HIghest first</a></li>
                    <li role="presentation"><a href="#">Product Name:A to Z</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.fld -->
            </div>
            <!-- /.lbl-cnt -->
          </div>
          <!-- /.col -->
          <div class="col col-sm-3 col-md-6 no-padding">
            <div class="lbl-cnt">
              <span class="lbl">Show</span>
              <div class="fld inline">
                <select
                  id="pagination"
                  class="form-control select2bs4 select2-accessible"
                  style="width: 73px"
                  data-select2-id=" 17"
                  tabindex="-1"
                  aria-hidden="true"
                  name="showEntries"
                  v-on:change="showEntries()"
                >
                  <option value="9" data-select2-id="9">9</option>
                  <option value="18" data-select2-id="18">18</option>
                  <option value="36" data-select2-id="36">36</option>
                  <option value="144" data-select2-id="144">144</option>
                  <option value="288" data-select2-id="288">288</option>
                </select>
              </div>
              <!-- /.fld -->
            </div>
            <!-- /.lbl-cnt -->
          </div>
          <!-- /.col -->
        </div>
        <div class="col col-sm-6 col-md-2"></div>
        <!-- /.col -->
        <div class="col col-sm-6 col-md-4 text-right">
          <nav
            aria-label="Page navigation example"
            class="pagination-container float-right"
            style="margin-top: 5px"
          >
            <pagination
              v-model="page"
              :records="totalRecords"
              :per-page="perPage"
              @paginate="searchData"
            />
          </nav>
          <!-- /.pagination-container -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>

    <div class="search-result-container">
      <div id="myTabContent" class="tab-content category-list">
        <div class="tab-pane active" id="grid-container">
          <div class="category-product">
            <!-- start row -->
            <div class="row">
              <div
                class="col-sm-6 col-md-4 wow fadeInUp"
                v-for="product in products"
                :key="product.id"
              >
                <div class="products">
                  <div class="product">
                    <div class="product-image">
                      <div class="image">
                        <a href="detail.html"
                          ><img
                            style="width: 249px; height: 249px"
                            :src="`${BASE_URL}/storage/app/public/products/${
                              Object.values(JSON.parse(product.images)[0])[1]
                            }`"
                            alt=""
                        /></a>
                      </div>
                      <!-- /.image -->

                      <div class="tag new"><span>new</span></div>
                    </div>
                    <!-- /.product-image -->

                    <div class="product-info text-left">
                      <h3 class="name">
                        <router-link
                          :to="{
                            name: 'product-show',
                            params: { id: product.id, slug: product.product_slug },
                          }"
                          target="_blank"
                        >
                          {{ product.product_name.substring(0, 20) + '...' }}
                        </router-link>
                      </h3>
                      <div class="rating rateit-small"></div>
                      <div class="description"></div>
                      <div class="product-price">
                        <span class="price"> Rp.{{ formatNumber(product.price) }} </span>
                        <span class="price-before-discount">$ 800</span>
                      </div>
                      <!-- /.product-price -->
                    </div>
                    <!-- /.product-info -->
                    <div class="cart clearfix animate-effect">
                      <div class="action">
                        <ul class="list-unstyled">
                          <li class="add-cart-button btn-group">
                            <a
                              class="btn btn-primary icon"
                              data-toggle="dropdown"
                              style="margin-right: -1px; margin-top: -0.07px; height: 35px"
                              type="button"
                            >
                              <i class="fa fa-shopping-cart"></i>
                            </a>
                            <button class="btn btn-primary cart-btn" type="button">
                              Add to cart
                            </button>
                          </li>
                          <li class="lnk wishlist">
                            <a class="add-to-cart" href="detail.html" title="Wishlist"> 
                              <i class="icon fa fa-heart"></i>
                            </a>
                          </li>
                          <li class="lnk">
                            <a class="add-to-cart" href="detail.html" title="Compare">
                              <i class="fa fa-signal"></i>
                            </a>
                          </li>
                        </ul>
                      </div>
                      <!-- /.action -->
                    </div>
                    <!-- /.cart -->
                  </div>
                  <!-- /.product -->
                </div>
                <!-- /.products -->
              </div>
              <!-- /.item -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.category-product -->
        </div>
        <!-- /.tab-pane -->
      </div>

      <!-- /.tab-content -->
      <div class="clearfix filters-container">
        <div class="text-right">
          <nav
            aria-label="Page navigation example"
            class="pagination-container float-right"
            style="margin-top: 5px"
          >
            <pagination
              v-model="page"
              :records="totalRecords"
              :per-page="perPage"
              @paginate="searchData"
            />
          </nav>
        </div>
        <!-- /.text-right -->
      </div>
      <!-- /.filters-container -->
    </div>
  </section>
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import { Form } from 'vform';
import { BASE_URL } from '@/assets/js/base-url.js';
import _ from 'lodash';
import swal from 'sweetalert2';

export default {
  name: 'products-index',

  beforeCreate: function () {
    //
  },

  components: {
    //
  },

  // Declare categories (as object), form (as /vform instance) and /isFormCreateSubCategoryMode (as boolean defaulted to 'true') inside /data() { return {} }.
  data() {
    return {
      BASE_URL: BASE_URL,
      page: 1,
      perPage: 0,
      totalRecords: 0,
      from: 0,
      to: 0,
      currentPage: 0,
      search: '',
      trashed: 0,
      products: {},
      form: new Form({
        id: '',
        status: '',
      }),
      imagePreview: null,
      showPreview: false,
      isFormCreateSubCategoryMode: true,
      isInAllData: true,
      loading: false,
      loadingForm: false,
      defaultDataIndexPagination: false,
      defaultShowEntriesPagination: false,
      defaultSearchPagination: false,
      isDataIndexPagination: false,
      isShowEntriesPagination: false,
      isSearchPagination: false,
      detectUpdate: false,
      detectTrash: false,
      detectMultipleTrash: false,
      selectedValues: [],
      total_sub_cat: 0,
      msg: '',
      title: '',
    };
  },

  methods: {
    updateStatus() {
      var self = this;
      $('.status').bootstrapSwitch();
      $('.status').on('switchChange.bootstrapSwitch', function (e) {
        var id = e.target.value;

        if ($(this).is(':checked') === false) {
          self.form.status = 'Inactive';
        } else {
          self.form.status = 'Active';
        }

        let formData = new FormData();
        formData.append('status', self.form.status);
        formData.append('_method', 'PUT');

        self.form
          .put('api/staff/products/update-status/' + id, {
            data: formData,
          })
          .then((response) => {
            console.log(response);
          })
          .catch((err) => {
            console.log(err);
          })
          .finally(() => {
            console.log('Work');
          });
      });
    },

    showSuccessMsg(response) {
      var responseData = response.data;
      this.msg = responseData.message;
      $('#errMsg').fadeIn().delay(2000).fadeOut();

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
        title: this.title,
      });
    },

    closeMsg() {
      $('#errMsg').hide('slow');
    },

    formatNumber(numb) {
      return numb
        .toString()
        .replace(/\D/g, '')
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },

    loadData(response) {
      var responseData = response.data;
      this.products = responseData.products.data;
      this.totalRecords = responseData.products.total;
      this.from = responseData.products.from;
      this.to = responseData.products.to;
      this.currentPage = responseData.products.current_page;
      this.trashed = responseData.total_trashed_products;
      this.perPage = responseData.items;
    },

    loadSpecificPage() {
      if (this.defaultDataIndexPagination === true) {
        this.isDataIndexPagination = true;
        this.showAllDataIndex(this.page);
        console.log(`I am in getCat`);
      } else if (this.defaultShowEntriesPagination === true) {
        this.isShowEntriesPagination = true;
        this.showEntries(this.page);
        console.log(`I am in show entries`);
      } else if (this.defaultSearchPagination === true) {
        this.searchData(); // the page is not defined because we should return it to page 1.
        console.log(`I am in search page`);
      } else {
        this.page = 1;
        this.showAllDataIndex(this.page);
        console.log(`No matching option. So, I am in getCat`);
      }
    },

    determineDefaultPage() {
      // for example if user trash data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
      if (_.isEmpty(this.search) === false) {
        this.defaultSearchPagination = true;
        this.isSearchPagination = true;
        this.defaultDataIndexPagination = false;
        this.defaultShowEntriesPagination = false;
      }
    },

    highlightNewRecords() {
      // Highlight new record if new record exist after submit
      var newRecord = document.getElementById('cat-table');
      var rows = newRecord.rows;
      var totalRows = this.total_sub_cat;
      if (totalRows > 0) {
        for (let i = 0; i < totalRows; i++) {
          var newRow = rows[i + 1];
          $(newRow)
            .toggleClass('highlight')
            .fadeOut(2000, function () {
              $(this).toggleClass('highlight').fadeIn(5);
            });
        }
      }
      this.total_sub_cat = 0;
    },

    highlightChangedRecord() {
      if (this.detectUpdate === true || this.detectTrash === true) {
        $('.data-' + this.form.id)
          .toggleClass('highlight')
          .fadeOut(1500, function () {
            $(this).toggleClass('highlight').fadeIn(1);
          });
      } else if (this.detectMultipleTrash === true) {
        let values = this.selectedValues;
        values.forEach(function (value) {
          $('.data-' + value)
            .toggleClass('highlight')
            .fadeOut(1500, function () {
              $(this).toggleClass('highlight').fadeIn(1);
            });
        });
      }

      this.detectUpdate = false;
      this.detectTrash = false;
      this.detectMultipleTrash = false;
    },

    // /showAllDataIndex() function. Function we use to get user list by calling api/categories method GET.
    showAllDataIndex(page) {
      this.loading = true;
      this.isDataIndexPagination = true;
      this.defaultDataIndexPagination = true;
      this.defaultShowEntriesPagination = false;
      this.defaultSearchPagination = false;
      this.isShowEntriesPagination = false;
      this.isSearchPagination = false;

      // const token = localStorage.getItem('token-staff');

      if (typeof page === 'undefined') {
        page = 1;
      }

      //this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/products/list-products', {
          params: {
            page: page,
          },
        })
        .then((response) => {
          this.loadData(response);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
          // this.highlightNewRecords();
          // this.updateStatus();
        });
    },

    showEntries(page) {
      this.loading = true;
      this.isShowEntriesPagination = true;
      this.defaultShowEntriesPagination = true;
      this.defaultDataIndexPagination = false;
      this.defaultSearchPagination = false;
      this.isDataIndexPagination = false;
      this.isSearchPagination = false;

      var val = $('select[name=showEntries] option').filter(':selected').val();

      if (typeof page === 'undefined') {
        this.page = 1;
      }

      this.axios
        .get('api/products/list-products?items=' + val, {
          params: {
            page: page,
          },
        })
        .then((response) => {
          this.search = '';
          this.loadData(response);
        })
        .catch((error) => {
          console.log(error.response.data);
          swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href>Why do I have this issue?</a>',
          });
        })
        .finally(() => {
          this.loading = false;
          this.highlightNewRecords();
          this.updateStatus();
        });
    },

    searchData: _.debounce(function (page) {
      if (_.isEmpty(this.search)) {
        this.defaultSearchPagination = false;
        this.isSearchPagination = false;
        this.loadSpecificPage();
      } else {
        this.loading = true;

        if (this.defaultDataIndexPagination === true) {
          this.isDataIndexPagination = false;
        } else if (this.defaultShowEntriesPagination === true) {
          this.isShowEntriesPagination = false;
        }

        this.isSearchPagination = true;

        if (typeof page === 'undefined') {
          page = 1;
        }

        this.axios
          .get('api/staff/products/search/' + this.search, {
            params: {
              page: page,
            },
          })
          .then((response) => {
            this.loadData(response);
          })
          .finally(() => {
            this.loading = false;
            this.updateStatus();
          });
      }
    }),
  },

  created() {
    // Call /showAllDataIndex() function initially.
    this.showAllDataIndex();
  },

  mounted() {
    // prevent sweetalert error if user change the route when swal is still visible.
    if (swal.isVisible()) {
      document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
    }
  },
};
</script>

<style>
.VuePagination__count {
  display: none;
}
.pagination {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  padding-left: 0;
  list-style: none;
  border-radius: 0.25rem;
}
.page-link {
  position: relative;
  display: inline;
  padding: 0.5rem 0.75rem;
  margin-left: -1px;
  line-height: 1.25;
  color: #007bff;
  background-color: #fff;
  border: 1px solid #dee2e6;
}
.page-link:hover {
  z-index: 2;
  color: #0056b3;
  text-decoration: none;
  background-color: #e9ecef;
  border-color: #dee2e6;
}
.page-link:focus {
  z-index: 3;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.page-item:first-child .page-link {
  margin-left: 0;
  border-top-left-radius: 0.25rem;
  border-bottom-left-radius: 0.25rem;
}
.page-item:last-child .page-link {
  border-top-right-radius: 0.25rem;
  border-bottom-right-radius: 0.25rem;
}
.page-item.active .page-link {
  z-index: 3;
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}
.page-item.disabled .page-link {
  color: #6c757d;
  pointer-events: none;
  cursor: auto;
  background-color: #fff;
  border-color: #dee2e6;
}
.pagination-lg .page-link {
  padding: 0.75rem 1.5rem;
  font-size: 1.25rem;
  line-height: 1.5;
}
.pagination-lg .page-item:first-child .page-link {
  border-top-left-radius: 0.3rem;
  border-bottom-left-radius: 0.3rem;
}
.pagination-lg .page-item:last-child .page-link {
  border-top-right-radius: 0.3rem;
  border-bottom-right-radius: 0.3rem;
}
.pagination-sm .page-link {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  line-height: 1.5;
}
.pagination-sm .page-item:first-child .page-link {
  border-top-left-radius: 0.2rem;
  border-bottom-left-radius: 0.2rem;
}
.pagination-sm .page-item:last-child .page-link {
  border-top-right-radius: 0.2rem;
  border-bottom-right-radius: 0.2rem;
}
.pagination-month .page-item {
  justify-self: stretch;
}
.pagination-month .page-item .page-link {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-justify-content: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column;
  box-shadow: none;
}
.pagination-month .page-item:first-child .page-link,
.pagination-month .page-item:last-child .page-link {
  height: 100%;
  font-size: 1.25rem;
}
.pagination-month .page-item .page-month {
  margin-bottom: 0;
  font-size: 1.25rem;
  font-weight: 700;
}
.pagination-month .page-item .page-year {
  margin-bottom: 0;
}
.pagination-month.pagination-lg .page-month {
  font-size: 1.5625rem;
}
.pagination-month.pagination-sm .page-month {
  font-size: 1rem;
}
.pagination {
  margin-bottom: -0.3rem;
  margin-top: -0.3rem;
}
</style>
