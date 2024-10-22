<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderTracking;
use App\Http\Resources\OrderTrackingResource;
use Validator;

class OrderTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderTracking = OrderTracking::with('order.customer', 'tracking')->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => OrderTrackingResource::collection($orderTracking)
        ], 200);
    }

    public function indexByOrderId($id)
    {
        $orderTracking = OrderTracking::whereHas('order', function ($q) use ($id) {
            $q->where('order_number', $id);

        })->latest()->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => OrderTrackingResource::collection($orderTracking)
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
            'order_id' => 'required',
            'tracking_id' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTracking = OrderTracking::create([
            'order_id' => $request->order_id,
            'tracking_id' => $request->tracking_id,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'Order Tracking created successfully',
            new OrderTrackingResource($orderTracking)
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
            'order_id' => 'required',
            'tracking_id' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTracking = OrderTracking::find($id);
        $orderTracking->update([
            'order_id' => $request->order_id,
            'tracking_id' => $request->tracking_id,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order Tracking updated successfully.',
            'data' => new OrderTrackingResource($orderTracking)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orderTracking = OrderTracking::find($id);
        $orderTracking->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order Tracking deleted successfully.',
        ], 200);
    }
}
