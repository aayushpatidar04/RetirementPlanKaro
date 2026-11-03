@extends('admin.layout')
@section('content')
<div class="top"><div><h2>Guidance sessions</h2><p>{{ $sessions->total() }} bookings.</p></div></div>
<div class="panel">
@if($sessions->isEmpty())<div class="empty">No bookings.</div>@else
<table>
<tr><th>User</th><th>Date</th><th>Slot</th><th>Mode</th><th>Mobile</th><th>Note</th><th>Status</th><th>Action</th></tr>
@foreach($sessions as $s)
<tr>
  <td>{{ $s->name }}<br><small style="color:var(--mu)">{{ $s->email }}</small></td>
  <td>{{ \Illuminate\Support\Carbon::parse($s->date)->format('d M Y') }}</td>
  <td>{{ $s->slot }}</td>
  <td>{{ $s->mode }}</td>
  <td>{{ $s->mobile }}</td>
  <td style="white-space:normal;max-width:220px">{{ $s->note ?: '—' }}</td>
  <td><span class="tag {{ $s->status==='confirmed'?'pd':($s->status==='done'?'ok':($s->status==='cancelled'?'no':'mu')) }}">{{ $s->status }}</span></td>
  <td class="row">
    @if($s->status==='confirmed')
    <form method="POST" action="{{ route('admin.sessions.status',$s->id) }}"><input type="hidden" name="status" value="done">@csrf<button class="btn sm">Mark done</button></form>
    <form method="POST" action="{{ route('admin.sessions.status',$s->id) }}"><input type="hidden" name="status" value="cancelled">@csrf<button class="btn sm gh">Cancel</button></form>
    @endif
  </td>
</tr>
@endforeach
</table>
@endif
</div>
<div class="pager">{{ $sessions->links() }}</div>
@endsection