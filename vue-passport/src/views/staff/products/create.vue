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
                                                        placeholder="Product Name"
                                                        autofocus
                                                    />
                                                    <span class="text-danger" id="codeError"></span>
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
                                                        v-bind:name="form.brand_id"
                                                        id="brand_id"
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('brand_id'), 
                                                        }"
                                                    >
                                                        <option value="default" selected="true">
                                                            === Select Brand ===
                                                        </option>
                                                    </select>
                                                    <span
                                                        class="text-danger"
                                                        id="brand_id_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        class="errorIcon"
                                                        v-if="form.errors.has('brand_id')"
                                                        v-html="form.errors.get('brand_id')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group get-categories">
                                                    <label for="nik">Category</label>
                                                    <select
                                                        v-bind:name="form.category_id"
                                                        class="form-control"  
                                                        id="category_id"
                                                        :required="true"
                                                    >
                                                        <option value="default" selected="true">
                                                            === Select Category ===
                                                        </option>
                                                    </select>
                                                    <span
                                                        class="text-danger"
                                                        id="category_id_error"
                                                    ></span>
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
                                                        v-bind:name="form.subcategory_id"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('subcategory_id'),
                                                        }"
                                                        id="subcategory_id"
                                                        class="form-control"
                                                        :required="true"
                                                    >
                                                        <option
                                                            value="default"
                                                            id="default-subcat"
                                                            selected="true"
                                                        >
                                                            === Select Sub Category ===
                                                        </option>
                                                    </select>
                                                    <span
                                                        class="text-danger"
                                                        id="subcategory_id_error"
                                                    ></span>
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
                                                        v-bind:name="form.subsubcategory_id"
                                                        id="subsubcategory_id"
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('subcategory_id'),
                                                        }"
                                                        :required="true"
                                                    >
                                                        <option
                                                            value="default"
                                                            id="default-subcat"
                                                            selected="true"
                                                        >
                                                            === Select Sub Sub Category ===
                                                        </option>
                                                    </select>
                                                    <span
                                                        class="text-danger"
                                                        id="subsubcategory_id_error"
                                                    ></span>
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
                                                    <label for="short_desc"
                                                        >Short Description</label
                                                    >
                                                    <textarea
                                                        v-model="form.short_desc"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('short_desc'),
                                                        }"
                                                        id="short_desc"
                                                        class="form-control"
                                                        name="short_desc"
                                                        required
                                                        autocomplete="short_desc"
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        id="short_desc_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('short_desc')"
                                                        v-html="form.errors.get('short_desc')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="long_desc">Long Description</label>
                                                    <ckeditor
                                                        id="long_desc"
                                                        :editor="editor"
                                                        v-model="form.long_desc"
                                                        :config="editorConfig"
                                                    ></ckeditor>
                                                    <span
                                                        class="text-danger"
                                                        id="long_desc_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('long_desc')"
                                                        v-html="form.errors.get('long_desc')"
                                                    />
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
                                                                    <label for="product_weight"
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
                                                                    <label for="product_weight"
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
                                        <div
                                            v-if="form.variants_prod.length > 0"
                                            class="product_variants"
                                        >
                                            <table
                                                style="width: 1880px"
                                                class="table table-bordered table-hover dataTable"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th style="width: 7%">Product Variant</th>
                                                        <th style="width: 13%">Price</th>
                                                        <th style="width: 7%">Stock</th>
                                                        <th style="width: 9%">Condition</th>
                                                        <th style="width: 7%">SKU</th>
                                                        <th>Status</th>
                                                        <th style="width: 100%">Images</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="variantVal in form.variants_prod"
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
                                                                'variant_product_' + variantVal.id
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
                                                                            key !==
                                                                                'available_stock' &&
                                                                            key !== 'sku' &&
                                                                            key !== 'images' &&
                                                                            key !==
                                                                                'total_images' &&
                                                                            key !== 'status' &&
                                                                            key !== 'condition'
                                                                    )
                                                                    .map(([, v]) => v)
                                                                    .join('-')
                                                            }}
                                                        </td>
                                                        <td>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"
                                                                        >Rp</span
                                                                    >
                                                                </div>
                                                                <input
                                                                    id="variant_price"
                                                                    :class="
                                                                        'variant_price_' +
                                                                        variantVal.id
                                                                    "
                                                                    v-bind:name="variantVal.price"
                                                                    v-model="variantVal.price"
                                                                    type="text"
                                                                    class="
                                                                        form-control
                                                                        variant_price
                                                                    "
                                                                    required
                                                                    autofocus
                                                                    @keyup="
                                                                        allowOnlyNumberAndDot(
                                                                            $event
                                                                        )
                                                                    "
                                                                />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input
                                                                id="variant_available_stock"
                                                                type="text"
                                                                :class="
                                                                    'variant_available_stock_' +
                                                                    variantVal.id
                                                                "
                                                                :name="variantVal.available_stock"
                                                                v-model="variantVal.available_stock"
                                                                class="form-control"
                                                                required
                                                                autocomplete="variant_available_stock"
                                                                autofocus
                                                                @keyup="
                                                                    allowOnlyNumberAndDot($event)
                                                                "
                                                            />
                                                        </td>
                                                        <td>
                                                            <input
                                                                value="New"
                                                                type="radio"
                                                                id="new"
                                                                :name="'condition_' + variantVal.id"
                                                                checked
                                                            />
                                                            <label for="new">New</label> <br />
                                                            <input
                                                                value="Second"
                                                                type="radio"
                                                                id="second"
                                                                :name="'condition_' + variantVal.id"
                                                            />
                                                            <label for="second">Second</label>
                                                        </td>
                                                        <td>
                                                            <input
                                                                id="variant_sku"
                                                                type="text"
                                                                :class="
                                                                    'variant_sku_' + variantVal.id
                                                                "
                                                                v-model="variantVal.sku"
                                                                class="form-control"
                                                                name="variant_sku"
                                                                required
                                                                autocomplete="variant_sku"
                                                                autofocus
                                                            />
                                                        </td>
                                                        <td>
                                                            <input
                                                                type="checkbox"
                                                                class="switch"
                                                                name="permission[]"
                                                                data-bootstrap-switch
                                                                data-off-color="danger"
                                                                data-on-text=""
                                                                data-off-text=""
                                                                data-size="small"
                                                                value="testing"
                                                                :class="'status_' + variantVal.id"
                                                            />
                                                            <br />
                                                            {{ variantVal.status }}
                                                        </td>
                                                        <td>
                                                            <div class="file-loading">
                                                                <input
                                                                    id="images"
                                                                    :class="
                                                                        'images' + variantVal.id
                                                                    "
                                                                    name="images[]"
                                                                    type="file"
                                                                    multiple
                                                                    ref="images"
                                                                />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br />
                                        <!-- end row product varian -->
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
                                                        type="text"
                                                        id="min_order"
                                                        :name="form.min_order"
                                                        v-model="form.min_order"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('min_order'),
                                                        }"
                                                        class="form-control min_order"
                                                        required
                                                        autocomplete="min_order"
                                                        autofocus
                                                        placeholder="Minimum Order"
                                                        @keyup="allowOnlyNumberAndDot($event)"
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        id="min_order_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('min_order')"
                                                        v-html="form.errors.get('min_order')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-4 job-info">
                                                <label for="price">Product Price </label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input
                                                        id="price"
                                                        type="text"
                                                        v-bind:name="form.price"
                                                        v-model="form.price"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('price'),
                                                        }"
                                                        class="form-control price"
                                                        required
                                                        autocomplete="price"
                                                        autofocus
                                                        aria-label="Amount (to the nearest dollar)"
                                                        placeholder="Price"
                                                        @keyup="allowOnlyNumberAndDot($event)"
                                                    />
                                                </div>
                                                <span
                                                    class="text-danger"
                                                    id="price_error"
                                                ></span>
                                                <div
                                                    style="color: red"
                                                    v-if="form.errors.has('price')"
                                                    v-html="form.errors.get('price')"
                                                />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <p class="lead section-title">
                                                        Product Management:
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="available_stock">Stock</label>
                                                    <input
                                                        id="available_stock"
                                                        v-bind:name="form.available_stock"
                                                        v-model="form.available_stock"
                                                        type="text"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('available_stock'),
                                                        }"
                                                        class="form-control available_stock"
                                                        required
                                                        autocomplete="available_stock"
                                                        autofocus
                                                        placeholder="Stock"
                                                        @keyup="allowOnlyNumberAndDot($event)"
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        id="available_stock_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('available_stock')"
                                                        v-html="form.errors.get('available_stock')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-left: 50px">
                                                    <label for="product_cond"
                                                        >Product Condition</label
                                                    >
                                                    <br />
                                                    <input
                                                        value="New"
                                                        type="radio"
                                                        id="new"
                                                        name="product_cond"
                                                        checked
                                                    />
                                                    <label for="new">New</label> &nbsp; &nbsp;
                                                    <input
                                                        value="Second"
                                                        type="radio"
                                                        id="second"
                                                        name="product_cond"
                                                    />
                                                    <label for="second">Second</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-left: 50px">
                                                    <label for="status">Status</label>
                                                    <br />
                                                    <input
                                                        type="checkbox"
                                                        name="permission[]"
                                                        data-bootstrap-switch
                                                        data-off-color="danger"
                                                        data-on-text=""
                                                        data-off-text=""
                                                        data-size="small"
                                                        value="testing"
                                                        class="status"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sku">SKU</label>
                                                    <input
                                                        id="sku"
                                                        v-model="form.sku"
                                                        :class="{
                                                            'is-invalid': form.errors.has('sku'),
                                                        }"
                                                        type="text"
                                                        class="form-control"
                                                        name="sku"
                                                        required
                                                        autocomplete="sku"
                                                        autofocus
                                                        placeholder="SKU"
                                                    />
                                                    <span class="text-danger" id="sku_error"></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('sku')"
                                                        v-html="form.errors.get('sku')"
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
                                            <div class="col-md-2">
                                                <label for="sku">Product Weight</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input
                                                        id="product_weight"
                                                        v-bind:name="form.product_weight"
                                                        v-model="form.product_weight"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('product_weight'),
                                                        }"
                                                        type="text"
                                                        class="form-control product_weight"
                                                        required
                                                        autocomplete="product_weight"
                                                        placeholder="Product Weight"
                                                        autofocus
                                                        @keyup="allowOnlyNumberAndDot($event)"
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        id="product_weight_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('product_weight')"
                                                        v-html="form.errors.get('product_weight')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <select
                                                        v-bind:name="form.metric_mass"
                                                        id="metric_mass"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('metric_mass'),
                                                        }"
                                                        class="form-control metric_mass"
                                                        style="width: 120px"
                                                    >
                                                        <option value="Gram (g)" selected="true">
                                                            Gram (g)
                                                        </option>
                                                        <option value="Kilogram (kg)">
                                                            Kilogram (kg)
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="sku">Dimension</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <input
                                                            type="text"
                                                            id="product_length"
                                                            v-bind:name="form.product_length"
                                                            v-model="form.product_length"
                                                            :class="{
                                                                'is-invalid':
                                                                    form.errors.has(
                                                                        'product_length'
                                                                    ),
                                                            }"
                                                            class="form-control product_length"
                                                            placeholder="Product Length"
                                                            @keyup="allowOnlyNumberAndDot($event)"
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                        <span
                                                            class="text-danger"
                                                            id="product_length_error"
                                                        ></span>
                                                        <div
                                                            style="color: red"
                                                            v-if="form.errors.has('product_length')"
                                                            v-html="
                                                                form.errors.get('product_length')
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <input
                                                            type="text"
                                                            id="product_width"
                                                            v-bind:name="form.product_width"
                                                            v-model="form.product_width"
                                                            :class="{
                                                                'is-invalid':
                                                                    form.errors.has(
                                                                        'product_width'
                                                                    ),
                                                            }"
                                                            class="form-control product_width"
                                                            placeholder="Product Width"
                                                            @keyup="allowOnlyNumberAndDot($event)"
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                        <span
                                                            class="text-danger"
                                                            id="product_width_error"
                                                        ></span>
                                                        <div
                                                            style="color: red"
                                                            v-if="form.errors.has('product_width')"
                                                            v-html="
                                                                form.errors.get('product_width')
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <input
                                                            type="text"
                                                            id="product_height"
                                                            v-bind:name="form.product_height"
                                                            v-model="form.product_height"
                                                            :class="{
                                                                'is-invalid':
                                                                    form.errors.has(
                                                                        'product_height'
                                                                    ),
                                                            }"
                                                            class="form-control product_height"
                                                            placeholder="Product Height"
                                                            @keyup="allowOnlyNumberAndDot($event)"
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                        <span
                                                            class="text-danger"
                                                            id="product_height_error"
                                                        ></span>
                                                        <div
                                                            style="color: red"
                                                            v-if="form.errors.has('product_height')"
                                                            v-html="
                                                                form.errors.get('product_height')
                                                            "
                                                        />
                                                    </div>
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input
                                                        type="checkbox"
                                                        name="permission[]"
                                                        data-bootstrap-switch
                                                        data-off-color="danger"
                                                        data-on-text=""
                                                        data-off-text=""
                                                        data-size="small"
                                                        value="testing"
                                                        class="hot_deals"
                                                    />
                                                    &nbsp; Hot Deals
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input
                                                        type="checkbox"
                                                        name="permission[]"
                                                        data-bootstrap-switch
                                                        data-off-color="danger"
                                                        data-on-text=""
                                                        data-off-text=""
                                                        data-size="small"
                                                        value="testing"
                                                        class="special_offer"
                                                    />
                                                    &nbsp; Special Offer
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input
                                                        type="checkbox"
                                                        name="permission[]"
                                                        data-bootstrap-switch
                                                        data-off-color="danger"
                                                        data-on-text=""
                                                        data-off-text=""
                                                        data-size="small"
                                                        value="testing"
                                                        class="featured"
                                                    />
                                                    &nbsp; Featured
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input
                                                        type="checkbox"
                                                        name="permission[]"
                                                        data-bootstrap-switch
                                                        data-off-color="danger"
                                                        data-on-text=""
                                                        data-off-text=""
                                                        data-size="small"
                                                        value="testing"
                                                        class="special_deals"
                                                    />
                                                    &nbsp; Special Deals
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
                                            <div class="col-md-12 job-info">
                                                <div class="form-group">
                                                    <div class="file-loading">
                                                        <input
                                                            id="picts"
                                                            name="images[]"
                                                            type="file"
                                                            multiple
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="box-footer text-right">
                                            <button
                                                type="submit"
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
import { Form } from 'vform';
import { BASE_URL } from '@/assets/js/base-url.js';
import swal from 'sweetalert2';
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
import '@/assets/js/select2.min.js';
import '@/assets/js/bootstrap-tokenfield.js'; // another related file found index.html
import 'bootstrap-fileinput/js/fileinput.min.js'; // npm install bootstrap-fileinput
import '@/assets/js/theme.js';
import 'bootstrap-fileinput/css/fileinput.css';
// npm install --save @ckeditor/ckeditor5-vue @ckeditor/ckeditor5-build-classic
// more configuration found in main.js
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

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
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
            },
            BASE_URL: BASE_URL,
            nextId: 1,
            variantProductId: 0,
            form: new Form({
                product_name: '',
                brand_id: '',
                category_id: '',
                subcategory_id: '',
                subsubcategory_id: '',
                short_desc: '',
                long_desc: '',
                min_order: '',
                price: '',
                available_stock: '',
                product_cond: '',
                sku: '',
                product_length: '',
                product_width: '',
                product_height: '',
                product_weight: '',
                metric_mass: '',
                images: [],
                totalInputtedPicts: 0,
                status: '',
                hot_deals: '',
                special_offer: '',
                featured: '',
                special_deals: '',
                isVariantExists: 0,
                variants: [
                    {
                        id: 1,
                        variant_type: '',
                        variant_options: [],
                    },
                ],
                variants_prod: [], // all general variant products that displayed in view.
                varProdsImgsToBeDeleted: [], // all of the variant options that has been deleted in the view, it's uploaded images should be stored here to be deleted.
                deletedVarProdsFromVariants: [],
            }),
            error: '',
            attributes: [],
            title: '',
            dataFiles: [],
            varProdsImgsToBeDeleted: [],
        };
    },
    methods: {
        removeDuplicatesFileInfo(arr) {
            let s = new Set(arr);
            let it = s.values();
            return Array.from(it);
        },
        generateVariantProducts() {
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
            var last = this.form.variants_prod[this.form.variants_prod.length - 1]; 
            attrs.forEach((item, i) => {
                if (last) {
                    item.id = i + 1 + last.id;
                } else {
                    item.id = i + 1;
                }
                setTimeout(function () {
                    item.product_variant = $('.variant_product_' + item.id).text();
                }, 100);
                item.price = '';
                item.available_stock = '';
                item.sku = '';
                item.condition = '';
                item.images = [];
                item.status = '';
                item.total_images = item.images.length;
            });

            this.form.variants_prod = attrs;
        },
        addVariant() {
            var self = this;
            if (this.form.variants.length === 0) {
                this.form.variants.push({
                    id: this.nextId++,
                    variant_type: '',
                    variant_options: '',
                });
            } else if (this.form.variants.length === 1) {
                if (this.dataFiles.length > 0) {
                    alert('Please delete all the inputted images variant products first!');
                } else {
                    let existingTokens = $('.variant_options').tokenfield('getTokens');
                    const isEmpty = (str) => !str.trim().length;
                    this.dataFiles = [];

                    if (isEmpty($('#variant_type').val())) {
                        alert('Please fill the existing varian fields first!');
                    } else if ($('#variant_type').val()) {
                        if (existingTokens.length === 0) {
                            alert('Please fill the existing varian fields first!');
                        } else {
                            this.form.variants_prod.splice(0, this.form.variants_prod.length);
                            this.form.variants.push({
                                id: this.nextId++,
                                variant_type: '',
                                variant_options: '',
                            });
                        }
                    }
                }
            } else {
                this.error = 'You can only add 2 type of varians';
                $('#errMsg').show();
            }

            this.form.variants.forEach((data) => {
                setTimeout(function () {
                    self.tokenField(data.id);
                }, 100);
            });
        },
        deleteAllNewAddedVarProdImages() {
            let formData = new FormData();
            formData.append('variants_prod', this.form.variants_prod);

            this.form
                .post('api/products/delete-all-new-added-variant-product-images-in-create-page', {
                    data: formData,
                })
                .then((response) => {
                    console.log(response);
                })
                .catch((err) => {
                    console.log(err);
                })
                .finally(() => {});
        },
        deleteVariant(index) {
            this.deleteAllNewAddedVarProdImages();
            $('#errMsg').hide();
            this.form.variants.splice(index, 1); // deleted variants
            if (this.form.variants.length === 0) {
                this.form.variants_prod.splice(0, this.form.variants_prod.length);
            }
            $('.product_variants').find(':input').val('');
            this.generateVariantProducts();
        },
        tokenField(id) {
            // enter button is killed no current input data found. To activate again, open the bootstrap-tokenfield.js, and search "kill enter button", uncomment the rest of code, and delete e.preventDefault()
            var self = this;
            $('.variant_options_' + id).tokenfield({
                showAutocompleteOnFocus: true,
            });

            $('.variant_options_' + id)
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
                    self.generateVariantProducts();

                    // fill the value of variant_options
                    self.form.variants.forEach((data) => {
                        let dataObj = Object.values(data);
                        data.variant_options = $('.variant_options_' + dataObj[0]).tokenfield(
                            'getTokens'
                        );
                    });

                    self.form.variants_prod.forEach((data) => {
                        // execute self.fileInputVariants(data.id) after 100 milisecond
                        setTimeout(function () {
                            self.fileInputVariants(data.id);
                            self.disableRightClickAndLongPress('variant_price_' + data.id);
                            self.disableRightClickAndLongPress(
                                'variant_available_stock_' + data.id
                            );
                        }, 100);
                    });
                })
                .on('tokenfield:removetoken', function () {
                    //
                })
                .on('tokenfield:removedtoken', function (event) {
                    let varProdsImgsToBeDeleted = [];
                    varProdsImgsToBeDeleted.push(self.form.variants_prod);

                    var varType = self.form.variants.filter(function (x) {
                        return x.id == id;
                    });

                    if (varType[0].variant_options.length === 1) {
                        self.form.variantIsDeleted = 'Yes';
                    }

                    let prop = varType[0].variant_type;
                    var varProd = self.form.variants_prod.filter(function (x) {
                        return x[prop] !== event.attrs.value;
                    });
                    self.form.variants_prod = varProd;

                    // update the value of variant_options
                    self.form.variants.forEach((data) => {
                        let dataObj = Object.values(data);
                        data.variant_options = $('.variant_options_' + dataObj[0]).tokenfield(
                            'getTokens'
                        );
                    });

                    // get and updated deleted variant products images
                    var getVarProdsImgsToBeDeleted = varProdsImgsToBeDeleted[0].filter(function (
                        x
                    ) {
                        return x[prop] == event.attrs.value;
                    });
                    self.varProdsImgsToBeDeleted.push(...getVarProdsImgsToBeDeleted);
                    self.form.varProdsImgsToBeDeleted = self.varProdsImgsToBeDeleted;

                    let formData = new FormData();
                    formData.append('varProdsImgsToBeDeleted', self.form.varProdsImgsToBeDeleted);

                    self.form
                        .post('api/products/delete-selected-variant-product-images', {
                            data: formData,
                        })
                        .then((response) => {
                            console.log(response);
                        })
                        .catch((err) => {
                            console.log(err);
                        })
                        .finally(() => {});
                });
        },
        fileInputVariants(id) {
            var self = this;

            $('.status_' + id).bootstrapSwitch('state', $('.status_' + id).prop('checked'));

            var varProdImgs = this.form.variants_prod.filter(function (x) {
                return x.id == id;
            });

            $('.images' + id)
                .fileinput({
                    theme: 'fas',
                    uploadUrl: `${BASE_URL}/api/products/store-images`,
                    dropZoneEnabled: false,
                    browseOnZoneClick: false,
                    showUpload: false, // mass upload
                    showRemove: false, // mass remove
                    required: true,
                    fileActionSettings: {
                        showUpload: false, // single upload
                    },
                    previewSettings: {
                        image: {
                            width: 'auto',
                            height: 'auto',
                            'max-width': '100%',
                            'max-height': '100%',
                        },
                    },
                    uploadExtraData: function () {
                        return {
                            _token: $("input[name='_token']").val(),
                        };
                    },
                    allowedFileTypes: ['image'],
                    allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    overwriteInitial: false,
                    maxFileSize: 2000,
                    maxFileCount: 5,
                    validateInitialCount: true,
                    uploadAsync: false,
                    initialPreviewConfig: self.removeDuplicatesFileInfo(self.dataFiles),
                    slugCallback: function (filename) {
                        return filename.replace('(', '_').replace(']', '_');
                    },
                })
                .on('filebatchselected', function () {
                    // event, files
                    $('.images' + id).fileinput('upload');
                })
                .on('filebatchuploadsuccess', function (event, data) {
                    //self.dataFiles.push(...data.response.initialPreviewConfig);
                    varProdImgs[0].images.push(...data.response.initialPreviewConfig);
                    varProdImgs[0].total_images = varProdImgs[0].images.length;
                })
                .on('filebeforedelete', function () {
                    //
                })
                .on('filedeleted', function (event, key) {
                    let getDataFileInfo = self.removeDuplicatesFileInfo(self.dataFiles);

                    var singleRemoveFileInfo = getDataFileInfo.filter(function (x) {
                        return x.key == key;
                    });

                    var filteredRes = getDataFileInfo.filter(
                        (item) => !singleRemoveFileInfo.includes(item)
                    );

                    self.dataFiles = filteredRes;
                })
                .on('fileclear', function () {
                    // before bulk remove
                })
                .on('filecleared', function () {
                    // after bulk remove
                    let dataFileInfo = self.removeDuplicatesFileInfo(self.dataFiles);

                    var bulkRemoveFileInfo = dataFileInfo.filter(function (x) {
                        return x.id == id;
                    });

                    var filteredArray = dataFileInfo.filter(
                        (item) => !bulkRemoveFileInfo.includes(item)
                    );

                    self.dataFiles = filteredArray;
                });
        },
        getSwitchValue() {
            if ($('.status').is(':checked') === false) {
                this.form.status = 'Inactive';
            } else {
                this.form.status = 'Active';
            }

            if ($('.hot_deals').is(':checked') === false) {
                this.form.hot_deals = 'No';
            } else {
                this.form.hot_deals = 'Yes';
            }

            if ($('.special_offer').is(':checked') === false) {
                this.form.special_offer = 'No';
            } else {
                this.form.special_offer = 'Yes';
            }

            if ($('.featured').is(':checked') === false) {
                this.form.featured = 'No';
            } else {
                this.form.featured = 'Yes';
            }

            if ($('.special_deals').is(':checked') === false) {
                this.form.special_deals = 'No';
            } else {
                this.form.special_deals = 'Yes';
            }
        },
        getSwitchValueVarProds() {
            var self = this;
            this.form.variants_prod.forEach((item) => {
                if ($('.status_' + item.id).is(':checked') === false) {
                    item.status = 'Inactive';
                } else {
                    item.status = 'Active';
                }
                setTimeout(function () {
                    self.fileInputVariants(item.id);
                }, 1000);
            });
        },
        getRadioButtonVarProdsVal() {
            this.form.variants_prod.forEach((item) => {
                item.condition = $('input[name="condition_' + item.id + '"]:checked').val();
            });
        },
        disableRightClickAndLongPress(className) { 
            // disable right click
            $('.' + className + '').on('contextmenu', function () {
                return false;
            });

            let flag = 0;
            $('.' + className + '').on('keydown', function (evt) {
                evt = evt ? evt : window.event;
                var charCode = evt.which ? evt.which : evt.keyCode;
                var vKey = 86, // paste
                    cKey = 67; // copy

                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
                    flag++;
                    if (flag > 4) {
                        evt.preventDefault();
                    }
                }

                if (evt.keyCode == cKey && evt.keyCode == vKey) {
                    evt.preventDefault();
                }
            });
        },
        allowOnlyNumberAndDot: function (evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            var vKey = 86,
                cKey = 67;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46 &&
                evt.keyCode == cKey &&
                evt.keyCode == vKey
            ) {
                evt.preventDefault();
            } else {
                this.form.variants_prod.forEach((data) => {
                    // limit input
                    var txtVal = $('.variant_price_' + data.id).val();
                    if (txtVal.length > 11) {
                        $('.variant_price_' + data.id).val(txtVal.substring(0, 11));
                        return false;
                    }

                    // add dot in numbers and only number is allowed (replace(/\D/g, '')).
                    $('.variant_price_' + data.id).val(function (index, value) {
                        return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    });

                    var varStock = $('.variant_available_stock_' + data.id).val();
                    if (varStock.length > 11) {
                        $('.variant_available_stock_' + data.id).val(varStock.substring(0, 11));
                        return false;
                    }

                    // add dot in numbers and only number is allowed (replace(/\D/g, '')).
                    $('.variant_available_stock_' + data.id).val(function (index, value) {
                        return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    });

                    data.price = $('.variant_price_' + data.id).val();
                    data.available_stock = $('.variant_available_stock_' + data.id).val();
                });

                let className = [
                    'min_order',
                    'price',
                    'available_stock',
                    'product_weight',
                    'product_length',
                    'product_width',
                    'product_height',
                ];

                className.forEach((data) => {
                    var theClass = $('.' + data + '').val();

                    if (theClass.length > 11) {
                        $('.' + data + '').val(theClass.substring(0, 11));
                        return false;
                    }

                    // add dot in numbers and only number is allowed (replace(/\D/g, '')).
                    $('.' + data + '').val(function (index, value) {
                        return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    });

                    this.form.min_order = $('.min_order').val();
                    this.form.price = $('.price').val();
                    this.form.available_stock = $('.available_stock').val();
                    this.form.product_weight = $('.product_weight').val();
                    this.form.product_length = $('.product_length').val();
                    this.form.product_width = $('.product_width').val();
                    this.form.product_height = $('.product_height').val();
                });
            }
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
        loadBrands() {
            this.axios
                .get('api/staff/get-brands', {})
                .then((response) => {
                    var responseData = response.data;
                    let brands = responseData.brands;

                    brands.forEach(function (brand) {
                        var option = new Option(brand.brand_name, brand.id, true, true);
                        $('#brand_id').append(option);
                        $('div.get-brands select').val('default').change();
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        loadCatSelectOption() {
            this.axios
                .get('api/staff/get-categories', {})
                .then((response) => {
                    var responseData = response.data;
                    let categories = responseData.categories;

                    categories.forEach(function (category) {
                        $('#category_id').append(
                            '<option value="' +
                                category.id +
                                '" data-id="' +
                                category.id +
                                '">' +
                                category.category_name +
                                '</option>'
                        );
                        $('div.get-categories select').val('default').change();
                    });
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loadCatAndSubCat();
                });
        },
        loadCatAndSubCat() {
            const token = localStorage.getItem('token-staff');

            $('#category_id').on('change', function () {
                var category_id = $(this).find(':selected').attr('data-id');

                $.ajax({
                    url: `${BASE_URL}/api/staff/sub-sub-categories/get-sub-category/` + category_id,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer ${token}`);
                    },
                    success: function (data) {
                        let subCategories = data.sub_categories;

                        $('#subcategory_id').empty();
                        $('#subcategory_id').append(
                            '<option value="default" selected="true">=== Select Sub Category ===</option>'
                        );

                        $('#subsubcategory_id').empty();
                        $('#subsubcategory_id').append(
                            '<option value="default" selected="true">=== Select Sub Sub Categories ===</option>'
                        );

                        $.each(subCategories, function (index, subCat) {
                            $('#subcategory_id').append(
                                '<option value="' +
                                    subCat.id +
                                    '" data-id="' +
                                    subCat.id +
                                    '">' +
                                    subCat.subcategory_name +
                                    '</option>'
                            );
                        });
                    },
                });
            });

            $('#subcategory_id').on('change', function () {
                var subcategory_id = $(this).find(':selected').attr('data-id');

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

                        $('#subsubcategory_id').empty();
                        $('#subsubcategory_id').append(
                            '<option value="0" selected="true">=== Select Sub Sub Category ===</option>'
                        );

                        $.each(subSubCategories, function (index, subSubCat) {
                            $('#subsubcategory_id').append(
                                '<option value="' +
                                    subSubCat.id +
                                    '" data-id="' +
                                    subSubCat.id +
                                    '">' +
                                    subSubCat.subsubcategory_name +
                                    '</option>'
                            );
                        });
                    },
                });
            });
        },
        fileInput() {
            var self = this;

            $('#picts')
                .fileinput({
                    theme: 'fas',
                    uploadUrl: `${BASE_URL}/api/products/store-images`,
                    dropZoneEnabled: true,
                    browseOnZoneClick: true,
                    showUpload: false, // mass upload
                    showRemove: false, // mass remove
                    showBrowse: false,
                    required: true,
                    fileActionSettings: {
                        showUpload: false, // single upload
                    },
                    previewSettings: {
                        image: {
                            width: 'auto',
                            height: 'auto',
                            'max-width': '100%',
                            'max-height': '100%',
                        },
                    },
                    uploadExtraData: function () {
                        return {
                            _token: $("input[name='_token']").val(),
                        };
                    },
                    allowedFileTypes: ['image'],
                    allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    overwriteInitial: false,
                    maxFileSize: 2000,
                    maxFileCount: 5,
                    validateInitialCount: true,
                    uploadAsync: false,
                    initialPreviewConfig: self.removeDuplicatesFileInfo(self.form.images),
                    slugCallback: function (filename) {
                        return filename.replace('(', '_').replace(']', '_');
                    },
                })
                .on('filebatchselected', function () {
                    // event, files
                    $('#picts').fileinput('upload');
                })
                .on('filebatchuploadsuccess', function (event, data) {
                    self.form.images.push(...data.response.initialPreviewConfig);
                    self.form.totalInputtedPicts = self.form.images.length;
                })
                .on('filebeforedelete', function () {
                    //
                })
                .on('filedeleted', function (event, key) {
                    let getDataFileInfo = self.removeDuplicatesFileInfo(self.form.images);

                    var singleRemoveFileInfo = getDataFileInfo.filter(function (x) {
                        return x.key == key;
                    });

                    var filteredRes = getDataFileInfo.filter(
                        (item) => !singleRemoveFileInfo.includes(item)
                    );

                    self.form.images = filteredRes;
                    self.form.totalInputtedPicts = self.form.images.length;
                });
        },
        showSuccessMsg(response) {
            let responseData = response.data;
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
            //this.msg = response.responseJSON.message;
            console.log(response);
            swal.fire({
                icon: 'error',
                title: 'Oopss...',
                text: 'Make sure you have fill all the fields!', //this.msg,
                footer: '<a href>Why do I have this issue?</a>',
            });
        },
        showVariantFieldsErr(response) {
            let responseData = response.data;
            this.msg = responseData.message;

            swal.fire({
                icon: 'error',
                title: 'Oopss...',
                text: this.msg,
                footer: '<a href>Why do I have this issue?</a>',
            });
        },
        validateInputFields() {
            let images = this.form.images;

            if (images.length > 0) {
                var uploadedImages = images.length;
            } else {
                var inputImages = $('#picts').val();
            }

            if (uploadedImages == 0 || inputImages == '') {
                $('#picts').fileinput('upload');
            }
        },
        validateVariants(res) {
            let responseData = res.data;
            let images = this.form.images;

            if (images.length > 0) {
                var uploadedImages = images.length;
            } else {
                var inputImages = $('#picts').val();
            }

            if (uploadedImages == 0 || inputImages == '') {
                $('#picts').fileinput('upload');
                swal.fire({
                    icon: 'error',
                    title: 'Oouch...',
                    text: responseData.message,
                    footer: '<a href>Why do I have this issue?</a>',
                });
            }

            let variant_type = this.variant_type;

            this.form.variants.forEach((data) => {
                let dataObjVal = Object.values(data);

                $('.variant_type_' + dataObjVal[0]).removeClass('is-invalid');
                var existingTokens = $('.variant_options_' + dataObjVal[0]).tokenfield('getTokens');
                variant_type = $('.variant_type_' + dataObjVal[0]).val();

                if (variant_type == '') {
                    $('.variant_type_' + dataObjVal[0]).addClass('is-invalid');
                    this.showVariantFieldsErr(res);
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
                    this.showVariantFieldsErr(res);
                }
            });

            var emptyVarType = this.form.variants.filter(function (x) {
                return x.variant_type == '';
            });

            var emptyVarOpt = this.form.variants.filter(function (x) {
                return x.variant_options.length === 0;
            });

            if (emptyVarType.length === 0 && emptyVarOpt.length === 0) {
                this.validateVariantsProd(res);
            }
        },
        validateVariantsProd(res) {
            var emptyInputImgs = this.form.variants_prod.filter(function (x) {
                return x.total_images == 0;
            });

            this.form.variants_prod.forEach((data) => {
                let inputPrice = $('.variant_price_' + data.id).val();
                let inputStock = $('.variant_available_stock_' + data.id).val();
                let inputSku = $('.variant_sku_' + data.id).val();
                let images = data.images;

                if (images.length > 0) {
                    var uploadedImages = images.length;
                } else {
                    var inputImages = $('.images' + data.id).val();
                }

                $('.variant_price_' + data.id).removeClass('is-invalid');
                $('.variant_available_stock_' + data.id).removeClass('is-invalid');
                $('.variant_sku_' + data.id).removeClass('is-invalid');

                if (inputPrice == '') {
                    $('.variant_price_' + data.id).addClass('is-invalid');
                    this.showVariantFieldsErr(res);
                }

                if (inputStock == '') {
                    $('.variant_available_stock_' + data.id).addClass('is-invalid');
                    this.showVariantFieldsErr(res);
                }

                if (inputSku == '') {
                    $('.variant_sku_' + data.id).addClass('is-invalid');
                    this.showVariantFieldsErr(res);
                }

                if (uploadedImages == 0 || inputImages == '') {
                    this.showVariantFieldsErr(res);
                    $('.images' + data.id).fileinput('upload');
                }
            });

            var price = this.form.variants_prod.filter(function (x) {
                return x.price == '';
            });

            var sku = this.form.variants_prod.filter(function (x) {
                return x.sku == '';
            });

            var stock = this.form.variants_prod.filter(function (x) {
                return x.available_stock == '';
            });

            if (
                price.length === 0 &&
                sku.length === 0 &&
                stock.length === 0 &&
                emptyInputImgs.length == 0 && // empty input images is not exist.
                this.form.images.length > 0
            ) {
                //this.$router.push({ name: 'products-index' });
                this.showSuccessMsg(res);
            }
        },
        store() {
            $('#loadingButton').html(
                `<div class="proc-regis"><i class='fa fa-circle-o-notch fa-spin'></i> Storing data</div>`
            );
            $('#loadingButton').attr('disabled', true);

            this.getSwitchValue();
            this.getSwitchValueVarProds();
            this.getRadioButtonVarProdsVal();
            this.form.isVariantExists = $('#variant_type').length;
            this.form.brand_id = $('#brand_id').val();
            this.form.category_id = $('#category_id').find(':selected').attr('data-id');
            this.form.subcategory_id = $('#subcategory_id').find(':selected').attr('data-id');
            this.form.subsubcategory_id = $('#subsubcategory_id').find(':selected').attr('data-id');

            let formData = new FormData();
            formData.append('isVariantExists', this.form.isVariantExists);  
            let variants = JSON.stringify(this.form.variants);
            formData.append('variants', variants);
            formData.append('variants_prod', this.form.variants_prod);
            formData.append('totalInputtedPicts', this.form.totalInputtedPicts);

            this.form
                .post(`${BASE_URL}/api/staff/products/store`, { data: formData })
                .then((result) => {
                    let responseData = result.data;
                    if (this.form.isVariantExists > 0) {
                        this.validateInputFields();
                        this.validateVariants(result);
                    } else {
                        let images = this.form.images;

                        if (images.length > 0) {
                            var uploadedImages = images.length;
                        } else {
                            var inputImages = $('#picts').val();
                        }

                        if (uploadedImages == 0 || inputImages == '') {
                            $('#picts').fileinput('upload');
                            swal.fire({
                                icon: 'error',
                                title: 'Oouch...',
                                text: responseData.message,
                                footer: '<a href>Why do I have this issue?</a>',
                            });
                        } else {
                            this.$router.push({ name: 'products-index' });
                            this.showSuccessMsg(result);
                        }
                    }
                    $('#loadingButton').attr('disabled', false);
                    $('.proc-regis').remove();
                    $('#loadingButton').html(`Save`);
                })
                .catch((err) => {
                    console.log(err);
                    this.showErrMsg(err);
                    $('#loadingButton').attr('disabled', false);
                    $('.proc-regis').remove();
                    $('#loadingButton').html(`Save`);
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
        this.fileInput();
        this.disableRightClickAndLongPress('min_order');
        this.disableRightClickAndLongPress('price');
        this.disableRightClickAndLongPress('available_stock');
        this.disableRightClickAndLongPress('product_weight');
        this.disableRightClickAndLongPress('product_length');
        this.disableRightClickAndLongPress('product_width');
        this.disableRightClickAndLongPress('product_height');
        // bootstrap-switch.min.js is already attached in main.js
        $('.status').bootstrapSwitch('state', $('.status').prop('checked'));
        $('.hot_deals').bootstrapSwitch('state', $('.hot_deals').prop('checked'));
        $('.special_offer').bootstrapSwitch('state', $('.special_offer').prop('checked'));
        $('.special_deals').bootstrapSwitch('state', $('.special_deals').prop('checked'));
        $('.featured').bootstrapSwitch('state', $('.featured').prop('checked'));
    },
};
</script>
<style>
select.form-control {
    -webkit-appearance: menulist;
}
.section-title {
    border: 0;
    border-bottom: 1px solid #eee;
    color: #31708f;
    padding-bottom: 5px;
    margin-right: 50px;
}
td {
    white-space: nowrap;
}
.product_variants {
    overflow-x: scroll;
    white-space: nowrap;
}
.ck-editor__editable_inline {
    min-height: 200px;
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
/* adjust file input preview image. Place it in fileinput css file*/
/*.file-thumbnail-footer {
    width: 113;
    height: 70;
}
.clearfix {
    width: 113;
    height: 31;
}
.kv-file-content {
    width: 113; 
    height: 100; 
display: block;
  margin-left: auto;
  margin-right: auto;
}
.file-preview-frame {
    width: 127;
    height: 169;
}*/ ;
</style>
