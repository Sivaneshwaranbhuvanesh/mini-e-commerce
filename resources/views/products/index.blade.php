@extends('layouts.app')
@section('title', 'Shop')

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="mb-2">Our Products</h1>
        <p class="mb-0 opacity-75">Discover amazing products at great prices</p>
    </div>
</div>

<div class="container pb-5">
    {{-- Filters --}}
    <div class="row mb-4 g-3">
        <div class="col-12">
            <div class="card p-3">
                <form action="{{ route('home') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-600 mb-1">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search products..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-600 mb-1">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-accent flex-fill">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Active Filters --}}
    @if(request('search') || request('category'))
        <div class="mb-3">
            <span class="text-muted small me-2">Active filters:</span>
            @if(request('search'))
                <span class="badge bg-secondary me-1">Search: "{{ request('search') }}"</span>
            @endif
            @if(request('category'))
                @php $catName = $categories->firstWhere('id', request('category'))?->name; @endphp
                @if($catName)
                    <span class="badge bg-secondary me-1">Category: {{ $catName }}</span>
                @endif
            @endif
            <span class="text-muted small">— {{ $products->total() }} result(s)</span>
        </div>
    @endif

    {{-- Products Grid --}}
    @if($products->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-search" style="font-size:3rem;color:#ccc;"></i>
            <h4 class="mt-3 text-muted">No products found</h4>
            <p class="text-muted">Try adjusting your search or filter criteria.</p>
            <a href="{{ route('home') }}" class="btn btn-accent">View All Products</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card product-card h-100">
                        <a href="{{ route('products.show', $product) }}">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="card-img-top" style="height:200px;object-fit:cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-1">
                                <span class="badge" style="background:var(--primary);font-size:.7rem;">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                            <h6 class="card-title fw-600 mb-1">
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h6>
                            <p class="text-muted small mb-2" style="flex:1;">
                                {{ Str::limit($product->description, 60) }}
                            </p>
                            <div class="d-flex align-items-center justify-content-between mt-auto">
                                <span class="fw-bold fs-5" style="color:var(--accent);">
                                    ₹{{ number_format($product->price, 2) }}
                                </span>
                                <span class="small text-muted">Stock: {{ $product->stock }}</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                            @auth
                                @if(!auth()->user()->isAdmin())
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-accent w-100 btn-sm"
                                            {{ $product->stock < 1 ? 'disabled' : '' }}>
                                            <i class="bi bi-cart-plus me-1"></i>
                                            {{ $product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary w-100 btn-sm">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-accent w-100 btn-sm">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection