@extends('layouts.app')
@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('home', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-md-5">
                <div class="card p-0 overflow-hidden" style="border-radius:16px;">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-100"
                        style="height:400px;object-fit:cover;">
                </div>
            </div>

            <div class="col-md-7">
                <span class="badge mb-2" style="background:var(--primary);">{{ $product->category->name }}</span>
                <h1 class="fw-bold mb-2" style="font-family:'Playfair Display',serif;">{{ $product->name }}</h1>

                <div class="fs-2 fw-bold mb-3" style="color:var(--accent);">
                    ₹{{ number_format($product->price, 2) }}
                </div>

                <div class="mb-3">
                    @if($product->stock > 10)
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>In Stock ({{ $product->stock }}
                            available)</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Low Stock
                            ({{ $product->stock }} left)</span>
                    @else
                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>
                    @endif
                </div>

                @if($product->description)
                    <p class="text-muted mb-4" style="line-height:1.8;">{{ $product->description }}</p>
                @endif

                @auth
                    @if(!auth()->user()->isAdmin() && $product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-3 align-items-center">
                            @csrf
                            <div style="width:120px;">
                                <label class="form-label small fw-600">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="1" min="1"
                                    max="{{ $product->stock }}">
                            </div>
                            <div class="align-self-end">
                                <button type="submit" class="btn btn-accent px-4 py-2">
                                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                </button>
                            </div>
                        </form>
                    @elseif($product->stock < 1)
                        <button class="btn btn-secondary" disabled>Out of Stock</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-accent px-4 py-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login to Add to Cart
                    </a>
                @endauth

                <div class="mt-4 p-3 rounded" style="background:#f8f7f4;">
                    <div class="row text-center g-3">
                        <div class="col-4">
                            <i class="bi bi-truck fs-4 d-block mb-1" style="color:var(--accent);"></i>
                            <small class="text-muted">Free Shipping</small>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-shield-check fs-4 d-block mb-1" style="color:var(--accent);"></i>
                            <small class="text-muted">Secure Payment</small>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-arrow-repeat fs-4 d-block mb-1" style="color:var(--accent);"></i>
                            <small class="text-muted">Easy Returns</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection