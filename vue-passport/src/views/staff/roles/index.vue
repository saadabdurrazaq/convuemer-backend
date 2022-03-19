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
                    <nav class="navecation"></nav>
                  </div>
                  <div class="col-md-6 text-right">
                    <router-link
                      :to="{
                        name: 'roles-create',
                      }"
                      class="btn btn-info"
                      style="margin-top: 25px"
                      ><i class="fas fa-user-plus"></i> Add new role
                    </router-link>
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
                <div style="float: right">
                  <form action="">
                    <div class="input-group input-group-sm" style="width: 215px">
                      <input
                        type="text"
                        @keyup="searchrole"
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
                        <th>Role Name</th>
                        <th>Permissions</th>
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
                      <tr :class="'data-' + role.id" v-for="role in roles" :key="role.id">
                        <td style="text-align: center">
                          <input
                            type="checkbox"
                            id="select"
                            class="sub_chk"
                            :data-id="role.id"
                            :value="role.id"
                            name="selected_values[]"
                          />
                        </td>
                        <td class="align-middle" style="text-align: center; width: 15%">
                          {{ role.name }}
                        </td>
                        <td v-if="role.role_permissions.length > 0">
                          <div
                            v-for="rolePerm in role.role_permissions"
                            :key="rolePerm.id"
                            style="float: left; padding-right: 5px"
                          >
                            <span class="badge bg-info text-light">{{ rolePerm.name }}</span
                            >,
                          </div>
                        </td>
                        <td style="text-align: center; width: 30%">
                          <router-link
                            :to="{
                              name: 'roles-edit',
                              params: { id: role.id },
                            }"
                            class="btn btn-info"
                            style="margin-right: 7px"
                            ><i class="fa fa-edit"></i> Edit
                          </router-link>
                          <a class="btn btn-warning" href="" @click.prevent="softDelete(role.id)">
                            <i class="fa fa-trash"></i> Trash
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div v-if="isrolesPagination">
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
                        @paginate="Getroles"
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
                        @paginate="searchrole"
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
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import 'admin-lte/dist/css/adminlte.min.css'; // conflict with frontend theme
import _ from 'lodash';
import '@/assets/css/custom.css';
import swal from 'sweetalert2';
import Nav from '../partials/Nav.vue';
import Breadcrumbs from '../partials/Breadcrumbs.vue';
import Sidebar from '../partials/Sidebar.vue';
import Footer from '../partials/Footer.vue';
import { BASE_URL } from '@/assets/js/base-url.js';

export default {
  name: 'role-management',

  beforeCreate: function () {
    document.body.className = 'home-staff';
  },

  components: {
    Nav,
    Breadcrumbs,
    Sidebar,
    Footer,
  },

  // Declare roles (as object), form (as /vform instance) and /isFormCreateroleMode (as boolean defaulted to 'true') inside /data() { return {} }.
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
      roles: {},
      msg: '',
      title: '',
      imagePreview: null,
      showPreview: false,
      isFormCreateroleMode: true,
      isInAllData: true,
      loading: false,
      loadingForm: false,
      defaultrolesPagination: false,
      defaultShowEntriesPagination: false,
      defaultSearchPagination: false,
      isrolesPagination: false,
      isShowEntriesPagination: false,
      isSearchPagination: false,
      detectNewRecord: false,
      detectUpdate: false,
      detectTrash: false,
      detectMultipleTrash: false,
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

    loadData(response) {
      var responseData = response.data;
      this.roles = response;
      this.totalRecords = responseData.roles.total;
      this.from = responseData.roles.from;
      this.to = responseData.roles.to;
      this.currentPage = responseData.roles.current_page;
      this.trashed = responseData.total_trashed_role;
      this.perPage = responseData.items;
    },

    loadSpecificPage() {
      if (this.defaultrolesPagination === true) {
        this.isrolesPagination = true;
        this.Getroles(this.page);
        console.log(`I am in getroles`);
      } else if (this.defaultShowEntriesPagination === true) {
        this.isShowEntriesPagination = true;
        this.showEntries(this.page);
        console.log(`I am in show entries`);
      } else if (this.defaultSearchPagination === true) {
        this.searchrole(); // the page is not defined because we should return it to page 1.
        console.log(`I am in search page`);
      } else {
        this.page = 1;
        this.Getroles(this.page);
        console.log(`No matching option. So, I am in getroles`);
      }
    },

    determineDefaultPage() {
      // for example if user trash data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
      if (_.isEmpty(this.search) === false) {
        this.defaultSearchPagination = true;
        this.isSearchPagination = true;
        this.defaultrolesPagination = false;
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

    // /showData() function. Function we use to get user list by calling api/roles method GET.
    showData() {
      const token = localStorage.getItem('token-staff');

      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/roles/index')
        .then((response) => {
          let rolePermissions = response.data.role_permissions;
          let roles = response.data.roles.data;

          roles.forEach((roleData) => {
            var rolePermissionsFiltered = rolePermissions.filter(function (x) {
              return x.role_id === roleData.id;
            });
            // add new attribute with its data
            Object.assign(roleData, {
              role_permissions: rolePermissionsFiltered,
            });
          });

          this.loadData(roles);
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
      this.defaultrolesPagination = false;
      this.defaultSearchPagination = false;
      this.isrolesPagination = false;
      this.isSearchPagination = false;

      var val = $('select[name=showEntries] option').filter(':selected').val();

      if (typeof page === 'undefined') {
        this.page = 1;
      }

      this.axios
        .get('api/staff/role-management?items=' + val, {
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

    searchrole: _.debounce(function (page) {
      if (_.isEmpty(this.search)) {
        this.defaultSearchPagination = false;
        this.isSearchPagination = false;
        this.loadSpecificPage();
      } else {
        this.loading = true;

        if (this.defaultrolesPagination === true) {
          this.isrolesPagination = false;
        } else if (this.defaultShowEntriesPagination === true) {
          this.isShowEntriesPagination = false;
        }

        this.isSearchPagination = true;

        if (typeof page === 'undefined') {
          page = 1;
        }

        this.axios
          .get('api/staff/role-management/search/' + this.search, {
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

    // /showModal() function. Function we use to 1. Set /isFormCreateroleMode to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating user details.
    showModal() {
      this.isFormCreateroleMode = true;
      this.form.reset(); // v form reset
      $('#exampleModal').modal('show'); // show modal
    },

    // /createrole() function. Function we use to store user details by calling api/roles method POST (carrying form input data).
    createrole() {
      this.loadingForm = true;
      let formData = new FormData();

      formData.append('name', this.form.name);
      formData.append('role_image', this.form.role_image);

      console.log(this.form.role_image);

      // request post
      this.form
        .post('api/staff/role-management', formData)
        .then((response) => {
          $('#exampleModal').modal('hide'); // hide modal

          this.detectNewRecord = true;
          this.page = 1;
          this.determineDefaultPage();
          this.loadSpecificPage();
          this.title = 'role/s created successfully!';
          this.showSuccessMsg(response);
          document.getElementById('role_image').value = '';
          this.imagePreview = null;
          this.showPreview = false;
          this.form.role_image = null;
        })
        .catch((error) => {
          // sweet alert fail
          console.log(error);
        })
        .finally(() => {
          this.loadingForm = false;
        });
    },

    // /editUser() function. Function we use to 1. Set /isFormCreateroleMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating user details, 4. Fill form with user details.
    editrole(role) {
      this.isFormCreateroleMode = false;
      this.form.reset(); // v form reset inputs
      this.form.clear(); // v form clear errors
      this.loadingForm = false;
      $('#exampleModal').modal('show'); // show modal
      this.form.fill(role);
    },

    // /updaterole() function. Function we use to update user details by calling api/roles/{id} method PUT (carrying form input data).
    updaterole() {
      let myXhr;
      const token = localStorage.getItem('token-staff');
      var self = this;

      // if input image is empty, set null and false. So that, data can be updated without attaching an image.
      if (document.getElementById('role_image').value == '') {
        self.imagePreview = null;
        self.showPreview = false;
        self.form.role_image = null;
      }

      let formDataUpdate = new FormData();
      formDataUpdate.append('name', this.form.name);
      formDataUpdate.append('role_image', this.form.role_image);
      formDataUpdate.append('_method', 'PUT');
      let selectedImage = $('#role_image')[0].files[0];
      formDataUpdate.append('selectedImages', selectedImage);

      $.ajaxSetup({
        url: `${BASE_URL}/api/staff/role-management/` + this.form.id,
      });

      $.ajax({
        method: 'POST',
        data: formDataUpdate,
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        async: true,
        headers: {
          'Content-Type': undefined,
        },
        xhr: function () {
          myXhr = $.ajaxSettings.xhr();
          return myXhr;
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader('Authorization', `Bearer ${token}`);
          self.loadingForm = true;
        },
        success: function (result) {
          if (result.errors) {
            console.log(result.errors);
            // sweet alert fail
            swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
              footer: '<a href>Why do I have this issue?</a>',
            });
          } else {
            $('#exampleModal').modal('hide'); // hide modal

            self.detectUpdate = true;
            self.highlightChangedRecord();
            self.determineDefaultPage();
            self.loadSpecificPage();
            self.title = 'role updated successfully!';
            self.showSuccessMsg(result);
            self.loadingForm = false;
            self.imagePreview = null;
            self.showPreview = false;
            document.getElementById('role_image').value = '';
            self.form.role_image = null;
          }
        },
        error: function (response) {
          self.loadingForm = false;
          console.log(response.responseJSON.errors.name);
          $('#name').addClass('is-invalid');
          $('#codeError').text(response.responseJSON.errors.name);
          $('.alert-danger').html('An error in your input fields');
          $.each(response.responseJSON.errors, function (key, value) {
            $('.alert-danger').show();
            $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
          });
        },
      });
    },

    // /softDelete() function. Function we use to delete user record by calling api/roles/{id} method DELETE.
    softDelete(id) {
      this.form.id = id;

      // sweet alert confirmation
      swal
        .fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
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
              .delete('api/staff/role-management/soft-delete/' + id, {})
              .then((response) => {
                this.detectTrash = true;
                this.highlightChangedRecord();
                this.determineDefaultPage();
                this.loadSpecificPage();
                this.title = 'role has been trashed successfully!';
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
                  .get('api/staff/role-management/soft-delete-multiple/ids=' + join_selected_values)
                  .then((response) => {
                    this.detectMultipleTrash = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'role/s has been trashed successfully!';
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
    this.showData();
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
