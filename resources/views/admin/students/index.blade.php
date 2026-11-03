@extends('admin.layouts.app')

@section('title', 'Students Master Directory')

@section('breadcrumb')
    <li class="active-item">Students Master</li>
@endsection

@section('content')

<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Students Directory</h3>
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1 small">
                Master Database
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Monitor, verify, and manage all enrolled student candidates across colleges and internship applications.
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.reports.export', 'students') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm bg-white">
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
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Total Students</span>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ number_format($metrics['total'] ?? $students->total()) }}</div>
                </div>
                <div class="stat-icon primary" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                All registered candidates
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Active Accounts</span>
                    <div class="fs-4 fw-bold text-success mt-1">{{ number_format($metrics['active'] ?? 0) }}</div>
                </div>
                <div class="stat-icon success" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <div class="text-success small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-check2"></i> Can login & apply
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Resumes Attached</span>
                    <div class="fs-4 fw-bold text-info mt-1">{{ number_format($metrics['with_resume'] ?? 0) }}</div>
                </div>
                <div class="stat-icon teal" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Ready for recruiter review
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Active Applicants</span>
                    <div class="fs-4 fw-bold text-primary mt-1">{{ number_format($metrics['with_applications'] ?? 0) }}</div>
                </div>
                <div class="stat-icon purple" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-send-check-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Applied to at least 1 job
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search Toolbar -->
<div class="card p-3 mb-4 shadow-sm border-0">
    <form method="GET" action="{{ route('admin.students') }}" class="row g-2 align-items-center">

        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Search by student name, email, college, degree, skills..."
                    value="{{ $search }}"
                >
            </div>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses (Active & Inactive)</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive / Suspended Only</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1.5 shadow-sm">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
        </div>

        @if($search || ($status !== null && $status !== ''))
            <div class="col-auto">
                <a href="{{ route('admin.students') }}" class="btn btn-light border text-secondary">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
            </div>
        @endif

        <div class="col-auto ms-auto text-muted small">
            Showing <strong>{{ $students->firstItem() ?? 0 }} - {{ $students->lastItem() ?? 0 }}</strong> of <strong>{{ $students->total() }}</strong> records
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
                    <th>College & Program</th>
                    <th>Grad Year</th>
                    <th>Applications</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php
                        $avatarColors = ['#3454D1', '#0EA5E9', '#10B981', '#8B5CF6', '#F59E0B', '#EC4899'];
                        $bgColor = $avatarColors[$student->id % count($avatarColors)];
                    @endphp
                    <tr>
                        <td class="text-muted small">
                            {{ $students->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="sidebar-user-avatar" style="width:38px; height:38px; font-size:0.875rem; background: {{ $bgColor }};">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                        {{ $student->name }}
                                    </a>
                                    <div class="text-muted small">{{ $student->email }}</div>
                                    @if($student->studentProfile?->phone)
                                        <div class="text-secondary" style="font-size:0.75rem;">
                                            <i class="bi bi-telephone me-1"></i>{{ $student->studentProfile->phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="fw-semibold text-dark">
                                {{ $student->studentProfile?->college ?? 'College not specified' }}
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-mortarboard text-secondary me-1"></i>
                                {{ $student->studentProfile?->course ?? 'Degree not specified' }}
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-light text-secondary border">
                                {{ $student->studentProfile?->graduation_year ?? '—' }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('admin.applications', ['search' => $student->email]) }}" class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1.5 text-decoration-none">
                                <i class="bi bi-file-earmark-text me-1"></i>
                                {{ $student->applications_count }} applied
                            </a>
                        </td>

                        <td>
                            @if($student->studentProfile?->resume_path)
                                <a href="{{ route('admin.students.resume', $student->id) }}" class="btn btn-sm btn-light border text-danger d-inline-flex align-items-center gap-1" title="Download Resume">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                    <span style="font-size: 0.75rem;">PDF</span>
                                </a>
                            @else
                                <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">None</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge-status {{ $student->is_active ? 'active' : 'inactive' }}">
                                {{ $student->is_active ? 'Active' : 'Deactivated' }}
                            </span>
                        </td>

                        <td class="text-muted small">
                            {{ $student->created_at ? $student->created_at->format('M d, Y') : '—' }}
                        </td>

                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-light border" title="View Full Profile">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>

                                <form action="{{ route('admin.students.toggle-status', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-light border {{ $student->is_active ? 'text-warning' : 'text-success' }}"
                                        title="{{ $student->is_active ? 'Deactivate Student Account' : 'Activate Student Account' }}"
                                        onclick="return confirm('Change status for {{ addslashes($student->name) }}?')"
                                    >
                                        <i class="bi {{ $student->is_active ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-light border text-danger"
                                        title="Delete Student"
                                        onclick="return confirm('Permanently delete student {{ addslashes($student->name) }} and all applications? This action cannot be undone.')"
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
                            <i class="bi bi-people fs-1 text-secondary opacity-50 d-block mb-2"></i>
                            <h6 class="fw-bold mb-1">No students found matching your criteria</h6>
                            <p class="small text-secondary mb-3">Try adjusting your search terms or clearing your status filter.</p>
                            <a href="{{ route('admin.students') }}" class="btn btn-sm btn-outline-primary">
                                Clear Filters
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($students->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="small text-muted">
                Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students
            </div>
            <div>
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

@endsection
