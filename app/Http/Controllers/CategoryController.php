<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class CategoryController extends Controller  
{
	public $request; 

	public function __construct(Request $request) 
	{
		$this->request = $request;

		$this->middleware('permission:View Categories', ['only' => ['index']]);  
        $this->middleware('permission:Create Category', ['only' => ['store']]);
        $this->middleware('permission:Update Category', ['only' => ['update', 'assignSubCat', 'assignSubSubCat']]);
        $this->middleware('permission:Delete Category', ['only' => ['softDelete', 'softDeleteMultiple', 'forceDelete', 'forceDeleteMultiple', 'forceDeleteCategory']]);

	}

	public function index(Request $request)
	{
		$items = $request->items ?? 5;
		$trashedCategories = Category::onlyTrashed()->count();
		$categories = Category::with('subCategory.subSubCategory')->orderBy('id', 'desc')->paginate($items);

		return response()->json([
			'categories' => $categories,
			'total_trashed_categories' => $trashedCategories,
			'items' => $items,
		], 200);
	}

	public function store(Request $request)
	{
		$request->validate([
			'category_name' => 'required',
			'category_icon' => 'required',
		], [
			'category_name.required' => 'Input category name with valid format!',
			'category_icon.required' => 'Input category icon with valid format!',
		]);

		$objectCategoryNames = json_encode($request->get('category_name')); //object to json string conversion $request->get('subcategory_name')
		$stringCategoryNames = json_decode($objectCategoryNames); // json string to array
		$categoryNames = explode(",", $stringCategoryNames);

		$objectCategoryIcons = json_encode($request->get('category_icon')); //object to json string conversion $request->get('subcategory_name')
		$stringCategoryIcons = json_decode($objectCategoryIcons); // json string to array
		$categoryIcons = explode(",", $stringCategoryIcons);

		$totalCategoryNames = count(array_filter($categoryNames));
		$totalCategoryIcons = count(array_filter($categoryIcons));

		if ($totalCategoryNames == $totalCategoryIcons) {
			foreach ($categoryNames as $index => $categoryName) {
				Category::insert([
					'category_name' => $categoryName,
					'category_icon' => $categoryIcons[$index],
					'category_slug' => strtolower(str_replace(' ', '-', $categoryName)),
				]);
			}

			// Fix invalid slug
			$invalidSlugsId = DB::table('categories')->select('id')->where('category_slug', 'like', '-%')->get();
			$invalidSlugs = DB::table('categories')->select('category_slug')->where('category_slug', 'like', '-%')->pluck('category_slug')->toArray();
			$totalInvalidSlugs = DB::table('categories')->select('id')->where('category_slug', 'like', '-%')->count();

			$validSlugs = array();
			for ($i = 0; $i < count($invalidSlugs); $i++) {
				array_push($validSlugs, Str::substr($invalidSlugs[$i], 1));
			}

			if ($totalInvalidSlugs > 0) {
				foreach ($invalidSlugsId as $index => $invalidSlugId) {
					$data = json_decode(json_encode($invalidSlugId), true);
					Category::findOrFail($data['id'])->update([
						'category_slug' => $validSlugs[$index]
					]);
				}
			}

			return response()->json([
				'success' => true,
				'message' => 'Category(ies) successfully inserted!',
				'total_category_names' => $totalCategoryNames,
				'total_category_icons' => $totalCategoryIcons
			]);
		} else {
			return response()->json([
				'message' => 'Failed to insert data!',
				'total_category_names' => $totalCategoryNames,
				'total_category_icons' => $totalCategoryIcons
			]);
		}
	}

	public function searchCatAndSubCat($keyword)
	{
		$items = $this->request->items ?? 5;
		$trashedCategories = Category::onlyTrashed()->count();
		$totalCategories = Category::with('subCategory.subSubCategory')->where('category_name', 'LIKE', "%{$keyword}%")->get();

		// If user search by category keyword, and data is found
		if (count($totalCategories) > 0) {
			$category = Category::with('subCategory.subSubCategory')->where('category_name', 'LIKE', "%{$keyword}%")->paginate($items);

			return response()->json([
				'categories' => $category,
				'total_trashed_categories' => $trashedCategories,
				'items' => $items,
			], Response::HTTP_OK);
		} else 
		if (count($totalCategories) == 0) { // if data of category keyword is not found, then search by subcategory keyword
			$subCat = Category::with('subCategory.subSubCategory')->OrWhereHas('subCategory', function ($q) use ($keyword) {
				$q->where('subcategory_name', 'LIKE', "%{$keyword}%");
			})->paginate($items);

			return response()->json([
				'categories' => $subCat,
				'total_trashed_categories' => $trashedCategories,
				'items' => $items,
			], Response::HTTP_OK);
		}
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'category_name' => 'required',
			'category_icon' => 'required',
		], [
			'category_name.required' => 'Input a valid category!',
			'category_icon.required' => 'Input a valid font awesome icon!'
		]);

		Category::findOrFail($id)->update([
			'category_name' => $request->category_name,
			'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
			'category_icon' => $request->category_icon,
		]);

		return response()->json([
			'success' => true,
			'message' => 'Category updated!',
		]);
	}

	public function loadSubCategories(Request $request, $id)
	{
		$keyword = $request->get('q');

		$subCatHasCat = SubCategory::with('category')
			->OrWhereHas('category', function ($q) use ($id) {
				$q->where('id', $id);
			})->get();

		if ($subCatHasCat) {
			$subCategories = SubCategory::with('category')
				->OrWhereHas('category', function ($q) use ($id) { 
					$q->where('id', $id);
				})
				->orWhereDoesntHave('category')
				->where("subcategory_name", "LIKE", "%$keyword%")->get();

			return $subCategories;
		} else {
			$subCategories = SubCategory::with('category')
				->orWhereDoesntHave('category')
				->where("subcategory_name", "LIKE", "%$keyword%")->get();

			return $subCategories;
		}
	}

	public function loadSubSubCat(Request $request, $id)
	{
		$keyword = $request->get('q');

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
			$subSubCategories = SubSubCategory::with('subCategory')
				->orWhereDoesntHave('subCategory')
				->where("subsubcategory_name", "LIKE", "%$keyword%")->get();

			return $subSubCategories;
		}
	}

	public function getSubCategories($id) // fill sub category input when single assign modal is opened. 
	{
		$category = Category::find($id);

		// fill the input column with these data
		$subCategories = SubCategory::whereHas('category', function ($q) use ($id) {
			$q->where('id', $id);
		})->get();

		$totalSubCategories = SubCategory::whereHas('category', function ($q) use ($id) {
			$q->where('id', $id);
		})->count();

		return response()->json([
			'success' => true,
			'category' => $category,
			'sub_categories' => $subCategories,
			'total_sub_categories' => $totalSubCategories
		]);
	}

	public function getCatAndSubSubCat($id) // fill category input and sub sub category input in assign/unassign sub sub cat
	{
		$catAndSubCat = SubCategory::with(['category' => function ($query) {
			$query->withTrashed();
		}])
			->with('subSubCategory')
			->where('id', $id)->get();

		return response()->json([
			'success' => true,
			'sub_category' => $catAndSubCat,
		]);
	}

	public function doAssignSubCat()
	{
		$this->request->validate([
			'sub_categories' => ['required'],
		], [
			'sub_categories.required' => 'Select an available sub categories!',
		]);

		$categoryId = $this->request->get('id');
		$subCategoriesId = $this->request->get('sub_categories');

		if (is_string($subCategoriesId)) {

			// if string contain space
			if (strpos($subCategoriesId, ' ')) {
				$removeSpaceInSubCatId = str_replace(' ', '', $subCategoriesId); // remove space
				$subCategoriesIdArr = explode(',', $removeSpaceInSubCatId); // convert string to array
			} else {
				$subCategoriesIdArr = explode(',', $subCategoriesId);
			}

			$subCategoriesId = array_values(array_filter($subCategoriesIdArr)); // remove the last index if the value is empty
		}

		// Compare sub category preset value with sub category value that user change in sub categories select2 input
		// And then get the sub category id that not exist in sub categories select2 input.
		$getSubCatIdHasAssigned = SubCategory::select('id')->whereHas('category', function ($q)  use ($categoryId) {
			$q->where('id', $categoryId);
		})->get();

		$convertSubCatIdHasAssigned = json_encode($getSubCatIdHasAssigned); // string with [{id:""}] character
		$getOnlySubCatId = preg_replace('/[^0-9,]/', '', $convertSubCatIdHasAssigned); // get only id and comma without those character.
		$subCatIdHasAssigned  = explode(",", $getOnlySubCatId); //  array

		$removeSubCatId = array_diff($subCatIdHasAssigned, $subCategoriesId); // using array_diff(A,B), it returns all values from A, which are not values of B

		// Remove all relationship of sub category that not exist in sub categories select2 input.
		if ($removeSubCatId) {

			$removeSubSubCat = SubSubCategory::with('subCategory')->WhereHas('subCategory', function ($q) use ($removeSubCatId) {
				$q->whereIn('id', $removeSubCatId);
			});

			$removeSubSubCat->update([
				'category_id' => null,
				'subcategory_id' => null,
			]);

			$removeSubCat = SubCategory::with('category')->WhereHas('category', function ($q) use ($categoryId) {
				$q->where('id', $categoryId);
			});

			$removeSubCat->update([
				'category_id' => null,
			]);
		}

		// Reassign all new relationship data that have been inputted. 
		$assignSubCategories = SubCategory::whereIn('id', $subCategoriesId);
		$assignSubCategories->update(['category_id' => $categoryId]);
	}

	public function assignSubCat()
	{
		$checkBoxChecked = $this->request->get('unassign');
		$catId = $this->request->get('id');

		if (empty($checkBoxChecked)) {
			$this->doAssignSubCat();
		} else 
		if ($checkBoxChecked[0] == 'unassign') {
			$removeSubSubCat = SubSubCategory::with('category')->WhereHas('category', function ($q) use ($catId) {
				$q->where('id', $catId);
			});

			$removeSubSubCat->update([
				'category_id' => null,
				'subcategory_id' => null,
			]);

			$removeSubCat = SubCategory::with('category')->WhereHas('category', function ($q) use ($catId) {
				$q->where('id', $catId);
			});

			$removeSubCat->update([
				'category_id' => null,
			]);
		}

		return response()->json([
			'success' => true,
			'message' => 'Categories assigned successfully!',
		]);
	}

	public function doAssignSubSubCat()
	{
		$this->request->validate([
			'sub_sub_categories' => ['required'],
		], [
			'sub_sub_categories.required' => 'Select an available sub sub categories!',
		]);

		$categoryId = $this->request->get('category_id');
		$subCatId = $this->request->get('id');
		$subSubCategoriesId = $this->request->get('sub_sub_categories');

		if (is_string($subSubCategoriesId)) {

			// if string contain space
			if (strpos($subSubCategoriesId, ' ')) {
				$removeSpaceInSubCatId = str_replace(' ', '', $subSubCategoriesId); // remove space
				$subSubCategoriesIdArr = explode(',', $removeSpaceInSubCatId); // convert string to array
			} else {
				$subSubCategoriesIdArr = explode(',', $subSubCategoriesId);
			}

			$subSubCategoriesId = array_values(array_filter($subSubCategoriesIdArr)); // remove the last index if the value is empty
		}

		$getSubSubCatIdHasAssigned = SubSubCategory::select('id')->whereHas('subCategory', function ($q)  use ($subCatId) {
			$q->where('id', $subCatId);
		})->get();

		$convertSubSubCatIdHasAssigned = json_encode($getSubSubCatIdHasAssigned); // string with [{id:""}] character
		$getOnlySubSubCatId = preg_replace('/[^0-9,]/', '', $convertSubSubCatIdHasAssigned); // get only id and comma without those character.
		$subSubCatIdHasAssigned  = explode(",", $getOnlySubSubCatId); //  array

		$removeSubSubCatId = array_diff($subSubCatIdHasAssigned, $subSubCategoriesId); // using array_diff(A,B), it returns all values from A, which are not values of B

		if ($removeSubSubCatId) {
			$removeSubSubCat = SubSubCategory::whereIn('id', $removeSubSubCatId);

			$removeSubSubCat->update([
				'category_id' => null,
				'subcategory_id' => null,
			]);
		}

		// Reassign all new relationship data that have been inputted. 
		$assignSubSubCategories = SubSubCategory::whereIn('id', $subSubCategoriesId);
		$assignSubSubCategories->update([
			'category_id' => $categoryId,
			'subcategory_id' => $subCatId
		]);
	}

	public function assignSubSubCat()
	{
		$checkBoxChecked = $this->request->get('unassign_subsubcat');
		$subCatId = $this->request->get('id');

		if (empty($checkBoxChecked)) {
			$this->doAssignSubSubCat();
		} else 
		if ($checkBoxChecked[0] == 'unassign-subsubcat') { // problem here

			$removeSubSubCat = SubSubCategory::WhereHas('subCategory', function ($q) use ($subCatId) {
				$q->where('id', $subCatId);
			});

			if ($removeSubSubCat) {
				$removeSubSubCat->update([
					'category_id' => null,
					'subcategory_id' => null,
				]);
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Setting is successfully saved!',
		]);
	}

	public function softDelete($id)
	{
		Category::findOrFail($id)->delete();

		return response()->json([
			'success' => true,
			'message' => 'Category is successfully trashed!',
		]);
	}

	public function softDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$categories = Category::findOrFail($id);

			if ($categories) {
				$categories->delete();
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Category/ies trashed successfully.'
		]);
	}

	public function trash(Request $request)
	{
		$items = $request->items ?? 5;
		$trashedCategories = Category::onlyTrashed()->count();
		$categories = Category::with('subCategory.subSubCategory')->onlyTrashed()->orderBy('id', 'desc')->paginate($items);
		$nonTrashed = Category::count();

		return response()->json([
			'categories' => $categories,
			'total_trashed_categories' => $trashedCategories,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], 200);
	}

	public function searchTrashCatAndSubCat($keyword)
	{
		$items = $this->request->items ?? 5;
		$totalTrashedCategories = Category::with('subCategory.subSubCategory')->onlyTrashed()->where('category_name', 'LIKE', "%{$keyword}%")->get();
		$trashedCategories = Category::onlyTrashed()->count();
		$nonTrashed = Category::count();

		if (count($totalTrashedCategories) > 0) {
			$category = Category::with('subCategory.subSubCategory')->onlyTrashed()->where('category_name', 'LIKE', "%{$keyword}%")->paginate($items);

			return response()->json([
				'categories' => $category,
				'total_trashed_categories' => $trashedCategories,
				'non_trashed' => $nonTrashed,
				'items' => $items,
			], Response::HTTP_OK);
		} else 
		if (count($totalTrashedCategories) == 0) {

			$subCat = Category::with('subCategory.subSubCategory')->OrWhereHas('subCategory', function ($q) use ($keyword) {
				$q->where('subcategory_name', 'LIKE', "%{$keyword}%");
			})->onlyTrashed()->paginate($items);

			return response()->json([
				'categories' => $subCat,
				'total_trashed_categories' => $trashedCategories,
				'non_trashed' => $nonTrashed,
				'items' => $items,
			], Response::HTTP_OK);
		}
	}

	public function restore($id)
	{
		$category = Category::withTrashed()->findOrFail($id);

		if ($category->trashed()) {
			$category->restore();
			return response()->json([
				'success' => true,
				'message' => 'Category successfully restored.',
			]);
		}
	}

	public function restoreMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		$categories = Category::withTrashed()->whereIn('id', $ids);
		$categories->restore();

		return response()->json([
			'success' => true,
			'message' => "Categories successfully restored"
		]);
	}

	public function forceDeleteCategory($id)
	{
		$category = Category::withTrashed()->findOrFail($id);

		$catId = $category->id;

		$subSubCat = SubSubCategory::with('category')->withTrashed()
			->WhereHas('category', function ($q) {
				$q->withTrashed();
			})
			->where('category_id', $catId);

		if ($subSubCat) {
			$subSubCat->update([
				'category_id' => null,
				'subcategory_id' => null,
			]);
		}

		$subCat = SubCategory::with('category')->withTrashed()->WhereHas('category', function ($q) use ($catId) {
			$q->withTrashed()->where('id', $catId);
		});

		if ($subCat) {
			$subCat->update([
				'category_id' => null,
			]);
		}

		$category->forceDelete();
	}

	public function forceDelete($id)
	{
		$category = Category::withTrashed()->findOrFail($id);

		if ($category) {
			$this->forceDeleteCategory($id);

			return response()->json([
				'success' => true,
				'message' => 'Category deleted successfully.',
			]);
		}
	}

	public function forceDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$cat = Category::withTrashed()->findOrFail($id);

			if ($cat) {
				$this->forceDeleteCategory($id);
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Category deleted successfully.'
		]);
	}
}
