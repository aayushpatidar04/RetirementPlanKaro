@extends('admin.layout')
@section('content')
<div class="top"><div><h2>Payments</h2><p>Revenue collected: ₹{{ number_format($totals['success']) }} · {{ $totals['pending'] }} pending · {{ $totals['failed'] }} failed</p></div>
<form class="row">
<select name="status" onchange="this.form.submit()">
<option value="">All statuses</option>
<option value="success" {{ $status==='success'?'selected':'' }}>Success</option>
<option value="pending" {{ $status==='pending'?'selected':'' }}>Pending</option>
<option value="failed" {{ $status==='failed'?'selected':'' }}>Failed</option>
</select>
</form></div>
<div class="panel">
@if($payments->isEmpty())<div class="empty">No payments.</div>@else
<table>
<tr><th>Txn ID</th><th>User</th><th>Purpose</th><th>Amount</th><th>Coupon</th><th>Status</th><th>PayU ID</th><th>When</th></tr>
@foreach($payments as $p)
<tr>
  <td>{{ $p->txnid }}</td>
  <td>{{ $p->name }}<br><small style="color:var(--mu)">{{ $p->mobile }}</small></td>
  <td>{{ ucfirst($p->purpose) }}</td>
  <td>₹{{ number_format($p->amount,2) }}</td>
  <td>{{ $p->coupon_code ?: '—' }}</td>
  <td><span class="tag {{ $p->status==='success'?'ok':($p->status==='pending'?'pd':'no') }}">{{ $p->status }}</span></td>
  <td>{{ $p->payu_id ?: '—' }}</td>
  <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d M, h:i A') }}</td>
</tr>
@endforeach
</table>
@endif
</div>
<div class="pager">{{ $payments->links() }}</div>
@endsection