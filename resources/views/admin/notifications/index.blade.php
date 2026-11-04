@extends('admin.layouts.app')

@section('title', 'System Alerts & Notifications')

@section('breadcrumb')
    <li class="active-item">Notifications Center</li>
@endsection

@section('content')

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Alert & Notification Center</h3>
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1 small">
                Live Dispatch
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Real-time platform logs, student applications, company registrations, and Flutter mobile push integration.
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        @if($unreadCount > 0)
            <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-check2-all"></i>
                    <span>Mark All as Read</span>
                </button>
            </form>
        @endif
    </div>
</div>

<!-- 4 Top KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.notifications') }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="View All Notifications">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Total Alerts</span>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ number_format($totalCount) }}</div>
                </div>
                <div class="stat-icon primary" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-bell-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Historical notification volume
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.notifications', ['filter' => 'unread']) }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="Filter Unread Notifications">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Unread Items</span>
                    <div class="fs-4 fw-bold text-danger mt-1">{{ number_format($unreadCount) }}</div>
                </div>
                <div class="stat-icon danger" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-envelope-exclamation-fill"></i>
                </div>
            </div>
            <div class="text-danger small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-dot"></i> Needs administrator attention
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.notifications', ['filter' => 'read']) }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="Filter Read Notifications">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Read Archive</span>
                    <div class="fs-4 fw-bold text-success mt-1">{{ number_format(max(0, $totalCount - $unreadCount)) }}</div>
                </div>
                <div class="stat-icon success" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-envelope-check-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Reviewed notices
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.settings') }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="View System Settings">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">FCM Mobile Push</span>
                    <div class="fs-4 fw-bold text-info mt-1">Ready</div>
                </div>
                <div class="stat-icon teal" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-broadcast"></i>
                </div>
            </div>
            <div class="text-info small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-shield-check"></i> Sanctum token channel
            </div>
        </a>
    </div>
</div>

<div class="row g-4">

    <!-- Left Column: Notification Feed -->
    <div class="col-lg-8">

        <!-- Tabs Toolbar -->
        <div class="card p-2 mb-3 shadow-sm border-0">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <ul class="nav nav-pills gap-1">
                    <li class="nav-item">
                        <a class="nav-link py-1.5 px-3 {{ $filter === 'all' ? 'active' : '' }}" href="{{ route('admin.notifications', ['filter' => 'all']) }}">
                            All <span class="badge bg-white text-dark ms-1">{{ $totalCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1.5 px-3 {{ $filter === 'unread' ? 'active' : '' }}" href="{{ route('admin.notifications', ['filter' => 'unread']) }}">
                            Unread <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1.5 px-3 {{ $filter === 'read' ? 'active' : '' }}" href="{{ route('admin.notifications', ['filter' => 'read']) }}">
                            Read Archive
                        </a>
                    </li>
                </ul>

                <span class="text-muted small pe-2">
                    Showing {{ $notifications->count() }} alerts
                </span>
            </div>
        </div>

        <!-- Notification List -->
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="list-group list-group-flush">
                @forelse($notifications as $note)
                    @php
                        $isUnread = !$note->read_at;
                    @endphp
                    <div class="list-group-item p-3.5 d-flex align-items-start gap-3 transition-all {{ $isUnread ? 'bg-light bg-opacity-50 border-start border-primary border-3' : '' }}">

                        <div class="stat-icon {{ $isUnread ? 'primary' : 'teal' }} flex-shrink-0" style="width:42px; height:42px; font-size:1.1rem; border-radius:10px;">
                            <i class="bi {{ $note->data['icon'] ?? 'bi-bell-fill' }}"></i>
                        </div>

                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-dark">
                                        {{ $note->data['title'] ?? 'System Alert' }}
                                    </h6>
                                    @if($isUnread)
                                        <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size:0.65rem;">NEW</span>
                                    @endif
                                </div>
                                <span class="text-muted small">
                                    <i class="bi bi-clock me-1"></i>{{ $note->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p class="text-secondary small mb-2" style="line-height: 1.45;">
                                {{ $note->data['message'] ?? 'No notification details available.' }}
                            </p>

                            <div class="d-flex align-items-center gap-2 mt-2">
                                @if(!empty($note->data['link']))
                                    <a href="{{ route('admin.notifications.show', $note->id) }}" class="btn btn-sm btn-primary py-1 px-2.5 small" style="font-size:0.75rem;">
                                        <span>View Action</span>
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                @endif

                                @if($isUnread)
                                    <form action="{{ route('admin.notifications.read', $note->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-light border py-1 px-2 text-muted" style="font-size:0.75rem;">
                                            <i class="bi bi-check me-1"></i>Mark Read
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.notifications.destroy', $note->id) }}" method="POST" class="ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border py-1 px-2 text-danger" style="font-size:0.75rem;" title="Delete Alert">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-bell-slash fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        <h6 class="fw-bold text-dark mb-1">No Notifications In This Filter</h6>
                        <p class="small text-muted mb-0">You are all caught up! New alerts will stream here as students apply or companies join.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="p-3 border-top bg-white">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>

    <!-- Right Column: Push Notification / FCM Architecture Info -->
    <div class="col-lg-4">

        <div class="card p-4 mb-4 shadow-sm border-0">
            <h5 class="fw-bold mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                <i class="bi bi-broadcast text-primary"></i>
                <span>Mobile Push Dispatch</span>
            </h5>
            <p class="text-secondary small mb-3">
                InternTrack is equipped with database event listeners ready for <strong>Firebase Cloud Messaging (FCM)</strong> delivery to the Flutter mobile client.
            </p>

            <div class="bg-light p-3 rounded-3 border mb-3 small">
                <div class="fw-semibold text-dark mb-1">Infrastructure Status:</div>
                <ul class="mb-0 ps-3 text-secondary">
                    <li>Database notifications schema active</li>
                    <li>Automatic candidate alert triggers</li>
                    <li>Status change event listeners hooked</li>
                    <li>FCM device token payload ready</li>
                </ul>
            </div>

            <div class="alert alert-info py-2 px-3 small mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill fs-5"></i>
                <div>
                    Admins and students receive notifications in real-time when application stages transition.
                </div>
            </div>
        </div>

        <div class="card p-4 shadow-sm border-0">
            <h6 class="fw-bold mb-2">Platform System Notice</h6>
            <p class="text-secondary small mb-3">
                Need to announce scheduled maintenance or new internship placement drives to all users?
            </p>
            <a href="mailto:admin@interntrack.com" class="btn btn-outline-secondary w-100 btn-sm">
                <i class="bi bi-envelope me-1"></i> Contact Tech Support
            </a>
        </div>

    </div>

</div>

@endsection
