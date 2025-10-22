@extends('layouts.app')

@section('title', 'Subcategories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-collection"></i> Subcategories</h1>
    <a href="{{ route('subcategories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Subcategory
    </a>
</div>

@if($subcategories->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('subcategories.show', $subcategory) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('subcategories.edit', $subcategory) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('subcategories.destroy', $subcategory) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this subcategory?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-collection display-1 text-muted"></i>
        <h3 class="mt-3">No subcategories found</h3>
        <p class="text-muted">Create a subcategory under a category.</p>
        <a href="{{ route('subcategories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Subcategory
        </a>
    </div>
@endif
@endsection