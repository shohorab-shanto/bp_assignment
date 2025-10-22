@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $category->name }}</h1>
    <div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Subcategories</div>
            <div class="card-body">
                <p class="text-muted">{{ $category->subcategories->count() }} subcategories</p>
                <a href="{{ route('subcategories.index') }}" class="btn btn-sm btn-outline-primary">Manage Subcategories</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Products</div>
            <div class="card-body">
                <p class="text-muted">{{ $category->products->count() }} products</p>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">Manage Products</a>
            </div>
        </div>
    </div>
</div>
@endsection