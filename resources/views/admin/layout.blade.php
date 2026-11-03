<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') · Retirement Plan Karo</title>
<style>
:root{--bg:#f6f7fb;--sf:#fff;--ln:#e7e9f1;--ink:#1b2437;--mu:#6b7280;--br:#4f46e5;--br2:#4338ca;--rad:14px}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink);font:14px/1.5 -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif}
a{color:inherit;text-decoration:none}
.shell{display:flex;min-height:100vh}
.side{width:232px;flex:none;background:var(--sf);border-right:1px solid var(--ln);padding:22px 14px;position:sticky;top:0;height:100vh}
.side h1{font-size:15px;font-weight:700;margin:0 0 2px;padding:0 10px}
.side .sub{font-size:11px;color:var(--mu);padding:0 10px;margin-bottom:22px;display:block}
.side nav a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:var(--mu);font-weight:600;font-size:13.5px;margin-bottom:3px}
.side nav a:hover{background:var(--bg);color:var(--ink)}
.side nav a.on{background:#eef0ff;color:var(--br)}
.side form{margin-top:16px;padding-top:16px;border-top:1px solid var(--ln)}
.side button{width:100%;background:none;border:1px solid var(--ln);padding:9px;border-radius:10px;color:var(--mu);font-weight:600;cursor:pointer;font-size:13px}
.side button:hover{color:#dc2626;border-color:#fca5a5}
.main{flex:1;min-width:0;padding:28px 32px}
.top{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:10px}
.top h2{margin:0;font-size:20px}
.top p{margin:3px 0 0;color:var(--mu);font-size:13px}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px;margin-bottom:24px}
.card{background:var(--sf);border:1px solid var(--ln);border-radius:var(--rad);padding:18px;box-shadow:0 1px 2px rgba(16,24,40,.03)}
.card b{display:block;font-size:24px;margin-top:4px}
.card small{color:var(--mu);font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.03em}
.panel{background:var(--sf);border:1px solid var(--ln);border-radius:var(--rad);overflow:hidden;margin-bottom:22px}
.panel h3{margin:0;padding:16px 18px;border-bottom:1px solid var(--ln);font-size:14.5px}
table{width:100%;border-collapse:collapse;font-size:13px}
th,td{text-align:left;padding:11px 18px;border-bottom:1px solid var(--ln);white-space:nowrap}
th{color:var(--mu);font-weight:600;font-size:11.5px;text-transform:uppercase;letter-spacing:.03em;background:#fafbfe}
tr:last-child td{border-bottom:0}
.tag{display:inline-block;padding:3px 9px;border-radius:99px;font-size:11.5px;font-weight:700}
.tag.ok{background:#dcfce7;color:#166534}
.tag.pd{background:#fef3c7;color:#92400e}
.tag.no{background:#fee2e2;color:#991b1b}
.tag.mu{background:#eef0f4;color:#525a6b}
.btn{display:inline-flex;align-items:center;gap:6px;background:var(--br);color:#fff;border:0;padding:8px 14px;border-radius:9px;font-weight:600;font-size:13px;cursor:pointer}
.btn:hover{background:var(--br2)}
.btn.gh{background:none;color:var(--mu);border:1px solid var(--ln)}
.btn.gh:hover{color:var(--ink);border-color:#c7cad6}
.btn.sm{padding:5px 10px;font-size:12px;border-radius:7px}
input,select{font:inherit;padding:9px 11px;border:1px solid var(--ln);border-radius:9px;background:#fff;color:var(--ink)}
.row{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
.flash{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;padding:11px 16px;border-radius:10px;margin-bottom:18px;font-weight:600;font-size:13px}
.pager a,.pager span{display:inline-block;padding:7px 12px;border:1px solid var(--ln);border-radius:8px;margin-right:6px;font-size:12.5px;color:var(--mu)}
.empty{padding:40px;text-align:center;color:var(--mu)}
@media(max-width:860px){.side{display:none}.main{padding:18px}}
</style>
</head>
<body>
<div class="shell">
  <aside class="side">
    <h1>Retirement Plan Karo</h1>
    <span class="sub">Admin</span>
    <nav>
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard')?'on':'' }}">Dashboard</a>
      <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users')?'on':'' }}">Signups</a>
      <a href="{{ route('admin.leads') }}" class="{{ request()->routeIs('admin.leads')?'on':'' }}">Leads</a>
      <a href="{{ route('admin.payments') }}" class="{{ request()->routeIs('admin.payments')?'on':'' }}">Payments</a>
      <a href="{{ route('admin.sessions') }}" class="{{ request()->routeIs('admin.sessions')?'on':'' }}">Guidance sessions</a>
      <a href="{{ route('admin.coupons') }}" class="{{ request()->routeIs('admin.coupons')?'on':'' }}">Coupons</a>
      <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings')?'on':'' }}">Settings</a>
    </nav>
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit">Log out</button>
    </form>
  </aside>
  <main class="main">
    @if(session('ok'))<div class="flash">{{ session('ok') }}</div>@endif
    @yield('content')
  </main>
</div>
</body>
</html>