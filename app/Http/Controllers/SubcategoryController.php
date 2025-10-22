<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->orderBy('name')->paginate(10);
        return view('subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $slug = Str::slug($validated['name']);
        $counter = 1;
        $baseSlug = $slug;
        while (Subcategory::where('slug', $slug)->where('category_id', $validated['category_id'])->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Subcategory::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return redirect()->route('subcategories.index')->with('status', 'Subcategory created');
    }

    public function show(Subcategory $subcategory)
    {
        $subcategory->load('category', 'products');
        return view('subcategories.show', compact('subcategory'));
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::orderBy('name')->get();
        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $subcategory->category_id = $validated['category_id'];
        $subcategory->name = $validated['name'];
        $subcategory->slug = Str::slug($validated['name']);

        $counter = 1;
        $baseSlug = $subcategory->slug;
        while (
            Subcategory::where('slug', $subcategory->slug)
                ->where('category_id', $validated['category_id'])
                ->where('id', '!=', $subcategory->id)
                ->exists()
        ) {
            $subcategory->slug = $baseSlug . '-' . $counter++;
        }

        $subcategory->save();
        return redirect()->route('subcategories.index')->with('status', 'Subcategory updated');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('status', 'Subcategory deleted');
    }
}
