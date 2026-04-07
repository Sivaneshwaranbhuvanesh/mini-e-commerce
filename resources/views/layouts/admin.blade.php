<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard') | ShopLaravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1a1a2e;
            --sidebar-width: 260px;
            --accent: #e94560;
            --accent-soft: rgba(233,69,96,0.1);
        }
        body { font-family: 'DM Sans', sans-serif; background: #f0f2f5; }
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            display: flex; flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            text-decoration: none;
        }
        .sidebar-brand span { color: var(--accent); }
        .sidebar-label {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            padding: 1.2rem 1.5rem 0.4rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.72);
            padding: .6rem 1.5rem;
            border-radius: 8px;
            margin: 2px 10px;
            font-weight: 500;
            transition: all .2s;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: var(--accent-soft);
            color: #fff;
        }
        .sidebar .nav-link.active { border-left: 3px solid var(--accent); }
        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            font-size: .85rem;
            color: rgba(255,255,255,0.5);
        }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        .top-bar {
            background: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 1px 10px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .top-bar h5 { margin: 0; font-weight: 600; color: #1a1a2e; }
        .content-area { padding: 2rem; }
        .stat-card {
            border: none; border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
            transition: transform .2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.07); }
        .btn { border-radius: 8px; font-weight: 500; }
        .form-control, .form-select { border-radius: 8px; border: 1.5px solid #e0e0e0; }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233,69,96,0.12);
        }
        .table th { font-weight: 600; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; color: #666; }
        .badge { border-radius: 6px; }
        .alert { border-radius: 10px; border: none; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">Shop<span>Laravel</span><br>
        <small style="font-family:'DM Sans',sans-serif;font-size:.7rem;font-weight:400;color:rgba(255,255,255,.4);">Admin Panel</small>
    </a>

    <div class="sidebar-label">Main</div>
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="sidebar-label">Catalog</div>
    <a href="{{ route('admin.products.index') }}"
       class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Products
    </a>
    <a href="{{ route('admin.categories.index') }}"
       class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="bi bi-tags"></i> Categories
    </a>

    <div class="sidebar-label">Sales</div>
    <a href="{{ route('admin.orders.index') }}"
       class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i> Orders
    </a>

    <div class="sidebar-label">Site</div>
    <a href="{{ route('home') }}" class="nav-link" target="_blank">
        <i class="bi bi-globe"></i> View Store
    </a>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                 style="width:32px;height:32px;">
                <i class="bi bi-person-fill text-white small"></i>
            </div>
            <div>
                <div style="color:#fff;font-size:.85rem;font-weight:600;">{{ auth()->user()->name }}</div>
                <div style="font-size:.72rem;">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button class="btn btn-sm btn-outline-danger w-100" type="submit">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="top-bar">
        <h5>@yield('title', 'Dashboard')</h5>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.orders.index') }}?status=pending" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-clock me-1"></i>
                {{ \App\Models\Order::where('status','pending')->count() }} Pending
            </a>
            <span class="text-muted small">{{ now()->format('D, d M Y') }}</span>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>