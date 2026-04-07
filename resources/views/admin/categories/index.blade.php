@extends('layouts.admin')
@section('title', 'Categories')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Categories</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn" style="background:#e94560;color:#fff;">
        <i class="bi bi-plus me-2"></i>Add Category
    </a>
</div>
<div class="card"><div class="card-body p-0">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th class="px-4">Name</th><th>Products</th><th class="px-4">Actions</th></tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td class="px-4 fw-600">{{ $category->name }}</td>
            <td><span class="badge bg-secondary">{{ $category->products_count }}</span></td>
            <td class="px-4">
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center text-muted py-4">No categories yet.</td></tr>
        @endforelse
    </tbody>
</table>
</div></div>
<div class="mt-4 d-flex justify-content-center">{{ $categories->links() }}</div>
@endsection