<template>
  <div class="wrapper">
    <Nav />
    <Sidebar />
    <div class="content-wrapper">
      <!-- Title and breadacrumbs -->
      <Breadcrumbs />
      <!-- End title and breadacrumbs -->
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card card-outline card-info">
              <div class="card-body">
                <!-- list data -->
                <form @submit.prevent="update()" novalidate>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <strong>Name</strong>
                        <input
                          v-model="form.name"
                          type="text"
                          name="name"
                          id="name"
                          placeholder="Role Name"
                          class="form-control"
                          :class="{
                            'is-invalid': form.errors.has('name'),
                          }"
                        />
                        <div
                          style="color: red"
                          v-if="form.errors.has('name')"
                          v-html="form.errors.get('name')"
                        />
                      </div>
                    </div>
                    <div
                      class="col-xs-6 col-sm-6 col-md-6 panel-body table-responsive"
                      style="overflow: hidden"
                    >
                      <strong>Product Management</strong>
                      <table
                        class="table table-hover table-striped dataTable"
                        style="border: 1px solid rgba(0, 0, 0, 0.125)"
                      >
                        <tbody>
                          <tr v-for="permission in form.permissions.slice(0, 4)" :key="permission.id">
                            <td>
                              <input
                                type="checkbox"
                                name="permission[]"
                                data-bootstrap-switch
                                data-off-color="danger"
                                :value="permission.id"
                                class="product_management"
                                data-size="small"
                                :checked="Object.values(form.role_permissions).includes(permission.id)" 
                              />
                              {{ permission.name }} <br />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <strong>Staffs Management</strong>
                      <table
                        class="table table-hover table-striped dataTable"
                        style="border: 1px solid rgba(0, 0, 0, 0.125)"
                      >
                        <tbody>
                          <tr v-for="permission in form.permissions.slice(8, 12)" :key="permission.id">
                            <td>
                              <input
                                type="checkbox"
                                name="permission[]"
                                data-bootstrap-switch
                                data-off-color="danger"
                                :value="permission.id"
                                class="user_management"
                                :checked="Object.values(form.role_permissions).includes(permission.id)"
                              />
                              {{ permission.name }} <br />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div
                      class="col-xs-6 col-sm-6 col-md-6 panel-body table-responsive"
                      style="overflow: hidden"
                    >
                      <strong>Roles Management</strong>
                      <table
                        class="table table-hover table-striped dataTable"
                        style="border: 1px solid rgba(0, 0, 0, 0.125)"
                      >
                        <tbody>
                          <tr v-for="permission in form.permissions.slice(4, 8)" :key="permission.id">
                            <td>
                              <input
                                type="checkbox"
                                name="roles_permission"
                                data-bootstrap-switch
                                data-off-color="danger"
                                class="role_management"
                                v-model="roles_status"
                                v-bind="$attrs"
                                :value="permission.id"
                                :checked="Object.values(form.role_permissions).includes(permission.id)"
                              />
                              {{ permission.name }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-right" style="margin-top: 10px">
                      <button type="submit" class="btn btn-primary" id="loadingButton">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
                <!-- end list data -->
              </div>
            </div>
          </div>
        </div>
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
import swal from 'sweetalert2';
import Nav from '../partials/Nav.vue';
import Breadcrumbs from '../partials/Breadcrumbs.vue';
import Sidebar from '../partials/Sidebar.vue';
import Footer from '../partials/Footer.vue';
import { BASE_URL } from '@/assets/js/base-url.js';
import { Form } from 'vform';

export default {
  name: 'brand-management',
  beforeCreate: function () {
    document.body.className = 'home-staff';
  },
  components: {
    Nav,
    Breadcrumbs,
    Sidebar,
    Footer,
  },
  data() {
    return {
      BASE_URL: BASE_URL,
      loading: false,
      permissions: {},
      form: new Form({
        roles: '',
        role_permissions: '',
        permissions: [],
        permissionsId: [], // required to update data
        name: '', // required to update data
      }),
    };
  },
  methods: {
    log(item) {
      console.log(item); // for use: :load="log(permission.name)"
    },
    showSuccessMsg(response) {
        console.log(response);
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
        title: response.message,
      });
    },
    showErrMsg(response) {
      console.log(response);
      swal.fire({
        icon: 'error',
        title: 'Oopss...',
        text: 'Something went wrong. Please try again later!', //this.msg,
        footer: '<a href>Why do I have this issue?</a>',
      });
    },
    showData() {
      this.loading = true;
      const token = localStorage.getItem('token-staff');
      let id = this.$route.params.id;

      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/roles/edit/' + id)
        .then((response) => {
          let responseData = response.data;
          this.form.fill(responseData);
          this.form.name = this.form.roles.name;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
          $('.product_management').bootstrapSwitch();
          $('.role_management').bootstrapSwitch();
          $('.user_management').bootstrapSwitch();

          this.getSwitchValue();
          this.detectSwitchChange();
        });
    },
    getSwitchValue() { 
      let arrVal = [];
      Object.values(this.form.role_permissions).forEach((data) => {
        arrVal.push({key: `${data}`})
      });
      this.form.permissionsId = arrVal;
    },
    detectSwitchChange() {
      var self = this;

      $('.role_management').on('switchChange.bootstrapSwitch', function (e) {
        if ($(this).is(':checked') === true) {
          self.form.permissionsId.push({ key: e.target.value });
        } else {
          var singleRemoveFileInfo = self.form.permissionsId.filter(function (x) {
            return x.key !== e.target.value;
          });
          self.form.permissionsId = singleRemoveFileInfo;
        }
      });

      $('.product_management').on('switchChange.bootstrapSwitch', function (e) {
        if ($(this).is(':checked') === true) {
          self.form.permissionsId.push({ key: e.target.value });
        } else {
          var singleRemoveFileInfo = self.form.permissionsId.filter(function (x) {
            return x.key !== e.target.value;
          });
          self.form.permissionsId = singleRemoveFileInfo;
        }
      });

      $('.user_management').on('switchChange.bootstrapSwitch', function (e) {
        if ($(this).is(':checked') === true) {
          self.form.permissionsId.push({ key: e.target.value });
        } else {
          var singleRemoveFileInfo = self.form.permissionsId.filter(function (x) {
            return x.key !== e.target.value;
          });
          self.form.permissionsId = singleRemoveFileInfo;
        }
      });

    },
    update() {
      $('#loadingButton').html(
        `<div class="proc-regis"><i class='fa fa-circle-o-notch fa-spin'></i> Updating data</div>`
      );
      $('#loadingButton').attr('disabled', true);

      var values = [];
      this.form.permissionsId.forEach((data) => {
        values.push(...Object.values(data));
      });
      this.form.permissionsId = values;

      let id = this.$route.params.id;

      this.form
        .put(`${BASE_URL}/api/staff/roles/update/` + id)
        .then((result) => {
          let responseData = result.data;
          $('#loadingButton').attr('disabled', false);
          $('.proc-regis').remove();
          $('#loadingButton').html(`Save`);
          this.showSuccessMsg(responseData);
        })
        .catch((err) => {
          this.showErrMsg(err);
          $('#loadingButton').attr('disabled', false);
          $('.proc-regis').remove();
          $('#loadingButton').html(`Save`);
        })
        .finally(() => {
          $('#loadingButton').attr('disabled', false);
          $('.proc-regis').remove();
          $('#loadingButton').html(`Save`);
          // prevent an unidentified permission if we rechange the permission without loading the page
          this.form.permissionsId = [];
          this.showData();
        });
    },
  },
  created() {
    this.showData();
  },
  mounted() {
    // prevent sweetalert error if user change the route when swal is still visible.
    if (swal.isVisible()) {
      document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
    }
  },
};
</script>

<style type="scss">
/*
  There is a conflict between adminlte.min.css and docs.md-iconic-font.min.css that called in public/index.html so, the navbar height must be reverted
*/
.navbar {
  min-height: revert;
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
