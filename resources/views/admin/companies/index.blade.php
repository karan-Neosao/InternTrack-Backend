@extends('admin.layouts.app')

@section('title', 'Companies Master Directory')

@section('breadcrumb')
    <li class="active-item">Companies Master</li>
@endsection

@section('content')

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Hiring Partners & Companies</h3>
            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-2.5 py-1 small">
                Employer Network
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Review employer profiles, grant official partner verification, and oversee internship postings.
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.reports.export', 'companies') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm bg-white">
            <i class="bi bi-file-earmark-arrow-down text-info"></i>
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
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Total Companies</span>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ number_format($metrics['total'] ?? $companies->total()) }}</div>
                </div>
                <div class="stat-icon teal" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-buildings-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                All employer accounts
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Verified Partners</span>
                    <div class="fs-4 fw-bold text-primary mt-1">{{ number_format($metrics['verified'] ?? 0) }}</div>
                </div>
                <div class="stat-icon primary" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
            </div>
            <div class="text-primary small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-shield-check"></i> Verified badges granted
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Active Employers</span>
                    <div class="fs-4 fw-bold text-success mt-1">{{ number_format($metrics['active'] ?? 0) }}</div>
                </div>
                <div class="stat-icon success" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-person-check-fill"></i>
                </div>
            </div>
            <div class="text-success small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-check2"></i> Can login & post jobs
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Internships Posted</span>
                    <div class="fs-4 fw-bold text-purple mt-1" style="color: #8B5CF6;">{{ number_format($metrics['total_jobs'] ?? 0) }}</div>
                </div>
                <div class="stat-icon purple" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Openings published across platform
            </div>
        </div>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="card p-3 mb-4 shadow-sm border-0">
    <form method="GET" action="{{ route('admin.companies') }}" class="row g-2 align-items-center">

        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Search by company name, contact, email..."
                    value="{{ $search }}"
                >
            </div>
        </div>

        <div class="col-md-2">
            <select name="industry" class="form-select">
                <option value="">All Industries</option>
                @foreach($industries as $ind)
                    <option value="{{ $ind }}" {{ $industry === $ind ? 'selected' : '' }}>{{ $ind }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="verified" class="form-select">
                <option value="">Verification Status</option>
                <option value="1" {{ $verified === '1' ? 'selected' : '' }}>Verified Partners</option>
                <option value="0" {{ $verified === '0' ? 'selected' : '' }}>Unverified</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Account Status</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1.5 shadow-sm">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
        </div>

        @if($search || $industry || ($verified !== null && $verified !== '') || ($status !== null && $status !== ''))
            <div class="col-auto">
                <a href="{{ route('admin.companies') }}" class="btn btn-light border text-secondary">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
            </div>
        @endif

        <div class="col-auto ms-auto text-muted small">
            Showing <strong>{{ $companies->firstItem() ?? 0 }} - {{ $companies->lastItem() ?? 0 }}</strong> of <strong>{{ $companies->total() }}</strong> records
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
                    <th>Company</th>
                    <th>Industry & Location</th>
                    <th>Website</th>
                    <th>Verification</th>
                    <th>Openings</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    @php
                        $avatarColors = ['#0EA5E9', '#3454D1', '#10B981', '#8B5CF6', '#F59E0B', '#14B8A6'];
                        $bgColor = $avatarColors[$company->id % count($avatarColors)];
                        $companyName = $company->companyProfile?->company_name ?: $company->name;
                        $isVerified = (bool) ($company->companyProfile?->is_verified ?? false);
                    @endphp
                    <tr>
                        <td class="text-muted small">
                            {{ $companies->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="sidebar-user-avatar" style="width:40px; height:40px; font-size:0.95rem; background: {{ $bgColor }}; border-radius: 10px;">
                                    <i class="bi bi-buildings"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-1.5">
                                        <a href="{{ route('admin.companies.show', $company->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                            {{ $companyName }}
                                        </a>
                                        @if($isVerified)
                                            <i class="bi bi-patch-check-fill text-primary" title="Verified Employer Partner"></i>
                                        @endif
                                    </div>
                                    <div class="text-muted small">{{ $company->email }}</div>
                                    @if($company->companyProfile?->phone)
                                        <div class="text-secondary" style="font-size:0.75rem;">
                                            <i class="bi bi-telephone me-1"></i>{{ $company->companyProfile->phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="fw-semibold text-dark">
                                {{ $company->companyProfile?->industry ?? 'Industry not set' }}
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-geo-alt text-danger me-1"></i>
                                {{ $company->companyProfile?->location ?? 'Location not set' }}
                            </div>
                        </td>

                        <td>
                            @if($company->companyProfile?->website)
                                <a href="{{ $company->companyProfile->website }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-light border text-primary small d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-globe2"></i>
                                    <span style="font-size: 0.75rem;">Visit</span>
                                    <i class="bi bi-box-arrow-up-right" style="font-size: 0.65rem;"></i>
                                </a>
                            @else
                                <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">None</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.companies.toggle-verify', $company->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button
                                    type="submit"
                                    class="badge border-0 {{ $isVerified ? 'bg-primary-subtle text-primary' : 'bg-light text-secondary border' }} px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1 text-decoration-none cursor-pointer"
                                    title="Click to toggle partner verification badge"
                                >
                                    <i class="bi {{ $isVerified ? 'bi-patch-check-fill' : 'bi-dash-circle' }}"></i>
                                    <span>{{ $isVerified ? 'Verified' : 'Unverified' }}</span>
                                </button>
                            </form>
                        </td>

                        <td>
                            <a href="{{ route('admin.internships', ['search' => $companyName]) }}" class="badge bg-purple-subtle text-purple fw-semibold px-2.5 py-1.5 text-decoration-none" style="background: #F3E8FF; color: #7E22CE;">
                                <i class="bi bi-briefcase me-1"></i>
                                {{ $company->internships_count }} roles
                            </a>
                        </td>

                        <td>
                            <span class="badge-status {{ $company->is_active ? 'active' : 'inactive' }}">
                                {{ $company->is_active ? 'Active' : 'Suspended' }}
                            </span>
                        </td>

                        <td class="text-muted small">
                            {{ $company->created_at ? $company->created_at->format('M d, Y') : '—' }}
                        </td>

                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.companies.show', $company->id) }}" class="btn btn-light border" title="View Company Profile & Jobs">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>

                                <form action="{{ route('admin.companies.toggle-status', $company->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-light border {{ $company->is_active ? 'text-warning' : 'text-success' }}"
                                        title="{{ $company->is_active ? 'Suspend Company Account' : 'Activate Company Account' }}"
                                        onclick="return confirm('Toggle account status for {{ addslashes($companyName) }}?')"
                                    >
                                        <i class="bi {{ $company->is_active ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-light border text-danger"
                                        title="Delete Company"
                                        onclick="return confirm('Permanently delete {{ addslashes($companyName) }} and associated internships/applications? This action cannot be reversed.')"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-buildings fs-1 text-secondary opacity-50 d-block mb-2"></i>
                            <h6 class="fw-bold mb-1">No employer companies found</h6>
                            <p class="small text-secondary mb-3">Try adjusting your filters or search keywords.</p>
                            <a href="{{ route('admin.companies') }}" class="btn btn-sm btn-outline-primary">
                                Clear Filters
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($companies->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="small text-muted">
                Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of {{ $companies->total() }} companies
            </div>
            <div>
                {{ $companies->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

@endsection
