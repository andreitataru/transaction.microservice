<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response; 
use App\Models\Transaction;
use Illuminate\Http\Request;  

class TransactionController extends Controller
{

    public function addTransaction(Request $request) {  
        //validate incoming request 
        $this->validate($request, [
            'buyerId' => 'required',
            'sellerId' => 'required',
            'contractId' => 'required',
            'amount' => 'required',
            'paymentType' => 'required'
        ]);
        
        try {
            $transaction = new Transaction;
            $transaction->buyerId = $request->buyerId;
            $transaction->sellerId = $request->sellerId;
            $transaction->contractId = $request->contractId;
            $transaction->amount = $request->amount;
            $transaction->paymentType = $request->paymentType;

            $transaction->save();
           
            //return successful response
            return response()->json(['transaction' => $transaction, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'addTransaction Failed' + $e], 409);
        }


    }
}
