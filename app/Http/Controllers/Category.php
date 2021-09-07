<?php

namespace App\Http\Controllers;

use App\Models\Category as CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class Category extends Controller
{
    public function getcategories()
    {
        
      return response()->json(['categories' => CategoryModel::all()], 200);
    }
    public function getSpecificCat($id)
    {
       
           $user = CategoryModel::findOrFail($id);
       
        return response()->json(['user' => $user], 200);
        
    }
    public function createCat(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'

        ];

        // $this->validate($request,$rules);
        $validation = Validator::make(request()->all(), $rules);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $data = $request->all();
       
        
        $cat = CategoryModel::create($data);
        return response()->json('cat created', 201);
    }

    public function update($id)
    {  
      $cat=CategoryModel::findOrFail($id);
      
      $cat->fill(request()->only('name','description'));
      if($cat->isClean()){
          
        return response()->json('nothing to change', 201);
    }
$cat->save();
      return response()->json(['cat updated'=>$cat], 201);
    }


    public function delete($id)
    { $cat = CategoryModel::findOrFail($id);
        
        $cat->delete();
        return response()->json('category deleted', 201);
    }
    public function productsForCategory($id)
    { 
        $products = CategoryModel::findOrFail($id)->products;
        
        
        return response()->json(['products'=>$products], 201);
    }

    public function sellersForCategory($id)
    { 
        $products = CategoryModel::findOrFail($id)->products()
        ->with('seller')->get()->pluck('seller')->unique('id');
        
        
        return response()->json(['products'=>$products], 201);
    }

    public function transactionsForCategory($id)
    { 
        $transactions = CategoryModel::findOrFail($id)->products()->whereHas('transactions')
        ->with('transactions')->get()->pluck('transactions')->collapse();
        
        
        return response()->json(['transactions'=>$transactions], 201);
    }

    public function buyersForCategory($id)
    {  $items = 2;
        $index= paginator($items );
        
        $buyers = CategoryModel::findOrFail($id)->products()->whereHas('transactions')
        ->with('transactions.buyer')->get()->pluck('transactions')->collapse()->pluck('buyer')->unique('id')->sortBy([
            ['id', 'asc']]);

        
        
        
        return response()->json(['buyers'=>$buyers], 201);
    }
}
