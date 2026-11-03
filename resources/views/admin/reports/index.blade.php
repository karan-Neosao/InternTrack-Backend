@extends('admin.layouts.app')

@section('title', 'Reports & Analytics')

@section('breadcrumb')
    <li class="active-item">Reports & Analytics</li>
@endsection

@section('content')

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Reports & Analytics</h3>
            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 small">
                Data Warehousing
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Generate high-resolution platform metrics, analyze recruitment timelines, and stream raw CSV datasets.
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm bg-white" onclick="window.print()">
            <i class="bi bi-printer text-dark"></i>
            <span>Print Report</span>
        </button>
    </div>
</div>

<!-- 4 One-Click CSV Export Cards -->
<div class="row g-3 mb-4">

    <!-- Students CSV -->
    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 border-0 shadow-sm h-100 hover-card" style="border-top: 3px solid #3454D1 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon primary" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="badge bg-light text-secondary border">CSV Format</span>
            </div>
            <h6 class="fw-bold text-dark mb-1">Students Roster</h6>
            <p class="text-secondary small mb-3" style="font-size: 0.75rem;">
                Full profiles, colleges, degrees, graduation years, contact numbers, and resume paths.
            </p>
            <a href="{{ route('admin.reports.export', 'students') }}" class="btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-sm">
                <i class="bi bi-download"></i>
                <span>Download Students CSV</span>
            </a>
        </div>
    </div>

    <!-- Companies CSV -->
    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 border-0 shadow-sm h-100 hover-card" style="border-top: 3px solid #0EA5E9 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon teal" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-buildings-fill"></i>
                </div>
                <span class="badge bg-light text-secondary border">CSV Format</span>
            </div>
            <h6 class="fw-bold text-dark mb-1">Employers Dataset</h6>
            <p class="text-secondary small mb-3" style="font-size: 0.75rem;">
                Hiring partner names, domains, verified badge status, locations, websites, and total openings.
            </p>
            <a href="{{ route('admin.reports.export', 'companies') }}" class="btn btn-sm btn-info text-white w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-sm">
                <i class="bi bi-download"></i>
                <span>Download Companies CSV</span>
            </a>
        </div>
    </div>

    <!-- Internships CSV -->
    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 border-0 shadow-sm h-100 hover-card" style="border-top: 3px solid #8B5CF6 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon purple" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <span class="badge bg-light text-secondary border">CSV Format</span>
            </div>
            <h6 class="fw-bold text-dark mb-1">Internship Opportunities</h6>
            <p class="text-secondary small mb-3" style="font-size: 0.75rem;">
                All openings, work types (remote/onsite), stipend figures, durations, and applicant counts.
            </p>
            <a href="{{ route('admin.reports.export', 'internships') }}" class="btn btn-sm text-white w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="background:#8B5CF6;">
                <i class="bi bi-download"></i>
                <span>Download Internships CSV</span>
            </a>
        </div>
    </div>

    <!-- Applications CSV -->
    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 border-0 shadow-sm h-100 hover-card" style="border-top: 3px solid #F59E0B !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon warning" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <span class="badge bg-light text-secondary border">CSV Format</span>
            </div>
            <h6 class="fw-bold text-dark mb-1">Recruitment Pipeline</h6>
            <p class="text-secondary small mb-3" style="font-size: 0.75rem;">
                Student names, applied roles, company pairings, review statuses, and timestamps.
            </p>
            <a href="{{ route('admin.reports.export', 'applications') }}" class="btn btn-sm btn-warning text-dark fw-semibold w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-sm">
                <i class="bi bi-download"></i>
                <span>Download Applications CSV</span>
            </a>
        </div>
    </div>

</div>

<!-- Date Filter Card -->
<div class="card p-3 mb-4 shadow-sm border-0">
    <form method="GET" action="{{ route('admin.reports') }}" class="row g-2 align-items-center">

        <div class="col-md-4">
            <label class="form-label small text-muted mb-1 fw-bold" style="font-size: 0.7rem;">FROM DATE</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                <input type="date" name="start_date" class="form-control border-start-0" value="{{ $startDate->format('Y-m-d') }}">
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label small text-muted mb-1 fw-bold" style="font-size: 0.7rem;">TO DATE</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar-check"></i></span>
                <input type="date" name="end_date" class="form-control border-start-0" value="{{ $endDate->format('Y-m-d') }}">
            </div>
        </div>

        <div class="col-md-4 pt-md-3">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1.5 shadow-sm">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter Custom Period</span>
            </button>
        </div>

    </form>
</div>

<!-- Overview Stats Cards -->
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">REGISTERED STUDENTS</div>
                    <div class="stat-value">{{ number_format($stats['total_students']) }}</div>
                </div>
                <div class="stat-icon primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="stat-subtitle text-secondary pt-2 border-top mt-2">
                <strong>+{{ $stats['period_students'] }}</strong> enrolled in selected range
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">PARTNER COMPANIES</div>
                    <div class="stat-value">{{ number_format($stats['total_companies']) }}</div>
                </div>
                <div class="stat-icon teal">
                    <i class="bi bi-buildings-fill"></i>
                </div>
            </div>
            <div class="stat-subtitle text-secondary pt-2 border-top mt-2">
                <strong>+{{ $stats['period_companies'] }}</strong> joined in selected range
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">INTERNSHIP LISTINGS</div>
                    <div class="stat-value">{{ number_format($stats['total_internships']) }}</div>
                </div>
                <div class="stat-icon purple">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
            </div>
            <div class="stat-subtitle text-success pt-2 border-top mt-2">
                {{ $stats['active_internships'] }} Active · {{ $stats['closed_internships'] }} Closed
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">TOTAL APPLICATIONS</div>
                    <div class="stat-value">{{ number_format($stats['total_applications']) }}</div>
                </div>
                <div class="stat-icon warning">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
            </div>
            <div class="stat-subtitle text-primary pt-2 border-top mt-2">
                <strong>+{{ $stats['period_applications'] }}</strong> submitted in range
            </div>
        </div>
    </div>

</div>

<!-- Monthly Performance Breakdown Chart -->
<div class="card p-4 shadow-sm border-0 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-graph-up text-primary"></i>
                <span>Semester Recruitment Trajectory</span>
            </h5>
            <p class="text-muted small mb-0">Monthly growth volume comparing student signups, partner onboarding, and applications.</p>
        </div>
        <span class="badge bg-light text-secondary border px-3 py-2">6 Months Historical</span>
    </div>
    <div style="height: 300px; position: relative;">
        <canvas id="reportsTrendChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('reportsTrendChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [
                    {
                        label: 'Applications',
                        data: {!! json_encode($applicationsSubmitted) !!},
                        backgroundColor: '#3454D1',
                        borderRadius: 6,
                    },
                    {
                        label: 'Students',
                        data: {!! json_encode($studentRegistrations) !!},
                        backgroundColor: '#10B981',
                        borderRadius: 6,
                    },
                    {
                        label: 'Companies',
                        data: {!! json_encode($companyRegistrations) !!},
                        backgroundColor: '#F59E0B',
                        borderRadius: 6,
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
                            font: { family: 'Inter', size: 12 },
                            usePointStyle: true,
                            boxWidth: 10
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', size: 12 }
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
});
</script>

@endsection
