<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MegaMenuController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductSliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AllOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('staff/login', [LoginController::class, 'staffLogin'])->name('staffLogin'); 

// Product store and delete images
Route::post('products/store-images', [ProductController::class, 'storeImages']);
Route::post('products/delete-images/{id}', [ProductController::class, 'deleteImages']);
Route::post('products/delete-selected-variant-product-images', [ProductController::class, 'deleteSelectedVarProdsImages']);
Route::post('products/delete-all-new-added-variant-product-images', [ProductController::class, 'deleteAllNewAddedVarProdImages']);
Route::post('products/delete-all-new-added-variant-product-images-in-create-page', [ProductController::class, 'deleteAllNewAddedVarProdImagesInCreatePage']);
Route::post('products/delete-some-new-added-variant-product-images', [ProductController::class, 'deleteSomeNewAddedVarProdImages']);

// To see the route url, use php artisan r:l
Route::group(['prefix' => 'staff', 'middleware' => ['auth:staff-api', 'scopes:staff']], function () {
    // authenticated staff routes here 
    Route::get('dashboard', [LoginController::class, 'staffDashboard']);
    Route::get('staff/home', [LoginController::class, 'staffDashboard']);
    Route::post('logout', [LoginController::class, 'logoutStaff']);  

    // CRUD staff.  
    Route::get('staff-management', [StaffController::class, 'index']);
    Route::post('staff-management', [StaffController::class, 'store']);
    Route::delete('staff-management/{id}', [StaffController::class, 'destroy']);
    Route::put('staff-management/{id}', [StaffController::class, 'update']);
    Route::get('staff-management/search/{keyword}', [StaffController::class, 'searchStaff']);
    Route::get('staff-management/delete-multiple/ids={ids}', [StaffController::class, 'deleteMultiple']);
    Route::get('staff-management/download-pdf', [StaffController::class, 'downloadPDF']);
    Route::get('staff-management/download-excel', [StaffController::class, 'downloadExcel']);
    Route::get('staff-management/download-word', [StaffController::class, 'downloadWord']);

    // CRUD brands
    Route::get('brand-management', [BrandController::class, 'index']);
    Route::post('brand-management', [BrandController::class, 'store']);
    Route::get('brand-management/search/{keyword}', [BrandController::class, 'searchBrand']);
    Route::put('brand-management/{id}', [BrandController::class, 'update']);
    Route::delete('brand-management/soft-delete/{id}', [BrandController::class, 'softDelete']);
    Route::get('brand-management/soft-delete-multiple/ids={ids}', [BrandController::class, 'softDeleteMultiple']);
    Route::delete('brand-management/force-delete/{id}', [BrandController::class, 'forceDelete']);
    Route::get('brand-management/force-delete-multiple/ids={ids}', [BrandController::class, 'forceDeleteMultiple']);
    Route::get('brand-management/trash', [BrandController::class, 'trash']);
    Route::get('brand-management/trash/search/{keyword}', [BrandController::class, 'searchTrashBrand']);
    Route::get('brand-management/restore/{id}', [BrandController::class, 'restore']);
    Route::get('brand-management/restore-multiple/ids={ids}', [BrandController::class, 'restoreMultiple']);

    // CRUD Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/update/{id}', [CategoryController::class, 'update']);
    Route::get('categories/load-sub-cat-wheredoesnthave-cat-orwherehas-cat-where-cat-id/{id}', [CategoryController::class, 'loadSubCategories']);
    Route::post('categories/assign', [CategoryController::class, 'assignSubCat']);
    Route::get('categories/get-sub-categories/{id}', [CategoryController::class, 'getSubCategories']);
    Route::get('categories/select-sub-sub-cat-wherehas-sub-cat-where-sub-cat-id/{id}', [CategoryController::class, 'getCatAndSubSubCat']);
    Route::get('categories/load-sub-sub-cat-wheredoesnthave-subcat-orwherehas-subcat-where-subcat-id/{id}', [CategoryController::class, 'loadSubSubCat']);
    Route::post('categories/assign-sub-sub-cat', [CategoryController::class, 'assignSubSubCat']);
    Route::get('categories/search/{keyword}', [CategoryController::class, 'searchCatAndSubCat']);
    Route::delete('categories/soft-delete/{id}', [CategoryController::class, 'softDelete']);
    Route::get('categories/soft-delete-multiple/ids={ids}', [CategoryController::class, 'softDeleteMultiple']);
    Route::get('categories/trash', [CategoryController::class, 'trash']);
    Route::get('categories/trash/search/{keyword}', [CategoryController::class, 'searchTrashCatAndSubCat']);
    Route::get('categories/restore/{id}', [CategoryController::class, 'restore']);
    Route::get('categories/restore-multiple/ids={ids}', [CategoryController::class, 'restoreMultiple']);
    Route::delete('categories/force-delete/{id}', [CategoryController::class, 'forceDelete']);
    Route::get('categories/force-delete-multiple/ids={ids}', [CategoryController::class, 'forceDeleteMultiple']);

    // CRUD Sub Categories
    Route::get('sub-categories', [SubCategoryController::class, 'index']);
    Route::post('sub-categories', [SubCategoryController::class, 'store']);
    Route::get('sub-categories/search/{keyword}', [SubCategoryController::class, 'searchSubCategory']);
    Route::put('sub-categories/update/{id}', [SubCategoryController::class, 'update']);
    Route::delete('sub-categories/soft-delete/{id}', [SubCategoryController::class, 'softDelete']);
    Route::get('sub-categories/soft-delete-multiple/ids={ids}', [SubCategoryController::class, 'softDeleteMultiple']);
    Route::delete('sub-categories/force-delete/{id}', [SubCategoryController::class, 'forceDelete']);
    Route::get('sub-categories/force-delete-multiple/ids={ids}', [SubCategoryController::class, 'forceDeleteMultiple']);
    Route::get('sub-categories/trash', [SubCategoryController::class, 'trash']);
    Route::get('sub-categories/trash/search/{keyword}', [SubCategoryController::class, 'searchTrashSubCategory']);
    Route::get('sub-categories/restore/{id}', [SubCategoryController::class, 'restore']);
    Route::get('sub-categories/restore-multiple/ids={ids}', [SubCategoryController::class, 'restoreMultiple']);

    // CRUD Sub Sub Categories
    Route::get('sub-sub-categories', [SubSubCategoryController::class, 'index']);
    Route::post('sub-sub-categories', [SubSubCategoryController::class, 'store']);
    Route::get('sub-sub-categories/search/{keyword}', [SubSubCategoryController::class, 'searchSubSubCatByKey']);
    Route::put('sub-sub-categories/update/{id}', [SubSubCategoryController::class, 'update']);
    Route::get('sub-sub-categories/search-sub-sub-categories/{id}', [SubSubCategoryController::class, 'searchSubSubCategories']);
    Route::get('get-categories', [SubSubCategoryController::class, 'getCategories']);
    Route::get('sub-sub-categories/get-sub-category/{id}', [SubSubCategoryController::class, 'getSubCategories']);
    Route::get('sub-sub-categories/get-sub-sub-categories/{id}', [SubSubCategoryController::class, 'getSubSubCategories']);
    Route::get('sub-sub-categories/get-cat-sub-cat/{id}', [SubSubCategoryController::class, 'getCatSubCat']);
    Route::put('sub-sub-categories/bulk-assign', [SubSubCategoryController::class, 'bulkAssign']);
    Route::put('sub-sub-categories/single-assign/{id}', [SubSubCategoryController::class, 'singleAssign']);
    Route::get('sub-sub-categories/trash', [SubSubCategoryController::class, 'trash']);
    Route::delete('sub-sub-categories/soft-delete/{id}', [SubSubCategoryController::class, 'softDelete']);
    Route::get('sub-sub-categories/soft-delete-multiple/ids={ids}', [SubSubCategoryController::class, 'softDeleteMultiple']);
    Route::get('sub-sub-categories/restore/{id}', [SubSubCategoryController::class, 'restore']);
    Route::get('sub-sub-categories/restore-multiple/ids={ids}', [SubSubCategoryController::class, 'restoreMultiple']);
    Route::delete('sub-sub-categories/force-delete/{id}', [SubSubCategoryController::class, 'forceDelete']);
    Route::get('sub-sub-categories/force-delete-multiple/ids={ids}', [SubSubCategoryController::class, 'forceDeleteMultiple']);
    Route::get('sub-sub-categories/trash/search/{keyword}', [SubSubCategoryController::class, 'searchTrashSubSubCat']);

    // CRUD products
    Route::get('get-brands', [ProductController::class, 'getBrands']);
    Route::post('products/store', [ProductController::class, 'store']);
    Route::get('products/index', [ProductController::class, 'index']);
    Route::get('products/search/{keyword}', [ProductController::class, 'searchProduct']);
    Route::delete('products/soft-delete/{id}', [ProductController::class, 'softDelete']);
    Route::get('products/soft-delete-multiple/ids={ids}', [ProductController::class, 'softDeleteMultiple']);
    Route::get('products/trash', [ProductController::class, 'trash']);
    Route::get('products/trash/search/{keyword}', [ProductController::class, 'searchInTrash']);
    Route::get('products/restore/{id}', [ProductController::class, 'restore']);
    Route::get('products/restore-multiple/ids={ids}', [ProductController::class, 'restoreMultiple']);
    Route::delete('products/force-delete/{id}', [ProductController::class, 'forceDelete']);
    Route::get('products/force-delete-multiple/ids={ids}', [ProductController::class, 'forceDeleteMultiple']);
    Route::put('products/update-status/{id}', [ProductController::class, 'updateStatus']);
    Route::get('products/edit/{id}', [ProductController::class, 'edit']); // used in edit.vue
    Route::put('products/update-images/{id}', [ProductController::class, 'updateImages']);
    Route::put('products/update-variant-product-images/{id}', [ProductController::class, 'updateVarProdImages']);
    Route::put('products/update/{id}', [ProductController::class, 'update']);

    // CRUD sliders
    Route::get('sliders/index', [SliderController::class, 'index']);
    Route::put('sliders/update-status/{id}', [SliderController::class, 'updateStatus']);
    Route::post('sliders/store', [SliderController::class, 'store']);
    Route::get('sliders/search/{keyword}', [SliderController::class, 'searchSlider']);
    Route::put('sliders/update/{id}', [SliderController::class, 'update']);
    Route::delete('sliders/soft-delete/{id}', [SliderController::class, 'softDelete']);
    Route::get('sliders/soft-delete-multiple/ids={ids}', [SliderController::class, 'softDeleteMultiple']);
    Route::delete('sliders/force-delete/{id}', [SliderController::class, 'forceDelete']);
    Route::get('sliders/force-delete-multiple/ids={ids}', [SliderController::class, 'forceDeleteMultiple']);
    Route::get('sliders/trash', [SliderController::class, 'trash']);
    Route::get('sliders/trash/search/{keyword}', [SliderController::class, 'searchTrashSlider']);
    Route::get('sliders/restore/{id}', [SliderController::class, 'restore']);
    Route::get('sliders/restore-multiple/ids={ids}', [SliderController::class, 'restoreMultiple']);

    // Manage Roles
    Route::get('roles/index', [RoleController::class, 'index']); 
    Route::get('roles/create', [RoleController::class, 'create']); 
    Route::post('roles/store', [RoleController::class, 'store']);
    Route::get('roles/edit/{id}', [RoleController::class, 'edit']);
    Route::put('roles/update/{id}', [RoleController::class, 'update']);
    Route::get('roles/permissions/{permissionName}', [RoleController::class, 'check']);

    // Manage orders
    Route::get('orders/index', [AllOrderController::class, 'index']); 
    Route::get('orders/edit/{id}', [AllOrderController::class, 'edit']);
    Route::put('orders/update/{id}', [AllOrderController::class, 'update']);
});

Route::middleware(['auth:staff-api', 'scopes:staff'])->get('/staff', function (Request $request) {
    return $request->user();
});
