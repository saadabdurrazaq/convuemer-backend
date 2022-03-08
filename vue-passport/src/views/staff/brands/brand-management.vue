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
                                                        :to="{ name: 'brand-management' }"
                                                        :class="
                                                            isInAllData ? 'menu current' : 'menu'
                                                        "
                                                        href="#"
                                                        >All ({{ totalRecords }})</router-link
                                                    >
                                                </li>
                                                <li>
                                                    <router-link
                                                        :to="{ name: 'brand-management-trash' }"
                                                        class="menu"
                                                        href="#"
                                                        >Trash ({{ trashed }})</router-link
                                                    >
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
                                            <i class="fas fa-user-plus"></i> Add new brand
                                        </button>
                                    </div>
                                </div>
                                <hr />

                                <div style="float: left; padding-top: 3px; padding-right: 4px">
                                    Show
                                </div>
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
                                <div
                                    style="
                                        float: left;
                                        padding-top: 3px;
                                        padding-left: 4px;
                                        padding-right: 10px;
                                    "
                                >
                                    entries
                                </div>
                                <div style="float: left; margin-left: 4px">
                                    <select
                                        class="
                                            form-control
                                            select2bs4
                                            select2-accessible
                                            trash_multiple
                                        "
                                        style="width: 130px"
                                        data-select2-id=" 17"
                                        tabindex="-1"
                                        aria-hidden="true"
                                        v-on:change="bulkActions()"
                                    >
                                        <option selected="selected" data-select2-id="19">
                                            Bulk Actions
                                        </option>
                                        <option data-select2-id="38" value="trashMultiple">
                                            Trash
                                        </option>
                                    </select>
                                </div>
                                <div style="float: right">
                                    <form action="">
                                        <div
                                            class="input-group input-group-sm"
                                            style="width: 215px"
                                        >
                                            <input
                                                type="text"
                                                @keyup="searchBrand"
                                                placeholder="Search by name"
                                                v-model="search"
                                                class="form-control float-right"
                                            />
                                            <div class="input-group-append">
                                                <button
                                                    type="submit"
                                                    value="Filter"
                                                    class="btn btn-default"
                                                >
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="panel-body table-responsive" style="overflow: hidden">
                                    <!-- Data-table with pagination for user list. -->
                                    <table
                                        class="table table-bordered table-hover dataTable"
                                        id="cat-table"
                                    >
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">
                                                    <input
                                                        type="checkbox"
                                                        id="select-multiple"
                                                        @click="selectMultiple()"
                                                    />
                                                </th>
                                                <th>No</th>
                                                <th>Brand Name</th>
                                                <th>Brand Image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div
                                                v-if="loading"
                                                style="position: absolute; top: 50%; left: 50%"
                                            >
                                                <div class="lds-facebook">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div> 
                                            </div>
                                            <!-- Loop through each user record and display user details -->
                                            <tr
                                                :class="'data-' + brand.id"
                                                v-for="brand in brands"
                                                :key="brand.id"
                                            >
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
                                                    {{
                                                        brands.indexOf(brand) +
                                                        1 +
                                                        (currentPage - 1) * perPage
                                                    }}
                                                </td>
                                                <td class="align-middle">{{ brand.brand_name }}</td>
                                                <td v-if="brand.brand_image" class="align-middle">
                                                    <img
                                                        :src="`${BASE_URL}/storage/app/public/brands/${brand.brand_image}`"
                                                        style="width: 70px; height: 40px"
                                                    />
                                                </td>
                                                <td
                                                    v-if="!brand.brand_image"
                                                    class="align-middle"
                                                ></td>
                                                <td style="text-align: center; width: 30%">
                                                    <a
                                                        class="btn btn-info"
                                                        style="margin-right: 7px"
                                                        href=""
                                                        @click.prevent="editBrand(brand)"
                                                    >
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a
                                                        class="btn btn-warning"
                                                        href=""
                                                        @click.prevent="softDelete(brand.id)"
                                                    >
                                                        <i class="fa fa-trash"></i> Trash
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="isBrandsPagination">
                                        <nav style="margin-top: 5px" class="float-left">
                                            <p>
                                                Showing {{ from }} to {{ to }} of
                                                {{ totalRecords }} entries
                                            </p>
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
                                            <p>
                                                Showing {{ from }} to {{ to }} of
                                                {{ totalRecords }} entries
                                            </p>
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
                                            <p>
                                                Showing {{ from }} to {{ to }} of
                                                {{ totalRecords }} entries
                                            </p>
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
                                    <!-- Show/hide headings dynamically based on /isFormCreateBrandMode value (true/false) -->
                                    <h5
                                        v-show="isFormCreateBrandMode"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Add new brand
                                    </h5>
                                    <h5
                                        v-show="!isFormCreateBrandMode"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Update brand
                                    </h5>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <!-- Form for adding/updating user details. When submitted call /createBrand() function if /isFormCreateBrandMode value is true. Otherwise call /updateBrand() function. -->
                                <form
                                    @submit.prevent="
                                        isFormCreateBrandMode ? createBrand() : updateBrand()
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
                                        <div
                                            style="display: none"
                                            id="errMsg"
                                            class="box no-border"
                                        >
                                            <div class="box-tools">
                                                <p class="alert alert-warning alert-dismissible">
                                                    Only image file is allowed!
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
                                        <div
                                            v-if="loadingForm"
                                            style="position: absolute; top: 20%; left: 40%"
                                        >
                                            <div class="lds-facebook">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input
                                                v-model="form.brand_name"
                                                type="text"
                                                name="brand_name"
                                                id="brand_name"
                                                placeholder="Brand Name"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has('brand_name'),
                                                }"
                                            />
                                            <span class="text-danger" id="codeError"></span>
                                            <div
                                                style="color: red"
                                                v-if="form.errors.has('brand_name')"
                                                v-html="form.errors.get('brand_name')"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <input
                                                type="file"
                                                id="brand_image"
                                                name="brand_image"
                                                @change="handleFile"
                                            />
                                            <div
                                                style="color: red"
                                                v-if="form.errors.has('brand_image')"
                                                v-html="form.errors.get('brand_image')"
                                            />
                                        </div>
                                        <div
                                            class="array-images-forEdit"
                                            style="position: relative"
                                        >
                                            <button
                                                type="submit"
                                                @click.prevent="clearImage"
                                                value=""
                                                name="close-forEdit"
                                                class="close-forEdit"
                                                id="close-forEdit"
                                                style="
                                                    display: none;
                                                    position: absolute;
                                                    top: 0;
                                                    left: 0;
                                                    left: 5px;
                                                    margin-left: 75px;
                                                    border-style: none;
                                                    font-size: 1.5rem;
                                                    font-weight: 700;
                                                    line-height: 1;
                                                    color: #000;
                                                    text-shadow: 0 1px 0 #fff;
                                                    background-color: transparent;
                                                "
                                                aria-label="Close"
                                            >
                                                <span>&times;</span>
                                            </button>
                                            <img
                                                v-bind:src="imagePreview"
                                                width="100"
                                                height="100"
                                                v-show="showPreview"
                                            />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-dismiss="modal"
                                        >
                                            Close
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            v-show="isFormCreateBrandMode"
                                        >
                                            Save changes
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            v-show="!isFormCreateBrandMode"
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
import { Form } from 'vform';
import { BASE_URL } from '@/assets/js/base-url.js';

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

    // Declare brands (as object), form (as /vform instance) and /isFormCreateBrandMode (as boolean defaulted to 'true') inside /data() { return {} }.
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
            brands: {},
            form: new Form({
                id: '',
                brand_name: '',
                brand_image: [],
            }),
            msg: '',
            title: '',
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
            this.brands = responseData.brands.data;
            this.totalRecords = responseData.brands.total;
            this.from = responseData.brands.from;
            this.to = responseData.brands.to;
            this.currentPage = responseData.brands.current_page;
            this.trashed = responseData.total_trashed_brand;
            this.perPage = responseData.items;
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
            // for example if user trash data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
            if (_.isEmpty(this.search) === false) {
                this.defaultSearchPagination = true;
                this.isSearchPagination = true;
                this.defaultBrandsPagination = false;
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

        handleFile(event) {
            let totalImagesFile = $('#brand_image')[0].files.length;

            // Set the local file variable to what the user has selected.
            const file = event.target.files[0];

            for (let i = 0; i < totalImagesFile; i++) {
                // Set the file object onto the form...
                this.form.brand_image = file;
            }

            // Initialize a File Reader object
            let reader = new FileReader();

            /*
         Add an event listener to the reader that when the file
         has been loaded, we flag the show preview as true and set the
         image to be what was read from the reader.
      */
            reader.addEventListener(
                'load',
                function () {
                    this.showPreview = true;
                    this.imagePreview = reader.result;
                }.bind(this),
                false
            );

            // Check to see if the file is not empty.
            if (file) {
                // Ensure the file is an image file.
                if (/\.(jpe?g|png|gif)$/i.test(this.form.brand_image.name)) {
                    /*
            Fire the readAsDataURL method which will read the file in and
            upon completion fire a 'load' event which we will listen to and
            display the image in the preview.
          */
                    reader.readAsDataURL(this.form.brand_image);
                    $('#close-forEdit').show();
                } else {
                    $('#errMsg').show('fast');
                    document.getElementById('brand_image').value = '';
                    this.imagePreview = null;
                    this.showPreview = false;
                    this.form.brand_image = null;
                }
            }
        },

        closeMsg() {
            $('#errMsg').hide('slow');
            document.getElementById('brand_image').value = '';
            this.imagePreview = null;
            this.showPreview = false;
            this.form.brand_image = null;
        },

        clearImage() {
            document.getElementById('brand_image').value = '';
            this.imagePreview = null;
            this.showPreview = false;
            this.form.brand_image = null;
            $('#close-forEdit').hide();
        },

        // /GetBrands() function. Function we use to get user list by calling api/brands method GET.
        GetBrands(page) {
            this.loading = true;
            this.isBrandsPagination = true;
            this.defaultBrandsPagination = true;
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
                .get('api/staff/brand-management', {
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
            this.defaultBrandsPagination = false;
            this.defaultSearchPagination = false;
            this.isBrandsPagination = false;
            this.isSearchPagination = false;

            var val = $('select[name=showEntries] option').filter(':selected').val();

            if (typeof page === 'undefined') {
                this.page = 1;
            }

            this.axios
                .get('api/staff/brand-management?items=' + val, {
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
                    page = 1;
                }

                this.axios
                    .get('api/staff/brand-management/search/' + this.search, {
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

        // /showModal() function. Function we use to 1. Set /isFormCreateBrandMode to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating user details.
        showModal() {
            this.isFormCreateBrandMode = true;
            this.form.reset(); // v form reset
            $('#exampleModal').modal('show'); // show modal
        },

        // /createBrand() function. Function we use to store user details by calling api/brands method POST (carrying form input data).
        createBrand() {
            this.loadingForm = true;
            let formData = new FormData();

            formData.append('brand_name', this.form.brand_name);
            formData.append('brand_image', this.form.brand_image);

            console.log(this.form.brand_image);

            // request post
            this.form
                .post('api/staff/brand-management', formData)
                .then((response) => {
                    $('#exampleModal').modal('hide'); // hide modal

                    this.detectNewRecord = true;
                    this.page = 1;
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Brand/s created successfully!';
                    this.showSuccessMsg(response);
                    document.getElementById('brand_image').value = '';
                    this.imagePreview = null;
                    this.showPreview = false;
                    this.form.brand_image = null;
                })
                .catch((error) => {
                    // sweet alert fail
                    console.log(error);
                })
                .finally(() => {
                    this.loadingForm = false;
                });
        },

        // /editUser() function. Function we use to 1. Set /isFormCreateBrandMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating user details, 4. Fill form with user details.
        editBrand(brand) {
            this.isFormCreateBrandMode = false;
            this.form.reset(); // v form reset inputs
            this.form.clear(); // v form clear errors
            this.loadingForm = false;
            $('#exampleModal').modal('show'); // show modal
            this.form.fill(brand);
        },

        // /updateBrand() function. Function we use to update user details by calling api/brands/{id} method PUT (carrying form input data).
        updateBrand() {
            let myXhr;
            const token = localStorage.getItem('token-staff');
            var self = this;

            // if input image is empty, set null and false. So that, data can be updated without attaching an image.
            if (document.getElementById('brand_image').value == '') {
                self.imagePreview = null;
                self.showPreview = false;
                self.form.brand_image = null;
            }

            let formDataUpdate = new FormData();
            formDataUpdate.append('brand_name', this.form.brand_name);
            formDataUpdate.append('brand_image', this.form.brand_image);
            formDataUpdate.append('_method', 'PUT');
            let selectedImage = $('#brand_image')[0].files[0];
            formDataUpdate.append('selectedImages', selectedImage);

            $.ajaxSetup({
                url: `${BASE_URL}/api/staff/brand-management/` + this.form.id,
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
                        self.title = 'Brand updated successfully!';
                        self.showSuccessMsg(result);
                        self.loadingForm = false;
                        self.imagePreview = null;
                        self.showPreview = false;
                        document.getElementById('brand_image').value = '';
                        self.form.brand_image = null;
                    }
                },
                error: function (response) {
                    self.loadingForm = false;
                    console.log(response.responseJSON.errors.brand_name);
                    $('#brand_name').addClass('is-invalid');
                    $('#codeError').text(response.responseJSON.errors.brand_name);
                    $('.alert-danger').html('An error in your input fields');
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
                    });
                },
            });
        },

        // /softDelete() function. Function we use to delete user record by calling api/brands/{id} method DELETE.
        softDelete(id) {
            this.form.id = id;

            // sweet alert confirmation
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, trash it!',
            }).then((result) => {
                // confirm delete?
                if (result.value) {
                    // request delete
                    this.form
                        .delete('api/staff/brand-management/soft-delete/' + id, {})
                        .then((response) => {
                            this.detectTrash = true;
                            this.highlightChangedRecord();
                            this.determineDefaultPage();
                            this.loadSpecificPage();
                            this.title = 'Brand has been trashed successfully!';
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
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You still can revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, trash it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var join_selected_values = allVals.join(',');
                            this.axios
                                .get(
                                    'api/staff/brand-management/soft-delete-multiple/ids=' +
                                        join_selected_values
                                )
                                .then((response) => {
                                    this.detectMultipleTrash = true;
                                    this.highlightChangedRecord();
                                    this.determineDefaultPage();
                                    this.loadSpecificPage();
                                    this.title = 'Brand/s has been trashed successfully!';
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
