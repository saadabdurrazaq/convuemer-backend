<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Illuminate\Support\Str;
use App\Models\Product;

class SubSubCategoryController extends Controller
{
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;

		$this->middleware('permission:View Sub Sub Categories', ['only' => ['index']]);
		$this->middleware('permission:Create Sub Sub Category', ['only' => ['store']]);
		$this->middleware('permission:Update Sub Sub Category', ['only' => ['update', 'bulkAssign', 'singleAssign', 'doSingleAssign']]);
		$this->middleware('permission:Delete Sub Sub Category', ['only' => ['softDelete', 'softDeleteMultiple', 'forceDelete', 'forceDeleteMultiple']]);
	}

	public function index(Request $request)
	{
		$items = $request->items ?? 5;
		$subSubCategories = SubSubCategory::with('subCategory')->with('category')->orderBy('id', 'desc')->paginate($items);
		$totalTrashedSubSubCategories = SubSubCategory::onlyTrashed()->count();

		return response()->json([
			'sub_sub_categories' => $subSubCategories,
			'total_trashed_sub_sub_categories' => $totalTrashedSubSubCategories,
			'items' => $items,
		], 200);
	}

	public function searchSubSubCatByKey($keyword)
	{
		$items = $this->request->items ?? 5;
		$subSubCategory = SubSubCategory::with('subCategory')->with('category')->where('subsubcategory_name', 'LIKE', "%{$keyword}%")->paginate($items);
		$trashedSubSubCategories = SubSubCategory::onlyTrashed()->count();

		return response()->json([
			'sub_sub_categories' => $subSubCategory,
			'total_trashed_sub_sub_categories' => $trashedSubSubCategories,
			'items' => $items,
		], Response::HTTP_OK);
	}

	public function store(Request $request)
	{
		$request->validate([
			'subsubcategory_name' => 'required',
		], [
			'subsubcategory_name.required' => 'Input valid sub category name! End with a comma.',
		]);

		$convertString = json_encode($request->get('subsubcategory_name')); //object to json string conversion $request->get('subcategory_name')
		$dataString = json_decode($convertString); // json string to array
		$subSubCategories = explode(",", $dataString);

		$totalSubSubCat = count(array_filter($subSubCategories));

		foreach ($subSubCategories as $subSubCategory) {
			SubSubCategory::insert([
				'subsubcategory_name' => $subSubCategory,
				'subsubcategory_slug' => strtolower(str_replace(' ', '-', $subSubCategory)),
			]);
		}

		// Fix invalid slug
		$invalidSlugsId = DB::table('sub_sub_categories')->select('id')->where('subsubcategory_slug', 'like', '-%')->get();
		$invalidSlugs = DB::table('sub_sub_categories')->select('subsubcategory_slug')->where('subsubcategory_slug', 'like', '-%')->pluck('subsubcategory_slug')->toArray();
		$totalInvalidSlugs = DB::table('sub_sub_categories')->select('id')->where('subsubcategory_slug', 'like', '-%')->count();

		$validSlugs = array();
		for ($i = 0; $i < count($invalidSlugs); $i++) {
			array_push($validSlugs, Str::substr($invalidSlugs[$i], 1));
		}

		if ($totalInvalidSlugs > 0) {
			foreach ($invalidSlugsId as $index => $invalidSlugId) {
				$data = json_decode(json_encode($invalidSlugId), true);
				SubSubCategory::findOrFail($data['id'])->update([
					'subsubcategory_slug' => $validSlugs[$index]
				]);
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Sub sub category successfully inserted!',
			'total_sub_sub_cat' => $totalSubSubCat
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'subsubcategory_name' => 'required',
		], [
			'subsubcategory_name.required' => 'Input a valid sub sub category!'
		]);

		SubSubCategory::findOrFail($id)->update([
			'subsubcategory_name' => $request->subsubcategory_name,
			'subsubcategory_slug' => strtolower(str_replace(' ', '-', $request->subsubcategory_name)),
		]);

		return response()->json([
			'success' => true,
			'message' => 'Sub sub category updated!',
		]);
	}

	public function getCategories()
	{
		$categories = Category::orderBy('id', 'desc')->get();

		return response()->json([
			'categories' => $categories,
		], 200);
	}

	public function getSubCategories($id)
	{
		$subCat = SubCategory::where('category_id', $id)->orderBy('subcategory_name', 'ASC')->get();
		return response()->json([
			'sub_categories' => $subCat,
		], 200);
	}

	public function getSubSubCategories($id)
	{
		$subSubCat = SubSubCategory::with('subCategory')
			->OrWhereHas('subCategory', function ($q) use ($id) {
				$q->where('id', $id);
			})
			->orderBy('subsubcategory_name', 'ASC')
			->get();

		return response()->json([
			'sub_sub_categories' => $subSubCat,
		], 200);
	}

	public function getCatSubCat($id)
	{
		$subSubCat = SubSubCategory::find($id); // id of sub sub category

		if ($subSubCat->subCategory()->exists()) {

			$category = Category::OrWhereHas('subSubCategory', function ($q) use ($id) {
				$q->where('id', $id);
			})
				->orderBy('category_name', 'ASC')
				->get();

			$subCategory = SubCategory::OrWhereHas('subSubCategory', function ($q) use ($id) {
				$q->where('id', $id);
			})
				->orderBy('subcategory_name', 'ASC')
				->get();

			$subSubCategory = SubSubCategory::where('id', $id)->get();

			/////////////////////////////////////////////////////////////////////////////

			$getCategoryId = Category::select('id')
				->OrWhereHas('subSubCategory', function ($q) use ($id) {
					$q->where('id', $id);
				})->get();

			$getSubCategoryId = SubCategory::select('id')
				->OrWhereHas('subSubCategory', function ($q) use ($id) {
					$q->where('id', $id);
				})->get();


			$categoryIdArr = $getCategoryId->toArray();
			$categoryIdArray = $categoryIdArr[0];
			$categoryId = $categoryIdArray['id'];

			$subCategoryIdArr = $getSubCategoryId->toArray();
			$subCategoryIdArray = $subCategoryIdArr[0];
			$subCategoryId = $subCategoryIdArray['id'];

			$allCategories = Category::where('id', '!=', $categoryId)->get();
			$allRelatedSubCategories = SubCategory::OrWhereHas('category', function ($q) use ($categoryId) {
				$q->where('id', $categoryId);
			})->where('id', '!=', $subCategoryId)->get(); // It's to remove duplicate result. That's mean if the value of first displayed sub category is 'Foo', then the same 'Foo' of the rest result should not exist if user click the dropdown 
			$allRelatedSubSubCategories = SubSubCategory::OrWhereHas('subCategory', function ($q) use ($subCategoryId) {
				$q->where('id', $subCategoryId);
			})->where('id', '!=', $id)->get();

			return response()->json([
				'category' => $category,
				'sub_category' => $subCategory,
				'sub_sub_category' => $subSubCategory,
				'all_categories' => $allCategories,
				'all_related_sub_categories' => $allRelatedSubCategories,
				'all_related_sub_sub_categories' => $allRelatedSubSubCategories,
			], 200);
		} else {
			$allCategories2 = Category::all();
			$allSubCategories2 = SubCategory::all();
			$allSubSubCategories2 = SubSubCategory::all();

			return response()->json([
				'category' => null,
				'sub_category' => null,
				'sub_sub_category' => null,
				'all_categories' => $allCategories2,
				'all_sub_categories' => $allSubCategories2,
				'all_sub_sub_categories' => $allSubSubCategories2,
			], 200);
		}
	}

	public function searchSubSubCategories(Request $request, $id)
	{
		$keyword = $request->get('q');

		// check if sub sub cat has relationship with sub cat.
		$subSubCatHasSubCat = SubSubCategory::with('subCategory')
			->OrWhereHas('subCategory', function ($q) use ($id) {
				$q->where('id', $id);
			})->get();

		if ($subSubCatHasSubCat) {
			$subSubCategories = SubSubCategory::with('subCategory')
				->OrWhereHas('subCategory', function ($q) use ($id) {
					$q->where('id', $id);
				})
				->orWhereDoesntHave('subCategory')
				->where("subsubcategory_name", "LIKE", "%$keyword%")->get();

			return $subSubCategories;
		} else {
			$subSubCategories = SubSubCategory::with('category')
				->orWhereDoesntHave('category')
				->where("subsubcategory_name", "LIKE", "%$keyword%")->get();

			return $subSubCategories;
		}
	}

	public function bulkAssign(Request $request)
	{
		$request->validate([
			'category_id' => 'required|numeric',
			'subcategory_id' => 'required|numeric',
			'subsubcategory_name' => 'required',
		], [
			'category_id.numeric' => 'Please select any option!',
			'subcategory_id.numeric' => 'Please select any option!',
			'subsubcategory_name.required' => 'Input an available sub sub category!',
		]);

		$categoryId = $request->get('category_id');
		$subCategoryId = $request->get('subcategory_id');
		$subSubCategoriesId = $request->get('subsubcategory_name');

		$relatedSubSubCat = SubSubCategory::with('subCategory')
			->WhereHas('subCategory', function ($q) use ($subCategoryId) {
				$q->where('id', $subCategoryId);
			});

		$relatedSubSubCat->update([
			'category_id' => null,
			'subcategory_id' => null
		]);

		$assignSubSubCategories = SubSubCategory::whereIn('id', $subSubCategoriesId);

		$assignSubSubCategories->update([
			'category_id' => $categoryId,
			'subcategory_id' => $subCategoryId,
		]);

		return response()->json([
			'success' => true,
			'message' => 'Sub sub category successfully assigned!',
		]);
	}

	public function doSingleAssign($id)
	{
		$subSubCat = SubSubCategory::findOrFail($id);

		$categoryId = $this->request->get('category_id');
		$subCategoryId = $this->request->get('subcategory_id');
		$checkBoxChecked = $this->request->get('unassign');

		if (empty($checkBoxChecked)) {
			$this->request->validate([
				'category_id' => 'required|numeric',
				'subcategory_id' => 'required|numeric',
			], [
				'category_id.numeric' => 'Please select any option!',
				'subcategory_id.numeric' => 'Please select any option!',
			]);

			$subSubCat->update([
				'category_id' => $categoryId,
				'subcategory_id' => $subCategoryId,
			]);
		} else 
		if ($checkBoxChecked[0] == 'unassign') {
			$subSubCat->update([
				'category_id' => null,
				'subcategory_id' => null,
			]);
		}
	}

	public function singleAssign($id)
	{
		$subSubCat = SubSubCategory::findOrFail($id);

		if ($subSubCat->subCategory()->exists()) {
			$this->doSingleAssign($id);
		} else {
			$this->doSingleAssign($id);
		}

		return response()->json([
			'success' => true,
			'message' => 'Sub sub category successfully changed!',
		]);
	}

	public function softDelete($id)
	{
		SubSubCategory::findOrFail($id)->delete();

		return response()->json([
			'success' => true,
			'message' => 'Sub category trashed successfully.',
		]);
	}

	public function softDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$subSubCategory = SubSubCategory::findOrFail($id);

			if ($subSubCategory) {
				$subSubCategory->delete();
			}
		}

		return response()->json([
			'success' => true,
			'Message' => 'Sub sub category trashed successfully.'
		]);
	}

	public function trash(Request $request)
	{
		$items = $request->items ?? 5;
		$subSubCategories = SubSubCategory::with('subCategory')->with('category')->orderBy('id', 'desc')->onlyTrashed()->paginate($items);
		$totalTrashedSubSubCat = SubSubCategory::onlyTrashed()->count();
		$nonTrashed = SubSubCategory::count();

		return response()->json([
			'sub_sub_categories' => $subSubCategories,
			'total_trashed_sub_sub_categories' => $totalTrashedSubSubCat,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], 200);
	}

	public function searchTrashSubSubCat($keyword)
	{
		$items = $this->request->items ?? 5;
		$subSubCategories = SubSubCategory::with('subCategory')->with('category')->where('subsubcategory_name', 'LIKE', "%{$keyword}%")->onlyTrashed()->paginate($items);
		$totalTrashedSubSubCat = SubSubCategory::onlyTrashed()->count();
		$nonTrashed = SubSubCategory::count();

		return response()->json([
			'sub_sub_categories' => $subSubCategories,
			'total_trashed_sub_sub_categories' => $totalTrashedSubSubCat,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], Response::HTTP_OK);
	}

	public function restore($id)
	{
		$subSubCategory = SubSubCategory::withTrashed()->findOrFail($id);

		if ($subSubCategory->trashed()) {
			$subSubCategory->restore();

			return response()->json([
				'success' => true,
				'message' => 'Sub sub category successfully restored.',
			]);
		}
	}

	public function restoreMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		$subSubCategories = SubSubCategory::withTrashed()->whereIn('id', $ids);
		$subSubCategories->restore();

		return response()->json([
			'success' => true,
			'message' => "Sub sub category/ies successfully restored"
		]);
	}

	public function forceDelete($id)
	{
		$subSubCategory = SubSubCategory::withTrashed()->findOrFail($id);
		$product = Product::withTrashed()->where('subsubcategory_id', $id);

		if ($product) {
			$product->update([
				'category_id' => null,
				'subcategory_id' => null,
				'subsubcategory_id' => null,
			]);
		}

		if ($subSubCategory) {
			$subSubCategory->forceDelete();
		}

		return response()->json([
			'success' => true,
			'message' => 'Sub sub category deleted successfully.',
		]);
	}

	public function forceDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$subSubCategory = SubSubCategory::withTrashed()->findOrFail($id);

			if ($subSubCategory) {
				$subSubCategory->forceDelete();
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Sub sub category/ies deleted successfully.'
		]);
	}
}
