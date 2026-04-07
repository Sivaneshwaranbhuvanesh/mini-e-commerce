@extends('layouts.admin')
@section('title', 'Edit Product')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit: {{ $product->name }}</h4>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">← Back</a>
</div>
<div class="card"><div class="card-body p-4">
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label fw-600">Product Name *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-600">Price (₹) *</label>
            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-8">
            <label class="form-label fw-600">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label fw-600">Category *</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label fw-600">Stock *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
            </div>
        </div>
        <div class="col-12">
            <label class="form-label fw-600">Product Image</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ $product->image_url }}" style="height:80px;border-radius:8px;">
                    <small class="text-muted ms-2">Current image — upload new to replace</small>
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="col-12">
            <button type="submit" class="btn px-4" style="background:#e94560;color:#fff;">
                <i class="bi bi-save me-2"></i>Update Product
            </button>
        </div>
    </div>
</form>
</div></div>
@endsection