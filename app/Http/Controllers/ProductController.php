<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
      public function index()
    {
        $products = Product::with('images')->latest()->get();
        return view('page.product', compact('products'));
    }

     public function show(Product $product)
    {
        $product->load('images');
        $product->price = (float)$product->price;

        return view('page.detail', compact('product'));
    }
}
