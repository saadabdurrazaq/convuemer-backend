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
                          <router-link
                            :to="{ name: 'staff-management' }"
                            :class="isInAllData ? 'menu current' : 'menu'"
                            href="#"
                            >All ({{ totalRecords }})</router-link
                          >
                        </li>
                        <li>
                          <a class="menu" href="#">Trash ({{ trashed }})</a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                  <div class="col-md-6 text-right">
                    <button
                      type="submit"
                      class="btn btn-primary"
                      data-toggle="modal"
                      style="margin-top: 25px"
                      data-target="#exampleModal"
                      @click.prevent="showModal"
                    >
                      <i class="fas fa-user-plus"></i> Add new user
                    </button>
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
                    v-on:change="deleteMultiple()"
                  >
                    <option selected="selected" data-select2-id="19">Bulk Actions</option>
                    <option data-select2-id="38" value="trashMultiple">Trash</option>
                  </select>
                </div>
                <div style="float: left; margin-left: 20px">
                  <select
                    v-on:change="exportFiles()"
                    class="form-control select2bs4 select2-hidden-accessible export-files"
                    style="width: 115px"
                    data-select2-id=" 17"
                    tabindex="-1"
                    aria-hidden="true"
                  >
                    <option selected="selected" data-select2-id="19" value="">Download</option>
                    <option data-select2-id="38" value="PDF">PDF</option>
                    <option data-select2-id="39" value="XLS">XLS</option>
                    <option data-select2-id="39" value="Doc">Doc</option>
                  </select>
                </div>
                <div style="float: right">
                  <form action="">
                    <div class="input-group input-group-sm" style="width: 215px">
                      <input
                        type="text"
                        @keyup="searchStaff"
                        placeholder="Search by name or email"
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
                        <th>Name</th>
                        <th>Email</th>
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
                      <tr :class="'data-' + user.id" v-for="user in users" :key="user.id">
                        <td style="text-align: center">
                          <input
                            type="checkbox"
                            id="select"
                            class="sub_chk"
                            :data-id="user.id"
                            :value="user.id"
                            name="selected_values[]"
                          />
                        </td>
                        <td class="align-middle">
                          {{ users.indexOf(user) + 1 + (currentPage - 1) * perPage }}
                        </td>
                        <td class="align-middle">{{ user.name }}</td>
                        <td class="align-middle">{{ user.email }}</td>
                        <td style="text-align: center; width: 30%">
                          <a class="btn btn-primary" style="margin-right: 7px" href="#">
                            <i class="fa fa-info"></i> Detail
                          </a>
                          <a
                            class="btn btn-info"
                            style="margin-right: 7px"
                            href=""
                            @click.prevent="editUser(user)"
                          >
                            <i class="fa fa-edit"></i> Edit
                          </a>
                          <a class="btn btn-danger" href="" @click.prevent="deleteUser(user.id)">
                            <i class="fa fa-trash"></i> Delete
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div v-if="isUsersPagination">
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
                        @paginate="getUsers"
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
                        @paginate="searchStaff"
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
                  <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
                  <h5 v-show="isFormCreateUserMode" class="modal-title" id="exampleModalLabel">
                    Add new user
                  </h5>
                  <h5 v-show="!isFormCreateUserMode" class="modal-title" id="exampleModalLabel">
                    Update user
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>

                <!-- Form for adding/updating user details. When submitted call /createUser() function if /isFormCreateUserMode value is true. Otherwise call /updateUser() function. -->
                <form @submit.prevent="isFormCreateUserMode ? createUser() : updateUser()">
                  <div class="modal-body">
                    <div v-if="loadingForm" style="position: absolute; top: 20%; left: 40%">
                      <div class="lds-facebook">
                        <div></div>
                        <div></div>
                        <div></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input
                        v-model="form.name"
                        type="text"
                        name="name"
                        placeholder="Name"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                      />
                      <div
                        style="color: red"
                        v-if="form.errors.has('name')"
                        v-html="form.errors.get('name')"
                      />
                    </div>
                    <div class="form-group">
                      <input
                        v-model="form.email"
                        type="email"
                        name="name"
                        placeholder="Email"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <div
                        style="color: red"
                        v-if="form.errors.has('email')"
                        v-html="form.errors.get('email')"
                      />
                    </div>
                    <div class="form-group">
                      <input
                        v-show="isFormCreateUserMode"
                        v-model="form.password"
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                      />
                      <div
                        style="color: red"
                        v-if="form.errors.has('password')"
                        v-html="form.errors.get('password')"
                      />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      Close
                    </button>
                    <button type="submit" class="btn btn-primary" v-show="isFormCreateUserMode">
                      Save changes
                    </button>
                    <button type="submit" class="btn btn-primary" v-show="!isFormCreateUserMode">
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
import Nav from './partials/Nav.vue';
import Breadcrumbs from './partials/Breadcrumbs.vue';
import Sidebar from './partials/Sidebar.vue';
import Footer from './partials/Footer.vue';
import { Form } from 'vform';
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;

export default {
  name: 'staff-management',

  beforeCreate: function () {
    document.body.className = 'home-staff';
  },

  components: {
    Nav,
    Breadcrumbs,
    Sidebar,
    Footer,
  },

  // Declare users (as object), form (as /vform instance) and /isFormCreateUserMode (as boolean defaulted to 'true') inside /data() { return {} }.
  data() {
    return {
      page: 1,
      perPage: 0,
      totalRecords: 0,
      from: 0,
      to: 0,
      currentPage: 0,
      search: '',
      trashed: 0,
      users: {},
      form: new Form({
        id: '',
        name: '',
        email: '',
        password: '',
      }),
      msg: '',
      title: '',
      isFormCreateUserMode: true,
      isInAllData: true,
      loading: false,
      loadingForm: false,
      defaultUsersPagination: false,
      defaultShowEntriesPagination: false,
      defaultSearchPagination: false,
      isShowEntriesPagination: false,
      isUsersPagination: false,
      isSearchPagination: false,
      detectUpdate: false,
      detectTrash: false,
      detectMultipleTrash: false,
      detectNewRecord: false,
      selectedValues: [],
    };
  },

  methods: {
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
      this.users = responseData.staffs.data;
      this.totalRecords = responseData.staffs.total;
      this.from = responseData.staffs.from;
      this.to = responseData.staffs.to;
      this.currentPage = responseData.staffs.current_page;
      this.trashed = responseData.total_trashed_staff;
      this.perPage = responseData.items;
    },

    loadSpecificPage() {
      if (this.defaultUsersPagination === true) {
        this.isUsersPagination = true;
        this.getUsers(this.page);
        console.log(`I am in getUsers`);
      } else if (this.defaultShowEntriesPagination === true) {
        this.isShowEntriesPagination = true;
        this.showEntries(this.page);
        console.log(`I am in show entries`);
      } else if (this.defaultSearchPagination === true) {
        this.searchStaff(); // the page is not defined because we should return it to page 1.
        console.log(`I am in search page`);
      } else {
        this.page = 1;
        this.getUsers(this.page);
        console.log(`No matching option. So, I am in getUsers`);
      }
    },

    determineDefaultPage() {
      // for example if user trash data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
      if (_.isEmpty(this.search) === false) {
        this.defaultSearchPagination = true;
        this.isSearchPagination = true;
        this.defaultUsersPagination = false;
        this.defaultShowEntriesPagination = false;
      }
    },

    highlightNewRecords() {
      // Highlight new record if new record exist after submit
      var newRecord = document.getElementById('cat-table');
      var rows = newRecord.rows;

      if (this.detectNewRecord === true) {
        var newRow = rows[0 + 1];
        $(newRow)
          .toggleClass('highlight')
          .fadeOut(2000, function () {
            $(this).toggleClass('highlight').fadeIn(5);
          });
      }

      this.detectNewRecord = false; 
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

    // /getUsers() function. Function we use to get user list by calling api/users method GET.
    getUsers(page) {
      this.loading = true;
      this.isUsersPagination = true;
      this.defaultUsersPagination = true;
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
        .get('api/staff/staff-management', {
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
        });
    },

    showEntries(page) {
      this.loading = true;
      this.isShowEntriesPagination = true;
      this.defaultShowEntriesPagination = true;
      this.defaultUsersPagination = false;
      this.defaultSearchPagination = false;
      this.isUsersPagination = false;
      this.isSearchPagination = false;

      var val = $('select[name=showEntries] option').filter(':selected').val();

      if (typeof page === 'undefined') {
        this.page = 1;
      }

      this.axios
        .get('api/staff/staff-management?items=' + val, {
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

    searchStaff: _.debounce(function (page) {
      if (_.isEmpty(this.search)) {
        this.defaultSearchPagination = false;
        this.isSearchPagination = false;
        this.loadSpecificPage();
      } else {
        this.loading = true;

        if (this.defaultUsersPagination === true) {
          this.isUsersPagination = false;
        } else if (this.defaultShowEntriesPagination === true) {
          this.isShowEntriesPagination = false;
        }

        this.isSearchPagination = true;

        if (typeof page === 'undefined') {
          page = 1;
        }

        this.axios
          .get('api/staff/staff-management/search/' + this.search, {
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

    exportFiles() {
      this.loading = true;

      if ($('.export-files').val() == 'PDF') {
        this.axios
          .get('api/staff/staff-management/download-pdf', {
            responseType: 'blob',
            Accept: 'application/pdf',
          })
          .then((response) => {
            const url = window.URL.createObjectURL(
              new Blob([response.data], { type: 'application/pdf' })
            );
            const link = document.createElement('a');
            console.log(link);
            link.href = url;
            link.setAttribute('download', 'staffs.pdf'); //or any other extension
            document.body.appendChild(link);
            link.click();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.loading = false;
          });
      } else if ($('.export-files').val() == 'XLS') {
        this.axios
          .get('api/staff/staff-management/download-excel', {
            responseType: 'blob',
            Accept: 'application/pdf',
          })
          .then((response) => {
            const url = window.URL.createObjectURL(
              new Blob([response.data], { type: 'application/pdf' })
            );
            const link = document.createElement('a');
            console.log(link);
            link.href = url;
            link.setAttribute('download', 'staffs.xlsx'); //or any other extension
            document.body.appendChild(link);
            link.click();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.loading = false;
          });
      } else if ($('.export-files').val() == 'Doc') {
        this.axios
          .get('api/staff/staff-management/download-word', {
            responseType: 'blob',
            Accept: 'application/pdf',
          })
          .then((response) => {
            const url = window.URL.createObjectURL(
              new Blob([response.data], { type: 'application/pdf' })
            );
            const link = document.createElement('a');
            console.log(link);
            link.href = url;
            link.setAttribute('download', 'staffs.doc'); //or any other extension
            document.body.appendChild(link);
            link.click();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.loading = false;
          });
      } else {
        this.loading = false;
      }
    },

    // /showModal() function. Function we use to 1. Set /isFormCreateUserMode to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating user details.
    showModal() {
      this.isFormCreateUserMode = true;
      this.form.reset(); // v form reset
      $('#exampleModal').modal('show'); // show modal
    },

    // /createUser() function. Function we use to store user details by calling api/users method POST (carrying form input data).
    createUser() {
      this.loadingForm = true;

      this.form
        .post('api/staff/staff-management', {})
        .then((response) => {
          $('#exampleModal').modal('hide'); // hide modal
          this.detectNewRecord = true;
          this.page = 1;
          this.determineDefaultPage();
          this.loadSpecificPage();
          this.title = 'Staff created successfully!';
          this.showSuccessMsg(response);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.loadingForm = false;
        });
    },

    // /editUser() function. Function we use to 1. Set /isFormCreateUserMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating user details, 4. Fill form with user details.
    editUser(user) {
      this.isFormCreateUserMode = false;
      this.form.reset(); // v form reset inputs
      this.form.clear(); // v form clear errors
      $('#exampleModal').modal('show'); // show modal
      this.form.fill(user);
      console.log(this.form);
    },

    // /updateUser() function. Function we use to update user details by calling api/users/{id} method PUT (carrying form input data).
    updateUser() {
      this.loadingForm = true;
      // request put
      this.form
        .put('api/staff/staff-management/' + this.form.id, {})
        .then((response) => {
          $('#exampleModal').modal('hide'); // hide modal

          this.detectUpdate = true;
          this.highlightChangedRecord();
          this.determineDefaultPage();
          this.loadSpecificPage();
          this.title = 'Staff updated successfully!';
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

    // /deleteUser() function. Function we use to delete user record by calling api/users/{id} method DELETE.
    deleteUser(id) {
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
              .delete('api/staff/staff-management/' + id, {})
              .then((response) => {
                this.detectTrash = true;
                this.highlightChangedRecord();
                this.determineDefaultPage();
                this.loadSpecificPage();
                this.title = 'Staff has been trashed successfully!';
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

    deleteMultiple() {
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
                  .get('api/staff/staff-management/delete-multiple/ids=' + join_selected_values)
                  .then((response) => {
                    this.detectMultipleTrash = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Staff/s has been trashed successfully!';
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
    // Call /getUsers() function initially.
    this.getUsers();
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
