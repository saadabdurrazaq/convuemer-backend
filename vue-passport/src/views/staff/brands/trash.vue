<template>
  <div class="wrapper">
    <Nav />
    <Sidebar />
    <div class="content-wrapper">
      <!-- Title and breadacrumbs -->
      <Breadcrumbs />
      <!-- End title and breadacrumbs -->
      <div class="content">
        <div style="display: none" id="errMsg" class="box no-border">
          <div class="box-tools">
            <p class="alert alert-success alert-dismissible">
              {{ this.title }}
              <button
                type="button"
                @click.prevent="closeMsg"
                class="close"
                data-hide="alert"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </p>
          </div>
        </div>
        <!-- begin the element -->
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-info">
              <div class="card-body">
                <div class="row" style="margin-top: -20px">
                  <div class="col-md-6">
                    <nav class="navecation">
                      <ul id="navi" style="margin-top: 40px">
                        <li>
                          <router-link :to="{ name: 'brand-management' }" class="menu" href="#"
                            >All ({{ nonTrashed }})</router-link
                          >
                        </li>
                        <li>
                          <router-link
                            :to="{ name: 'brand-management-trash' }"
                            :class="isInAllData ? 'menu current' : 'menu'"
                            href="#"
                            >Trash ({{ trashed }})</router-link
                          >
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
                <hr />

                <div style="float: left; padding-top: 3px; padding-right: 4px">Show</div>
                <div style="width: 73px; float: left; margin-bottom: 7px">
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
                    <option value="5" data-select2-id="19">5</option>
                    <option value="10" data-select2-id="38">10</option>
                    <option value="25" data-select2-id="39">25</option>
                    <option value="50" data-select2-id="40">50</option>
                    <option value="100" data-select2-id="41">100</option>
                    <option value="250" data-select2-id="42">250</option>
                  </select>
                </div>
                <div style="float: left; padding-top: 3px; padding-left: 4px; padding-right: 10px">
                  entries
                </div>
                <div style="float: left; margin-left: 4px">
                  <select
                    class="form-control select2bs4 select2-accessible bulk_actions"
                    style="width: 130px"
                    data-select2-id=" 17"
                    tabindex="-1"
                    aria-hidden="true"
                    v-on:change="bulkActions()"
                  >
                    <option selected="selected" data-select2-id="19">Bulk Actions</option>
                    <option data-select2-id="38" value="restoreMultiple">Restore</option>
                    <option data-select2-id="38" value="deleteMultiple">Delete</option>
                  </select>
                </div>
                <div style="float: right">
                  <form action="">
                    <div class="input-group input-group-sm" style="width: 215px">
                      <input
                        type="text"
                        @keyup="searchBrand"
                        placeholder="Search by name"
                        v-model="search"
                        class="form-control float-right"
                      />
                      <div class="input-group-append">
                        <button type="submit" value="Filter" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="panel-body table-responsive" style="overflow: hidden">
                  <!-- Data-table with pagination for user list. -->
                  <table class="table table-bordered table-hover dataTable">
                    <thead>
                      <tr>
                        <th style="text-align: center">
                          <input type="checkbox" id="select-multiple" @click="selectMultiple()" />
                        </th>
                        <th>No</th>
                        <th>Brand Name</th>
                        <th>Brand Image</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <div v-if="loading" style="position: absolute; top: 50%; left: 50%">
                        <div class="lds-facebook">
                          <div></div>
                          <div></div>
                          <div></div>
                        </div>
                      </div>
                      <!-- Loop through each user record and display user details -->
                      <tr :class="'data-' + brand.id" v-for="brand in brands" :key="brand.id">
                        <td style="text-align: center">
                          <input
                            type="checkbox"
                            id="select"
                            class="sub_chk"
                            :data-id="brand.id"
                            :value="brand.id"
                            name="selected_values[]"
                          />
                        </td>
                        <td class="align-middle">
                          {{ brands.indexOf(brand) + 1 + (currentPage - 1) * perPage }}
                        </td>
                        <td class="align-middle">{{ brand.brand_name }}</td>
                        <td v-if="brand.brand_image" class="align-middle">
                          <img
                            :src="`${BASE_URL}/storage/app/public/brands/${brand.brand_image}`"
                            style="width: 70px; height: 40px"
                          />
                        </td>
                        <td v-if="!brand.brand_image" class="align-middle"></td>
                        <td style="text-align: center; width: 30%">
                          <a
                            class="btn btn-success"
                            style="margin-right: 7px"
                            href=""
                            @click.prevent="restore(brand.id)"
                          >
                            <i class="fa fa-undo"></i> Restore
                          </a>
                          <a class="btn btn-danger" href="" @click.prevent="forceDelete(brand.id)">
                            <i class="fa fa-trash"></i> Delete
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div v-if="isBrandsPagination">
                    <nav style="margin-top: 5px" class="float-left">
                      <p>Showing {{ from }} to {{ to }} of {{ totalRecords }} entries</p>
                    </nav>
                    <nav
                      aria-label="Page navigation example"
                      class="pagination-container float-right"
                      style="margin-top: 5px"
                    >
                      <pagination
                        v-model="page"
                        :records="totalRecords"
                        :per-page="perPage"
                        @paginate="GetBrands"
                      />
                    </nav>
                  </div>
                  <div v-if="isShowEntriesPagination">
                    <nav style="margin-top: 5px" class="float-left">
                      <p>Showing {{ from }} to {{ to }} of {{ totalRecords }} entries</p>
                    </nav>
                    <nav
                      aria-label="Page navigation example"
                      class="pagination-container float-right"
                      style="margin-top: 5px"
                    >
                      <pagination
                        v-model="page"
                        :records="totalRecords"
                        :per-page="perPage"
                        @paginate="showEntries"
                      />
                    </nav>
                  </div>
                  <div v-if="isSearchPagination">
                    <nav style="margin-top: 5px" class="float-left">
                      <p>Showing {{ from }} to {{ to }} of {{ totalRecords }} entries</p>
                    </nav>
                    <nav
                      aria-label="Page navigation example"
                      class="pagination-container float-right"
                      style="margin-top: 5px"
                    >
                      <pagination
                        v-model="page"
                        :records="totalRecords"
                        :per-page="perPage"
                        @paginate="searchBrand"
                      />
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end the element -->
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import 'admin-lte/dist/css/adminlte.min.css'; // conflict with frontend theme
import _ from 'lodash';
import '@/assets/css/custom.css';
import swal from 'sweetalert2';
import Nav from '../partials/Nav.vue';
import Breadcrumbs from '../partials/Breadcrumbs.vue';
import Sidebar from '../partials/Sidebar.vue';
import Footer from '../partials/Footer.vue';
import { Form } from 'vform';
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import { BASE_URL } from '@/assets/js/base-url.js';

export default {
  name: 'brand-management-trash',

  beforeCreate: function () {
    document.body.className = 'home-staff';
  },

  components: {
    Nav,
    Breadcrumbs,
    Sidebar,
    Footer,
  },

  // Declare brands (as object), form (as /vform instance) and /isFormCreateBrandMode (as boolean defaulted to 'true') inside /data() { return {} }.
  data() {
    return {
      BASE_URL: BASE_URL,
      page: 1,
      perPage: 0,
      totalRecords: 0,
      nonTrashed: 0,
      from: 0,
      to: 0,
      currentPage: 0,
      search: '',
      trashed: 0,
      brands: {},
      form: new Form({
        id: '',
        brand_name: '',
        brand_image: null,
      }),
      imagePreview: null,
      showPreview: false,
      isFormCreateBrandMode: true,
      isInAllData: true,
      loading: false,
      loadingForm: false,
      defaultBrandsPagination: false,
      defaultShowEntriesPagination: false,
      defaultSearchPagination: false,
      isBrandsPagination: false,
      isShowEntriesPagination: false,
      isSearchPagination: false,
      title: '',
      msg: '',
      selectedValues: [],
      detectRestore: false,
      detectDelete: false,
      detectMultipleRestore: false,
      detectMultipleDelete: false,
    };
  },

  methods: {
    loadData(response) {
      var responseData = response.data;
      this.brands = responseData.brands.data;
      this.totalRecords = responseData.brands.total;
      this.from = responseData.brands.from;
      this.to = responseData.brands.to;
      this.currentPage = responseData.brands.current_page;
      this.trashed = responseData.total_trashed_brand;
      this.perPage = responseData.items;
      this.nonTrashed = responseData.non_trashed;
    },

    loadSpecificPage() {
      if (this.defaultBrandsPagination === true) {
        this.isBrandsPagination = true;
        this.GetBrands(this.page);
        console.log(`I am in getBrands`);
      } else if (this.defaultShowEntriesPagination === true) {
        this.isShowEntriesPagination = true;
        this.showEntries(this.page);
        console.log(`I am in show entries`);
      } else if (this.defaultSearchPagination === true) {
        this.searchBrand(); // the page is not defined because we should return it to page 1.
        console.log(`I am in search page`);
      } else {
        this.page = 1;
        this.GetBrands(this.page);
        console.log(`No matching option. So, I am in getBrands`);
      }
    },

    determineDefaultPage() {
      // for example if user delete data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
      if (_.isEmpty(this.search) === false) {
        this.defaultSearchPagination = true;
        this.isSearchPagination = true;
        this.defaultBrandsPagination = false;
        this.defaultShowEntriesPagination = false;
      }
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

    highlightChangedRecord() {
      if (this.detectRestore === true || this.detectDelete === true) {
        $('.data-' + this.form.id)
          .toggleClass('highlight')
          .fadeOut(1500, function () {
            $(this).toggleClass('highlight').fadeIn(1);
          });
      } else if (this.detectMultipleRestore === true || this.detectMultipleDelete === true) {
        let values = this.selectedValues;
        values.forEach(function (value) {
          $('.data-' + value)
            .toggleClass('highlight')
            .fadeOut(1500, function () {
              $(this).toggleClass('highlight').fadeIn(1);
            });
        });
      }

      this.detectRestore = false;
      this.detectDelete = false;
      this.detectMultipleRestore = false;
      this.detectMultipleDelete = false;
      this.selectedValues = [];
    },

    // /GetBrands() function. Function we use to get user list by calling api/brands method GET.
    GetBrands(page) {
      this.loading = true;
      this.isBrandsPagination = true;
      this.defaultBrandsPagination = true;
      this.defaultShowEntriesPagination = false;
      this.isShowEntriesPagination = false;
      this.defaultSearchPagination = false;
      this.isSearchPagination = false;

      const token = localStorage.getItem('token-staff');

      if (typeof page === 'undefined') {
        page = 1;
      }

      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/brand-management/trash', {
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
        });
    },

    showEntries(page) {
      this.loading = true;
      this.isShowEntriesPagination = true;
      this.defaultShowEntriesPagination = true;
      this.defaultBrandsPagination = false;
      this.isBrandsPagination = false;
      this.defaultSearchPagination = false;
      this.isSearchPagination = false;

      var val = $('select[name=showEntries] option').filter(':selected').val();

      if (typeof page === 'undefined') {
        this.page = 1;
      }

      this.axios
        .get('api/staff/brand-management/trash?items=' + val, {
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
        });
    },

    searchBrand: _.debounce(function (page) {
      if (_.isEmpty(this.search)) {
        this.defaultSearchPagination = false;
        this.isSearchPagination = false;
        this.loadSpecificPage();
      } else {
        this.loading = true;

        if (this.defaultBrandsPagination === true) {
          this.isBrandsPagination = false;
        } else if (this.defaultShowEntriesPagination === true) {
          this.isShowEntriesPagination = false;
        }

        this.isSearchPagination = true;

        if (typeof page === 'undefined') {
          this.page = 1;
        }

        this.axios
          .get('api/staff/brand-management/trash/search/' + this.search, {
            params: {
              page: page,
            },
          })
          .then((response) => {
            this.loadData(response);
          })
          .finally(() => {
            this.loading = false;
          });
      }
    }),

    restore(id) {
      this.form.id = id;

      swal
        .fire({
          title: 'Are you sure?',
          text: 'You still be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, restore it!',
        })
        .then((result) => {
          // confirm delete?
          if (result.value) {
            // request delete
            this.form
              .get('api/staff/brand-management/restore/' + id, {})
              .then((response) => {
                this.detectRestore = true;
                this.highlightChangedRecord();
                this.determineDefaultPage();
                this.loadSpecificPage();
                this.title = 'Brand restored successfully!';
                this.showSuccessMsg(response);
              })
              .catch(() => {
                // sweet alert fail
                swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!',
                  footer: '<a href>Why do I have this issue?</a>',
                });
              });
          }
        });
    },

    // /forceDelete() function. Function we use to delete user record by calling api/brands/{id} method DELETE.
    forceDelete(id) {
      this.form.id = id;

      swal
        .fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
        })
        .then((result) => {
          // confirm delete?
          if (result.value) {
            // request delete
            this.form
              .delete('api/staff/brand-management/force-delete/' + id, {})
              .then((response) => {
                this.detectDelete = true;
                this.highlightChangedRecord();
                this.determineDefaultPage();
                this.loadSpecificPage();
                this.title = 'Brand deleted successfully!';
                this.showSuccessMsg(response);
              })
              .catch(() => {
                // sweet alert fail
                swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!',
                  footer: '<a href>Why do I have this issue?</a>',
                });
              });
          }
        });
    },

    selectMultiple() {
      var checked = $('#select-multiple').is(':checked', true);
      if (checked) {
        $('.sub_chk').prop('checked', true);
      } else {
        $('.sub_chk').prop('checked', false);
      }
    },

    bulkActions() {
      if ($('.bulk_actions').val() == 'deleteMultiple') {
        var allVals = [];
        $('.sub_chk:checked').each(function () {
          allVals.push($(this).attr('data-id'));
        });

        this.selectedValues = allVals;

        if (allVals.length <= 0) {
          alert('Please select row.');
        } else {
          swal
            .fire({
              title: 'Are you sure?',
              text: 'You wont be able to revert this!',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!',
            })
            .then((result) => {
              if (result.isConfirmed) {
                var join_selected_values = allVals.join(',');
                this.axios
                  .get(
                    'api/staff/brand-management/force-delete-multiple/ids=' + join_selected_values
                  )
                  .then((response) => {
                    this.detectMultipleDelete = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Brand/s has been deleted successfully!';
                    this.showSuccessMsg(response);
                  })
                  .catch((error) => {
                    console.log(error.response.data);
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong!',
                      footer: '<a href>Why do I have this issue?</a>',
                    });
                  });
              } else {
                swal.fire('Cancelled', 'Your data is safe :)', 'error');
              }
            });
        }
      } else if ($('.bulk_actions').val() == 'restoreMultiple') {
        var multipleVals = [];
        $('.sub_chk:checked').each(function () {
          multipleVals.push($(this).attr('data-id'));
        });

        this.selectedValues = multipleVals;

        if (multipleVals.length <= 0) {
          alert('Please select row.');
        } else {
          swal
            .fire({
              title: 'Are you sure?',
              text: 'You still can revert this!',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, restore it!',
            })
            .then((result) => {
              if (result.isConfirmed) {
                var multipleRestoredIds = multipleVals.join(',');
                this.axios
                  .get('api/staff/brand-management/restore-multiple/ids=' + multipleRestoredIds)
                  .then((response) => {
                    this.detectMultipleRestore = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Brand/s has been restored successfully!';
                    this.showSuccessMsg(response);
                  })
                  .catch((error) => {
                    console.log(error.response.data);
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong!',
                      footer: '<a href>Why do I have this issue?</a>',
                    });
                  });
              } else {
                swal.fire('Cancelled', 'Your data is safe :)', 'error');
              }
            });
        }
      }
    },
  },

  created() {
    // Call /GetBrands() function initially.
    this.GetBrands();
  },

  mounted() {
    console.log('Component mounted.');
    // prevent sweetalert error if user change the route when swal is still visible.
    if (swal.isVisible()) {
      document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
    }
  },
};
</script>

<style type="scss">
.highlight {
  background: #fff2e1;
}
.pagination-container {
  height: 75px;
  display: grid;
}
.pagination {
  margin: auto !important;
}
</style>
