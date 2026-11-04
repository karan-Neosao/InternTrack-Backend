@extends('admin.layouts.app')

@section('title', 'Admin Settings & Activity Logs')

@section('breadcrumb')
    <li class="active-item">Settings & Logs</li>
@endsection

@section('content')

@php
    $activeTab = request()->query('tab', request()->has('search') ? 'activity' : 'general');
@endphp

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Account &amp; System Settings</h3>
            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2.5 py-1 small">
                Security & Activity
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Manage admin security credentials, runtime diagnostics, and monitor real-time website visitor activity & IP logs.
        </p>
    </div>

    <!-- Quick Navigation Pills -->
    <ul class="nav nav-pills bg-white p-1 rounded-3 shadow-sm border" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'general' ? 'active' : '' }} d-flex align-items-center gap-2 px-3 py-2 fw-semibold small"
                    id="general-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#general-pane"
                    type="button"
                    role="tab">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Profile & Security</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'activity' ? 'active' : '' }} d-flex align-items-center gap-2 px-3 py-2 fw-semibold small"
                    id="activity-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#activity-pane"
                    type="button"
                    role="tab">
                <i class="bi bi-activity"></i>
                <span>Visitor & Activity Logs</span>
                <span class="badge {{ $activeTab === 'activity' ? 'bg-white text-primary' : 'bg-primary text-white' }} rounded-pill px-2 ms-1">
                    {{ number_format($activityStats['total_visits'] ?? 0) }}
                </span>
            </button>
        </li>
    </ul>
</div>

<!-- Tab Content -->
<div class="tab-content" id="settingsTabsContent">

    <!-- TAB 1: General & Security -->
    <div class="tab-pane fade {{ $activeTab === 'general' ? 'show active' : '' }}" id="general-pane" role="tabpanel">

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
                <div class="card p-4 mb-4 shadow-sm border-0 rounded-3">
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
                <div class="card p-4 shadow-sm border-0 rounded-3">
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
                <div class="card p-4 mb-4 shadow-sm border-0 rounded-3">
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
                <div class="card p-4 shadow-sm border-0 rounded-3">
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
                            <span class="text-muted">Visitor Activity Tracking</span>
                            <span class="badge bg-success-subtle text-success fw-semibold">Live & Active</span>
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

    </div>

    <!-- TAB 2: Visitor & Activity Logs -->
    <div class="tab-pane fade {{ $activeTab === 'activity' ? 'show active' : '' }}" id="activity-pane" role="tabpanel">

        <!-- Analytics Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card p-3 border-0 shadow-sm rounded-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-primary" style="width: 50px; height: 50px; background: rgba(37, 99, 235, 0.1); font-size: 1.5rem;">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <div>
                        <div class="text-secondary small fw-medium">Total Website Visits</div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($activityStats['total_visits'] ?? 0) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card p-3 border-0 shadow-sm rounded-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-success" style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); font-size: 1.5rem;">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                    <div>
                        <div class="text-secondary small fw-medium">Unique IP Addresses</div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($activityStats['unique_ips'] ?? 0) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card p-3 border-0 shadow-sm rounded-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-info" style="width: 50px; height: 50px; background: rgba(6, 182, 212, 0.1); font-size: 1.5rem;">
                        <i class="bi bi-calendar2-check-fill"></i>
                    </div>
                    <div>
                        <div class="text-secondary small fw-medium">Today's Visits</div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($activityStats['today_visits'] ?? 0) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card p-3 border-0 shadow-sm rounded-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-warning" style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.1); font-size: 1.5rem;">
                        <i class="bi bi-person-fill-lock"></i>
                    </div>
                    <div>
                        <div class="text-secondary small fw-medium">User / Guest Visits</div>
                        <div class="fs-4 fw-bold text-dark">
                            {{ $activityStats['logged_in_visits'] ?? 0 }} <span class="fs-6 text-muted fw-normal">/ {{ $activityStats['guest_visits'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Logs Card -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="p-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check text-primary"></i>
                        <span>Live Visitor & User Activity Log</span>
                    </h5>
                    <p class="text-secondary small mb-0">Records visitor name, recognized identity, IP address, ISP, location, and timestamps.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <!-- Search Filter Form -->
                    <form method="GET" action="{{ route('admin.settings') }}" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="tab" value="activity">
                        <div class="input-group input-group-sm" style="min-width: 240px;">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   name="search"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Search by name, IP, city, ISP..."
                                   class="form-control border-start-0 ps-0">
                        </div>
                        @if(!empty($search))
                            <a href="{{ route('admin.settings', ['tab' => 'activity']) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </form>

                    <!-- Clear Logs Button -->
                    <button type="button"
                            class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1.5"
                            data-bs-toggle="modal"
                            data-bs-target="#clearLogsModal">
                        <i class="bi bi-trash3"></i>
                        <span>Clear Logs</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-3 py-3" style="min-width: 240px;">Visitor / Identified Name</th>
                            <th class="py-3">Role / Status</th>
                            <th class="py-3" style="min-width: 220px;">IP Address &amp; Location</th>
                            <th class="py-3">Viewed Page / Action</th>
                            <th class="py-3">Device &amp; Browser</th>
                            <th class="pe-3 py-3 text-end">Visited Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <!-- User / Visitor Name & Avatar -->
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                             style="width: 38px; height: 38px; font-size: 0.85rem; background: {{ $log->user_role === 'admin' ? '#2563EB' : ($log->user_role === 'student' ? '#10B981' : ($log->user_role === 'company' ? '#8B5CF6' : ($log->custom_label ? '#F59E0B' : '#64748B'))) }};">
                                            {{ strtoupper(substr($log->user_name ?: 'G', 0, 1)) }}
                                        </div>
                                        <div class="text-truncate" style="max-width: 220px;">
                                            <div class="d-flex align-items-center gap-1.5">
                                                <span class="fw-bold text-dark text-truncate">{{ $log->user_name ?: 'Guest Visitor' }}</span>
                                                @if($log->custom_label)
                                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning border-opacity-25 rounded-pill px-1.5 py-0.5" style="font-size:0.65rem;" title="Admin Named Visitor">
                                                        <i class="bi bi-tag-fill"></i> Named
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-secondary small text-truncate">
                                                @if($log->city || $log->country)
                                                    <span><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $log->city ? $log->city . ', ' : '' }}{{ $log->country }}</span>
                                                @else
                                                    {{ $log->user_email ?: 'Anonymous' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role Badge -->
                                <td>
                                    @if($log->user_role === 'admin')
                                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1">
                                            <i class="bi bi-shield-fill me-1"></i> Admin
                                        </span>
                                    @elseif($log->user_role === 'student')
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1">
                                            <i class="bi bi-mortarboard-fill me-1"></i> Student
                                        </span>
                                    @elseif($log->user_role === 'company')
                                        <span class="badge bg-info-subtle text-info border border-info border-opacity-25 rounded-pill px-2.5 py-1">
                                            <i class="bi bi-buildings-fill me-1"></i> Company
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2.5 py-1">
                                            <i class="bi bi-person me-1"></i> Public Guest
                                        </span>
                                    @endif
                                </td>

                                <!-- IP Address & Location -->
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-inline-flex align-items-center gap-1.5">
                                            <div class="d-inline-flex align-items-center gap-1.5 bg-light px-2 py-0.5 rounded-2 border">
                                                <i class="bi bi-hdd-network text-muted small"></i>
                                                <code class="text-dark fw-bold small">{{ $log->ip_address }}</code>
                                            </div>
                                            <!-- Name Person / IP Button -->
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary py-0 px-2 d-flex align-items-center gap-1"
                                                    style="font-size: 0.72rem; height: 24px;"
                                                    onclick="openLabelModal('{{ $log->ip_address }}', '{{ addslashes($log->custom_label ?: ($log->user_role === 'guest' ? '' : $log->user_name)) }}')"
                                                    title="Name this person / IP">
                                                <i class="bi bi-pencil-fill" style="font-size: 0.65rem;"></i>
                                                <span>Name IP</span>
                                            </button>
                                        </div>
                                        @if($log->isp)
                                            <div class="small text-secondary text-truncate" style="max-width: 220px;" title="{{ $log->isp }}">
                                                <i class="bi bi-broadcast text-info me-1"></i>{{ $log->isp }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Viewed Page / Action -->
                                <td>
                                    <div>
                                        <span class="fw-semibold text-dark small d-block">
                                            {{ $log->action ?: 'Page Visit' }}
                                        </span>
                                        <span class="text-muted small text-truncate d-inline-block" style="max-width: 220px;" title="{{ $log->url }}">
                                            <span class="badge bg-light text-secondary border me-1">{{ $log->method }}</span>
                                            {{ parse_url($log->url, PHP_URL_PATH) ?: '/' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Device & Browser -->
                                <td>
                                    <div class="d-flex align-items-center gap-2 small text-secondary">
                                        @if(str_contains(strtolower($log->device ?? ''), 'mobile') || str_contains(strtolower($log->device ?? ''), 'android') || str_contains(strtolower($log->device ?? ''), 'ios'))
                                            <i class="bi bi-phone text-primary"></i>
                                        @elseif(str_contains(strtolower($log->device ?? ''), 'mac'))
                                            <i class="bi bi-apple text-dark"></i>
                                        @elseif(str_contains(strtolower($log->device ?? ''), 'windows'))
                                            <i class="bi bi-windows text-info"></i>
                                        @else
                                            <i class="bi bi-laptop text-secondary"></i>
                                        @endif
                                        <span>{{ $log->device ?: 'Unknown Device' }}</span>
                                    </div>
                                </td>

                                <!-- Time -->
                                <td class="pe-3 text-end">
                                    <div class="fw-semibold text-dark small">
                                        {{ $log->created_at->diffForHumans() }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        {{ $log->created_at->format('d M Y, h:i A') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-clipboard2-pulse fs-1 text-secondary mb-2 d-block"></i>
                                        <h6 class="fw-bold text-dark">No Activity Logs Found</h6>
                                        <p class="small text-secondary mb-0">No visitor or user activity has been recorded matching your criteria yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
                <div class="p-3 border-top d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} records
                    </div>
                    <div>
                        {{ $logs->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

</div>

<!-- Name / Label IP Modal -->
<div class="modal fade" id="nameIpModal" tabindex="-1" aria-labelledby="nameIpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-primary d-flex align-items-center gap-2" id="nameIpModalLabel">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Name This Visitor / IP Address</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.settings.activity-logs.label') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="alert alert-info py-2 px-3 small border-0 mb-3" style="background: #EFF6FF; color: #1D4ED8;">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        जेव्हा तुम्ही एखाद्या IP Address ला व्यक्तीचे नाव द्याल (उदा. "Karan", "Rohit HR", "Sneha Student"), तेव्हा त्या IP वरून येणाऱ्या <strong>सर्व भूतकाळातील आणि भविष्यातील व्हिजिट्स</strong> त्या व्यक्तीच्या नावाने दिसतील.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">IP Address</label>
                        <input type="text" name="ip_address" id="modalIpAddress" class="form-control bg-light fw-bold" readonly required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">या व्यक्तीचे / संस्थेचे नाव (Person / Organization Name) <span class="text-danger">*</span></label>
                        <input type="text" name="label" id="modalLabelName" class="form-control" placeholder="उदा. Karan, Prof. Kulkarni, HR Infosys" required autofocus>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1.5 shadow-sm">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Save Name &amp; Identify</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Clear Logs Confirmation Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" aria-labelledby="clearLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2" id="clearLogsModalLabel">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Clear All Activity Logs?</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <p class="mb-0 text-secondary">
                    Are you sure you want to permanently delete all visitor tracking and user activity records? This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.settings.activity-logs.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger d-flex align-items-center gap-1.5">
                        <i class="bi bi-trash3-fill"></i>
                        <span>Yes, Delete All Logs</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openLabelModal(ip, currentName) {
    document.getElementById('modalIpAddress').value = ip;
    document.getElementById('modalLabelName').value = currentName || '';
    const modalEl = document.getElementById('nameIpModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Keep tab selection state on reload or hash change
    const tabButtons = document.querySelectorAll('#settingsTabs button[data-bs-toggle="pill"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function (e) {
            const targetId = e.target.getAttribute('data-bs-target').replace('#', '').replace('-pane', '');
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('tab', targetId);
            window.history.replaceState({}, '', newUrl);
        });
    });
});
</script>

@endsection
