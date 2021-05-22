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

    public function getAllTransactions(Request $request){
        return response()->json(['transactions' =>  Transaction::all()], 200);
    }

    public function getTransactionById($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            return response()->json(['transaction' => $transaction], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Transaction not found!'], 404);
        }

    }

    public function getTransactionByUserId($id)
    {
        try {
            $transactionsBuyer = Transaction::where('buyerId' , '=' , $id)->get();
            $transactionsSeller = Transaction::where('sellerId' , '=' , $id)->get();

            if (count($transactionsBuyer) > 0 || count($transactionsSeller) > 0){
                return response()->json(['transactionsBuyer' => $transactionsBuyer,'transactionsSeller' => $transactionsSeller, ], 200);
            }
            else{
                return response()->json(['message' => 'No transactions found with user id ' . $id], 404);
            }

        } catch (\Exception $e) {

            return response()->json(['message' => 'Error'], 500);
        }

    }

    public function getTransactionsByDate(Request $request)
    {
        $transactions = Transaction::where('created_at', 'like', $request->date . "%")->get();
        return response()->json(['transactions' => $transactions], 200);

    }

}
