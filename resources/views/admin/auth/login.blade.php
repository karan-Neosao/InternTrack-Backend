<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | InternTrack</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #3454D1;
            --primary-hover: #2642b5;
            --sidebar-bg: #111827;
            --body-bg: #F5F7FB;
            --border-color: #E5E7EB;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #F5F7FB 0%, #E9EEF9 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #1F2937;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #FFFFFF;
            padding: 44px 38px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 40px -15px rgba(17, 24, 39, 0.08);
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3454D1 0%, #5B7BFE 100%);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 14px rgba(52, 84, 209, 0.35);
        }

        .brand-title {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #111827;
        }

        .brand-title span {
            color: #3454D1;
        }

        .form-control {
            padding: 11px 14px;
            border-radius: 9px;
            border: 1px solid var(--border-color);
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(52, 84, 209, 0.12);
        }

        .btn-login {
            background: var(--primary);
            color: white;
            padding: 12px;
            border-radius: 9px;
            font-weight: 600;
            font-size: 0.9375rem;
            border: none;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            color: white;
            box-shadow: 0 4px 14px rgba(52, 84, 209, 0.35);
        }

        .password-toggle-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            border-left: none;
            color: #6B7280;
            padding: 0 14px;
            cursor: pointer;
            border-top-right-radius: 9px;
            border-bottom-right-radius: 9px;
        }

        .password-toggle-btn:hover {
            color: #1F2937;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="brand-header">
        <div class="brand-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <div class="brand-title">Intern<span>Track</span></div>
            <div class="text-secondary small">Administration Portal</div>
        </div>
    </div>

    <h4 class="fw-bold mb-1">Sign In</h4>
    <p class="text-secondary small mb-4">
        Enter your administrative credentials to access the console.
    </p>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 small border-0 mb-3" style="border-radius:8px;">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 small border-0 mb-3" style="border-radius:8px;">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 small border-0 mb-3" style="border-radius:8px;">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold small text-dark">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 9px 0 0 9px; border-color: var(--border-color);">
                    <i class="bi bi-envelope"></i>
                </span>
                <input
                    type="email"
                    name="email"
                    class="form-control border-start-0"
                    placeholder="admin@interntrack.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    style="border-radius: 0 9px 9px 0;"
                >
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small text-dark">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 9px 0 0 9px; border-color: var(--border-color);">
                    <i class="bi bi-shield-lock"></i>
                </span>
                <input
                    type="password"
                    name="password"
                    id="passwordInput"
                    class="form-control border-start-0 border-end-0"
                    placeholder="••••••••"
                    required
                >
                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                    <i class="bi bi-eye" id="passwordToggleIcon"></i>
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input
                    type="checkbox"
                    name="remember"
                    class="form-check-input"
                    id="remember"
                >
                <label class="form-check-label text-secondary small" for="remember">
                    Keep me signed in
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100">
            Sign In to Dashboard &rarr;
        </button>
    </form>

    <div class="text-center text-muted small mt-4 pt-2 border-top">
        Protected admin area · © {{ date('Y') }} InternTrack
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
</script>

</body>
</html>
