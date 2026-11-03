@extends('admin.layout')
@section('content')
<div class="top"><div><h2>Signups</h2><p>{{ $users->total() }} total accounts.</p></div>
<form class="row"><input type="text" name="q" value="{{ $q }}" placeholder="Search name, email, mobile, referral code"><button class="btn gh" type="submit">Search</button></form></div>
<div class="panel">
@if($users->isEmpty())<div class="empty">No users found.</div>@else
<table>
<tr><th>Name</th><th>Mobile</th><th>Email</th><th>City</th><th>Verified</th><th>Referral</th><th>Referred by</th><th>Joined</th></tr>
@foreach($users as $u)
<tr>
  <td>{{ $u->name }} {{ $u->surname }}</td>
  <td>{{ $u->mobile }}</td>
  <td>{{ $u->email }}</td>
  <td>{{ $u->city }}</td>
  <td>@if($u->email_verified_at)<span class="tag ok">Yes</span>@else<span class="tag no">No</span>@endif</td>
  <td>{{ $u->referral_code }}</td>
  <td>{{ $u->referred_by_code ?: '—' }}</td>
  <td>{{ \Illuminate\Support\Carbon::parse($u->created_at)->format('d M Y') }}</td>
</tr>
@endforeach
</table>
@endif
</div>
<div class="pager">{{ $users->links() }}</div>
@endsection