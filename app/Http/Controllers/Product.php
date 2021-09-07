<?php

namespace App\Http\Controllers;

use App\Models\Product as ProductModel;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Controller
{
  public function getAll()
  {
    $products = ProductModel::all();
    if (request()->has('sort_by')) {
      $attr = request()->sort_by;
      $products = $products->sortBy->{$attr};
    }
    return response()->json(['products' => $products], 200);
  }

  public function getOne($id)
  {
    $product = ProductModel::findOrFail($id);
    return response()->json(['product' => $product], 200);
  }
  public function productTransaction($id)
  {
    $transactions = ProductModel::findOrFail($id)->transactions;

    // $transactions=Transaction::all()->where('product_id',$id);
    // $transactions = DB::table('transactions')
    //   ->where('product_id', '=', $id)
    //   ->get();
    return response()->json(['transactions' => $transactions], 200);
  }
  public function productBuyers($id)
  {
    $buyers = ProductModel::findOrFail($id)->transactions()
      ->with('buyer')->get()->pluck('buyer')->unique('id');
    return response()->json(['buyers' => $buyers], 200);
  }
  public function productCategories($id)
  {
    $categories = ProductModel::findOrFail($id)->categories;
    return response()->json(['categories' => $categories], 200);
  }

  public function addCategoryToProduct($productId, $categoryId)
  {
    $product = ProductModel::findOrFail($productId)->categories()->syncWithoutDetaching([$categoryId]);
    return response()->json(['product' => $product], 200);
  }


  public function removeCategoryFromProduct($productId, $categoryId)
  {
    if (!ProductModel::findOrFail($productId)->categories()->find($categoryId)) {
      return response()->json('product cat not found', 200);
    }
    $product = ProductModel::findOrFail($productId)->categories()->detach($categoryId);
    return response()->json(['product' => $product], 200);
  }
}
