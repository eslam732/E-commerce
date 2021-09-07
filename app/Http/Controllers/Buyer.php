<?php

namespace App\Http\Controllers;

use App\Models\buyer as BuyerModel;
use App\Models\Product;
use App\Models\User as UserModel;
use Illuminate\Http\Request;

class Buyer extends Controller
{
    public function getBuyers()
    {
        $buyers = BuyerModel::has('transactions')->get();
        return response()->json(['buyers' => $buyers, 200]);
    }

    public function getBuyer($id)
    {
        $buyer = BuyerModel::has('transactions')->findOrFail($id);
        return response()->json(['buyer' => $buyer, 200]);
    }



    public function buyerTransactions($id)
    {

        $buyer = BuyerModel::findOrFail($id);
        $trans = $buyer->transactions;
        return response()->json(['tr' => $trans, 200]);
    }


    public function buyerProducts($id)
    {
        $products = BuyerModel::findOrFail($id)->transactions()->with('product')->get()->pluck('product');
        return response()->json(['products' => $products, 200]);
    }

    public function sellersForBuyer($id)
    {
        $seller = BuyerModel::findOrFail($id)->transactions()
            ->with('product.seller')->get()->pluck('product.seller')->unique('id');
        return response()->json(['seller' => $seller, 200]);
    }

    public function categoriesForBuyer($id)
    {
        $categories = BuyerModel::findOrFail($id)->transactions()
            ->with('product.categories')->get()->pluck('product.categories')->unique('id')->collapse();


        return response()->json(['categories' => $categories, 200]);
    }
}
