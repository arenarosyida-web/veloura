<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'stock'=>'required',
            'image'=>'image|mimes:jpg,png,jpeg'
        ]);

        $image = null;

        if($request->hasFile('image')){
            $image = $request->file('image')->store('products','public');
        }

        Product::create([
            'category_id'=>$request->category_id,
            'image'=>$image,
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock
        ]);

        return redirect()->route('products.index')
            ->with('success','Product created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        if($request->hasFile('image')){
            Storage::disk('public')->delete($product->image);

            $image = $request->file('image')->store('products','public');
            $product->image = $image;
        }

        $product->update([
            'category_id'=>$request->category_id,
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock
        ]);

        return redirect()->route('products.index')
        ->with('success','Product updated');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        Storage::disk('public')->delete($product->image);

        $product->delete();

        return back()->with('success','Product deleted');
    }
}