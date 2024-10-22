<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashFlow;
use App\Http\Resources\CashFlowResource;
use Validator;
use Carbon\Carbon;
use DB;

class CashFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');

        $data = CashFlow::with(['createdBy' => function ($query) {
            $query->select('id', 'name');
        }])->orderBy('transaction_date', 'DESC');

        if ($request->start_date && $request->end_date) {
            $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date);
        }

        $ls = $data->whereBetween(DB::raw('transaction_date'), [$start_date, $end_date])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => CashFlowResource::collection($ls)
        ], 200);
    }

    public function getAll() {
        $data = CashFlow::with(['paymentMethod'])->get();
        // dd($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => CashFlowResource::collection($data)
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
            'transaction_date' => 'required|date',
            'user_id' => 'required|numeric',
            'cash_flow_type' => 'required',
            'amount' => 'required|numeric',
            'payment_methods_id' => 'required|numeric',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $cashFlow = CashFlow::create([
            'transaction_date' => $request->transaction_date,
            'user_id' => $request->user_id,
            'cash_flow_type' => $request->cash_flow_type,
            'amount' => $request->amount,
            'payment_methods_id' => $request->payment_methods_id,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cash flow created successfully.',
            'data' => new CashFlowResource($cashFlow)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cashFlow = CashFlow::find($id);

        if (is_null($cashFlow)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => new CashFlowResource($cashFlow)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cashFlow->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cash flow deleted successfully.'
        ]);
    }
}
