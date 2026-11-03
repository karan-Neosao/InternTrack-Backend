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

<div class="row g-4">

    <!-- Left Column: Profile & Security -->
    <div class="col-lg-7">

        <!-- Admin Profile Details -->
        <div class="card p-4 mb-4 shadow-sm border-0">
            <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-person-badge-fill text-primary"></i>
                <span>Profile Details</span>
            </h5>
            <p class="text-secondary small mb-4">Update your display name and administrative notification email.</p>

            <form action="{{ route('admin.settings.profile') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Admin Full Name <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $admin->name) }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $admin->email) }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-4">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Save Profile Changes</span>
                </button>
            </form>
        </div>

        <!-- Security / Password Change -->
        <div class="card p-4 shadow-sm border-0">
            <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock-fill text-warning"></i>
                <span>Security & Password</span>
            </h5>
            <p class="text-secondary small mb-4">Ensure your account is protected with a strong, secure passphrase.</p>

            <form action="{{ route('admin.settings.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                    <input
                        type="password"
                        name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                    >
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimum 8 characters"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Re-enter new password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-4">
                    <i class="bi bi-key-fill"></i>
                    <span>Update Password</span>
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
