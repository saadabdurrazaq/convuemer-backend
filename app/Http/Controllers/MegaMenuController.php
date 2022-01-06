<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Illuminate\Support\Str;

class MegaMenuController extends Controller
{
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function getMenuData(Request $request)
	{
		$megaMenu = Category::with('subCategory.subSubCategory')->orderBy('category_name', 'ASC')->get();

		return response()->json([
			'mega_menu' => $megaMenu,
		], 200);
	}
}
