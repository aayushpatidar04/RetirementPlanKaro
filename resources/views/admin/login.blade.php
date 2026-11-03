<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login · Retirement Plan Karo</title>
<style>
body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f6f7fb;font:14px/1.5 -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;color:#1b2437}
.box{width:100%;max-width:360px;background:#fff;border:1px solid #e7e9f1;border-radius:16px;padding:32px;box-shadow:0 1px 3px rgba(16,24,40,.05)}
.box h1{font-size:17px;margin:0 0 2px}
.box p{color:#6b7280;font-size:13px;margin:0 0 22px}
label{display:block;font-size:12.5px;font-weight:600;color:#374151;margin:14px 0 6px}
input{width:100%;padding:10px 12px;border:1px solid #e7e9f1;border-radius:10px;font:inherit}
button{width:100%;margin-top:20px;background:#4f46e5;color:#fff;border:0;padding:11px;border-radius:10px;font-weight:700;font-size:14px;cursor:pointer}
button:hover{background:#4338ca}
.err{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px 13px;border-radius:9px;font-size:12.5px;margin-bottom:6px}
</style>
</head>
<body>
<div class="box">
  <h1>Admin login</h1>
  <p>Retirement Plan Karo</p>
  @if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif
  <form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <button type="submit">Log in</button>
  </form>
</div>
</body>
</html>