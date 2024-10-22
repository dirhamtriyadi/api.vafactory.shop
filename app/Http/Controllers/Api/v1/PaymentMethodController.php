<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Resources\PaymentMethodResource;
use Validator;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PaymentMethod::latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => PaymentMethodResource::collection($data)
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
            'name' => 'required|unique:payment_methods,name'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $paymentMethod = PaymentMethod::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment method created successfully.',
            'data' => new PaymentMethodResource($paymentMethod)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if (is_null($paymentMethod)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => new PaymentMethodResource($paymentMethod)
        ], 200);
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
            'name' => 'required|unique:payment_methods,name,'. $paymentMethod->id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->name = $request->name;
        $paymentMethod->description = $request->description;
        $paymentMethod->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment method updated successfully.',
            'data' => new PaymentMethodResource($paymentMethod)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment method deleted successfully.',
        ], 200);
    }
}
