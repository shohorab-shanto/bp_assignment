@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-tags"></i> Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Category
    </a>
</div>

@if($categories->count() > 0)
    <div class="row">
        @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="text-muted">{{ $category->subcategories_count ?? $category->subcategories->count() }} subcategories</p>
                        <p class="text-muted">{{ $category->products_count ?? $category->products->count() }} products</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-tags display-1 text-muted"></i>
        <h3 class="mt-3">No categories found</h3>
        <p class="text-muted">Get started by creating your first category.</p>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Category
        </a>
    </div>
@endif
@endsection