@extends('admin.layout')
@section('content')
<div class="top"><div><h2>Settings</h2><p>Prices and point rewards. Changes apply immediately, no deploy needed.</p></div></div>
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf
<div class="panel">
<h3>Prices</h3>
<div class="row" style="padding:16px 18px">
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Premium report price (₹)</label><input type="number" name="report_price" value="{{ $values['report_price'] }}" required></div>
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Guidance session price (₹)</label><input type="number" name="session_price" value="{{ $values['session_price'] }}" required></div>
</div>
</div>

<div class="panel">
<h3>Points and rewards</h3>
<div class="row" style="padding:16px 18px">
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Min. points to redeem</label><input type="number" name="ref_pts" value="{{ $values['ref_pts'] }}" required></div>
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Wallet unlock cost (pts)</label><input type="number" name="wallet_unlock_cost" value="{{ $values['wallet_unlock_cost'] }}" required></div>
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Wallet unlock hours</label><input type="number" name="wallet_unlock_hours" value="{{ $values['wallet_unlock_hours'] }}" required></div>
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Welcome bonus (pts)</label><input type="number" name="welcome_bonus" value="{{ $values['welcome_bonus'] }}" required></div>
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Referral bonus (pts)</label><input type="number" name="referral_bonus" value="{{ $values['referral_bonus'] }}" required></div>
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Daily streak points</label><input type="number" name="streak_points" value="{{ $values['streak_points'] }}" required></div>
<div><label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Streak length (days)</label><input type="number" name="streak_days" value="{{ $values['streak_days'] }}" required></div>
</div>
</div>

<div class="panel">
<h3>Wallet recharge packs</h3>
<div class="row" style="padding:16px 18px">
@foreach($packs as $i=>$pk)
<div style="border:1px solid var(--ln);border-radius:10px;padding:12px">
<label style="display:block;font-size:12px;color:var(--mu);margin-bottom:5px">Pack {{ $i+1 }}: points</label>
<input type="number" name="pack{{ $i+1 }}_pts" value="{{ $pk[0] }}" style="width:120px" required>
<label style="display:block;font-size:12px;color:var(--mu);margin:8px 0 5px">Price (₹)</label>
<input type="number" name="pack{{ $i+1 }}_rs" value="{{ $pk[1] }}" style="width:120px" required>
</div>
@endforeach
</div>
</div>

<button class="btn" type="submit">Save settings</button>
</form>
<p style="color:var(--mu);font-size:12.5px;margin-top:14px">Report and session prices update live on the site immediately. Wallet pack and point-reward numbers shown on the Explore page's own labels are fixed in the page itself for display only — the server always charges the correct new amount even if a label lags; tell me if you want those labels wired live too.</p>
@endsection