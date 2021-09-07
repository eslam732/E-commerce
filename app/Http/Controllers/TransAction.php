<?php

namespace App\Http\Controllers;

use App\Models\Transaction as TransactionModel;
use Illuminate\Http\Request;

class TransAction extends Controller
{
    public function getAll()
    {
      return response()->json(['transactions'=>TransactionModel::all()],200);
    }
    
    public function getOne($id)
    {
        $transaction=TransactionModel::findOrFail($id);
        return response()->json(['transactions'=>$transaction],200);

    }
}
