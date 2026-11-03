<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | InternTrack</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --navy-dark: #0A0F1D;
            --border-color: #E2E8F0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background-color: #F1F5F9;
            /* Subtle tech grid background pattern */
            background-image: radial-gradient(#CBD5E1 1px, transparent 1px);
            background-size: 24px 24px;
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
            color: #0F172A;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }

        /* MASTER FRAMED BOX CONTAINER */
        .portal-card {
            width: 100%;
            max-width: 1140px;
            min-height: 620px;
            background: #FFFFFF;
            border-radius: 20px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.14), 0 0 0 1px rgba(15, 23, 42, 0.04);
            display: flex;
            overflow: hidden;
            position: relative;
        }

        /* LEFT BRANDING HERO (INSIDE FRAME) */
        .brand-panel {
            flex: 1.1;
            background: linear-gradient(150deg, #1E3A8A 0%, #0F172A 60%, #020617 100%);
            color: #FFFFFF;
            padding: 44px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.28) 0%, rgba(37, 99, 235, 0) 70%);
            top: -100px;
            left: -100px;
            filter: blur(40px);
            pointer-events: none;
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, rgba(79, 70, 229, 0) 70%);
            bottom: -60px;
            right: -60px;
            filter: blur(40px);
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
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 12px;
        }

        .brand-logo-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #FFFFFF;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4);
        }

        .brand-logo-text {
            font-size: 1.2rem;
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
            margin: 28px 0;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(59, 130, 246, 0.18);
            border: 1px solid rgba(96, 165, 250, 0.35);
            color: #93C5FD;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 999px;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .hero-heading {
            font-size: 2.15rem;
            font-weight: 800;
            line-height: 1.22;
            letter-spacing: -0.8px;
            margin-bottom: 12px;
            color: #F8FAFC;
        }

        .hero-heading .gradient-text {
            background: linear-gradient(135deg, #93C5FD 0%, #60A5FA 50%, #38BDF8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 0.9375rem;
            line-height: 1.55;
            color: #94A3B8;
            margin-bottom: 24px;
        }

        /* 2x2 Grid Stats Cards */
        .career-stat-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 10px;
            padding: 14px 16px;
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(96, 165, 250, 0.4);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            background: rgba(59, 130, 246, 0.22);
            color: #60A5FA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 1.3rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #94A3B8;
            margin-top: 3px;
        }

        .brand-footer {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 16px;
            color: #64748B;
            font-size: 0.75rem;
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

        /* RIGHT LOGIN FORM (INSIDE FRAME) */
        .login-panel {
            flex: 0.9;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 44px 46px;
            position: relative;
        }

        .login-wrapper {
            width: 100%;
            max-width: 380px;
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 6px;
            background: #F1F5F9;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .login-badge i {
            color: var(--primary);
        }

        .login-title {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -0.6px;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .login-desc {
            font-size: 0.875rem;
            color: #64748B;
            margin-bottom: 22px;
            line-height: 1.45;
        }

        /* Form elements - Modern Square Aesthetic */
        .form-group-custom {
            margin-bottom: 16px;
        }

        .form-label-custom {
            display: block;
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
            left: 13px;
            color: #94A3B8;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-custom {
            width: 100%;
            height: 46px;
            padding: 10px 14px 10px 40px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: #F8FAFC;
            font-size: 0.9rem;
            color: #0F172A;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .input-custom:focus {
            background: #FFFFFF;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
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
            padding: 4px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: #0F172A;
        }

        .btn-submit {
            width: 100%;
            height: 46px;
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
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.22);
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
        }

        /* 1-Click Demo Credentials Pill */
        .demo-credentials-card {
            background: #F8FAFC;
            border: 1px dashed #CBD5E1;
            border-radius: 8px;
            padding: 10px 12px;
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .demo-text {
            font-size: 0.775rem;
            color: #334155;
            line-height: 1.35;
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
            padding: 5px 10px;
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

        /* Responsive */
        @media (max-width: 992px) {
            body {
                padding: 16px;
            }

            .portal-card {
                flex-direction: column;
                min-height: auto;
            }

            .brand-panel {
                padding: 32px 24px;
                flex: none;
            }

            .hero-heading {
                font-size: 1.75rem;
            }

            .career-stat-cards {
                grid-template-columns: 1fr 1fr;
            }

            .login-panel {
                padding: 36px 24px;
                flex: none;
            }
        }
    </style>
</head>

<body>

<!-- FRAMED PROFESSIONAL PORTAL CONTAINER -->
<div class="portal-card">

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
                <i class="bi bi-stars"></i> Next-Gen Career & Internship Hub
            </div>

            <h1 class="hero-heading">
                Accelerating Tech Careers.<br>
                <span class="gradient-text">Empowering Tomorrow's Talent.</span>
            </h1>

            <p class="hero-subtitle">
                The centralized enterprise ecosystem connecting students, universities, and top corporate employers for high-impact internship opportunities.
            </p>

            <!-- 2x2 Stat Cards -->
            <div class="career-stat-cards">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-buildings"></i>
                    </div>
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Verified Companies</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="stat-number">12,000+</div>
                    <div class="stat-label">Students Placed</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="stat-number">98.4%</div>
                    <div class="stat-label">Placement Success</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="stat-number">Real-Time</div>
                    <div class="stat-label">Tracking Console</div>
                </div>
            </div>
        </div>

        <!-- Bottom Trust Footer -->
        <div class="brand-footer">
            <div class="d-flex align-items-center gap-3">
                <div class="trust-badge-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>ISO 27001 Secure</span>
                </div>
                <div class="trust-badge-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Enterprise RBAC</span>
                </div>
            </div>
            <div>
                © {{ date('Y') }} InternTrack
            </div>
        </div>

    </div>

    <!-- RIGHT SIDE: MODERN SQUARE-STYLE LOGIN FORM -->
    <div class="login-panel">
        <div class="login-wrapper">

            <div class="login-badge">
                <i class="bi bi-shield-lock-fill"></i> Administrative Portal
            </div>

            <h2 class="login-title">Sign in to console</h2>
            <p class="login-desc">Enter your credentials to manage students, companies, and internship placements.</p>

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

            <form action="/admin/login" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="form-group-custom">
                    <label class="form-label-custom" for="adminEmail">Work Email Address</label>
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
                    <label class="form-label-custom" for="passwordInput">Password</label>
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

                <!-- Remember Me -->
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

            <!-- 1-Click Demo Credentials for Recruiters -->
            <div class="demo-credentials-card">
                <div class="demo-text">
                    <strong>Demo Admin Access:</strong>
                    <span>admin@interntrack.com · password123</span>
                </div>
                <button type="button" class="btn-fill-demo" onclick="fillDemoCredentials()">
                    <i class="bi bi-lightning-charge-fill"></i> Auto-Fill
                </button>
            </div>

            <div class="text-center text-muted small mt-3 pt-2 border-top" style="border-color: #F1F5F9 !important; font-size: 0.725rem;">
                InternTrack Enterprise Console v2.4
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
