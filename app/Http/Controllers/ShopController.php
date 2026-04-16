<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();

        $products = Product::with('category')
            ->when($request->category, function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.index', compact('products', 'categories'));
    }

    public function product($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('product_id', '!=', $product->product_id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('shop.product', compact('product', 'relatedProducts'));
    }
}