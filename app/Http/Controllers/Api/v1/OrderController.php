<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Order::with(['orderTransaction.paymentMethod', 'orderTransaction.createdBy', 'orderTracking.tracking', 'createdBy', 'customer', 'printType'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => OrderResource::collection($data)
        ], 200);
    }

    public function getByOrder(Request $request, $order)
    {
        $data = Order::where('order_number', $order)->with(['orderTransaction', 'orderTracking.tracking', 'createdBy', 'customer', 'printType'])->get();
        // dd($data);
        // $data = Order::with(['orderTransaction', 'user', 'customer', 'printType'])->latest()->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => OrderResource::collection($data)
        ], 200);
        // return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required',
            'user_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'print_type_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'total' => 'required|numeric',
            'discount' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'name' => 'required',
            'description' => 'required',
            'order_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = Order::create([
            'order_number' => $request->order_number,
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'print_type_id' => $request->print_type_id,
            'qty' => $request->qty,
            'price' => $request->price,
            'total' => $request->total,
            'discount' => $request->discount,
            'subtotal' => $request->subtotal,
            'name' => $request->name,
            'description' => $request->description,
            'order_date' => $request->order_date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully.',
            'data' => new OrderResource($order)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required',
            'user_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'print_type_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'total' => 'required|numeric',
            'discount' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'name' => 'required',
            'description' => 'required',
            'order_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = Order::find($id);
        $order->update([
            'order_number' => $request->order_number,
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'print_type_id' => $request->print_type_id,
            'qty' => $request->qty,
            'price' => $request->price,
            'total' => $request->total,
            'discount' => $request->discount,
            'subtotal' => $request->subtotal,
            'name' => $request->name,
            'description' => $request->description,
            'order_date' => $request->order_date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully.',
            'data' => new OrderResource($order)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully.',
        ], 200);
    }
}
