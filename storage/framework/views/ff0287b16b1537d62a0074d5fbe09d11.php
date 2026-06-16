<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - <?php echo e(config('app.name')); ?></title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            --accent: #003b96;
            --accent-dark: #002d72;
            --ink: #1f2937;
            --muted: #4b5563;
            --line: #cfd6e3;
            --page: #f4f7fb;
            --danger: #c2410c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            background: var(--page);
            border-top: 7px solid #6d5dfc;
        }

        .login-page {
            min-height: calc(100vh - 7px);
            display: grid;
            place-items: center;
            padding: 48px 20px;
        }

        .login-shell {
            width: min(100%, 430px);
            display: grid;
            justify-items: center;
            gap: 22px;
        }

        .brand {
            display: grid;
            justify-items: center;
            gap: 10px;
            text-align: center;
        }

        .brand-mark {
            width: 64px;
            height: 64px;
            border-radius: 7px;
            background: var(--accent);
            display: grid;
            place-items: center;
            color: #fff;
            box-shadow: 0 12px 26px rgba(0, 59, 150, 0.24);
        }

        .brand-mark svg {
            width: 34px;
            height: 34px;
            stroke: currentColor;
        }

        .brand h1 {
            margin: 0;
            color: var(--accent);
            font-size: 25px;
            line-height: 1.1;
            font-weight: 800;
        }

        .brand p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .login-card {
            width: 100%;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: 26px 24px 24px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        }

        .login-card h2 {
            margin: 0 0 4px;
            font-size: 20px;
            line-height: 1.25;
            font-weight: 700;
        }

        .login-card p {
            margin: 0 0 24px;
            color: var(--muted);
            font-size: 13px;
        }

        .google-button {
            width: 100%;
            min-height: 42px;
            border: 1px solid var(--line);
            border-radius: 4px;
            background: #fff;
            color: var(--ink);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: border-color .2s ease, box-shadow .2s ease, transform .15s ease;
        }

        .google-button:hover {
            border-color: #9ca8ba;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .google-icon {
            width: 18px;
            height: 18px;
        }

        .error-box {
            margin-top: 16px;
            border: 1px solid #fed7aa;
            border-radius: 4px;
            background: #fff7ed;
            color: var(--danger);
            padding: 11px 12px;
            font-size: 13px;
            font-weight: 700;
        }

        .login-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            color: #374151;
            font-size: 12px;
        }

        .login-footer a {
            color: inherit;
            text-decoration: none;
        }

        .login-footer a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        .dot {
            width: 5px;
            height: 5px;
            border-radius: 999px;
            background: #c7cdd8;
        }

        @media (max-width: 520px) {
            body {
                border-top-width: 5px;
            }

            .login-page {
                min-height: calc(100vh - 5px);
                padding: 32px 16px;
            }

            .brand-mark {
                width: 58px;
                height: 58px;
            }

            .brand h1 {
                font-size: 22px;
            }

            .login-card {
                padding: 22px 18px;
            }
        }
    </style>
</head>
<body>
    <main class="login-page">
        <div class="login-shell">
            <div class="brand">
                <div class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 5h16v4H4z"></path>
                        <path d="M6 9h12v10H6z"></path>
                        <path d="M9 13h6"></path>
                    </svg>
                </div>
                <div>
                    <h1><?php echo e(config('app.name')); ?></h1>
                    <p>Enterprise Resource Planning</p>
                </div>
            </div>

            <section class="login-card">
                <h2>Selamat Datang</h2>
                <p>Masuk menggunakan akun Anda untuk mengakses dashboard sistem</p>

                <?php if($googleConfigured): ?>
                    <a class="google-button" href="<?php echo e(route('auth.google.redirect')); ?>">
                        <svg class="google-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.24 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"></path>
                            <path fill="#FBBC05" d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.84z"></path>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06L5.84 9.9c.87-2.6 3.3-4.52 6.16-4.52z"></path>
                        </svg>
                        Lanjutkan dengan Google     
                    </a>
                <?php else: ?>
                    <div class="error-box">Google Client ID dan Client Secret belum diisi di file .env.</div>
                <?php endif; ?>
            </section>

            <div class="login-footer">
                <a href="#">Privacy Policy</a>
                <span class="dot" aria-hidden="true"></span>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </main>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>