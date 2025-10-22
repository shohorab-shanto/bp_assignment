@extends('layouts.app')

@section('title', $subcategory->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $subcategory->name }}</h1>
    <div>
        <a href="{{ route('subcategories.edit', $subcategory) }}" class="btn btn-secondary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('subcategories.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<ul class="list-group mb-4">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Category
        <span class="badge bg-primary">{{ $subcategory->category->name }}</span>
    </li>
</ul>

<div>
    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Manage Products</a>
</div>
@endsection