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
                  <div class="col-md-4">
                    <nav class="navecation">
                      <ul id="navi" style="margin-top: 40px">
                        <li>
                          <router-link
                            :to="{ name: 'sub-categories' }"
                            :class="isInAllData ? 'menu current' : 'menu'"
                            href="#"
                            >All ({{ totalRecords }})</router-link
                          >
                        </li>
                        <li>
                          <router-link :to="{ name: 'sub-categories-trash' }" class="menu" href="#"
                            >Trash ({{ trashed }})</router-link
                          >
                        </li>
                      </ul>
                    </nav>
                  </div>
                  <div class="col-md-8 text-right">
                    <button
                      type="submit"
                      class="btn btn-success"
                      data-toggle="modal"
                      style="margin-top: 25px; margin-right: 7px"
                      data-target="#exampleModal"
                      @click.prevent="showModalCreate"
                    >
                      <i class="fas fa-plus"></i> Add New Sub Categories
                    </button>
                    <router-link
                      :to="{ name: 'categories' }"
                      type="submit"
                      class="btn btn-primary"
                      style="margin-top: 25px; margin-right: 7px"
                      ><i class="fas fa-list"></i> List of Categories</router-link
                    >
                    <router-link
                      :to="{ name: 'sub-sub-categories' }"
                      type="submit"
                      class="btn btn-primary"
                      style="margin-top: 25px; margin-right: 7px"
                      ><i class="fas fa-list"></i> List of Sub Sub Categories</router-link
                    >
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
                    class="form-control select2bs4 select2-accessible trash_multiple"
                    style="width: 130px"
                    data-select2-id=" 17"
                    tabindex="-1"
                    aria-hidden="true"
                    v-on:change="bulkActions()"
                  >
                    <option selected="selected" data-select2-id="19">Bulk Actions</option>
                    <option data-select2-id="38" value="trashMultiple">Trash</option>
                  </select>
                </div>
                <div style="float: right">
                  <form action="">
                    <div class="input-group input-group-sm" style="width: 215px">
                      <input
                        type="text"
                        @keyup="searchSubCategory"
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
                  <table class="table table-bordered table-hover dataTable" id="cat-table">
                    <thead>
                      <tr>
                        <th style="text-align: center">
                          <input type="checkbox" id="select-multiple" @click="selectMultiple()" />
                        </th>
                        <th>No</th>
                        <th>Sub Categories Name</th>
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
                      <tr
                        :class="'data-' + sub_category.id"
                        v-for="sub_category in sub_categories"
                        :key="sub_category.id"
                      >
                        <td style="text-align: center">
                          <input
                            type="checkbox"
                            id="select"
                            class="sub_chk"
                            :data-id="sub_category.id"
                            :value="sub_category.id"
                            name="selected_values[]"
                          />
                        </td>
                        <td class="align-middle">
                          {{
                            sub_categories.indexOf(sub_category) + 1 + (currentPage - 1) * perPage
                          }}
                        </td>
                        <td class="align-middle">
                          {{ sub_category.subcategory_name }}
                        </td>
                        <td style="text-align: center; width: 30%">
                          <a
                            class="btn btn-info"
                            style="margin-right: 7px"
                            href=""
                            @click.prevent="showModalEdit(sub_category)"
                          >
                            <i class="fa fa-edit"></i> Edit
                          </a>
                          <button
                            :disabled="deleteSubCategoryPermission === null"
                            class="btn btn-warning"
                            href=""
                            @click.prevent="softDelete(sub_category.id)"
                          >
                            <i class="fa fa-trash"></i> Trash
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div v-if="isSubCatPagination">
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
                        @paginate="GetSubCategories"
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
                        @paginate="searchSubCategory"
                      />
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal containing dynamic form for adding/updating user details. -->
          <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <!-- Show/hide headings dynamically based on /isFormCreateSubCategoryMode value (true/false) -->
                  <h5
                    v-show="isFormCreateSubCategoryMode"
                    class="modal-title"
                    id="exampleModalLabel"
                  >
                    Add new sub category
                  </h5>
                  <h5
                    v-show="!isFormCreateSubCategoryMode"
                    class="modal-title"
                    id="exampleModalLabel"
                  >
                    Update category
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>

                <!-- Form for adding/updating user details. When submitted call /createSubCategories() function if /isFormCreateSubCategoryMode value is true. Otherwise call /updateSubCategory() function. -->
                <form
                  @submit.prevent="
                    isFormCreateSubCategoryMode ? createSubCategories() : updateSubCategory()
                  "
                >
                  <div class="modal-body">
                    <div
                      class="alert alert-danger alert-dismissible fade show"
                      role="alert"
                      style="display: none"
                    >
                      <button
                        type="button"
                        @click.prevent="closeMsg"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div v-if="loadingForm" style="position: absolute; top: 20%; left: 40%">
                      <div class="lds-facebook">
                        <div></div>
                        <div></div>
                        <div></div>
                      </div>
                    </div>
                    <div v-show="isFormCreateSubCategoryMode" class="form-group">
                      <input
                        type="text"
                        placeholder="Sub Category Name"
                        v-bind:name="form.subcategory_name"
                        id="subcategory_name"
                        class="form-control"
                        :class="{
                          'is-invalid': form.errors.has('subcategory_name'),
                        }"
                      />
                      <small class="text-muted"
                        >End with a comma for single or multiple inputs. E.g: data1, data2,</small
                      >
                      <div
                        style="color: red"
                        v-if="form.errors.has('subcategory_name')"
                        v-html="form.errors.get('subcategory_name')"
                      />
                    </div>
                    <div v-show="!isFormCreateSubCategoryMode" class="form-group">
                      <input
                        v-model="form.subcategory_name"
                        type="text"
                        name="name"
                        placeholder="Sub Category Name"
                        class="form-control"
                        :class="{
                          'is-invalid': form.errors.has('subcategory_name'),
                        }"
                      />
                      <div
                        style="color: red"
                        v-if="form.errors.has('subcategory_name')"
                        v-html="form.errors.get('subcategory_name')"
                      />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      Close
                    </button>
                    <button
                      type="submit"
                      :disabled="createSubCategoryPermission === null"
                      v-on:click="getSubCategoriesInput()"
                      class="btn btn-primary"
                      v-show="isFormCreateSubCategoryMode"
                    >
                      Save changes
                    </button>
                    <button
                      type="submit"
                      :disabled="updateSubCategoryPermission === null"
                      class="btn btn-primary"
                      v-show="!isFormCreateSubCategoryMode"
                    >
                      Update
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- end modal -->
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
import '@/assets/js/bootstrap-tokenfield.js'; // another related file found index.html

export default {
  name: 'sub-categories',

  beforeCreate: function () {
    document.body.className = 'home-staff';
  },

  components: {
    Nav,
    Breadcrumbs,
    Sidebar,
    Footer,
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
      sub_categories: {},
      form: new Form({
        id: '',
        subcategory_name: '',
      }),
      imagePreview: null,
      showPreview: false,
      isFormCreateSubCategoryMode: true,
      isInAllData: true,
      loading: false,
      loadingForm: false,
      defaultSubCatPagination: false,
      defaultShowEntriesPagination: false,
      defaultSearchPagination: false,
      isSubCatPagination: false,
      isShowEntriesPagination: false,
      isSearchPagination: false,
      detectUpdate: false,
      detectTrash: false,
      detectMultipleTrash: false,
      selectedValues: [],
      total_sub_cat: 0,
      msg: '',
      title: '',
      createSubCategoryPermission: null,
      updateSubCategoryPermission: null,
      deleteSubCategoryPermission: null,
    };
  },

  methods: {
    getSubCategoriesInput() {
      this.form.subcategory_name = $('#subcategory_name').val();
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

    loadData(response) {
      var responseData = response.data;
      this.sub_categories = responseData.sub_categories.data;
      this.totalRecords = responseData.sub_categories.total;
      this.from = responseData.sub_categories.from;
      this.to = responseData.sub_categories.to;
      this.currentPage = responseData.sub_categories.current_page;
      this.trashed = responseData.total_trashed_sub_categories;
      this.perPage = responseData.items;
    },

    loadSpecificPage() {
      if (this.defaultSubCatPagination === true) {
        this.isSubCatPagination = true;
        this.GetSubCategories(this.page);
        console.log(`I am in getCat`);
      } else if (this.defaultShowEntriesPagination === true) {
        this.isShowEntriesPagination = true;
        this.showEntries(this.page);
        console.log(`I am in show entries`);
      } else if (this.defaultSearchPagination === true) {
        this.searchSubCategory(); // the page is not defined because we should return it to page 1.
        console.log(`I am in search page`);
      } else {
        this.page = 1;
        this.GetSubCategories(this.page);
        console.log(`No matching option. So, I am in getCat`);
      }
    },

    determineDefaultPage() {
      // for example if user trash data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
      if (_.isEmpty(this.search) === false) {
        this.defaultSearchPagination = true;
        this.isSearchPagination = true;
        this.defaultSubCatPagination = false;
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

    // /GetSubCategories() function. Function we use to get user list by calling api/categories method GET.
    GetSubCategories(page) {
      this.loading = true;
      this.isSubCatPagination = true;
      this.defaultSubCatPagination = true;
      this.defaultShowEntriesPagination = false;
      this.defaultSearchPagination = false;
      this.isShowEntriesPagination = false;
      this.isSearchPagination = false;

      const token = localStorage.getItem('token-staff');

      if (typeof page === 'undefined') {
        page = 1;
      }

      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/sub-categories', {
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
          this.highlightNewRecords();
          this.checkPermissions('Create Sub Category');
          this.checkPermissions('Update Sub Category');
          this.checkPermissions('Delete Sub Category');
        });
    },

    checkPermissions(permissionName) {
      const token = localStorage.getItem('token-staff');
      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/roles/permissions/' + permissionName)
        .then((response) => {
          if (permissionName === 'Create Sub Category') {
            this.createSubCategoryPermission = response.data.staff;
          }

          if (permissionName === 'Update Sub Category') {
            this.updateSubCategoryPermission = response.data.staff;
          }

          if (permissionName === 'Delete Sub Category') {
            this.deleteSubCategoryPermission = response.data.staff;
          }
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          //
        });
    },

    showEntries(page) {
      this.loading = true;
      this.isShowEntriesPagination = true;
      this.defaultShowEntriesPagination = true;
      this.defaultSubCatPagination = false;
      this.defaultSearchPagination = false;
      this.isSubCatPagination = false;
      this.isSearchPagination = false;

      var val = $('select[name=showEntries] option').filter(':selected').val();

      if (typeof page === 'undefined') {
        this.page = 1;
      }

      this.axios
        .get('api/staff/sub-categories?items=' + val, {
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
        });
    },

    searchSubCategory: _.debounce(function (page) {
      if (_.isEmpty(this.search)) {
        this.defaultSearchPagination = false;
        this.isSearchPagination = false;
        this.loadSpecificPage();
      } else {
        this.loading = true;

        if (this.defaultSubCatPagination === true) {
          this.isSubCatPagination = false;
        } else if (this.defaultShowEntriesPagination === true) {
          this.isShowEntriesPagination = false;
        }

        this.isSearchPagination = true;

        if (typeof page === 'undefined') {
          page = 1;
        }

        this.axios
          .get('api/staff/sub-categories/search/' + this.search, {
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

    // /showModalCreate() function. Function we use to 1. Set /isFormCreateSubCategoryMode to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating user details.
    showModalCreate() {
      this.isFormCreateSubCategoryMode = true;
      this.form.reset(); // v form reset
      $('#exampleModal').on('shown.bs.modal', function () {
        $('.modal').css('display', 'block');
      });
    },

    // /createSubCategories() function. Function we use to store user details by calling api/categories method POST (carrying form input data).
    createSubCategories() {
      this.loadingForm = true;

      $('#subcategory_name').tokenfield('setTokens', []);

      let formData = new FormData();
      formData.append('subcategory_name', this.form.subcategory_name);

      // request post
      this.form
        .post('api/staff/sub-categories', formData)
        .then((response) => {
          var responseData = response.data;
          this.total_sub_cat = responseData.total_sub_cat;

          $('#exampleModal').modal('hide'); // hide modal
          $('.modal-backdrop').remove();

          this.page = 1;
          this.determineDefaultPage();
          this.loadSpecificPage();
          this.title = 'Sub category/ies created successfully!';
          this.showSuccessMsg(response);
        })
        .catch((error) => {
          // sweet alert fail
          console.log(error);
        })
        .finally(() => {
          this.loadingForm = false;
        });
    },

    // /editUser() function. Function we use to 1. Set /isFormCreateSubCategoryMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating user details, 4. Fill form with user details.
    showModalEdit(sub_category) {
      this.isFormCreateSubCategoryMode = false;
      this.form.reset(); // v form reset inputs
      this.form.clear(); // v form clear errors
      $('#exampleModal').modal('show'); // show modal
      this.form.fill(sub_category);
      console.log(sub_category); // object
      console.log(this.form);
    },

    // /updateSubCategory() function. Function we use to update user details by calling api/categories/{id} method PUT (carrying form input data).
    updateSubCategory() {
      this.loadingForm = true;
      // request put
      this.form
        .put('api/staff/sub-categories/update/' + this.form.id, {})
        .then((response) => {
          $('#exampleModal').modal('hide'); // hide modal
          this.detectUpdate = true;
          this.highlightChangedRecord();
          this.determineDefaultPage();
          this.loadSpecificPage();
          this.title = 'Sub category updated successfully!';
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
        })
        .finally(() => {
          this.loadingForm = false;
        });
    },

    // /softDelete() function. Function we use to delete user record by calling api/categories/{id} method DELETE.
    softDelete(id) {
      this.form.id = id;
      // sweet alert confirmation
      swal
        .fire({
          title: 'Are you sure?',
          text: 'You still be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, trash it!',
        })
        .then((result) => {
          // confirm delete?
          if (result.value) {
            // request delete
            this.form
              .delete('api/staff/sub-categories/soft-delete/' + id, {})
              .then((response) => {
                this.detectTrash = true;
                this.highlightChangedRecord();
                this.determineDefaultPage();
                this.loadSpecificPage();
                this.title = 'Sub category has been trashed successfully!';
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
      if ($('.trash_multiple').val() == 'trashMultiple') {
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
              text: 'You still can revert this!',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, trash it!',
            })
            .then((result) => {
              if (result.isConfirmed) {
                var join_selected_values = allVals.join(',');
                this.axios
                  .get('api/staff/sub-categories/soft-delete-multiple/ids=' + join_selected_values)
                  .then((response) => {
                    this.detectMultipleTrash = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Sub category/ies has been trashed successfully!';
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
    // Call /GetSubCategories() function initially.
    this.GetSubCategories();
  },

  mounted() {
    console.log('Component mounted.');

    // prevent sweetalert error if user change the route when swal is still visible.
    if (swal.isVisible()) {
      document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
    }

    $('#subcategory_name').tokenfield({
      showAutocompleteOnFocus: false,
    });
  },
};
</script>

<style type="scss">
body {
  padding-right: 0 !important;
}
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
