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
                                                        v-bind:name="form.brand"
                                                        id="brand"
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid': form.errors.has('brand'),
                                                        }"
                                                    >
                                                        <option value="default" selected="true">
                                                            === Select Brand ===
                                                        </option>
                                                    </select>
                                                    <span
                                                        class="text-danger"
                                                        id="brand_error"
                                                    ></span>
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
                                        <div
                                            v-if="form.variantsProd.length > 0"
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
                                                        v-for="variantVal in form.variantsProd"
                                                        :key="variantVal.id"
                                                        @mouseover="
                                                            fileInputVariants(variantVal.id)
                                                        "
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
                                                                            key !== 'stock' &&
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
                                                                    @mouseover="
                                                                        validateInputNumber(
                                                                            'variant_price_' +
                                                                                variantVal.id
                                                                        )
                                                                    "
                                                                    :class="
                                                                        'variant_price_' +
                                                                        variantVal.id
                                                                    "
                                                                    v-bind:name="variantVal.price"
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
                                                                    'variant_stock_' + variantVal.id
                                                                "
                                                                @mouseover="
                                                                    validateInputNumber(
                                                                        'variant_stock_' +
                                                                            variantVal.id
                                                                    )
                                                                "
                                                                v-bind:name="variantVal.stock"
                                                                class="form-control"
                                                                required
                                                                autocomplete="variant_stock"
                                                                autofocus
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
                                                        type="text"
                                                        id="minimum_order"
                                                        v-bind:name="form.minimum_order"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('minimum_order'),
                                                        }"
                                                        class="form-control minimum_order"
                                                        required
                                                        autocomplete="minimum_order"
                                                        autofocus
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        id="minimum_order_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('minimum_order')"
                                                        v-html="form.errors.get('minimum_order')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-4 job-info">
                                                <label for="product_price">Product Price </label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input
                                                        id="product_price"
                                                        type="text"
                                                        v-bind:name="form.product_price"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('product_price'),
                                                        }"
                                                        class="form-control product_price"
                                                        required
                                                        autocomplete="product_price"
                                                        autofocus
                                                        aria-label="Amount (to the nearest dollar)"
                                                    />
                                                </div>
                                                <span
                                                    class="text-danger"
                                                    id="product_price_error"
                                                ></span>
                                                <div
                                                    style="color: red"
                                                    v-if="form.errors.has('product_price')"
                                                    v-html="form.errors.get('product_price')"
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
                                                    <label for="single_stock">Stock</label>
                                                    <input
                                                        id="single_stock"
                                                        v-bind:name="form.single_stock"
                                                        type="text"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has('single_stock'),
                                                        }"
                                                        class="form-control single_stock"
                                                        required
                                                        autocomplete="single_stock"
                                                        autofocus
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        id="single_stock_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('single_stock')"
                                                        v-html="form.errors.get('single_stock')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-left: 50px">
                                                    <label for="product_condition"
                                                        >Product Condition</label
                                                    >
                                                    <br />
                                                    <input
                                                        value="New"
                                                        type="radio"
                                                        id="new"
                                                        name="product_condition"
                                                        checked
                                                    />
                                                    <label for="new">New</label> &nbsp; &nbsp;
                                                    <input
                                                        value="Second"
                                                        type="radio"
                                                        id="second"
                                                        name="product_condition"
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
                                                <label for="sku">Weight</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input
                                                        id="weight"
                                                        v-bind:name="form.weight"
                                                        :class="{
                                                            'is-invalid': form.errors.has('weight'),
                                                        }"
                                                        type="text"
                                                        class="form-control weight"
                                                        required
                                                        autocomplete="weight"
                                                        placeholder="Weight"
                                                        autofocus
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        id="weight_error"
                                                    ></span>
                                                    <div
                                                        style="color: red"
                                                        v-if="form.errors.has('weight')"
                                                        v-html="form.errors.get('weight')"
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
                                                        <option value="Gram (g)">Gram (g)</option>
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
                                                            id="length"
                                                            v-bind:name="form.length"
                                                            :class="{
                                                                'is-invalid':
                                                                    form.errors.has('length'),
                                                            }"
                                                            class="form-control length"
                                                            placeholder="Length"
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                        <span
                                                            class="text-danger"
                                                            id="length_error"
                                                        ></span>
                                                        <div
                                                            style="color: red"
                                                            v-if="form.errors.has('length')"
                                                            v-html="form.errors.get('length')"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <input
                                                            type="text"
                                                            id="width"
                                                            v-bind:name="form.width"
                                                            :class="{
                                                                'is-invalid':
                                                                    form.errors.has('width'),
                                                            }"
                                                            class="form-control width"
                                                            placeholder="Width"
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                        <span
                                                            class="text-danger"
                                                            id="width_error"
                                                        ></span>
                                                        <div
                                                            style="color: red"
                                                            v-if="form.errors.has('width')"
                                                            v-html="form.errors.get('width')"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <input
                                                            type="text"
                                                            id="height"
                                                            v-bind:name="form.height"
                                                            :class="{
                                                                'is-invalid':
                                                                    form.errors.has('height'),
                                                            }"
                                                            class="form-control height"
                                                            placeholder="Height"
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                        <span
                                                            class="text-danger"
                                                            id="height_error"
                                                        ></span>
                                                        <div
                                                            style="color: red"
                                                            v-if="form.errors.has('height')"
                                                            v-html="form.errors.get('height')"
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
                                                            name="picts[]"
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
                                                @mouseover="collectData()"
                                                v-on:keydown.enter="collectData()"
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
import '@/assets/js/select2.min.js';
import '@/assets/js/bootstrap-tokenfield.js'; // another related file found index.html
import { BASE_URL } from '@/assets/js/base-url.js';
import swal from 'sweetalert2';
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
                brand: '',
                category_id: '',
                subcategory_id: '',
                subsubcategory_id: '',
                short_desc: '',
                long_desc: '',
                minimum_order: '',
                product_price: '',
                single_stock: '',
                product_condition: '',
                sku: '',
                length: '',
                width: '',
                height: '',
                weight: '',
                metric_mass: '',
                dataPicts: [],
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
                variantsProd: [],
            }),
            error: '',
            attributes: [],
            title: '',
            dataFiles: [],
        };
    },
    methods: {
        removeDuplicatesFileInfo(arr) {
            let s = new Set(arr);
            let it = s.values();
            return Array.from(it);
        },
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
        collectData() {
            this.form.variantsProd.forEach((item) => {
                var last = this.form.variantsProd[this.form.variantsProd.length - 1];
                const isEmpty = (str) => !str.trim().length;

                if (this.dataFiles.length > 0) {
                    let dataFileInfo = this.removeDuplicatesFileInfo(this.dataFiles);
                    var fileInfo = dataFileInfo.filter(function (x) {
                        return x.id == item.id;
                    });

                    if (fileInfo.length > 0) {
                        var totalImages = fileInfo.length;
                    } else {
                        totalImages = 0;
                    }
                } else {
                    fileInfo = [];
                    totalImages = 0;
                }

                if ($('.status_' + item.id).is(':checked') === false) {
                    item.status = 'Inactive';
                } else {
                    item.status = 'Active';
                }

                item.price = $('.variant_price_' + item.id).val();
                item.images = fileInfo;
                item.total_images = totalImages;
                item.condition = document.querySelector(
                    'input[name="condition_' + item.id + '"]:checked'
                ).value;
                item.stock = $('.variant_stock_' + item.id).val();

                if (item.price === undefined || isEmpty(item.product_variant)) {
                    item.product_variant = $('.variant_product_' + last.id).text();
                    item.price = $('.variant_price_' + last.id).val();
                    item.stock = $('.variant_stock_' + last.id).val();
                    item.sku = $('.variant_sku_' + last.id).val();
                }
            });

            this.getSwitchValue();
            this.form.brand = $('#brand').val();
            this.form.category_id = $('#category_id').val();
            this.form.subcategory_id = $('#subcategory_id').val();
            this.form.subsubcategory_id = $('#subsubcategory_id').val();
            this.form.metric_mass = $('#metric_mass').val();
            this.form.minimum_order = $('.minimum_order').val();
            this.form.product_price = $('.product_price').val();
            this.form.single_stock = $('.single_stock').val();
            this.form.weight = $('.weight').val();
            this.form.length = $('.length').val();
            this.form.width = $('.width').val();
            this.form.height = $('.height').val();
            this.form.product_condition = document.querySelector(
                'input[name="product_condition"]:checked'
            ).value;

            console.log(JSON.stringify(this.form.variantsProd));
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
                .on('tokenfield:removetoken', function (event) {
                    if (self.dataFiles.length > 0) {
                        alert('Please delete all the inputted images variant products first!');
                        event.preventDefault();
                    }
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
                            this.form.variantsProd.splice(0, this.form.variantsProd.length);
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
        },
        deleteVariant(index) {
            if (this.dataFiles.length > 0) {
                alert('Please delete all the inputted images variant products first!');
            } else {
                $('#errMsg').hide();
                this.form.variants.splice(index, 1);
                if (this.form.variants.length === 0) {
                    this.form.variantsProd.splice(0, this.form.variantsProd.length);
                }
                $('.product_variants').find(':input').val('');
                this.getVariantProducts();
            }
        },
        showSuccessMsg(response) {
            this.msg = response.message;

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
            this.msg = response.responseJSON.message;

            swal.fire({
                icon: 'error',
                title: 'Oopss...',
                text: this.msg,
                footer: '<a href>Why do I have this issue?</a>',
            });
        },
        showVariantFieldsErr(response) {
            this.msg = response.message;

            swal.fire({
                icon: 'error',
                title: 'Oopss...',
                text: this.msg,
                footer: '<a href>Why do I have this issue?</a>',
            });
        },
        validateInputNumber(className) {
            // disable right click
            $('.' + className + '').on('contextmenu', function () {
                return false;
            });

            function addDot(x) {
                return x.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            var flag = 0;
            $('.' + className + '').on('keydown', function (e) {
                flag++;
                if (flag > 4) {
                    e.preventDefault();
                }
            });

            $('.' + className + '').on('keyup', this, function (event) {
                flag = 0;

                // skip for arrow left (37) and arrow down (40)
                if (event.which >= 37 && event.which <= 40) {
                    return;
                }

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

            //////////////////////////////////////////////////////////////////////////////////

            $('.' + className + '').on('paste', function (event) {
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
                        $('.' + className + '').val(res); // Assume, we paste 200000, without if else below, it will result 200.000200000

                        return false;
                    } else {
                        var res2 = addDot(dataText);
                        $('.' + className + '').val(res2); // Assume, we paste 200000, without if else below, it will result 200.000200000
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
        loadBrands() {
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
                    uploadUrl: `${BASE_URL}/api/products/store-picts-single-product`,
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
                    initialPreviewConfig: self.removeDuplicatesFileInfo(self.form.dataPicts),
                    slugCallback: function (filename) {
                        return filename.replace('(', '_').replace(']', '_');
                    },
                })
                .on('filebatchselected', function () {
                    // event, files
                    $('#picts').fileinput('upload');
                })
                .on('filebatchuploadsuccess', function (event, data) {
                    self.form.dataPicts.push(...data.response.initialPreviewConfig);
                    self.form.totalInputtedPicts = self.form.dataPicts.length;
                })
                .on('filebeforedelete', function () {
                    //
                })
                .on('filedeleted', function (event, key) {
                    let getDataFileInfo = self.removeDuplicatesFileInfo(self.form.dataPicts);

                    var singleRemoveFileInfo = getDataFileInfo.filter(function (x) {
                        return x.key == key;
                    });

                    var filteredRes = getDataFileInfo.filter(
                        (item) => !singleRemoveFileInfo.includes(item)
                    );

                    self.form.dataPicts = filteredRes;
                    self.form.totalInputtedPicts = self.form.dataPicts.length;
                });
        },
        fileInputVariants(id) {
            var self = this;

            $('.status_' + id).bootstrapSwitch('state', $('.status_' + id).prop('checked'));

            $('.images' + id)
                .fileinput({
                    theme: 'fas',
                    uploadUrl: `${BASE_URL}/api/products/store-images/` + id,
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
                    self.dataFiles.push(...data.response.initialPreviewConfig);
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
                    self.collectData();
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
        validateVariants(res) {
            let images = this.form.dataPicts;

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
                    text: res.message,
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

                if (variant_type !== '' && existingTokens.length > 0) {
                    this.validateVariantsProd(res);
                }
            });
        },
        validateVariantsProd(res) {
            var emptyInputImgs = this.form.variantsProd.filter(function (x) {
                return x.total_images == 0;
            });

            this.form.variantsProd.forEach((data) => {
                let inputPrice = $('.variant_price_' + data.id).val();
                let inputStock = $('.variant_stock_' + data.id).val();
                let inputSku = $('.variant_sku_' + data.id).val();
                let images = data.images;

                if (images.length > 0) {
                    var uploadedImages = images.length;
                } else {
                    var inputImages = $('.images' + data.id).val();
                }

                $('.variant_price_' + data.id).removeClass('is-invalid');
                $('.variant_stock_' + data.id).removeClass('is-invalid');
                $('.variant_sku_' + data.id).removeClass('is-invalid');

                if (inputPrice == '') {
                    $('.variant_price_' + data.id).addClass('is-invalid');
                    this.showVariantFieldsErr(res);
                }

                if (inputStock == '') {
                    $('.variant_stock_' + data.id).addClass('is-invalid');
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

                if (
                    inputPrice !== '' &&
                    inputStock !== '' &&
                    inputSku !== '' &&
                    emptyInputImgs.length == 0 && // empty input images is not exist.
                    this.form.dataPicts.length > 0
                ) {
                    //this.$router.push({ name: 'products-index' });
                    this.showSuccessMsg(res);
                }
            });
        },
        validateInputFields(error) {
            if ($('#brand').val() === 'default') {
                $('#brand').addClass('is-invalid');
                $('#brand_error').text(error.responseJSON.errors.brand);
            } else {
                $('#brand').removeClass('is-invalid');
                $('#brand_error').text('');
            }

            if ($('#product_name').val() === '') {
                $('#product_name').addClass('is-invalid');
                $('#codeError').text(error.responseJSON.errors.product_name);
                $('.alert-danger').html('An error in your input fields');
            } else {
                $('#product_name').removeClass('is-invalid');
                $('#codeError').text('');
            }

            if ($('#category_id').val() === 'default') {
                $('#category_id').addClass('is-invalid');
                $('#category_id_error').text(error.responseJSON.errors.category_id);
            } else {
                $('#category_id').removeClass('is-invalid');
                $('#category_id_error').text('');
            }

            if ($('#subcategory_id').val() === 'default') {
                $('#subcategory_id').addClass('is-invalid');
                $('#subcategory_id_error').text(error.responseJSON.errors.subcategory_id);
            } else {
                $('#subcategory_id').removeClass('is-invalid');
                $('#subcategory_id_error').text('');
            }

            if ($('#subsubcategory_id').val() === 'default') {
                $('#subsubcategory_id').addClass('is-invalid');
                $('#subsubcategory_id_error').text(error.responseJSON.errors.subsubcategory_id);
            } else {
                $('#subsubcategory_id').removeClass('is-invalid');
                $('#subsubcategory_id_error').text('');
            }

            if ($('#short_desc').val() === '') {
                $('#short_desc').addClass('is-invalid');
                $('#short_desc_error').text(error.responseJSON.errors.short_desc);
            } else {
                $('#short_desc').removeClass('is-invalid');
                $('#short_desc_error').text('');
            }

            if (this.form.long_desc === '') {
                $('#long_desc').addClass('is-invalid');
                $('#long_desc_error').text(error.responseJSON.errors.long_desc);
            } else {
                $('#long_desc').removeClass('is-invalid');
                $('#long_desc_error').text('');
            }

            if ($('#minimum_order').val() === '') {
                $('#minimum_order').addClass('is-invalid');
                $('#minimum_order_error').text(error.responseJSON.errors.minimum_order);
            } else {
                $('#minimum_order').removeClass('is-invalid');
                $('#minimum_order_error').text('');
            }

            if ($('#product_price').val() === '') {
                $('#product_price').addClass('is-invalid');
                $('#product_price_error').text(error.responseJSON.errors.product_price);
            } else {
                $('#product_price').removeClass('is-invalid');
                $('#product_price_error').text('');
            }

            if ($('#single_stock').val() === '') {
                $('#single_stock').addClass('is-invalid');
                $('#single_stock_error').text(error.responseJSON.errors.single_stock);
            } else {
                $('#single_stock').removeClass('is-invalid');
                $('#single_stock_error').text('');
            }

            if ($('#sku').val() === '') {
                $('#sku').addClass('is-invalid');
                $('#sku_error').text(error.responseJSON.errors.sku);
            } else {
                $('#sku').removeClass('is-invalid');
                $('#sku_error').text('');
            }

            if ($('#length').val() === '') {
                $('#length').addClass('is-invalid');
                $('#length_error').text(error.responseJSON.errors.length);
            } else {
                $('#length').removeClass('is-invalid');
                $('#length_error').text('');
            }

            if ($('#width').val() === '') {
                $('#width').addClass('is-invalid');
                $('#width_error').text(error.responseJSON.errors.width);
            } else {
                $('#width').removeClass('is-invalid');
                $('#width_error').text('');
            }

            if ($('#height').val() === '') {
                $('#height').addClass('is-invalid');
                $('#height_error').text(error.responseJSON.errors.height);
            } else {
                $('#height').removeClass('is-invalid');
                $('#height_error').text('');
            }

            if ($('#weight').val() === '') {
                $('#weight').addClass('is-invalid');
                $('#weight_error').text(error.responseJSON.errors.weight);
            } else {
                $('#weight').removeClass('is-invalid');
                $('#weight_error').text('');
            }

            let images = this.form.dataPicts;

            if (images.length > 0) {
                var uploadedImages = images.length;
            } else {
                var inputImages = $('#picts').val();
            }

            if (uploadedImages == 0 || inputImages == '') {
                $('#picts').fileinput('upload');
            }
        },
        store() {
            $('#loadingButton').html(
                `<div class="proc-regis"><i class='fa fa-circle-o-notch fa-spin'></i> Storing data</div>`
            );
            $('#loadingButton').attr('disabled', true);

            this.form.isVariantExists = $('#variant_type').length;
            this.form.category_id = $('#category_id').find(':selected').attr('data-id');
            this.form.subcategory_id = $('#subcategory_id').find(':selected').attr('data-id');
            this.form.subsubcategory_id = $('#subsubcategory_id').find(':selected').attr('data-id');

            let formData = new FormData();
            formData.append('product_name', this.form.product_name);
            formData.append('brand', this.form.brand);
            formData.append('category_id', this.form.category_id);
            formData.append('subcategory_id', this.form.subcategory_id);
            formData.append('subsubcategory_id', this.form.subsubcategory_id);
            formData.append('short_desc', this.form.short_desc);
            formData.append('long_desc', this.form.long_desc);
            formData.append('minimum_order', this.form.minimum_order);
            formData.append('product_price', this.form.product_price);
            formData.append('single_stock', this.form.single_stock);
            formData.append('status', this.form.status);
            formData.append('sku', this.form.sku);
            formData.append('product_condition', this.form.product_condition);
            formData.append('weight', this.form.weight);
            formData.append('length', this.form.length);
            formData.append('width', this.form.width);
            formData.append('height', this.form.height);
            formData.append('hot_deals', this.form.hot_deals);
            formData.append('featured', this.form.featured);
            formData.append('special_offer', this.form.special_offer);
            formData.append('special_deals', this.form.special_deals);
            formData.append('metric_mass', this.form.metric_mass);
            let dataPicts = JSON.stringify(this.form.dataPicts);
            formData.append('dataPicts', dataPicts);
            formData.append('totalInputtedPicts', this.form.totalInputtedPicts);
            let variants = JSON.stringify(this.form.variants);
            formData.append('variants', variants);
            let varProd = JSON.stringify(this.form.variantsProd); // convert object to string
            formData.append('variantsProd', varProd);
            formData.append('isVariantExists', this.form.isVariantExists);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
            const token = localStorage.getItem('token-staff');
            var self = this;
            $.ajax({
                url: `${BASE_URL}/api/staff/products/store`,
                method: 'post',
                data: formData,
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
                    let myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${token}`);
                },
                error: function (error) {
                    console.log(error);
                    self.showErrMsg(error);
                    self.validateInputFields(error);
                    $('#loadingButton').attr('disabled', false);
                    $('.proc-regis').remove();
                    $('#loadingButton').html(`Save`);
                },
                success: function (result) {
                    if (result.errors) {
                        console.log(result);
                        swal.fire({
                            icon: 'error',
                            title: 'Oouch...',
                            text: 'Something went wrong! Make sure you input the valid data!',
                            footer: '<a href>Why do I have this issue?</a>',
                        });
                        $('#loadingButton').attr('disabled', false);
                        $('.proc-regis').remove();
                        $('#loadingButton').html(`Save`);
                    } else {
                        if (self.form.isVariantExists > 0) {
                            self.validateInputFields(result);
                            self.validateVariants(result);
                        } else {
                            let images = self.form.dataPicts;

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
                                    text: result.message,
                                    footer: '<a href>Why do I have this issue?</a>',
                                });
                            } else {
                                //self.$router.push({ name: 'products-index' });
                                self.showSuccessMsg(result);
                            }
                        }
                        $('#loadingButton').attr('disabled', false);
                        $('.proc-regis').remove();
                        $('#loadingButton').html(`Save`);
                    } //endif
                },
            }); //ajax
        },
    }, // methods:
    created() {},
    mounted() {
        $('.status').bootstrapSwitch('state', $('.status').prop('checked'));
        $('.hot_deals').bootstrapSwitch('state', $('.hot_deals').prop('checked'));
        $('.special_offer').bootstrapSwitch('state', $('.special_offer').prop('checked'));
        $('.special_deals').bootstrapSwitch('state', $('.special_deals').prop('checked'));
        $('.featured').bootstrapSwitch('state', $('.featured').prop('checked'));
        this.tokenField();
        this.form.variants.splice(0, this.form.variants.length); // empty an array of dynamic variants field
        // prevent sweetalert error if user change the route when swal is still visible.
        if (swal.isVisible()) {
            document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
        }
        this.loadBrands();
        this.loadCatSelectOption();
        this.fileInput();
        this.validateInputNumber('minimum_order');
        this.validateInputNumber('product_price');
        this.validateInputNumber('single_stock');
        this.validateInputNumber('weight');
        this.validateInputNumber('length');
        this.validateInputNumber('width');
        this.validateInputNumber('height');
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
