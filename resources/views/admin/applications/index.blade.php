@extends('admin.layouts.app')

@section('title', 'Applications Master Directory')

@section('breadcrumb')
    <li class="active-item">Applications Master</li>
@endsection

@section('content')

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Candidate Applications</h3>
            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2.5 py-1 small">
                Recruitment Pipeline
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Supervise application submissions, track candidate review statuses, and review candidate resumes.
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.reports.export', 'applications') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm bg-white">
            <i class="bi bi-file-earmark-arrow-down text-warning"></i>
            <span>Export CSV</span>
        </a>
    </div>
</div>

<!-- 4 Top KPI Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.applications') }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="View All Applications">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Total Received</span>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ number_format($metrics['total'] ?? $applications->total()) }}</div>
                </div>
                <div class="stat-icon warning" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-inbox-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                All applications on portal
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.applications', ['status' => 'pending']) }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="Filter Pending Review">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Pending Review</span>
                    <div class="fs-4 fw-bold text-warning mt-1">{{ number_format($metrics['pending'] ?? 0) }}</div>
                </div>
                <div class="stat-icon warning" style="width: 38px; height: 38px; font-size: 1.1rem; background: #FFFBEB; color: #D97706;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <div class="text-warning small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-exclamation-circle"></i> Requires attention
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.applications', ['status' => 'reviewed']) }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="Filter Under Review">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Under Review</span>
                    <div class="fs-4 fw-bold text-primary mt-1">{{ number_format($metrics['reviewed'] ?? 0) }}</div>
                </div>
                <div class="stat-icon primary" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-search"></i>
                </div>
            </div>
            <div class="text-primary small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-arrow-repeat"></i> Interview stage
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.applications', ['status' => 'accepted']) }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="Filter Accepted Offers">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Offers Accepted</span>
                    <div class="fs-4 fw-bold text-success mt-1">{{ number_format($metrics['accepted'] ?? 0) }}</div>
                </div>
                <div class="stat-icon success" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-trophy-fill"></i>
                </div>
            </div>
            <div class="text-success small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-check-all"></i> Placements successful
            </div>
        </a>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="card p-3 mb-4 shadow-sm border-0">
    <form method="GET" action="{{ route('admin.applications') }}" class="row g-2 align-items-center">

        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Search candidate name, email, or role..."
                    value="{{ $search }}"
                >
            </div>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Review Stages</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending Review</option>
                <option value="reviewed" {{ $status === 'reviewed' ? 'selected' : '' }}>Under Review</option>
                <option value="accepted" {{ $status === 'accepted' ? 'selected' : '' }}>Accepted Offers</option>
                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="company_id" class="form-select">
                <option value="">All Companies</option>
                @foreach($companies as $comp)
                    <option value="{{ $comp->id }}" {{ $companyId == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1.5 shadow-sm">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
        </div>

        @if($search || $status || $companyId)
            <div class="col-auto">
                <a href="{{ route('admin.applications') }}" class="btn btn-light border text-secondary">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
            </div>
        @endif

        <div class="col-auto ms-auto text-muted small">
            Showing <strong>{{ $applications->firstItem() ?? 0 }} - {{ $applications->lastItem() ?? 0 }}</strong> of <strong>{{ $applications->total() }}</strong> records
        </div>

    </form>
</div>

<!-- Table Card -->
<div class="card shadow-sm border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Candidate</th>
                    <th>Internship Role & Company</th>
                    <th>Resume</th>
                    <th>Stage</th>
                    <th>Applied Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    @php
                        $avatarColors = ['#3454D1', '#0EA5E9', '#10B981', '#8B5CF6', '#F59E0B', '#EC4899'];
                        $bgColor = $avatarColors[$app->student_id % count($avatarColors)];
                        $statusClass = match(strtolower($app->status ?? 'pending')) {
                            'accepted' => 'active',
                            'reviewed' => 'active',
                            'rejected' => 'inactive',
                            default => 'pending'
                        };
                    @endphp
                    <tr>
                        <td class="text-muted small">
                            {{ $applications->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="sidebar-user-avatar" style="width:38px; height:38px; font-size:0.875rem; background: {{ $bgColor }};">
                                    {{ strtoupper(substr($app->student->name ?? 'C', 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.applications.show', $app->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                        {{ $app->student->name ?? 'Candidate' }}
                                    </a>
                                    <div class="text-muted small">{{ $app->student->email ?? '' }}</div>
                                    @if($app->student?->studentProfile?->college)
                                        <div class="text-secondary" style="font-size:0.75rem;">
                                            <i class="bi bi-mortarboard me-1"></i>{{ $app->student->studentProfile->college }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="fw-bold text-dark">
                                {{ $app->internship->title ?? 'N/A' }}
                            </div>
                            <div class="text-muted small d-flex align-items-center gap-1.5 mt-0.5">
                                <i class="bi bi-buildings text-secondary"></i>
                                <span>{{ $app->internship?->company?->name ?? 'Employer' }}</span>
                                <span>•</span>
                                <span class="badge bg-light text-secondary border">{{ ucfirst($app->internship?->work_type ?? 'Role') }}</span>
                            </div>
                        </td>

                        <td>
                            @php
                                $hasResume = $app->resume_path || $app->student?->studentProfile?->resume_path;
                            @endphp
                            @if($hasResume)
                                <a href="{{ route('admin.applications.resume', $app->id) }}" class="btn btn-sm btn-light border text-danger d-inline-flex align-items-center gap-1.5" title="Download Candidate Resume">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                    <span style="font-size: 0.75rem;">View PDF</span>
                                </a>
                            @else
                                <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">No Resume</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.applications.status', $app->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select
                                    name="status"
                                    class="form-select form-select-sm border-0 fw-semibold {{ $statusClass === 'active' ? 'text-success bg-success-subtle' : ($statusClass === 'inactive' ? 'text-danger bg-danger-subtle' : 'text-warning bg-warning-subtle') }}"
                                    style="width: 130px; font-size: 0.8rem;"
                                    onchange="this.form.submit()"
                                >
                                    <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="reviewed" {{ $app->status === 'reviewed' ? 'selected' : '' }}>🔍 Reviewed</option>
                                    <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>✅ Accepted</option>
                                    <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                </select>
                            </form>
                        </td>

                        <td class="text-muted small">
                            <div>{{ $app->created_at ? $app->created_at->format('M d, Y') : '—' }}</div>
                            <div class="text-secondary" style="font-size:0.7rem;">{{ $app->created_at ? $app->created_at->diffForHumans() : '' }}</div>
                        </td>

                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-light border" title="Review Full Details">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>

                                <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-light border text-danger"
                                        title="Delete Application"
                                        onclick="return confirm('Remove application from {{ addslashes($app->student->name ?? 'Student') }}?')"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-send fs-1 text-secondary opacity-50 d-block mb-2"></i>
                            <h6 class="fw-bold mb-1">No candidate applications found</h6>
                            <p class="small text-secondary mb-3">Try adjusting your filters or search criteria.</p>
                            <a href="{{ route('admin.applications') }}" class="btn btn-sm btn-outline-primary">
                                Clear Filters
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($applications->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="small text-muted">
                Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} applications
            </div>
            <div>
                {{ $applications->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

@endsection
