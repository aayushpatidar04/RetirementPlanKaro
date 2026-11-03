@extends('admin.layout')

@section('title', 'Client Records')

@push('styles')
  <style>
    .hh { display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; margin-bottom:14px }
    .hr { display:flex; gap:8px; flex-wrap:wrap; align-items:center }
    .sub { color:var(--mut) }
    .pick { display:flex; gap:10px; margin-bottom:16px; flex-wrap:wrap }
    .pick input, .pick select { font:inherit; padding:10px 12px; border:1px solid var(--line); border-radius:10px; background:var(--card); color:var(--ink) }
    .pick select { flex:1; min-width:260px; font-weight:600 }
    .pick input { width:230px }
    .kpis { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:10px; margin-bottom:16px }
    .k { background:var(--card); border:1px solid var(--line); border-radius:12px; padding:12px 14px }
    .k span { color:var(--mut); font-size:12.5px }
    .k b { display:block; font-size:21px }
    .hd { background:var(--card); border:1px solid var(--line); border-radius:12px; padding:16px 18px; margin-bottom:14px; display:flex; gap:16px; align-items:center; flex-wrap:wrap }
    .av { width:52px; height:52px; border-radius:50%; background:var(--pri); color:#fff; display:grid; place-items:center; font-weight:700; font-size:18px }
    .hd h3 { margin:0; font-size:18px }
    .hd p { margin:0; color:var(--mut) }
    .hd .r { margin-left:auto; display:flex; gap:8px; flex-wrap:wrap }
    .btn { font:inherit; font-weight:600; padding:7px 12px; border-radius:8px; border:1px solid var(--line); background:var(--card); color:var(--ink); cursor:pointer; text-decoration:none }
    .btn.p { background:var(--pri); color:#fff; border-color:var(--pri) }
    .tabs { display:flex; gap:6px; margin-bottom:14px; flex-wrap:wrap; position:sticky; top:0; background:var(--bg); padding:6px 0; z-index:5 }
    .tabs button { font:inherit; font-weight:600; border:1px solid var(--line); background:var(--card); color:var(--mut); padding:6px 13px; border-radius:99px; cursor:pointer }
    .tabs button.on { background:var(--pri); color:#fff; border-color:var(--pri) }
    .card { background:var(--card); border:1px solid var(--line); border-radius:12px; margin-bottom:14px; overflow:hidden }
    .card>h3 { margin:0; padding:12px 16px; font-size:14.5px; border-bottom:1px solid var(--line) }
    .kv { display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); }
    .kv div { padding:10px 16px; border-bottom:1px solid var(--line) }
    .kv dt { color:var(--mut); font-size:12.5px }
    .kv dd { margin:0; font-weight:600 }
    .sc { overflow-x:auto }
    table { border-collapse:collapse; width:100%; min-width:560px }
    th,td { text-align:left; padding:9px 14px; border-bottom:1px solid var(--line); white-space:nowrap }
    th { color:var(--mut); font-size:12.5px; font-weight:600; background:color-mix(in srgb,var(--bg) 60%,var(--card)) }
    tr:last-child td { border:0 }
    .pill { display:inline-block; padding:2px 9px; border-radius:99px; font-size:12px; font-weight:700; background:var(--bg); color:var(--mut) }
    .pill.ok { background:var(--ok-s); color:var(--ok) }
    .pill.bad { background:var(--bad-s); color:var(--bad) }
    .pill.warn { background:var(--warn-s); color:var(--warn) }
    .pill.pri { background:var(--pri-s); color:var(--pri) }
    .em { padding:16px; color:var(--mut) }
  </style>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Client Records</h2>
      <div class="sub" style="margin:2px 0 0">{{ $users->total() }} total accounts</div>
    </div>
    <div class="hr">
      <form class="pick" style="margin:0" method="GET" action="{{ route('admin.users') }}">
        <input type="text" name="q" value="{{ $q }}" placeholder="Search name, mobile, email">
        <button class="btn" type="submit">Search</button>
        <a class="btn" href="{{ route('admin.users') }}">Reset</a>
      </form>
    </div>
  </div>

  <div class="kpis">
    <div class="k"><span>Total signups</span><b>{{ $users->total() }}</b></div>
    <div class="k"><span>Email verified</span><b>{{ $users->whereNotNull('email_verified_at')->count() }}</b></div>
  </div>

  <div class="card">
    <div class="sc">
      @if($users->isEmpty())
        <div class="em">No users found.</div>
      @else
        <table>
          <thead><tr><th>Name</th><th>Mobile</th><th>Email</th><th>City</th><th>Referral</th><th>Joined</th><th></th></tr></thead>
          <tbody>
            @foreach($users as $u)
              <tr>
                <td>{{ trim(($u->name??'').' '.($u->surname??'')) ?? '—' }}</td>
                <td>{{ $u->mobile ?? '—' }}</td>
                <td>{{ $u->email ?? '—' }}</td>
                <td>{{ $u->city ?? '—' }}</td>
                <td>{{ $u->referral_code ?? '—' }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($u->created_at)->format('d M Y') }}</td>
                <td><a class="btn" href="{{ route('admin.users.show', $u->id) }}">View</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;color:var(--mut);font-size:13px">
    <div>Showing {{ $users->firstItem()??0 }}-{{ $users->lastItem()??0 }} of {{ $users->total() }}</div>
    <div>{{ $users->links() }}</div>
  </div>
@endsection
