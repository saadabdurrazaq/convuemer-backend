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
                                    <div class="col-md-3">
                                        <nav class="navecation">
                                            <ul id="navi" style="margin-top: 40px">
                                                <li>
                                                    <router-link
                                                        :to="{ name: 'sub-sub-categories' }"
                                                        :class="
                                                            isInAllData ? 'menu current' : 'menu'
                                                        "
                                                        href="#"
                                                        >All ({{ totalRecords }})</router-link
                                                    >
                                                </li>
                                                <li>
                                                    <router-link
                                                        :to="{ name: 'sub-sub-categories-trash' }"
                                                        class="menu"
                                                        href="#"
                                                        >Trash ({{ trashed }})</router-link
                                                    >
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            data-toggle="modal"
                                            style="margin-top: 25px; margin-right: 7px"
                                            data-target="#exampleModal"
                                            @click.prevent="showModalCreate"
                                        >
                                            <i class="fas fa-plus"></i> Add New Sub Sub Categories
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            data-toggle="modal"
                                            style="margin-top: 25px; margin-right: 7px"
                                            data-target="#exampleModal"
                                            @click.prevent="showModalBulkAssign(category)"
                                        >
                                            <i class="fas fa-map-pin"></i> Bulk Assign
                                        </button>
                                        <router-link
                                            :to="{ name: 'categories' }"
                                            type="submit"
                                            class="btn btn-primary"
                                            style="margin-top: 25px; margin-right: 7px"
                                            ><i class="fas fa-list"></i> List of
                                            Categories</router-link
                                        >
                                        <router-link
                                            :to="{ name: 'sub-categories' }"
                                            type="submit"
                                            class="btn btn-primary"
                                            style="margin-top: 25px; margin-right: 7px"
                                            ><i class="fas fa-list"></i> List of Sub
                                            Categories</router-link
                                        >
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
                                                @keyup="searchSubSubCat"
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
                                                <th>Categories</th>
                                                <th>Sub Categories</th>
                                                <th>Sub Sub Categories</th>
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
                                                :class="'data-' + sub_sub_category.id"
                                                v-for="sub_sub_category in sub_sub_categories"
                                                :key="sub_sub_category.id"
                                            >
                                                <td style="text-align: center">
                                                    <input
                                                        type="checkbox"
                                                        id="select"
                                                        class="sub_chk"
                                                        :data-id="sub_sub_category.id"
                                                        :value="sub_sub_category.id"
                                                        name="selected_values[]"
                                                    />
                                                </td>
                                                <td class="align-middle">
                                                    {{
                                                        sub_sub_categories.indexOf(
                                                            sub_sub_category
                                                        ) +
                                                        1 +
                                                        (currentPage - 1) * perPage
                                                    }}
                                                </td>
                                                <td v-if="sub_sub_category.category !== null">
                                                    {{ sub_sub_category.category['category_name'] }}
                                                </td>
                                                <td v-if="sub_sub_category.category == null"></td>
                                                <td v-if="sub_sub_category.sub_category !== null">
                                                    {{
                                                        sub_sub_category.sub_category[
                                                            'subcategory_name'
                                                        ]
                                                    }}
                                                </td>
                                                <td
                                                    v-if="sub_sub_category.sub_category == null"
                                                ></td>
                                                <td class="align-middle">
                                                    {{ sub_sub_category.subsubcategory_name }}
                                                </td>
                                                <td style="text-align: center; width: 30%">
                                                    <a
                                                        class="btn btn-success"
                                                        style="margin-right: 7px"
                                                        href=""
                                                        @click.prevent="
                                                            showModalSingleAssign(sub_sub_category)
                                                        "
                                                    >
                                                        <i class="fas fa-map-pin"></i> Assign
                                                    </a>
                                                    <a
                                                        class="btn btn-info"
                                                        style="margin-right: 7px"
                                                        href=""
                                                        @click.prevent="
                                                            showModalEdit(sub_sub_category)
                                                        "
                                                    >
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a
                                                        class="btn btn-warning"
                                                        href=""
                                                        @click.prevent="
                                                            softDelete(sub_sub_category.id)
                                                        "
                                                    >
                                                        <i class="fa fa-trash"></i> Trash
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="isSubSubCatPagination">
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
                                                @paginate="GetSubSubCategories"
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
                                                @paginate="searchSubSubCat"
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
                                    <!-- Show/hide headings dynamically based on /isFormCreate value (true/false) -->
                                    <h5
                                        v-show="isFormCreate"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Add new sub sub category
                                    </h5>
                                    <h5
                                        v-show="isFormEdit"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Update sub sub category
                                    </h5>
                                    <h5
                                        v-show="isFormBulkAssign"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Bulk assign sub sub category
                                    </h5>
                                    <h5
                                        v-show="isFormSingleAssign"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Single assign or unassign sub sub category
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

                                <!-- Form for adding/updating user details. When submitted call /create() function if /isFormCreate value is true. Otherwise call /update() function. -->
                                <form
                                    @submit.prevent="
                                        isFormCreate
                                            ? create()
                                            : isFormEdit
                                            ? update()
                                            : isFormBulkAssign
                                            ? bulkAssign()
                                            : singleAssign()
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
                                                @click.prevent="closeModal"
                                                class="close"
                                                data-dismiss="alert"
                                                aria-label="Close"
                                            >
                                                <span aria-hidden="true">&times;</span>
                                            </button>
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
                                        <!-- Create form -->
                                        <div v-show="isFormCreate" class="form-group">
                                            <label>Sub Sub Categories</label>
                                            <input
                                                type="text"
                                                placeholder="Sub Sub Category"
                                                v-bind:name="form.subsubcategory_name"
                                                id="subsubcategory_name"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has('subsubcategory_name'),
                                                }"
                                            />
                                            <small class="text-muted"
                                                >End with a comma for single or multiple inputs.
                                                E.g: data1, data2,</small
                                            >
                                            <div
                                                style="color: red"
                                                v-if="form.errors.has('subsubcategory_name')"
                                                v-html="form.errors.get('subsubcategory_name')"
                                            />
                                        </div>
                                        <!-- Edit form -->
                                        <div v-show="isFormEdit" class="form-group">
                                            <input
                                                v-model="form.subsubcategory_name"
                                                type="text"
                                                name="name"
                                                placeholder="Sub Category Name"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has('subsubcategory_name'),
                                                }"
                                            />
                                            <div
                                                style="color: red"
                                                v-if="form.errors.has('subsubcategory_name')"
                                                v-html="form.errors.get('subsubcategory_name')"
                                            />
                                        </div>
                                        <!-- Bulk Assign form -->
                                        <div
                                            v-show="isFormBulkAssign"
                                            class="form-group get-categories"
                                        >
                                            <label>Categories</label>
                                            <select
                                                v-bind:name="form.category_id"
                                                id="category_id"
                                                class="form-control"
                                            >
                                                <option value="default" selected="true">
                                                    Select Category
                                                </option>
                                            </select>
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('category_id')"
                                                v-html="form.errors.get('category_id')"
                                            />
                                        </div>
                                        <div
                                            v-show="isFormBulkAssign"
                                            class="form-group get-sub-categories"
                                        >
                                            <label>Sub Categories</label>
                                            <select
                                                v-bind:name="form.subcategory_id"
                                                id="subcategory_id"
                                                class="form-control"
                                            >
                                                <option
                                                    value="default"
                                                    id="default-subcat"
                                                    selected="true"
                                                >
                                                    Select Sub Category
                                                </option>
                                            </select>
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('subcategory_id')"
                                                v-html="form.errors.get('subcategory_id')"
                                            />
                                        </div>
                                        <div v-show="isFormBulkAssign" class="form-group">
                                            <label>Sub Sub Categories</label>
                                            <select
                                                v-bind:name="form.subsubcategory_name"
                                                style="width: 100%"
                                                selected="selected"
                                                multiple
                                                class="form-control subsubcategory_name"
                                                id="sub_sub_cat_bulk_assign"
                                            ></select>
                                            <small class="text-muted"
                                                >All pre assigned items will be appeared inside this
                                                input fields</small
                                            >
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('subsubcategory_name')"
                                                v-html="form.errors.get('subsubcategory_name')"
                                            />
                                        </div>
                                        <!-- Single Assign form -->
                                        <div
                                            v-show="isFormSingleAssign"
                                            class="form-group get-categories2"
                                        >
                                            <label>Categories</label>
                                            <select
                                                v-bind:name="form.category_id"
                                                id="category_id2"
                                                class="form-control"
                                            >
                                                <option value="default" selected="true">
                                                    Select Category
                                                </option>
                                            </select>
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('category_id')"
                                                v-html="form.errors.get('category_id')"
                                            />
                                        </div>
                                        <div
                                            v-show="isFormSingleAssign"
                                            class="form-group get-sub-categories2"
                                        >
                                            <label>Sub Categories</label>
                                            <select
                                                v-bind:name="form.subcategory_id"
                                                id="subcategory_id2"
                                                class="form-control"
                                            >
                                                <option
                                                    value="default"
                                                    id="default-subcat"
                                                    selected="true"
                                                >
                                                    Select Sub Category
                                                </option>
                                            </select>
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('subcategory_id')"
                                                v-html="form.errors.get('subcategory_id')"
                                            />
                                        </div>
                                        <div v-show="isFormSingleAssign" class="form-group">
                                            <label>Sub Sub Category</label>
                                            <input
                                                v-model="form.subsubcategory_name"
                                                type="text"
                                                name="name"
                                                class="form-control"
                                                disabled
                                            />
                                        </div>
                                        <div v-show="isFormSingleAssign">
                                            <hr />
                                            <div class="col-8">
                                                <div class="icheck-primary">
                                                    <input
                                                        type="checkbox"
                                                        name="unassign"
                                                        value="unassign"
                                                        id="unassign"
                                                    />
                                                    <label for="unassign">
                                                        &nbsp; Unassign sub sub category
                                                    </label>
                                                </div>
                                            </div>
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
                                            v-on:click="getSubSubCatVal()"
                                            class="btn btn-primary"
                                            v-show="isFormCreate"
                                        >
                                            Save changes
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            v-show="isFormEdit"
                                        >
                                            Update
                                        </button>
                                        <button
                                            type="submit"
                                            v-on:click="getRelatedSubSubCatVal()"
                                            class="btn btn-primary"
                                            v-show="isFormBulkAssign"
                                        >
                                            Bulk Assign
                                        </button>
                                        <button
                                            type="submit"
                                            v-on:click="getSingleAssignFormData()"
                                            class="btn btn-primary"
                                            v-show="isFormSingleAssign"
                                        >
                                            Save
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
import '@/assets/js/select2.min.js'; // another related file found index.html

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

    // Declare categories (as object), form (as /vform instance) and /isFormCreate (as boolean defaulted to 'true') inside /data() { return {} }.
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
            sub_sub_categories: {},
            sub_sub_categories_id: [],
            form: new Form({
                id: '', // refer to sub sub category
                subsubcategory_name: '',
                category_id: '',
                subcategory_id: '',
                sub_sub_cat_bulk_assign: '',
                unassign: [],
            }),
            imagePreview: null,
            showPreview: false,
            isFormCreate: true,
            isFormEdit: true,
            isFormBulkAssign: true,
            isFormSingleAssign: true,
            isInAllData: true,
            loading: false,
            loadingForm: false,
            msg: '',
            title: '',
            total_sub_sub_cat: 0,
            defaultSubSubCatPagination: false,
            defaultShowEntriesPagination: false,
            defaultSearchPagination: false,
            isSubSubCatPagination: false,
            isShowEntriesPagination: false,
            isSearchPagination: false,
            detectUpdate: false,
            detectTrash: false,
            detectMultipleTrash: false,
            detectSingleAssign: false,
        };
    },

    methods: {
        getSingleAssignFormData() {
            var selected = [];
            $('input[name="unassign"]:checked').each(function () {
                selected.push($(this).val());
            });
            this.form.unassign = selected;

            this.form.category_id = $('#category_id2').val();
            this.form.subcategory_id = $('#subcategory_id2').val();
        },
        clearAndResetForm() {
            this.form.reset(); // v form reset
            this.form.clear();
        },
        clearCatSelectOption1() {
            $('#category_id')
                .find('option')
                .remove()
                .end()
                .append('<option value="default">Select Category</option>')
                .val('default');
        },
        clearCatSelectOption2() {
            $('#category_id2')
                .find('option')
                .remove()
                .end()
                .append('<option value="default">Select Category</option>')
                .val('default');
        },
        clearSubCatSelectOption1() {
            $('#subcategory_id')
                .find('option')
                .remove()
                .end()
                .append('<option value="default">Select Sub Category</option>')
                .val('default');
        },
        clearSubCatSelectOption2() {
            $('#subcategory_id2')
                .find('option')
                .remove()
                .end()
                .append('<option value="default">Select Sub Category</option>')
                .val('default');
        },
        clearAllSubCatSelectOption() {
            this.clearSubCatSelectOption1();
            this.clearSubCatSelectOption2();
        },
        clearAllCatSubCatSelectOption() {
            this.clearCatSelectOption1();
            this.clearCatSelectOption2();
            this.clearAllSubCatSelectOption();
        },
        // This method is used in bulk assign modal form
        loadCatSelectOption() {
            this.loadingForm = true;

            // Fill category input
            const token = localStorage.getItem('token-staff');
            this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            this.axios
                .get('api/staff/get-categories', {})
                .then((response) => {
                    var responseData = response.data;
                    let categories = responseData.categories;

                    categories.forEach(function (category) {
                        var option = new Option(category.category_name, category.id, true, true);
                        // Bulk assign form
                        $('#category_id').append(option);
                        $('div.get-categories select').val('default').change();
                    });

                    this.loadingForm = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.loadingForm = false;
                });
        },
        // This method is used in single and bulk assign modal form
        loadSubCatSelectOption() {
            var self = this;
            const token = localStorage.getItem('token-staff');

            // fill sub category input
            $('#category_id, #category_id2').on('change', function () {
                $('#sub_sub_cat_bulk_assign').val(null).trigger('change');
                self.clearAllSubCatSelectOption();

                var category_id = $(this).val();

                self.loadingForm = true;

                if (category_id !== 'default') {
                    $.ajax({
                        url:
                            `${BASE_URL}/api/staff/sub-sub-categories/get-sub-category/` +
                            category_id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', `Bearer ${token}`);
                        },
                        success: function (data) {
                            let subCategories = data.sub_categories;

                            subCategories.forEach(function (category) {
                                var option = new Option(
                                    category.subcategory_name,
                                    category.id,
                                    true,
                                    true
                                );
                                // Bulk assign form
                                $('#subcategory_id').append(option);
                                $('div.get-sub-categories select').val('default').change();
                            });

                            $('#subcategory_id2')
                                .find('option')
                                .remove()
                                .end()
                                .append('<option value="default">Select Sub Category</option>')
                                .val('default');

                            subCategories.forEach(function (category) {
                                var option = new Option(
                                    category.subcategory_name,
                                    category.id,
                                    true,
                                    true
                                );
                                // Bulk assign form
                                $('#subcategory_id2').append(option);
                                $('div.get-sub-categories2 select').val('default').change();
                            });

                            self.loadingForm = false;
                        },
                    });
                } else {
                    self.loadingForm = false;
                    $('#subcategory_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="default">Select Sub Category</option>')
                        .val('default');
                }
            });
        },
        selectSubCatFirstBeforeSelectSubSubCat() {
            $('#sub_sub_cat_bulk_assign').select2({
                placeholder: 'Select available sub sub categories',
                language: {
                    noResults: function () {
                        return 'Please select category and sub category first!';
                    },
                },
            });
        },
        // This used in bulk assign show modal. Called inside mounted()
        fillAndLoadSubSubCat() {
            const token = localStorage.getItem('token-staff');
            var self = this;

            // fill sub sub categories
            $('#subcategory_id').on('change', function () {
                $('#sub_sub_cat_bulk_assign').val(null).trigger('change');

                var subcategory_id = $(this).val();

                self.loadingForm = true;

                if (subcategory_id !== 'default') {
                    $.ajax({
                        url:
                            `${BASE_URL}/api/staff/sub-sub-categories/get-sub-sub-categories/` +
                            subcategory_id,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', `Bearer ${token}`);
                        },
                        success: function (data) {
                            let subSubCategories = data.sub_sub_categories;

                            // fill all related data in select2
                            subSubCategories.forEach(function (subSubCategory) {
                                var option = new Option(
                                    subSubCategory.subsubcategory_name,
                                    subSubCategory.id,
                                    true,
                                    true
                                );
                                $('#sub_sub_cat_bulk_assign').append(option);
                            });

                            // Load a rest of data in select2
                            $('#sub_sub_cat_bulk_assign').select2({
                                ajax: {
                                    url:
                                        `${BASE_URL}/api/staff/sub-sub-categories/search-sub-sub-categories/` +
                                        subcategory_id,
                                    data: function (params) {
                                        return {
                                            value: $('#sub_sub_cat_bulk_assign').val(),
                                            q: params.term,
                                        };
                                    },
                                    beforeSend: function (xhr) {
                                        xhr.setRequestHeader('Authorization', `Bearer ${token}`);
                                    },
                                    processResults: function (data) {
                                        return {
                                            results: data.map(function (item) {
                                                return {
                                                    id: item.id,
                                                    text: item.subsubcategory_name,
                                                };
                                            }),
                                        };
                                    },
                                },
                            });

                            self.loadingForm = false;
                        },
                        error: function (response) {
                            console.log(response);
                        },
                    });
                } else {
                    self.loadingForm = false;
                    $('#sub_sub_cat_bulk_assign').val(null).empty();
                    self.selectSubCatFirstBeforeSelectSubSubCat();
                }
            });

            // If user haven't selected category and sub category yet.
            this.selectSubCatFirstBeforeSelectSubSubCat();
        },
        getSubSubCatVal() {
            this.form.subsubcategory_name = $('#subsubcategory_name').val();
        },
        getRelatedSubSubCatVal() {
            // Bulk Assign form
            this.form.category_id = $('#category_id').val();
            this.form.subcategory_id = $('#subcategory_id').val();
            this.form.subsubcategory_name = $('#sub_sub_cat_bulk_assign').val();
        },
        closeModal() {
            $('#errMsg').hide('slow');
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
            this.sub_sub_categories = responseData.sub_sub_categories.data;
            this.totalRecords = responseData.sub_sub_categories.total;
            this.from = responseData.sub_sub_categories.from;
            this.to = responseData.sub_sub_categories.to;
            this.currentPage = responseData.sub_sub_categories.current_page;
            this.trashed = responseData.total_trashed_sub_sub_categories;
            this.perPage = responseData.items;
        },
        loadSpecificPage() {
            if (this.defaultSubSubCatPagination === true) {
                this.isSubSubCatPagination = true;
                this.GetSubSubCategories(this.page);
                console.log(`I am in getSubSubCat`);
            } else if (this.defaultShowEntriesPagination === true) {
                this.isShowEntriesPagination = true;
                this.showEntries(this.page);
                console.log(`I am in show entries`);
            } else if (this.defaultSearchPagination === true) {
                this.searchSubSubCat(); // the page is not defined because we should return it to page 1.
                console.log(`I am in search page`);
            } else {
                this.page = 1;
                this.GetSubSubCategories(this.page);
                console.log(`No matching option. So, I am in getSubSubCat`);
            }
        },
        determineDefaultPage() {
            // for example if user trash data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
            if (_.isEmpty(this.search) === false) {
                this.defaultSearchPagination = true;
                this.isSearchPagination = true;
                this.defaultSubSubCatPagination = false;
                this.defaultShowEntriesPagination = false;
            }
        },
        highlightNewRecords() {
            // Highlight new record if new record exist after submit
            var newRecord = document.getElementById('cat-table');
            var rows = newRecord.rows;
            var totalRows = this.total_sub_sub_cat;
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
            this.total_sub_sub_cat = 0;
        },
        highlightChangedRecord() {
            if (
                this.detectUpdate === true ||
                this.detectSingleAssign === true ||
                this.detectTrash === true
            ) {
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
            this.detectSingleAssign = false;
            this.detectTrash = false;
            this.detectMultipleTrash = false;
        },
        // /GetSubSubCategories() function. Function we use to get user list by calling api/categories method GET.
        GetSubSubCategories(page) {
            this.loading = true;
            this.isSubSubCatPagination = true;
            this.defaultSubSubCatPagination = true;
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
                .get('api/staff/sub-sub-categories', {
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
            this.defaultSubSubCatPagination = false;
            this.defaultSearchPagination = false;
            this.isSubSubCatPagination = false;
            this.isSearchPagination = false;

            var val = $('select[name=showEntries] option').filter(':selected').val();

            if (typeof page === 'undefined') {
                this.page = 1;
            }

            this.axios
                .get('api/staff/sub-sub-categories?items=' + val, {
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
        searchSubSubCat: _.debounce(function (page) {
            if (_.isEmpty(this.search)) {
                this.defaultSearchPagination = false;
                this.isSearchPagination = false;
                this.loadSpecificPage();
            } else {
                this.loading = true;

                if (this.defaultSubSubCatPagination === true) {
                    this.isSubSubCatPagination = false;
                } else if (this.defaultShowEntriesPagination === true) {
                    this.isShowEntriesPagination = false;
                }

                this.isSearchPagination = true;

                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.axios
                    .get('api/staff/sub-sub-categories/search/' + this.search, {
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
        // /showModalCreate() function. Function we use to 1. Set /isFormCreate to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating user details.
        showModalCreate() {
            this.isFormCreate = true;
            this.isFormBulkAssign = false;
            this.isFormEdit = false;
            this.isFormSingleAssign = false;
            this.clearAndResetForm(); // v form reset and clear
            $('#subsubcategory_name').tokenfield('setTokens', []);
            $('#exampleModal').modal('show'); // show modal
        },
        // /create() function. Function we use to store user details by calling api/categories method POST (carrying form input data).
        create() {
            this.loadingForm = true;

            let formData = new FormData();
            formData.append('subsubcategory_name', this.form.subsubcategory_name);

            // request post
            this.form
                .post('api/staff/sub-sub-categories', formData)
                .then((response) => {
                    var responseData = response.data;
                    this.total_sub_sub_cat = responseData.total_sub_sub_cat;

                    $('#exampleModal').modal('hide'); // hide modal

                    this.page = 1;
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Sub sub category/ies created successfully!';
                    this.showSuccessMsg(response);
                })
                .catch((error) => {
                    console.log(error);
                    console.log('sdfdsg');
                })
                .finally(() => {
                    this.loadingForm = false;
                });
        },
        // /editUser() function. Function we use to 1. Set /isFormCreate to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating user details, 4. Fill form with user details.
        showModalEdit(sub_sub_category) {
            this.isFormEdit = true;
            this.isFormCreate = false;
            this.isFormBulkAssign = false;
            this.isFormSingleAssign = false;
            this.clearAndResetForm(); // v form reset and clear
            $('#exampleModal').modal('show'); // show modal
            this.form.fill(sub_sub_category);
        },
        // /update() function. Function we use to update user details by calling api/categories/{id} method PUT (carrying form input data).
        update() {
            this.loadingForm = true;

            this.form
                .put('api/staff/sub-sub-categories/update/' + this.form.id, {})
                .then((response) => {
                    $('#exampleModal').modal('hide'); // hide modal

                    this.detectUpdate = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Sub sub category updated successfully!';
                    this.showSuccessMsg(response);
                })
                .catch((err) => {
                    console.log(err);
                })
                .finally(() => {
                    this.loadingForm = false;
                });
        },
        showModalBulkAssign(sub_sub_category) {
            this.isFormBulkAssign = true;
            this.isFormEdit = false;
            this.isFormCreate = false;
            this.isFormSingleAssign = false;

            this.clearAndResetForm(); // v form reset and clear
            this.form.fill(sub_sub_category);

            this.clearAllCatSubCatSelectOption();
            $('#sub_sub_cat_bulk_assign').val(null).trigger('change');
            $('#sub_sub_cat_bulk_assign').val(null).empty();
            $('#sub_sub_cat_bulk_assign')
                .html('')
                .select2({ data: { id: null, text: null } });
            this.selectSubCatFirstBeforeSelectSubSubCat();
            $('#exampleModal').modal({ backdrop: 'static', keyboard: false }); // show modal

            // Trigger category select option to load the data
            this.loadCatSelectOption();

            // for event listener subcategory and select2 found in mounted()
        },
        bulkAssign() {
            this.loadingForm = true;

            let formData = new FormData();
            formData.append('category_id', this.form.category_id);
            formData.append('subcategory_id', this.form.subcategory_id);
            formData.append('subsubcategory_name', this.form.subsubcategory_name);

            this.form
                .put('api/staff/sub-sub-categories/bulk-assign', {
                    data: formData,
                })
                .then((res) => {
                    console.log(res);
                    $('#exampleModal').modal('hide'); // hide modal
                    this.GetSubSubCategories();

                    this.title = 'Sub sub category/ies successfully assigned!';
                    this.showSuccessMsg(res);
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loadingForm = false;
                });
        },
        // This method is used in single assign modal form
        fillCatAndSubSelectOption() {
            this.loadingForm = true;

            // Fill category input
            const token = localStorage.getItem('token-staff');
            this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            this.axios
                .get('api/staff/sub-sub-categories/get-cat-sub-cat/' + this.form.id, {}) // The id refer to subsubcat
                .then((response) => {
                    var responseData = response.data;
                    let allCategories = responseData.all_categories;
                    let allRelatedSubCategories = responseData.all_related_sub_categories;
                    let subCategory = responseData.sub_category;
                    let category = responseData.category;

                    allCategories.forEach(function (category) {
                        var option = new Option(category.category_name, category.id, true, true);
                        // Dump all categories data
                        $('#category_id2').append(option);
                    });

                    if (allRelatedSubCategories !== undefined) {
                        allRelatedSubCategories.forEach(function (subCategory) {
                            var option = new Option(
                                subCategory.subcategory_name,
                                subCategory.id,
                                true,
                                true
                            );
                            // Dump all sub categories data
                            $('#subcategory_id2').append(option);
                        });
                    }

                    if (category !== null && subCategory !== null) {
                        category.forEach(function (category) {
                            var option = new Option(
                                category.category_name,
                                category.id,
                                true,
                                true
                            );
                            // show selected category data in the first time
                            $('div.get-categories2 select').append(option);
                        });

                        subCategory.forEach(function (subCategory) {
                            var option = new Option(
                                subCategory.subcategory_name,
                                subCategory.id,
                                true,
                                true
                            );
                            // show selected sub category data in the first time
                            $('div.get-sub-categories2 select').append(option);
                        });
                    } else {
                        $('div.get-categories2 select').val('default').change();
                        $('div.get-sub-categories2 select').val('default').change();
                    }

                    this.loadingForm = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.loadingForm = false;
                });
        },
        showModalSingleAssign(sub_sub_category) {
            this.isFormSingleAssign = true;
            this.isFormBulkAssign = false;
            this.isFormEdit = false;
            this.isFormCreate = false;
            this.clearAndResetForm(); // v form reset and clear
            this.form.fill(sub_sub_category);

            this.clearAllCatSubCatSelectOption();
            $('input[name="unassign"]').prop('checked', false);
            $('#category_id2').removeAttr('disabled');
            $('#subcategory_id2').removeAttr('disabled');
            $('#exampleModal').modal('show'); // show modal

            // Trigger select option to load the data
            this.fillCatAndSubSelectOption();
        },
        singleAssign() {
            this.loadingForm = true;

            let formData = new FormData();
            formData.append('category_id', this.form.category_id);
            formData.append('subcategory_id', this.form.subcategory_id);
            formData.append('unassign', this.form.unassign);

            this.form
                .put('api/staff/sub-sub-categories/single-assign/' + this.form.id, {
                    data: formData,
                })
                .then((response) => {
                    $('#exampleModal').modal('hide'); // hide modal
                    this.detectSingleAssign = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Sub sub category assigned successfully!';
                    this.showSuccessMsg(response);
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loadingForm = false;
                });
        },
        // /softDelete() function. Function we use to delete user record by calling api/categories/{id} method DELETE.
        softDelete(id) {
            this.form.id = id;

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
                        .delete('api/staff/sub-sub-categories/soft-delete/' + id, {})
                        .then((response) => {
                            this.detectTrash = true;
                            this.highlightChangedRecord();
                            this.determineDefaultPage();
                            this.loadSpecificPage();
                            this.title = 'Sub sub category has been trashed successfully!';
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
                                    'api/staff/sub-sub-categories/soft-delete-multiple/ids=' +
                                        join_selected_values
                                )
                                .then((response) => {
                                    this.detectMultipleTrash = true;
                                    this.highlightChangedRecord();
                                    this.determineDefaultPage();
                                    this.loadSpecificPage();
                                    this.title =
                                        'Sub sub category/ies has been trashed successfully!';
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
        // Call /GetSubSubCategories() function initially.
        this.GetSubSubCategories();
    },
    mounted() {
        console.log('Component mounted.');

        // prevent sweetalert error if user change the route when swal is still visible.
        if (swal.isVisible()) {
            document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
        }

        $('#subsubcategory_name').tokenfield({
            showAutocompleteOnFocus: false,
        });

        // Bulk and single assign show modal
        this.loadSubCatSelectOption();
        // Bulk assign show modal
        this.fillAndLoadSubSubCat();

        // Single assign action
        $('#unassign').change(function () {
            if (this.checked) {
                $('#category_id2').attr('disabled', 'disabled');
                $('#subcategory_id2').attr('disabled', 'disabled');
                $('div.get-categories2 select').val('default').change();
                $('div.get-sub-categories2 select').val('default').change();
            } else {
                $('#category_id2').removeAttr('disabled');
                $('#subcategory_id2').removeAttr('disabled');
            }
        });
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
