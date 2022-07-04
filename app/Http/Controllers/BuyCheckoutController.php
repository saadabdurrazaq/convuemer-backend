<?php

namespace App\Http\Controllers;

use App\Models\BuyCheckout;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\ProductCombOrder;
use Hash;
use Validator;
use Auth;
use DB;

class BuyCheckoutController extends Controller
{
    public function insertData(Request $request)
    {
        $userId = Auth::user()->id;
        $checkStuff = BuyCheckout::where('user_id', $userId)->get();
        $productId = $request->product_id;
        $prodCombId = $request->product_combination_id;

        if (count($checkStuff) == 0) {
            if ($prodCombId !== '') {
                BuyCheckout::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'product_combination_id' => $prodCombId,
                ]);
            } else {
                BuyCheckout::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
            }

            return response()->json(['success' => 'Product inserted successfully!']);
        } else 
        if (count($checkStuff) > 0) {
            if ($prodCombId !== '') {
                BuyCheckout::where('user_id', $userId)->update([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'product_combination_id' => $prodCombId,
                ]);
            } else {
                BuyCheckout::where('user_id', $userId)->update([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'product_combination_id' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
            ]);
        }
    }

    public function deleteData(Request $request)
    {
        $userId = Auth::user()->id;
        $checkStuff = BuyCheckout::where('user_id', $userId)->get();

        if (count($checkStuff) > 0) {
            BuyCheckout::withTrashed()->where('user_id', $userId)->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
            ]);
        }
    }

    public function getData(Request $request)
    {
        $userId = Auth::user()->id;
        $prodCombId = BuyCheckout::where('user_id', $userId)->value('product_combination_id');
        $productId = BuyCheckout::where('user_id', $userId)->value('product_id');

        if ($prodCombId !== null) {
            $prodComb = ProductCombination::where('id', $prodCombId)->get();

            return response()->json([
                'success' => true,
                'data' => $prodComb,
                'product_combination' => 'yes'
            ]);
        } else {
            $product = Product::where('id', $productId)->get();

            return response()->json([
                'success' => true,
                'data' => $product,
                'product_combination' => 'no'
            ]);
        }
    }

    public function couriers()
    {
        $couriers = [
            ['id' => 'jne', 'text' => 'JNE'],
            ['id' => 'tiki', 'text' => 'TIKI'],
            ['id' => 'pos', 'text' => 'POS'],
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'courier',
            'data' => $couriers
        ], 200);
    }

    protected function getServices($data)
    {
        $url_cost = "https://api.rajaongkir.com/starter/cost";
        $key = "6d5e3d17ee9a7bffb8503a7fe4ffd74b";
        $postdata = http_build_query($data);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url_cost,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => [
                "content-type: application/x-www-form-urlencoded",
                "key: " . $key
            ],
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        return [
            'error' =>  $error,
            'response' =>  $response,
        ];
    }

    public function services(Request $request)
    {
        $status = "error";
        $message = "";
        $data = [];
        $city = $request->city;
        $cityId = $request->city_id;
        $total_quantity = $request->total_quantity;

        // validasi kelengkapan data
        // $this->validate($request, [
        //     'courier' => 'required', 
        //     'product' => 'required',
        // ]);

        $user = Auth::user();

        if ($user !== null) {
            $destination = $city;
            if ($destination !== "") {
                // hardcode
                $origin = 153; // Jakarta Selatan
                $courier = $request->courier;
                $product = $request->product;
                $products = json_decode($product, true);

                // validasi data belanja
                $availStock = 0;
                foreach ($products as $product) {
                    $availStock = $product['available_stock'];
                    if ($product['metric_mass'] == 'G (Gram)') {
                        $weightGram = $product['product_weight'] * $total_quantity;
                        $gramToKg = $weightGram / 1000;
                        $firstNum = strval($gramToKg)[0];
                        $roundNum = floor($gramToKg);
                        foreach (explode(".", $gramToKg) as $row) {
                            $numAfterComma = $row;
                        }
                        $firstNumAfterComma = strval($numAfterComma)[0];

                        if ($firstNum == 0) {
                            $weight = 1;
                        } else {
                            if ($firstNumAfterComma !== '') {
                                if ($firstNumAfterComma <= 2) {
                                    $weight = $roundNum;
                                    $weight = $weight * 1000;
                                } else if ($firstNumAfterComma > 2) {
                                    $weight = $roundNum + 1;
                                    $weight = $weight * 1000;
                                }
                            } else {
                                $weight = $roundNum;
                                $weight = $weight * 1000;
                            }
                        }
                    } else {
                        $weight = ($product['weight'] * $total_quantity) * 1000;
                    }
                }
                // end validasi data belanja

                if ($weight > 0) {
                    // request courier service API RajaOngkir 
                    $parameter = [
                        "origin"        => $origin,
                        "destination"   => $cityId,
                        "weight"        => $weight,
                        "courier"       => $courier
                    ];

                    $respon_services = $this->getServices($parameter);

                    if ($respon_services['error'] == null) {
                        $services = [];
                        $response = json_decode($respon_services['response']);
                        $costs = $response->rajaongkir->results[0]->costs;

                        foreach ($costs as $cost) {
                            $service_name = $cost->service;
                            $service_cost = $cost->cost[0]->value;
                            $service_estimation = str_replace('hari', '', trim($cost->cost[0]->etd));
                            $services[] = [
                                'service' => $service_name,
                                'cost' => $service_cost,
                                'estimation' => $service_estimation,
                                'resume' => $service_name . ' [ Rp. ' . number_format($service_cost) . ', Etd: ' . $cost->cost[0]->etd . ' day(s) ]'
                            ];
                        }

                        // Response
                        if (count($services) > 0) {
                            $data['services'] = $services;
                            $status = "success";
                            $message = "getting services success";
                        } else {
                            $message = "courier services unavailable";
                        }

                        // if ($quantity_different) {
                        //     $status = "warning";
                        //     $message = "Check cart data, " . $message;
                        // }
                    } else {
                        $message = "cURL Error #:" . $respon_services['error'];
                    }
                } else {
                    $message = "weight invalid";
                }
            } else {
                $message = "destination not set";
            }
        } else {
            $message = "user not found";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public function proceed(Request $request)
    {
        $error = 0;
        $status = "error";
        $message = "";
        $data = [];

        $user = Auth::user();
        if ($user) {

            // validasi kelengkapan data
            $this->validate($request, [
                'courier' => 'required',
                'service' => 'required',
                'products' => 'required',
            ]);

            $total = [
                'quantity_before' => 0,
                'quantity'  => 0,
                'price'     => 0,
                'gram_to_kg'  => 0,
                'first_num' => 0,
                'round_num'  => 0,
                'num_after_comma' => 0,
                'weight_gram' => 0,
                'total_weight_gram_to_kg' => 0,
                'total_weight_kg' => 0,
                'weight'    => 0,
            ];

            DB::beginTransaction();
            try {
                // prepare data
                $origin = 153; // Jakarta Selatan
                $destination = $request->city_id;
                if ($destination <= 0) $error++;
                $courier = $request->courier;
                $service = $request->service;
                $products = json_decode($request->products, true);
                $total_quantity = $request->total_quantity;

                // create order
                $order = new Order;
                $order->user_id = $user->id;
                $order->total_bill = 0;
                $order->invoice_number = date('YmdHis');
                $order->courier_service = $courier . '-' . $service;
                $order->total_quantity = $total_quantity;
                $order->status = 'SUBMIT';

                if ($order->save()) {
                    $total_price = 0;
                    $total_weight = 0;

                    // start foreach
                    foreach ($products as $product) {
                        $id = (int) $product['id'];
                        $quantity = $total_quantity;

                        if ($product['product_type'] == 'prod') {
                            $product = Product::find($id);

                            if ($product->available_stock >= $quantity) {
                                // calculate weight
                                $total['price'] += $product->price * $quantity;

                                if ($product->metric_mass == 'G (Gram)') {
                                    $total['weight_gram'] += $product->product_weight * $quantity;
                                    $total['gram_to_kg'] =  $total['weight_gram'] / 1000;
                                    $total['first_num'] = strval($total['gram_to_kg'])[0];
                                    $total['round_num'] = floor($total['gram_to_kg']);
                                    foreach (explode(".", $total['gram_to_kg']) as $row) {
                                        $total['num_after_comma'] = $row;
                                    }
                                    $firstNumAfterComma = strval($total['num_after_comma'])[0];

                                    if ($total['first_num'] == 0) {
                                        $totalWeightGram = 1;
                                        $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                    } else {
                                        if ($firstNumAfterComma !== '') {
                                            if ($firstNumAfterComma <= 2) {
                                                $totalWeightGram = $total['round_num'];
                                                $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                            } else if ($firstNumAfterComma > 2) {
                                                $totalWeightGram = $total['round_num'] + 1;
                                                $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                            }
                                        } else {
                                            $totalWeightGram = $total['round_num'];
                                            $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                        }
                                    }
                                } else {
                                    $total['total_weight_kg'] += $product->weight * $quantity;
                                }
                                $total['weight'] = $total['total_weight_gram_to_kg'] + $total['total_weight_kg'];
                                // end calculate weight

                                $product_order = new ProductOrder;
                                $product_order->product_id = $product->id;
                                $product_order->order_id = $order->id;
                                $product_order->quantity = $quantity;

                                if ($product_order->save()) {
                                    $product->available_stock = $product->available_stock - $quantity;
                                    $product->save();
                                }
                            } else {
                                $error++;
                                throw new \Exception('Out of stock');
                            }
                        } else if ($product['product_type'] == 'prod-comb') {
                            $prodCom = ProductCombination::find($id);
                            if ($prodCom->available_stock >= $quantity) {
                                // calculate weight
                                $total['price'] += $prodCom->price * $quantity;
                                if ($prodCom->metric_mass == 'G (Gram)') {
                                    $total['weight_gram'] += $prodCom->product_weight * $quantity;
                                    $total['gram_to_kg'] =  $total['weight_gram'] / 1000;
                                    $total['first_num'] = strval($total['gram_to_kg'])[0];
                                    $total['round_num'] = floor($total['gram_to_kg']);
                                    foreach (explode(".", $total['gram_to_kg']) as $row) {
                                        $total['num_after_comma'] = $row;
                                    }
                                    $firstNumAfterCommaProdComb = strval($total['num_after_comma'])[0];

                                    if ($total['first_num'] == 0) {
                                        $totalWeightGram = 1;
                                        $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                    } else {
                                        if ($firstNumAfterCommaProdComb !== '') {
                                            if ($firstNumAfterCommaProdComb <= 2) {
                                                $totalWeightGram = $total['round_num'];
                                                $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                            } else if ($firstNumAfterCommaProdComb > 2) {
                                                $totalWeightGram = $total['round_num'] + 1;
                                                $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                            }
                                        } else {
                                            $totalWeightGram = $total['round_num'];
                                            $total['total_weight_gram_to_kg'] = $totalWeightGram;
                                        }
                                    }
                                } else {
                                    $total['total_weight_kg'] += $prodCom->weight * $quantity;
                                }
                                $total['weight'] = $total['total_weight_gram_to_kg'] + $total['total_weight_kg'];
                                // end calculate weight

                                $prodCom_order = new ProductCombOrder;
                                $prodCom_order->product_combination_id = $prodCom->id;
                                $prodCom_order->order_id = $order->id;
                                $prodCom_order->quantity = $quantity;

                                if ($prodCom_order->save()) {
                                    $prodCom->available_stock = $prodCom->available_stock - $quantity;
                                    $prodCom->save();
                                }
                            } else {
                                $error++;
                                throw new \Exception('Out of stock');
                            }
                        } else {
                            $error++;
                            throw new \Exception('Product is not found');
                        }
                    }
                    // end foreach

                    $totalBill = 0;
                    $weight = $total['weight'] * 1000;
                    if ($weight <= 0) {
                        $error++;
                        throw new \Exception('Weight null');
                    }
                    $data = [
                        "origin"        => $origin,
                        "destination"   => $destination,
                        "weight"        => $weight,
                        "courier"       => $courier
                    ];
                    $data_cost = $this->getServices($data);
                    if ($data_cost['error']) {
                        $error++;
                        throw new \Exception('Courier service unavailable');
                    }

                    $response = json_decode($data_cost['response']);
                    $costs = $response->rajaongkir->results[0]->costs;
                    $service_cost = 0;
                    foreach ($costs as $cost) {
                        $service_name = $cost->service;
                        if ($service == $service_name) {
                            $service_cost = $cost->cost[0]->value;
                            break;
                        }
                    }
                    if ($service_cost <= 0) {
                        $error++;
                        throw new \Exception('Service cost invalid');
                    }

                    $total_bill = $total['price'] + $service_cost;

                    // update total bill order
                    $order->total_bill = $total_bill;
                    if ($order->save()) {
                        if ($error == 0) {
                            DB::commit();
                            $status = 'success';
                            $message = 'Transaction success';
                            $data = [
                                'order_id' => $order->id,
                                'total_bill' => $total_bill,
                                'invoice_number' => $order->invoice_number,
                            ];
                        } else {
                            $message = 'There are ' . $error . ' errors';
                        }
                    }
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
                DB::rollback();
            }
        } else {
            $message = "User not found";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], 200);
    }
}
