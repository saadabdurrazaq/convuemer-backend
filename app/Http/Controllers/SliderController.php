<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Image;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use DB;

class SliderController extends Controller 
{
	public $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function index(Request $request)
	{
		$items = $request->items ?? 5;
		$sliders = Slider::orderBy('id', 'desc')->paginate($items);
		$trashedSliders = Slider::onlyTrashed()->count();

		return response()->json([
			'sliders' => $sliders,
			'total_trashed_sliders' => $trashedSliders,
			'items' => $items,
		], 200);
	}

	public function show(Request $request)
	{
		$items = $request->items ?? 5;
		$sliders = Slider::where('status', 'Active')->orderBy('id', 'desc')->paginate($items);
		$trashedSliders = Slider::onlyTrashed()->count();

		return response()->json([
			'sliders' => $sliders,
			'total_trashed_sliders' => $trashedSliders,
			'items' => $items,
		], 200);
	}

	public function updateStatus($id)
	{
		$status =  $this->request->get('status');

		$prod = Slider::where('id', $id);
		$prod->update(['status' => $status]);

		return response()->json([
			'success' => true,
			'message' => 'Product status succesfully updated!',
		]);
	}

	public function searchSlider($keyword)
	{
		$items = $this->request->items ?? 5;
		$sliders = Slider::where('title', 'LIKE', "%{$keyword}%")->paginate($items);
		$trashedSliders = Slider::onlyTrashed()->count();

		return response()->json([
			'sliders' => $sliders,
			'total_trashed_sliders' => $trashedSliders,
			'items' => $items,
		], Response::HTTP_OK);
	}

	public function store(Request $request)
	{
		$request->validate([
			'slider_header'  => 'required',
			'title' => 'required',
			'description' => 'required',
			'button_text' => 'required',
			'link' => 'required',
			'slider_image' => 'required',
		], [
			'title.required' => 'Input a valid slider!',
			'slider_image.required' => 'Input a valid image slider!',
		]);

		$image = $request->file('slider_image');
		$name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
		Image::make($image)->save('storage/app/public/sliders/' . $name_gen);
		$save_url = $name_gen;

		return Slider::create([
			'slider_header' => $request['slider_header'],
			'title' => $request['title'],
			'description' => $request['description'],
			'button_text' => $request['button_text'],
			'link' => $request['link'],
			'status' => 'Inactive',
			'slider_image' => $save_url,
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'slider_header'  => 'required',
			'title' => 'required',
			'description' => 'required',
			'button_text' => 'required',
			'link' => 'required',
		], [
			'title.required' => 'Input a valid slider!'
		]);

		if ($request->slider_image > 0) {
			$old_img = DB::table('sliders')->select('slider_image')->where('id', $id)->pluck('slider_image')->toArray();
			if ($old_img[0] !== null) {
				$storedImage = storage_path('app\\public\\sliders\\' . $old_img[0]);
				if (file_exists($storedImage)) {
					unlink($storedImage);
				} else {
					Slider::findOrFail($id)->update([
						'slider_image' => null,
					]);
				}
			}

			$image = $request->file('slider_image');
			$name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
			Image::make($image)->save('storage/app/public/sliders/' . $name_gen);
			$save_url = $name_gen;

			Slider::findOrFail($id)->update([
				'slider_header' => $request['slider_header'],
				'title' => $request['title'],
				'description' => $request['description'],
				'button_text' => $request['button_text'],
				'link' => $request['link'],
				'slider_image' => $save_url,
			]);

			return response()->json([
				'success' => true,
				'message' => 'Slider updated!',
			]);
		} else {

			Slider::findOrFail($id)->update([
				'slider_header' => $request['slider_header'],
				'title' => $request['title'],
				'description' => $request['description'],
				'button_text' => $request['button_text'],
				'link' => $request['link'],
			]);

			return response()->json([
				'success' => true,
				'message' => 'Slider updated!',
			]);
		}
	}

	public function softDeleteSlider($id)
	{
		$slider = Slider::findOrFail($id);
		$slider->delete();
	}

	public function softDelete($id)
	{
		$slider = Slider::findOrFail($id);

		if ($slider) {
			$this->softDeleteSlider($id);
			return response()->json([
				'success' => true,
				'message' => 'Slider trashed successfully.',
			]);
		}
	}

	public function softDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$slider = Slider::findOrFail($id);

			if ($slider) {
				$this->softDeleteSlider($id);
			}
		}

		return response()->json(['success' => 'Slider trashed successfully.']);
	}

	public function forceDeleteSlider($id)
	{
		$slider = Slider::withTrashed()->findOrFail($id);

		$old_img = DB::table('sliders')->select('slider_image')->where('id', $id)->pluck('slider_image')->toArray();
		if ($old_img[0] !== null) {
			$storedImage = storage_path('app\\public\\sliders\\' . $old_img[0]);
			if (file_exists($storedImage)) {
				unlink($storedImage);
			}
		}

		$slider->forceDelete();
	}

	public function forceDelete($id)
	{
		$slider = Slider::withTrashed()->findOrFail($id);

		if ($slider) {
			$this->forceDeleteSlider($id);
			return response()->json([
				'success' => true,
				'message' => 'Slider deleted successfully.',
			]);
		}
	}

	public function forceDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$slider = Slider::withTrashed()->findOrFail($id);

			if ($slider) {
				$this->forceDeleteSlider($id);
			}
		}

		return response()->json(['success' => 'Slider deleted successfully.']);
	}

	public function trash(Request $request)
	{
		$items = $request->items ?? 5;
		$sliders = Slider::orderBy('id', 'desc')->onlyTrashed()->paginate($items);
		$trashedSliders = Slider::onlyTrashed()->count();
		$nonTrashed = Slider::count();

		return response()->json([
			'sliders' => $sliders,
			'total_trashed_sliders' => $trashedSliders,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], 200);
	}

	public function searchTrashSlider($keyword)
	{
		$items = $this->request->items ?? 5;
		$slider = Slider::onlyTrashed()->where('title', 'LIKE', "%{$keyword}%")->paginate($items);
		$trashedSliders = Slider::onlyTrashed()->count();
		$nonTrashed = Slider::count();

		return response()->json([
			'sliders' => $slider,
			'total_trashed_sliders' => $trashedSliders,
			'items' => $items,
			'non_trashed' => $nonTrashed,
		], Response::HTTP_OK);
	}

	public function restore($id)
	{
		$slider = Slider::withTrashed()->findOrFail($id);

		if ($slider->trashed()) {
			$slider->restore();
			return response()->json([
				'success' => true,
				'message' => 'Slider successfully restored.',
			]);
		}
	}

	public function restoreMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		$sliders = Slider::withTrashed()->whereIn('id', $ids);
		$sliders->restore();
		return response()->json(['success' => "Sliders successfully restored"]);
	}
}
