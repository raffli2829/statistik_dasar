<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Panel Admin Statistik Dasar Satu Data Bangka</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --primary: #DC2626;
            --primary-hover: #B91C1C;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 50%, #31101E 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #0F172A;
        }

        .login-card {
            background: #FFFFFF;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 440px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #DC2626, #F97316, #E11D48);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #DC2626, #991B1B);
            color: white;
            border-radius: 14px;
            margin-bottom: 16px;
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.35);
        }

        .login-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.02em;
        }

        .login-subtitle {
            font-size: 0.85rem;
            color: #64748B;
            margin-top: 6px;
        }

        .alert-error {
            background-color: #FEE2E2;
            border: 1px solid #FCA5A5;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94A3B8;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px 11px 42px;
            border: 1px solid #CBD5E1;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            color: #0F172A;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            color: white;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #B91C1C, #991B1B);
            transform: translateY(-1px);
        }

        .demo-credentials {
            margin-top: 24px;
            padding: 14px;
            background-color: #F8FAFC;
            border: 1px dashed #CBD5E1;
            border-radius: 10px;
            font-size: 0.78rem;
            color: #64748B;
            line-height: 1.5;
        }

        .demo-credentials strong {
            color: #0F172A;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.82rem;
            color: #64748B;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="brand-badge">
                <i data-lucide="shield-check" style="width: 28px; height: 28px;"></i>
            </div>
            <h1 class="login-title">Panel Admin Statistik</h1>
            <p class="login-subtitle">Satu Data Kabupaten Bangka</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <i data-lucide="alert-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if(session('info'))
            <div style="background-color: #E0F2FE; border: 1px solid #7DD3FC; color: #0369A1; padding: 12px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 20px;">
                {{ session('info') }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-wrapper">
                    <i data-lucide="mail" class="input-icon" style="width: 18px; height: 18px;"></i>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', 'admin@bangka.go.id') }}" required autofocus placeholder="admin@bangka.go.id">
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-wrapper">
                    <i data-lucide="lock" class="input-icon" style="width: 18px; height: 18px;"></i>
                    <input type="password" id="password" name="password" class="form-input" required placeholder="••••••••">
                </div>
            </div>

            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" value="1" checked style="accent-color: var(--primary);">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                <span>Masuk ke Dashboard</span>
                <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
            </button>
        </form>

        <div class="demo-credentials">
            <strong>🔑 Kredensial Default Admin:</strong><br>
            Email: <code>admin@bangka.go.id</code><br>
            Kata Sandi: <code>adminbangka2025</code>
        </div>

        <a href="{{ route('statistik.index') }}" class="back-link">
            ← Kembali ke Portal Publik Statistik Dasar
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
