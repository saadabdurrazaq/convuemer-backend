<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Image;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductSliderController extends Controller
{
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function showFeaturedProduct(Request $request)
	{
		$products = Product::where('featured', 'Yes')->orderBy('id', 'desc')->get();

		return response()->json([
			'products' => $products,
		], 200);
	}
}
