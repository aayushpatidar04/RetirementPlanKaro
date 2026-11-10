<!doctype html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') · Retirement Plan Karo</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --bg: #f5f6fa;
      --card: #fff;
      --ink: #14172b;
      --mut: #697089;
      --line: #e6e8f0;
      --pri: #4f46e5;
      --pri-s: #ecebff;
      --ok: #0f7a3d;
      --ok-s: #dcf6e6;
      --bad: #a4161a;
      --bad-s: #fde2e2;
      --warn: #8a5a00;
      --warn-s: #fdf0cf;
      box-sizing: border-box;
      padding-top: env(safe-area-inset-top, 0px);
      padding-bottom: env(safe-area-inset-bottom, 0px)
    }

    @media (prefers-color-scheme:dark) {
      :root:not([data-theme="light"]) {
        --bg: #0f1220;
        --card: #181c30;
        --ink: #eceefb;
        --mut: #9aa1bf;
        --line: #2a2f4a;
        --pri: #8b85ff;
        --pri-s: #26275a;
        --ok: #6fe0a0;
        --ok-s: #133a28;
        --bad: #ff9a9d;
        --bad-s: #4a1a1d;
        --warn: #f3c460;
        --warn-s: #3d3012
      }
    }

    :root[data-theme="dark"] {
      --bg: #0f1220;
      --card: #181c30;
      --ink: #eceefb;
      --mut: #9aa1bf;
      --line: #2a2f4a;
      --pri: #8b85ff;
      --pri-s: #26275a;
      --ok: #6fe0a0;
      --ok-s: #133a28;
      --bad: #ff9a9d;
      --bad-s: #4a1a1d;
      --warn: #f3c460;
      --warn-s: #3d3012
    }

    html {
      scroll-padding-top: env(safe-area-inset-top, 0px)
    }

    * {
      box-sizing: border-box
    }

    body {
      margin: 0;
      background: var(--bg);
      color: var(--ink);
      font: 14px/1.5 "Plus Jakarta Sans", system-ui, sans-serif;
      display: flex;
      min-height: 100vh
    }

    a {
      color: inherit;
      text-decoration: none
    }

    /* Sidebar */
    nav.side {
      width: 224px;
      flex: none;
      background: var(--card);
      border-right: 1px solid var(--line);
      padding: 18px 12px;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow: auto;
      display: flex;
      flex-direction: column
    }

    nav.side h1 {
      font-size: 16px;
      margin: 0 8px 2px
    }

    nav.side small {
      display: block;
      margin: 0 8px 14px;
      color: var(--mut)
    }

    nav.side .top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 0px 10px;
    }

    nav.side .top h1 {
      font-size: 16px;
      margin: 0
    }

    nav.side .top small {
      display: block;
      margin: 0;
      color: var(--mut)
    }

    nav.side .theme-btn {
      border: 0;
      background: none;
      font-size: 18px;
      cursor: pointer;
      padding: 4px 8px;
      border-radius: 8px;
      line-height: 1;
      color: var(--mut)
    }

    nav.side .theme-btn:hover {
      background: var(--bg);
      color: var(--ink)
    }

    nav.side .ngh {
      font-weight: 700;
      color: var(--ink);
      margin: 16px 10px 4px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13.5px;
      cursor: pointer;
      padding: 8px 10px;
    }

    nav.side .ngh:hover {
      background: var(--bg)
    }

    nav.side .ngh:first-of-type {
      margin-top: 4px
    }

    nav.side .ngh .chev {
      color: var(--mut);
      font-size: 11px
    }

    nav.side a {
      display: block;
      padding: 8px 0px;
      border-radius: 8px;
      color: var(--mut);
      cursor: pointer;
      font-weight: 500;
      font-size: 13.5px;
      margin-bottom: 2px
    }

    nav.side a:hover {
      background: var(--bg)
    }

    nav.side a.on {
      background: var(--pri-s);
      color: var(--pri);
      font-weight: 700
    }

    nav.side summary.on {
      border-radius: 8px;
      background: var(--pri-s);
      color: var(--pri);
      font-weight: 700
    }

    nav.side a.top {
      font-weight: 700;
      color: var(--ink);
      display: flex;
      align-items: center;
      gap: 6px
    }

    nav.side a.top.on {
      background: var(--pri-s);
      color: var(--pri)
    }

    nav.side .nsub {
      margin-left: 14px;
      padding: 6px 10px;
      font-size: 13.5px;
      border-left: 2px solid var(--line);
      border-radius: 0 8px 8px 0
    }

    nav.side .nsub.on {
      border-left-color: var(--pri);
      background: var(--pri-s);
      color: var(--pri);
      font-weight: 700
    }

    /* Main */
    main {
      flex: 1;
      min-width: 0;
      padding: 22px 26px 60px
    }

    h2 {
      font-size: 21px;
      margin: 0 0 14px
    }

    /* Cards */
    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      margin-bottom: 14px;
      overflow: hidden
    }

    .card>h3 {
      margin: 0;
      padding: 12px 16px;
      font-size: 14.5px;
      border-bottom: 1px solid var(--line)
    }

    .panel {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 14px
    }

    .panel h3 {
      margin: 0;
      padding: 14px 18px;
      border-bottom: 1px solid var(--line);
      font-size: 14.5px
    }

    /* Tables */
    .sc {
      overflow-x: auto
    }

    table {
      border-collapse: collapse;
      width: 100%;
      min-width: 560px;
      font-size: 13px
    }

    th,
    td {
      text-align: left;
      padding: 9px 14px;
      border-bottom: 1px solid var(--line);
      white-space: nowrap
    }

    th {
      color: var(--mut);
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .03em;
      background: color-mix(in srgb, var(--bg) 60%, var(--card))
    }

    tr:last-child td {
      border: 0
    }

    tr.c {
      cursor: pointer
    }

    tr.c:hover {
      background: var(--pri-s)
    }

    /* Pills */
    .pill {
      display: inline-block;
      padding: 2px 9px;
      border-radius: 99px;
      font-size: 12px;
      font-weight: 700;
      background: var(--bg);
      color: var(--mut)
    }

    .pill.ok {
      background: var(--ok-s);
      color: var(--ok)
    }

    .pill.bad {
      background: var(--bad-s);
      color: var(--bad)
    }

    .pill.warn {
      background: var(--warn-s);
      color: var(--warn)
    }

    .pill.pri {
      background: var(--pri-s);
      color: var(--pri)
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-family: inherit;
      font-weight: 600;
      padding: 7px 12px;
      border-radius: 8px;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--ink);
      cursor: pointer;
      font-size: 13px;
      transition: background .15s;
      text-decoration: none
    }

    .btn:hover {
      background: var(--bg)
    }

    .btn.p {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri)
    }

    .btn.p:hover {
      background: color-mix(in srgb, var(--pri) 85%, #000)
    }

    .btn.d {
      color: var(--bad)
    }

    .btn.s {
      padding: 4px 9px;
      font-size: 12.5px
    }

    /* Flash */
    .flash {
      background: var(--ok-s);
      border: 1px solid color-mix(in srgb, var(--ok) 25%, transparent);
      color: var(--ok);
      padding: 11px 16px;
      border-radius: 10px;
      margin-bottom: 18px;
      font-weight: 600;
      font-size: 13px
    }

    /* Responsive */
    @media(max-width:800px) {
      body {
        display: block
      }

      nav.side {
        position: static;
        width: auto;
        height: auto;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 4px;
        overflow-x: auto;
        padding: 8px
      }

      nav.side h1,
      nav.side small,
      nav.side .ngh,
      nav.side form.logout {
        display: none
      }

      nav.side a,
      nav.side .nsub {
        white-space: nowrap;
        margin: 0
      }

      main {
        padding: 14px
      }
    }

    @media print {
      nav.side {
        display: none
      }

      body {
        display: block
      }
    }
  </style>
  @stack('styles')
</head>

<body>
  <nav class="side">
    <div class="top">
      <div>
        <h1>Retirement Plan Karo</h1>
        <small>Admin Portal</small>
      </div>
    </div>
    <hr style="height: 2px; width: 100%; border: 0; border-top: 2px solid #000; margin: 10px 0;">
    <a href="{{ route('admin.dashboard') }}" class="top {{ request()->routeIs('admin.dashboard') ? 'on' : '' }}"
      style="padding: 8px 10px;">Dashboard</a>

    <details class="nav-group" {{ 
        request()->routeIs([
    'admin.clients',
    'admin.users',
    'admin.leads',
    'admin.payments',
  ])
  ? 'open'
  : ''}}>
      <summary class="ngh {{ request()->routeIs('admin.clients') ? 'on' : '' }}"><a href="{{ route('admin.clients') }}"
          style="color:inherit;text-decoration:none; font-weight: bold; padding: 0px;">Clients</a> <span
          class="chev">▾</span>
      </summary>
      <a href="{{ route('admin.users') }}" class="nsub {{ request()->routeIs('admin.users') ? 'on' : '' }}">Client
        Records</a>
      <a href="{{ route('admin.leads') }}"
        class="nsub {{ request()->routeIs('admin.leads') ? 'on' : '' }}">Prospects</a>
      <a href="{{ route('admin.payments') }}"
        class="nsub {{ request()->routeIs('admin.payments') ? 'on' : '' }}">Transactions</a>
    </details>

<details class="nav-group" {{
  request()->routeIs([
    'admin.sessions',
    'admin.quotes',
    'admin.referrals',
    'admin.messages',
  ])
  ? 'open'
  : ''
}}>
      <summary class="ngh">Business Development <span class="chev">▾</span></summary>
      <a href="{{ route('admin.quotes') }}"
        class="nsub {{ request()->routeIs('admin.quotes') ? 'on' : '' }}">Quote Requests</a>
      <a href="{{ route('admin.sessions') }}"
        class="nsub {{ request()->routeIs('admin.sessions') ? 'on' : '' }}">Advisory
        sessions</a>
      <a href="#" class="nsub">Referrals</a>
      <a href="#" class="nsub">Messages & Email</a>
    </details>

    <details class="nav-group" {{
  request()->routeIs([
    'admin.coupons'
  ])
  ? 'open'
  : ''
    }}>
      <summary class="ngh">Pricing & Incentives <span class="chev">▾</span></summary>
      <a href="{{ route('admin.coupons') }}" class="nsub {{ request()->routeIs('admin.coupons') ? 'on' : '' }}">Discount
        codes</a>
      <a href="#" class="nsub">One Window Investing</a>
    </details>

    <details class="nav-group" {{ 
        request()->routeIs([
    'admin.testimonials',
  ])
  ? 'open'
  : ''}}>
      <summary class="ngh">Website Content <span class="chev">▾</span></summary>
      <a href="#" class="nsub">Testimonials</a>
    </details>

    <details class="nav-group" {{ 
        request()->routeIs([
    'admin.versions',
    'admin.audit',
  ])
  ? 'open'
  : ''}}>
      <summary class="ngh">Administration <span class="chev">▾</span></summary>
      <a href="#" class="nsub">Website versions</a>
      <a href="#" class="nsub">Audit log</a>
    </details>

    <details class="nav-group" {{ 
        request()->routeIs([
    'admin.team',
    'admin.roles',
  ])
  ? 'open'
  : ''}}>
      <summary class="ngh">Access Control <span class="chev">▾</span></summary>
      <a href="#" class="nsub">Team Members</a>
      <a href="#" class="nsub">Roles & Permissions</a>
    </details>

    <a href="{{ route('admin.settings') }}" class="top {{ request()->routeIs('admin.settings') ? 'on' : '' }}"
      style="padding: 8px 10px;">Settings</a>


    <form method="POST" action="{{ route('admin.logout') }}" class="logout"
      style="margin-top:auto;padding-top:16px;border-top:1px solid var(--line)">
      @csrf
      <button type="submit"
        style="width:100%;background:none;border:1px solid var(--line);padding:9px;border-radius:10px;color:var(--mut);font-weight:600;cursor:pointer;font-size:13px;font-family:inherit">Log
        out</button>
    </form>
    <button type="button" class="theme-btn" onclick="toggleTheme()" title="Toggle theme">🌓</button>
  </nav>
  <main>
    @if(session('ok'))
    <div class="flash">{{ session('ok') }}</div>@endif
    @yield('content')
  </main>
  <script>
    function toggleTheme() {
      const r = document.documentElement;
      r.dataset.theme = r.dataset.theme === 'dark' ? 'light' : 'dark';
      localStorage.setItem('theme', r.dataset.theme);
    }
    (function () {
      const t = localStorage.getItem('theme');
      if (t) document.documentElement.dataset.theme = t;
    })();
  </script>
  @stack('scripts')
</body>

</html>