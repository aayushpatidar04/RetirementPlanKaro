@extends('admin.layout')
@section('content')
<div class="top"><div><h2>Coupons</h2><p>Create and manage discount codes.</p></div></div>

<div class="panel">
<h3>Add a coupon</h3>
<form method="POST" action="{{ route('admin.coupons.store') }}" style="padding:16px 18px" class="row">
@csrf
<input name="code" placeholder="CODE" maxlength="30" required style="text-transform:uppercase">
<select name="type"><option value="flat">Flat ₹ off</option><option value="percent">% off</option></select>
<input name="value" type="number" step="1" min="1" placeholder="Value" required style="width:110px">
<input name="max_uses" type="number" min="1" placeholder="Max uses (optional)" style="width:170px">
<input name="expires_at" type="date" placeholder="Expires (optional)">
<button class="btn" type="submit">Add coupon</button>
</form>
@if($errors->any())<div style="padding:0 18px 14px;color:#991b1b;font-size:13px">{{ $errors->first() }}</div>@endif
</div>

<div class="panel">
<h3>All coupons</h3>
@if($coupons->isEmpty())<div class="empty">No coupons yet.</div>@else
<table>
<tr><th>Code</th><th>Type</th><th>Value</th><th>Used</th><th>Max</th><th>Expires</th><th>Status</th><th>Action</th></tr>
@foreach($coupons as $c)
<tr>
  <td><b>{{ $c->code }}</b></td>
  <td>{{ $c->type==='flat'?'Flat ₹':'%' }}</td>
  <td>{{ $c->type==='flat'?'₹'.number_format($c->value):$c->value.'%' }}</td>
  <td>{{ $c->used_count }}</td>
  <td>{{ $c->max_uses ?? '∞' }}</td>
  <td>{{ $c->expires_at ? \Illuminate\Support\Carbon::parse($c->expires_at)->format('d M Y') : '—' }}</td>
  <td><span class="tag {{ $c->active?'ok':'no' }}">{{ $c->active?'Active':'Off' }}</span></td>
  <td class="row">
    <form method="POST" action="{{ route('admin.coupons.toggle',$c->id) }}">@csrf<button class="btn sm gh">{{ $c->active?'Disable':'Enable' }}</button></form>
    <form method="POST" action="{{ route('admin.coupons.delete',$c->id) }}" onsubmit="return confirm('Delete this coupon?')">@csrf<button class="btn sm gh">Delete</button></form>
  </td>
</tr>
@endforeach
</table>
@endif
</div>
@endsection