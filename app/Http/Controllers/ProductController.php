<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VariantType;
use App\Models\VariantOption;
use App\Models\ProductCombination;
use Illuminate\Support\Str;
use DB;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public $request;
    protected $newProductId;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function storeProduct()
    {
        $productName = $this->request->get('product_name');

        $this->newProductId = Product::insertGetId([
            'product_name' => $productName,
        ]);
    }

    public function store(Request $request)
    {
        $isVariantExists =  $this->request->get('isVariantExists');
        $variants = $this->request->get('variants');
        $variantsProd = $this->request->get('variantsProd');

        $this->request->validate([
            'product_name' => 'required',
        ], [
            'product_name.required' => 'Input product name with valid format!',
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

                if ($price == null || $stock == null || $sku == null) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Please fill the variant product input!',
                    ]);
                }
            }

            // if validation success, run the proccess below. 
            $this->storeProduct();

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

                $stringParts = str_split($productVariant);
                sort($stringParts);
                $string = implode($stringParts);
                $subStr = Str::substr($string, 1);

                $newProductCombinationId = ProductCombination::insertGetId([
                    'product_id' => $this->newProductId,
                    'sku' => $sku,
                    'combination_string' => $productVariant,
                    'unique_string_id' => Str::lower($subStr),
                    'price' => str_replace(".", "", $price),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added!',
            ]);
        } else {
            $this->storeProduct();

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added!',
            ]);
        }
    }
}
