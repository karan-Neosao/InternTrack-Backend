@extends('admin.layouts.app')

@section('title', 'Admin Settings & Security')

@section('breadcrumb')
    <li class="active-item">Settings & Environment</li>
@endsection

@section('content')

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Account & System Settings</h3>
            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2.5 py-1 small">
                Security & Config
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Manage your administrator credentials, access tokens, environment runtime, and database parameters.
        </p>
    </div>
</div>

<!-- LinkedIn Demo Notice Banner -->
<div class="alert border-0 shadow-sm d-flex align-items-center gap-3 p-3 mb-4" style="background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); border-left: 4px solid #2563EB !important; border-radius: 12px;">
    <div class="d-flex align-items-center justify-content-center text-primary rounded-circle flex-shrink-0" style="width: 44px; height: 44px; background: #FFFFFF; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15); font-size: 1.35rem;">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    <div class="flex-grow-1">
        <div class="fw-bold text-dark d-flex align-items-center gap-2" style="font-size: 0.95rem;">
            <span>Public Demo Mode Active</span>
            <span class="badge bg-primary text-white rounded-pill px-2.5 py-0.5" style="font-size: 0.7rem;">PORTFOLIO SAFEGUARD</span>
        </div>
        <div class="text-secondary small mt-0.5">
            To ensure every recruiter and reviewer visiting from LinkedIn has uninterrupted access, credentials editing and password changes are securely locked in read-only mode.
        </div>
    </div>
</div>

<div class="row g-4">

    <!-- Left Column: Profile & Security -->
    <div class="col-lg-7">

        <!-- Admin Profile Details -->
        <div class="card p-4 mb-4 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-person-badge-fill text-primary"></i>
                    <span>Profile Details</span>
                </h5>
                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2.5 py-1 small">
                    <i class="bi bi-lock-fill"></i> Read Only
                </span>
            </div>
            <p class="text-secondary small mb-3">Administrator display name and primary contact email.</p>

            <form action="{{ route('admin.settings.profile') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">Admin Full Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control bg-light"
                        value="{{ $admin->name }}"
                        readonly
                        disabled
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted small">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control bg-light"
                        value="{{ $admin->email }}"
                        readonly
                        disabled
                    >
                    <div class="form-text text-muted small mt-1.5">
                        <i class="bi bi-info-circle me-1"></i> Preserved for public evaluation access.
                    </div>
                </div>

                <button type="button" class="btn btn-secondary d-flex align-items-center gap-2 shadow-sm px-4" disabled style="opacity: 0.65; cursor: not-allowed;">
                    <i class="bi bi-lock-fill"></i>
                    <span>Profile Modification Locked</span>
                </button>
            </form>
        </div>

        <!-- Security / Password Change (LOCKED FOR DEMO) -->
        <div class="card p-4 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <span>Security & Password</span>
                </h5>
                <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold">
                    <i class="bi bi-lock-fill"></i> Disabled in Demo
                </span>
            </div>
            <p class="text-secondary small mb-3">Password alteration is disabled so other LinkedIn reviewers are never locked out.</p>

            <div class="p-3 mb-4 rounded-3 border" style="background: #F8FAFC; border-color: #E2E8F0 !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-dark fw-bold small"><i class="bi bi-key-fill text-primary me-1"></i> Public Demo Admin Credentials:</span>
                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25">Permanent</span>
                </div>
                <div class="d-flex flex-wrap gap-3 small text-secondary">
                    <div><strong>Email:</strong> <code class="text-primary fw-bold">admin@interntrack.com</code></div>
                    <div><strong>Password:</strong> <code class="text-primary fw-bold">password123</code></div>
                </div>
            </div>

            <form action="{{ route('admin.settings.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">Current Password</label>
                    <input
                        type="password"
                        class="form-control bg-light"
                        value="password123"
                        disabled
                        readonly
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">New Password</label>
                    <input
                        type="password"
                        class="form-control bg-light"
                        placeholder="••••••••••••"
                        disabled
                        readonly
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted small">Confirm New Password</label>
                    <input
                        type="password"
                        class="form-control bg-light"
                        placeholder="••••••••••••"
                        disabled
                        readonly
                    >
                </div>

                <button type="button" class="btn btn-secondary d-flex align-items-center gap-2 shadow-sm px-4" disabled style="opacity: 0.65; cursor: not-allowed;">
                    <i class="bi bi-lock-fill"></i>
                    <span>Password Change Disabled</span>
                </button>
            </form>
        </div>

    </div>

    <!-- Right Column: System Diagnostics -->
    <div class="col-lg-5">

        <!-- Active Admin Session Profile -->
        <div class="card p-4 mb-4 shadow-sm border-0">
            <h5 class="fw-bold mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                <i class="bi bi-person-check-fill text-success"></i>
                <span>Active Admin Session</span>
            </h5>

            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="sidebar-user-avatar" style="width: 50px; height: 50px; font-size: 1.2rem; background: linear-gradient(135deg, #3454D1 0%, #6366F1 100%);">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-bold fs-6 text-dark">{{ $admin->name }}</div>
                    <div class="text-muted small">{{ $admin->email }}</div>
                    <span class="badge bg-primary-subtle text-primary mt-1">Super Administrator</span>
                </div>
            </div>

            <div class="bg-light p-3 rounded-3 border small">
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Account Status:</span>
                    <span class="badge bg-success-subtle text-success fw-semibold">Active Verified</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Session Driver:</span>
                    <span class="fw-semibold text-dark">{{ config('session.driver') }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Last Activity:</span>
                    <span class="text-dark">{{ now()->format('H:i, d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- System & Runtime Diagnostics -->
        <div class="card p-4 shadow-sm border-0">
            <h5 class="fw-bold mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                <i class="bi bi-hdd-network text-info"></i>
                <span>Runtime Environment</span>
            </h5>

            @php
                $sys = $system ?? $systemInfo ?? [
                    'laravel_version' => app()->version(),
                    'php_version' => PHP_VERSION,
                    'db_connection' => config('database.default'),
                    'environment' => config('app.env'),
                    'timezone' => config('app.timezone', 'UTC'),
                ];
            @endphp
            <div class="list-group list-group-flush small">
                <div class="list-group-item px-0 py-2.5 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Framework Version</span>
                    <span class="badge bg-light text-dark border">{{ $sys['laravel_version'] ?? app()->version() }}</span>
                </div>
                <div class="list-group-item px-0 py-2.5 d-flex justify-content-between align-items-center">
                    <span class="text-muted">PHP Engine</span>
                    <span class="badge bg-light text-dark border">{{ $sys['php_version'] ?? PHP_VERSION }}</span>
                </div>
                <div class="list-group-item px-0 py-2.5 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Database Server</span>
                    <span class="badge bg-success-subtle text-success fw-semibold">{{ $sys['db_connection'] ?? config('database.default') }} (Online)</span>
                </div>
                <div class="list-group-item px-0 py-2.5 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Application Environment</span>
                    <span class="badge bg-info-subtle text-info text-capitalize">{{ $sys['environment'] ?? config('app.env') }}</span>
                </div>
                <div class="list-group-item px-0 py-2.5 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Server Timezone</span>
                    <span class="text-dark fw-medium">{{ $sys['timezone'] ?? config('app.timezone', 'UTC') }}</span>
                </div>
                <div class="list-group-item px-0 py-2.5 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Flutter API Guard</span>
                    <span class="badge bg-purple-subtle text-purple fw-semibold" style="background:#F3E8FF; color:#7E22CE;">Sanctum v3</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-center">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out from Admin Panel</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

@endsection
