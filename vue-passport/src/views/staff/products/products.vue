<template>
    <div class="wrapper">
        <Nav />
        <Sidebar />
        <div class="content-wrapper">
            <Breadcrumbs />
            <div class="content">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Create New Product</div>

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
                                                    <label for="product_code">Product Code</label>
                                                    <input
                                                        v-model="form.product_code"
                                                        id="product_code"
                                                        type="text"
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('product_code'),
                                                        }"
                                                        name="product_code"
                                                        required
                                                        autocomplete="product_code"
                                                        autofocus
                                                    />
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('product_code')"
                                                        v-html="form.errors.get('product_code')"
                                                    />
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
                                                <div class="form-group">
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
                                                </div>
                                                <div
                                                    style="color: red"
                                                    class="errorIcon"
                                                    v-if="form.errors.has('brand')"
                                                    v-html="form.errors.get('brand')"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="nik">Category</label>
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
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="nik">Sub Category</label>
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
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="citizenship"
                                                        >Sub-sub Category</label
                                                    >
                                                    <select
                                                        v-bind:name="form.subsubcategory_id"
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
                                            <div class="col-md-3">
                                                <label for="weight">Product Tags</label>
                                                <div class="input-group mb-3">
                                                    <input
                                                        id="height"
                                                        type="text"
                                                        class="form-control"
                                                        name="height"
                                                        value=""
                                                        required
                                                        autocomplete="weight"
                                                        autofocus
                                                    />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Cm</span>
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
                                                        <button
                                                            class="btn btn-success"
                                                            @click="addVariant"
                                                        >
                                                            Add Variant
                                                        </button>
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
                                                                            v-model="
                                                                                variant.variant_type
                                                                            "
                                                                            v-on:keydown.tab="
                                                                                tokenField()
                                                                            "
                                                                            @change="tokenField()"
                                                                            onkeydown="if (event.keyCode == 13) event.preventDefault()"
                                                                            placeholder="Input variant type. E.g: Color"
                                                                            name="name"
                                                                            required
                                                                            autofocus
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
                                                v-if="variantsVal.length > 0"
                                                class="col-md-12 panel-body table-responsive"
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
                                                            v-for="(
                                                                variantVal, index
                                                            ) in variantsVal"
                                                            :key="index"
                                                        >
                                                            <td>
                                                                {{
                                                                    Object.values(variantVal).join(
                                                                        '-'
                                                                    )
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
                                                                        type="text"
                                                                        class="form-control"
                                                                        name="variant_price"
                                                                        value=""
                                                                        required
                                                                        autocomplete="variant_price"
                                                                        autofocus
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input
                                                                    id="variant_stock"
                                                                    type="text"
                                                                    class="form-control"
                                                                    name="variant_stock"
                                                                    value=""
                                                                    required
                                                                    autocomplete="variant_stock"
                                                                    autofocus
                                                                />
                                                            </td>
                                                            <td>
                                                                <input
                                                                    id="variant_sku"
                                                                    type="text"
                                                                    class="form-control"
                                                                    name="variant_sku"
                                                                    value=""
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
                                                        id="salary"
                                                        type="text"
                                                        class="form-control salary"
                                                        name="salary"
                                                        required
                                                        autocomplete="salary"
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
import '@/assets/css/app.css';
import '@/assets/js/select2.min.js';
import '@/assets/js/bootstrap-tokenfield.js'; // another related file found index.html
//import { BASE_URL } from '@/assets/js/base-url.js';
//import swal from 'sweetalert2';

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
            nextId: 1,
            variantsVal: [],
            form: new Form({
                product_code: '',
                product_name: '',
                brand: '',
                category_id: 0,
                subcategory_id: 0,
                subsubcategory_id: 0,
                variants: [
                    {
                        id: 1,
                        variant_type: '',
                        variant_options: '',
                    },
                ],
            }),
            error: '',
            attributes: [],
        };
    },
    methods: {
        getVariantOptions() {
            console.log('work');
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
                    // variant_id: dataObj[0],
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

            this.variantsVal = attrs;
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
                    self.getVariantOptions();
                })
                .on('tokenfield:removedtoken', function () {
                    self.getVariantOptions();
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
                        this.variantsVal.splice(0, this.variantsVal.length);
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
                this.variantsVal.splice(0, this.variantsVal.length);
            }
            this.getVariantOptions();
        },
    }, // methods:
    created() {},
    mounted() {
        this.tokenField();
        this.form.variants.splice(0, this.form.variants.length); // empty an array of dynamic variants field
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
