@extends('admin.layout')
@section('content')
<div class="top"><div><h2>Dashboard</h2><p>Live overview of signups, leads and payments.</p></div></div>
<div class="kpis">
  <div class="k"><span>Total signups</span><b>{{ $stats['users'] }}</b></div>
  <div class="k"><span>Email verified</span><b>{{ $stats['verified'] }}</b></div>
  <div class="k"><span>Leads captured</span><b>{{ $stats['leads'] }}</b></div>
  <div class="k"><span>Successful payments</span><b>{{ $stats['payments_ok'] }}</b></div>
  <div class="k"><span>Revenue collected</span><b>₹{{ number_format($stats['revenue']) }}</b></div>
  <div class="k"><span>Sessions to conduct</span><b>{{ $stats['sessions_due'] }}</b></div>
</div>
<div class="card">
  <h3>Recent payments</h3>
  @if($recentPayments->isEmpty())<div class="empty">No payments yet.</div>@else
  <div class="sc">
  <table>
    <thead><tr><th>User</th><th>Purpose</th><th>Amount</th><th>Status</th><th>When</th></tr></thead>
    <tbody>
    @foreach($recentPayments as $p)
    <tr>
      <td>{{ $p->name }}<br><small style="color:var(--mut)">{{ $p->mobile }}</small></td>
      <td>{{ ucfirst($p->purpose) }}</td>
      <td>₹{{ number_format($p->amount,2) }}</td>
      <td><span class="pill {{ $p->status==='success'?'ok':($p->status==='pending'?'warn':'bad') }}">{{ $p->status }}</span></td>
      <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d M, h:i A') }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
  </div>
  @endif
</div>
<div class="card">
  <h3>Recent leads</h3>
  @if($recentLeads->isEmpty())<div class="empty">No leads yet.</div>@else
  <div class="sc">
  <table>
    <thead><tr><th>Event</th><th>Mobile</th><th>Email</th><th>When</th></tr></thead>
    <tbody>
    @foreach($recentLeads as $l)
    <tr><td><span class="pill">{{ $l->event }}</span></td><td>{{ $l->mobile ?: '—' }}</td><td>{{ $l->email ?: '—' }}</td><td>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M, h:i A') }}</td></tr>
    @endforeach
    </tbody>
  </table>
  </div>
  @endif
</div>
@endsection