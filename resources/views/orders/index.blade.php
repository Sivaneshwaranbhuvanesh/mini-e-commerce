@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
    <div class="page-header">
        <div class="container">
            <h1 class="mb-0">My Orders</h1>
        </div>
    </div>

    <div class="container pb-5">
        @if($orders->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-bag-x" style="font-size:4rem;color:#ccc;"></i>
                <h3 class="mt-3 text-muted">No orders yet</h3>
                <p class="text-muted">Start shopping to see your orders here.</p>
                <a href="{{ route('home') }}" class="btn btn-accent px-4">
                    <i class="bi bi-shop me-2"></i>Start Shopping
                </a>
            </div>
        @else
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4">Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="px-4 fw-bold">#{{ $order->id }}</td>
                                        <td class="text-muted small">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                        <td>{{ $order->items->count() }} item(s)</td>
                                        <td class="fw-bold" style="color:var(--accent);">
                                            ₹{{ number_format($order->total_price, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4">
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection