<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderTransaction;
use App\Http\Resources\OrderTransactionResource;
use Validator;

class OrderTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = OrderTransaction::with('order', 'paymentMethod', 'createdBy')->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => OrderTransactionResource::collection($data)
        ], 200);
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
            'order_id' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTransaction = OrderTransaction::create([
            'order_id' => $request->order_id,
            'payment_method_id' => $request->payment_method_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order Transaction created successfully.',
            'data' => new OrderTransactionResource($orderTransaction)
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
            'order_id' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTransaction = OrderTransaction::find($id);
        $orderTransaction->update([
            'order_id' => $request->order_id,
            'payment_method_id' => $request->payment_method_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order Transaction updated successfully.',
            'data' => new OrderTransactionResource($orderTransaction)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orderTransaction = OrderTransaction::find($id);
        $orderTransaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order Transaction deleted successfully.',
        ], 200);
    }
}
