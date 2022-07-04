<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use Image;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use DB;

class BrandController extends Controller
{
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;

		$this->middleware('permission:View Brands', ['only' => ['index']]);
		$this->middleware('permission:Create Brand', ['only' => ['store']]);
		$this->middleware('permission:Update Brand', ['only' => ['update']]);
		$this->middleware('permission:Delete Brand', ['only' => ['softDelete', 'softDeleteMultiple', 'forceDelete', 'forceDeleteMultiple', 'forceDeleteBrand', 'softDeleteBrand']]);
	}

	public function index(Request $request)
	{
		$items = $request->items ?? 5;
		$brands = Brand::orderBy('id', 'desc')->paginate($items);
		$trashedBrand = Brand::onlyTrashed()->count();

		return response()->json([
			'brands' => $brands,
			'total_trashed_brand' => $trashedBrand,
			'items' => $items,
		], 200);
	}

	public function searchBrand($keyword)
	{
		$items = $this->request->items ?? 5;
		$brands = Brand::where('brand_name', 'LIKE', "%{$keyword}%")->paginate($items);
		$trashedBrand = Brand::onlyTrashed()->count();

		return response()->json([
			'brands' => $brands,
			'total_trashed_brand' => $trashedBrand,
			'items' => $items,
		], Response::HTTP_OK);
	}

	public function store(Request $request)
	{
		$request->validate([
			'brand_name' => 'required',
			'brand_image' => 'required',
		], [
			'brand_name.required' => 'Input a valid brand!',
			'brand_image.required' => 'Input a valid image brand!',
		]);

		$image = $request->file('brand_image');
		$name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
		Image::make($image)->resize(300, 300)->save('storage/app/public/brands/' . $name_gen);
		$save_url = $name_gen;

		return Brand::create([
			'brand_name' => $request['brand_name'],
			'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
			'brand_image' => $save_url,
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'brand_name' => 'required',
		], [
			'brand_name.required' => 'Input a valid brand!'
		]);

		if ($request->brand_image > 0) {

			$old_img = DB::table('brands')->select('brand_image')->where('id', $id)->pluck('brand_image')->toArray();
			if ($old_img[0] !== null) {
				$storedImage = storage_path('app\\public\\brands\\' . $old_img[0]);
				if (file_exists($storedImage)) {
					unlink($storedImage);
				} else {
					Brand::findOrFail($id)->update([
						'brand_image' => null,
					]);
				}
			}

			$image = $request->file('brand_image');
			$name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
			Image::make($image)->resize(300, 300)->save('storage/app/public/brands/' . $name_gen);
			$save_url = $name_gen;

			Brand::findOrFail($id)->update([
				'brand_name' => $request['brand_name'],
				'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
				'brand_image' => $save_url,
			]);

			return response()->json([
				'success' => true,
				'message' => 'Brand updated!',
			]);
		} else {

			Brand::findOrFail($id)->update([
				'brand_name' => $request['brand_name'],
				'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
			]);

			return response()->json([
				'success' => true,
				'message' => 'Brand updated!',
			]);
		}
	}

	public function softDeleteBrand($id)
	{
		$brand = Brand::findOrFail($id);
		$brand->delete();
	}

	public function softDelete($id)
	{
		$brand = Brand::findOrFail($id);

		if ($brand) {
			$this->softDeleteBrand($id);
			return response()->json([
				'success' => true,
				'message' => 'Brand trashed successfully.',
			]);
		}
	}

	public function softDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$brand = Brand::findOrFail($id);

			if ($brand) {
				$this->softDeleteBrand($id);
			}
		}

		return response()->json(['success' => 'Brand trashed successfully.']);
	}

	public function forceDeleteBrand($id)
	{
		$brand = Brand::withTrashed()->findOrFail($id);
		$product = Product::withTrashed()->where('brand_id', $id);

		$product->update([
			'brand_id' => null,
		]);

		$old_img = DB::table('brands')->select('brand_image')->where('id', $id)->pluck('brand_image')->toArray();
		if ($old_img[0] !== null) {
			$storedImage = storage_path('app\\public\\brands\\' . $old_img[0]);
			if (file_exists($storedImage)) {
				unlink($storedImage);
			}
		}

		$brand->forceDelete();
	}

	public function forceDelete($id)
	{
		$brand = Brand::withTrashed()->findOrFail($id);

		if ($brand) {
			$this->forceDeleteBrand($id);
			return response()->json([
				'success' => true,
				'message' => 'Brand deleted successfully.',
			]);
		}
	}

	public function forceDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$brand = Brand::withTrashed()->findOrFail($id);

			if ($brand) {
				$this->forceDeleteBrand($id);
			}
		}

		return response()->json(['success' => 'Brand deleted successfully.']);
	}

	public function trash(Request $request)
	{
		$items = $request->items ?? 5;
		$brands = Brand::orderBy('id', 'desc')->onlyTrashed()->paginate($items);
		$trashedBrand = Brand::onlyTrashed()->count();
		$nonTrashed = Brand::count();

		return response()->json([
			'brands' => $brands,
			'total_trashed_brand' => $trashedBrand,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], 200);
	}

	public function searchTrashBrand($keyword)
	{
		$items = $this->request->items ?? 5;
		$brand = Brand::onlyTrashed()->where('brand_name', 'LIKE', "%{$keyword}%")->paginate($items);
		$trashedBrand = Brand::onlyTrashed()->count();
		$nonTrashed = Brand::count();

		return response()->json([
			'brands' => $brand,
			'total_trashed_brand' => $trashedBrand,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], Response::HTTP_OK);
	}

	public function restore($id)
	{
		$brand = Brand::withTrashed()->findOrFail($id);

		if ($brand->trashed()) {
			$brand->restore();
			return response()->json([
				'success' => true,
				'message' => 'Brand successfully restored.',
			]);
		}
	}

	public function restoreMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		$brands = Brand::withTrashed()->whereIn('id', $ids);
		$brands->restore();
		return response()->json(['success' => "Brands successfully restored"]);
	}
}
