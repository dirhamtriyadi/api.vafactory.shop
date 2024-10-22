<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Http\Resources\TransactionResource;
use Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaction::with(['transactionDetail', 'createdBy'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => TransactionResource::collection($data)
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
            'date' => 'required|date',
            'transaction_number' => 'required|unique:transactions,transaction_number',
            'users_id' => 'required|numeric',
            'customers_id' => 'required|numeric',
            'items' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $transaction = Transaction::create([
            'date' => $request->date,
            'transaction_number' => $request->transaction_number,
            'users_id' => $request->users_id,
            'customers_id' => $request->customers_id
        ]);

        if ($transaction) {
            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'description' => $item['description']
                ]);
            }

            /* if ($request->payment) {
                Payment::create([
                    'date' => $item->price,
                    'transactions_id' => $transaction->id,
                    'termin' => $item->products_id,
                    'amount' => $item->qty,
                    'description' => $item->description
                ]);
            } */
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction created successfully.',
            'data' => new TransactionResource($transaction)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['$transactionDetail'])->find($id);

        if (is_null($transaction)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'data' => new TransactionResource($transaction)
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
            'date' => 'required|date',
            'transaction_number' => 'required|unique:transactions,transaction_number,'. $transaction->id,
            // 'users_id' => 'required|numeric',
            'customers_id' => 'required|numeric',
            'items' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->date = $request->date;
        $transaction->transaction_number = $request->transaction_number;
        $transaction->customers_id = $request->customers_id;
        $updatedTransaction = $transaction->save();

        if ($updatedTransaction) {
            foreach ($request->items as $item) {
                TransactionDetail::upsert(
                    [[
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                        'description' => $item['description']
                    ]],
                    ['transaction_id', 'product_id'],
                    ['qty', 'price', 'subtotal', 'description']
                );
            }

            /* if ($request->payment) {
                Payment::create([
                    'date' => $item->price,
                    'transactions_id' => $transaction->id,
                    'termin' => $item->products_id,
                    'amount' => $item->qty,
                    'description' => $item->description
                ]);
            } */
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction updated successfully.',
            'data' => new TransactionResource($transaction)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction deleted successfully.',
        ], 200);
    }
}
