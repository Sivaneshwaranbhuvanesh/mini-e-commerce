@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Products</h4>
        <p class="text-muted small mb-0">{{ $products->total() }} total products</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn" style="background:#e94560;color:#fff;">
        <i class="bi bi-plus me-2"></i>Add Product
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4" style="width:60px;">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th class="px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="px-4">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                     style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                            </td>
                            <td>
                                <div class="fw-600">{{ $product->name }}</div>
                                <div class="text-muted small">{{ Str::limit($product->description, 50) }}</div>
                            </td>
                            <td>
                                <span class="badge" style="background:#1a1a2e;">{{ $product->category->name }}</span>
                            </td>
                            <td class="fw-bold" style="color:#e94560;">₹{{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td class="px-4">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Delete {{ addslashes($product->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No products found.
                                <a href="{{ route('admin.products.create') }}">Add one now</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection