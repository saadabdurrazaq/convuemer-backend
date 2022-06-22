<?php

namespace App\Http\Controllers;

use App\Models\BuyCheckout;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Staff;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Order;
use Hash;
use Validator;
use Auth;
use DB;

class AllOrderController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->items ?? 5;

        $orders = Order::with('user')
            ->with('products')
            ->with('variantsProd')
            ->orderBy('id', 'desc')
            ->paginate($items);

        $trashedOrders = Order::onlyTrashed()->count();

        return response()->json([
            'orders' => $orders,
            'total_trashed_data' => $trashedOrders,
            'items' => $items,
        ], 200);
    }

    public function searchData($keyword) 
	{
		$items = $this->request->items ?? 5; 
		$orders = Order::with('user')
        ->with('products')
        ->with('variantsProd')->where('invoice_number', 'LIKE', "%{$keyword}%")->paginate($items);

		return response()->json([
			'orders' => $orders,
			'items' => $items,
		], Response::HTTP_OK);
	}

    public function edit(Request $request, $id)
    {
        $order = Order::with('user')->with('products')->with('variantsProd')->where('id', '=', $id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $order
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id); 
    }

    public function forceDeleteOrder($id)
	{
		$order = Order::withTrashed()->findOrFail($id);
		$orderProduct = DB::table('order_product')->where('order_id', $id);
        $orderProductCombination = DB::table('order_product_combination')->where('order_id', $id);

        if ($orderProduct) {
            $order->products()->detach();
        }

        if ($orderProductCombination) {
            $order->variantsProd()->detach();
        }

        if ($order) {
            $order->forceDelete();
        }

	}

	public function forceDelete($id)
	{
		$order = Order::withTrashed()->findOrFail($id);

		if ($order) {
			$this->forceDeleteOrder($id);
			return response()->json([
				'success' => true,
				'message' => 'Order deleted successfully.',
			]);
		}
	}

	public function forceDeleteMultiple(Request $request)
	{
		$get_ids = $request->ids;
		$ids = explode(',', $get_ids);

		// precess request one by one
		foreach ($ids as $id) {
			$order = Order::withTrashed()->findOrFail($id);

			if ($order) {
				$this->forceDeleteOrder($id);
			}
		}

		return response()->json(['success' => 'Order deleted successfully.']);
	}
}
