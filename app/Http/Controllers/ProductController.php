<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])
            ->orderBy('name')
            ->paginate(12);
        return view('products.index', compact('products'));
    }

    public function create(Category $category = null, Subcategory $subcategory = null)
    {
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();
        return view('products.create', compact('categories', 'subcategories', 'category', 'subcategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => [
                'required',
                Rule::exists('subcategories', 'id')->where(function ($q) use ($request) {
                    return $q->where('category_id', $request->input('category_id'));
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'new_price' => ['required', 'numeric', 'min:0'],
        ]);

        $slug = Str::slug($validated['name']);
        $counter = 1;
        $baseSlug = $slug;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'old_price' => $validated['old_price'] ?? null,
            'new_price' => $validated['new_price'],
        ]);

        return redirect()->route('products.index')->with('status', 'Product created');
    }

    public function show(Product $product)
    {
        $product->load('category', 'subcategory');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => [
                'required',
                Rule::exists('subcategories', 'id')->where(function ($q) use ($request) {
                    return $q->where('category_id', $request->input('category_id'));
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'new_price' => ['required', 'numeric', 'min:0'],
        ]);

        $product->category_id = $validated['category_id'];
        $product->subcategory_id = $validated['subcategory_id'];
        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);

        $counter = 1;
        $baseSlug = $product->slug;
        while (Product::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
            $product->slug = $baseSlug . '-' . $counter++;
        }

        $product->description = $validated['description'] ?? null;
        $product->old_price = $validated['old_price'] ?? null;
        $product->new_price = $validated['new_price'];

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->save();
        return redirect()->route('products.index')->with('status', 'Product updated');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('products.index')->with('status', 'Product deleted');
    }
}
