@extends('admin.layout')
@section('content')
<div class="top"><div><h2>Dashboard</h2><p>Live overview of signups, leads and payments.</p></div></div>
<div class="grid">
  <div class="card"><small>Total signups</small><b>{{ $stats['users'] }}</b></div>
  <div class="card"><small>Email verified</small><b>{{ $stats['verified'] }}</b></div>
  <div class="card"><small>Leads captured</small><b>{{ $stats['leads'] }}</b></div>
  <div class="card"><small>Successful payments</small><b>{{ $stats['payments_ok'] }}</b></div>
  <div class="card"><small>Revenue collected</small><b>₹{{ number_format($stats['revenue']) }}</b></div>
  <div class="card"><small>Sessions to conduct</small><b>{{ $stats['sessions_due'] }}</b></div>
</div>
<div class="panel">
  <h3>Recent payments</h3>
  @if($recentPayments->isEmpty())<div class="empty">No payments yet.</div>@else
  <table>
    <tr><th>User</th><th>Purpose</th><th>Amount</th><th>Status</th><th>When</th></tr>
    @foreach($recentPayments as $p)
    <tr>
      <td>{{ $p->name }}<br><small style="color:var(--mu)">{{ $p->mobile }}</small></td>
      <td>{{ ucfirst($p->purpose) }}</td>
      <td>₹{{ number_format($p->amount,2) }}</td>
      <td><span class="tag {{ $p->status==='success'?'ok':($p->status==='pending'?'pd':'no') }}">{{ $p->status }}</span></td>
      <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d M, h:i A') }}</td>
    </tr>
    @endforeach
  </table>
  @endif
</div>
<div class="panel">
  <h3>Recent leads</h3>
  @if($recentLeads->isEmpty())<div class="empty">No leads yet.</div>@else
  <table>
    <tr><th>Event</th><th>Mobile</th><th>Email</th><th>When</th></tr>
    @foreach($recentLeads as $l)
    <tr><td><span class="tag mu">{{ $l->event }}</span></td><td>{{ $l->mobile ?: '—' }}</td><td>{{ $l->email ?: '—' }}</td><td>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M, h:i A') }}</td></tr>
    @endforeach
  </table>
  @endif
</div>
@endsection