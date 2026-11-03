@extends('admin.layout')

@section('title', 'Client Profile')

@push('styles')
  <style>
    .hh { display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; margin-bottom:14px }
    .hr { display:flex; gap:8px; flex-wrap:wrap; align-items:center }
    .sub { color:var(--mut) }
    .hd { background:var(--card); border:1px solid var(--line); border-radius:12px; padding:16px 18px; margin-bottom:14px; display:flex; gap:16px; align-items:center; flex-wrap:wrap }
    .av { width:52px; height:52px; border-radius:50%; background:var(--pri); color:#fff; display:grid; place-items:center; font-weight:700; font-size:18px }
    .hd h3 { margin:0; font-size:18px }
    .hd p { margin:0; color:var(--mut) }
    .hd .r { margin-left:auto; display:flex; gap:8px; flex-wrap:wrap }
    .btn { font:inherit; font-weight:600; padding:7px 12px; border-radius:8px; border:1px solid var(--line); background:var(--card); color:var(--ink); cursor:pointer; text-decoration:none }
    .btn.p { background:var(--pri); color:#fff; border-color:var(--pri) }
    .btn.wa { background:#25d366; color:#053b1b; border-color:#25d366; text-decoration:none }
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
  @php
    $fullname = trim(($user->name??'').' '.($user->surname??''));
    $initials = collect(explode(' ', $fullname))->filter()->map(fn($w)=>strtoupper(substr($w,0,1)))->take(2)->implode('') ?? 'C';
  @endphp
  <div class="hh">
    <div>
      <div class="sub"><a href="{{ route('admin.users') }}" style="color:var(--pri);text-decoration:none">Clients</a> / Customer</div>
      <h2 style="margin:4px 0 0">{{ $fullname ?? 'Customer' }}</h2>
    </div>
    <div class="hr">
      <a class="btn" href="{{ route('admin.users') }}">← Back</a>
    </div>
  </div>

  <div class="hd">
    <div class="av">{{ $initials }}</div>
    <div>
      <h3>{{ $fullname ?? '—' }}</h3>
      <p>{{ $user->mobile ?? '—' }} · {{ $user->email ?? '—' }} · {{ $user->city ?? '—' }}</p>
    </div>
    <div><span class="pill pri">Customer</span></div>
    <div class="r">
      @if($user->mobile)<a class="btn wa" href="https://wa.me/91{{ preg_replace('/\D/','',$user->mobile) }}" target="_blank">WhatsApp</a><a class="btn" href="tel:{{ $user->mobile }}">Call</a>@endif
      <a class="btn" href="{{ route('admin.users') }}">All clients</a>
    </div>
  </div>

  <div class="tabs">
    <button class="on">Profile</button>
    <button>Planner</button>
    <button>Payments</button>
    <button>Sessions</button>
    <button>Messages & notes</button>
    <button>Activity log</button>
  </div>

  <div class="card">
    <h3>Account</h3>
    <div class="kv">
      <div><dt>Full name</dt><dd>{{ $fullname ?? '—' }}</dd></div>
      <div><dt>Mobile</dt><dd>{{ $user->mobile ?? '—' }}</dd></div>
      <div><dt>Email</dt><dd>{{ $user->email ?? '—' }}</dd></div>
      <div><dt>Email verified</dt><dd>@if(!empty($user->email_verified_at))<span class="pill ok">Yes</span>@else<span class="pill bad">No</span>@endif</dd></div>
      <div><dt>Mobile verified</dt><dd><span class="pill bad">No</span></dd></div>
      <div><dt>Language</dt><dd>{{ $user->language ?? ($user->lang ?? '—') }}</dd></div>
      <div><dt>Country</dt><dd>{{ $user->country ?? '—' }}</dd></div>
      <div><dt>Residential status</dt><dd>{{ $user->residential_status ?? ($user->res ?? '—') }}</dd></div>
      <div><dt>State</dt><dd>{{ $user->state ?? '—' }}</dd></div>
      <div><dt>City</dt><dd>{{ $user->city ?? '—' }}</dd></div>
      <div><dt>Age</dt><dd>{{ $user->age ?? '—' }}</dd></div>
      <div><dt>Account status</dt><dd>{{ $user->status ?? 'Active' }}</dd></div>
      <div><dt>Joined</dt><dd>{{ \Illuminate\Support\Carbon::parse($user->created_at)->format('d M Y, H:i') }}</dd></div>
      <div><dt>Last active</dt><dd>{{ $user->updated_at ? \Illuminate\Support\Carbon::parse($user->updated_at)->format('d M Y, H:i') : '—' }}</dd></div>
      <div><dt>Signup IP</dt><dd>{{ $user->signup_ip ?? ($user->ip ?? '—') }}</dd></div>
    </div>
  </div>

  <div class="card">
    <h3>Referral & rewards</h3>
    <div class="kv">
      <div><dt>Own referral code</dt><dd>{{ $user->referral_code ?? '—' }}</dd></div>
      <div><dt>Referred by</dt><dd>{{ $user->referred_by_code ?? '—' }}</dd></div>
      <div><dt>Referrals made</dt><dd>{{ $leads->count() }}</dd></div>
      <div><dt>Points balance</dt><dd>{{ $user->points ?? 0 }}</dd></div>
    </div>
  </div>

  <div class="card">
    <h3>Payments</h3>
    <div class="sc">
      @if($payments->isEmpty())
        <div class="em">No payments.</div>
      @else
        <table>
          <thead><tr><th>TxnID</th><th>Purpose</th><th>Amount</th><th>Status</th><th>PayU ID</th><th>Paid at</th><th>Created</th></tr></thead>
          <tbody>
            @foreach($payments as $p)
              <tr>
                <td>{{ $p->txnid }}</td>
                <td>{{ $p->purpose }}</td>
                <td>₹{{ number_format($p->amount,2) }}</td>
                <td>@if($p->status==='success')<span class="pill ok">success</span>@elseif($p->status==='failed')<span class="pill bad">failed</span>@else<span class="pill warn">{{ $p->status }}</span>@endif</td>
                <td>{{ $p->payu_id ?? '—' }}</td>
                <td>{{ $p->paid_at ? \Illuminate\Support\Carbon::parse($p->paid_at)->format('d M Y H:i') : '—' }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div class="card">
    <h3>Sessions</h3>
    <div class="sc">
      @if($sessions->isEmpty())
        <div class="em">No sessions.</div>
      @else
        <table>
          <thead><tr><th>Date</th><th>Slot</th><th>Mode</th><th>Mobile</th><th>Status</th><th>Note</th></tr></thead>
          <tbody>
            @foreach($sessions as $s)
              <tr><td>{{ $s->date }}</td><td>{{ $s->slot }}</td><td>{{ $s->mode }}</td><td>{{ $s->mobile }}</td><td>{{ $s->status }}</td><td>{{ $s->note ?? '—' }}</td></tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection
