@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
    <div class="page-header">
        <div class="container">
            <h1 class="mb-0">Shopping Cart</h1>
        </div>
    </div>

    <div class="container pb-5">
        @if(empty($cart))
            <div class="text-center py-5">
                <i class="bi bi-cart-x" style="font-size:4rem;color:#ccc;"></i>
                <h3 class="mt-3 text-muted">Your cart is empty</h3>
                <p class="text-muted">Add some products to get started!</p>
                <a href="{{ route('home') }}" class="btn btn-accent px-4">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div
                            class="card-header bg-white border-0 pb-0 pt-3 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Cart Items ({{ count($cart) }})</h5>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Clear entire cart?')">
                                    <i class="bi bi-trash me-1"></i>Clear All
                                </button>
                            </form>
                        </div>
                        <div class="card-body px-4">
                            @foreach($cart as $productId => $item)
                                <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    @php
                                        $product = \App\Models\Product::find($productId);
                                    @endphp
                                    <img src="{{ $product ? $product->image_url : asset('images/no-image.png') }}"
                                        alt="{{ $item['name'] }}"
                                        style="width:80px;height:80px;object-fit:cover;border-radius:10px;">

                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0">{{ $item['name'] }}</h6>
                                        <span class="text-muted small">₹{{ number_format($item['price'], 2) }} each</span>
                                        @if($product && $item['quantity'] > $product->stock)
                                            <div class="text-danger small"><i class="bi bi-exclamation-triangle me-1"></i>Exceeds
                                                available stock ({{ $product->stock }})</div>
                                        @endif
                                    </div>

                                    <form action="{{ route('cart.update', $productId) }}" method="POST"
                                        class="d-flex align-items-center gap-2">
                                        @csrf @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            max="{{ $product ? $product->stock : 99 }}" class="form-control form-control-sm"
                                            style="width:70px;" onchange="this.form.submit()">
                                    </form>

                                    <div class="text-end" style="min-width:90px;">
                                        <div class="fw-bold" style="color:var(--accent);">
                                            ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>
                                    </div>

                                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-3">
                        <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                    </a>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Order Summary</h5>

                            @foreach($cart as $productId => $item)
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">{{ Str::limit($item['name'], 25) }} × {{ $item['quantity'] }}</span>
                                    <span>₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>₹{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping</span>
                                <span class="text-success">Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong class="fs-5">Total</strong>
                                <strong class="fs-5" style="color:var(--accent);">₹{{ number_format($total, 2) }}</strong>
                            </div>

                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-accent w-100 py-2"
                                    onclick="return confirm('Place order for ₹{{ number_format($total, 2) }}?')">
                                    <i class="bi bi-bag-check me-2"></i>Place Order
                                </button>
                            </form>

                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>Secure checkout. No payment required.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection