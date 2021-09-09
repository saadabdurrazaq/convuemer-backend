<template>
    <div class="wrapper">
        <Nav />
        <Sidebar />
        <div class="content-wrapper">
            <Breadcrumbs />
            <div class="content">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-body">
                                <form @submit.prevent="store()" novalidate>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">Info Product:</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_name">Product Name</label>
                                                    <input
                                                        id="product_name"
                                                        v-model="form.product_name"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('product_name'),
                                                        }"
                                                        type="text"
                                                        class="form-control"
                                                        name="product_name"
                                                        required
                                                        autocomplete="product_name"
                                                        autofocus
                                                    />
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('product_name')"
                                                        v-html="form.errors.get('product_name')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group get-brands">
                                                    <label for="nickname">Brand</label>
                                                    <select
                                                        v-bind:name="form.brand"
                                                        id="brand"
                                                        class="form-control"
                                                    >
                                                        <option value="default" selected="true">
                                                            Select Brand
                                                        </option>
                                                    </select>
                                                    <div
                                                        style="color: red"
                                                        class="errorIcon"
                                                        v-if="form.errors.has('brand')"
                                                        v-html="form.errors.get('brand')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group get-categories">
                                                    <label for="nik">Category</label>
                                                    <select
                                                        v-model="form.category_id"
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
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group get-sub-categories">
                                                    <label for="nik">Sub Category</label>
                                                    <select
                                                        v-model="form.subcategory_id"
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
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group get-sub-sub-categories">
                                                    <label for="citizenship"
                                                        >Sub-sub Category</label
                                                    >
                                                    <select
                                                        v-model="form.subsubcategory_id"
                                                        id="subsubcategory_id"
                                                        class="form-control"
                                                    >
                                                        <option
                                                            value="default"
                                                            id="default-subcat"
                                                            selected="true"
                                                        >
                                                            Select Sub Sub Category
                                                        </option>
                                                    </select>
                                                    <div
                                                        style="color: red"
                                                        class="errorIcon"
                                                        v-if="form.errors.has('subsubcategory_id')"
                                                        v-html="
                                                            form.errors.get('subsubcategory_id')
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="weight">Stock</label>
                                                <div class="input-group mb-3">
                                                    <input
                                                        id="weight"
                                                        type="text"
                                                        class="form-control"
                                                        name="weight"
                                                        value=""
                                                        required
                                                        autocomplete="weight"
                                                        autofocus
                                                        aria-label="Amount (to the nearest dollar)"
                                                    />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Kg</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">
                                                        Detail Product:
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- row 1 -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="username">Short Description</label>
                                                    <input
                                                        v-model="form.username"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('username'),
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="account_key"
                                                        >Long Description</label
                                                    >
                                                    <input
                                                        v-model="form.account_key"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('account_key'),
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
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="gender"
                                                            >Product Condition</label
                                                        >
                                                        <br />
                                                        <input
                                                            value="Male"
                                                            type="radio"
                                                            id="male"
                                                            name="gender"
                                                            checked
                                                        />
                                                        <label for="male">New</label>
                                                        <input
                                                            value="Female"
                                                            type="radio"
                                                            id="female"
                                                            name="gender"
                                                        />
                                                        <label for="female">Second</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End row 1 -->
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">
                                                        Product Variant:
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <a
                                                            class="btn btn-success"
                                                            style="color: white"
                                                            @click="addVariant"
                                                        >
                                                            Add Variant
                                                        </a>
                                                        <div
                                                            style="display: none"
                                                            id="errMsg"
                                                            class="box no-border"
                                                        >
                                                            <div
                                                                class="box-tools"
                                                                style="margin-top: 15px"
                                                            >
                                                                <p
                                                                    class="
                                                                        alert
                                                                        alert-warning
                                                                        alert-dismissible
                                                                    "
                                                                >
                                                                    {{ this.error }}
                                                                    <button
                                                                        type="button"
                                                                        @click.prevent="closeMsg"
                                                                        class="close"
                                                                        data-hide="alert"
                                                                        aria-label="Close"
                                                                    >
                                                                        <span aria-hidden="true"
                                                                            >&times;</span
                                                                        >
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-10 variants">
                                                <div class="form-group">
                                                    <div
                                                        class="card"
                                                        v-for="(variant, index) in form.variants"
                                                        :key="variant.id"
                                                    >
                                                        <div class="card-body">
                                                            <span
                                                                class="float-right"
                                                                style="cursor: pointer"
                                                                @click="deleteVariant(index)"
                                                            >
                                                                X
                                                            </span>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="weight"
                                                                        >Variant Type
                                                                        {{ index + 1 }}
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input
                                                                            type="text"
                                                                            id="variant_type"
                                                                            class="form-control"
                                                                            :class="
                                                                                'variant_type_' +
                                                                                variant.id
                                                                            "
                                                                            :name="variant_type"
                                                                            v-model="
                                                                                variant.variant_type
                                                                            "
                                                                            v-on:keydown.tab="
                                                                                tokenField()
                                                                            "
                                                                            @change="tokenField()"
                                                                            onkeydown="if (event.keyCode == 13) event.preventDefault()"
                                                                            placeholder="Input variant type. E.g: Color"
                                                                            required
                                                                            autofocus
                                                                        />
                                                                        <div
                                                                            style="color: red"
                                                                            v-if="
                                                                                form.errors.has(
                                                                                    'variant_type'
                                                                                )
                                                                            "
                                                                            v-html="
                                                                                form.errors.get(
                                                                                    'variant_type'
                                                                                )
                                                                            "
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label for="weight"
                                                                        >Variant Options
                                                                        {{ index + 1 }}</label
                                                                    >
                                                                    <div class="input-group">
                                                                        <input
                                                                            type="text"
                                                                            :class="
                                                                                'variant_options_' +
                                                                                variant.id
                                                                            "
                                                                            autofocus="true"
                                                                            v-model="
                                                                                variant.variant_options
                                                                            "
                                                                            @mouseover="
                                                                                tokenField()
                                                                            "
                                                                            placeholder="Input variant options. E.g: Blue, Brown,"
                                                                            class="
                                                                                form-control
                                                                                variant_options
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <small class="text-muted"
                                                                        >End with a comma for single
                                                                        or multiple inputs. E.g:
                                                                        data1, data2,</small
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- v-for -->
                                                </div>
                                            </div>
                                            <!-- col 10 -->
                                        </div>
                                        <!-- row product varian -->
                                        <div class="row">
                                            <div
                                                v-if="form.variantsProd.length > 0"
                                                class="
                                                    col-md-12
                                                    panel-body
                                                    table-responsive
                                                    product_variants
                                                "
                                                style="overflow: hidden"
                                            >
                                                <table
                                                    class="
                                                        table table-bordered table-hover
                                                        dataTable
                                                    "
                                                >
                                                    <thead>
                                                        <tr>
                                                            <th>Product Variant</th>
                                                            <th>Price</th>
                                                            <th>Stock</th>
                                                            <th>SKU</th>
                                                            <th>Images</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="variantVal in form.variantsProd"
                                                            :key="variantVal.id"
                                                        >
                                                            <td style="display: none">
                                                                <input
                                                                    v-model="variantVal.id"
                                                                    :class="
                                                                        'variant_product_' +
                                                                        variantVal.id
                                                                    "
                                                                    class="form-control"
                                                                    type="hidden"
                                                                    name="variant_product"
                                                                />
                                                            </td>
                                                            <td
                                                                :class="
                                                                    'variant_product_' +
                                                                    variantVal.id
                                                                "
                                                            >
                                                                {{
                                                                    Object.entries(variantVal)
                                                                        .filter(
                                                                            ([key]) =>
                                                                                key !== 'id' &&
                                                                                key !==
                                                                                    'product_variant' &&
                                                                                key !== 'price' &&
                                                                                key !== 'stock' &&
                                                                                key !== 'sku'
                                                                        )
                                                                        .map(([, v]) => v)
                                                                        .join('-')
                                                                }}
                                                            </td>
                                                            <td>
                                                                <div class="input-group mb-3">
                                                                    <div
                                                                        class="input-group-prepend"
                                                                    >
                                                                        <span
                                                                            class="input-group-text"
                                                                            >Rp</span
                                                                        >
                                                                    </div>
                                                                    <input
                                                                        id="variant_price"
                                                                        @mouseover="
                                                                            validatePrice(
                                                                                variantVal.id
                                                                            )
                                                                        "
                                                                        :class="
                                                                            'variant_price_' +
                                                                            variantVal.id
                                                                        "
                                                                        v-bind:name="
                                                                            variantVal.price
                                                                        "
                                                                        type="text"
                                                                        class="
                                                                            form-control
                                                                            variant_price
                                                                        "
                                                                        required
                                                                        autofocus
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input
                                                                    id="variant_stock"
                                                                    type="text"
                                                                    :class="
                                                                        'variant_stock_' +
                                                                        variantVal.id
                                                                    "
                                                                    v-model="variantVal.stock"
                                                                    class="form-control"
                                                                    name="variant_stock"
                                                                    required
                                                                    autocomplete="variant_stock"
                                                                    autofocus
                                                                />
                                                            </td>
                                                            <td>
                                                                <input
                                                                    id="variant_sku"
                                                                    type="text"
                                                                    :class="
                                                                        'variant_sku_' +
                                                                        variantVal.id
                                                                    "
                                                                    v-model="variantVal.sku"
                                                                    class="form-control"
                                                                    name="variant_sku"
                                                                    required
                                                                    autocomplete="variant_sku"
                                                                    autofocus
                                                                />
                                                            </td>
                                                            <td>images</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- row 1.1 -->
                                        <div class="row"></div>
                                        <!-- End row 1.1 -->
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">Product Price:</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 job-info">
                                                <div class="form-group">
                                                    <label for="company-name">Minimum Order</label>
                                                    <input
                                                        id="company-name"
                                                        type="text"
                                                        class="form-control"
                                                        name="company-name"
                                                        value=""
                                                        required
                                                        autocomplete="company-name"
                                                        autofocus
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-4 job-info">
                                                <div class="form-group">
                                                    <label for="profession">Unit Price</label>
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
                                                <label for="weight">Product Discount Price </label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input
                                                        id="discount_price"
                                                        type="text"
                                                        class="form-control discount_price"
                                                        name="discount_price"
                                                        required
                                                        autocomplete="discount_price"
                                                        autofocus
                                                        aria-label="Amount (to the nearest dollar)"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">Product Shape:</p>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">Product Photo:</p>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">
                                                        Product Marketing:
                                                    </p>
                                                </div>
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
                                                @mouseover="addProp()"
                                                v-on:keydown.enter="addProp()"
                                            >
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
import Nav from '../partials/Nav.vue';
import Breadcrumbs from '../partials/Breadcrumbs.vue';
import Sidebar from '../partials/Sidebar.vue';
import Footer from '../partials/Footer.vue';
// datepicker
import 'jquery-ui/ui/widgets/datepicker.js';
import 'jquery-ui-dist/jquery-ui.js'; // npm install --save jquery-ui
import 'jquery-ui-dist/jquery-ui.css';
import 'jquery/dist/jquery.js';
// end datepicker
import { Form } from 'vform';
//import '@/assets/css/app.css';
import '@/assets/js/select2.min.js';
import '@/assets/js/bootstrap-tokenfield.js'; // another related file found index.html
import { BASE_URL } from '@/assets/js/base-url.js';
import swal from 'sweetalert2';

export default {
    name: 'HelloWorld',
    components: {
        Nav,
        Breadcrumbs,
        Sidebar,
        Footer,
    },
    data() {
        return {
            BASE_URL: BASE_URL,
            nextId: 1,
            variantProductId: 0,
            form: new Form({
                product_name: '',
                brand: '',
                category_id: 0,
                subcategory_id: 0,
                subsubcategory_id: 0,
                isVariantExists: 0,
                variants: [
                    {
                        id: 1,
                        variant_type: '',
                        variant_options: [],
                    },
                ],
                variantsProd: [],
            }),
            error: '',
            attributes: [],
            title: '',
        };
    },
    methods: {
        getVariantProducts() {
            let variants = this.form.variants;
            var variantsValue = [];

            variants.forEach((data) => {
                let dataObj = Object.values(data);

                var variantOpt = $('.variant_options_' + dataObj[0]).tokenfield('getTokens');
                var varianOptVal = [];

                variantOpt.forEach((data) => {
                    varianOptVal.push(data.value);
                });

                // Arrays has not been merged, and still has it's properties.
                variantsValue.push({
                    variant_id: dataObj[0],
                    variant_type: dataObj[1],
                    variant_options: varianOptVal,
                });
            });

            // Arrays is now merged, but the properties (acc) is more dynamic.
            /*{Color: Array(2), Size: Array(3)}
              Color: (2) ["Blue", "Brown"]
              Size: (3) ["S", "M", "L"]*/
            const reduceTheRes = (data) =>
                data.reduce((acc, item) => {
                    acc[item.variant_type] = item.variant_options;
                    return acc;
                }, {});

            /* 
            0: Array(2)
               0: {Color: "Blue"}
               1: {Color: "Green"}
            1: Array(3)
               0: {Size: "S"}
               1: {Size: "M"}
            */
            let attrs = [];
            for (const [attr, values] of Object.entries(reduceTheRes(variantsValue))) {
                attrs.push(values.map((val) => ({ [attr]: val })));
            }

            // Mapping the values to each properties
            // a, b
            // d, e
            // a => d. b => e.
            // ...d, ...e (Mapping an array from the top (d) input to bottom (e))
            attrs = attrs.reduce((a, b) => a.flatMap((d) => b.map((e) => ({ ...d, ...e }))));

            // Add id to each row.
            attrs.forEach((item, i) => {
                item.id = i + 1;
                item.product_variant = $('.variant_product_' + item.id).text();
                item.price = $('.variant_price_' + item.id).val();
                item.stock = $('.variant_stock_' + item.id).val();
                item.sku = $('.variant_sku_' + item.id).val();
            });

            this.form.variantsProd = attrs;
        },
        addProp() {
            this.form.variantsProd.forEach((item) => {
                item.price = $('.variant_price_' + item.id).val();
                const isEmpty = (str) => !str.trim().length;
                if (item.price === undefined || isEmpty(item.product_variant)) {
                    var last = this.form.variantsProd[this.form.variantsProd.length - 1];
                    item.product_variant = $('.variant_product_' + last.id).text();
                    item.price = $('.variant_price_' + last.id).val();
                    item.stock = $('.variant_stock_' + last.id).val();
                    item.sku = $('.variant_sku_' + last.id).val();
                }
            });
        },
        tokenField() {
            // enter button is killed no current input data found. To activate again, open the bootstrap-tokenfield.js, and search "kill enter button", uncomment the rest of code, and delete e.preventDefault()
            var self = this;
            $('.variant_options').tokenfield({
                showAutocompleteOnFocus: true,
            });

            $('.variant_options')
                .on('tokenfield:createtoken', function (event) {
                    var existingTokens = $(this).tokenfield('getTokens');
                    const isEmpty = (str) => !str.trim().length;

                    if (isEmpty($('#variant_type').val())) {
                        event.preventDefault();
                        self.error = 'Please fill the variant type first';
                        $('#errMsg').show().delay(1000).fadeOut(300);
                    }

                    $.each(existingTokens, function (index, token) {
                        if (token.value === event.attrs.value) {
                            event.preventDefault();
                            self.error = 'Duplicate value is not allowed!';
                            $('#errMsg').show().delay(1000).fadeOut(300);
                        }
                    });
                })
                .on('tokenfield:createdtoken', function () {
                    self.getVariantProducts();
                    // fill the value of variant_options
                    self.form.variants.forEach((data) => {
                        let dataObj = Object.values(data);
                        data.variant_options = $('.variant_options_' + dataObj[0]).tokenfield(
                            'getTokens'
                        );
                    });
                })
                .on('tokenfield:removedtoken', function () {
                    self.getVariantProducts();
                    $('.product_variants').find(':input').val(''); // clear price, sku, stock input field
                    // update the value of variant_options
                    self.form.variants.forEach((data) => {
                        let dataObj = Object.values(data);
                        data.variant_options = $('.variant_options_' + dataObj[0]).tokenfield(
                            'getTokens'
                        );
                    });
                });
        },
        addVariant() {
            if (this.form.variants.length === 0) {
                this.form.variants.push({
                    id: this.nextId++,
                    variant_type: '',
                    variant_options: '',
                });
            } else if (this.form.variants.length === 1) {
                let existingTokens = $('.variant_options').tokenfield('getTokens');
                const isEmpty = (str) => !str.trim().length;

                if (isEmpty($('#variant_type').val())) {
                    alert('Please fill the existing varian fields first!');
                } else if ($('#variant_type').val()) {
                    if (existingTokens.length === 0) {
                        alert('Please fill the existing varian fields first!');
                    } else {
                        this.form.variantsProd.splice(0, this.form.variantsProd.length);
                        this.form.variants.push({
                            id: this.nextId++,
                            variant_type: '',
                            variant_options: '',
                        });
                    }
                }
            } else {
                this.error = 'You can only add 2 type of varians';
                $('#errMsg').show();
            }
        },
        deleteVariant(index) {
            $('#errMsg').hide();
            this.form.variants.splice(index, 1);
            if (this.form.variants.length === 0) {
                this.form.variantsProd.splice(0, this.form.variantsProd.length);
            }
            this.getVariantProducts();
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
        showErrMsg(response) {
            var responseData = response.data;
            this.msg = responseData.message;

            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: this.msg,
                footer: '<a href>Why do I have this issue?</a>',
            });
        },
        validatePrice(id) {
            $('.variant_price_' + id).on('contextmenu', function () {
                return false;
            });

            function addDot(x) {
                return x.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            $('.variant_price_' + id).on('keyup', this, function (event) {
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

            $('.variant_price_' + id).on('paste', function (event) {
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
                        $('.variant_price_' + id).val(res); // Assume, we paste 200000, without if else below, it will result 200.000200000

                        return false;
                    } else {
                        var res2 = addDot(dataText);
                        $('.variant_price_' + id).val(res2); // Assume, we paste 200000, without if else below, it will result 200.000200000
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
        clearAllSubCatSelectOption() {
            $('#subcategory_id')
                .find('option')
                .remove()
                .end()
                .append('<option value="default">Select Sub Category</option>')
                .val('default');
        },
        clearAllSubSubCatSelectOption() {
            $('#subsubcategory_id')
                .find('option')
                .remove()
                .end()
                .append('<option value="default">Select Sub Sub Category</option>')
                .val('default');
        },
        loadCatSelectOption() {
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
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        loadSubCatSelectOption() {
            var self = this;
            const token = localStorage.getItem('token-staff');

            // fill sub category input
            $('#category_id').on('change', function () {
                self.clearAllSubCatSelectOption();
                self.clearAllSubSubCatSelectOption();

                var category_id = $(this).val();

                if (category_id === 'default') {
                    $('div.get-sub-categories select')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="default">Select Sub Category</option>')
                        .val('default');
                }

                $.ajax({
                    url: `${BASE_URL}/api/staff/sub-sub-categories/get-sub-category/` + category_id,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${token}`);
                    },
                    success: function (data) {
                        let subCategories = data.sub_categories;

                        if (subCategories) {
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
                        }

                        if (subCategories.length === 0) {
                            $('div.get-sub-categories select').val('default').change();
                        }
                    },
                });
            });
        },
        loadSubSubCatSelectOption() {
            var self = this;
            const token = localStorage.getItem('token-staff');

            // fill sub category input
            $('#subcategory_id').on('change', function () {
                self.clearAllSubSubCatSelectOption();

                var subcategory_id = $(this).val();

                if (subcategory_id === 'default') {
                    $('#subsubcategory_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="default">Select Sub Sub Category</option>')
                        .val('default');
                }

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

                        if (subSubCategories.length === 0) {
                            $('div.get-sub-sub-categories select').val('default').change();
                        }

                        subSubCategories.forEach(function (subSubCategory) {
                            var option = new Option(
                                subSubCategory.subsubcategory_name,
                                subSubCategory.id,
                                true,
                                true
                            );
                            // Bulk assign form
                            $('#subsubcategory_id').append(option);
                            $('div.get-sub-sub-categories select').val('default').change();
                        });
                    },
                });
            });
        },
        loadBrands() {
            // Fill category input
            const token = localStorage.getItem('token-staff');
            this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            this.axios
                .get('api/staff/get-brands', {})
                .then((response) => {
                    var responseData = response.data;
                    let brands = responseData.brands;

                    brands.forEach(function (brand) {
                        var option = new Option(brand.brand_name, brand.id, true, true);
                        $('#brand').append(option);
                        $('div.get-brands select').val('default').change();
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        store() {
            $('#loadingButton').html(
                `<div class="proc-regis"><i class='fa fa-circle-o-notch fa-spin'></i> Storing data</div>`
            );
            $('#loadingButton').attr('disabled', true);

            this.form.isVariantExists = $('#variant_type').length;
            console.log(this.form.subcategory_id);

            this.form
                .post('api/staff/products/store')
                .then((response) => {
                    let variants = this.form.variants;

                    if (this.form.isVariantExists > 0) {
                        variants.forEach((data) => {
                            let dataObjVal = Object.values(data);

                            $('.variant_type_' + dataObjVal[0]).removeClass('is-invalid');
                            var existingTokens = $('.variant_options_' + dataObjVal[0]).tokenfield(
                                'getTokens'
                            );
                            let variant_type = $('.variant_type_' + dataObjVal[0]).val();

                            if (variant_type == '') {
                                $('.variant_type_' + dataObjVal[0]).addClass('is-invalid');
                                this.showErrMsg(response);
                            }
                            if (existingTokens.length > 0) {
                                $('.variant_options_' + dataObjVal[0])
                                    .parent()
                                    .removeClass('is-invalid');
                            }
                            if (existingTokens.length === 0) {
                                $('.variant_options_' + dataObjVal[0])
                                    .parent()
                                    .addClass('is-invalid');
                                this.showErrMsg(response);
                            }
                        });

                        this.form.variantsProd.forEach((data) => {
                            let inputPrice = $('.variant_price_' + data.id).val();
                            let inputStock = $('.variant_stock_' + data.id).val();
                            let inputSku = $('.variant_sku_' + data.id).val();

                            $('.variant_price_' + data.id).removeClass('is-invalid');
                            $('.variant_stock_' + data.id).removeClass('is-invalid');
                            $('.variant_sku_' + data.id).removeClass('is-invalid');

                            if (inputPrice == '') {
                                $('.variant_price_' + data.id).addClass('is-invalid');
                                this.showErrMsg(response);
                            }

                            if (inputStock == '') {
                                $('.variant_stock_' + data.id).addClass('is-invalid');
                                this.showErrMsg(response);
                            }

                            if (inputSku == '') {
                                $('.variant_sku_' + data.id).addClass('is-invalid');
                                this.showErrMsg(response);
                            }

                            if (inputPrice !== '' && inputStock !== '' && inputSku !== '') {
                                this.$router.push({ name: 'products-index' });
                                this.showSuccessMsg(response);
                            }
                        });
                    } else {
                        this.$router.push({ name: 'products-index' });
                        this.showSuccessMsg(response);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Make sure you input the valid data!',
                        footer: '<a href>Why do I have this issue?</a>',
                    });
                })
                .finally(() => {
                    $('#loadingButton').attr('disabled', false);
                    $('.proc-regis').remove();
                    $('#loadingButton').html(`Save`);
                });
        },
    }, // methods:
    created() {},
    mounted() {
        this.tokenField();
        this.form.variants.splice(0, this.form.variants.length); // empty an array of dynamic variants field
        // prevent sweetalert error if user change the route when swal is still visible.
        if (swal.isVisible()) {
            document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
        }
        this.loadBrands();
        this.loadCatSelectOption();
        this.loadSubCatSelectOption();
        this.loadSubSubCatSelectOption();
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
