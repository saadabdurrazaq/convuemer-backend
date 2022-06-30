<template>
  <div id="app">
    <Nav />
    <main class="py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">Daftar Akun</div>

              <div class="card-body">
                <form @submit.prevent="store()" novalidate>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Info Data Pribadi:</p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="name">Nama Depan</label>
                          <input
                            v-model="form.first_name"
                            id="name"
                            type="text"
                            class="form-control"
                            :class="{
                              'is-invalid': form.errors.has('first_name'),
                            }"
                            name="name"
                            required
                            autocomplete="name"
                            autofocus
                          />
                          <div
                            style="color: red"
                            v-if="form.errors.has('first_name')"
                            v-html="form.errors.get('first_name')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="name">Nama Belakang</label>
                          <input
                            v-model="form.last_name"
                            id="last-name"
                            type="text"
                            :class="{
                              'is-invalid': form.errors.has('last_name'),
                            }"
                            class="form-control"
                            name="last-name"
                            required
                            autocomplete="last-name"
                            autofocus
                          />
                          <div
                            style="color: red"
                            v-if="form.errors.has('last_name')"
                            v-html="form.errors.get('last_name')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="nickname">Nama Panggilan</label>
                          <input
                            id="nickname"
                            type="text"
                            class="form-control"
                            v-model="form.nick_name"
                            :class="{
                              'is-invalid': form.errors.has('nick_name'),
                            }"
                            name="nickname"
                            required
                            autocomplete="nickname"
                            autofocus
                          />
                          <div
                            style="color: red"
                            v-if="form.errors.has('nick_name')"
                            v-html="form.errors.get('nick_name')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="nik">Tanggal Lahir</label>
                          <input
                            v-model="form.birthday"
                            :class="{
                              'is-invalid': form.errors.has('birthday'),
                            }"
                            class="birth form-control datepicker"
                            placeholder="Pilih tanggal lahir"
                            name="birth"
                            type="text"
                            readonly="readonly"
                            style="background-color: #fff"
                            @focus="onFocus"
                          />
                          <div
                            style="color: red"
                            v-if="form.errors.has('birthday')"
                            v-html="form.errors.get('birthday')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="nik">Status Keluarga</label>
                          <select
                            v-model="form.status"
                            :class="{
                              'is-invalid': form.errors.has('status'),
                            }"
                            id="status"
                            selected="selected"
                            name="status"
                            class="form-control relationship"
                            data-select2-id="17"
                            tabindex="-1"
                            aria-hidden="true"
                            v-on:change="showRelFieldsOrVal()"
                          >
                            <option value="0" selected="true">=== Select status ===</option>
                            <option value="Single (pria)" data-select2-id="19">
                              Single (pria)
                            </option>
                            <option value="Single (wanita)" data-select2-id="19">
                              Single (wanita)
                            </option>
                            <option value="Suami (menikah)" data-select2-id="38">
                              Suami (menikah)
                            </option>
                            <option value="Istri (menikah)" data-select2-id="38">
                              Istri (menikah)
                            </option>
                            <option value="Duda" data-select2-id="19">Duda</option>
                            <option value="Janda" data-select2-id="19">Janda</option>
                            <option value="Anak" data-select2-id="39">Anak</option>
                            >
                          </select>
                          <div
                            style="color: red"
                            v-if="form.errors.has('status')"
                            v-html="form.errors.get('status')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="nik">Pendidikan Terakhir</label>
                          <select
                            v-model="form.education"
                            :class="{
                              'is-invalid': form.errors.has('education'),
                            }"
                            v-on:change="showJurusan()"
                            id="pagination"
                            class="form-control jurusan"
                            data-select2-id="17"
                            tabindex="-1"
                            aria-hidden="true"
                          >
                            <option value="0" disable="true" selected="true">
                              === Select Education ===
                            </option>
                            <option value="sd" data-select2-id="19">SD</option>
                            <option value="smp" data-select2-id="38">SMP</option>
                            <option value="sma" data-select2-id="39">SMA</option>
                            <option value="d3" data-select2-id="40">D3</option>
                            <option value="s1" data-select2-id="41">S1</option>
                            <option value="s2" data-select2-id="41">S2</option>
                            <option value="s3" data-select2-id="41">S3</option>
                          </select>
                          <div
                            style="color: red"
                            v-if="form.errors.has('education')"
                            v-html="form.errors.get('education')"
                          />
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group" id="jurusan">
                          <label for="email">Jurusan</label><br />
                          <select
                            v-bind:name="form.concentration"
                            style="width: 100%"
                            selected="selected"
                            multiple
                            class="form-control"
                            id="concentration"
                          ></select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('concentration')"
                            v-html="form.errors.get('concentration')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group" id="jurusan">
                          <!-- style="display: none;" -->
                          <label for="email">Universitas</label><br />
                          <select
                            v-bind:name="form.university"
                            selected="selected"
                            multiple
                            class="form-control"
                            style="width: 100%"
                            id="university"
                          ></select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('university')"
                            v-html="form.errors.get('university')"
                          />
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Credential Info:</p>
                        </div>
                      </div>
                    </div>
                    <!-- row 1 -->
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input
                            v-model="form.username"
                            :class="{
                              'is-invalid': form.errors.has('username'),
                            }"
                            id="username"
                            type="text"
                            class="form-control"
                            name="username"
                            required
                            autocomplete="username"
                          />
                          <div
                            style="color: red"
                            v-if="form.errors.has('username')"
                            v-html="form.errors.get('username')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="account_key">Account Key</label>
                          <input
                            v-model="form.account_key"
                            :class="{
                              'is-invalid': form.errors.has('account_key'),
                            }"
                            id="account_key"
                            type="password"
                            class="form-control"
                            name="account_key"
                            required
                            autocomplete="account_key"
                          />
                          <div
                            style="color: red"
                            v-if="form.errors.has('account_key')"
                            v-html="form.errors.get('account_key')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <label for="account_key_confirmation">Confirm Account Key</label>
                        <input
                          v-model="form.account_key_confirmation"
                          :class="{
                            'is-invalid': form.errors.has('account_key_confirmation'),
                          }"
                          id="account_key_confirmation"
                          type="password"
                          class="form-control"
                          name="account_key_confirmation"
                          required
                          autocomplete="account_key_confirmation"
                        />
                        <div
                          style="color: red"
                          v-if="form.errors.has('account_key_confirmation')"
                          v-html="form.errors.get('account_key_confirmation')"
                        />
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="phone">Phone & WhatsApp Number</label>
                          <input
                            id="phone"
                            v-model="form.phone"
                            :class="{
                              'is-invalid': form.errors.has('phone'),
                            }"
                            type="text"
                            class="form-control"
                            name="phone"
                            required
                            autocomplete="phone"
                          />
                          <div
                            style="color: red"
                            v-if="form.errors.has('phone')"
                            v-html="form.errors.get('phone')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="form-group">
                            <label for="gender">Jenis Kelamin</label>
                            <br />
                            <input
                              type="radio"
                              id="male"
                              name="gender"
                              v-model="form.picked_gender"
                            />
                            <label for="male">Pria</label>
                            <input
                              v-model="form.picked_gender"
                              type="radio"
                              id="female"
                              name="gender"
                            />
                            <label for="female">Wanita</label>
                          </div>
                          <div
                            style="color: red"
                            v-if="form.errors.has('picked_gender')"
                            v-html="form.errors.get('picked_gender')"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- End row 1 -->
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Info Kediaman:</p>
                        </div>
                      </div>
                    </div>
                    <!-- row 1.1 -->
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group get-provinces">
                          <label for="username">Provinsi</label>
                          <select
                            v-bind:name="form.province_residence"
                            :class="{
                              'is-invalid': form.errors.has('province_residence'),
                            }"
                            class="form-control"
                            id="province_residence"
                            :required="true"
                          >
                            <option value="0" :selected="true">=== Select Province ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('province_residence')"
                            v-html="form.errors.get('province_residence')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group get-regencies">
                          <label for="username">Kabupaten/Kota</label>
                          <select
                            v-bind:name="form.regency_residence"
                            :class="{
                              'is-invalid': form.errors.has('regency_residence'),
                            }"
                            class="form-control"
                            id="regency_residence"
                          >
                            <option value="0" :selected="true">=== Select Regency ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('regency_residence')"
                            v-html="form.errors.get('regency_residence')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group get-districts">
                          <label for="email">Kecamatan</label>
                          <select
                            v-bind:name="form.district_residence"
                            :class="{
                              'is-invalid': form.errors.has('district_residence'),
                            }"
                            class="form-control"
                            id="district_residence"
                          >
                            <option value="0" :selected="true">=== Select District ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('district_residence')"
                            v-html="form.errors.get('district_residence')"
                          />
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="phone">Kelurahan/Desa</label>
                          <select
                            v-bind:name="form.village_residence"
                            :class="{
                              'is-invalid': form.errors.has('village_residence'),
                            }"
                            class="form-control"
                            id="village_residence"
                          >
                            <option value="0" :selected="true">=== Select Village ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('village_residence')"
                            v-html="form.errors.get('village_residence')"
                          />
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email">Tempat Tinggal</label>
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

                      <div class="col-md-2">
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
                    <div v-if="isChildernForm">
                      <br />
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <p class="lead section-title">Info Hubungan:</p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="username">Username Ayah</label>
                            <input
                              v-model="form.father_username"
                              :class="{
                                'is-invalid': form.errors.has('father_username'),
                              }"
                              id="father-username"
                              type="text"
                              class="form-control"
                              name="father-username"
                              required
                              autocomplete="username"
                              placeholder="Username ayah"
                            />
                            <div
                              style="color: red"
                              v-if="form.errors.has('father_username')"
                              v-html="form.errors.get('father_username')"
                            />
                            <span
                              style="display: none"
                              class="invalid-feedback no_father"
                              role="alert"
                            >
                              <strong>Maaf, data ayah tidak ditemukan!</strong>
                            </span>
                            <input
                              type="checkbox"
                              name="yatim"
                              value="yatim"
                              id="yatim"
                              v-on:click="disableFatherFields()"
                            /><small class="text-muted">
                              Saya tidak punya ayah atau ayah saya sudah meninggal.</small
                            >
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="username">Account Key Ayah</label>
                            <input
                              v-model="form.father_acc_key"
                              :class="{
                                'is-invalid': form.errors.has('father_acc_key'),
                              }"
                              id="father-account-key"
                              type="password"
                              class="form-control"
                              name="account-key"
                              required
                              autocomplete="username"
                              placeholder="Account key ayah"
                            />
                            <div
                              style="color: red"
                              v-if="form.errors.has('father_acc_key')"
                              v-html="form.errors.get('father_acc_key')"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="username">Username Ibu</label>
                            <input
                              v-model="form.mother_username"
                              :class="{
                                'is-invalid': form.errors.has('mother_username'),
                              }"
                              id="mother-username"
                              type="text"
                              class="form-control"
                              name="mother-username"
                              required
                              autocomplete="username"
                              placeholder="Username ibu"
                            />
                            <div
                              style="color: red"
                              v-if="form.errors.has('mother_username')"
                              v-html="form.errors.get('mother_username')"
                            />
                            <span
                              style="display: none"
                              class="invalid-feedback no_mother"
                              role="alert"
                            >
                              <strong>Maaf, data ibu tidak ditemukan!</strong>
                            </span>
                            <input
                              type="checkbox"
                              name="piatu"
                              value="piatu"
                              id="piatu"
                              v-on:click="disableMotherFields()"
                            /><small class="text-muted">
                              Saya tidak punya ibu atau ibu saya sudah meninggal.</small
                            >
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="username">Account Key Ibu</label>
                            <input
                              v-model="form.mother_acc_key"
                              :class="{
                                'is-invalid': form.errors.has('mother_acc_key'),
                              }"
                              id="mother-account-key"
                              type="password"
                              class="form-control"
                              name="mother-account-key"
                              required
                              autocomplete="username"
                              placeholder="Account key ibu"
                            />
                            <div
                              style="color: red"
                              v-if="form.errors.has('mother_acc_key')"
                              v-html="form.errors.get('mother_acc_key')"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-if="isWifeForm">
                      <br />
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <p class="lead section-title">Info Hubungan:</p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="username">Username Suami</label>
                            <input
                              v-model="form.husbandUsername"
                              :class="{
                                'is-invalid': form.errors.has('husbandUsername'),
                              }"
                              id="husbandUsername"
                              type="text"
                              class="form-control"
                              name="husbandUsername"
                              required
                              autocomplete="username"
                              placeholder="Username suami"
                            />
                            <div
                              style="color: red"
                              v-if="form.errors.has('husbandUsername')"
                              v-html="form.errors.get('husbandUsername')"
                            />
                            <span
                              style="display: none"
                              class="invalid-feedback no_husband"
                              role="alert"
                            >
                              <strong>Maaf, data suami tidak ditemukan!</strong>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="username">Account Key Suami</label>
                            <input
                              v-model="form.husbandAccKey"
                              :class="{
                                'is-invalid': form.errors.has('husbandAccKey'),
                              }"
                              id="husbandAccKey"
                              type="password"
                              class="form-control"
                              name="husbandAccKey"
                              required
                              autocomplete="username"
                              placeholder="Account key suami"
                            />
                            <div
                              style="color: red"
                              v-if="form.errors.has('husbandAccKey')"
                              v-html="form.errors.get('husbandAccKey')"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Job Info:</p>
                        </div>
                      </div>
                      <div class="col-md-4 job-info">
                        <div class="form-group">
                          <label for="profession">Profesi</label>
                          <select
                            v-bind:name="form.profession"
                            style="width: 100%"
                            selected="selected"
                            multiple
                            class="form-control"
                            id="profession"
                          ></select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('profession')"
                            v-html="form.errors.get('profession')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4 job-info">
                        <div class="form-group">
                          <label for="company-name">Tempat Kerja</label>
                          <input
                            v-model="form.work_place"
                            :class="{
                              'is-invalid': form.errors.has('work_place'),
                            }"
                            id="work_place"
                            type="text"
                            class="form-control"
                            name="work_place"
                            required
                            autocomplete="work_place"
                            autofocus
                          />
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('work_place')"
                            v-html="form.errors.get('work_place')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4 job-info">
                        <label for="weight">Gaji per Bulan </label>
                        <div class="input-group mb-3">
                          <div class="input-group-append">
                            <span class="input-group-text">Rp</span>
                          </div>
                          <input
                            v-model="form.salary"
                            :class="{
                              'is-invalid': form.errors.has('salary'),
                            }"
                            id="salary"
                            type="text"
                            class="form-control salary"
                            name="salary"
                            required
                            autocomplete="salary"
                            autofocus
                            aria-label="Amount (to the nearest dollar)"
                          />
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('salary')"
                            v-html="form.errors.get('salary')"
                          />
                        </div>
                      </div>
                      <div class="col-md-8 job-info">
                        <div class="form-group">
                          <label for="company-address">Alamat Tempat Kerja</label>
                          <input
                            v-model="form.work_place_address"
                            :class="{
                              'is-invalid': form.errors.has('work_place_address'),
                            }"
                            id="work_place_address"
                            type="text"
                            class="form-control"
                            name="work_place_address"
                            required
                            autocomplete="work_place_address"
                            autofocus
                          />
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('work_place_address')"
                            v-html="form.errors.get('work_place_address')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4 job-info">
                        <div class="form-group get-provinces2">
                          <label for="username">Provinsi</label>
                          <select
                            v-bind:name="form.province_work"
                            :class="{
                              'is-invalid': form.errors.has('province_work'),
                            }"
                            class="form-control"
                            id="provinces2"
                          >
                            <option value="0" selected="true">=== Select Provinces ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('province_work')"
                            v-html="form.errors.get('province_work')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4 job-info">
                        <div class="form-group get-regencies2">
                          <label for="username">Kabupaten/Kota</label>
                          <select
                            v-bind:name="form.regency_work"
                            :class="{
                              'is-invalid': form.errors.has('regency_work'),
                            }"
                            class="form-control"
                            id="regencies2"
                            selected="selected"
                            data-select2-id="17"
                            tabindex="-1"
                            aria-hidden="true"
                          >
                            <option value="0" selected="true">=== Select Regencies ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('regency_work')"
                            v-html="form.errors.get('regency_work')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4 job-info">
                        <div class="form-group get-districts2">
                          <label for="email">Kecamatan</label>
                          <select
                            v-bind:name="form.district_work"
                            :class="{
                              'is-invalid': form.errors.has('district_work'),
                            }"
                            class="form-control"
                            id="districts2"
                          >
                            <option value="0" selected="true">=== Select Districts ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('district_work')"
                            v-html="form.errors.get('district_work')"
                          />
                        </div>
                      </div>
                      <div class="col-md-4 job-info">
                        <div class="form-group get-villages2">
                          <label for="phone">Kelurahan/Desa</label>
                          <select
                            v-bind:name="form.village_work"
                            :class="{
                              'is-invalid': form.errors.has('village_work'),
                            }"
                            class="form-control"
                            id="villages2"
                          >
                            <option value="0" selected="true">=== Select Villages ===</option>
                          </select>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('village_work')"
                            v-html="form.errors.get('village_work')"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="border-top: 1px solid #eee">
                      <div class="form-group" style="margin-top: 10px; margin-left: 5px">
                        <input
                          type="checkbox"
                          name="jobless"
                          value="jobless"
                          id="jobless"
                          class="checkbox form-check-input"
                        />
                        <label class="form-check-label" for="jobless"
                          >Saya belum bekerja atau sedang menganggur.</label
                        >
                      </div>
                    </div>

                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Agreement:</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-left: 5px">
                      <div class="form-group">
                        <input
                          type="checkbox"
                          name="agreement"
                          value="agreement"
                          id="agreement"
                          class="checkbox form-check-input"
                        />
                        <label class="form-check-label" for="agreement"
                          >Saya menyatakan bahwa semua data yang saya input benar adanya.</label
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="box-footer text-right">
                      <button
                        type="submit"
                        v-on:click="getDataBeforeStore()"
                        class="btn btn-primary btn-md"
                        id="loadingButton"
                      >
                        Register
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import swal from 'sweetalert2';
// datepicker
import 'jquery-ui/ui/widgets/datepicker.js';
import 'jquery-ui-dist/jquery-ui.js'; // npm install --save jquery-ui
import 'jquery-ui-dist/jquery-ui.css';
import 'jquery/dist/jquery.js';
// end datepicker
import { Form } from 'vform';
import '@/assets/css/app.css';
import Nav from './partials/Nav.vue';
import '@/assets/js/select2.min.js';
import { BASE_URL } from '@/assets/js/base-url.js';

export default {
  name: 'HelloWorld',
  components: {
    Nav,
  },
  data() {
    return {
      msg: '',
      isChildernForm: false,
      isWifeForm: false,
      form: new Form({
        agreement: [],
        yatim: [],
        piatu: [],
        jobless: '',
        concentration: '',
        profession: '',
        university: '',
        username: '',
        first_name: '',
        last_name: '',
        nick_name: '',
        birthday: '',
        picked_gender: '',
        province_residence: '',
        regency_residence: '',
        district_residence: '',
        village_residence: '',
        address: '',
        kode_pos: '',
        work_place: '',
        salary: '',
        work_place_address: '',
        province_work: '',
        regency_work: '',
        district_work: '',
        village_work: '',
        account_key_confirmation: '',
        account_key: '',
        father_username: '',
        father_acc_key: '',
        mother_username: '',
        mother_acc_key: '',
        status: '0',
        education: '0',
        husbandUsername: '',
        husbandAccKey: '',
        isChildernVal: '',
        isWifeVal: '',
        isSingleMaleOrDudaVal: '',
        isSingleFemaleOrJandaVal: '',
      }),
    };
  },
  methods: {
    loadJobsInSelect2() {
      $('#profession').select2({
        maximumSelectionLength: 1,
        placeholder: 'Select available jobs',
        ajax: {
          url: `${BASE_URL}/api/job-types/load-all-jobs-in-select2`,
          data: function (params) {
            return {
              value: $('#profession').val(),
              q: params.term,
            };
          },
          processResults: function (data) {
            return {
              results: data.map(function (item) {
                return {
                  id: item.id,
                  text: item.name,
                };
              }),
            };
          },
        },
      });
    },

    loadConcentrationsInSelect2() {
      $('#concentration').select2({
        disabled: false,
        maximumSelectionLength: 1,
        placeholder: 'Pilih jurusan yang tersedia',
        ajax: {
          url: `${BASE_URL}/api/job-types/load-all-concentrations-in-select2`,
          data: function (params) {
            return {
              value: $('#concentration').val(),
              q: params.term,
            };
          },
          processResults: function (data) {
            return {
              results: data.map(function (item) {
                return {
                  id: item.id,
                  text: item.name,
                };
              }),
            };
          },
        },
      });
    },

    loadUniversitiesInSelect2() {
      $('#university').select2({
        disabled: false,
        maximumSelectionLength: 1,
        placeholder: 'Pilih universitas yang tersedia',
        ajax: {
          url: `${BASE_URL}/api/universities/load-all-universities-in-select2`,
          data: function (params) {
            return {
              value: $('#university').val(),
              q: params.term,
            };
          },
          processResults: function (data) {
            return {
              results: data.map(function (item) {
                return {
                  id: item.id,
                  text: item.name,
                };
              }),
            };
          },
        },
      });
    },

    showJurusan() {
      if (
        $('.jurusan').val() == 'd3' ||
        $('.jurusan').val() == 's1' ||
        $('.jurusan').val() == 's2' ||
        $('.jurusan').val() == 's3'
      ) {
        this.loadConcentrationsInSelect2();
        this.loadUniversitiesInSelect2();
        $('#concentration').select2('open');
      } else {
        $('#concentration').select2({
          disabled: true,
        });
        $('#university').select2({
          disabled: true,
        });
        $('#concentration').select2('val', 'All');
        $('#university').select2('val', 'All');
      }
    },

    showSuccessMsg(response) {
      var responseData = response.data;
      this.msg = responseData.message;
      console.log(this.msg);
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
        title: this.msg,
      });
    },

    deactivateChilWiFeJan() {
      this.form.isChildernVal = '';
      this.form.isWifeVal = '';
      this.form.isSingleFemaleOrJandaVal = '';
      this.isWifeForm = false;
      this.isChildernForm = false;
    },

    deactivateChilWiMaDu() {
      this.form.isChildernVal = '';
      this.form.isWifeVal = '';
      this.form.isSingleMaleOrDudaVal = '';
      this.isWifeForm = false;
      this.isChildernForm = false;
    },

    clearAllStatus() {
      this.isChildernForm = false;
      this.isWifeForm = false;
      this.form.isChildernVal = '';
      this.form.isWifeVal = '';
      this.form.isSingleMaleOrDudaVal = '';
      this.form.isSingleFemaleOrJandaVal = '';
    },

    showRelFieldsOrVal() {
      this.clearAllStatus();

      if ($('.relationship').val() == 'anak') {
        this.isWifeForm = false;
        this.form.isWifeVal = '';
        this.form.isSingleMaleOrDudaVal = '';
        this.form.isSingleFemaleOrJandaVal = '';
        this.isChildernForm = true;
        this.form.isChildernVal = $('.relationship').val();
      } else if ($('.relationship').val() == 'istri') {
        this.isChildernForm = false;
        this.form.isChildernVal = '';
        this.form.isSingleMaleOrDudaVal = '';
        this.form.isSingleFemaleOrJandaVal = '';
        this.isWifeForm = true;
        this.form.isWifeVal = $('.relationship').val();
      } else if ($('.relationship').val() == 'perjaka') {
        this.deactivateChilWiFeJan();
        this.form.isSingleMaleOrDudaVal = $('.relationship').val();
      } else if ($('.relationship').val() == 'duda') {
        this.deactivateChilWiFeJan();
        this.form.isSingleMaleOrDudaVal = $('.relationship').val();
      } else if ($('.relationship').val() == 'suami') {
        this.deactivateChilWiFeJan();
        this.form.isSingleMaleOrDudaVal = $('.relationship').val();
      } else if ($('.relationship').val() == 'perawan') {
        this.deactivateChilWiMaDu;
        this.form.isSingleFemaleOrJandaVal = $('.relationship').val();
      } else if ($('.relationship').val() == 'janda') {
        this.deactivateChilWiMaDu();
        this.form.isSingleFemaleOrJandaVal = $('.relationship').val();
      } else {
        this.clearAllStatus();
      }
    },

    disableFatherFields() {
      if (document.getElementById('yatim').checked) {
        $('#father-username').prop('disabled', true);
        $('#father-account-key').prop('disabled', true);
        $('#father-username').removeClass('is-invalid');
        $('#father-account-key').removeClass('is-invalid');
        $('.no_father').hide();
      } else {
        $('#father-username').prop('disabled', false);
        $('#father-account-key').prop('disabled', false);
        $('#father-username').removeClass('is-invalid');
        $('#father-account-key').removeClass('is-invalid');
        $('.no_father').hide();
      }
    },

    disableMotherFields() {
      if (document.getElementById('piatu').checked) {
        $('#mother-username').prop('disabled', true);
        $('#mother-account-key').prop('disabled', true);
        $('#mother-username').removeClass('is-invalid');
        $('#mother-account-key').removeClass('is-invalid');
        $('.no_mother').hide();
      } else {
        $('#mother-username').prop('disabled', false);
        $('#mother-account-key').prop('disabled', false);
        $('#mother-username').removeClass('is-invalid');
        $('#mother-account-key').removeClass('is-invalid');
        $('.no_mother').hide();
      }
    },

    getDataBeforeStore() {
      this.form.yatim = '';
      this.form.piatu = '';
      this.form.jobless = '';

      var selected = [];
      $('input[name="agreement"]:checked').each(function () {
        selected.push($(this).val());
      });
      this.form.agreement = selected;

      var jobless = '';
      $('input[id="jobless"]:checked').each(function () {
        jobless = $(this).val();
      });
      this.form.jobless = jobless;

      var yatim = [];
      $('input[name="yatim"]:checked').each(function () {
        yatim.push($(this).val());
      });
      this.form.yatim = yatim;

      var piatu = [];
      $('input[name="piatu"]:checked').each(function () {
        piatu.push($(this).val());
      });
      this.form.piatu = piatu;

      this.form.concentration = $('#concentration').val();
      this.form.university = $('#university').val();
      this.form.profession = $('#profession').val();
      this.form.province_residence = $('#province_residence').val();
      this.form.regency_residence = $('#regency_residence').val();
      this.form.district_residence = $('#district_residence').val();
      this.form.village_residence = $('#village_residence').val();
      this.form.province_work = $('#provinces2').val();
      this.form.regency_work = $('#regencies2').val();
      this.form.district_work = $('#districts2').val();
      this.form.village_work = $('#villages2').val();
    },

    validatePrice() {
      $('.salary').on('contextmenu', function () {
        return false;
      });

      function addDot(x) {
        return x.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }

      $('.salary').on('keyup', this, function (event) {
        // skip for arrow left (37) and arrow down (40)
        if (event.which >= 37 && event.which <= 40) return;

        // Limit number
        var txtVal = $(this).val();
        if (txtVal.length > 11) {
          $(this).val(txtVal.substring(0, 11));
          return false;
        }

        // add dot in numbers and only number is allowed (replace(/\D/g, '')).
        $(this).val(function (index, value) {
          return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });
      });

      $('.salary').on('paste', function (event) {
        // This will allow only number with dot (/^[0-9]*\.?[0-9]*$/).
        // But if we want only number without dot, we can use ( /[^\d]/ )
        var rgx = /^[0-9]*\.?[0-9]*$[^\d]/;

        if (event.originalEvent.clipboardData.getData('text').match(rgx)) {
          event.preventDefault();
        } else {
          var dataText = event.originalEvent.clipboardData.getData('text');

          // Limit number
          if (dataText.length > 11) {
            var subsData = dataText.substring(0, 11);
            var res = addDot(subsData);

            $(this).val(subsData);
            $('.salary').val(res); // Assume, we paste 200000, without if else below, it will result 200.000200000

            return false;
          } else {
            var res2 = addDot(dataText);
            $('.salary').val(res2); // Assume, we paste 200000, without if else below, it will result 200.000200000
          }

          // if 200000 is exsist, remove 200000
          if (dataText || subsData) {
            return false;
          } else {
            return true;
          }
        }
      });
    },

    store() {
      $('#loadingButton').html(
        `<div class="proc-regis"><i class='fa fa-circle-o-notch fa-spin'></i> Memproses Registrasi</div>`
      );
      $('#loadingButton').attr('disabled', true);

      console.log(this.form.status);

      // request post
      this.form
        .post('api/register-user/store')
        .then((response) => {
          var responseData = response.data;

          let agreement = this.form.agreement;
          if (agreement[0] !== 'agreement') {
            swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Kamu harus menyatakan bahwa semua data yang kamu input benar adanya!',
              footer: '<a href>Why do I have this issue?</a>',
            });
          } else {
            if (responseData.message === 'Data suami tidak ditemukan!') {
              $('#husbandUsername').addClass('is-invalid');
              $('#husbandAccKey').addClass('is-invalid');
              $('.no_husband').show();
              swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data suami tidak ditemukan!',
                footer: '<a href>Why do I have this issue?</a>',
              });
            } else if (responseData.message === 'Data ayah & ibu tidak ditemukan!') {
              $('#father-username').addClass('is-invalid');
              $('#father-account-key').addClass('is-invalid');
              $('#mother-username').addClass('is-invalid');
              $('#mother-account-key').addClass('is-invalid');
              $('.no_father').show();
              $('.no_mother').show();
              swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data ayah & ibu tidak ditemukan!',
                footer: '<a href>Why do I have this issue?</a>',
              });
            } else if (responseData.message === 'Data ayah tidak ditemukan!') {
              $('#father-username').addClass('is-invalid');
              $('#father-account-key').addClass('is-invalid');
              $('.no_father').show();
              swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data ayah tidak ditemukan!',
                footer: '<a href>Why do I have this issue?</a>',
              });
            } else if (responseData.message === 'Data ibu tidak ditemukan!') {
              $('#mother-username').addClass('is-invalid');
              $('#mother-account-key').addClass('is-invalid');
              $('.no_mother').show();
              swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data ibu tidak ditemukan!',
                footer: '<a href>Why do I have this issue?</a>',
              });
            } else {
              this.showSuccessMsg(response);
            }
          }
        })
        .catch((error) => {
          console.log(error);
          swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Tidak boleh ada field yang kosong. Pastikan semua fields terisi dengan data yang valid!',
            footer: '<a href>Why do I have this issue?</a>',
          });
        })
        .finally(() => {
          $('#loadingButton').attr('disabled', false);
          $('.proc-regis').remove();
          $('#loadingButton').html(`Register`);
        });
    },
    loadProvinces() {
      this.axios
        .get('api/json-provinces', {})
        .then((response) => {
          var responseData = response.data;
          let provinces = responseData.provinces;

          provinces.forEach(function (province) {
            $('#province_residence').append(
              '<option value="' +
                province.name +
                '" data-id="' +
                province.id +
                '">' +
                province.name +
                '</option>'
            );
            $('div.get-provinces select').val('0').change();
          });

          provinces.forEach(function (province) {
            $('#provinces2').append(
              '<option value="' +
                province.name +
                '" data-id="' +
                province.id +
                '">' +
                province.name +
                '</option>'
            );
            $('div.get-provinces2 select').val('0').change();
          });
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.loadAddresses();
        });
    },
    loadAddresses() {
      $('#province_residence').on('change', function () {
        var province_id = $(this).find(':selected').attr('data-id');

        $.get(`${BASE_URL}/api/json-regencies/` + province_id, function (data) {
          $('#regency_residence').empty();
          $('#regency_residence').append(
            '<option value="0" selected="true">=== Select Regencies ===</option>'
          );

          $('#district_residence').empty();
          $('#district_residence').append(
            '<option value="0" selected="true">=== Select Districts ===</option>'
          );

          $('#village_residence').empty();
          $('#village_residence').append(
            '<option value="0" selected="true">=== Select Villages ===</option>'
          );

          $.each(data, function (index, regenciesObj) {
            $('#regency_residence').append(
              '<option value="' +
                regenciesObj.name +
                '" data-id="' +
                regenciesObj.id +
                '">' +
                regenciesObj.name +
                '</option>'
            );
          });
        });
      });

      $('#regency_residence').on('change', function () {
        var regency_id = $(this).find(':selected').attr('data-id');

        $.get(`${BASE_URL}/api/json-districts/` + regency_id, function (data) {
          $('#district_residence').empty();
          $('#district_residence').append(
            '<option value="0" selected="true">=== Select Districts ===</option>'
          );
          $('#village_residence').empty();
          $('#village_residence').append(
            '<option value="0" selected="true">=== Select Villages ===</option>'
          );

          $.each(data, function (index, districtsObj) {
            $('#district_residence').append(
              '<option value="' +
                districtsObj.name +
                '" data-id="' +
                districtsObj.id +
                '">' +
                districtsObj.name +
                '</option>'
            );
          });
        });
      });

      $('#district_residence').on('change', function () {
        var districts_id = $(this).find(':selected').attr('data-id');

        $.get(`${BASE_URL}/api/json-village/` + districts_id, function (data) {
          $('#village_residence').empty();
          $('#village_residence').append(
            '<option value="0" selected="true">=== Select Villages ===</option>'
          );

          $.each(data, function (index, villagesObj) {
            $('#village_residence').append(
              '<option value="' +
                villagesObj.name +
                '" data-id="' +
                villagesObj.id +
                '">' +
                villagesObj.name +
                '</option>'
            );
          });
        });
      });

      ////////////////////////////////////////////////////////////////////

      $('#provinces2').on('change', function () {
        var province_id = $(this).find(':selected').attr('data-id');

        $.get(`${BASE_URL}/api/json-regencies/` + province_id, function (data) {
          $('#regencies2').empty();
          $('#regencies2').append(
            '<option value="0" selected="true">=== Select Regencies ===</option>'
          );

          $('#districts2').empty();
          $('#districts2').append(
            '<option value="0" selected="true">=== Select Districts ===</option>'
          );

          $('#villages2').empty();
          $('#villages2').append(
            '<option value="0" selected="true">=== Select Villages ===</option>'
          );

          $.each(data, function (index, regenciesObj) {
            $('#regencies2').append(
              '<option value="' +
                regenciesObj.name +
                '" data-id="' +
                regenciesObj.id +
                '">' +
                regenciesObj.name +
                '</option>'
            );
          });
        });
      });

      $('#regencies2').on('change', function () {
        var regencies_id = $(this).find(':selected').attr('data-id');

        $.get(`${BASE_URL}/api/json-districts/` + regencies_id, function (data) {
          $('#districts2').empty();
          $('#districts2').append(
            '<option value="0" selected="true">=== Select Districts ===</option>'
          );
          $('#villages2').empty();
          $('#villages2').append(
            '<option value="0" selected="true">=== Select Villages ===</option>'
          );

          $.each(data, function (index, districtsObj) {
            $('#districts2').append(
              '<option value="' +
                districtsObj.name +
                '" data-id="' +
                districtsObj.id +
                '">' +
                districtsObj.name +
                '</option>'
            );
          });
        });
      });

      $('#districts2').on('change', function () {
        var districts_id = $(this).find(':selected').attr('data-id');

        $.get(`${BASE_URL}/api/json-village/` + districts_id, function (data) {
          $('#villages2').empty();
          $('#villages2').append(
            '<option value="0" selected="true">=== Select Villages ===</option>'
          );

          $.each(data, function (index, villagesObj) {
            $('#villages2').append(
              '<option value="' +
                villagesObj.name +
                '" data-id="' +
                villagesObj.id +
                '">' +
                villagesObj.name +
                '</option>'
            );
          });
        });
      });
    },
  }, // methods:
  created() {},
  mounted() {
    $('.birth').datepicker({
      yearRange: '-100:+0',
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
    });

    $('#concentration').select2({
      disabled: true,
    });

    $('#university').select2({
      disabled: true,
    });

    this.loadJobsInSelect2();
    this.loadProvinces();
    this.validatePrice();

    // Single assign action
    $('#jobless').change(function () {
      if (this.checked) {
        $('.job-info').hide('1000');
      } else {
        $('.job-info').show('1000');
      }
    });
  },
};
</script>
<style>
.section-title {
  border: 0;
  border-bottom: 1px solid #eee;
  color: #31708f;
  padding-bottom: 5px;
  margin-right: 50px;
}
</style>
