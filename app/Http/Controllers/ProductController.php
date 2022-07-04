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
use App\Models\SubCategory;
use App\Models\Order;
use DB;
use Image;
use Mockery\Undefined;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public $request;
    public $newProductId;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('permission:View Products', ['only' => ['index']]);
        $this->middleware('permission:Create Product', ['only' => ['store']]);
        $this->middleware('permission:Update Product', ['only' => ['update']]);
        $this->middleware('permission:Delete Product', ['only' => ['softDelete', 'softDeleteMultiple', 'forceDelete', 'forceDeleteMultiple', 'forceDeleteProduct', 'deleteAllVarProds']]);
    }

    public function show($id, $slug)
    {
        $product =  Product::with('variants.variantOptions')->with('variantsProd')->where('id', $id)->where('product_slug', $slug)->first();

        // fix invalid unique_string that contains -
        $invalidUnSId = DB::table('products_combinations')->select('id')->where('unique_string_id', 'like', '%-%')->get();
        $invalidUnS = DB::table('products_combinations')->select('unique_string_id')->where('unique_string_id', 'like', '%-%')->pluck('unique_string_id')->toArray();
        $totalInvalidUnSId = DB::table('products_combinations')->select('id')->where('unique_string_id', 'like', '%-%')->count();

        $validStrings = array();
        for ($i = 0; $i < $totalInvalidUnSId; $i++) {
            array_push($validStrings, str_replace('-', '', $invalidUnS[$i]));
        }

        if ($totalInvalidUnSId > 0) {
            foreach ($invalidUnSId as $index => $invUnSId) {
                $data = json_decode(json_encode($invUnSId), true);
                ProductCombination::findOrFail($data['id'])->update([
                    'unique_string_id' => $validStrings[$index],
                ]);
            }
        }

        return response()->json($product);
    }

    public function getBrands()
    {
        $brands = Brand::orderBy('id', 'desc')->get();

        return response()->json([
            'brands' => $brands,
        ], 200);
    }

    // Store images file in a certain folder. While updateImages() used for update all atribute images texts for single product in database. And updateVarProdImages() used for update all atribute images texts for variant product in database
    public function storeImages()
    {
        $preview = $config = $errors = [];
        $input = 'images'; // name of input

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
                $newFileUrl = 'http://localhost/my-project/laravue-backend/storage/app/public/products/' . $fileName; // the url path will be stored in database, and the stored data will be used to preview the image

                //Upload the file into the new path  
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = '<img class="kv-preview-data file-preview-image" src="' . $newFileUrl . '">'; //$newFileUrl;
                    $config[] = [
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => 'http://localhost/my-project/laravue-backend/api/products/delete-images/' . $fileName, // the url path will be stored in database, and the stored data will be used to delete the image
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
            'price' => 'required',
            'available_stock' => 'required',
            'sku' => 'required',
            'product_weight' => 'required',
            'metric_mass' => 'required',
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

    public function inputData()
    {
        $data = array();

        $data['product_name'] =  $this->request->get('product_name');
        $data['brand_id'] =  $this->request->get('brand_id');
        $data['category_id'] =  $this->request->get('category_id');
        $data['subcategory_id'] =  $this->request->get('subcategory_id');
        $data['subsubcategory_id'] =  $this->request->get('subsubcategory_id');
        $data['product_name'] =  $this->request->get('product_name');
        $data['available_stock'] =  $this->request->get('available_stock');
        $data['price'] =  $this->request->get('price');
        $data['short_desc'] =  $this->request->get('short_desc');
        $data['long_desc'] =  $this->request->get('long_desc');
        $data['product_cond'] =  $this->request->get('product_cond');
        $data['min_order'] =  $this->request->get('min_order');
        $data['sku'] =  $this->request->get('sku');
        $data['product_weight'] =  $this->request->get('product_weight');
        $data['metric_mass'] =  $this->request->get('metric_mass');
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

        $JSONimgsStr = json_encode($data_value['images']);
        $JSONimgsArr = json_decode($JSONimgsStr, TRUE);
        $imagesCaption = array();
        foreach ($JSONimgsArr as $image) {
            $imagesCaption[] = $image['caption'];
        }

        $productWeight = str_replace(".", "", $data_value['product_weight']);
        if ($data_value['metric_mass'] == 'G (Gram)') {
            $weight = $productWeight / 1000;
            $weight = ceil($weight);
        } else {
            $weight = $productWeight;
        }

        $this->newProductId = Product::insertGetId([
            'product_name' => $data_value['product_name'],
            'brand_id' => $data_value['brand_id'],
            'category_id' => $data_value['category_id'],
            'subcategory_id' => $data_value['subcategory_id'],
            'subsubcategory_id' => $data_value['subsubcategory_id'],
            'available_stock' => str_replace(".", "", $data_value['available_stock']),
            'product_slug' => strtolower(str_replace(' ', '-', $data_value['product_name'])),
            'product_key' => uniqid(),
            'url' => strtolower(str_replace(' ', '-', $data_value['product_name'])),
            'price' => str_replace(".", "", $data_value['price']),
            'short_desc' => $data_value['short_desc'],
            'long_desc' => $data_value['long_desc'],
            'product_cond' => $data_value['product_cond'],
            'min_order' => str_replace(".", "", $data_value['min_order']),
            'sku' => $data_value['sku'],
            'product_weight' => str_replace(".", "", $data_value['product_weight']),
            'weight' => $weight,
            'metric_mass' => $data_value['metric_mass'],
            'product_length' => str_replace(".", "",  $data_value['product_length']),
            'product_width' => str_replace(".", "",  $data_value['product_width']),
            'product_height' => str_replace(".", "",  $data_value['product_height']),
            'product_type' => 'prod',
            'hot_deals' => $data_value['hot_deals'],
            'featured' => $data_value['featured'],
            'special_offer' => $data_value['special_offer'],
            'special_deals' => $data_value['special_deals'],
            'status' => $data_value['status'],
            'images' => json_encode($data_value['images']),
            'cover' => $imagesCaption[0]
        ]);
    }

    public function updateProduct($id)
    {
        $product = Product::findOrFail($id);
        $data_value = $this->inputData();

        $JSONimgsStr = json_encode($data_value['images']);
        $JSONimgsArr = json_decode($JSONimgsStr, TRUE);
        $imagesCaption = array();
        foreach ($JSONimgsArr as $image) {
            $imagesCaption[] = $image['caption'];
        }

        $productWeight = str_replace(".", "", $data_value['product_weight']);
        if ($data_value['metric_mass'] == 'G (Gram)') {
            $weight = $productWeight / 1000;
            $weight = ceil($weight);
        } else {
            $weight = $productWeight;
        }

        $this->newProductId = $product->update([
            'product_name' => $data_value['product_name'],
            'brand_id' =>  $data_value['brand_id'],
            'category_id' => $data_value['category_id'],
            'subcategory_id' => $data_value['subcategory_id'],
            'subsubcategory_id' => $data_value['subsubcategory_id'],
            'available_stock' => str_replace(".", "", $data_value['available_stock']),
            'product_slug' => strtolower(str_replace(' ', '-', $data_value['product_name'])),
            'url' => strtolower(str_replace(' ', '-', $data_value['product_name'])),
            'url_id' => $id,
            'price' => str_replace(".", "", $data_value['price']),
            'short_desc' => $data_value['short_desc'],
            'long_desc' => $data_value['long_desc'],
            'product_cond' => $data_value['product_cond'],
            'min_order' => str_replace(".", "", $data_value['min_order']),
            'sku' => $data_value['sku'],
            'product_weight' => str_replace(".", "", $data_value['product_weight']),
            'weight' => $weight,
            'metric_mass' => $data_value['metric_mass'],
            'product_length' => str_replace(".", "",  $data_value['product_length']),
            'product_width' => str_replace(".", "",  $data_value['product_width']),
            'product_height' => str_replace(".", "",  $data_value['product_height']),
            'product_type' => 'prod',
            'hot_deals' => $data_value['hot_deals'],
            'featured' => $data_value['featured'],
            'special_offer' => $data_value['special_offer'],
            'special_deals' => $data_value['special_deals'],
            'status' => $data_value['status'],
            'cover' => $imagesCaption[0]
        ]);
    }

    public function storeNewVarTypeAndVarOpt($id)
    {
        $variants = $this->request->get('variants');

        foreach ($variants as $variant) {
            $variant_type = $variant['variant_type'];
            $variant_options = $variant['variant_options'];

            $newVariantTypeId = VariantType::insertGetId([
                'product_id' => $id,
                'variant_name' => $variant_type,
                'variant_type' => $variant_type,
            ]);

            foreach ($variant_options as $varOpt) {
                $varVal = $varOpt['value'];

                $newVariantOptionId = VariantOption::insertGetId([
                    'product_id' => $id,
                    'product_variant_id' => $newVariantTypeId,
                    'variant_value_name' => $varVal,
                    'value' => $varVal,
                ]);
            }
        }
    }

    public function storeNewVarProds($id)
    {
        $variantsProd = $this->request->get('variants_prod');
        $getProductSlug = DB::table('products')->select('product_slug')->where('id', $id)->get();
        $productSlug = $getProductSlug[0]->product_slug;

        foreach ($variantsProd as $key) {
            $productVariant = $key['product_variant'];
            $productCombinationSlug = strtolower(str_replace(' ', '-', $key['product_variant']));
            $prodAndProdCombSlug = $productSlug . '-' . $productCombinationSlug;
            $price = $key['price'];
            $sku = $key['sku'];
            $images = $key['images'];
            $condition = $key['condition'];
            $status = $key['status'];
            $stock = $key['available_stock'];
            $productWeight = $key['product_weight'];
            $metricMass = $key['metric_mass'];
            if ($key['metric_mass'] == 'G (Gram)') {
                $weight = $productWeight / 1000;
                $weight = ceil($weight);
            } else {
                $weight = $productWeight;
            }

            $stringParts = str_split($productVariant);
            sort($stringParts, SORT_NATURAL | SORT_FLAG_CASE);
            $string = implode($stringParts);

            $JSONimgsStr = json_encode($images);
            $JSONimgsArr = json_decode($JSONimgsStr, TRUE);
            $imagesCaption = array();
            foreach ($JSONimgsArr as $image) {
                $imagesCaption[] = $image['caption'];
            }

            $prodCombName = str_replace("-", " ", $prodAndProdCombSlug);

            $newProductCombinationId = ProductCombination::insertGetId([
                'product_id' => $id,
                'product_variant' => $productVariant,
                'product_slug' => $prodAndProdCombSlug,
                'product_key' => uniqid(),
                'url' => $productSlug,
                'url_id' => $id,
                'product_name' => ucwords($prodCombName),
                'unique_string_id' => Str::lower($string),
                'price' => str_replace(".", "", $price),
                'sku' => $sku,
                'product_weight' => $productWeight,
                'metric_mass' => $metricMass,
                'weight' => $weight,
                'available_stock' => str_replace(".", "", $stock),
                'product_type' => 'prod-comb',
                'condition' => $condition,
                'status' => $status,
                'images' => json_encode($images),
                'cover' => $imagesCaption[0]
            ]);
        }
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
                $product_weight = $var['product_weight'];
                $metric_mass = $var['metric_mass'];

                if ($price == null || $stock == null || $sku == null || $total_images == 0 || $product_weight == null || $metric_mass == null) {
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

            $this->storeNewVarTypeAndVarOpt($this->newProductId);
            $this->storeNewVarProds($this->newProductId);
            $product = Product::findOrFail($this->newProductId);
            $product->update(['url_id' => $this->newProductId]);

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added!',
            ]);
        } else {
            if ($totalInputtedPicts > 0) {
                $this->storeProduct();
                $product = Product::findOrFail($this->newProductId);
                $product->update(['url_id' => $this->newProductId]);

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

    public function listProducts(Request $request)
    {
        $items = $request->items ?? 9;
        $trashedProducts = Product::onlyTrashed()->count();
        $products = Product::with('variantsProd')->orderBy('id', 'desc')->paginate($items);

        return response()->json([
            'products' => $products,
            'total_trashed_products' => $trashedProducts,
            'items' => $items,
        ], 200);
    }

    public function softDelete($id)
    {
        Product::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product has been trashed successfully.',
        ]);
    }

    public function softDeleteMultiple(Request $request)
    {
        $get_ids = $request->ids;
        $ids = explode(',', $get_ids);

        // precess request one by one 
        foreach ($ids as $id) {
            $product = Product::findOrFail($id);

            if ($product) {
                $product->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product/s has been trashed successfully.'
        ]);
    }

    public function searchProduct($keyword)
    {
        $items = $this->request->items ?? 5;
        $product = Product::where('product_name', 'LIKE', "%{$keyword}%")->paginate($items);
        $trashedProducts = Product::onlyTrashed()->count();

        return response()->json([
            'products' => $product,
            'total_trashed_products' => $trashedProducts,
            'items' => $items,
        ], Response::HTTP_OK);
    }

    public function trash(Request $request)
    {
        $items = $request->items ?? 5;
        $products = Product::orderBy('id', 'desc')->onlyTrashed()->paginate($items);
        $trashedProducts = Product::onlyTrashed()->count();
        $nonTrashed = Product::count();

        return response()->json([
            'products' => $products,
            'total_trashed_products' => $trashedProducts,
            'items' => $items,
            'non_trashed' => $nonTrashed,
        ], 200);
    }

    public function searchInTrash($keyword)
    {
        $items = $this->request->items ?? 5;
        $product = Product::onlyTrashed()->where('product_name', 'LIKE', "%{$keyword}%")->paginate($items);
        $trashedProducts = Product::onlyTrashed()->count();
        $nonTrashed = Product::count();

        return response()->json([
            'products' => $product,
            'total_trashed_products' => $trashedProducts,
            'items' => $items,
            'non_trashed' => $nonTrashed,
        ], Response::HTTP_OK);
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if ($product->trashed()) {
            $product->restore();
            return response()->json([
                'success' => true,
                'message' => 'Product successfully restored.',
            ]);
        }
    }

    public function restoreMultiple(Request $request)
    {
        $get_ids = $request->ids;
        $ids = explode(',', $get_ids);

        $products = Product::withTrashed()->whereIn('id', $ids);
        $products->restore();
        return response()->json([
            'success' => true,
            'message' => 'Selected products successfully restored'
        ]);
    }

    public function deleteProdCombOrder($id)
    {
        $orders = array();
        $duplicateOrderIds = array();

        $prodCombId = DB::table('products_combinations')->select('id')->where('product_id', $id)->pluck('id'); // all id of prod comb related with specific product
        $relatedOrdersFromProdComb = ProductCombination::whereIn('id', $prodCombId)->with('orders')->get();
        if ($relatedOrdersFromProdComb) {
            foreach ($relatedOrdersFromProdComb as $relatedOrder) {
                $orders[] = $relatedOrder['orders'];
            }

            // remove an empty array
            foreach ($orders as $key => $order) {
                if (count($order) === 0) {
                    unset($orders[$key]);
                }
            }

            // getting order id
            foreach ($orders as $key => $order) {
                foreach ($order as $key2 => $ord) {
                    $duplicateOrderIds[] = $order[$key2]['id'];
                }
            }
        }
        $orderIds = array_unique($duplicateOrderIds);

        // delete product combination orders
        if (count($orderIds) > 0) {
            foreach ($orderIds as $orderId) {
                $order = Order::withTrashed()->findOrFail($orderId);

                $orderProductCombination = DB::table('order_product_combination')->whereIn('product_combination_id', $prodCombId); // all id of prod comb related with specific product
                if ($orderProductCombination) {
                    $orderProductCombination->delete();
                }

                if (!$order->products()->exists() && !$order->variantsProd()->exists()) {
                    // delete orders
                    $order->forceDelete();
                } else {
                    // update total quantity 
                    $totalQty = count($order->products) + count($order->variantsProd);
                    Order::withTrashed()->findOrFail($orderId)->update([
                        'total_quantity' => $totalQty,
                    ]);
                }
            }
        }

        // delete buy_checkout
        $buyCheckOut = DB::table('buy_checkout')->where('product_id', $id);
        if ($buyCheckOut) {
            $buyCheckOut->delete();
        }
    }

    public function forceDeleteProduct($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $imagesProduct = Product::withTrashed()->where('id', $id)->get('images');
        $varProds = ProductCombination::withTrashed()->where('product_id', $id);

        ///////////////////////////////////////////////////////////////////////////////////////////

        $orders = array();
        $duplicateOrderIds = array();

        $prodCombId = DB::table('products_combinations')->select('id')->where('product_id', $id)->pluck('id'); // all id of prod comb related with specific product
        $relatedOrdersFromProdComb = ProductCombination::whereIn('id', $prodCombId)->with('orders')->get();
        if ($relatedOrdersFromProdComb) {
            foreach ($relatedOrdersFromProdComb as $relatedOrder) {
                $orders[] = $relatedOrder['orders'];
            }

            // remove an empty array
            foreach ($orders as $key => $order) {
                if (count($order) === 0) {
                    unset($orders[$key]);
                }
            }

            // getting order id
            foreach ($orders as $key => $order) {
                foreach ($order as $key2 => $ord) {
                    $duplicateOrderIds[] = $order[$key2]['id'];
                }
            }
        }

        $relatedOrdersFromProd = Product::withTrashed()->where('id', $id)->with('orders')->get();
        if ($relatedOrdersFromProd) {
            foreach ($relatedOrdersFromProd as $relatedOrder) {
                $orders[] = $relatedOrder['orders'];
            }

            // remove an empty array
            foreach ($orders as $key => $order) {
                if (count($order) === 0) {
                    unset($orders[$key]);
                }
            }

            // getting order id
            foreach ($orders as $key => $order) {
                foreach ($order as $key2 => $ord) {
                    $duplicateOrderIds[] = $order[$key2]['id'];
                }
            }
        }

        $orderIds = array_unique($duplicateOrderIds);

        ///////////////////////////////////////////////////////////////////////////////////////////

        if (count($orderIds) > 0) {
            foreach ($orderIds as $orderId) {
                $order = Order::withTrashed()->findOrFail($orderId);

                $orderProduct = DB::table('order_product')->where('product_id', $id);
                if ($orderProduct) {
                    $orderProduct->delete();
                }

                $orderProductCombination = DB::table('order_product_combination')->whereIn('product_combination_id', $prodCombId); // all id of prod comb related with specific product
                if ($orderProductCombination) {
                    $orderProductCombination->delete();
                }

                if (!$order->products()->exists() && !$order->variantsProd()->exists()) {
                    // delete orders
                    $order->forceDelete();
                } else {
                    // update total quantity 
                    $totalQty = count($order->products) + count($order->variantsProd);
                    Order::withTrashed()->findOrFail($orderId)->update([
                        'total_quantity' => $totalQty,
                    ]);
                }
            }
        }

        // delete buy_checkout
        $buyCheckOut = DB::table('buy_checkout')->where('product_id', $id);
        if ($buyCheckOut) {
            $buyCheckOut->delete();
        }

        // Delete product images. 
        $this->deleteStoredImages($imagesProduct);

        if ($varProds) {
            // Delete variant product images. 
            $this->deleteAllVarProdsImagesInDb($id);

            // Delete variant products
            $varProds->forceDelete();
        }

        // Delete product variant type and product variant options
        $this->deleteVarTypeAndVarOpt($id);

        // Delete product
        $product->forceDelete();
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if ($product) {
            $this->forceDeleteProduct($id);

            return response()->json([
                'success' => true,
                'message' => 'Product successfully deleted!'
            ]);
        }
    }

    public function forceDeleteMultiple(Request $request)
    {
        $get_ids = $request->ids;
        $ids = explode(',', $get_ids);

        // precess request one by one
        foreach ($ids as $id) {
            $product = Product::withTrashed()->findOrFail($id);

            if ($product) {
                $this->forceDeleteProduct($id);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
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

    public function edit($id)
    {
        $product =  Product::with('variants.variantOptions')->with('variantsProd')->where('id', $id)->first();
        return response()->json($product);
    }

    public function updateImages($id)
    {
        $images =  $this->request->get('images');

        $JSONimgsStr = json_encode($images);
        $JSONimgsArr = json_decode($JSONimgsStr, TRUE);
        $imagesCaption = array();
        foreach ($JSONimgsArr as $image) {
            $imagesCaption[] = $image['caption'];
        }

        $prod = Product::where('id', $id);
        $prod->update([
            'images' => json_encode($images),
            'cover' => $imagesCaption[0]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product images succesfully updated!',
        ]);
    }

    public function updateVarProdImages($id)
    {
        $imagesUpdated =  $this->request->get('imagesUpdated');

        if ($imagesUpdated === null) {
            $prod = ProductCombination::where('id', $id);
            $prod->update([
                'images' => null,
            ]);
        } else {
            $JSONimgsStr = json_encode($imagesUpdated);
            $JSONimgsArr = json_decode($JSONimgsStr, TRUE);
            $imagesCaption = array();
            foreach ($JSONimgsArr as $image) {
                $imagesCaption[] = $image['caption'];
            }

            $prod = ProductCombination::where('id', $id);
            $prod->update([
                'images' => json_encode($imagesUpdated),
                'cover' => $imagesCaption[0]
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product images succesfully updated!',
        ]);
    }

    public function updateVarProdUrlImages()
    {
        $imagesUpdated =  $this->request->get('varProdImages');
        $varProdIds = $this->request->get('varProdIds');

        foreach ($varProdIds as $index => $varProdId) {
            $prod = ProductCombination::where('id', $varProdId);

            if ($prod) {
                $prod->update([
                    'images' => json_encode($imagesUpdated[$index]),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Images API has been updated successfully!',
        ]);
    }

    public function deleteStoredImages($images)
    {
        if ($images) {
            $imagesArr = array();
            foreach ($images as $image) {
                $imagesArr[] = json_decode($image['images']);
            }

            if (sizeof($imagesArr) > 0) {
                $imagesArrName = array();
                foreach ($imagesArr as $imageArr) {
                    if ($imageArr) {
                        foreach ($imageArr as $imageFileName) {
                            $imagesArrName[] = $imageFileName;
                        }
                    }
                }

                if (sizeof($imagesArrName) > 0) {
                    $deleteAllImages = array_column($imagesArrName, 'caption');

                    foreach ($deleteAllImages as $deleteImage) {
                        $this->deleteImages($deleteImage);
                    }
                }
            }
        }
    }

    public function deleteAllVarProdsImagesInDb($id)
    {
        $varProds = ProductCombination::where('product_id', $id)->get('images');
        $this->deleteStoredImages($varProds);
    }

    public function getVarProdImagesToDelete($varProdImages)
    {
        $images = array();
        foreach ($varProdImages as $deletedVarProd) {
            $images[] = $deletedVarProd['images'];
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

    public function deleteSelectedVarProdsImages()
    {
        $varProdsImgsToBeDeleted = $this->request->get('varProdsImgsToBeDeleted');

        if (sizeof($varProdsImgsToBeDeleted) > 0) {
            $this->getVarProdImagesToDelete($varProdsImgsToBeDeleted);
        }
    }

    // This function is executed directly only from the view when user delete the variant type. 
    public function deleteAllNewAddedVarProdImages()
    {
        $newAddedVarProdImages = $this->request->get('addedNewVarProds');

        if (sizeof($newAddedVarProdImages) > 0) {
            $this->getVarProdImagesToDelete($newAddedVarProdImages);
        }
    }

    public function deleteAllNewAddedVarProdImagesInCreatePage()
    {
        $variantsProd = $this->request->get('variants_prod');

        if (sizeof($variantsProd) > 0) {
            $this->getVarProdImagesToDelete($variantsProd);
        }
    }

    // This function is executed directly from the view when user delete the new added variant products through the variant options field. 
    public function deleteSomeNewAddedVarProdImages()
    {
        $newVarProdsImagesToBeDeleted = $this->request->get('newVarProdsImagesToBeDeleted');

        if (sizeof($newVarProdsImagesToBeDeleted) > 0) {
            $this->getVarProdImagesToDelete($newVarProdsImagesToBeDeleted);
        }
    }

    public function deleteAllVarProds($id)
    {
        $varProds = ProductCombination::where('product_id', $id);
        if ($varProds) {
            $varProds->forceDelete();
        }

        $varOpt = VariantOption::where('product_id', $id);
        if ($varOpt) {
            $varOpt->forceDelete();
        }

        $varType = VariantType::where('product_id', $id);
        if ($varType) {
            $varType->forceDelete();
        }
    }

    public function deleteVarTypeAndVarOpt($id)
    {
        $varOpts = VariantOption::where('product_id', $id);
        if ($varOpts) {
            $varOpts->forceDelete();
        }

        $varTypes = VariantType::where('product_id', $id);
        if ($varTypes) {
            $varTypes->forceDelete();
        }
    }

    public function updateVarTypesAndVarOpts($id)
    {
        // delete all variant type and variant options
        $this->deleteVarTypeAndVarOpt($id);

        // insert the new updated variant type and variant options
        $this->storeNewVarTypeAndVarOpt($id);
    }

    public function update($id) // $id refer to product id
    {
        $this->validateFields();

        $totalInputtedPicts = $this->request->get('totalInputtedPicts');
        $isVariantExists =  $this->request->get('isVariantExists');
        $variantIsDeleted = $this->request->get('variantIsDeleted');

        if ($isVariantExists > 0) {
            $variants = $this->request->get('variants');
            $variantsProd = $this->request->get('variants_prod');
            $varProdsToBeDeleted = $this->request->get('varProdsToBeDeleted');
            $varProdsImgsToBeDeleted = $this->request->get('varProdsImgsToBeDeleted');
            $newVarProdIsExist = $this->request->get('addedNewVarProds');
            $varProdsBeenStoredInDb = $this->request->get('varProdsBeenStoredInDb');

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
                $product_weight = $var['product_weight'];
                $metric_mass = $var['metric_mass'];

                if ($price == null || $stock == null || $sku == null || $total_images == 0 || $product_weight == null || $metric_mass == null) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Please fill the variant product input!',
                    ]);
                }
            }

            ///////////////////////////////////////////////////////////////////////////////////////

            // Update the variant type product
            $variants = $this->request->get('variants');

            $variant_types = array();
            foreach ($variants as $variant) {
                $variant_types[] = $variant['variant_type'];
            }

            $getVarTypes = VariantType::where('product_id', $id)->get();
            foreach ($getVarTypes as $index => $getVarType) {
                $getVarType->update([
                    'product_id' => $id,
                    'variant_name' => $variant_types[$index],
                    'variant_type' => $variant_types[$index],
                ]);
            }

            // update the single product
            if ($totalInputtedPicts > 0) { // if total input images of single product is more than 0
                $this->updateProduct($id); // update single product
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Please upload a product picts!',
                ]);
            }

            // Do this action if variant is deleted from the view. 
            if ($variantIsDeleted == 'Yes') {
                $this->deleteProdCombOrder($id);

                // delete all variant product images
                $this->deleteAllVarProdsImagesInDb($id);

                // delete all variant products
                $this->deleteAllVarProds($id);

                // store new variant products
                $this->storeNewVarProds($id);

                // update the change of variant type and variant options
                $this->updateVarTypesAndVarOpts($id);
            }

            // if one or some of variant options is deleted from the view, do this action. 
            if ($varProdsImgsToBeDeleted !== null && $variantIsDeleted == 'No') {
                $this->deleteProdCombOrder($id);

                // delete variant product images file that has been uploaded. 
                $this->deleteSelectedVarProdsImages();

                // if the variant product that stored in database is deleted in the view, then also delete it from database. 
                if ($varProdsToBeDeleted !== null) {
                    if (sizeof($varProdsToBeDeleted)  > 0) {
                        $varProdIds = array();
                        foreach ($varProdsToBeDeleted as $varProd) {
                            $varProdIds[] = $varProd['id'];
                        }

                        if (count($varProdIds) > 0) {
                            foreach ($varProdIds as $varProdId) {
                                $varProd = ProductCombination::where('id', $varProdId);
                                $varProd->forceDelete();
                            }
                        }
                    }

                    // update the change of variant type and variant options
                    $this->updateVarTypesAndVarOpts($id);
                }
            }

            $getProductSlug = DB::table('products')->select('product_slug')->where('id', $id)->get();
            $productSlug = $getProductSlug[0]->product_slug;

            // If the new variant products exist, then insert it to database. 
            if ($newVarProdIsExist !== null && $variantIsDeleted == 'No') {
                if (sizeof($newVarProdIsExist) > 0) {
                    foreach ($newVarProdIsExist as $key) {
                        $productVariant = $key['product_variant'];
                        $productCombinationSlug = strtolower(str_replace(' ', '-', $key['product_variant']));
                        $prodAndProdCombSlug = $productSlug . '-' . $productCombinationSlug;
                        $prodCombName = str_replace("-", " ", $prodAndProdCombSlug);
                        $price = $key['price'];
                        $sku = $key['sku'];
                        $images = $key['images'];
                        $condition = $key['condition'];
                        $status = $key['status'];
                        $stock = $key['available_stock'];
                        $productWeight = $key['product_weight'];
                        $metricMass = $key['metric_mass'];
                        if ($key['metric_mass'] == 'G (Gram)') {
                            $weight = $productWeight / 1000;
                            $weight = ceil($weight);
                        } else {
                            $weight = $productWeight;
                        }
                        $JSONimgsStr = json_encode($key['images']);
                        $JSONimgsArr = json_decode($JSONimgsStr, TRUE);
                        $imagesCaption = array();
                        foreach ($JSONimgsArr as $image) {
                            $imagesCaption[] = $image['caption'];
                        }

                        $stringParts = str_split($productVariant);
                        sort($stringParts, SORT_NATURAL | SORT_FLAG_CASE);
                        $string = implode($stringParts);
                        $strToLower = Str::lower($string);
                        $trimmed_str = ltrim($strToLower);

                        $newProductCombinationId = ProductCombination::insertGetId([
                            'product_id' => $id,
                            'product_variant' => $productVariant,
                            'product_slug' => $prodAndProdCombSlug,
                            'url' => $productSlug,
                            'url_id' => $id,
                            'product_name' => ucwords($prodCombName),
                            'unique_string_id' => $trimmed_str,
                            'price' => str_replace(".", "", $price),
                            'sku' => $sku,
                            'product_weight' => $productWeight,
                            'metric_mass' => $metricMass,
                            'weight' => $weight,
                            'available_stock' => str_replace(".", "", $stock),
                            'product_type' => 'prod-comb',
                            'condition' => $condition,
                            'status' => $status,
                            'images' => json_encode($images),
                            'cover' => $imagesCaption[0]
                        ]);
                    }
                }

                // update the change of variant type and variant options
                $this->updateVarTypesAndVarOpts($id);
            }

            // If the variant products that has been stored in database are exist in the view, then update all of it. 
            if ($varProdsBeenStoredInDb !== null) {
                // bulk update all the existing variant products. 
                if (sizeof($varProdsBeenStoredInDb) > 0) {
                    $varProdIds = array();
                    foreach ($varProdsBeenStoredInDb as $varProd) {
                        $varProdIds[] = $varProd['id'];
                    }

                    $prices = array();
                    $sku = array();
                    $available_stocks = array();
                    $conditions = array();
                    $status = array();
                    $productWeight = array();
                    $metricMass = array();
                    $weight = array();
                    $caption = array();

                    for ($i = 0; $i < count($varProdsBeenStoredInDb); $i++) {
                        array_push($prices, $varProdsBeenStoredInDb[$i]['price']);
                        array_push($sku, $varProdsBeenStoredInDb[$i]['sku']);
                        array_push($available_stocks, $varProdsBeenStoredInDb[$i]['available_stock']);
                        array_push($conditions, $varProdsBeenStoredInDb[$i]['condition']);
                        array_push($status, $varProdsBeenStoredInDb[$i]['status']);
                        array_push($productWeight, $varProdsBeenStoredInDb[$i]['product_weight']);
                        array_push($metricMass, $varProdsBeenStoredInDb[$i]['metric_mass']);
                        $JSONimgsStr = json_encode($varProdsBeenStoredInDb[$i]['images']);
                        $JSONimgsArr = json_decode($JSONimgsStr, TRUE);
                        foreach ($JSONimgsArr as $image) {
                            $caption[] = $image['caption'];
                        }

                        if ($varProdsBeenStoredInDb[$i]['metric_mass'] == 'G (Gram)') {
                            $calcWeight = $varProdsBeenStoredInDb[$i]['product_weight'] / 1000;
                            array_push($weight, ceil($calcWeight));
                        } else {
                            array_push($weight, $varProdsBeenStoredInDb[$i]['product_weight']);
                        }
                    }

                    foreach ($varProdIds as $index => $varProdId) {
                        $prod = ProductCombination::where('id', $varProdId);
                        $getProductVariant = DB::table('products_combinations')->select('product_variant')->where('id', $varProdId)->get();
                        $productVariant = $getProductVariant[0]->product_variant;
                        $productCombinationSlug = strtolower(str_replace(' ', '-', $productVariant));
                        $prodAndProdCombSlug = $productSlug . '-' . $productCombinationSlug;
                        $prodCombName = str_replace("-", " ", $prodAndProdCombSlug);

                        $stringParts = str_split($productVariant);
                        sort($stringParts, SORT_NATURAL | SORT_FLAG_CASE);
                        $string = implode($stringParts);
                        $strToLower = Str::lower($string);
                        $trimmed_str = ltrim($strToLower);

                        $prod->update([
                            'product_slug' => $prodAndProdCombSlug,
                            'url' => $productSlug,
                            'url_id' => $id,
                            'product_name' => ucwords($prodCombName),
                            'unique_string_id' => $trimmed_str,
                            'price' => str_replace(".", "", $prices[$index]),
                            'sku' => $sku[$index],
                            'product_type' => 'prod-comb',
                            'product_weight' => $productWeight[$index],
                            'metric_mass' => $metricMass[$index],
                            'weight' => $weight[$index],
                            'available_stock' => str_replace(".", "", $available_stocks[$index]),
                            'condition' => $conditions[$index],
                            'status' => $status[$index],
                            'cover' => $caption[$index]
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Product successfully updated!',
            ]);
        } else {
            if ($totalInputtedPicts > 0) {
                $this->updateProduct($id);

                if ($variantIsDeleted == 'Yes') {
                    $this->deleteProdCombOrder($id);
                    $this->deleteAllVarProdsImagesInDb($id);
                    $this->deleteAllVarProds($id);
                }

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
