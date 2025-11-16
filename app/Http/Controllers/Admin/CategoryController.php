<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }
    public function show($id)
{
    $id = Crypt::decrypt($id);
    $category = Category::findOrFail($id);
    return view('admin.categories.show', compact('category'));
}


    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $category=Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $category=Category::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $category=Category::findOrFail($id);
        return back()->with('success', 'Category deleted successfully!');
    }
}
