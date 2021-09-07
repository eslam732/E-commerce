<?php

namespace App\Http\Controllers;
use App\Models\Transaction as TransactionModel;
use App\Models\User as UserModel;

use Illuminate\Http\Request;

class CategoryTransaction extends Controller
{
    public function getOneCatT($id)
    {
        
        $transaction=TransactionModel::findOrFail($id);
        $cat=$transaction->product->categories;
        return response()->json(['categories'=>$cat],200);   

    }

    public function getOneSeller($id)
    {
        $transaction=TransactionModel::findOrFail($id);
        $seller=$transaction->product->seller;
        return response()->json(['seller'=>$seller],200);   

    }
}
