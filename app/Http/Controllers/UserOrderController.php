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

class UserOrderController extends Controller
{
    public function myOrder(Request $request)  
    {
        $user = Auth::user();
        $status = "error";
        $message = "";
        $data = [];
        $items = $request->items ?? 5;

        if ($user) {
            $orders = Order::with('products')->with('variantsProd')->where('user_id', '=', $user->id)
                ->orderBy('id','DESC')
                ->get();

            $status = "success";
            $message = "data my order ";
            $data = $orders;
        }
        else {
            $message = "User not found";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'items' => $items,
        ], 200);
    }
}
