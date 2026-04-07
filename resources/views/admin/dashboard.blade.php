@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Stats Grid --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(233,69,96,.1);">
                    <i class="bi bi-box-seam" style="color:#e94560;"></i>
                </div>
                <span class="badge bg-danger-subtle text-danger">Products</span>
            </div>
            <h2 class="fw-bold mb-0">{{ $stats['total_products'] }}</h2>
            <span class="text-muted small">Total Products</span>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-danger mt-3">Manage →</a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(13,110,253,.1);">
                    <i class="bi bi-bag-check" style="color:#0d6efd;"></i>
                </div>
                <span class="badge bg-primary-subtle text-primary">Orders</span>
            </div>
            <h2 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h2>
            <span class="text-muted small">Total Orders</span>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary mt-3">View All →</a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(25,135,84,.1);">
                    <i class="bi bi-currency-rupee" style="color:#198754;"></i>
                </div>
                <span class="badge bg-success-subtle text-success">Revenue</span>
            </div>
            <h2 class="fw-bold mb-0">₹{{ number_format($stats['total_revenue'], 0) }}</h2>
            <span class="text-muted small">Total Revenue</span>
            <a href="{{ route('admin.orders.index') }}?status=delivered" class="btn btn-sm btn-outline-success mt-3">View →</a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(255,193,7,.15);">
                    <i class="bi bi-clock-history" style="color:#ffc107;"></i>
                </div>
                <span class="badge bg-warning-subtle text-warning">Pending</span>
            </div>
            <h2 class="fw-bold mb-0">{{ $stats['pending_orders'] }}</h2>
            <span class="text-muted small">Pending Orders</span>
            <a href="{{ route('admin.orders.index') }}?status=pending" class="btn btn-sm btn-outline-warning mt-3">Handle →</a>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning-charge me-2" style="color:var(--accent);"></i>Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm" style="background:#e94560;color:#fff;">
                    <i class="bi bi-plus me-1"></i>Add New Product
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-plus me-1"></i>Add Category
                </a>
                <a href="{{ route('admin.orders.index') }}?status=pending" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-clock me-1"></i>Pending Orders
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-globe me-1"></i>View Store
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart me-2" style="color:var(--accent);"></i>Overview</h6>
            <dl class="row small mb-0">
                <dt class="col-7 text-muted">Total Users</dt>
                <dd class="col-5 fw-bold">{{ $stats['total_users'] }}</dd>
                <dt class="col-7 text-muted">Categories</dt>
                <dd class="col-5 fw-bold">{{ $stats['total_categories'] }}</dd>
                <dt class="col-7 text-muted">Pending Orders</dt>
                <dd class="col-5 fw-bold text-warning">{{ $stats['pending_orders'] }}</dd>
                <dt class="col-7 text-muted">Confirmed Revenue</dt>
                <dd class="col-5 fw-bold text-success">₹{{ number_format($stats['total_revenue'], 0) }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100" style="background:linear-gradient(135deg,#1a1a2e,#16213e);color:#fff;">
            <h6 class="fw-bold mb-3" style="color:#e94560;"><i class="bi bi-info-circle me-2"></i>System</h6>
            <p class="small mb-2 opacity-75">Laravel Version: <strong style="color:#fff;">11.x</strong></p>
            <p class="small mb-2 opacity-75">PHP Version: <strong style="color:#fff;">{{ PHP_VERSION }}</strong></p>
            <p class="small mb-2 opacity-75">Environment: <strong style="color:#fff;">{{ app()->environment() }}</strong></p>
            <p class="small mb-0 opacity-75">Server Time: <strong style="color:#fff;">{{ now()->format('d M Y H:i') }}</strong></p>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="card">
    <div class="card-body p-0">
        <div class="d-flex align-items-center justify-content-between p-4 pb-0">
            <h5 class="fw-bold mb-0">Recent Orders</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-4 fw-bold">#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td class="fw-bold" style="color:#e94560;">₹{{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection