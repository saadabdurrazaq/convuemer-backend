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
use Symfony\Component\HttpFoundation\Response;
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
            $fileName = hexdec(uniqid()) . '.' . $getFileName;
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
            $fileName = hexdec(uniqid()) . '.' . $getFileName;
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

    public function storeProduct()
    {
        $product_name =  $this->request->get('product_name');
        $brand =  $this->request->get('brand');
        $category_id =  $this->request->get('category_id');
        $subcategory_id =  $this->request->get('subcategory_id');
        $subsubcategory_id =  $this->request->get('subsubcategory_id');
        $product_name =  $this->request->get('product_name');
        $single_stock =  $this->request->get('single_stock');
        $product_price =  $this->request->get('product_price');
        $short_desc =  $this->request->get('short_desc');
        $long_desc =  $this->request->get('long_desc');
        $product_condition =  $this->request->get('product_condition');
        $minimum_order =  $this->request->get('minimum_order');
        $sku =  $this->request->get('sku');
        $weight =  $this->request->get('weight');
        $length =  $this->request->get('length');
        $width =  $this->request->get('width');
        $height =  $this->request->get('height');
        $hot_deals =  $this->request->get('hot_deals');
        $featured =  $this->request->get('featured');
        $special_offer =  $this->request->get('special_offer');
        $special_deals =  $this->request->get('special_deals');
        $status =  $this->request->get('status');
        $metric_mass = $this->request->get('metric_mass');
        $dataPicts = $this->request->get('dataPicts');

        $this->newProductId = Product::insertGetId([
            'product_name' => $product_name,
            'brand_id' => $brand,
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
            'subsubcategory_id' => $subsubcategory_id,
            'product_name' => $product_name,
            'product_stock' => $single_stock,
            'selling_price' => $product_price,
            'short_desc' => $short_desc,
            'long_desc' => $long_desc,
            'product_cond' => $product_condition,
            'min_order' => $minimum_order,
            'sku' => $sku,
            'product_weight' => $weight,
            'metric_mass' => $metric_mass,
            'product_length' => $length,
            'product_width' => $width,
            'product_height' => $height,
            'hot_deals' => $hot_deals,
            'featured' => $featured,
            'special_offer' => $special_offer,
            'special_deals' => $special_deals,
            'status' => $status,
            'images' => $dataPicts,
        ]);
    }

    public function store(Request $request)
    {
        $isVariantExists =  $this->request->get('isVariantExists');
        $variantsStr = $this->request->get('variants');
        $variants = json_decode($variantsStr, TRUE);
        $variantsProdStr = $this->request->get('variantsProd'); // string
        $variantsProd = json_decode($variantsProdStr, TRUE); // array
        $totalInputtedPicts = $this->request->get('totalInputtedPicts');

        $this->validate($request, [
            'product_name' => 'required',
            'brand' => 'required|numeric',
            'category_id' => 'required|numeric',
            'subcategory_id' => 'required|numeric',
            'subsubcategory_id' => 'required|numeric',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'minimum_order' => 'required',
            'product_price' => 'required',
            'single_stock' => 'required',
            'sku' => 'required',
            'weight' => 'required',
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
        ], [
            'category_id.numeric' => 'Please select any option!',
            'subcategory_id.numeric' => 'Please select any option!',
            'brand.numeric' => 'Please select any option!',
            'subsubcategory_id.numeric' => 'Please select any option!',
        ]);

        if ($isVariantExists > 0) {
            // valildate variant type 
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
                $stock = $var['stock'];
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
                ]);

                foreach ($variant_options as $varOpt) {
                    $varVal = $varOpt['value'];

                    $newVariantOptionId = VariantOption::insertGetId([
                        'product_variant_id' => $newVariantTypeId,
                        'variant_value_name' => $varVal,
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
                    'sku' => $sku,
                    'available_stock' => $stock,
                    'combination_string' => $productVariant,
                    'unique_string_id' => Str::lower($string),
                    'price' => str_replace(".", "", $price),
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
}
