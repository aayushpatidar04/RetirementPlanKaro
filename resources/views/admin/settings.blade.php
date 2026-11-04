@extends('admin.layout')
@section('title', 'Settings')

@push('styles')
  <style>
    .hh { display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; margin-bottom:14px }
    .sub { color:var(--mut) }
    .card { background:var(--card); border:1px solid var(--line); border-radius:12px; overflow:hidden; margin-bottom:14px }
    .card-h { padding:12px 16px; border-bottom:1px solid var(--line); font-weight:600 }
    .grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:12px; padding:14px 16px }
    .field label { display:block; font-size:12.5px; color:var(--mut); margin-bottom:5px }
    .field input { width:100%; border:1px solid var(--line); background:var(--card); color:var(--ink); border-radius:8px; padding:7px 10px; font:inherit }
    .btn { display:inline-flex; align-items:center; gap:6px; font-family:inherit; font-weight:600; padding:7px 12px; border-radius:8px; border:1px solid var(--line); background:var(--card); color:var(--ink); cursor:pointer; font-size:13px; text-decoration:none }
    .btn.p { background:var(--pri); color:#fff; border-color:var(--pri) }
    .note { color:var(--mut); font-size:12.5px; margin-top:12px }
  </style>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Settings</h2>
      <div class="sub" style="margin:2px 0 0">Prices and point rewards. Changes apply immediately.</div>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    <div class="card">
      <div class="card-h">Prices</div>
      <div class="grid">
        <div class="field"><label>Premium report price (₹)</label><input type="number" name="report_price" value="{{ $values['report_price'] }}" required></div>
        <div class="field"><label>Guidance session price (₹)</label><input type="number" name="session_price" value="{{ $values['session_price'] }}" required></div>
      </div>
    </div>

    <div class="card">
      <div class="card-h">Points and rewards</div>
      <div class="grid">
        <div class="field"><label>Min. points to redeem</label><input type="number" name="ref_pts" value="{{ $values['ref_pts'] }}" required></div>
        <div class="field"><label>Wallet unlock cost (pts)</label><input type="number" name="wallet_unlock_cost" value="{{ $values['wallet_unlock_cost'] }}" required></div>
        <div class="field"><label>Wallet unlock hours</label><input type="number" name="wallet_unlock_hours" value="{{ $values['wallet_unlock_hours'] }}" required></div>
        <div class="field"><label>Welcome bonus (pts)</label><input type="number" name="welcome_bonus" value="{{ $values['welcome_bonus'] }}" required></div>
        <div class="field"><label>Referral bonus (pts)</label><input type="number" name="referral_bonus" value="{{ $values['referral_bonus'] }}" required></div>
        <div class="field"><label>Daily streak points</label><input type="number" name="streak_points" value="{{ $values['streak_points'] }}" required></div>
        <div class="field"><label>Streak length (days)</label><input type="number" name="streak_days" value="{{ $values['streak_days'] }}" required></div>
      </div>
    </div>

    <div class="card">
      <div class="card-h">Wallet recharge packs</div>
      <div class="grid">
        @foreach($packs as $i=>$pk)
          <div style="border:1px solid var(--line);border-radius:10px;padding:12px">
            <div class="field" style="margin-bottom:10px"><label>Pack {{ $i+1 }}: points</label><input type="number" name="pack{{ $i+1 }}_pts" value="{{ $pk[0] }}" required></div>
            <div class="field"><label>Price (₹)</label><input type="number" name="pack{{ $i+1 }}_rs" value="{{ $pk[1] }}" required></div>
          </div>
        @endforeach
      </div>
    </div>

    <button class="btn p" type="submit">Save settings</button>
  </form>

  <p class="note">Report and session prices update live on the site immediately.</p>
@endsection
