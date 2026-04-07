@extends('layouts.admin')
@section('title', 'Order #' . $order->id)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Order #{{ $order->id }}</h4>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">← Back</a>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4"><div class="card-body p-4">
            <h5 class="fw-bold mb-4">Order Items</h5>
            @foreach($order->items as $item)
            <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <img src="{{ $item->product ? $item->product->image_url : asset('images/no-image.png') }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                <div class="flex-grow-1">
                    <div class="fw-600">{{ $item->product->name ?? 'Deleted Product' }}</div>
                    <small class="text-muted">₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}</small>
                </div>
                <div class="fw-bold" style="color:#e94560;">₹{{ number_format($item->subtotal, 2) }}</div>
            </div>
            @endforeach
            <div class="pt-3 mt-3 border-top d-flex justify-content-between">
                <strong class="fs-5">Total</strong>
                <strong class="fs-5" style="color:#e94560;">₹{{ number_format($order->total_price, 2) }}</strong>
            </div>
        </div></div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="fw-bold mb-3">Customer</h5>
            <p class="mb-1 fw-600">{{ $order->user->name }}</p>
            <p class="text-muted small mb-0">{{ $order->user->email }}</p>
        </div></div>
        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="fw-bold mb-3">Update Status</h5>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <select name="status" class="form-select">
                        @foreach(['pending','confirmed','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn w-100" style="background:#e94560;color:#fff;">Update Status</button>
            </form>
        </div></div>
        <div class="card"><div class="card-body p-4">
            <h5 class="fw-bold mb-3">Order Info</h5>
            <dl class="row small mb-0">
                <dt class="col-5 text-muted">Order ID</dt><dd class="col-7 fw-bold">#{{ $order->id }}</dd>
                <dt class="col-5 text-muted">Date</dt><dd class="col-7">{{ $order->created_at->format('d M Y') }}</dd>
                <dt class="col-5 text-muted">Status</dt>
                <dd class="col-7"><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></dd>
            </dl>
        </div></div>
    </div>
</div>
@endsection