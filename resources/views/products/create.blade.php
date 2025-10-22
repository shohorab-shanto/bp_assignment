@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
@php($categories = \App\Models\Category::orderBy('name')->get())
@php($subcategories = \App\Models\Subcategory::orderBy('name')->get())
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">Create Product</div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="subcategory_id" class="form-label">Subcategory (optional)</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select">
                                <option value="">Select a subcategory</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }} ({{ $subcategory->category->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="new_price" class="form-label">Price</label>
                            <input type="number" step="0.01" name="new_price" id="new_price" class="form-control" value="{{ old('new_price') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="old_price" class="form-label">Old Price (optional)</label>
                            <input type="number" step="0.01" name="old_price" id="old_price" class="form-control" value="{{ old('old_price') }}">
                        </div>
                        <div class="col-md-8">
                            <label for="image" class="form-label">Image (optional)</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection