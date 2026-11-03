@extends('admin.layouts.app')

@section('title', 'Internships Master Directory')

@section('breadcrumb')
    <li class="active-item">Internships Master</li>
@endsection

@section('content')

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Internship Opportunities</h3>
            <span class="badge bg-purple-subtle text-purple border border-purple border-opacity-25 rounded-pill px-2.5 py-1 small" style="background:#F3E8FF; color:#7E22CE;">
                Job Board
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Curate, publish, monitor, and regulate student internship openings across all partner employers.
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.internships.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Post New Internship</span>
        </a>
        <a href="{{ route('admin.reports.export', 'internships') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm bg-white">
            <i class="bi bi-file-earmark-arrow-down text-primary"></i>
            <span>Export CSV</span>
        </a>
    </div>
</div>

<!-- 4 Top KPI Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Total Listings</span>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ number_format($metrics['total'] ?? $internships->total()) }}</div>
                </div>
                <div class="stat-icon purple" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                All openings posted
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Actively Recruiting</span>
                    <div class="fs-4 fw-bold text-success mt-1">{{ number_format($metrics['active'] ?? 0) }}</div>
                </div>
                <div class="stat-icon success" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
            </div>
            <div class="text-success small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-check2"></i> Open for student applicants
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Remote Opportunities</span>
                    <div class="fs-4 fw-bold text-info mt-1">{{ number_format($metrics['remote'] ?? 0) }}</div>
                </div>
                <div class="stat-icon teal" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-laptop-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Work from anywhere roles
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Total Applications</span>
                    <div class="fs-4 fw-bold text-primary mt-1">{{ number_format($metrics['total_applications'] ?? 0) }}</div>
                </div>
                <div class="stat-icon primary" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-send-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Submitted by candidate students
            </div>
        </div>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="card p-3 mb-4 shadow-sm border-0">
    <form method="GET" action="{{ route('admin.internships') }}" class="row g-2 align-items-center">

        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Search by job title, skills, company..."
                    value="{{ $search }}"
                >
            </div>
        </div>

        <div class="col-md-2">
            <select name="work_type" class="form-select">
                <option value="">All Work Types</option>
                <option value="remote" {{ $workType === 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="onsite" {{ $workType === 'onsite' ? 'selected' : '' }}>Onsite</option>
                <option value="hybrid" {{ $workType === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Status</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="closed" {{ $status === 'closed' ? 'selected' : '' }}>Closed Only</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1.5 shadow-sm">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
        </div>

        @if($search || $workType || $categoryId || $status || $location)
            <div class="col-auto">
                <a href="{{ route('admin.internships') }}" class="btn btn-light border text-secondary">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
            </div>
        @endif

        <div class="col-auto ms-auto text-muted small">
            Showing <strong>{{ $internships->firstItem() ?? 0 }} - {{ $internships->lastItem() ?? 0 }}</strong> of <strong>{{ $internships->total() }}</strong> records
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
                    <th>Role & Category</th>
                    <th>Company</th>
                    <th>Work Type</th>
                    <th>Location & Duration</th>
                    <th>Stipend</th>
                    <th>Applicants</th>
                    <th>Status</th>
                    <th>Posted</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($internships as $job)
                    @php
                        $workTypeBadge = match(strtolower($job->work_type)) {
                            'remote' => 'bg-teal-subtle text-teal',
                            'hybrid' => 'bg-purple-subtle text-purple',
                            default => 'bg-primary-subtle text-primary'
                        };
                    @endphp
                    <tr>
                        <td class="text-muted small">
                            {{ $internships->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div>
                                <a href="{{ route('admin.internships.show', $job->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                    {{ $job->title }}
                                </a>
                                <div class="d-flex align-items-center gap-1.5 mt-1">
                                    @if($job->category)
                                        <span class="badge bg-light text-secondary border" style="font-size:0.7rem;">
                                            <i class="bi bi-tag me-1"></i>{{ $job->category->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted border" style="font-size:0.7rem;">General</span>
                                    @endif

                                    @if($job->skills)
                                        <span class="text-muted small text-truncate" style="max-width: 140px; font-size: 0.7rem;" title="{{ $job->skills }}">
                                            • {{ $job->skills }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="sidebar-user-avatar" style="width:28px; height:28px; font-size:0.7rem; border-radius: 6px;">
                                    <i class="bi bi-buildings"></i>
                                </div>
                                <div class="fw-semibold text-dark">
                                    {{ $job->company->name ?? 'Employer' }}
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="badge {{ $workTypeBadge }} fw-semibold px-2.5 py-1 text-capitalize" style="font-size: 0.75rem;">
                                {{ $job->work_type }}
                            </span>
                        </td>

                        <td>
                            <div class="fw-medium text-dark small">
                                <i class="bi bi-geo-alt text-danger me-1"></i>{{ $job->location ?: 'Not specified' }}
                            </div>
                            <div class="text-muted" style="font-size: 0.725rem;">
                                <i class="bi bi-calendar3 me-1"></i>{{ $job->duration ?: 'Flexible' }}
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-success-subtle text-success fw-bold px-2 py-1" style="font-size: 0.75rem;">
                                {{ $job->stipend ? '₹' . number_format((float) preg_replace('/[^0-9.]/', '', $job->stipend)) : 'Unpaid' }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('admin.applications', ['search' => $job->title]) }}" class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1.5 text-decoration-none">
                                <i class="bi bi-people me-1"></i>
                                {{ $job->applications_count }}
                            </a>
                        </td>

                        <td>
                            <span class="badge-status {{ $job->status === 'active' ? 'active' : 'inactive' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>

                        <td class="text-muted small">
                            {{ $job->created_at ? $job->created_at->format('M d, Y') : '—' }}
                        </td>

                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.internships.show', $job->id) }}" class="btn btn-light border" title="Preview Listing">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>

                                <a href="{{ route('admin.internships.edit', $job->id) }}" class="btn btn-light border" title="Edit Listing">
                                    <i class="bi bi-pencil-square text-secondary"></i>
                                </a>

                                <form action="{{ route('admin.internships.toggle-status', $job->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-light border {{ $job->status === 'active' ? 'text-warning' : 'text-success' }}"
                                        title="{{ $job->status === 'active' ? 'Close Internship Listing' : 'Reactivate Internship Listing' }}"
                                        onclick="return confirm('Toggle status for {{ addslashes($job->title) }}?')"
                                    >
                                        <i class="bi {{ $job->status === 'active' ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.internships.destroy', $job->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-light border text-danger"
                                        title="Delete Internship"
                                        onclick="return confirm('Delete {{ addslashes($job->title) }}? Associated applications will also be removed.')"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="bi bi-briefcase fs-1 text-secondary opacity-50 d-block mb-2"></i>
                            <h6 class="fw-bold mb-1">No internships found</h6>
                            <p class="small text-secondary mb-3">Post a new internship opening or adjust search filters.</p>
                            <a href="{{ route('admin.internships.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Post New Internship
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($internships->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="small text-muted">
                Showing {{ $internships->firstItem() }} to {{ $internships->lastItem() }} of {{ $internships->total() }} internships
            </div>
            <div>
                {{ $internships->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

@endsection
