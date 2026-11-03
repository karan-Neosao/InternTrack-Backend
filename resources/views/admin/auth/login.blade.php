<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | InternTrack - Enterprise Internship Platform</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --primary-light: #EFF6FF;
            --dark-navy: #0A0F1D;
            --surface-dark: #111827;
            --border-color: #E2E8F0;
            --text-muted: #64748B;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background-color: #FFFFFF;
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #0F172A;
            overflow-x: hidden;
        }

        .split-layout {
            min-height: 100vh;
            display: flex;
        }

        /* LEFT BRANDING HERO SECTION */
        .brand-panel {
            flex: 1.15;
            background: radial-gradient(circle at 20% 20%, #1E40AF 0%, #0F172A 70%, #020617 100%);
            color: #FFFFFF;
            position: relative;
            padding: 56px 64px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        /* Abstract glowing background shapes */
        .brand-panel::before {
            content: '';
            position: absolute;
            width: 480px;
            height: 480px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, rgba(37, 99, 235, 0) 70%);
            top: -120px;
            left: -120px;
            filter: blur(40px);
            pointer-events: none;
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, rgba(79, 70, 229, 0) 70%);
            bottom: -80px;
            right: -80px;
            filter: blur(50px);
            pointer-events: none;
        }

        .brand-top {
            position: relative;
            z-index: 2;
        }

        .brand-logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(12px);
            padding: 10px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .brand-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .brand-logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #FFFFFF;
        }

        .brand-logo-text span {
            color: #60A5FA;
        }

        .brand-center {
            position: relative;
            z-index: 2;
            margin: 40px 0;
            max-width: 580px;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, 0.16);
            border: 1px solid rgba(96, 165, 250, 0.3);
            color: #93C5FD;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .hero-heading {
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.18;
            letter-spacing: -1px;
            margin-bottom: 18px;
            color: #F8FAFC;
        }

        .hero-heading .gradient-text {
            background: linear-gradient(135deg, #93C5FD 0%, #60A5FA 50%, #38BDF8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.05rem;
            line-height: 1.6;
            color: #94A3B8;
            margin-bottom: 36px;
        }

        /* Glassmorphic Showcase Cards */
        .career-stat-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(14px);
            border-radius: 12px;
            padding: 18px 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(96, 165, 250, 0.35);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.2);
            color: #60A5FA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.5px;
        }

        .stat-label {
            font-size: 0.8125rem;
            color: #94A3B8;
            margin-top: 2px;
        }

        .brand-footer {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            color: #64748B;
            font-size: 0.8125rem;
        }

        .trust-badges {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .trust-badge-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #94A3B8;
        }

        .trust-badge-item i {
            color: #10B981;
        }

        /* RIGHT LOGIN FORM SECTION */
        .login-panel {
            flex: 0.85;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 6px;
            background: #F1F5F9;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 16px;
        }

        .login-badge i {
            color: var(--primary);
        }

        .login-title {
            font-size: 1.875rem;
            font-weight: 800;
            letter-spacing: -0.7px;
            color: #0F172A;
            margin-bottom: 8px;
        }

        .login-desc {
            font-size: 0.9375rem;
            color: var(--text-muted);
            margin-bottom: 28px;
            line-height: 1.5;
        }

        /* Form elements - Modern Square Aesthetic */
        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-label-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #1E293B;
            margin-bottom: 6px;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94A3B8;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-custom {
            width: 100%;
            height: 48px;
            padding: 10px 14px 10px 42px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: #F8FAFC;
            font-size: 0.9375rem;
            color: #0F172A;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .input-custom:focus {
            background: #FFFFFF;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .input-box:focus-within .input-icon {
            color: var(--primary);
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: #0F172A;
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            background: var(--primary);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* 1-Click Demo Credentials Pill */
        .demo-credentials-card {
            background: #F8FAFC;
            border: 1px dashed #CBD5E1;
            border-radius: 8px;
            padding: 12px 14px;
            margin-top: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .demo-text {
            font-size: 0.8125rem;
            color: #334155;
            line-height: 1.4;
        }

        .demo-text strong {
            color: #0F172A;
            display: block;
        }

        .btn-fill-demo {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .btn-fill-demo:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #FFFFFF;
        }

        /* Responsive layout */
        @media (max-width: 992px) {
            .split-layout {
                flex-direction: column;
            }

            .brand-panel {
                padding: 36px 24px;
                flex: none;
            }

            .hero-heading {
                font-size: 2rem;
            }

            .career-stat-cards {
                grid-template-columns: 1fr;
            }

            .login-panel {
                padding: 40px 24px;
                flex: none;
            }
        }
    </style>
</head>

<body>

<div class="split-layout">

    <!-- LEFT SIDE: CAREER SHOWCASE & BRANDING -->
    <div class="brand-panel">
        
        <!-- Top Branding Logo -->
        <div class="brand-top">
            <div class="brand-logo-badge">
                <div class="brand-logo-icon">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <div class="brand-logo-text">
                    Intern<span>Track</span>
                </div>
            </div>
        </div>

        <!-- Center Hero Content -->
        <div class="brand-center">
            <div class="hero-pill">
                <i class="bi bi-stars"></i> Next-Gen Career & Internship Platform
            </div>

            <h1 class="hero-heading">
                Accelerating Tech Careers.<br>
                <span class="gradient-text">Empowering Tomorrow's Talent.</span>
            </h1>

            <p class="hero-subtitle">
                The centralized enterprise hub connecting students, accredited universities, and verified corporate partners for high-impact internship opportunities.
            </p>

            <!-- Stat & Trust Badges -->
            <div class="career-stat-cards">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-buildings"></i>
                    </div>
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Verified Tech Companies</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="stat-number">12,000+</div>
                    <div class="stat-label">Students Placed Globally</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="stat-number">98.4%</div>
                    <div class="stat-label">Interview Success Rate</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="stat-number">Real-Time</div>
                    <div class="stat-label">Application Tracking</div>
                </div>
            </div>
        </div>

        <!-- Bottom Trust Footer -->
        <div class="brand-footer">
            <div class="trust-badges">
                <div class="trust-badge-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>ISO 27001 Secure</span>
                </div>
                <div class="trust-badge-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Role-Based Access</span>
                </div>
            </div>
            <div>
                © {{ date('Y') }} InternTrack Inc.
            </div>
        </div>

    </div>

    <!-- RIGHT SIDE: PROFESSIONAL SQUARE-STYLE LOGIN -->
    <div class="login-panel">
        <div class="login-wrapper">

            <div class="login-badge">
                <i class="bi bi-shield-lock-fill"></i> Administrative Portal
            </div>

            <h2 class="login-title">Sign in to console</h2>
            <p class="login-desc">Enter your administrative credentials to manage students, companies, and internship placements.</p>

            <!-- Status Alerts -->
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 small border-0 mb-3" style="border-radius:8px;background:#ECFDF5;color:#065F46;">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 small border-0 mb-3" style="border-radius:8px;background:#FEF2F2;color:#991B1B;">
                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 small border-0 mb-3" style="border-radius:8px;background:#FEF2F2;color:#991B1B;">
                    <i class="bi bi-exclamation-circle-fill text-danger"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="form-group-custom">
                    <label class="form-label-custom" for="adminEmail">
                        <span>Work Email Address</span>
                    </label>
                    <div class="input-box">
                        <i class="bi bi-envelope input-icon"></i>
                        <input
                            type="email"
                            id="adminEmail"
                            name="email"
                            class="input-custom"
                            placeholder="admin@interntrack.com"
                            value="{{ old('email', 'admin@interntrack.com') }}"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-group-custom">
                    <label class="form-label-custom" for="passwordInput">
                        <span>Password</span>
                    </label>
                    <div class="input-box">
                        <i class="bi bi-key input-icon"></i>
                        <input
                            type="password"
                            id="passwordInput"
                            name="password"
                            class="input-custom"
                            placeholder="••••••••••••"
                            value="password123"
                            required
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()" title="Show/Hide Password">
                            <i class="bi bi-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="remember"
                            class="form-check-input"
                            id="remember"
                            checked
                            style="border-radius: 4px;"
                        >
                        <label class="form-check-label text-secondary small" for="remember">
                            Remember this device
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Sign In to Console</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <!-- 1-Click Demo Credentials for Recruiters / LinkedIn Visitors -->
            <div class="demo-credentials-card">
                <div class="demo-text">
                    <strong>Demo Admin Access:</strong>
                    <span>admin@interntrack.com · password123</span>
                </div>
                <button type="button" class="btn-fill-demo" onclick="fillDemoCredentials()">
                    <i class="bi bi-lightning-charge-fill"></i> Auto-Fill
                </button>
            </div>

            <!-- Footer copyright -->
            <div class="text-center text-muted small mt-4 pt-3 border-top" style="border-color: #F1F5F9 !important;">
                InternTrack Enterprise v2.4 · High Security Environment
            </div>

        </div>
    </div>

</div>

<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('passwordToggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    function fillDemoCredentials() {
        document.getElementById('adminEmail').value = 'admin@interntrack.com';
        document.getElementById('passwordInput').value = 'password123';
    }
</script>

</body>
</html>
