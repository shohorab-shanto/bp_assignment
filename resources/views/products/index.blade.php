@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-box-seam"></i> Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Product
    </a>
</div>

@if($products->count() > 0)
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image_path)
                        <img src="{{ asset('storage/'.$product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-1">Category: {{ $product->category->name }}</p>
                        <p class="card-text text-muted">Subcategory: {{ optional($product->subcategory)->name ?? '—' }}</p>
                        <div class="mt-2">
                            @if($product->old_price)
                                <span class="text-muted text-decoration-line-through">${{ number_format($product->old_price, 2) }}</span>
                            @endif
                            <span class="fw-bold text-success">${{ number_format($product->new_price, 2) }}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this product?')">
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
        <i class="bi bi-box-seam display-1 text-muted"></i>
        <h3 class="mt-3">No products found</h3>
        <p class="text-muted">Create your first product with pricing and image.</p>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Product
        </a>
    </div>
@endif
@endsection