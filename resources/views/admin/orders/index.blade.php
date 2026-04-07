@extends('layouts.admin')
@section('title', 'Orders')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">All Orders</h4>
    <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex gap-2">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            @foreach(['pending','confirmed','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        @if(request('status'))<a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>@endif
    </form>
</div>
<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th class="px-4">Order #</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th class="px-4">Action</th></tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td class="px-4 fw-bold">#{{ $order->id }}</td>
            <td>{{ $order->user->name }}<br><small class="text-muted">{{ $order->user->email }}</small></td>
            <td>{{ $order->items->count() }}</td>
            <td class="fw-bold" style="color:#e94560;">₹{{ number_format($order->total_price, 2) }}</td>
            <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
            <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
            <td class="px-4"><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No orders found.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
</div></div>
<div class="mt-4 d-flex justify-content-center">{{ $orders->links() }}</div>
@endsection