<template v-if="isLoggedIn">
  <div>
    <div class="row">
      <div class="col-md-4">
        <div id="custom-search-input" style="margin-bottom: 20px; margin-right: 15px; float: left">
          <div class="input-group col-md-12">
            <input type="text" class="search-query form-control" placeholder="Search" />
            <span class="input-group-btn">
              <button class="btn btn-danger" type="button">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-8" style="width: 550px">
        <div id="custom-search-input" style="margin-bottom: 20px">
          <div class="input-group col-md-12">
            <a
              style="margin: auto 0 auto auto; float: right"
              href="#"
              class="btn btn-primary btn-lg active"
              role="button"
              aria-pressed="true"
              @click.prevent="showModalCreate()"
              >Add Address</a
            >
          </div>
        </div>
      </div>
      <div class="col-md-12" v-if="user_addresses.length > 0">
        <!-- address card -->
        <div
          v-for="user_address in user_addresses"
          :key="user_address.id"
          style="margin-bottom: 20px; width: 97.5%"
        >
          <div
            class="container"
            style="
              width: 100%;
              height: 200px;
              background: #fff;
              border-radius: 5px;
              box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            "
          >
            <div
              class="content"
              style="
                position: relative;
                width: 100%;
                height: 90%;
                float: left;
                padding: 5px 15px;
                box-sizing: border-box;
              "
            >
              <h3>{{ user_address.label }}</h3>
              <br />
              {{ user_address.address }}, Kel.{{ user_address.village_residence_name }}, Kec.{{
                user_address.district_residence_name
              }}, {{ user_address.regency_residence_name }},
              {{ user_address.province_residence_name }},
              {{ user_address.kode_pos }}

              <div style="float-left; position: absolute;bottom: 0;">
                <a
                  aria-pressed="true"
                  href=""
                  id="change_address"
                  @click.prevent="showModalEdit(user_address)"
                  >Ubah Alamat</a
                >
                |
                <a
                  aria-pressed="true"
                  href=""
                  id="change_address"
                  @click.prevent="forceDelete(user_address.id)"
                  >Hapus</a
                >
              </div>
            </div>
          </div>
        </div>
        <!-- end address card -->
      </div>
      <div class="col-md-12" v-else>
        <h3>No address found here!</h3>
      </div>
    </div>

    <!-- modal -->
    <form @submit.prevent="isFormCreate ? store() : update()" novalidate>
      <div
        class="modal animated fadeIn fade"
        id="modal_address"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="top: 30%">
            <div class="modal-header">
              <h5 v-show="isFormCreate" class="modal-title" id="exampleModalLabel">Add Address</h5>
              <h5 v-show="!isFormCreate" class="modal-title" id="exampleModalLabel">
                Update Address
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div v-if="loadingForm" style="position: absolute; top: 30%; left: 40%; z-index: 1">
                <div class="lds-facebook">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
              </div>
              <!-- row 1.1 -->
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Label Alamat</label>
                    <input
                      v-model="form.label"
                      :class="{
                        'is-invalid': form.errors.has('label'),
                      }"
                      id="label"
                      name="label"
                      type="text"
                      class="form-control"
                      required
                      autocomplete="label"
                      placeholder="Label Alamat"
                    />
                    <div
                      style="color: red"
                      class="errorIcon"
                      v-if="form.errors.has('label')"
                      v-html="form.errors.get('label')"
                    />
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="email">Alamat Rumah</label>
                    <input
                      v-model="form.address"
                      :class="{
                        'is-invalid': form.errors.has('address'),
                      }"
                      id="address"
                      name="address"
                      type="text"
                      class="form-control"
                      required
                      autocomplete="address"
                      placeholder="Jalan, RT/RW, No Rumah"
                    />
                    <div
                      style="color: red"
                      class="errorIcon"
                      v-if="form.errors.has('address')"
                      v-html="form.errors.get('address')"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group get-provinces">
                    <label for="username">Provinsi</label>
                    <select
                      v-model="form.province_residence"
                      id="province_residence"
                      :class="{
                        'is-invalid': form.errors.has('province_residence'),
                      }"
                      class="form-control"
                      @change="changeRegencies($event)"
                    >
                      <option :value="null" disabled selected>=== Select Province ===</option>
                      <option
                        v-for="province in provinces[0]"
                        :value="province.id"
                        :data-index="province.id"
                        v-bind:key="province.id"
                      >
                        {{ province.name }}
                      </option>
                    </select>
                    <div
                      style="color: red"
                      class="errorIcon"
                      v-if="form.errors.has('province_residence')"
                      v-html="form.errors.get('province_residence')"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group get-regencies">
                    <label for="username">Kabupaten/Kota</label>
                    <select
                      v-model="form.regency_residence"
                      id="regency_residence"
                      :class="{
                        'is-invalid': form.errors.has('regency_residence'),
                      }"
                      class="form-control"
                      @change="changeDistricts($event)"
                    >
                      <option :value="null" disabled selected>=== Select Regency ===</option>
                      <option
                        v-for="regency in regencies[0]"
                        :value="regency.id"
                        :data-index="regency.id"
                        v-bind:key="regency.id"
                        :selected="regency.id === regency_id"
                      >
                        {{ regency.name }}
                      </option>
                    </select>
                    <div
                      style="color: red"
                      class="errorIcon"
                      v-if="form.errors.has('regency_residence')"
                      v-html="form.errors.get('regency_residence')"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group get-districts">
                    <label for="email">Kecamatan</label>
                    <select
                      v-model="form.district_residence"
                      id="district_residence"
                      :class="{
                        'is-invalid': form.errors.has('district_residence'),
                      }"
                      class="form-control"
                      @change="changeVillages($event)"
                    >
                      <option :value="null" disabled selected>=== Select District ===</option>
                      <option
                        v-for="district in districts[0]"
                        :value="district.id"
                        :data-index="district.id"
                        v-bind:key="district.id"
                        :selected="district.id === district_id"
                      >
                        {{ district.name }}
                      </option>
                    </select>
                    <div
                      style="color: red"
                      class="errorIcon"
                      v-if="form.errors.has('district_residence')"
                      v-html="form.errors.get('district_residence')"
                    />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone">Kelurahan/Desa</label>
                    <select
                      v-model="form.village_residence"
                      id="village_residence"
                      :class="{
                        'is-invalid': form.errors.has('village_residence'),
                      }"
                      class="form-control"
                    >
                      <option :value="null" disabled selected>=== Select Village ===</option>
                      <option
                        v-for="village in villages[0]"
                        :value="village.id"
                        :data-index="village.id"
                        v-bind:key="village.id"
                        :selected="village.id === village_id"
                      >
                        {{ village.name }}
                      </option>
                    </select>
                    <div
                      style="color: red"
                      class="errorIcon"
                      v-if="form.errors.has('village_residence')"
                      v-html="form.errors.get('village_residence')"
                    />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email">Kode Pos</label>
                    <input
                      v-model="form.kode_pos"
                      :class="{
                        'is-invalid': form.errors.has('kode_pos'),
                      }"
                      id="kode_pos"
                      name="kode_pos"
                      type="text"
                      class="form-control"
                      required
                      autocomplete="kode_pos"
                      placeholder="Kode Pos"
                    />
                    <div
                      style="color: red"
                      class="errorIcon"
                      v-if="form.errors.has('kode_pos')"
                      v-html="form.errors.get('kode_pos')"
                    />
                  </div>
                </div>
              </div>
              <!-- End row 1.1 -->
            </div>
            <div class="modal-footer">
              <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">
                Close
              </button>
              <button type="submit" class="btn btn-primary">Save address</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- end modal -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
//import { BASE_URL } from '@/assets/js/base-url.js';
import { Form } from 'vform';
import swal from 'sweetalert2';
import axios from 'axios';
import '@/assets/css/loading.css';

export default {
  beforeCreate: function () {
    document.body.className = 'home-user';
  },
  data() {
    return {
      loadingForm: false,
      userData: '',
      defaultSelected: true,
      user_addresses: {},
      province_id: null,
      provinces: [],
      regency_id: null,
      regencies: [],
      district_id: null,
      districts: [],
      village_id: null,
      villages: [],
      isFormCreate: true,
      form: new Form({
        id: '',
        label: '',
        address: '',
        province_residence: null,
        regency_residence: null,
        district_residence: null,
        village_residence: null,
        kode_pos: '',
      }),
    };
  },
  computed: {
    ...mapGetters({
      guest: 'auth/guest',
      user: 'auth/user',
    }),
  },
  methods: {
    checkAuth() {
      let config = {
        headers: {
          Authorization: 'Bearer ' + this.user.token,
        },
      };

      //get data user
      axios
        .get('api/user', config)
        .then((response) => {
          this.userData = response.data;
          this.loadStoredAddresses();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    resetAndClearForm() {
      this.form.reset(); // v form reset inputs
      this.form.clear(); // v form clear errors
    },
    loadProvinces() {
      this.axios
        .get('api/json-provinces', {})
        .then((response) => {
          var responseData = response.data;
          let provinces = responseData.provinces;
          this.provinces.push(provinces);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          //
        });
    },
    changeRegencies(event) {
      this.regency_id = null;
      this.district_id = null;
      this.village_id = null;
      this.regencies = [];
      this.districts = [];
      this.villages = [];
      this.form.regency_residence = null;
      this.form.district_residence = null;
      this.form.village_residence = null;

      var province_id = event.target.options[event.target.selectedIndex].dataset.index;
      this.loadRegencies(province_id);
    },
    changeDistricts(event) {
      this.district_id = null;
      this.village_id = null;
      this.districts = [];
      this.villages = [];
      this.form.district_residence = null;
      this.form.village_residence = null;

      var regency_id = event.target.options[event.target.selectedIndex].dataset.index;
      this.loadDistricts(regency_id);
    },
    changeVillages(event) {
      this.village_id = null;
      this.villages = [];
      this.form.village_residence = null;

      var district_id = event.target.options[event.target.selectedIndex].dataset.index;
      this.loadVillages(district_id);
    },
    loadRegencies(province_id) {
      this.axios
        .get('api/json-regencies/' + province_id)
        .then((response) => {
          var regencies = response.data;
          this.regencies.push(regencies);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          //
        });
    },
    loadDistricts(regency_id) {
      this.axios
        .get('api/json-districts/' + regency_id)
        .then((response) => {
          var districts = response.data;
          this.districts.push(districts);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          //
        });
    },
    loadVillages(district_id) {
      this.axios
        .get('api/json-village/' + district_id)
        .then((response) => {
          var villages = response.data;
          this.villages.push(villages);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          //
        });
    },
    loadStoredAddresses() {
      this.axios
        .get('api/user/shipping-addresses/index/' + this.userData.id)
        .then((response) => {
          let responseData = response.data;
          this.user_addresses = responseData.data;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {});
    },
    showModalCreate() {
      this.resetAndClearForm();
      this.isFormCreate = true;
      $('#modal_address').modal({ backdrop: 'static', keyboard: false });
    },
    showModalEdit(userAddress) {
      $('#modal_address').modal({ backdrop: 'static', keyboard: false });
      this.isFormCreate = false;
      this.regencies = [];
      this.districts = [];
      this.villages = [];
      this.resetAndClearForm();
      this.form.fill(userAddress);
      this.loadRegencies(this.form.province_residence);
      this.loadDistricts(this.form.regency_residence);
      this.loadVillages(this.form.district_residence);
    },
    store() {
      this.loadingForm = true;

      this.form
        .post('api/user/shipping-addresses/store')
        .then((response) => {
          this.showSuccessMsg(response);
          $('#modal_address').modal('hide');
          $('.modal-backdrop').remove();
          this.resetAndClearForm();
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.loadingForm = false;
          this.loadStoredAddresses();
        });
    },
    showSuccessMsg(response) {
      var responseData = response.data;

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
        title: responseData.message,
      });
    },
    update() {
      this.loadingForm = true;

      // request put
      this.form
        .put('api/user/shipping-addresses/update/' + this.form.id)
        .then((response) => {
          this.showSuccessMsg(response);
        })
        .catch((err) => {
          // sweet alert fail
          swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href>Why do I have this issue?</a>',
          });
          console.log(err);
        })
        .finally(() => {
          this.loadingForm = false;
          $('#modal_address').modal('hide');
          $('.modal-backdrop').remove();
          this.loadStoredAddresses();
        });
    },
    forceDelete(id) {
      swal
        .fire({
          title: 'Are you sure?',
          text: 'You still be able to revert this!',
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
              .delete('api/user/shipping-addresses/force-delete/' + id)
              .then((response) => {
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
                $('#modal_address').modal('hide');
                $('.modal-backdrop').remove();
                this.loadStoredAddresses();
              });
          }
        });
    },
  },
  beforeMount() {},
  created() {},
  mounted() {
    this.checkAuth();
    this.loadProvinces();
    if (swal.isVisible()) {
      document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
    }
  },
};
</script>

<style type="scss">
.modal-open {
  padding-right: 0;
}
.modal-open .modal {
  overflow: hidden;
}
.modal-dialog {
  position: relative;
  width: auto;
  height: 100%;
  margin: 48px;
}
.modal-content {
  max-height: calc(100% - 96px);
  overflow-y: auto;
  padding: 8px;
  background-color: #fff;
  border: 0;
  border-radius: 0;
  box-shadow: 0 19px 38px rgba(0, 0, 0, 0.3), 0 15px 12px rgba(0, 0, 0, 0.22);
}
.modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-color: #000;
}
.modal-backdrop.in {
  opacity: 0.5;
  filter: alpha(opacity=50);
}
.modal-header {
  padding: 16px;
  padding-bottom: 0;
  border: 0;
  min-height: inherit;
}
.modal-header .close {
  position: absolute;
  top: 10px;
  right: 10px;
  margin: 0;
  padding: 0;
  height: 56px;
  width: 56px;
  min-width: 56px;
  font-size: 24px;
  line-height: 56px;
}
.modal-title {
  font-size: 20px;
  line-height: 28px;
  font-weight: 500;
  letter-spacing: 0.05px;
  color: rgba(0, 0, 0, 0.87);
  margin: 0;
}
.modal-body {
  color: rgba(0, 0, 0, 0.87);
  padding: 16px;
}
.modal-footer {
  height: 48px;
  padding: 8px 16px;
  text-align: right;
  border: 0;
}
body {
  overflow: auto;
  padding-right: 0 !important;
}
.modal-backdrop.fade,
.modal-backdrop.fade.in {
  opacity: 0.7 !important;
}
.modal-open {
  overflow-y: scroll;
}
</style>
