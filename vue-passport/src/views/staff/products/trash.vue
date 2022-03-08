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
                                                        :to="{ name: 'products-index' }"
                                                        class="menu"
                                                        href="#"
                                                        >All ({{ nonTrashed }})</router-link
                                                    >
                                                </li>
                                                <li>
                                                    <router-link
                                                        :to="{ name: 'products-trash' }"
                                                        :class="
                                                            isInAllData ? 'menu current' : 'menu'
                                                        "
                                                        href="#"
                                                        >Trash ({{ trashed }})</router-link
                                                    >
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-md-8 text-right">
                                        <router-link
                                            :to="{ name: 'products-create' }"
                                            class="btn btn-success"
                                            data-toggle="modal"
                                            style="margin-top: 25px; margin-right: 7px"
                                        >
                                            <i class="fas fa-plus"></i> Add New Product
                                        </router-link>
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
                                            bulk_actions
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
                                        <option data-select2-id="38" value="restoreMultiple">
                                            Restore
                                        </option>
                                        <option data-select2-id="38" value="deleteMultiple">
                                            Delete
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
                                                @keyup="searchData"
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
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Status</th>
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
                                                :class="'data-' + product.id"
                                                v-for="product in products"
                                                :key="product.id"
                                            >
                                                <td style="text-align: center">
                                                    <input
                                                        type="checkbox"
                                                        id="select"
                                                        class="sub_chk"
                                                        :data-id="product.id"
                                                        :value="product.id"
                                                        name="selected_values[]"
                                                    />
                                                </td>
                                                <td class="align-middle">
                                                    {{
                                                        products.indexOf(product) +
                                                        1 +
                                                        (currentPage - 1) * perPage
                                                    }}
                                                </td>
                                                <td
                                                    v-if="product.images !== 'null'"
                                                    class="align-middle"
                                                >
                                                    <img
                                                        :src="`${BASE_URL}/storage/app/public/products/${
                                                            Object.values(
                                                                JSON.parse(product.images)[0]
                                                            )[1]
                                                        }`"
                                                        style="width: 56px; height: 56px"
                                                    />
                                                </td>
                                                <td v-else>No images</td>
                                                <td class="align-middle">
                                                    {{ product.product_name }}
                                                </td>
                                                <td class="align-middle">
                                                    Rp.
                                                    {{ formatNumber(product.price) }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ formatNumber(product.available_stock) }}
                                                </td>
                                                <td
                                                    v-if="product.status === 'Active'"
                                                    class="align-middle"
                                                >
                                                    <div class="form-group">
                                                        <input
                                                            type="checkbox"
                                                            name="permission[]"
                                                            data-bootstrap-switch
                                                            data-off-color="danger"
                                                            data-on-text=""
                                                            data-off-text=""
                                                            data-size="small"
                                                            class="status"
                                                            :value="product.id"
                                                            checked
                                                        />
                                                    </div>
                                                </td>
                                                <td
                                                    v-if="product.status === 'Inactive'"
                                                    class="align-middle"
                                                >
                                                    <div class="form-group">
                                                        <input
                                                            type="checkbox"
                                                            name="permission[]"
                                                            data-bootstrap-switch
                                                            data-off-color="danger"
                                                            data-on-text=""
                                                            data-off-text=""
                                                            data-size="small"
                                                            class="status"
                                                            :value="product.id"
                                                        />
                                                    </div>
                                                </td>
                                                <td style="text-align: center; width: 30%">
                                                    <a
                                                        class="btn btn-success"
                                                        style="margin-right: 7px"
                                                        href=""
                                                        @click.prevent="restore(product.id)"
                                                    >
                                                        <i class="fa fa-undo"></i> Restore
                                                    </a>
                                                    <a
                                                        class="btn btn-danger"
                                                        href=""
                                                        @click.prevent="forceDelete(product.id)"
                                                    >
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="isDataIndexPagination">
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
                                                @paginate="showAllDataIndex"
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
                                                @paginate="searchData"
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
import { Form } from 'vform';
import { BASE_URL } from '@/assets/js/base-url.js';
import 'admin-lte/dist/css/adminlte.min.css'; // conflict with frontend theme
import _ from 'lodash';
import '@/assets/css/custom.css';
import swal from 'sweetalert2';
import Nav from '../partials/Nav.vue';
import Breadcrumbs from '../partials/Breadcrumbs.vue';
import Sidebar from '../partials/Sidebar.vue';
import Footer from '../partials/Footer.vue';

export default {
    name: 'products-index',

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
            nonTrashed: 0,
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
            this.nonTrashed = responseData.non_trashed;
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

            const token = localStorage.getItem('token-staff');

            if (typeof page === 'undefined') {
                page = 1;
            }

            this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            this.axios
                .get('api/staff/products/trash', {
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
                    this.updateStatus();
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
                .get('api/staff/products/trash?items=' + val, {
                    params: {
                        page: page,
                    },
                })
                .then((response) => {
                    this.search = '';
                    this.loadData(response);
                    this.bootstrapSwitch();
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
                    .get('api/staff/products/trash/search/' + this.search, {
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

        // /softDelete() function. Function we use to delete user record by calling api/categories/{id} method DELETE.
        softDelete(id) {
            this.form.id = id;
            // sweet alert confirmation
            swal.fire({
                title: 'Are you sure?',
                text: 'You still be able to revert this!',
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
                        .delete('api/staff/products/soft-delete/' + id, {})
                        .then((response) => {
                            this.detectTrash = true;
                            this.highlightChangedRecord();
                            this.determineDefaultPage();
                            this.loadSpecificPage();
                            this.title = 'Product has been trashed successfully!';
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

        restore(id) {
            this.form.id = id;

            swal.fire({
                title: 'Are you sure?',
                text: 'You still be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!',
            }).then((result) => {
                // confirm delete?
                if (result.value) {
                    // request delete
                    this.form
                        .get('api/staff/products/restore/' + id, {})
                        .then((response) => {
                            this.detectRestore = true;
                            this.highlightChangedRecord();
                            this.determineDefaultPage();
                            this.loadSpecificPage();
                            this.title = 'Product restored successfully!';
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

        forceDelete(id) {
            this.form.id = id;

            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.value) {
                    this.form
                        .delete('api/staff/products/force-delete/' + id, {})
                        .then((response) => {
                            let responseData = response.data;
                            this.detectDelete = true;
                            this.highlightChangedRecord();
                            this.determineDefaultPage();
                            this.loadSpecificPage();
                            this.title = 'Product deleted successfully!';
                            console.log(responseData);
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
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You wont be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var join_selected_values = allVals.join(',');
                            this.axios
                                .get(
                                    'api/staff/products/force-delete-multiple/ids=' +
                                        join_selected_values
                                )
                                .then((response) => {
                                    this.detectMultipleDelete = true;
                                    this.highlightChangedRecord();
                                    this.determineDefaultPage();
                                    this.loadSpecificPage();
                                    this.title = 'Products has been deleted successfully!';
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
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You still can revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, restore it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var multipleRestoredIds = multipleVals.join(',');
                            this.axios
                                .get(
                                    'api/staff/products/restore-multiple/ids=' + multipleRestoredIds
                                )
                                .then((response) => {
                                    this.detectMultipleRestore = true;
                                    this.highlightChangedRecord();
                                    this.determineDefaultPage();
                                    this.loadSpecificPage();
                                    this.title =
                                        'Selected products has been restored successfully!';
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
        // Call /showAllDataIndex() function initially.
        this.showAllDataIndex();
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
.bootstrap-switch-small,
.bootstrap-switch,
.bootstrap-switch-wrapper,
.bootstrap-switch-focused,
.bootstrap-switch-animate,
.bootstrap-switch-off {
    width: 60.4063px;
}

.bootstrap-switch-container {
    width: 85.2032px;
    margin-left: -26.7969px;
}

.bootstrap-switch-handle-on,
.bootstrap-switch-primary {
    width: 42.8px;
}

.bootstrap-switch-label {
    width: 46.6094px;
}

.bootstrap-switch-handle-off,
.bootstrap-switch-danger {
    width: 42.8px;
}
</style>
