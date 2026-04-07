@extends('layouts.admin')
@section('title', 'Edit Category')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Category</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">← Back</a>
</div>
<div class="card" style="max-width:500px;"><div class="card-body p-4">
<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label fw-600">Category Name *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn px-4" style="background:#e94560;color:#fff;">Update Category</button>
</form>
</div></div>
@endsection