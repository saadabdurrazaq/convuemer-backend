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
                <form @submit.prevent="update()" novalidate>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Info Product:</p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="product_name">Product Name</label>
                          <input
                            id="product_name"
                            v-model="form.product_name"
                            :class="{
                              'is-invalid': form.errors.has('product_name'),
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
                            v-model="form.brand_id"
                            id="brand_id"
                            class="form-control"
                            :class="{
                              'is-invalid': form.errors.has('brand_id'),
                            }"
                          >
                            <option value="default" selected="true">Select Brand</option>
                          </select>
                          <span class="text-danger" id="brand_error"></span>
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
                            <option value="default" selected="true">Select Category</option>
                          </select>
                          <span class="text-danger" id="category_id_error"></span>
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
                              'is-invalid': form.errors.has('subcategory_id'),
                            }"
                            id="subcategory_id"
                            class="form-control"
                            :required="true"
                          >
                            <option value="default" id="default-subcat" selected="true">
                              Select Sub Category
                            </option>
                          </select>
                          <span class="text-danger" id="subcategory_id_error"></span>
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
                          <label for="citizenship">Sub-sub Category</label>
                          <select
                            v-bind:name="form.subsubcategory_id"
                            id="subsubcategory_id"
                            class="form-control"
                            :class="{
                              'is-invalid': form.errors.has('subcategory_id'),
                            }"
                            :required="true"
                          >
                            <option value="default" id="default-subcat" selected="true">
                              Select Sub Sub Category
                            </option>
                          </select>
                          <span class="text-danger" id="subsubcategory_id_error"></span>
                          <div
                            style="color: red"
                            class="errorIcon"
                            v-if="form.errors.has('subsubcategory_id')"
                            v-html="form.errors.get('subsubcategory_id')"
                          />
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Detail Product:</p>
                        </div>
                      </div>
                    </div>
                    <!-- row 1 -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="short_desc">Short Description</label>
                          <textarea
                            v-model="form.short_desc"
                            :class="{
                              'is-invalid': form.errors.has('short_desc'),
                            }"
                            id="short_desc"
                            class="form-control"
                            name="short_desc"
                            required
                            autocomplete="short_desc"
                          />
                          <span class="text-danger" id="short_desc_error"></span>
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
                          <span class="text-danger" id="long_desc_error"></span>
                          <div
                            style="color: red"
                            v-if="form.errors.has('long_desc')"
                            v-html="form.errors.get('long_desc')"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- product variant here -->
                    <!-- End row 1 -->
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Product Variant:</p>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="form-group">
                            <a class="btn btn-success" style="color: white" @click="addVariant">
                              Add Variant
                            </a>
                            <div style="display: none" id="errMsg" class="box no-border">
                              <div class="box-tools" style="margin-top: 15px">
                                <p class="alert alert-warning alert-dismissible">
                                  {{ this.error }}
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
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10 variants">
                        <div v-if="pageIsLoaded" class="form-group">
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
                                      :class="'variant_type_' + variant.id"
                                      :name="variant_type"
                                      v-model="variant.variant_type"
                                      onkeydown="if (event.keyCode == 13) event.preventDefault()"
                                      placeholder="Input variant type. E.g: Color"
                                      required
                                      autofocus
                                    />
                                    <div
                                      style="color: red"
                                      v-if="form.errors.has('variant_type')"
                                      v-html="form.errors.get('variant_type')"
                                    />
                                  </div>
                                </div>
                                <div class="col-md-8">
                                  <label for="product_weight"
                                    >Variant Options {{ index + 1 }}</label
                                  >
                                  <div class="input-group">
                                    <input
                                      type="text"
                                      :class="'variant_options_' + variant.id"
                                      autofocus="true"
                                      v-model="variant.variant_options"
                                      placeholder="Input variant options. E.g: Blue, Brown,"
                                      class="form-control variant_options"
                                    />
                                  </div>
                                  <small class="text-muted"
                                    >End with a comma for single or multiple inputs. E.g: data1,
                                    data2,</small
                                  >
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- v-for -->
                        </div>
                        <div v-else></div>
                      </div>
                      <!-- col 10 -->
                    </div>
                    <!-- row product varian -->
                    <div v-if="form.variants_prod.length > 0" class="product_variants">
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
                          <tr v-for="variantVal in form.variants_prod" :key="variantVal.id">
                            <td style="display: none">
                              <input
                                v-model="variantVal.id"
                                :class="'variant_product_' + variantVal.id"
                                class="form-control"
                                type="hidden"
                                name="variant_product"
                              />
                            </td>
                            <td v-if="variantVal.product_variant">
                              {{ variantVal.product_variant }}
                            </td>
                            <td v-else :class="'variant_product_' + variantVal.id">
                              {{
                                Object.entries(variantVal)
                                  .filter(
                                    ([key]) =>
                                      key !== 'id' &&
                                      key !== 'product_variant' &&
                                      key !== 'price' &&
                                      key !== 'available_stock' &&
                                      key !== 'sku' &&
                                      key !== 'images' &&
                                      key !== 'total_images' &&
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
                                  <span class="input-group-text">Rp</span>
                                </div>
                                <input
                                  id="variant_price"
                                  type="text"
                                  :class="'variant_price_' + variantVal.id"
                                  v-model="variantVal.price"
                                  class="form-control"
                                  required
                                  autofocus
                                  @keyup="allowOnlyNumberAndDot($event)"
                                />
                              </div>
                            </td>
                            <td>
                              <input
                                id="variant_stock"
                                type="text"
                                :class="'variant_stock_' + variantVal.id"
                                v-model="variantVal.available_stock"
                                class="form-control"
                                required
                                autocomplete="variant_stock"
                                autofocus
                                @keyup="allowOnlyNumberAndDot($event)"
                              />
                            </td>
                            <td v-if="variantVal.condition === 'New'">
                              <input
                                value="New"
                                type="radio"
                                id="new"
                                :name="'condition_' + variantVal.id"
                                :class="'condition_' + variantVal.id"
                                checked
                              />
                              <label for="new">New</label> <br />
                              <input
                                value="Second"
                                type="radio"
                                id="second"
                                :name="'condition_' + variantVal.id"
                                :class="'condition_' + variantVal.id"
                              />
                              <label for="second">Second</label>
                            </td>
                            <td v-else>
                              <input
                                value="New"
                                type="radio"
                                id="new"
                                :name="'condition_' + variantVal.id"
                                :class="'condition_' + variantVal.id"
                              />
                              <label for="new">New</label> <br />
                              <input
                                value="Second"
                                type="radio"
                                id="second"
                                :name="'condition_' + variantVal.id"
                                :class="'condition_' + variantVal.id"
                                checked
                              />
                              <label for="second">Second</label>
                            </td>
                            <td>
                              <input
                                id="variant_sku"
                                type="text"
                                :class="'variant_sku_' + variantVal.id"
                                v-model="variantVal.sku"
                                class="form-control"
                                name="variant_sku"
                                required
                                autocomplete="variant_sku"
                                autofocus
                              />
                            </td>
                            <td v-if="variantVal.status === 'Active'">
                              <input
                                type="checkbox"
                                name="permission[]"
                                data-bootstrap-switch
                                data-off-color="danger"
                                data-on-text=""
                                data-off-text=""
                                data-size="small"
                                class="status_varprod"
                                :value="variantVal.id"
                                :class="'status_' + variantVal.id"
                                checked
                              />
                              <br />
                              {{ variantVal.status }}
                            </td>
                            <td v-else>
                              <input
                                type="checkbox"
                                name="permission[]"
                                data-bootstrap-switch
                                data-off-color="danger"
                                data-on-text=""
                                data-off-text=""
                                data-size="small"
                                :value="variantVal.id"
                                class="status_varprod"
                                :class="'status_' + variantVal.id"
                              />
                              <br />
                              {{ variantVal.status }}
                            </td>
                            <td>
                              <div class="file-loading">
                                <input
                                  id="images"
                                  :class="'images' + variantVal.id"
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
                    <!-- end product variant -->
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
                            v-model="form.min_order"
                            v-bind:name="form.min_order"
                            :class="{
                              'is-invalid': form.errors.has('min_order'),
                            }"
                            class="form-control min_order"
                            required
                            autocomplete="min_order"
                            autofocus
                            @keyup="allowOnlyNumberAndDot($event)"
                          />
                          <span class="text-danger" id="min_order_error"></span>
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
                            v-model="form.price"
                            v-bind:name="form.price"
                            :class="{
                              'is-invalid': form.errors.has('price'),
                            }"
                            class="form-control price"
                            required
                            autocomplete="price"
                            autofocus
                            aria-label="Amount (to the nearest dollar)"
                            @keyup="allowOnlyNumberAndDot($event)"
                          />
                        </div>
                        <span class="text-danger" id="price_error"></span>
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
                          <p class="lead section-title">Product Management:</p>
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
                              'is-invalid': form.errors.has('available_stock'),
                            }"
                            class="form-control available_stock"
                            required
                            autocomplete="available_stock"
                            autofocus
                            @keyup="allowOnlyNumberAndDot($event)"
                          />
                          <span class="text-danger" id="available_stock_error"></span>
                          <div
                            style="color: red"
                            v-if="form.errors.has('available_stock')"
                            v-html="form.errors.get('available_stock')"
                          />
                        </div>
                      </div>
                      <div v-if="form.product_cond === 'New'" class="col-md-3">
                        <div class="form-group" style="margin-left: 50px">
                          <label for="product_cond">Product Condition</label>
                          <br />
                          <input value="New" type="radio" id="new" name="product_cond" checked />
                          <label for="new">New</label> &nbsp; &nbsp;
                          <input value="Second" type="radio" id="second" name="product_cond" />
                          <label for="second">Second</label>
                        </div>
                      </div>
                      <div v-if="form.product_cond === 'Second'" class="col-md-3">
                        <div class="form-group" style="margin-left: 50px">
                          <label for="product_cond">Product Condition</label>
                          <br />
                          <input value="New" type="radio" id="new" name="product_cond" />
                          <label for="new">New</label> &nbsp; &nbsp;
                          <input
                            value="Second"
                            type="radio"
                            id="second"
                            name="product_cond"
                            checked
                          />
                          <label for="second">Second</label>
                        </div>
                      </div>
                      <div v-if="form.status === 'Active'" class="col-md-3">
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
                            class="status"
                            checked
                          />
                        </div>
                      </div>
                      <div v-else class="col-md-3">
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
                        <label for="product_weight">Product Weight</label>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input
                            id="product_weight"
                            v-bind:name="form.product_weight"
                            v-model="form.product_weight"
                            :class="{
                              'is-invalid': form.errors.has('product_weight'),
                            }"
                            type="text"
                            class="form-control product_weight"
                            required
                            autocomplete="product_weight"
                            placeholder="Product Weight"
                            autofocus
                            @keyup="allowOnlyNumberAndDot($event)"
                          />
                          <span class="text-danger" id="product_weight_error"></span>
                          <div
                            style="color: red"
                            v-if="form.errors.has('product_weight')"
                            v-html="form.errors.get('product_weight')"
                          />
                        </div>
                      </div>
                      <div v-if="form.metric_mass === 'Gram (g)'" class="col-md-7">
                        <div class="form-group">
                          <select
                            v-bind:name="form.metric_mass"
                            id="metric_mass"
                            :class="{
                              'is-invalid': form.errors.has('metric_mass'),
                            }"
                            class="form-control metric_mass"
                            style="width: 120px"
                          >
                            <option selected value="Gram (g)">Gram (g)</option>
                            <option value="Kilogram (kg)">Kilogram (kg)</option>
                          </select>
                        </div>
                      </div>
                      <div v-else class="col-md-7">
                        <div class="form-group">
                          <select
                            v-bind:name="form.metric_mass"
                            id="metric_mass"
                            :class="{
                              'is-invalid': form.errors.has('metric_mass'),
                            }"
                            class="form-control metric_mass"
                            style="width: 120px"
                          >
                            <option value="Gram (g)">Gram (g)</option>
                            <option selected value="Kilogram (kg)">Kilogram (kg)</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label for="dimension">Dimension</label>
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
                                'is-invalid': form.errors.has('product_length'),
                              }"
                              class="form-control product_length"
                              placeholder="Product Length"
                              @keyup="allowOnlyNumberAndDot($event)"
                            />
                            <div class="input-group-append">
                              <span class="input-group-text">cm</span>
                            </div>
                            <span class="text-danger" id="product_length_error"></span>
                            <div
                              style="color: red"
                              v-if="form.errors.has('product_length')"
                              v-html="form.errors.get('product_length')"
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
                                'is-invalid': form.errors.has('product_width'),
                              }"
                              class="form-control product_width"
                              placeholder="product_width"
                              @keyup="allowOnlyNumberAndDot($event)"
                            />
                            <div class="input-group-append">
                              <span class="input-group-text">cm</span>
                            </div>
                            <span class="text-danger" id="product_width_error"></span>
                            <div
                              style="color: red"
                              v-if="form.errors.has('product_width')"
                              v-html="form.errors.get('product_width')"
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
                                'is-invalid': form.errors.has('product_height'),
                              }"
                              class="form-control product_height"
                              placeholder="product_height"
                              @keyup="allowOnlyNumberAndDot($event)"
                            />
                            <div class="input-group-append">
                              <span class="input-group-text">cm</span>
                            </div>
                            <span class="text-danger" id="product_height_error"></span>
                            <div
                              style="color: red"
                              v-if="form.errors.has('product_height')"
                              v-html="form.errors.get('product_height')"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p class="lead section-title">Product Marketing:</p>
                        </div>
                      </div>
                      <div v-if="form.hot_deals === 'Yes'" class="col-md-3">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
                            class="hot_deals"
                            checked
                          />
                          &nbsp; Hot Deals
                        </div>
                      </div>
                      <div class="col-md-3" v-if="form.hot_deals === 'No'">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
                            class="hot_deals"
                          />
                          &nbsp; Hot Deals
                        </div>
                      </div>
                      <div v-if="form.special_offer === 'Yes'" class="col-md-3">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
                            class="special_offer"
                            checked
                          />
                          &nbsp; Special Offer
                        </div>
                      </div>
                      <div v-if="form.special_offer === 'No'" class="col-md-3">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
                            class="special_offer"
                          />
                          &nbsp; Special Offer
                        </div>
                      </div>
                      <div v-if="form.featured === 'Yes'" class="col-md-3">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
                            class="featured"
                            checked
                          />
                          &nbsp; Featured
                        </div>
                      </div>
                      <div v-if="form.featured === 'No'" class="col-md-3">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
                            class="featured"
                          />
                          &nbsp; Featured
                        </div>
                      </div>
                      <div v-if="form.special_deals === 'Yes'" class="col-md-3">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
                            class="special_deals"
                            checked
                          />
                          &nbsp; Special Deals
                        </div>
                      </div>
                      <div v-if="form.special_deals === 'No'" class="col-md-3">
                        <div class="form-group">
                          <input
                            type="checkbox"
                            name="permission[]"
                            data-bootstrap-switch
                            data-off-color="danger"
                            data-on-text=""
                            data-off-text=""
                            data-size="small"
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
                            <input id="picts" name="images[]" type="file" multiple />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="box-footer text-right">
                      <button type="submit" class="btn btn-primary btn-md" id="loadingButton">
                        Update
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
// npm install jquery-confirm
import 'jquery-confirm/js/jquery-confirm.js';
import 'jquery-confirm/css/jquery-confirm.css';

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
        id: '',
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
        imagesUpdated: [],
        variantIsDeleted: '',
        variants_prod: [], // all general variant products that displayed in the view.
        varProdsBeenStoredInDb: [], // it's used to update all existing variant products that displayed in the view and also already stored in db.
        varProdsImgsToBeDeleted: [], // all of the variant options that has been deleted in the view whether the new added variant products or the variant products that has been stored in DB, it's uploaded images should be stored here to be deleted. But the important thing, all the exisitng variant products in DB that user deleted through the variant options field, all that images will be deleted in controller if user click the update button.
        varProdsToBeDeleted: [], // The existing variant products that has been stored in db but user delete it in the view, it will be stored here to be deleted in controller if user click the update button.
        addedNewVarProds: [], // collect all new added variant products. It's gonna be stored in db.
        newVarProdsImagesToBeDeleted: [], // All new added variant products images (that not exist in database) must be deleted directly if user delete one of them through the variant options fields.
      }),
      error: '',
      attributes: [],
      title: '',
      pageIsLoaded: false,
      variantType: [],
      varProdsImgsToBeDeleted: [],
      addedNewVarProds: [],
    };
  },
  methods: {
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

          var varStock = $('.variant_stock_' + data.id).val();
          if (varStock.length > 11) {
            $('.variant_stock_' + data.id).val(varStock.substring(0, 11));
            return false;
          }

          // add dot in numbers and only number is allowed (replace(/\D/g, '')).
          $('.variant_stock_' + data.id).val(function (index, value) {
            return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          });

          data.price = $('.variant_price_' + data.id).val();
          data.available_stock = $('.variant_stock_' + data.id).val();
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
    generateVariantProducts() {
      let variants = this.form.variants;
      var variantsValue = [];

      variants.forEach((data) => {
        let dataObj = Object.values(data);
        var variantOpt = data.variant_options;

        var variantOptVal = [];
        variantOpt.forEach((data) => {
          variantOptVal.push(data.value);
        });

        // Arrays has not been merged, and still has it's properties.
        variantsValue.push({
          variant_id: dataObj[0],
          variant_type: dataObj[1],
          variant_options: variantOptVal,
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

      let arr2 = this.form.variants_prod.concat(attrs);
      this.form.variants_prod = arr2;

      this.form.variants.forEach((data) => {
        let dataObj = Object.values(data);
        data.variant_options = $('.variant_options_' + dataObj[0]).tokenfield('getTokens');
      });
    },
    getVarProdsBeenStoredInDb() {
      var storedVarProds = this.form.variants_prod.filter(function (x) {
        return Object.keys(x).includes('initial_preview');
      });
      this.form.varProdsBeenStoredInDb = storedVarProds;
    },
    getNewAddedVarProds() {
      var newVarProds = this.form.variants_prod.filter(function (x) {
        return Object.keys(x).includes('initial_preview') === false;
      });
      this.form.addedNewVarProds = newVarProds;
    },
    deleteAllNewAddedVarProdImages() {
      let formData = new FormData();
      formData.append('addedNewVarProds', this.form.addedNewVarProds);
      console.log(this.form.addedNewVarProds);
      this.form
        .post('api/products/delete-all-new-added-variant-product-images', {
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
    deleteSomeNewAddedVarProdImages() {
      let formData = new FormData();
      formData.append('newVarProdsImagesToBeDeleted', this.form.newVarProdsImagesToBeDeleted);

      this.form
        .post('api/products/delete-some-new-added-variant-product-images', {
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
    addVariant() {
      var self = this;
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
            this.form.variants_prod.splice(0, this.form.variants_prod.length);
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

      this.form.variants.forEach((data) => {
        setTimeout(function () {
          self.tokenField(data.id);
        }, 100);
      });
    },
    deleteVariant(index) {
      var self = this;
      this.form.variantIsDeleted = 'Yes';
      $('#errMsg').hide();

      this.form.variants.splice(index, 1);

      // if the last variant left is deleted.
      if (this.form.variants.length === 0) {
        // empty the variants_prod.
        this.form.variants_prod.splice(0, this.form.variants_prod.length);

        // delete the related variant product images.
        // Scenario: If user add the new variant products, and then he delete the variants
        if (this.form.addedNewVarProds !== undefined) {
          this.deleteAllNewAddedVarProdImages();
        }

        // delete all images that already stored in database

        // empty the new variant products.
        this.form.addedNewVarProds = [];
      }

      ///////////////////////////////////////////////////////////////////////////////////////////

      // if another variant is exist after one variant deleted.
      $('.product_variants').find(':input').val('');
      this.form.variants_prod = [];
      this.generateVariantProducts();

      this.form.variants_prod.forEach((data) => {
        // execute this.fileInputVariants(data.id) after 100 milisecond
        setTimeout(function () {
          self.fileInputVariants(data.id);
        }, 100);
      });

      // delete the related variant product images.
      // Scenario: If user add the new variant products, and then he delete the variants
      if (this.form.addedNewVarProds !== undefined) {
        this.deleteAllNewAddedVarProdImages();
      }

      // update the new added products list.
      this.form.addedNewVarProds = [];
      this.form.addedNewVarProds.push(this.form.variants_prod);
    },
    removeDuplicatesFileInfo(arr) {
      let s = new Set(arr);
      let it = s.values();
      return Array.from(it);
    },
    loadBrands() {
      this.axios
        .get('api/staff/get-brands', {})
        .then((response) => {
          var responseData = response.data;
          let brands = responseData.brands;

          var brandId = this.form.brand_id;

          var loadTheRestBrands = brands.filter(function (x) {
            return x.id !== brandId;
          });
          loadTheRestBrands.forEach(function (brand) {
            var option = new Option(brand.brand_name, brand.id, true, true);
            $('#brand_id').append(option);
            $('div.get-brands select').val('default').change();
          });

          if (this.form.brand_id !== null || this.form.brand_id !== undefined) {
            var selectedBrand = brands.filter(function (x) {
              return x.id == brandId;
            });

            selectedBrand.forEach(function (brand) {
              var option = new Option(brand.brand_name, brand.id, true, true);
              // show selected brand data in the first time
              $('div.get-brands select').append(option);
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fillCatSubCatAndSubSubCat() {
      // Fill category input
      const token = localStorage.getItem('token-staff');
      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/sub-sub-categories/get-cat-sub-cat/' + this.form.subsubcategory_id, {}) // The id refer to subsubcat
        .then((response) => {
          var responseData = response.data;
          let allCategories = responseData.all_categories;
          let allRelatedSubCategories = responseData.all_related_sub_categories;
          let allRelatedSubSubCategories = responseData.all_related_sub_sub_categories;
          let category = responseData.category;
          let subCategory = responseData.sub_category;
          let subSubCategory = responseData.sub_sub_category;

          allCategories.forEach(function (category) {
            var option = new Option(category.category_name, category.id, true, true);
            // Dump all categories data
            $('#category_id').append(option);
          });

          if (allRelatedSubCategories !== undefined) {
            allRelatedSubCategories.forEach(function (subCategory) {
              var option = new Option(subCategory.subcategory_name, subCategory.id, true, true);
              // Dump all sub categories data
              $('#subcategory_id').append(option);
            });
          }

          if (allRelatedSubSubCategories !== undefined) {
            allRelatedSubSubCategories.forEach(function (subSubCategory) {
              var option = new Option(
                subSubCategory.subsubcategory_name,
                subSubCategory.id,
                true,
                true
              );
              // Dump all sub sub categories data
              $('#subsubcategory_id').append(option);
            });
          }

          /////////////////////////////////////////////////////////////////////////////////

          if (category !== null && subCategory !== null && subSubCategory !== null) {
            category.forEach(function (category) {
              var option = new Option(category.category_name, category.id, true, true);
              // show selected category data in the first time
              $('div.get-categories select').append(option);
            });

            subCategory.forEach(function (subCategory) {
              var option = new Option(subCategory.subcategory_name, subCategory.id, true, true);
              // show selected sub category data in the first time
              $('div.get-sub-categories select').append(option);
            });

            subSubCategory.forEach(function (subSubCategory) {
              var option = new Option(
                subSubCategory.subsubcategory_name,
                subSubCategory.id,
                true,
                true
              );
              // show selected sub sub category data in the first time
              $('div.get-sub-sub-categories select').append(option);
            });
          } else {
            $('div.get-categories select').val('default').change();
            $('div.get-sub-categories select').val('default').change();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    catSubCatOnChange() {
      const token = localStorage.getItem('token-staff');

      // fill sub category input
      $('#category_id').on('change', function () {
        var category_id = $(this).val();

        if (category_id !== 'default') {
          $.ajax({
            url: `${BASE_URL}/api/staff/sub-sub-categories/get-sub-category/` + category_id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function (xhr) {
              xhr.setRequestHeader('Authorization', `Bearer ${token}`);
            },
            success: function (data) {
              $('#subcategory_id').empty();
              $('#subcategory_id').append(
                '<option value="default" selected="true">Select Sub Category</option>'
              );

              $('#subsubcategory_id').empty();
              $('#subsubcategory_id').append(
                '<option value="default" selected="true">Select Sub Sub Category</option>'
              );

              let subCategories = data.sub_categories;

              subCategories.forEach(function (category) {
                var option = new Option(category.subcategory_name, category.id, true, true);
                // Bulk assign form
                $('#subcategory_id').append(option);
                $('div.get-sub-categories select').val('default').change();
              });
            },
          });
        } else {
          $('#subcategory_id')
            .find('option')
            .remove()
            .end()
            .append('<option value="default">Select Sub Category</option>')
            .val('default');

          $('#subsubcategory_id')
            .find('option')
            .remove()
            .end()
            .append('<option value="default">Select Sub Sub Category</option>')
            .val('default');
        }
      });

      $('#subcategory_id').on('change', function () {
        var subcategory_id = $(this).val();

        $.ajax({
          url: `${BASE_URL}/api/staff/sub-sub-categories/get-sub-sub-categories/` + subcategory_id,
          type: 'GET',
          dataType: 'json',
          beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${token}`);
          },
          success: function (data) {
            let subSubCategories = data.sub_sub_categories;

            $('#subsubcategory_id').empty();
            $('#subsubcategory_id').append(
              '<option value="0" selected="true">Select Sub Sub Category</option>'
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

      // bootstrap-switch.min.js is already attached in main.js
      $('.status').bootstrapSwitch();
      $('.hot_deals').bootstrapSwitch();
      $('.special_offer').bootstrapSwitch();
      $('.special_deals').bootstrapSwitch();
      $('.featured').bootstrapSwitch();
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
    fileInput() {
      var self = this;

      var images = [];
      var imagesInfo = [];
      if (this.form.images !== null) {
        this.form.images.forEach((data) => {
          let dataObj = Object.values(data)[1];
          images.push(
            '<img class="kv-preview-data file-preview-image" src="' +
              BASE_URL +
              '/storage/app/public/products/' +
              dataObj.split(',') +
              '">'
          );
        });
        imagesInfo = this.removeDuplicatesFileInfo(this.form.images);
      } else {
        images = false;
        imagesInfo = false;
      }

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
          initialPreview: images,
          // to display the name and size of file
          initialPreviewConfig: imagesInfo,
          slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
          },
        })
        .on('filebatchselected', function () {
          $('#picts').fileinput('upload');
        })
        .on('filebatchuploadsuccess', function (event, data) {
          self.form.images.push(...data.response.initialPreviewConfig);
          self.form.totalInputtedPicts = self.form.images.length;

          let formData = new FormData();
          formData.append('images', self.form.images);
          formData.append('_method', 'PUT');

          self.form
            .put('api/staff/products/update-images/' + self.form.id, {
              data: formData,
            })
            .then((response) => {
              console.log(response.data.message);
            })
            .catch((err) => {
              console.log(err);
            })
            .finally(() => {
              console.log('Work');
            });
        })
        .on('filebeforedelete', function () {
          if (self.form.images.length > 1) {
            return new Promise(function (resolve) {
              $.confirm({
                title: 'Confirmation!',
                content: 'Are you sure you want to delete this file?',
                type: 'red',
                buttons: {
                  ok: {
                    btnClass: 'btn-primary text-white',
                    keys: ['enter'],
                    action: function () {
                      resolve();
                    },
                  },
                  cancel: function () {
                    $.alert('File deletion was aborted! ');
                  },
                },
              });
            });
          } else {
            return new Promise(function () {
              $.confirm({
                title: 'Information!',
                content: 'Product must have at least 1 image file!',
                type: 'red',
                buttons: {
                  ok: {
                    btnClass: 'btn-primary text-white',
                    keys: ['enter'],
                    action: function () {
                      $.alert('File deletion was aborted! ');
                    },
                  },
                  
                },
              });
            });
          }
        })
        .on('filedeleted', function (event, key) {
          if (self.form.images.length === 1) {
             self.form.images = null;
          } else {
            var singleRemoveFileInfo = self.form.images.filter(function (x) {
              return x.key !== key;
            });

            self.form.images = singleRemoveFileInfo;
            self.form.totalInputtedPicts = self.form.images.length;            
          }

            let formData = new FormData();
            formData.append('images', self.form.images);
            formData.append('_method', 'PUT');

            self.form
              .put('api/staff/products/update-images/' + self.form.id, {
                data: formData,
              })
              .then((response) => {
                console.log(response);
              })
              .catch((err) => {
                console.log(err);
              })
              .finally(() => {
                if (self.form.images === null) {
                  self.form.images = [];
                }
              });         
        });
    },
    fileInputVariants(id) {
      var self = this;

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
              product_width: 'auto',
              product_height: 'auto',
              'max-product_width': '100%',
              'max-product_height': '100%',
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
          initialPreview: varProdImgs[0].initial_preview,
          // to display the name and size of file
          initialPreviewConfig: varProdImgs[0].images,
          slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
          },
        })
        .on('filebatchselected', function () {
          // event, files
          $('.images' + id).fileinput('upload');
        })
        .on('filebatchuploadsuccess', function (event, data) {
          varProdImgs[0].images.push(...data.response.initialPreviewConfig);
          varProdImgs[0].total_images = varProdImgs[0].images.length;
          self.form.imagesUpdated = varProdImgs[0].images;

          let formData = new FormData();
          formData.append('imagesUpdated', self.form.imagesUpdated);
          formData.append('_method', 'PUT');

          self.form
            .put('api/staff/products/update-variant-product-images/' + id, {
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
        })
        .on('filebeforedelete', function () {
          if (varProdImgs[0].images.length > 1) {
            return new Promise(function (resolve) {
              $.confirm({
                title: 'Confirmation!',
                content: 'Are you sure you want to delete this file?',
                type: 'red',
                buttons: {
                  ok: {
                    btnClass: 'btn-primary text-white',
                    keys: ['enter'],
                    action: function () {
                      resolve();
                    },
                  },
                  cancel: function () {
                    $.alert('File deletion was aborted! ');
                  },
                },
              });
            });
          } else {
            return new Promise(function () {
              $.confirm({
                title: 'Information!',
                content: 'Each variant product must have at least 1 image file!',
                type: 'red',
                buttons: {
                  ok: {
                    btnClass: 'btn-primary text-white',
                    keys: ['enter'],
                    action: function () {
                      $.alert('File deletion was aborted! ');
                    },
                  },
                  
                },
              });
            });
          }
        })
        .on('filedeleted', function (event, key) {
          if (varProdImgs[0].images.length === 1) {
            varProdImgs[0].images = null;
            varProdImgs[0].total_images = 0;
            self.form.imagesUpdated = varProdImgs[0].images;
          } else {
            var singleRemoveFileInfo = varProdImgs[0].images.filter(function (x) {
              return x.key !== key;
            });
            varProdImgs[0].images = singleRemoveFileInfo;
            varProdImgs[0].total_images = varProdImgs[0].images.length;
            self.form.imagesUpdated = varProdImgs[0].images;
          }

          let formData = new FormData();
          formData.append('imagesUpdated', self.form.imagesUpdated);
          formData.append('_method', 'PUT');
          self.form
            .put('api/staff/products/update-variant-product-images/' + id, {
              data: formData,
            })
            .then((response) => {
              console.log(response);
            })
            .catch((err) => {
              console.log(err);
            })
            .finally(() => {
              if (varProdImgs[0].images === null) {
                varProdImgs[0].images = [];
              }
            });
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

          var filteredArray = dataFileInfo.filter((item) => !bulkRemoveFileInfo.includes(item));

          self.dataFiles = filteredArray;
        });

      $('.status_' + id).bootstrapSwitch('state', $('.status_' + id).prop('checked'));
    },
    tokenField(id) {
      // enter button is killed no current input data found. To activate again, open the bootstrap-tokenfield.js, and search "kill enter button", uncomment the rest of code, and delete e.preventDefault()
      var self = this;

      $('.variant_options_' + id).tokenfield({
        showAutocompleteOnFocus: true,
        disableEdit: false,
      });

      $('.variant_options_' + id)
        .on('tokenfield:edittoken', function (event) {
          event.preventDefault();
        })
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
          var varType = self.form.variants.filter(function (x) {
            return x.id == id;
          });

          // get new added variant options
          varType.forEach((data) => {
            let dataObj = Object.values(data);
            let varOpt = $('.variant_options_' + dataObj[0]).tokenfield('getTokens');
            let lastArr = [];
            var last = varOpt[varOpt.length - 1];
            lastArr.push(last);
            data.variant_options = lastArr;
          });

          // Generate variant products
          self.generateVariantProducts();

          // Add only new product variant to the list
          self.getNewAddedVarProds();

          // Get all the displayed variant products in the view that already stored in database.
          self.getVarProdsBeenStoredInDb();

          // execute self.fileInputVariants(data.id) after 100 milisecond
          self.form.variants_prod.forEach((data) => {
            setTimeout(function () {
              self.fileInputVariants(data.id);
              self.disableRightClickAndLongPress('variant_price_' + data.id);
              self.disableRightClickAndLongPress('variant_stock_' + data.id);
            }, 100);
          });
        })
        .on('tokenfield:removetoken', function (event) {
          console.log(event.attrs.value);
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
            data.variant_options = $('.variant_options_' + dataObj[0]).tokenfield('getTokens');
          });

          // get and updated deleted variant products images
          var getVarProdsImgsToBeDeleted = varProdsImgsToBeDeleted[0].filter(function (x) {
            return x[prop] == event.attrs.value;
          });
          self.varProdsImgsToBeDeleted.push(...getVarProdsImgsToBeDeleted);
          self.form.varProdsImgsToBeDeleted = self.varProdsImgsToBeDeleted;

          // variant products to be deleted from database
          self.form.varProdsToBeDeleted = self.varProdsImgsToBeDeleted;
          if (self.form.varProdsToBeDeleted.length > 0) {
            var deleteVarProdsFromDb = self.form.varProdsToBeDeleted.filter(function (x) {
              return Object.keys(x).includes('initial_preview'); // including initial_preview property
            });
            self.form.varProdsToBeDeleted = deleteVarProdsFromDb;
          }

          // delete related deleted data that stored in addedNewVarProds
          if (self.form.addedNewVarProds !== undefined) {
            // All new added variant products images must be deleted directly if user delete one of them through the variant options fields
            let deletedNewInputtedVarProds = self.form.addedNewVarProds.filter(function (x) {
              return x[prop] == event.attrs.value;
            });
            self.form.newVarProdsImagesToBeDeleted = deletedNewInputtedVarProds;
            self.deleteSomeNewAddedVarProdImages();

            // get the remaining new added variant products that still exist after deletion was happened.
            let remainingVarProds = self.form.addedNewVarProds.filter(function (x) {
              return x[prop] !== event.attrs.value;
            });
            self.form.addedNewVarProds = remainingVarProds;
          }

          // Get all the displayed variant products in the view that already stored in database.
          self.getVarProdsBeenStoredInDb();
        });
    },
    fillTokenField(id) {
      var dataInfo = this.form.variants.filter(function (x) {
        return x.id == id;
      });

      let variants = [];
      dataInfo.forEach((data) => {
        data.variant_options.forEach((data) => {
          variants.push(data.value);
        });
      });

      $('.variant_options_' + id).tokenfield({
        showAutocompleteOnFocus: true,
      });

      $('.variant_options_' + id).tokenfield('setTokens', variants);

      this.tokenField(id);
    },
    getDropdownVal() {
      this.form.brand_id = $('#brand_id').val();
      this.form.category_id = $('#category_id').val();
      this.form.subcategory_id = $('#subcategory_id').val();
      this.form.subsubcategory_id = $('#subsubcategory_id').val();
    },
    showData() {
      const token = localStorage.getItem('token-staff');
      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      let id = this.$route.params.id;

      this.axios
        .get('api/staff/products/edit/' + id)
        .then((response) => {
          this.form.reset(); // v form reset inputs
          this.form.clear(); // v form clear errors
          this.form.fill(response.data);
          this.form.images = JSON.parse(this.form.images);
          if (this.form.images === null) {
            this.form.images = [];
            this.form.totalInputtedPicts = 0;
          } else {
            this.form.totalInputtedPicts = this.form.images.length;
          }
          this.loadBrands();
          this.fillCatSubCatAndSubSubCat();
          this.catSubCatOnChange();
          this.fileInput();
          this.form.price = this.form.price.toLocaleString('id');
          this.form.min_order = this.form.min_order.toLocaleString('id');
          this.form.available_stock = this.form.available_stock.toLocaleString('id');
          this.disableRightClickAndLongPress('min_order');
          this.disableRightClickAndLongPress('price');
          this.disableRightClickAndLongPress('available_stock');
          this.disableRightClickAndLongPress('product_weight');
          this.disableRightClickAndLongPress('product_length');
          this.disableRightClickAndLongPress('product_width');
          this.disableRightClickAndLongPress('product_height');
          this.pageIsLoaded = true;

          let variants = [];
          this.form.variants.forEach((data) => {
            delete data.product_id;
            delete data.variant_name;
            delete data.created_at;
            delete data.updated_at;
            delete data.deleted_at;
            data.variant_options.forEach((data) => {
              delete data.id;
              delete data.product_id;
              delete data.product_variant_id;
              delete data.variant_value_name;
              delete data.created_at;
              delete data.updated_at;
              delete data.deleted_at;
              delete data.label;
            });
            variants.push(data);
          });
          this.form.variants = variants;

          this.form.variants_prod.forEach((data) => {
            delete data.product_id;
            delete data.unique_string_id;
            delete data.updated_at;
            delete data.created_at;
            delete data.deleted_at;
          });
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          let variantType = [];
          this.form.variants.forEach((data) => {
            variantType.push(data.variant_type);
            this.fillTokenField(data.id);
          });
          this.variantType = variantType;

          this.form.variants_prod.forEach((data) => {
            data.price = data.price.toLocaleString('id');
            data.available_stock = data.available_stock.toLocaleString('id');
            data.images = JSON.parse(data.images);
            var imgs = [];
            if (data.images !== null) {
              data.images.forEach((data) => {
                let dataObj = Object.values(data)[1];
                imgs.push(
                  '<img class="kv-preview-data file-preview-image" src="' +
                    BASE_URL +
                    '/storage/app/public/products/' +
                    dataObj.split(',') +
                    '">'
                );
              });
              data.total_images = imgs.length;
            } else {
              data.images = [];
              data.total_images = 0;
            }
            data.initial_preview = imgs;
            if (this.variantType.length > 1) {
              let prodVarStr = data.product_variant;
              var prodVar = prodVarStr.split('-');

              for (let i = 0; i < this.variantType.length; i++) {
                data[this.variantType[i]] = prodVar[i];
              }
            } else {
              data[this.variantType[0]] = data.product_variant;
            }

            this.fileInputVariants(data.id);
            this.disableRightClickAndLongPress('variant_price_' + data.id);
            this.disableRightClickAndLongPress('variant_stock_' + data.id);
          });

          this.form.variantIsDeleted = 'No';
          this.getSwitchValue();
        }); // .finally
    },
    showSuccessMsg(response) {
      var responseData = response.data;
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

      console.log(responseData.message);
    },
    showErrMsg(response) {
      swal.fire({
        icon: 'error',
        title: 'Oopss...',
        text: 'Make sure you have fill all the fields!',
        footer: '<a href>Why do I have this issue?</a>',
      });
      console.log(response);
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

      //let variant_type = this.variant_type;
      this.form.variants.forEach((data) => {
        let dataObjVal = Object.values(data);

        $('.variant_type_' + dataObjVal[0]).removeClass('is-invalid');
        var existingTokens = $('.variant_options_' + dataObjVal[0]).tokenfield('getTokens');
        let variant_type = $('.variant_type_' + dataObjVal[0]).val();

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
        this.$router.push({ name: 'products-index' });
        this.showSuccessMsg(res);
      }
    },
    update() {
      $('#loadingButton').html(
        `<div class="proc-regis"><i class='fa fa-circle-o-notch fa-spin'></i> Storing data</div>`
      );
      $('#loadingButton').attr('disabled', true);

      this.getDropdownVal();
      this.getSwitchValue();
      this.getSwitchValueVarProds();
      this.getRadioButtonVarProdsVal();
      this.getVarProdsBeenStoredInDb();

      this.form.isVariantExists = $('#variant_type').length;
      let variants = JSON.stringify(this.form.variants);

      let formData = new FormData();
      formData.append('totalInputtedPicts', this.form.totalInputtedPicts);
      formData.append('variantIsDeleted', this.form.variantIsDeleted);
      formData.append('isVariantExists', this.form.isVariantExists);
      formData.append('variants', variants);
      formData.append('variants_prod', this.form.variants_prod);
      formData.append('varProdsImgsToBeDeleted', this.form.varProdsImgsToBeDeleted);
      formData.append('varProdsToBeDeleted', this.form.varProdsToBeDeleted);
      formData.append('addedNewVarProds', this.form.addedNewVarProds);
      formData.append('varProdsBeenStoredInDb', this.form.varProdsBeenStoredInDb);

      console.log(this.form.addedNewVarProds);
      console.log(this.form.variantIsDeleted);

      this.form
        .put('api/staff/products/update/' + this.form.id, { data: formData })
        .then((response) => {
          if (this.form.isVariantExists > 0) {
            this.validateInputFields();
            this.validateVariants(response);
          } else {
            let images = this.form.images;

            if (images.length > 0) {
              var uploadedImages = images.length;
            } else {
              var inputImages = $('#picts').val();
            }

            if (uploadedImages == 0 || inputImages == '') {
              $('#picts').fileinput('upload');
              this.showErrMsg(response);
            } else {
              this.$router.push({ name: 'products-index' });
              this.showSuccessMsg(response);
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
  created() {
    this.showData();
  },
  mounted() {
    this.form.variants.splice(0, this.form.variants.length); // empty an array of dynamic variants field
    // prevent sweetalert error if user change the route when swal is still visible.
    if (swal.isVisible()) {
      document.querySelector('body').setAttribute('class', 'swal2-toast-shown swal2-shown');
    }
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
