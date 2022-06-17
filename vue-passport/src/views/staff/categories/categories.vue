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
                                                        :to="{ name: 'categories' }"
                                                        :class="
                                                            isInAllData ? 'menu current' : 'menu'
                                                        " 
                                                        href="#"
                                                        >All ({{ totalRecords }})</router-link
                                                    >
                                                </li>
                                                <li> 
                                                    <router-link
                                                        :to="{ name: 'categories-trash' }"
                                                        class="menu"
                                                        href="#"
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
                                            @click.prevent="showCreateModal"
                                        >
                                            <i class="fas fa-plus"></i> Add new categories
                                        </button>
                                        <router-link
                                            :to="{ name: 'sub-categories' }"
                                            type="submit"
                                            class="btn btn-primary"
                                            style="margin-top: 25px; margin-right: 7px"
                                            ><i class="fas fa-list"></i> List of Sub
                                            Categories</router-link
                                        >
                                        <router-link
                                            :to="{ name: 'sub-sub-categories' }"
                                            type="submit"
                                            class="btn btn-primary"
                                            style="margin-top: 25px; margin-right: 7px"
                                            ><i class="fas fa-list"></i> List of Sub Sub
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
                                            style="width: 260px"
                                        >
                                            <input
                                                type="text"
                                                @keyup="searchCatAndSubCat"
                                                placeholder="Search categories or sub categories"
                                                v-model="search"
                                                class="form-control float-right search"
                                                id="search"
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
                                                <th>Categories Icon</th>
                                                <th>Categories Name</th>
                                                <th>Sub & Sub Sub Categories</th>
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
                                                :class="'data-' + category.id"
                                                v-for="category in categories"
                                                :key="category.id"
                                            >
                                                <td style="text-align: center">
                                                    <input
                                                        type="checkbox"
                                                        id="select"
                                                        class="sub_chk"
                                                        :data-id="category.id"
                                                        :value="category.id"
                                                        name="selected_values[]"
                                                    />
                                                </td>
                                                <td class="align-middle">
                                                    {{
                                                        categories.indexOf(category) +
                                                        1 +
                                                        (currentPage - 1) * perPage
                                                    }}
                                                </td>
                                                <td
                                                    v-if="category.category_icon"
                                                    class="align-middle"
                                                >
                                                    <span
                                                        ><i :class="category.category_icon"></i
                                                    ></span>
                                                </td>
                                                <td class="align-middle">
                                                    {{ category.category_name }}
                                                </td>
                                                <td
                                                    v-if="
                                                        category && category.sub_category.length > 0
                                                    "
                                                >
                                                    <div
                                                        style="float: left; padding-right: 5px"
                                                        v-for="(
                                                            subCategory, index
                                                        ) in category.sub_category"
                                                        :key="index"
                                                    >
                                                        {{ subCategory.subcategory_name }}
                                                        <a
                                                            href=""
                                                            @click.prevent="
                                                                showAssignSubSubCatModal(
                                                                    subCategory
                                                                )
                                                            "
                                                            >({{
                                                                subCategory.sub_sub_category.length
                                                            }})</a
                                                        >,
                                                    </div>
                                                </td>
                                                <td
                                                    v-if="category.sub_category.length === 0"
                                                    style="color: #606770"
                                                >
                                                    No related sub and sub-sub category for this
                                                    category.
                                                </td>
                                                <td style="text-align: center; width: 30%">
                                                    <a
                                                        class="btn btn-success"
                                                        style="margin-right: 7px"
                                                        href=""
                                                        @click.prevent="showAssignModal(category)"
                                                    >
                                                        <i class="fas fa-map-pin"></i> Assign
                                                    </a>
                                                    <a
                                                        class="btn btn-info"
                                                        style="margin-right: 7px"
                                                        href=""
                                                        @click.prevent="showEditModal(category)"
                                                    >
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a
                                                        class="btn btn-warning"
                                                        href=""
                                                        @click.prevent="softDelete(category.id)"
                                                    >
                                                        <i class="fa fa-trash"></i> Trash
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="isCategoriesPagination">
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
                                                @paginate="GetCategories"
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
                                                @paginate="searchCatAndSubCat"
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
                                    <!-- Show/hide headings dynamically based on /isFormCreateCategoryMode value (true/false) -->
                                    <h5
                                        v-show="isFormCreateCategoryMode"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Add new category
                                    </h5>
                                    <h5
                                        v-show="isFormEditCategoryMode"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Update category
                                    </h5>
                                    <h5
                                        v-show="isFormAssignCategoryMode"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Assign/Unassign category
                                    </h5>
                                    <h5
                                        v-show="isFormAssignSubSubCat"
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Assign/Unassign sub sub category
                                    </h5>
                                    <button
                                        type="button"
                                        v-on:click="closeModalWithX()"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <!-- Form for adding/updating user details. When submitted call /createCategory() function if /isFormCreateCategoryMode value is true. Otherwise call /updateCategory() function. -->
                                <form
                                    @submit.prevent="
                                        isFormCreateCategoryMode
                                            ? createCategory()
                                            : isFormEditCategoryMode
                                            ? updateCategory()
                                            : isFormAssignCategoryMode
                                            ? assignCategory()
                                            : assignSubSubCat()
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
                                        <div v-show="isFormCreateCategoryMode" class="form-group">
                                            <label>Category/ies</label>
                                            <input
                                                type="text"
                                                placeholder="Category Name"
                                                v-bind:name="form.category_name"
                                                id="category_name"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has('category_name'),
                                                }"
                                            />
                                            <small class="text-muted"
                                                >End with a comma for single or multiple inputs.
                                                E.g: data1, data2,</small
                                            >
                                            <div
                                                style="color: red"
                                                v-if="form.errors.has('category_name')"
                                                v-html="form.errors.get('category_name')"
                                            />
                                            <div
                                                class="errorName"
                                                style="color: red; display: none"
                                                v-html="
                                                    `Total data of category name must be the same as category icon data!`
                                                "
                                            />
                                        </div>
                                        <div v-show="isFormCreateCategoryMode" class="form-group">
                                            <label>Sub Category/ies FA Icon</label>
                                            <input
                                                type="text"
                                                placeholder="Category Icon"
                                                v-bind:name="form.category_icon"
                                                id="category_icon"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has('category_icon'),
                                                }"
                                            />
                                            <small class="text-muted"
                                                >End with a comma for single or multiple inputs.
                                                E.g: data1, data2,</small
                                            >
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('category_icon')"
                                                v-html="form.errors.get('category_icon')"
                                            />
                                            <div
                                                class="errorIcon"
                                                style="color: red; display: none"
                                                v-html="
                                                    `Total data of Input category icon must be the same as category name data!`
                                                "
                                            />
                                        </div>
                                        <!-- Edit form -->
                                        <div v-show="isFormEditCategoryMode" class="form-group">
                                            <label>Category</label>
                                            <input
                                                v-model="form.category_name"
                                                type="text"
                                                placeholder="Category Name"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has('category_name'),
                                                }"
                                            />
                                            <div
                                                style="color: red"
                                                v-if="form.errors.has('category_name')"
                                                v-html="form.errors.get('category_name')"
                                            />
                                        </div>
                                        <div v-show="isFormEditCategoryMode" class="form-group">
                                            <label>Category Icon</label>
                                            <input
                                                v-model="form.category_icon"
                                                type="text"
                                                placeholder="Category Icon"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has('category_icon'),
                                                }"
                                            />
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('category_icon')"
                                                v-html="form.errors.get('category_icon')"
                                            />
                                        </div>
                                        <!-- Assign form -->
                                        <div v-show="isFormAssignCategoryMode" class="form-group">
                                            <input
                                                v-model="form.id"
                                                class="form-control"
                                                type="hidden"
                                                name="categoryid"
                                                id="categoryid"
                                            />
                                            <label>Category</label>
                                            <input
                                                v-model="form.category_name"
                                                type="text"
                                                placeholder="Category Name"
                                                class="form-control"
                                                readonly
                                            />
                                        </div>
                                        <div v-show="isFormAssignCategoryMode" class="form-group">
                                            <label>Sub Categories</label>
                                            <select
                                                v-bind:name="form.sub_categories"
                                                style="width: 100%"
                                                selected="selected"
                                                multiple
                                                class="form-control sub_categories"
                                                id="sub_categories"
                                            ></select>
                                            <small class="text-muted"
                                                >All trashed sub categories are not shown
                                                here!</small
                                            >
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('sub_categories')"
                                                v-html="form.errors.get('sub_categories')"
                                            />
                                        </div>
                                        <div v-show="isFormAssignCategoryMode">
                                            <hr />
                                            <div class="icheck-primary">
                                                <input
                                                    type="checkbox"
                                                    name="unassign"
                                                    value="unassign"
                                                    id="unassign"
                                                />
                                                <label for="unassign">
                                                    &nbsp; Unassign all sub category/ies
                                                </label>
                                            </div>
                                            <small class="text-muted"
                                                >Note:<br />
                                                All relationship data also will be removed if you
                                                remove sub category/ies</small
                                            >
                                        </div>
                                        <!-- Assign sub sub cat form -->
                                        <div v-show="isFormAssignSubSubCat" class="form-group">
                                            <input
                                                v-model="form.category_id"
                                                class="form-control"
                                                type="hidden"
                                                name="categoryid"
                                                id="categoryid"
                                            />
                                            <label>Category</label>
                                            <input
                                                type="text"
                                                v-model="form.category_name"
                                                placeholder="Category Name"
                                                class="form-control"
                                                readonly
                                            />
                                        </div>
                                        <div v-show="isFormAssignSubSubCat" class="form-group">
                                            <label>Sub Category</label>
                                            <input
                                                type="text"
                                                v-model="form.subcategory_name"
                                                placeholder="Sub Category Name"
                                                class="form-control"
                                                readonly
                                            />
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('subcategory_name')"
                                                v-html="form.errors.get('subcategory_name')"
                                            />
                                        </div>
                                        <div v-show="isFormAssignSubSubCat" class="form-group">
                                            <label>Sub Sub Categories</label>
                                            <select
                                                v-bind:name="form.sub_sub_categories"
                                                style="width: 100%"
                                                selected="selected"
                                                multiple
                                                class="form-control sub_sub_categories"
                                                id="sub_sub_cat"
                                            ></select>
                                            <small class="text-muted"
                                                >All trashed sub sub categories are not shown
                                                here!</small
                                            >
                                            <div
                                                style="color: red"
                                                class="errorIcon"
                                                v-if="form.errors.has('sub_sub_categories')"
                                                v-html="form.errors.get('sub_sub_categories')"
                                            />
                                        </div>
                                        <div v-show="isFormAssignSubSubCat">
                                            <hr />
                                            <div class="icheck-primary">
                                                <input
                                                    type="checkbox"
                                                    name="unassign-subsubcat"
                                                    value="unassign-subsubcat"
                                                    id="unassign-subsubcat"
                                                />
                                                <label for="unassign-subsubcat">
                                                    &nbsp; Unassign all sub sub category/ies
                                                </label>
                                            </div>
                                            <small class="text-muted"
                                                >Note:<br />
                                                All relationship data also will be removed if you
                                                remove sub sub category/ies</small
                                            >
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
                                            v-on:click="getCategoriesInput()"
                                            class="btn btn-primary"
                                            v-show="isFormCreateCategoryMode"
                                        >
                                            Save changes
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            v-show="isFormEditCategoryMode"
                                        >
                                            Update
                                        </button>
                                        <button
                                            type="submit"
                                            v-on:click="getSubCategoriesInput()"
                                            class="btn btn-primary"
                                            v-show="isFormAssignCategoryMode"
                                        >
                                            Save
                                        </button>
                                        <button
                                            type="submit"
                                            v-on:click="getSubSubCategoriesInput()"
                                            class="btn btn-primary"
                                            v-show="isFormAssignSubSubCat"
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
import '@/assets/js/select2.min.js';

export default {
    name: 'categories',

    beforeCreate: function () {
        document.body.className = 'home-staff';
    },

    components: {
        Nav,
        Breadcrumbs,
        Sidebar,
        Footer,
    },

    // Declare categories (as object), form (as /vform instance) and /isFormCreateCategoryMode (as boolean defaulted to 'true') inside /data() { return {} }.
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
            categories: {},
            msg: '',
            title: '',
            form: new Form({
                id: '',
                category_name: '',
                category_icon: '',
                sub_categories: [],
                sub_sub_categories: '',
                unassign: [],
                subcategory_name: '',
                category_id: '',
                unassign_subsubcat: [],
            }),
            imagePreview: null,
            showPreview: false,
            isFormCreateCategoryMode: true,
            isFormEditCategoryMode: true,
            isFormAssignCategoryMode: true,
            isFormAssignSubSubCat: true,
            isInAllData: true,
            loading: false,
            loadingForm: false,
            isCategoriesPagination: false,
            isShowEntriesPagination: false,
            isSearchPagination: false,
            defaultCategoriesPagination: false,
            defaultShowEntriesPagination: false,
            defaultSearchPagination: false,
            total_category_names: 0,
            total_category_icons: 0,
            detectUpdate: false,
            detectTrash: false,
            detectMultipleTrash: false,
            detectAssignSubCat: false,
            detectAssignSubSubCat: false,
            selectedValues: [],
        };
    },

    methods: {
        getCategoriesInput() {
            this.form.category_name = $('#category_name').val();
            this.form.category_icon = $('#category_icon').val();
        },

        getSubCategoriesInput() {
            var selected = [];
            $('input[name="unassign"]:checked').each(function () {
                selected.push($(this).val());
            });
            this.form.unassign = selected;

            this.form.sub_categories = $('#sub_categories').val();
        },

        getSubSubCategoriesInput() {
            var selected = [];
            $('input[name="unassign-subsubcat"]:checked').each(function () {
                selected.push($(this).val());
            });
            this.form.unassign_subsubcat = selected;

            this.form.sub_sub_categories = $('#sub_sub_cat').val();
        },

        closeModalWithX() {
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
            this.categories = responseData.categories.data;
            this.totalRecords = responseData.categories.total;
            this.from = responseData.categories.from;
            this.to = responseData.categories.to;
            this.currentPage = responseData.categories.current_page;
            this.trashed = responseData.total_trashed_categories;
            this.perPage = responseData.items;
        },

        loadSpecificPage() {
            if (this.defaultCategoriesPagination === true) {
                this.isCategoriesPagination = true;
                this.GetCategories(this.page);
                console.log(`I am in getCat`);
            } else if (this.defaultShowEntriesPagination === true) {
                this.isShowEntriesPagination = true;
                this.showEntries(this.page);
                console.log(`I am in show entries`);
            } else if (this.defaultSearchPagination === true) {
                this.searchCatAndSubCat(); // the page is not defined because we should return it to page 1.
                console.log(`I am in search page`);
            } else {
                this.page = 1;
                this.GetCategories(this.page);
                console.log(`No matching option. So, I am in getCat`);
            }
        },

        determineDefaultPage() {
            // for example if user trash data in show entries page, after submit he should be directed to show entries page as well with same page (if he was in page 3, he should be directed in page 3. etc...)
            if (_.isEmpty(this.search) === false) {
                this.defaultSearchPagination = true;
                this.isSearchPagination = true;
                this.defaultCategoriesPagination = false;
                this.defaultShowEntriesPagination = false;
            }
        },

        highlightNewRecords() {
            // Highlight new record if new record exist after submit
            var newRecord = document.getElementById('cat-table');
            var rows = newRecord.rows;
            var totalRows = this.total_category_names;
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
            this.total_category_names = 0;
        },

        highlightChangedRecord() {
            if (
                this.detectUpdate === true ||
                this.detectAssignSubCat === true ||
                this.detectTrash === true
            ) {
                $('.data-' + this.form.id)
                    .toggleClass('highlight')
                    .fadeOut(1500, function () {
                        $(this).toggleClass('highlight').fadeIn(1);
                    });
            } else if (this.detectAssignSubSubCat === true) {
                $('.data-' + this.form.category_id)
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
            this.detectAssignSubCat = false;
            this.detectAssignSubSubCat = false;
            this.detectTrash = false;
            this.detectMultipleTrash = false;
        },

        // /GetCategories() function. Function we use to get user list by calling api/categories method GET.
        GetCategories(page) {
            this.loading = true;
            this.isCategoriesPagination = true;
            this.defaultCategoriesPagination = true;
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
                .get('api/staff/categories', {
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
            this.defaultCategoriesPagination = false;
            this.defaultSearchPagination = false;
            this.isCategoriesPagination = false;
            this.isSearchPagination = false;

            var val = $('select[name=showEntries] option').filter(':selected').val();

            if (typeof page === 'undefined') {
                this.page = 1;
            }

            this.axios
                .get('api/staff/categories?items=' + val, {
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

        searchCatAndSubCat: _.debounce(function (page) {
            if (_.isEmpty(this.search)) {
                this.defaultSearchPagination = false;
                this.isSearchPagination = false;
                this.loadSpecificPage();
            } else {
                this.loading = true;

                if (this.defaultCategoriesPagination === true) {
                    this.isCategoriesPagination = false;
                } else if (this.defaultShowEntriesPagination === true) {
                    this.isShowEntriesPagination = false;
                }

                this.isSearchPagination = true;

                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.axios
                    .get('api/staff/categories/search/' + this.search, {
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

        // /showCreateModal() function. Function we use to 1. Set /isFormCreateCategoryMode to 'true', 2. Reset form data, 3. Show modal containing dynamic form for adding/updating user details.
        showCreateModal() {
            this.isFormCreateCategoryMode = true;
            this.isFormEditCategoryMode = false;
            this.isFormAssignCategoryMode = false;
            this.isFormAssignSubSubCat = false;
            this.form.reset(); // v form reset
            $('#exampleModal').on('shown.bs.modal', function () {
                $('.modal').css('display', 'block');
            });
        },

        // /createCategory() function. Function we use to store user details by calling api/categories method POST (carrying form input data).
        createCategory() {
            this.loadingForm = true;

            $('#category_name').tokenfield('setTokens', []);
            $('#category_icon').tokenfield('setTokens', []);

            let formData = new FormData();
            formData.append('category_name', this.form.category_name);
            formData.append('category_icon', this.form.category_icon);

            // request post
            this.form
                .post('api/staff/categories', formData)
                .then((response) => {
                    var responseData = response.data;
                    this.total_category_names = responseData.total_category_names; // kiriman dari controller (responseData)
                    this.total_category_icons = responseData.total_category_icons;

                    if (this.total_category_names !== this.total_category_icons) {
                        $('.errorName').show();
                        $('.errorIcon').show();
                    } else {
                        $('#exampleModal').modal('hide'); // hide modal
                        $('.modal-backdrop').remove();

                        this.page = 1;
                        this.determineDefaultPage();
                        this.loadSpecificPage();
                        this.title = 'Category/ies created successfully!';
                        this.showSuccessMsg(response);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loadingForm = false;
                });
        },

        // /showEditModal() function. Function we use to 1. Set /isFormCreateCategoryMode to 'false', 2. Reset and clear form data, 3. Show modal containing dynamic form for adding/updating user details, 4. Fill form with user details.
        showEditModal(category) {
            this.isFormEditCategoryMode = true;
            this.isFormCreateCategoryMode = false;
            this.isFormAssignCategoryMode = false;
            this.isFormAssignSubSubCat = false;
            this.form.reset(); // v form reset inputs
            this.form.clear(); // v form clear errors
            $('#exampleModal').modal('show'); // show modal
            this.form.fill(category);
        },

        // /updateCategory() function. Function we use to update user details by calling api/categories/{id} method PUT (carrying form input data).
        updateCategory() {
            this.loadingForm = true;

            // request put
            this.form
                .put('api/staff/categories/update/' + this.form.id, {}) 
                .then((response) => {
                    $('#exampleModal').modal('hide'); // hide modal
                    this.detectUpdate = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Category updated successfully!';
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

        fillSubCat() {
            this.loadingForm = true;

            this.form
                .get(`api/staff/categories/get-sub-categories/` + this.form.id, {}) // id refer to category id.
                .then((response) => {
                    var responseData = response.data;
                    let subCategoryNames = responseData.sub_categories;
                    let total_sub_categories = responseData.total_sub_categories;

                    if (total_sub_categories > 0) {
                        // Show related data in select box
                        subCategoryNames.forEach(function (subCategory) {
                            var option = new Option(
                                subCategory.subcategory_name,
                                subCategory.id,
                                true,
                                true
                            );
                            $('#sub_categories').append(option).trigger('change');
                        });
                        this.loadingForm = false;
                    } else {
                        this.loadingForm = false;
                    }
                })
                .catch((error) => {
                    // sweet alert fail
                    console.log(error);
                });
        },

        loadSubCatInSelect2() {
            const token = localStorage.getItem('token-staff');
            $('#sub_categories').select2({
                placeholder: 'Select available sub categories',
                ajax: {
                    url:
                        `${BASE_URL}/api/staff/categories/load-sub-cat-wheredoesnthave-cat-orwherehas-cat-where-cat-id/` +
                        this.form.id,
                    data: function (params) {
                        return {
                            value: $('#sub_categories').val(),
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
                                    text: item.subcategory_name,
                                };
                            }),
                        };
                    },
                },
            });
        },

        showAssignModal(category) {
            this.isFormAssignCategoryMode = true;
            this.isFormEditCategoryMode = false;
            this.isFormCreateCategoryMode = false;
            this.isFormAssignSubSubCat = false;
            this.form.reset(); // v form reset inputs
            this.form.clear(); // v form clear errors
            this.form.fill(category);

            $('#sub_categories').val(null).trigger('change');
            $('#sub_categories').val(null).empty();
            $('input[name="unassign"]').prop('checked', false);
            $('#sub_categories').removeAttr('disabled');
            $('#exampleModal').modal('show'); // show modal

            if ($('#sub_categories').val(null)) {
                this.fillSubCat();
                this.loadSubCatInSelect2();
            }
        },

        assignCategory() {
            this.loadingForm = true;

            let formData = new FormData();
            formData.append('id', this.form.id);
            formData.append('sub_categories', this.form.sub_categories);
            formData.append('unassign', this.form.unassign);

            this.form
                .post(`api/staff/categories/assign`, {
                    data: formData,
                })
                .then((response) => {
                    $('#exampleModal').modal('hide'); // hide modal
                    this.detectAssignSubCat = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Category assigned successfully!';
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

        loadSubSubCatInSelect2() {
            const token = localStorage.getItem('token-staff');
            $('#sub_sub_cat').select2({
                placeholder: 'Select available sub sub categories',
                ajax: {
                    url:
                        `${BASE_URL}/api/staff/categories/load-sub-sub-cat-wheredoesnthave-subcat-orwherehas-subcat-where-subcat-id/` +
                        this.form.id,
                    data: function (params) {
                        return {
                            value: $('#sub_sub_cat').val(),
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
        },

        fillCatAndSubSubCat() {
            this.loadingForm = true;

            this.form
                .get(
                    `api/staff/categories/select-sub-sub-cat-wherehas-sub-cat-where-sub-cat-id/` +
                        this.form.id,
                    {}
                )
                .then((response) => {
                    var responseData = response.data;
                    let subCategory = responseData.sub_category;

                    for (let i = 0; i < subCategory.length; i++) {
                        this.form.category_id = subCategory[i].category_id;
                        this.form.category_name = subCategory[i].category.category_name;
                        let subSubCategories = subCategory[i].sub_sub_category;

                        // fill all related data in select2
                        subSubCategories.forEach(function (subSubCategory) {
                            var option = new Option(
                                subSubCategory.subsubcategory_name,
                                subSubCategory.id,
                                true,
                                true
                            );
                            $('#sub_sub_cat').append(option).trigger('change');
                        });
                    }

                    this.loadingForm = false;
                })
                .catch((error) => {
                    // sweet alert fail
                    console.log(error);
                });
        },

        showAssignSubSubCatModal(subCat) {
            this.isFormAssignSubSubCat = true;
            this.isFormAssignCategoryMode = false;
            this.isFormEditCategoryMode = false;
            this.isFormCreateCategoryMode = false;
            this.form.reset(); // v form reset inputs
            this.form.clear(); // v form clear errors
            this.form.fill(subCat); // fill subcat

            $('#sub_sub_cat').val(null).trigger('change');
            $('#sub_sub_cat').val(null).empty();
            $('input[name="unassign-subsubcat"]').prop('checked', false);
            $('#sub_sub_cat').removeAttr('disabled');
            $('#exampleModal').modal('show'); // show modal

            this.fillCatAndSubSubCat();
            this.loadSubSubCatInSelect2();
        },

        assignSubSubCat() {
            this.loadingForm = true;

            let formData = new FormData();
            formData.append('id', this.form.id);
            formData.append('unassign_subsubcat', this.form.unassign_subsubcat);
            formData.append('category_id', this.form.category_id);
            formData.append('sub_sub_categories', this.form.sub_sub_categories); 

            this.form
                .post(`api/staff/categories/assign-sub-sub-cat`, {
                    data: formData,
                })
                .then((response) => {
                    $('#exampleModal').modal('hide'); // hide modal
                    this.detectAssignSubSubCat = true;
                    this.highlightChangedRecord();
                    this.determineDefaultPage();
                    this.loadSpecificPage();
                    this.title = 'Sub sub category has been assigned successfully!';
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
                        .delete('api/staff/categories/soft-delete/' + id, {})
                        .then((response) => {
                            this.detectTrash = true;
                            this.highlightChangedRecord();
                            this.determineDefaultPage();
                            this.loadSpecificPage();
                            this.title = 'Category has been trashed successfully!';
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
                                    'api/staff/categories/soft-delete-multiple/ids=' +
                                        join_selected_values
                                )
                                .then((response) => {
                                    this.detectMultipleTrash = true;
                                    this.highlightChangedRecord();
                                    this.determineDefaultPage();
                                    this.loadSpecificPage();
                                    this.title = 'Category has been trashed successfully!';
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
        // Call /GetCategories() function initially.
        this.GetCategories();
    },

    mounted() {
        console.log('Component mounted.');
        //this.$Progress.finish();
        var self = this;

        // prevent sweetalert error if user change the route when swal is still visible.
        if (swal.isVisible()) {
            document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
        }

        $('#category_name').tokenfield({
            showAutocompleteOnFocus: false,
        });

        $('#category_icon').tokenfield({
            showAutocompleteOnFocus: false,
        });

        // Single assign action
        $('#unassign').change(function () {
            if (this.checked) {
                $('#sub_categories').attr('disabled', 'disabled');
                $('#sub_categories').val(null).trigger('change');
                $('#sub_categories').val(null).empty();
            } else {
                $('#sub_categories').removeAttr('disabled');
                self.fillSubCat();
            }
        });

        // assign or unassign subsubcat
        $('#unassign-subsubcat').change(function () {
            if (this.checked) {
                $('#sub_sub_cat').attr('disabled', 'disabled');
                $('#sub_sub_cat').val(null).trigger('change');
                $('#sub_sub_cat').val(null).empty();
            } else {
                $('#sub_sub_cat').removeAttr('disabled');
                self.fillCatAndSubSubCat();
            }
        });
    },
};
</script>

<style type="scss">
body { padding-right: 0 !important }
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
