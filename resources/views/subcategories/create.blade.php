@extends('layouts.app')

@section('title', 'Create Subcategory')

@section('content')
@php($categories = \App\Models\Category::orderBy('name')->get())
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">Create Subcategory</div>
            <div class="card-body">
                <form action="{{ route('subcategories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection