<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:100',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // upload image
        $imagePath = $request->file('image')->store('categories', 'public');

        Category::create([
            'name'  => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'  => 'required|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // jika upload image baru
        if ($request->hasFile('image')) {

            // hapus image lama
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Category updated');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // hapus image juga
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return back()->with('success', 'Category deleted');
    }
}