<?php

namespace App\Http\Controllers;

use App\Models\BuyCheckout;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Order;
use Hash;
use Validator;
use Auth;

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
}
