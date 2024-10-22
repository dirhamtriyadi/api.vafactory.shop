<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrintType;
use App\Http\Resources\PrintTypeResource;
use Validator;

class PrintTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PrintType::latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => PrintTypeResource::collection($data)
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
            'name' => 'required|unique:print_types,name',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $printType = PrintType::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Print type created successfully.',
            'data' => new PrintTypeResource($printType)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $printType = PrintType::find($id);

        if (is_null($printType)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => new PrintTypeResource($printType)
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
            'name' => 'required|unique:print_types,name,'. $printType->id,
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $printType = PrintType::find($id);
        $printType->name = $request->name;
        $printType->price = $request->price;
        $printType->description = $request->description;
        $printType->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Print type updated successfully.',
            'data' => new PrintTypeResource($printType)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $printType = PrintType::find($id);
        $printType->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Print type deleted successfully.',
        ], 200);
    }
}
