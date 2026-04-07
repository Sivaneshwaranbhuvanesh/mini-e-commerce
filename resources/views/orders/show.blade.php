@extends('layouts.app')
@section('title', 'Order #' . $order->id)

@section('content')
    <div class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color:rgba(255,255,255,.5);">
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-white-50">My Orders</a>
                    </li>
                    <li class="breadcrumb-item active text-white">Order #{{ $order->id }}</li>
                </ol>
            </nav>
            <h1 class="mb-0">Order #{{ $order->id }}</h1>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Items</h5>
                        @foreach($order->items as $item)
                            <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <img src="{{ $item->product ? $item->product->image_url : asset('images/no-image.png') }}"
                                    alt="{{ $item->product->name ?? 'Product' }}"
                                    style="width:70px;height:70px;object-fit:cover;border-radius:10px;">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0">{{ $item->product->name ?? 'Product Deleted' }}</h6>
                                    <span class="text-muted small">₹{{ number_format($item->price, 2) }} ×
                                        {{ $item->quantity }}</span>
                                </div>
                                <div class="fw-bold" style="color:var(--accent);">
                                    ₹{{ number_format($item->subtotal, 2) }}
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                            <strong class="fs-5">Total</strong>
                            <strong class="fs-5"
                                style="color:var(--accent);">₹{{ number_format($order->total_price, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Details</h5>
                        <dl class="row small mb-0">
                            <dt class="col-5 text-muted">Order ID</dt>
                            <dd class="col-7 fw-bold">#{{ $order->id }}</dd>
                            <dt class="col-5 text-muted">Placed On</dt>
                            <dd class="col-7">{{ $order->created_at->format('d M Y') }}</dd>
                            <dt class="col-5 text-muted">Time</dt>
                            <dd class="col-7">{{ $order->created_at->format('h:i A') }}</dd>
                            <dt class="col-5 text-muted">Status</dt>
                            <dd class="col-7">
                                <span class="badge bg-{{ $order->status_badge }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>

                {{-- Status Timeline --}}
                <div class="card">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Order Progress</h6>
                        @php
                            $statuses = ['pending', 'confirmed', 'delivered'];
                            $currentIdx = array_search($order->status, $statuses);
                        @endphp
                        @foreach($statuses as $idx => $status)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;min-width:32px;
                                         background:{{ ($currentIdx !== false && $idx <= $currentIdx) || $order->status === 'delivered' ? 'var(--accent)' : '#e0e0e0' }};
                                         color:{{ ($currentIdx !== false && $idx <= $currentIdx) ? '#fff' : '#999' }};">
                                    <i class="bi bi-check small"></i>
                                </div>
                                <div>
                                    <div
                                        class="fw-600 small {{ ($currentIdx !== false && $idx <= $currentIdx) ? '' : 'text-muted' }}">
                                        {{ ucfirst($status) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($order->status === 'cancelled')
                            <div class="alert alert-danger py-2 small mb-0">
                                <i class="bi bi-x-circle me-1"></i>This order was cancelled.
                            </div>
                        @endif
                    </div>
                </div>

                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100 mt-3">
                    <i class="bi bi-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
        </div>
    </div>
@endsection