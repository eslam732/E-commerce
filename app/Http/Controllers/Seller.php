<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\seller as SellerModel;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class Seller extends Controller
{
    public function getSellers()
    {
        $sellers = SellerModel::has('products')->get();
        return response()->json(['sellers' => $sellers, 200]);
    }

    public function getSeller($id)
    {
        $seller = SellerModel::has('products')->findOrFail($id);
        return response()->json(['seller' => $seller, 200]);
    }
    public function sellerProducts($id)
    {
        $products = SellerModel::findOrFail($id)->products;
        return response()->json(['products' => $products, 200]);
    }

    public function createProduct($id)
    {
        $seller = User::findOrFail($id);
        $rules = [

            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',

        ];
        $validation = Validator::make(request()->all(), $rules);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $data = request()->all();
        $image = request()->file('image')->store('posts');

        // $fileName = request()->file('image')->getClientOriginalName();
        // $extension = request()->file('image')->extension();
        // $mime = request()->file('image')->getMimeType();
        // $clientSize = request()->file('image')->getSize();

        // dd($fileName , $extension  , $mime , $clientSize);

        
        $data['seller_id'] = $id;
        $data['status'] = 'unavailable';
        $data['image'] = $image;
        //  $data['image']='1.jpg';
        $product = Product::create($data);
        return response()->json(['product' => $product, 201]);
    }


    // public function updateProduct($sellerId, $productId)
    // {
    //     $seller = User::findOrFail($sellerId);
    //     $product=Product::findOrFail($productId);
    //     $rules = [

    //         'quantity' => 'required|integer|min:1',
    //         'image' => 'required|image',
    //         'status' => 'in: available , not available',


    //     ];
    //     $validation = Validator::make(request()->all(), $rules);
    //     if ($validation->fails()) {
    //         return response()->json($validation->errors(), 400);
    //     }

    //         $product->fill(request()->only([
    //             'name',
    //             'description',
    //             'quantity'
    //         ]));  

    // }

    public function deleteProduct($id)
    {
        $product=Product::findOrFail($id);
        Storage::delete($product->image);
        $product->delete();
    }

    public function sellerTranasctions($id)
    {
        $transactions = SellerModel::findOrFail($id)->products()->whereHas('transactions')->with('transactions')
            ->get()->pluck('transactions')->collapse();

        return response()->json(['transactions' => $transactions, 200]);
    }
    public function sellerCategories($id)
    {
        $cats = SellerModel::findOrFail($id)->products()->with('categories')
            ->get()->pluck('categories')->collapse()->unique('id');

        return response()->json(['transactions' => $cats, 200]);
    }

    public function sellerBuyers($id)
    {
        $buyers = SellerModel::findOrFail($id)->products()->whereHas('transactions')->with('transactions.buyer')
            ->get()->pluck('transactions')->collapse()->pluck('buyer')->unique('id');

        return response()->json(['buyers' => $buyers, 200]);
    }


}
