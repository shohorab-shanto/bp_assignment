@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $product->name }}</h1>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            @if($product->image_path)
                <img src="{{ asset('storage/'.$product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->description }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Category
                <span class="badge bg-primary">{{ $product->category->name }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Subcategory
                <span class="badge bg-secondary">{{ optional($product->subcategory)->name ?? '—' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Price
                <span class="fw-bold text-success">${{ number_format($product->new_price, 2) }}</span>
            </li>
            @if($product->old_price)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Old Price
                    <span class="text-muted text-decoration-line-through">${{ number_format($product->old_price, 2) }}</span>
                </li>
            @endif
        </ul>
    </div>
</div>
@endsection