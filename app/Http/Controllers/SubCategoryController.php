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

class SubCategoryController extends Controller
{
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function index(Request $request)
	{
		$items = $request->items ?? 5;
		$subCategories = SubCategory::orderBy('id', 'desc')->paginate($items);
		$trashedSubCategories = SubCategory::onlyTrashed()->count();

		return response()->json([
			'sub_categories' => $subCategories,
			'total_trashed_sub_categories' => $trashedSubCategories,
			'items' => $items,
		], 200);
	}

	public function searchSubCategory($keyword)
	{
		$items = $this->request->items ?? 5;
		$subCategory = SubCategory::where('subcategory_name', 'LIKE', "%{$keyword}%")->paginate($items);
		$trashedSubCategories = SubCategory::onlyTrashed()->count();

		return response()->json([
			'sub_categories' => $subCategory,
			'total_trashed_sub_categories' => $trashedSubCategories,
			'items' => $items,
		], Response::HTTP_OK);
	}

	public function store(Request $request)
	{
		$request->validate([
			'subcategory_name' => 'required',
		], [
			'subcategory_name.required' => 'Input valid sub category name! End with a comma.',
		]);

		$convertString = json_encode($request->get('subcategory_name')); //object to json string conversion $request->get('subcategory_name')
		$dataString = json_decode($convertString); // json string to array
		$subcategories = explode(",", $dataString);

		$totalSubCat = count(array_filter($subcategories));

		foreach ($subcategories as $subcategory) {
			SubCategory::insert([
				'subcategory_name' => $subcategory,
				'subcategory_slug' => strtolower(str_replace(' ', '-', $subcategory)),
			]);
		}

		// Fix invalid slug
		$invalidSlugsId = DB::table('sub_categories')->select('id')->where('subcategory_slug', 'like', '-%')->get();
		$invalidSlugs = DB::table('sub_categories')->select('subcategory_slug')->where('subcategory_slug', 'like', '-%')->pluck('subcategory_slug')->toArray();
		$totalInvalidSlugs = DB::table('sub_categories')->select('id')->where('subcategory_slug', 'like', '-%')->count();

		$validSlugs = array();
		for ($i = 0; $i < count($invalidSlugs); $i++) {
			array_push($validSlugs, Str::substr($invalidSlugs[$i], 1));
		}

		if ($totalInvalidSlugs > 0) {
			foreach ($invalidSlugsId as $index => $invalidSlugId) {
				$data = json_decode(json_encode($invalidSlugId), true);
				SubCategory::findOrFail($data['id'])->update([
					'subcategory_slug' => $validSlugs[$index]
				]);
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Sub category successfully inserted!',
			'total_sub_cat' => $totalSubCat
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'subcategory_name' => 'required',
		], [
			'subcategory_name.required' => 'Input a valid sub category!'
		]);

		SubCategory::findOrFail($id)->update([
			'subcategory_name' => $request->subcategory_name,
			'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
		]);

		return response()->json([
			'success' => true,
			'message' => 'Sub category updated!',
		]);
	}

	public function softDelete($id)
	{
		SubCategory::findOrFail($id)->delete();

		return response()->json([
			'success' => true,
			'message' => 'Sub category has been trashed successfully.',
		]);
	}

	public function softDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$subCategory = SubCategory::findOrFail($id);

			if ($subCategory) {
				$subCategory->delete();
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Sub category/ies has been trashed successfully.'
		]);
	}

	public function trash(Request $request)
	{
		$items = $request->items ?? 5;
		$subCategories = SubCategory::orderBy('id', 'desc')->onlyTrashed()->paginate($items);
		$trashedSubCategories = SubCategory::onlyTrashed()->count();
		$nonTrashed = SubCategory::count();

		return response()->json([
			'sub_categories' => $subCategories,
			'total_trashed_sub_categories' => $trashedSubCategories,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], 200);
	}

	public function searchTrashSubCategory($keyword)
	{
		$items = $this->request->items ?? 5;
		$subCategory = SubCategory::onlyTrashed()->where('subcategory_name', 'LIKE', "%{$keyword}%")->paginate($items);
		$trashedSubCategories = SubCategory::onlyTrashed()->count();

		return response()->json([
			'sub_categories' => $subCategory,
			'total_trashed_sub_categories' => $trashedSubCategories,
			'items' => $items,
		], Response::HTTP_OK);
	}

	public function restore($id)
	{
		$subCategory = SubCategory::withTrashed()->findOrFail($id);

		if ($subCategory->trashed()) {
			$subCategory->restore();
			return response()->json([
				'success' => true,
				'message' => 'Sub category successfully restored.',
			]);
		}
	}

	public function restoreMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		$subCategories = SubCategory::withTrashed()->whereIn('id', $ids);
		$subCategories->restore();
		return response()->json([
			'success' => true,
			'message' => "Sub categories successfully restored"
		]);
	}

	public function forceDeleteSubCategory($id)
	{
		$subCategory = SubCategory::withTrashed()->findOrFail($id);

		$subCatId = $subCategory->id;

		$subSubCat = SubSubCategory::with('subCategory')->withTrashed()
			->WhereHas('subCategory', function ($q) {
				$q->withTrashed();
			})
			->where('subcategory_id', $subCatId);

		if ($subSubCat) {
			$subSubCat->update([
				'category_id' => null,
				'subcategory_id' => null,
			]);
		}

		if ($subCategory) {
			$subCategory->update([
				'category_id' => null,
			]);
		}

		$subCategory->forceDelete();
	}

	public function forceDelete($id)
	{
		$subCategory = SubCategory::withTrashed()->findOrFail($id);

		if ($subCategory) {
			$this->forceDeleteSubCategory($id);

			return response()->json([
				'success' => true,
				'message' => 'Sub category deleted successfully.',
			]);
		}
	}

	public function forceDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$subCategory = SubCategory::withTrashed()->findOrFail($id);

			if ($subCategory) {
				$this->forceDeleteSubCategory($id);
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Sub category deleted successfully.'
		]);
	}
}
