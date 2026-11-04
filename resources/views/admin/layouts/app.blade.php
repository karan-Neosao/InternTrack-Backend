<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Console') | InternTrack</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --primary-light: #EFF6FF;
            --primary-glow: rgba(37, 99, 235, 0.25);
            --sidebar-bg: #0B132B;
            --sidebar-border: #1E293B;
            --sidebar-text: #94A3B8;
            --sidebar-active: #2563EB;
            --body-bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --info: #0EA5E9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: var(--body-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--text-dark);
            font-size: 0.875rem;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6, .brand-text {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-bg);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border-right: 1px solid var(--sidebar-border);
        }

        .sidebar-brand {
            padding: 20px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #FFFFFF;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #2563EB 0%, #38BDF8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 20px;
            color: #FFFFFF;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
            flex-shrink: 0;
        }

        .sidebar-brand-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .sidebar-brand-sub {
            font-size: 0.6875rem;
            color: #64748B;
            font-weight: 500;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 14px;
            overflow-y: auto;
        }

        .sidebar-section-title {
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            color: #475569;
            padding: 14px 12px 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            margin-bottom: 4px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .sidebar-link i.nav-icon {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
            transition: transform 0.2s;
        }

        .sidebar-link .sidebar-chevron {
            margin-left: auto;
            font-size: 0.75rem;
            color: #475569;
            transition: all 0.2s;
        }

        .sidebar-link:hover {
            color: #FFFFFF;
            background-color: rgba(255, 255, 255, 0.05);
            transform: translateX(2px);
        }

        .sidebar-link:hover .sidebar-chevron {
            color: #94A3B8;
        }

        .sidebar-link.active {
            background: #2563EB !important;
            color: #FFFFFF !important;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        .sidebar-link.active .sidebar-chevron {
            color: #FFFFFF;
        }

        /* Promo Card matching mockup */
        .sidebar-promo-card {
            margin: 14px 12px 18px;
            padding: 18px 14px;
            border-radius: 16px;
            background: linear-gradient(135deg, #1E3A8A 0%, #1D4ED8 100%);
            color: #FFFFFF;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(30, 58, 138, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-promo-card .promo-icon {
            font-size: 26px;
            margin-bottom: 6px;
        }

        .sidebar-promo-card .promo-title {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 3px;
            letter-spacing: -0.2px;
        }

        .sidebar-promo-card .promo-sub {
            font-size: 0.6875rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .sidebar-promo-card .promo-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            background: #FFFFFF;
            color: #1D4ED8;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .sidebar-promo-card .promo-btn:hover {
            background: #F8FAFC;
            transform: translateY(-1px);
        }

        /* Topbar Search Box matching mockup */
        .topbar-search-box {
            background: #F1F5F9;
            border-radius: 9999px;
            padding: 8px 16px;
            width: 320px;
            max-width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .topbar-search-box:focus-within {
            background: #FFFFFF;
            border-color: #CBD5E1;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .topbar-search-input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.8125rem;
            color: #0F172A;
            width: 100%;
        }

        .topbar-search-input::placeholder {
            color: #94A3B8;
        }

        .topbar-bell-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #F1F5F9;
            color: #0F172A;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            text-decoration: none;
            border: none;
            transition: background 0.2s;
        }

        .topbar-bell-btn:hover {
            background: #E2E8F0;
        }

        .topbar-bell-btn .bell-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #EF4444;
            color: #FFFFFF;
            font-size: 0.625rem;
            font-weight: 700;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FFFFFF;
        }
            color: #FFFFFF;
        }

        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(0, 0, 0, 0.2);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 6px 8px;
            border-radius: 8px;
            text-decoration: none;
            color: #FFFFFF;
            transition: background 0.2s;
        }

        .sidebar-user:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3454D1 0%, #818CF8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: #FFFFFF;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .sidebar-user-info {
            overflow: hidden;
            flex: 1;
        }

        .sidebar-user-name {
            font-weight: 600;
            font-size: 0.8125rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.6875rem;
            color: #94A3B8;
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Topbar */
        .topbar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-toggle {
            display: none;
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 10px;
            color: var(--text-dark);
            font-size: 1.125rem;
            cursor: pointer;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .topbar-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.15s;
        }

        .topbar-breadcrumb a:hover {
            color: var(--primary);
        }

        .topbar-breadcrumb .separator {
            font-size: 0.6875rem;
            color: #CBD5E1;
        }

        .topbar-breadcrumb .active-item {
            color: var(--text-dark);
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: 9px;
            border: 1px solid var(--border-color);
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .topbar-btn:hover {
            background-color: #F8FAFC;
            border-color: #CBD5E1;
            color: var(--primary);
            transform: translateY(-1px);
        }

        .topbar-btn .badge-pill {
            position: absolute;
            top: -4px;
            right: -4px;
            padding: 3px 6px;
            font-size: 0.625rem;
            font-weight: 700;
            background-color: var(--danger);
            color: #FFFFFF;
            border-radius: 9999px;
            border: 2px solid #FFFFFF;
            line-height: 1;
        }

        /* Pulse Beacon */
        .pulse-beacon {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.1);
            color: #065F46;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: var(--success);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Content Area */
        .content-container {
            flex: 1;
            padding: 28px 30px;
        }

        /* Cards & Metric Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02), 0 1px 2px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .stat-card {
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
            height: 100%;
            position: relative;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.03);
            border-color: #CBD5E1;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: transform 0.2s;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.08);
        }

        .stat-icon.primary { background: #EEF2FF; color: #3454D1; }
        .stat-icon.success { background: #ECFDF5; color: #10B981; }
        .stat-icon.warning { background: #FFFBEB; color: #F59E0B; }
        .stat-icon.danger  { background: #FEF2F2; color: #EF4444; }
        .stat-icon.purple  { background: #F5F3FF; color: #8B5CF6; }
        .stat-icon.teal    { background: #F0FDFA; color: #0D9488; }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            margin-top: 14px;
        }

        .stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-top: 4px;
            line-height: 1.15;
            letter-spacing: -0.5px;
        }

        .stat-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 6px;
        }

        /* Buttons & Inputs */
        .btn {
            font-weight: 600;
            border-radius: 9px;
            padding: 8px 16px;
            font-size: 0.875rem;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 1px 2px rgba(52, 84, 209, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            box-shadow: 0 4px 12px var(--primary-glow);
            transform: translateY(-1px);
        }

        .btn-light {
            background-color: #F8FAFC;
            border-color: var(--border-color);
            color: var(--text-dark);
        }

        .btn-light:hover {
            background-color: #F1F5F9;
            border-color: #CBD5E1;
            color: var(--text-dark);
        }

        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: 9px;
            padding: 9px 13px;
            font-size: 0.875rem;
            background-color: #FFFFFF;
            color: var(--text-dark);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        /* Tables */
        .table {
            margin-bottom: 0;
            color: var(--text-dark);
            font-size: 0.875rem;
        }

        .table thead th {
            background-color: #F8FAFC;
            color: #475569;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 13px 18px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px 18px;
            vertical-align: middle;
            border-bottom: 1px solid #F1F5F9;
        }

        .table tbody tr {
            transition: background-color 0.15s ease;
        }

        .table tbody tr:hover {
            background-color: #F8FAFC;
        }

        /* Status Badges */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: capitalize;
            letter-spacing: 0.2px;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .badge-status.active,
        .badge-status.accepted,
        .badge-status.verified {
            background-color: #ECFDF5;
            color: #065F46;
        }
        .badge-status.active::before,
        .badge-status.accepted::before,
        .badge-status.verified::before {
            background-color: #10B981;
        }

        .badge-status.pending {
            background-color: #FFFBEB;
            color: #92400E;
        }
        .badge-status.pending::before {
            background-color: #F59E0B;
        }

        .badge-status.reviewed {
            background-color: #EFF6FF;
            color: #1E40AF;
        }
        .badge-status.reviewed::before {
            background-color: #3B82F6;
        }

        .badge-status.rejected,
        .badge-status.inactive,
        .badge-status.closed {
            background-color: #FEF2F2;
            color: #991B1B;
        }
        .badge-status.rejected::before,
        .badge-status.inactive::before,
        .badge-status.closed::before {
            background-color: #EF4444;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 1030;
        }

        /* Mobile Breakpoints */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .topbar-toggle {
                display: inline-flex;
            }

            .content-container {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<!-- Mobile Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">

    <!-- Brand -->
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <div class="sidebar-brand-title">InternTrack</div>
            <div class="sidebar-brand-sub">Student Internship Portal</div>
        </div>
    </a>

    <!-- Nav Menu -->
    <div class="sidebar-nav">

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill nav-icon"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.students') }}"
           class="sidebar-link {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
            <i class="bi bi-people-fill nav-icon"></i>
            <span>Students</span>
            <i class="bi bi-chevron-right sidebar-chevron"></i>
        </a>

        <a href="{{ route('admin.companies') }}"
           class="sidebar-link {{ request()->routeIs('admin.companies*') ? 'active' : '' }}">
            <i class="bi bi-buildings-fill nav-icon"></i>
            <span>Companies</span>
        </a>

        <a href="{{ route('admin.internships') }}"
           class="sidebar-link {{ request()->routeIs('admin.internships*') ? 'active' : '' }}">
            <i class="bi bi-briefcase-fill nav-icon"></i>
            <span>Internships</span>
        </a>

        <a href="{{ route('admin.applications') }}"
           class="sidebar-link {{ request()->routeIs('admin.applications*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text-fill nav-icon"></i>
            <span>Applications</span>
        </a>

        <a href="{{ route('admin.reports') }}"
           class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line-fill nav-icon"></i>
            <span>Reports</span>
        </a>

        <a href="{{ route('admin.settings') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill nav-icon"></i>
            <span>Settings</span>
        </a>

        <!-- Quick Access Section matching mockup -->
        <div class="sidebar-section-title">QUICK ACCESS</div>

        <a href="{{ route('admin.students') }}" class="sidebar-link">
            <i class="bi bi-plus-lg nav-icon"></i>
            <span>Add Student</span>
        </a>

        <a href="{{ route('admin.companies') }}" class="sidebar-link">
            <i class="bi bi-buildings nav-icon"></i>
            <span>Add Company</span>
        </a>

        <a href="{{ route('admin.reports') }}" class="sidebar-link">
            <i class="bi bi-bar-chart nav-icon"></i>
            <span>View Reports</span>
        </a>

        <!-- Grow Together Promo Card matching mockup -->
        <div class="sidebar-promo-card">
            <div class="promo-icon">🚀</div>
            <div class="promo-title">Grow Together</div>
            <div class="promo-sub">Build Your Career with InternTrack</div>
            <a href="{{ route('admin.reports') }}" class="promo-btn">
                <span>Learn More</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

    </div>

</aside>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Top Navigation Bar -->
    <header class="topbar">

        <div class="topbar-left d-flex align-items-center gap-3">
            <button class="topbar-toggle" onclick="toggleSidebar()" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>

            <!-- Search Bar matching mockup -->
            <div class="topbar-search-box d-none d-md-flex align-items-center">
                <i class="bi bi-search text-muted"></i>
                <input type="text" placeholder="Search students, companies... (Ctrl + K)" class="topbar-search-input" id="globalAdminSearch">
            </div>
        </div>

        <div class="topbar-right d-flex align-items-center gap-3">

            <!-- Notifications Dropdown -->
            <div class="dropdown">
                @php
                    $unreadCount = auth()->user()?->unreadNotifications()->count() ?? 3;
                    $recentNotes = auth()->user()?->notifications()->take(5)->get() ?? collect();
                @endphp
                <a href="#" class="topbar-bell-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                    <i class="bi bi-bell-fill"></i>
                    <span class="bell-badge">3</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow-lg p-0" style="width: 320px; border-radius: 12px; border: 1px solid var(--border-color);">
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="fw-bold text-dark">Notifications</div>
                        @if($unreadCount > 0)
                            <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-decoration-none text-primary" style="font-size:0.75rem;">
                                    Mark all read
                                </button>
                            </form>
                        @endif
                    </div>

                    <div style="max-height: 280px; overflow-y: auto;">
                        @forelse($recentNotes as $note)
                            <a href="{{ route('admin.notifications.show', $note->id) }}" class="d-flex align-items-start gap-2 p-3 text-decoration-none border-bottom text-dark {{ !$note->read_at ? 'bg-light' : '' }}">
                                <div class="stat-icon primary flex-shrink-0" style="width:32px; height:32px; font-size:0.875rem;">
                                    <i class="bi {{ $note->data['icon'] ?? 'bi-bell' }}"></i>
                                </div>
                                <div class="flex-grow-1" style="font-size:0.75rem;">
                                    <div class="fw-semibold text-dark">{{ $note->data['title'] ?? 'Notification' }}</div>
                                    <div class="text-secondary text-truncate" style="max-width:210px;">{{ $note->data['message'] ?? '' }}</div>
                                    <div class="text-muted mt-1" style="font-size:0.6875rem;">{{ $note->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        @empty
                            <div class="p-3 d-flex align-items-start gap-2 border-bottom">
                                <div class="stat-icon primary flex-shrink-0" style="width:32px; height:32px; font-size:0.875rem;">
                                    <i class="bi bi-person-fill text-primary"></i>
                                </div>
                                <div class="flex-grow-1" style="font-size:0.75rem;">
                                    <div class="fw-semibold text-dark">New student registered</div>
                                    <div class="text-secondary">Rahul Patil joined platform</div>
                                    <div class="text-muted mt-1" style="font-size:0.6875rem;">2 min ago</div>
                                </div>
                            </div>
                            <div class="p-3 d-flex align-items-start gap-2 border-bottom">
                                <div class="stat-icon flex-shrink-0" style="width:32px; height:32px; font-size:0.875rem; background:#ECFDF5; color:#10B981; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-buildings-fill"></i>
                                </div>
                                <div class="flex-grow-1" style="font-size:0.75rem;">
                                    <div class="fw-semibold text-dark">New company added</div>
                                    <div class="text-secondary">TCS Technologies registered</div>
                                    <div class="text-muted mt-1" style="font-size:0.6875rem;">5 min ago</div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-2 text-center border-top bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        <a href="{{ route('admin.notifications') }}" class="text-decoration-none text-primary fw-semibold" style="font-size:0.75rem;">
                            View All Notifications &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown matching mockup -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="sidebar-user-avatar" style="width:38px; height:38px; border-radius:50%; background: linear-gradient(135deg, #2563EB 0%, #38BDF8 100%); overflow:hidden; display:flex; align-items:center; justify-content:center;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&h=120&q=80" alt="Admin" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <span style="display:none; color:white; font-weight:700;">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="d-none d-md-block text-start">
                        <div class="fw-bold text-dark" style="font-size:0.875rem; line-height:1.2;">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </div>
                        <div class="text-secondary" style="font-size:0.6875rem;">Super Admin</div>
                    </div>
                    <i class="bi bi-chevron-down text-secondary ms-1 d-none d-md-inline" style="font-size:0.6875rem;"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width: 200px; border-radius: 10px; border: 1px solid var(--border-color);">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold text-dark">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <div class="text-muted small text-truncate">{{ auth()->user()->email ?? 'admin@interntrack.com' }}</div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('admin.settings') }}">
                            <i class="bi bi-person me-2 text-primary"></i> Account Settings
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('admin.reports') }}">
                            <i class="bi bi-graph-up me-2 text-success"></i> Performance Reports
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger">
                                <i class="bi bi-box-arrow-left me-2"></i> Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>

    </header>

                <div class="dropdown-menu dropdown-menu-end shadow-lg p-0" style="width: 320px; border-radius: 12px; border: 1px solid var(--border-color);">
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="fw-bold text-dark">Notifications</div>
                        @if($unreadCount > 0)
                            <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-decoration-none text-primary" style="font-size:0.75rem;">
                                    Mark all read
                                </button>
                            </form>
                        @endif
                    </div>

                    <div style="max-height: 280px; overflow-y: auto;">
                        @forelse($recentNotes as $note)
                            <a href="{{ route('admin.notifications.show', $note->id) }}" class="d-flex align-items-start gap-2 p-3 text-decoration-none border-bottom text-dark {{ !$note->read_at ? 'bg-light' : '' }}">
                                <div class="stat-icon primary flex-shrink-0" style="width:32px; height:32px; font-size:0.875rem;">
                                    <i class="bi {{ $note->data['icon'] ?? 'bi-bell' }}"></i>
                                </div>
                                <div class="flex-grow-1" style="font-size:0.75rem;">
                                    <div class="fw-semibold text-dark">{{ $note->data['title'] ?? 'Notification' }}</div>
                                    <div class="text-secondary text-truncate" style="max-width:210px;">{{ $note->data['message'] ?? '' }}</div>
                                    <div class="text-muted mt-1" style="font-size:0.6875rem;">{{ $note->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center text-secondary small">
                                <i class="bi bi-bell-slash fs-4 d-block mb-1 text-muted"></i>
                                No notifications yet
                            </div>
                        @endforelse
                    </div>

                    </div>
                </div>
            </div>

    <!-- Main Content Container -->
    <main class="content-container">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm border-0 mb-4" role="alert" style="border-radius:10px;">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm border-0 mb-4" role="alert" style="border-radius:10px;">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius:10px;">
                <div class="d-flex align-items-center gap-2 fw-bold mb-1">
                    <i class="bi bi-exclamation-circle-fill"></i> Please correct the following errors:
                </div>
                <ul class="mb-0 ps-4 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Yield Content -->
        @yield('content')

    </main>

</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Scripts -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
</script>

@stack('scripts')

</body>
</html>
