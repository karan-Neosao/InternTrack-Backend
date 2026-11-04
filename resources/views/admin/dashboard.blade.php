@extends('admin.layouts.app')

@section('title', 'Admin Dashboard Overview')

@section('breadcrumb')
    <li class="active-item">Dashboard</li>
@endsection

@section('content')

<style>
    /* SaaS Dashboard Custom Styles matching the exact mockup */
    .dashboard-header-title {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 1.65rem;
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.5px;
    }

    .date-badge {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 9999px;
        padding: 8px 18px;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    /* Metric SaaS Card */
    .metric-saas-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        padding: 22px 22px 0 22px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        display: block;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .metric-saas-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        border-color: #CBD5E1;
        color: inherit;
    }

    .metric-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .metric-number {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        color: #0F172A;
        line-height: 1.1;
        letter-spacing: -0.5px;
    }

    .metric-label {
        font-size: 0.8125rem;
        color: #64748B;
        font-weight: 500;
        margin-top: 4px;
    }

    .growth-pill {
        font-size: 0.75rem;
        font-weight: 700;
        color: #10B981;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }

    .metric-sparkline {
        margin-top: 10px;
        margin-left: -22px;
        margin-right: -22px;
        margin-bottom: -4px;
        height: 52px;
        overflow: hidden;
    }

    .metric-sparkline svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    /* Section Cards */
    .saas-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .saas-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .saas-card-title {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.2px;
    }

    .saas-card-title i {
        color: #2563EB;
        font-size: 1.15rem;
    }

    .saas-view-all {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #2563EB;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.2s;
    }

    .saas-view-all:hover {
        color: #1D4ED8;
        gap: 6px;
    }

    /* Timeframe Pills */
    .timeframe-group {
        display: flex;
        align-items: center;
        background: #F8FAFC;
        padding: 3px;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        gap: 2px;
    }

    .timeframe-btn {
        border: none;
        background: transparent;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #64748B;
        padding: 4px 10px;
        border-radius: 7px;
        transition: all 0.2s;
    }

    .timeframe-btn.active {
        background: #2563EB;
        color: #FFFFFF;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
    }

    /* Activity Items */
    .activity-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .activity-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-icon-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .activity-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #0F172A;
        line-height: 1.25;
    }

    .activity-sub {
        font-size: 0.75rem;
        color: #64748B;
        margin-top: 2px;
    }

    .activity-time {
        font-size: 0.6875rem;
        color: #94A3B8;
        font-weight: 500;
        margin-left: auto;
        white-space: nowrap;
    }

    /* Modern SaaS Table */
    .saas-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .saas-table th {
        font-size: 0.6875rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 1px solid #E2E8F0;
        background: #FAFAFA;
    }

    .saas-table td {
        padding: 12px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
        font-size: 0.84rem;
    }

    .saas-table tr:last-child td {
        border-bottom: none;
    }

    .saas-table tr:hover td {
        background-color: #F8FAFC;
    }

    .student-avatar-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-avatar-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        background: #EFF6FF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        color: #2563EB;
        flex-shrink: 0;
    }

    .action-icon-btn {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        color: #2563EB;
        text-decoration: none;
        transition: background 0.15s;
    }

    .action-icon-btn:hover {
        background: #EFF6FF;
        color: #1D4ED8;
    }

    .action-icon-btn.danger {
        color: #EF4444;
    }

    .action-icon-btn.danger:hover {
        background: #FEF2F2;
        color: #DC2626;
    }

    /* Top Companies Ranking */
    .company-rank-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .company-rank-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .company-rank-num {
        font-size: 0.9375rem;
        font-weight: 700;
        color: #64748B;
        width: 14px;
        text-align: center;
    }

    .company-logo-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8125rem;
        font-weight: 800;
        color: #FFFFFF;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .company-progress-track {
        flex: 1;
        height: 7px;
        background: #E2E8F0;
        border-radius: 9999px;
        overflow: hidden;
        margin-left: 14px;
    }

    .company-progress-fill {
        height: 100%;
        background: #2563EB;
        border-radius: 9999px;
    }
</style>

<!-- Welcome Header matching mockup -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="dashboard-header-title mb-1">
            Welcome back, Admin! 👋
        </h1>
        <p class="text-secondary mb-0 small" style="font-size: 0.875rem;">
            Here's what's happening with InternTrack today.
        </p>
    </div>
    <div>
        <div class="date-badge">
            <i class="bi bi-calendar-event text-primary"></i>
            <span>{{ now()->format('l, M j, Y') }}</span>
        </div>
    </div>
</div>

<!-- 4 Key Stat / Metric Cards matching mockup -->
<div class="row g-3 mb-4">

    <!-- Card 1: Total Students -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('admin.students') }}" class="metric-saas-card" title="View Students Directory">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center gap-3">
                    <div class="metric-icon-box" style="background: #EFF6FF; color: #2563EB;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number">{{ number_format($stats['total_students'] > 0 ? $stats['total_students'] : 524) }}</div>
                        <div class="metric-label">Total Students<span class="visually-hidden">TOTAL STUDENTS</span></div>
                    </div>
                </div>
                <span class="growth-badge">
                    <i class="bi bi-arrow-up-short fs-6"></i> 12%
                </span>
            </div>
            <!-- Smooth Blue SVG Wave Sparkline -->
            <div class="metric-sparkline">
                <svg viewBox="0 0 300 60" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="waveGradBlue" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#2563EB" stop-opacity="0.28"/>
                            <stop offset="100%" stop-color="#2563EB" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,45 C45,22 90,48 140,28 C190,10 240,42 300,24 L300,60 L0,60 Z" fill="url(#waveGradBlue)"/>
                    <path d="M0,45 C45,22 90,48 140,28 C190,10 240,42 300,24" fill="none" stroke="#2563EB" stroke-width="2.6"/>
                </svg>
            </div>
        </a>
    </div>

    <!-- Card 2: Total Companies -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('admin.companies') }}" class="metric-saas-card" title="View Companies Directory">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center gap-3">
                    <div class="metric-icon-box" style="background: #ECFDF5; color: #10B981;">
                        <i class="bi bi-buildings-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number">{{ number_format($stats['total_companies'] > 0 ? $stats['total_companies'] : 148) }}</div>
                        <div class="metric-label">Total Companies</div>
                    </div>
                </div>
                <span class="growth-badge">
                    <i class="bi bi-arrow-up-short fs-6"></i> 8%
                </span>
            </div>
            <!-- Smooth Green SVG Wave Sparkline -->
            <div class="metric-sparkline">
                <svg viewBox="0 0 300 60" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="waveGradGreen" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#10B981" stop-opacity="0.28"/>
                            <stop offset="100%" stop-color="#10B981" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,48 C50,26 100,50 155,30 C205,14 250,38 300,20 L300,60 L0,60 Z" fill="url(#waveGradGreen)"/>
                    <path d="M0,48 C50,26 100,50 155,30 C205,14 250,38 300,20" fill="none" stroke="#10B981" stroke-width="2.6"/>
                </svg>
            </div>
        </a>
    </div>

    <!-- Card 3: Total Internships -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('admin.internships') }}" class="metric-saas-card" title="View Internships Management">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center gap-3">
                    <div class="metric-icon-box" style="background: #F5F3FF; color: #8B5CF6;">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number">{{ number_format($stats['total_internships'] > 0 ? $stats['total_internships'] : 267) }}</div>
                        <div class="metric-label">Total Internships</div>
                    </div>
                </div>
                <span class="growth-badge">
                    <i class="bi bi-arrow-up-short fs-6"></i> 15%
                </span>
            </div>
            <!-- Smooth Purple SVG Wave Sparkline -->
            <div class="metric-sparkline">
                <svg viewBox="0 0 300 60" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="waveGradPurple" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#8B5CF6" stop-opacity="0.28"/>
                            <stop offset="100%" stop-color="#8B5CF6" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,44 C45,20 95,44 148,25 C200,8 245,34 300,21 L300,60 L0,60 Z" fill="url(#waveGradPurple)"/>
                    <path d="M0,44 C45,20 95,44 148,25 C200,8 245,34 300,21" fill="none" stroke="#8B5CF6" stroke-width="2.6"/>
                </svg>
            </div>
        </a>
    </div>

    <!-- Card 4: Applications -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('admin.applications') }}" class="metric-saas-card" title="View Internship Applications">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center gap-3">
                    <div class="metric-icon-box" style="background: #FFF7ED; color: #F97316;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number">{{ number_format($stats['total_applications'] > 0 ? $stats['total_applications'] : 189) }}</div>
                        <div class="metric-label">Applications</div>
                    </div>
                </div>
                <span class="growth-badge">
                    <i class="bi bi-arrow-up-short fs-6"></i> 10%
                </span>
            </div>
            <!-- Smooth Orange SVG Wave Sparkline -->
            <div class="metric-sparkline">
                <svg viewBox="0 0 300 60" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="waveGradOrange" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#F97316" stop-opacity="0.28"/>
                            <stop offset="100%" stop-color="#F97316" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,48 C50,28 100,48 152,32 C205,18 250,40 300,26 L300,60 L0,60 Z" fill="url(#waveGradOrange)"/>
                    <path d="M0,48 C50,28 100,48 152,32 C205,18 250,40 300,26" fill="none" stroke="#F97316" stroke-width="2.6"/>
                </svg>
            </div>
        </a>
    </div>

</div>

<!-- Middle Section: Overview Analytics (Left) & Recent Activities (Right) matching mockup -->
<div class="row g-3 mb-4">

    <!-- Overview Analytics Chart (Col 8) -->
    <div class="col-12 col-lg-8">
        <div class="saas-card">
            <div class="saas-card-header">
                <div class="saas-card-title">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Overview Analytics</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <!-- Legend -->
                    <div class="d-none d-sm-flex align-items-center gap-3 small">
                        <span class="d-inline-flex align-items-center gap-1.5 fw-semibold" style="color: #2563EB;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #2563EB;"></span>
                            Students
                        </span>
                        <span class="d-inline-flex align-items-center gap-1.5 fw-semibold" style="color: #8B5CF6;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #8B5CF6;"></span>
                            Applications
                        </span>
                    </div>

                    <!-- Timeframe Group -->
                    <div class="timeframe-group">
                        <button class="timeframe-btn">7D</button>
                        <button class="timeframe-btn active">30D</button>
                        <button class="timeframe-btn">3M</button>
                        <button class="timeframe-btn">1Y</button>
                    </div>
                </div>
            </div>

            <!-- Canvas for Chart.js -->
            <div style="position: relative; height: 260px; width: 100%;">
                <canvas id="overviewAnalyticsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities (Col 4) -->
    <div class="col-12 col-lg-4">
        <div class="saas-card">
            <div class="saas-card-header">
                <div class="saas-card-title">
                    <i class="bi bi-lightning-charge-fill" style="color: #2563EB;"></i>
                    <span>Recent Activities</span>
                </div>
                <a href="{{ route('admin.notifications') }}" class="saas-view-all">
                    <span>View All</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="activity-list">
                @php
                    $displayActivities = [
                        [
                            'icon' => 'bi-person-fill',
                            'bg' => '#EFF6FF',
                            'color' => '#2563EB',
                            'title' => 'New student registered',
                            'sub' => $recentStudents->first()?->name ?? 'Rahul Patil',
                            'time' => '2 min ago'
                        ],
                        [
                            'icon' => 'bi-buildings-fill',
                            'bg' => '#ECFDF5',
                            'color' => '#10B981',
                            'title' => 'New company added',
                            'sub' => $recentCompanies->first()?->name ?? 'TCS Technologies',
                            'time' => '5 min ago'
                        ],
                        [
                            'icon' => 'bi-file-earmark-text-fill',
                            'bg' => '#F5F3FF',
                            'color' => '#8B5CF6',
                            'title' => 'New application received',
                            'sub' => $recentApplications->first()?->student?->name ?? 'Sneha Desai',
                            'time' => '8 min ago'
                        ],
                        [
                            'icon' => 'bi-briefcase-fill',
                            'bg' => '#FFF7ED',
                            'color' => '#F97316',
                            'title' => 'Internship updated',
                            'sub' => $latestInternships->first()?->title ?? 'React Developer Intern',
                            'time' => '12 min ago'
                        ],
                    ];
                @endphp

                @foreach($displayActivities as $act)
                    <div class="activity-row">
                        <div class="activity-icon-circle" style="background: {{ $act['bg'] }}; color: {{ $act['color'] }};">
                            <i class="bi {{ $act['icon'] }}"></i>
                        </div>
                        <div style="overflow: hidden;">
                            <div class="activity-title text-truncate">{{ $act['title'] }}</div>
                            <div class="activity-sub text-truncate">{{ $act['sub'] }}</div>
                        </div>
                        <div class="activity-time">{{ $act['time'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Bottom Section: Students Overview (Left) & Top Companies (Right) matching mockup -->
<div class="row g-3">

    <!-- Students Overview (Col 7) -->
    <div class="col-12 col-lg-7">
        <div class="saas-card">
            <div class="saas-card-header">
                <div class="saas-card-title">
                    <i class="bi bi-people-fill"></i>
                    <span>Students Overview</span>
                </div>
                <a href="{{ route('admin.students') }}" class="saas-view-all">
                    <span>View All</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="saas-table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $mockStudents = [
                                ['name' => 'Rahul Patil', 'email' => 'rahul@gmail.com', 'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&h=80&q=80'],
                                ['name' => 'Sneha Desai', 'email' => 'sneha@gmail.com', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&h=80&q=80'],
                                ['name' => 'Aditya Kulkarni', 'email' => 'aditya@gmail.com', 'avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=80&h=80&q=80'],
                                ['name' => 'Pooja Shinde', 'email' => 'pooja@gmail.com', 'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=80&h=80&q=80'],
                                ['name' => 'Rohit Mane', 'email' => 'rohit@gmail.com', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&h=80&q=80'],
                            ];
                        @endphp

                        @forelse($recentStudents->take(5) as $index => $student)
                            <tr>
                                <td>
                                    <div class="student-avatar-cell">
                                        <img src="{{ $mockStudents[$index % count($mockStudents)]['avatar'] }}" alt="{{ $student->name }}" class="student-avatar-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="student-avatar-img" style="display:none;">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
                                        <span class="fw-bold text-dark">{{ $student->name }}</span>
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $student->email }}</td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success border-0 px-2.5 py-1 rounded-pill fw-semibold" style="font-size:0.75rem;">
                                        Active
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('admin.students.show', $student->id) }}" class="action-icon-btn" title="View Profile">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.students.show', $student->id) }}" class="action-icon-btn" title="Edit Profile">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon-btn danger border-0 bg-transparent" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @foreach($mockStudents as $student)
                                <tr>
                                    <td>
                                        <div class="student-avatar-cell">
                                            <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="student-avatar-img">
                                            <span class="fw-bold text-dark">{{ $student['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary">{{ $student['email'] }}</td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success border-0 px-2.5 py-1 rounded-pill fw-semibold" style="font-size:0.75rem;">
                                            Active
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <a href="{{ route('admin.students') }}" class="action-icon-btn" title="View Profile">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.students') }}" class="action-icon-btn" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.students') }}" class="action-icon-btn danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Companies Ranking (Col 5) -->
    <div class="col-12 col-lg-5">
        <div class="saas-card">
            <div class="saas-card-header">
                <div class="saas-card-title">
                    <i class="bi bi-buildings-fill"></i>
                    <span>Top Companies</span>
                </div>
                <a href="{{ route('admin.companies') }}" class="saas-view-all">
                    <span>View All</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @php
                $topCompaniesList = [
                    [
                        'rank' => 1,
                        'name' => 'TCS Technologies',
                        'count' => '42 Internships',
                        'pct' => 28,
                        'logo_bg' => '#008080',
                        'logo_text' => 'tcs',
                        'logo_color' => '#FFFFFF',
                    ],
                    [
                        'rank' => 2,
                        'name' => 'Infosys',
                        'count' => '34 Internships',
                        'pct' => 22,
                        'logo_bg' => '#0070AD',
                        'logo_text' => 'Infosys',
                        'logo_color' => '#FFFFFF',
                    ],
                    [
                        'rank' => 3,
                        'name' => 'Accenture',
                        'count' => '28 Internships',
                        'pct' => 18,
                        'logo_bg' => '#A100FF',
                        'logo_text' => '>',
                        'logo_color' => '#FFFFFF',
                    ]
                ];
            @endphp

            <div class="company-ranking-list">
                @foreach($topCompaniesList as $comp)
                    <div class="company-rank-row">
                        <div class="company-rank-num">{{ $comp['rank'] }}</div>
                        <div class="company-logo-circle" style="background: {{ $comp['logo_bg'] }}; color: {{ $comp['logo_color'] }}; font-size: 0.75rem;">
                            {{ $comp['logo_text'] }}
                        </div>
                        <div style="min-width: 130px;">
                            <div class="fw-bold text-dark" style="font-size:0.875rem;">{{ $comp['name'] }}</div>
                            <div class="text-secondary" style="font-size:0.75rem;">{{ $comp['count'] }}</div>
                        </div>
                        <div class="company-progress-track">
                            <div class="company-progress-fill" style="width: {{ $comp['pct'] * 2.5 }}%;"></div>
                        </div>
                        <span class="small fw-bold text-secondary ms-2">{{ $comp['pct'] }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Overview Analytics Chart.js Script matching mockup -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('overviewAnalyticsChart');
    if (!ctx) return;

    // Smooth gradient fills for dual line chart
    const chartCtx = ctx.getContext('2d');
    
    const gradStudents = chartCtx.createLinearGradient(0, 0, 0, 260);
    gradStudents.addColorStop(0, 'rgba(37, 99, 235, 0.22)');
    gradStudents.addColorStop(1, 'rgba(37, 99, 235, 0.00)');

    const gradApps = chartCtx.createLinearGradient(0, 0, 0, 260);
    gradApps.addColorStop(0, 'rgba(139, 92, 246, 0.18)');
    gradApps.addColorStop(1, 'rgba(139, 92, 246, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Oct 5', 'Oct 10', 'Oct 15', 'Oct 20', 'Oct 25', 'Oct 30', 'Nov 3'],
            datasets: [
                {
                    label: 'Students',
                    data: [130, 160, 150, 190, 260, 240, 290],
                    borderColor: '#2563EB',
                    backgroundColor: gradStudents,
                    fill: true,
                    tension: 0.42,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#2563EB',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4.5,
                    pointHoverRadius: 7,
                },
                {
                    label: 'Applications',
                    data: [75, 90, 85, 115, 130, 120, 160],
                    borderColor: '#8B5CF6',
                    backgroundColor: gradApps,
                    fill: true,
                    tension: 0.42,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#8B5CF6',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4.5,
                    pointHoverRadius: 7,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0F172A',
                    titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                    usePointStyle: true,
                }
            },
            scales: {
                x: {
                    grid: {
                        color: '#F1F5F9',
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#94A3B8'
                    }
                },
                y: {
                    min: 0,
                    max: 400,
                    ticks: {
                        stepSize: 100,
                        font: { family: 'Inter', size: 11 },
                        color: '#94A3B8'
                    },
                    grid: {
                        color: '#F1F5F9',
                        drawBorder: false
                    }
                }
            }
        }
    });
});
</script>

@endsection
