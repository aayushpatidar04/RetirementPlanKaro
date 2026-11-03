<!doctype html>
<html lang="en" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Admin Login · Retirement Plan Karo</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#f5f6fa;--card:#fff;--ink:#14172b;--mut:#697089;--line:#e6e8f0;--pri:#4f46e5;--pri-s:#ecebff;--ok:#0f7a3d;--ok-s:#dcf6e6;--bad:#a4161a;--bad-s:#fde2e2;--warn:#8a5a00;--warn-s:#fdf0cf}
:root[data-theme="dark"]{--bg:#0f1220;--card:#181c30;--ink:#eceefb;--mut:#9aa1bf;--line:#2a2f4a;--pri:#8b85ff;--pri-s:#26275a;--ok:#6fe0a0;--ok-s:#133a28;--bad:#ff9a9d;--bad-s:#4a1a1d;--warn:#f3c460;--warn-s:#3d3012}
*{box-sizing:border-box}
body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg);color:var(--ink);font:14px/1.5 "Plus Jakarta Sans",system-ui,sans-serif}
.box{width:100%;max-width:380px;background:var(--card);border:1px solid var(--line);border-radius:16px;padding:36px 32px;box-shadow:0 4px 24px rgba(0,0,0,.06)}
.logo{display:flex;align-items:center;gap:10px;margin-bottom:6px}
.logo-icon{width:40px;height:40px;background:var(--pri);border-radius:10px;display:grid;place-items:center;color:#fff;font-weight:700;font-size:16px}
.box h1{font-size:18px;margin:0}
.box p{color:var(--mut);font-size:13px;margin:4px 0 24px}
label{display:block;font-size:12.5px;font-weight:600;color:var(--mut);margin:16px 0 6px}
input{width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;font:inherit;background:var(--bg);color:var(--ink);transition:border-color .15s}
input:focus{outline:none;border-color:var(--pri);box-shadow:0 0 0 3px var(--pri-s)}
.btn{width:100%;margin-top:22px;background:var(--pri);color:#fff;border:0;padding:12px;border-radius:10px;font-weight:700;font-size:14px;cursor:pointer;font-family:inherit;transition:background .15s}
.btn:hover{background:color-mix(in srgb,var(--pri) 85%,#000)}
.err{background:var(--bad-s);border:1px solid color-mix(in srgb,var(--bad) 30%,transparent);color:var(--bad);padding:10px 13px;border-radius:9px;font-size:12.5px;margin-bottom:8px;font-weight:500}
.footer{text-align:center;margin-top:20px;font-size:12px;color:var(--mut)}
</style>
</head>
<body>
<div class="box">
  <div class="logo">
    <div class="logo-icon">RPK</div>
    <div>
      <h1>Admin Portal</h1>
    </div>
  </div>
  <p>Sign in to Retirement Plan Karo admin</p>
  @if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif
  <form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <label for="email">Email address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@retirementplankaro.com">
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required placeholder="••••••••">
    <button class="btn" type="submit">Log in</button>
  </form>
  <div class="footer">Retirement Plan Karo &copy; {{ date('Y') }}</div>
</div>
</body>
</html>