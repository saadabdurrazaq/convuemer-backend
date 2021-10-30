<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VariantType;
use App\Models\VariantOption;
use App\Models\ProductCombination;
use App\Models\Brand;
use App\Models\ImageGallery;
use App\Models\ImageGalleryProductCombination;
use Illuminate\Support\Str;
use DB;
//use Symfony\Component\HttpFoundation\Response;
use Response;
use Image;

class ProductController extends Controller
{
    public $request;
    protected $newProductId;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getBrands()
    {
        $brands = Brand::orderBy('id', 'desc')->get();

        return response()->json([
            'brands' => $brands,
        ], 200);
    }

    public function storeImages($id)
    {
        $preview = $config = $errors = [];
        $input = 'images';

        if (empty($_FILES[$input])) {
            return [];
        }

        $total = count($_FILES[$input]['name']);
        $path = 'storage/app/public/products/';

        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $getFileName = $_FILES[$input]['name'][$i]; // the file name
            $array = explode('.', $getFileName);
            $extension = end($array);
            $fileName = hexdec(uniqid()) . '.' . $extension;
            $fileSize = $_FILES[$input]['size'][$i]; // the file size

            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                $newFilePath = $path . $fileName;
                $newFileUrl = 'http://localhost/my-project/laravue/storage/app/public/products/' . $fileName;

                //Upload the file into the new path
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = '<img class="kv-preview-data file-preview-image" src="' . $newFileUrl . '">'; //$newFileUrl;
                    $config[] = [
                        'id' => $id,
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => 'http://localhost/my-project/laravue/api/products/delete-images/' . $fileName, // server api to delete the file based on key
                    ];
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }

        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];

        if (!empty($errors)) {
            $error = [];
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }

        return $out;
    }

    public function deleteImages($fileName)
    {
        $storedImage = storage_path('app\\public\\products\\' . $fileName);

        if (file_exists($storedImage)) {
            unlink($storedImage);
        }

        return response()->json([
            'success' => true,
            'message' => 'File sucessfully deleted!',
        ]);
    }

    public function storePictsSingleProd()
    {
        $preview = $config = $errors = [];
        $input = 'picts';

        if (empty($_FILES[$input])) {
            return [];
        }

        $total = count($_FILES[$input]['name']);
        $path = 'storage/app/public/products/';

        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $getFileName = $_FILES[$input]['name'][$i]; // the file name
            $array = explode('.', $getFileName);
            $extension = end($array);
            $fileName = hexdec(uniqid()) . '.' . $extension;
            $fileSize = $_FILES[$input]['size'][$i]; // the file size

            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                $newFilePath = $path . $fileName;
                $newFileUrl = 'http://localhost/my-project/laravue/storage/app/public/products/' . $fileName;

                //Upload the file into the new path
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = '<img class="kv-preview-data file-preview-image" src="' . $newFileUrl . '">'; //$newFileUrl;
                    $config[] = [
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => 'http://localhost/my-project/laravue/api/products/delete-picts-single-product/' . $fileName, // server api to delete the file based on key
                    ];
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }

        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];

        if (!empty($errors)) {
            $error = [];
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }

        return $out;
    }

    public function deletePictsSingleProd($fileName)
    {
        $storedImage = storage_path('app\\public\\products\\' . $fileName);

        if (file_exists($storedImage)) {
            unlink($storedImage);
        }

        return response()->json([
            'success' => true,
            'message' => 'File sucessfully deleted!',
        ]);
    }

    public function validateFields()
    {
        $this->validate($this->request, [
            'product_name' => 'required',
            'brand_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'subcategory_id' => 'required|numeric',
            'subsubcategory_id' => 'required|numeric',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'min_order' => 'required',
            'selling_price' => 'required',
            'product_stock' => 'required',
            'sku' => 'required',
            'product_weight' => 'required',
            'product_length' => 'required',
            'product_width' => 'required',
            'product_height' => 'required',
        ], [
            'category_id.numeric' => 'Please select any option!',
            'subcategory_id.numeric' => 'Please select any option!',
            'brand_id.numeric' => 'Please select any option!',
            'subsubcategory_id.numeric' => 'Please select any option!',
        ]);
    }

    public function validateVariantsFields()
    {
        $variants = $this->request->get('variants');
        $variantsProd = $this->request->get('variants_prod');

        // validate variant type 
        foreach ($variants as $variant) {
            $variant_type = $variant['variant_type'];
            $variant_options = $variant['variant_options'];

            // if user, input varian opt ended with comma, but after then he delete it
            if (is_array($variant_options)) {
                $countVarOpt = count(array_filter($variant_options));
                if ($variant_type == null || $countVarOpt == 0) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Please fill the variant type and variant options field!', // 
                    ]);
                }
            } else {
                // if user doesn't input the variant options at all, all he input variant opt but not end with comma
                if ($variant_type == null || $variant_options == null) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Please fill the variant type and variant options field!', // 
                    ]);
                }
            }
        }

        // validate product variant
        foreach ($variantsProd as $var) {
            $price = $var['price'];
            $stock = $var['available_stock'];
            $sku = $var['sku'];
            $total_images = $var['total_images'];

            if ($price == null || $stock == null || $sku == null || $total_images == 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Please fill the variant product input!',
                ]);
            }
        }
    }

    public function inputData()
    {
        $data = array();

        $data['product_name'] =  $this->request->get('product_name');
        $data['brand_id'] =  $this->request->get('brand_id');
        $data['category_id'] =  $this->request->get('category_id');
        $data['subcategory_id'] =  $this->request->get('subcategory_id');
        $data['subsubcategory_id'] =  $this->request->get('subsubcategory_id');
        $data['product_name'] =  $this->request->get('product_name');
        $data['product_stock'] =  $this->request->get('product_stock');
        $data['selling_price'] =  $this->request->get('selling_price');
        $data['short_desc'] =  $this->request->get('short_desc');
        $data['long_desc'] =  $this->request->get('long_desc');
        $data['product_cond'] =  $this->request->get('product_cond');
        $data['min_order'] =  $this->request->get('min_order');
        $data['sku'] =  $this->request->get('sku');
        $data['product_weight'] =  $this->request->get('product_weight');
        $data['product_length'] =  $this->request->get('product_length');
        $data['product_width'] =  $this->request->get('product_width');
        $data['product_height'] =  $this->request->get('product_height');
        $data['hot_deals'] =  $this->request->get('hot_deals');
        $data['featured'] =  $this->request->get('featured');
        $data['special_offer'] =  $this->request->get('special_offer');
        $data['special_deals'] =  $this->request->get('special_deals');
        $data['status'] =  $this->request->get('status');
        $data['metric_mass'] = $this->request->get('metric_mass');
        $data['images'] = $this->request->get('images');

        return $data;
    }

    public function storeProduct()
    {
        $data_value = $this->inputData();

        $this->newProductId = Product::insertGetId([
            'product_name' => $data_value['product_name'],
            'brand_id' => $data_value['brand_id'],
            'category_id' => $data_value['category_id'],
            'subcategory_id' => $data_value['subcategory_id'],
            'subsubcategory_id' => $data_value['subsubcategory_id'],
            'product_name' => $data_value['product_name'],
            'product_stock' => str_replace(".", "", $data_value['product_stock']),
            'selling_price' => str_replace(".", "", $data_value['selling_price']),
            'short_desc' => $data_value['short_desc'],
            'long_desc' => $data_value['long_desc'],
            'product_cond' => $data_value['product_cond'],
            'min_order' => str_replace(".", "", $data_value['min_order']),
            'sku' => $data_value['sku'],
            'product_weight' => str_replace(".", "", $data_value['product_weight']),
            'metric_mass' => $data_value['metric_mass'],
            'product_length' => str_replace(".", "",  $data_value['product_length']),
            'product_width' => str_replace(".", "",  $data_value['product_width']),
            'product_height' => str_replace(".", "",  $data_value['product_height']),
            'hot_deals' => $data_value['hot_deals'],
            'featured' => $data_value['featured'],
            'special_offer' => $data_value['special_offer'],
            'special_deals' => $data_value['special_deals'],
            'status' => $data_value['status'],
            'images' => json_encode($data_value['images']),
        ]);
    }

    public function updateProduct($id)
    {
        $product = Product::findOrFail($id);
        $data_value = $this->inputData();

        $this->newProductId = $product->update([
            'product_name' => $data_value['product_name'],
            'brand_id' =>  $data_value['brand_id'],
            'category_id' => $data_value['category_id'],
            'subcategory_id' => $data_value['subcategory_id'],
            'subsubcategory_id' => $data_value['subsubcategory_id'],
            'product_stock' => str_replace(".", "", $data_value['product_stock']),
            'selling_price' => str_replace(".", "", $data_value['selling_price']),
            'short_desc' => $data_value['short_desc'],
            'long_desc' => $data_value['long_desc'],
            'product_cond' => $data_value['product_cond'],
            'min_order' => str_replace(".", "", $data_value['min_order']),
            'sku' => $data_value['sku'],
            'product_weight' => str_replace(".", "", $data_value['product_weight']),
            'metric_mass' => $data_value['metric_mass'],
            'product_length' => str_replace(".", "",  $data_value['product_length']),
            'product_width' => str_replace(".", "",  $data_value['product_width']),
            'product_height' => str_replace(".", "",  $data_value['product_height']),
            'hot_deals' => $data_value['hot_deals'],
            'featured' => $data_value['featured'],
            'special_offer' => $data_value['special_offer'],
            'special_deals' => $data_value['special_deals'],
            'status' => $data_value['status'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validateFields();

        $isVariantExists =  $this->request->get('isVariantExists');
        $totalInputtedPicts = $this->request->get('totalInputtedPicts');

        if ($isVariantExists > 0) {
            $variants = $this->request->get('variants');
            $variantsProd = $this->request->get('variants_prod');

            // validate variant type 
            foreach ($variants as $variant) {
                $variant_type = $variant['variant_type'];
                $variant_options = $variant['variant_options'];

                // if user, input varian opt ended with comma, but after then he delete it
                if (is_array($variant_options)) {
                    $countVarOpt = count(array_filter($variant_options));
                    if ($variant_type == null || $countVarOpt == 0) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Please fill the variant type and variant options field!', // 
                        ]);
                    }
                } else {
                    // if user doesn't input the variant options at all, all he input variant opt but not end with comma
                    if ($variant_type == null || $variant_options == null) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Please fill the variant type and variant options field!', // 
                        ]);
                    }
                }
            }

            // validate product variant
            foreach ($variantsProd as $var) {
                $price = $var['price'];
                $stock = $var['available_stock'];
                $sku = $var['sku'];
                $total_images = $var['total_images'];

                if ($price == null || $stock == null || $sku == null || $total_images == 0) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Please fill the variant product input!',
                    ]);
                }
            }

            ///////////////////////////////////////////////////////////////////////////////////////

            // if validation success, run the proccess below. 

            if ($totalInputtedPicts > 0) {
                $this->storeProduct();
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Please upload a product picts!',
                ]);
            }

            foreach ($variants as $variant) {
                $variant_type = $variant['variant_type'];
                $variant_options = $variant['variant_options'];

                $newVariantTypeId = VariantType::insertGetId([
                    'product_id' => $this->newProductId,
                    'variant_name' => $variant_type,
                    'variant_type' => $variant_type,
                ]);

                foreach ($variant_options as $varOpt) {
                    $varVal = $varOpt['value'];

                    $newVariantOptionId = VariantOption::insertGetId([
                        'product_id' => $this->newProductId,
                        'product_variant_id' => $newVariantTypeId,
                        'variant_value_name' => $varVal,
                        'value' => $varVal,
                    ]);
                }
            }

            foreach ($variantsProd as $key) {
                $productVariant = $key['product_variant'];
                $price = $key['price'];
                $sku = $key['sku'];
                $images = $key['images'];
                $condition = $key['condition'];
                $status = $key['status'];
                $stock = $key['stock'];

                $stringParts = str_split($productVariant);
                sort($stringParts);
                $string = implode($stringParts);

                $newProductCombinationId = ProductCombination::insertGetId([
                    'product_id' => $this->newProductId,
                    'product_variant' => $productVariant,
                    'unique_string_id' => Str::lower($string),
                    'price' => str_replace(".", "", $price),
                    'sku' => $sku,
                    'available_stock' => str_replace(".", "", $stock),
                    'condition' => $condition,
                    'status' => $status,
                    'images' => json_encode($images),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added!',
            ]);
        } else {
            if ($totalInputtedPicts > 0) {
                $this->storeProduct();

                return response()->json([
                    'success' => true,
                    'message' => 'Single Product successfully added!',
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Please upload a product picts!',
                ]);
            }
        }
    }

    public function index(Request $request)
    {
        $items = $request->items ?? 5;
        $trashedProducts = Product::onlyTrashed()->count();
        $products = Product::with('variantsProd')->orderBy('id', 'desc')->paginate($items);

        return response()->json([
            'products' => $products,
            'total_trashed_products' => $trashedProducts,
            'items' => $items,
        ], 200);
    }

    public function updateStatus($id)
    {
        $status =  $this->request->get('status');

        $prod = Product::where('id', $id);
        $prod->update(['status' => $status]);

        return response()->json([
            'success' => true,
            'message' => 'Product status succesfully updated!',
        ]);
    }

    public function show($id)
    {
        $product =  Product::with('variants.variantOptions')->with('variantsProd')->where('id', $id)->first();
        return response()->json($product);
    }

    public function updateImages($id)
    {
        $images =  $this->request->get('images');

        $prod = Product::where('id', $id);
        $prod->update(['images' => json_encode($images)]);

        return response()->json([
            'success' => true,
            'message' => 'Product images succesfully updated!',
        ]);
    }

    public function updateVarProdImages($id)
    {
        $imagesUpdated =  $this->request->get('imagesUpdated');

        $prod = ProductCombination::where('id', $id);
        $prod->update(['images' => json_encode($imagesUpdated)]);

        return response()->json([
            'success' => true,
            'message' => 'Product images succesfully updated!',
        ]);
    }

    public function update($id)
    {
        $this->validateFields();

        $totalInputtedPicts = $this->request->get('totalInputtedPicts');
        $isVariantExists =  $this->request->get('isVariantExists');

        if ($isVariantExists > 0) {
            $variants = $this->request->get('variants');
            $variantsProd = $this->request->get('variants_prod');
            $deletedVarProdsImages = $this->request->get('deletedVarProdsImages');
            $variantIsDeleted = $this->request->get('variantIsDeleted');

            // validate variant type 
            foreach ($variants as $variant) {
                $variant_type = $variant['variant_type'];
                $variant_options = $variant['variant_options'];

                // if user, input varian opt ended with comma, but after then he delete it
                if (is_array($variant_options)) {
                    $countVarOpt = count(array_filter($variant_options));
                    if ($variant_type == null || $countVarOpt == 0) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Please fill the variant type and variant options field!', // 
                        ]);
                    }
                } else {
                    // if user doesn't input the variant options at all, all he input variant opt but not end with comma
                    if ($variant_type == null || $variant_options == null) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Please fill the variant type and variant options field!', // 
                        ]);
                    }
                }
            }

            // validate product variant
            foreach ($variantsProd as $var) {
                $price = $var['price'];
                $stock = $var['available_stock'];
                $sku = $var['sku'];
                $total_images = $var['total_images'];

                if ($price == null || $stock == null || $sku == null || $total_images == 0) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Please fill the variant product input!',
                    ]);
                }
            }

            ///////////////////////////////////////////////////////////////////////////////////////

            if ($totalInputtedPicts > 0) {
                $this->updateProduct($id);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Please upload a product picts!',
                ]);
            }

            if ($deletedVarProdsImages !== null) {
                if (sizeof($deletedVarProdsImages) > 0) {
                    $images = array();
                    foreach ($deletedVarProdsImages as $deletedVarProdsImage) {
                        $images[] = $deletedVarProdsImage['images'];
                    }

                    $imagesName = array();
                    foreach ($images as $image) {
                        if ($image) {
                            foreach ($image as $fileName) {
                                $imagesName[] = $fileName['caption'];
                            }
                        }
                    }

                    foreach ($imagesName as $imageName) {
                        $this->deleteImages($imageName);
                    }
                }
            }

            if ($variantIsDeleted == 'Yes') {
                return response()->json([
                    'success' => true,
                    'message' => 'Variant is deleted!',
                ]);
            }

            $varProds = ProductCombination::where('product_id', $id)->get('images');

            $varProdImages = array();
            foreach ($varProds as $varProd) {
                $varProdImages[] = json_decode($varProd['images']);
            }

            /*$varProdImagesName = array();
            foreach ($varProdImages as $varProdImage) {
                if ($varProdImage) {
                    foreach ($varProdImage as $varProdFileName) {
                        $varProdImagesName[] = $varProdFileName['caption'];
                    }
                }
            }*/

            return response()->json([
                'success' => true,
                'message' => $varProdImages //'Product successfully updated!',
            ]);
        } else {
            if ($totalInputtedPicts > 0) {
                $this->updateProduct($id);

                return response()->json([
                    'success' => true,
                    'message' => 'Product successfully updated!',
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Please upload a product picts!',
                ]);
            }
        }
    }
}
