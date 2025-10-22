<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('subcategories')->orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $slug = Str::slug($validated['name']);
        // Ensure unique slug
        $counter = 1;
        $baseSlug = $slug;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return redirect()->route('categories.index')->with('status', 'Category created');
    }

    public function show(Category $category)
    {
        $category->load('subcategories');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        
        // Keep slug unique
        $counter = 1;
        $baseSlug = $category->slug;
        while (Category::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
            $category->slug = $baseSlug . '-' . $counter++;
        }
        
        $category->save();
        return redirect()->route('categories.index')->with('status', 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Category deleted');
    }
}
