<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            --ink: #111827;
            --muted: #6b7280;
            --line: #d9dee8;
            --panel: #ffffff;
            --page: #f3f6fb;
            --accent: #003b96;
            --accent-dark: #002d72;
            --ok: #0f9d58;
            --warn: #d94d24;
            --danger: #dc2626;
            --shadow: 0 8px 24px rgba(18, 29, 48, 0.08);
        }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; color: var(--ink); background: var(--page); font-size: 14px; }
        header { position: sticky; top: 0; z-index: 10; margin-left: 230px; background: rgba(255,255,255,0.88); border-bottom: 1px solid var(--line); backdrop-filter: blur(10px); }
        .wrap { width: 100%; max-width: none; margin: 0; padding: 0 32px; }
        .topbar { display: flex; align-items: center; justify-content: flex-end; gap: 18px; min-height: 56px; padding: 0 32px; }
        .brand { font-size: 18px; font-weight: 800; letter-spacing: 0; }
        .brand small { display: block; margin-top: 3px; font-size: 10px; color: var(--muted); font-weight: 700; letter-spacing: .08em; }
        nav, .account { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        nav a { color: #27364a; text-decoration: none; padding: 10px 12px; border: 1px solid transparent; border-radius: 4px; background: transparent; transition: all .2s ease; font-weight: 600; font-size: 13px; }
        nav a:hover, nav a.active { border-color: #d7e4fb; background: #dbeafe; color: #0b3f91; }
        .account { justify-content: flex-end; flex: 0 0 auto; }
        .account form { display: inline; }
        .account-name { color: var(--ink); font-size: 12px; font-weight: 700; }
        main { margin-left: 230px; padding: 28px 0 40px; }
        h1 { font-size: 28px; margin: 0; letter-spacing: 0; }
        h2 { font-size: 17px; margin: 0; }
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; margin-bottom: 20px; }
        .page-copy { max-width: 720px; color: var(--muted); line-height: 1.5; font-size: 13px; margin: 4px 0 0; }
        .app-shell { display: block; }
        .sidebar { position: fixed; inset: 0 auto 0 0; width: 230px; background: #f8fafc; border-right: 1px solid var(--line); padding: 26px 16px 18px; box-shadow: none; z-index: 20; display: flex; flex-direction: column; }
        .sidebar .sidebar-brand { display: grid; gap: 4px; padding: 0 2px 18px; }
        .sidebar .sidebar-brand .brand { margin: 0; }
        .sidebar .sidebar-desc { color: var(--muted); font-size: 10px; line-height: 1.4; text-transform: uppercase; letter-spacing: .08em; margin: 0; font-weight: 700; }
        .sidebar nav { margin-top: 12px; display: grid; gap: 4px; }
        .sidebar nav a { display: flex; align-items: center; gap: 10px; padding: 11px 12px; border-radius: 4px; color: #233044; text-decoration: none; background: transparent; border: 1px solid transparent; transition: all .2s ease; }
        .sidebar nav a:hover, .sidebar nav a.active { background: #dbeafe; border-color: #c7d8f5; color: #0a3d8f; }
        .sidebar-actions { display: grid; gap: 4px; margin-top: auto; border-top: 1px solid var(--line); padding-top: 18px; }
        .nav-icon { width: 16px; text-align: center; color: currentColor; font-weight: 800; }
        .page-content { display: grid; gap: 20px; }
        .card { background: var(--panel); border: 1px solid var(--line); border-radius: 6px; padding: 0; box-shadow: none; overflow: hidden; }
        .grid > section:not(.card), .page-content > section:not(.card) { background: var(--panel); border: 1px solid var(--line); border-radius: 6px; padding: 22px; }
        .card.no-shadow { box-shadow: none; }
        .card-light { background: #fff; }
        .card-body { padding: 22px; }
        .card > form, .card > p, .card > .grid:not(.notification-board) { padding: 22px; }
        .card > table { margin: 0; }
        .section-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 16px 20px; border-bottom: 1px solid var(--line); background: #fbfcff; }
        .section-head .label { color: var(--muted); font-size: 13px; text-transform: uppercase; letter-spacing: .12em; }
        label { display: block; font-size: 12px; color: #374151; margin-bottom: 7px; font-weight: 700; }
        input, select, textarea { width: 100%; border: 1px solid #cfd6e2; border-radius: 3px; padding: 10px 12px; font: inherit; background: #fff; color: var(--ink); outline: none; transition: border-color .2s ease, box-shadow .2s ease; }
        input:focus, select:focus, textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(0, 59, 150, 0.12); }
        input[readonly], .readonly-input { background: #edf1f6; color: #6b7280; border-color: #c6ceda; cursor: not-allowed; }
        textarea { min-height: 120px; resize: vertical; }
        form { display: grid; gap: 16px; }
        .field-group { display: grid; gap: 8px; }
        button, .button { border: 0; border-radius: 4px; background: var(--accent); color: #fff; padding: 11px 16px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: transform .15s ease, background .2s ease; font-size: 13px; }
        button:hover, .button:hover { transform: translateY(-1px); background: var(--accent-dark); }
        .button.secondary { background: #3d5172; }
        .button.secondary:hover { background: #32405a; }
        .button.ghost { width: auto; background: #fff; color: #374151; border: 1px solid var(--line); padding: 7px 10px; font-size: 11px; }
        .button.ghost:hover { background: #f7f9fc; color: var(--accent); }
        .danger-button { background: #dc2626; padding: 8px 10px; font-size: 12px; }
        .danger-button:hover { background: #b91c1c; }
        .form-actions { display: flex; justify-content: flex-end; padding-top: 8px; }
        .split-actions { justify-content: space-between; gap: 10px; }
        .toolbar-actions { display: flex; align-items: center; gap: 8px; }
        .item-actions { display: flex; align-items: flex-start; gap: 8px; }
        .edit-item { position: static; }
        .edit-item summary { list-style: none; cursor: pointer; border: 1px solid var(--line); border-radius: 4px; background: #fff; color: var(--accent); padding: 8px 10px; font-weight: 800; font-size: 12px; }
        .edit-item summary::-webkit-details-marker { display: none; }
        .edit-panel { width: 520px; max-width: calc(100vw - 320px); margin-top: 8px; background: #fff; border: 1px solid var(--line); border-radius: 6px; padding: 16px; box-shadow: var(--shadow); }
        .compact-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .span-all { grid-column: 1 / -1; }
        .grid { display: grid; gap: 20px; grid-template-columns: repeat(12, minmax(0, 1fr)); }
        .span-4 { grid-column: span 4; }
        .span-5 { grid-column: span 5; }
        .span-7 { grid-column: span 7; }
        .span-8 { grid-column: span 8; }
        .span-12 { grid-column: 1 / -1; }
        .notification-board { align-items: start; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { padding: 14px 18px; text-align: left; vertical-align: middle; border-bottom: 1px solid #e6ebf2; }
        th { background: #f7f9fc; color: #4b5563; font-weight: 800; letter-spacing: .02em; }
        tbody tr { background: #fff; }
        tbody tr:hover { background: #fbfdff; }
        tbody tr:last-child { border-bottom: none; }
        td { color: #213547; }
        .status, .alert { margin-bottom: 0; padding: 12px 14px; border-radius: 4px; }
        .status { border: 1px solid #b4dfc2; color: var(--ok); background: #eff9f2; }
        .alert { border: 1px solid #f0c27b; color: var(--warn); background: #fffbf1; font-weight: 700; }
        .pill { display: inline-flex; align-items: center; border-radius: 3px; padding: 4px 8px; font-size: 10px; background: #edf2f7; color: var(--ink); font-weight: 800; letter-spacing: .02em; text-transform: uppercase; }
        .pill.success { background: #e6f7ed; color: var(--ok); }
        .pill.warning { background: #fff0e8; color: var(--warn); }
        .danger { color: var(--danger); font-weight: 700; }
        .muted { color: var(--muted); }
        .table-action { color: var(--accent); text-decoration: none; font-weight: 800; font-size: 12px; }
        .table-action:hover { text-decoration: underline; }
        .item-thumb { width: 52px; height: 52px; object-fit: cover; border: 1px solid var(--line); border-radius: 4px; background: #f8fbff; display: block; }
        @media (max-width: 960px) {
            header, main { margin-left: 0; }
            .sidebar { position: static; width: auto; min-height: auto; border-right: 0; border-bottom: 1px solid var(--line); }
            .sidebar-actions { margin-top: 18px; }
            .topbar, .page-header { flex-direction: column; align-items: stretch; height: auto; padding-top: 12px; padding-bottom: 12px; }
            .grid { grid-template-columns: 1fr; }
            .span-4, .span-5, .span-7, .span-8, .span-12 { grid-column: auto; }
            .edit-panel { max-width: calc(100vw - 48px); }
        }
        @media (max-width: 720px) {
            .wrap, .topbar { padding-left: 16px; padding-right: 16px; }
            nav a, button, .button { width: 100%; justify-content: center; }
            .section-head { flex-direction: column; align-items: flex-start; }
            .item-actions { flex-direction: column; }
            .edit-item, .edit-item summary { width: 100%; }
            .edit-panel { width: 100%; max-width: 100%; margin-top: 8px; }
            .compact-grid { grid-template-columns: 1fr; }
        }
        @media print {
            header, .no-print, .sidebar { display: none; }
            body { background: #fff; }
            main { padding: 0; }
            .wrap { width: 100%; }
            .card { box-shadow: none; border: none; padding: 0; }
            table { font-size: 12px; }
        }
    </style>
</head>
<body>
<header>
    <div class="topbar">
        <div class="account">
            @auth
                <span class="account-name">{{ auth()->user()->name }}</span>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button secondary">Logout</button>
                </form>
            @else
                <a class="button" href="{{ route('login') }}">Login Google</a>
            @endauth
        </div>
    </div>
</header>
<main>
    <div class="wrap app-shell">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand">{{ config('app.name') }}</div>
                <p class="sidebar-desc">Enterprise Resource Planning</p>
            </div>
            <nav>
                <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}"><span class="nav-icon">≡</span>Pencatatan</a>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"><span class="nav-icon">□</span>Cetak Laporan</a>
                <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}"><span class="nav-icon">✉</span>Notif & Komunikasi</a>
            </nav>
            <div class="sidebar-actions">
                <a href="{{ route('home') }}"><span class="nav-icon">⚙</span>Settings</a>
                <a href="{{ route('home') }}"><span class="nav-icon">?</span>Help</a>
            </div>
        </aside>
        <section class="page-content">
            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="alert">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @yield('content')
        </section>
    </div>
</main>
</body>
</html>
