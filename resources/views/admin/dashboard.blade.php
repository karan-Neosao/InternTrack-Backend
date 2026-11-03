@extends('admin.layouts.app')

@section('title', 'Admin Dashboard Overview')

@section('breadcrumb')
    <li class="active-item">Executive Dashboard</li>
@endsection

@section('content')

<!-- Live Platform Hero Bar -->
<div class="card border-0 mb-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #3454D1 100%); color: #FFFFFF;">
    <!-- Abstract Glow Mesh -->
    <div style="position: absolute; right: -60px; top: -60px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(99, 102, 241, 0.4) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; left: 30%; bottom: -80px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(52, 84, 209, 0.3) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="card-body p-4 position-relative">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-success bg-opacity-25 text-white border border-success border-opacity-50 px-2.5 py-1 rounded-pill small d-inline-flex align-items-center gap-1.5">
                        <span class="pulse-dot bg-success" style="width: 6px; height: 6px;"></span>
                        <span>Production Portal Live</span>
                    </span>
                    <span class="badge bg-white bg-opacity-10 text-white-50 px-2.5 py-1 rounded-pill small">
                        v2.4 LTS
                    </span>
                </div>
                <h3 class="fw-bold mb-1 text-white" style="letter-spacing: -0.6px;">
                    Welcome back, {{ auth()->user()->name }}! 👋
                </h3>
                <p class="text-white-50 mb-0 small" style="max-width: 620px;">
                    Here is your real-time command center for student enrollments, hiring partners, and active internship placements.
                </p>
            </div>

            <div class="d-flex flex-wrap align-items-center gap-2">
                <div class="bg-white bg-opacity-10 backdrop-blur px-3 py-2 rounded-3 text-white small d-flex align-items-center gap-2 border border-white border-opacity-10">
                    <i class="bi bi-clock-history text-info"></i>
                    <span>{{ now()->format('D, d M Y') }}</span>
                </div>
                <a href="{{ route('admin.internships.create') }}" class="btn btn-light text-primary fw-bold shadow-sm d-flex align-items-center gap-1.5 px-3 py-2">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Post Internship</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="btn btn-outline-light d-flex align-items-center gap-1.5 px-3 py-2">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Analytics</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Key Stat Cards (Row 1) -->
<div class="row g-3 mb-4">

    <!-- Total Students -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">TOTAL STUDENTS</div>
                    <div class="stat-value">{{ number_format($stats['total_students']) }}</div>
                </div>
                <div class="stat-icon primary">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                <span class="small text-success fw-semibold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ $stats['active_students'] }} active
                </span>
                <a href="{{ route('admin.students') }}" class="small text-muted text-decoration-none hover-primary">
                    Manage <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <!-- Progress Bar -->
            @php
                $studentActivePct = $stats['total_students'] > 0 ? round(($stats['active_students'] / $stats['total_students']) * 100) : 0;
            @endphp
            <div class="progress mt-2" style="height: 4px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $studentActivePct }}%" aria-valuenow="{{ $studentActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Total Companies -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">HIRING COMPANIES</div>
                    <div class="stat-value">{{ number_format($stats['total_companies']) }}</div>
                </div>
                <div class="stat-icon teal">
                    <i class="bi bi-buildings-fill"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                <span class="small text-info fw-semibold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-patch-check-fill text-primary"></i>
                    {{ $stats['verified_companies'] }} verified
                </span>
                <a href="{{ route('admin.companies') }}" class="small text-muted text-decoration-none hover-primary">
                    Partners <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @php
                $companyVerifiedPct = $stats['total_companies'] > 0 ? round(($stats['verified_companies'] / $stats['total_companies']) * 100) : 0;
            @endphp
            <div class="progress mt-2" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $companyVerifiedPct }}%" aria-valuenow="{{ $companyVerifiedPct }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Total Internships -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">INTERNSHIP OPENINGS</div>
                    <div class="stat-value">{{ number_format($stats['total_internships']) }}</div>
                </div>
                <div class="stat-icon purple">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                <span class="small text-success fw-semibold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-lightning-charge-fill"></i>
                    {{ $stats['active_internships'] }} accepting applications
                </span>
                <a href="{{ route('admin.internships') }}" class="small text-muted text-decoration-none hover-primary">
                    View <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @php
                $internshipActivePct = $stats['total_internships'] > 0 ? round(($stats['active_internships'] / $stats['total_internships']) * 100) : 0;
            @endphp
            <div class="progress mt-2" style="height: 4px;">
                <div class="progress-bar" style="background-color: #8B5CF6; width: {{ $internshipActivePct }}%" aria-valuenow="{{ $internshipActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Total Applications -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">TOTAL APPLICATIONS</div>
                    <div class="stat-value">{{ number_format($stats['total_applications']) }}</div>
                </div>
                <div class="stat-icon warning">
                    <i class="bi bi-send-fill"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                <span class="small text-warning fw-semibold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-hourglass-split"></i>
                    {{ $stats['pending_applications'] }} awaiting review
                </span>
                <a href="{{ route('admin.applications') }}" class="small text-muted text-decoration-none hover-primary">
                    Review <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @php
                $appAcceptedPct = $stats['total_applications'] > 0 ? round(($stats['accepted_applications'] / $stats['total_applications']) * 100) : 0;
            @endphp
            <div class="progress mt-2" style="height: 4px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $stats['total_applications'] > 0 ? round(($stats['pending_applications'] / $stats['total_applications']) * 100) : 0 }}%"></div>
            </div>
        </div>
    </div>

</div>

<!-- Application Lifecycle Stage Pipeline -->
<div class="card mb-4 border-0 shadow-sm p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h6 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-diagram-3-fill text-primary"></i>
                <span>Application Processing Pipeline</span>
            </h6>
            <p class="text-muted small mb-0">Current volume of candidate applications across review lifecycle stages.</p>
        </div>
        <a href="{{ route('admin.applications') }}" class="btn btn-sm btn-light border px-3">
            Open Pipeline <i class="bi bi-box-arrow-up-right ms-1"></i>
        </a>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3" style="background: #FFFBEB; border: 1px solid #FDE68A;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.7rem;">Pending Review</span>
                    <i class="bi bi-clock-history text-warning"></i>
                </div>
                <div class="fs-4 fw-bold text-warning">{{ number_format($stats['pending_applications']) }}</div>
                <div class="small text-muted" style="font-size: 0.725rem;">Candidates waiting for response</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3" style="background: #EFF6FF; border: 1px solid #BFDBFE;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.7rem;">Under Review</span>
                    <i class="bi bi-search text-primary"></i>
                </div>
                <div class="fs-4 fw-bold text-primary">{{ number_format($stats['reviewed_applications']) }}</div>
                <div class="small text-muted" style="font-size: 0.725rem;">Interviewing or shortlisted</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3" style="background: #ECFDF5; border: 1px solid #A7F3D0;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.7rem;">Accepted Offers</span>
                    <i class="bi bi-trophy-fill text-success"></i>
                </div>
                <div class="fs-4 fw-bold text-success">{{ number_format($stats['accepted_applications']) }}</div>
                <div class="small text-muted" style="font-size: 0.725rem;">Placements confirmed</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="p-3 rounded-3" style="background: #FEF2F2; border: 1px solid #FECACA;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.7rem;">Rejected</span>
                    <i class="bi bi-x-circle-fill text-danger"></i>
                </div>
                <div class="fs-4 fw-bold text-danger">{{ number_format($stats['rejected_applications']) }}</div>
                <div class="small text-muted" style="font-size: 0.725rem;">Not selected this term</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">

    <!-- Growth Trends Chart -->
    <div class="col-lg-8">
        <div class="card p-4 h-100 shadow-sm border-0">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-graph-up text-primary"></i>
                        <span>Platform Growth & Applications</span>
                    </h5>
                    <p class="text-muted small mb-0">Monthly signups for students, companies, and applications submitted over the past 6 months.</p>
                </div>
                <div class="btn-group btn-group-sm">
                    <span class="badge bg-light text-secondary border px-3 py-2">6 Months Trend</span>
                </div>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="growthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Application Status Distribution Chart -->
    <div class="col-lg-4">
        <div class="card p-4 h-100 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-pie-chart-fill text-primary"></i>
                        <span>Status Split</span>
                    </h5>
                    <p class="text-muted small mb-0">Review outcome share.</p>
                </div>
            </div>
            <div style="height: 220px; position: relative;" class="d-flex align-items-center justify-content-center">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="d-flex justify-content-around text-center pt-3 border-top mt-3 small">
                <div>
                    <span class="d-block fw-bold text-warning">{{ $stats['pending_applications'] }}</span>
                    <span class="text-muted" style="font-size:0.7rem;">Pending</span>
                </div>
                <div>
                    <span class="d-block fw-bold text-primary">{{ $stats['reviewed_applications'] }}</span>
                    <span class="text-muted" style="font-size:0.7rem;">Reviewed</span>
                </div>
                <div>
                    <span class="d-block fw-bold text-success">{{ $stats['accepted_applications'] }}</span>
                    <span class="text-muted" style="font-size:0.7rem;">Accepted</span>
                </div>
                <div>
                    <span class="d-block fw-bold text-danger">{{ $stats['rejected_applications'] }}</span>
                    <span class="text-muted" style="font-size:0.7rem;">Rejected</span>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Recent Applications & Latest Opportunities -->
<div class="row g-4 mb-4">

    <!-- Recent Applications Table -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-person-fill text-primary"></i>
                        <span>Recent Candidate Applications</span>
                    </h5>
                    <p class="text-muted small mb-0">Latest applications submitted across internship listings.</p>
                </div>
                <a href="{{ route('admin.applications') }}" class="btn btn-sm btn-outline-primary">
                    View All ({{ $stats['total_applications'] }})
                </a>
            </div>

            <div class="table-responsive px-4 pb-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Role & Company</th>
                            <th>Status</th>
                            <th>Applied</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentApplications as $app)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="sidebar-user-avatar" style="width:34px; height:34px; font-size:0.8rem; background: linear-gradient(135deg, #3454D1 0%, #6366F1 100%);">
                                            {{ strtoupper(substr($app->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $app->student->name ?? 'Candidate' }}</div>
                                            <div class="text-muted" style="font-size:0.75rem;">{{ $app->student->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 170px;">
                                        {{ $app->internship->title ?? 'N/A' }}
                                    </div>
                                    <div class="text-secondary small" style="font-size: 0.75rem;">
                                        <i class="bi bi-building me-1"></i>{{ $app->internship?->company?->name ?? 'Company' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match(strtolower($app->status ?? 'pending')) {
                                            'accepted' => 'active',
                                            'reviewed' => 'active',
                                            'rejected' => 'inactive',
                                            default => 'pending'
                                        };
                                    @endphp
                                    <span class="badge-status {{ $statusClass }}">
                                        {{ ucfirst($app->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $app->created_at ? $app->created_at->diffForHumans(null, true) : 'Recently' }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-sm btn-light border px-2 py-1" title="Review Application">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block text-secondary opacity-50 mb-1"></i>
                                    No applications submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Latest Internships & Fast Operations -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-lightning-charge-fill text-warning"></i>
                        <span>Latest Opportunities</span>
                    </h5>
                    <p class="text-muted small mb-0">Recently posted internship roles.</p>
                </div>
                <a href="{{ route('admin.internships') }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>

            <div class="px-4 pb-3">
                <div class="list-group list-group-flush">
                    @forelse($latestInternships as $job)
                        <div class="list-group-item px-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.internships.show', $job->id) }}" class="fw-bold text-dark text-decoration-none hover-primary d-block">
                                    {{ $job->title }}
                                </a>
                                <div class="text-secondary small d-flex align-items-center gap-2 mt-1">
                                    <span><i class="bi bi-buildings me-1"></i>{{ $job->company->name ?? 'Company' }}</span>
                                    <span>•</span>
                                    <span class="badge bg-light text-secondary border">{{ ucfirst($job->work_type) }}</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1">
                                    {{ $job->applications_count }} applicants
                                </span>
                                <div class="small text-muted mt-1" style="font-size: 0.7rem;">
                                    {{ $job->created_at ? $job->created_at->format('M d') : 'Active' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-briefcase fs-3 d-block text-secondary opacity-50 mb-1"></i>
                            No internships posted yet.
                        </div>
                    @endforelse
                </div>

                <!-- Admin Quick Jump Nav -->
                <div class="mt-4 pt-3 border-top">
                    <div class="text-muted small fw-bold text-uppercase mb-2" style="letter-spacing: 0.5px;">Master Console Quick Actions</div>
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('admin.categories') }}" class="btn btn-light border w-100 text-start py-2 d-flex align-items-center gap-2 small">
                                <i class="bi bi-tags text-primary"></i>
                                <span>Categories</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.reports') }}" class="btn btn-light border w-100 text-start py-2 d-flex align-items-center gap-2 small">
                                <i class="bi bi-download text-success"></i>
                                <span>CSV Exports</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.notifications') }}" class="btn btn-light border w-100 text-start py-2 d-flex align-items-center gap-2 small">
                                <i class="bi bi-bell text-warning"></i>
                                <span>Alert Center</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.settings') }}" class="btn btn-light border w-100 text-start py-2 d-flex align-items-center gap-2 small">
                                <i class="bi bi-gear text-secondary"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Chart.js Setup Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Growth Line Chart
    const growthCtx = document.getElementById('growthChart');
    if (growthCtx) {
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyLabels) !!},
                datasets: [
                    {
                        label: 'Applications',
                        data: {!! json_encode($monthlyApplications) !!},
                        borderColor: '#3454D1',
                        backgroundColor: 'rgba(52, 84, 209, 0.08)',
                        tension: 0.35,
                        fill: true,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#3454D1',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Students',
                        data: {!! json_encode($monthlyStudents) !!},
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.04)',
                        tension: 0.35,
                        fill: true,
                        borderWidth: 2,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Companies',
                        data: {!! json_encode($monthlyCompanies) !!},
                        borderColor: '#F59E0B',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        tension: 0.35,
                        fill: false,
                        borderWidth: 2,
                        pointBackgroundColor: '#F59E0B',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            usePointStyle: true,
                            font: {
                                family: 'Inter',
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleFont: { family: 'Inter', size: 13, weight: 'bold' },
                        bodyFont: { family: 'Inter', size: 12 },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11 }, color: '#64748B' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F1F5F9' },
                        ticks: { font: { family: 'Inter', size: 11 }, color: '#64748B', precision: 0 }
                    }
                }
            }
        });
    }

    // 2. Application Status Doughnut Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Reviewed', 'Accepted', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $stats['pending_applications'] }},
                        {{ $stats['reviewed_applications'] }},
                        {{ $stats['accepted_applications'] }},
                        {{ $stats['rejected_applications'] }}
                    ],
                    backgroundColor: [
                        '#F59E0B',
                        '#3454D1',
                        '#10B981',
                        '#EF4444'
                    ],
                    borderWidth: 2,
                    borderColor: '#FFFFFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', size: 12 },
                        bodyFont: { family: 'Inter', size: 12 }
                    }
                }
            }
        });
    }
});
</script>

@endsection
