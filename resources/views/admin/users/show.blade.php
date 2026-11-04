@extends('admin.layout')

@section('title', 'Client Profile')

@push('styles')
  <style>
    .hh { display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; margin-bottom:14px }
    .hr { display:flex; gap:8px; flex-wrap:wrap; align-items:center }
    .sub { color:var(--mut); font-size:13px }
    .crumb { color:var(--mut); margin-bottom:8px; font-size:13px }
    .crumb a { color:var(--pri); text-decoration:none; font-weight:600 }
    .crumb b { color:var(--ink) }
    .hd { background:var(--card); border:1px solid var(--line); border-radius:12px; padding:16px 18px; margin-bottom:14px; display:flex; gap:16px; align-items:center; flex-wrap:wrap }
    .av { width:52px; height:52px; border-radius:50%; background:var(--pri); color:#fff; display:grid; place-items:center; font-weight:700; font-size:18px }
    .hd h3 { margin:0; font-size:18px }
    .hd p { margin:0; color:var(--mut) }
    .hd .r { margin-left:auto; display:flex; gap:8px; flex-wrap:wrap; align-items:center }
    .btn { font:inherit; font-weight:600; padding:7px 12px; border-radius:8px; border:1px solid var(--line); background:var(--card); color:var(--ink); cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px }
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
    .kv dd { margin:0; font-weight:600; word-break:break-word }
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
    .tl { border-left:2px solid var(--line); margin:14px 16px 8px 22px; padding-left:18px }
    .tl div { position:relative; padding-bottom:12px }
    .tl div:before { content:""; position:absolute; left:-25px; top:6px; width:10px; height:10px; border-radius:50%; background:var(--pri) }
    .tl small { color:var(--mut); display:block }
    .dd { position:relative; display:inline-block }
    .dd > summary { list-style:none; cursor:pointer; user-select:none }
    .dd > summary::-webkit-details-marker { display:none }
    .dd .ddm { position:absolute; right:0; top:calc(100%+4px); min-width:220px; background:var(--card); border:1px solid var(--line); border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,.18); padding:4px; z-index:70; display:flex; flex-direction:column }
    .dd .mi { font:inherit; font-weight:600; text-align:left; background:none; border:0; border-radius:7px; padding:9px 12px; color:var(--ink); cursor:pointer; white-space:nowrap; text-decoration:none }
    .dd .mi:hover { background:var(--pri-s) }
    .dd .mi.d { color:var(--bad) }
  </style>
@endpush

@section('content')
  @php
    $fullname = trim(($user->name??'').' '.($user->surname??''));
    $initials = collect(preg_split('/\s+/', $fullname))->filter()->map(fn($w)=>strtoupper(mb_substr($w,0,1)))->take(2)->implode('') ?? 'C';
    $mobileClean = preg_replace('/\D/','',$user->mobile ?? '');
  @endphp
  <div class="hh">
    <div>
      <div class="crumb"><a href="{{ route('admin.clients') }}">Clients</a> › <a href="{{ route('admin.users') }}">Client Records</a> › <b>Customer</b></div>
      <h2 style="margin:6px 0 0">{{ $fullname ?? 'Customer' }}</h2>
    </div>
    <div class="hr"><a class="btn" href="{{ route('admin.users') }}">Back to list</a></div>
  </div>

  <div class="hd">
    <div class="av">{{ $initials }}</div>
    <div>
      <h3>{{ $fullname ?? '—' }}</h3>
      <p>{{ $user->mobile ?? '—' }} · {{ $user->email ?? '—' }} · {{ $user->city ?? '—' }}</p>
    </div>
    <div><span class="pill pri">{{ $user->stage ?? 'Customer' }}</span></div>
    <div class="r">
      @if($user->mobile)<a class="btn wa" href="https://wa.me/91{{ $mobileClean }}" target="_blank">WhatsApp</a><a class="btn" href="tel:{{ $user->mobile }}">Call</a>@endif
      @if($user->email)<a class="btn" href="mailto:{{ $user->email }}">Email</a>@endif
      <details class="dd">
        <summary class="btn">More ▾</summary>
        <div class="ddm">
          <button class="mi">Edit client profile</button>
          <button class="mi">Adjust points / wallet</button>
          <button class="mi">Add note</button>
          <button class="mi">Edit tags</button>
          <button class="mi">Export client report</button>
          <button class="mi d">{{ !empty($user->status) && $user->status==='Blocked' ? 'Reinstate account' : 'Suspend account' }}</button>
        </div>
      </details>
    </div>
  </div>

  <div class="tabs" id="custTabs">
    <button class="on" data-tab="profile">Profile</button>
    <button data-tab="planner">Planner</button>
    <button data-tab="tools">Tools</button>
    <button data-tab="payments">Payments</button>
    <button data-tab="sessions">Sessions</button>
    <button data-tab="referrals">Referrals</button>
    <button data-tab="messages">Messages & notes</button>
    <button data-tab="activity">Activity log</button>
  </div>

  <div id="tab-profile">
    <div class="card">
      <h3>Account</h3>
      <div class="kv">
        <div><dt>Full name</dt><dd>{{ $fullname ?? '—' }}</dd></div>
        <div><dt>Mobile</dt><dd>{{ $user->mobile ?? '—' }}</dd></div>
        <div><dt>Email</dt><dd>{{ $user->email ?? '—' }}</dd></div>
        <div><dt>Email verified</dt><dd>@if(!empty($user->email_verified_at))<span class="pill ok">Yes</span>@else<span class="pill bad">No</span>@endif</dd></div>
        <div><dt>Mobile verified</dt><dd><span class="pill bad">No</span></dd></div>
        <div><dt>Language</dt><dd>{{ $user->language ?? ($user->lang ?? '—') }}</dd></div>
        <div><dt>Preferred contact</dt><dd>{{ $user->preferred_contact ?? ($user->contact ?? '—') }}</dd></div>
        <div><dt>Country</dt><dd>{{ $user->country ?? '—' }}</dd></div>
        <div><dt>Residential status</dt><dd>{{ $user->residential_status ?? ($user->res ?? '—') }}</dd></div>
        <div><dt>State</dt><dd>{{ $user->state ?? '—' }}</dd></div>
        <div><dt>City</dt><dd>{{ $user->city ?? '—' }}</dd></div>
        <div><dt>Age</dt><dd>{{ $user->age ?? '—' }}</dd></div>
        <div><dt>PAN (masked)</dt><dd>{{ $user->pan_masked ?? ($user->pan ?? '—') }}</dd></div>
        <div><dt>Account status</dt><dd>{{ $user->status ?? 'Active' }}</dd></div>
        <div><dt>Joined</dt><dd>{{ \Illuminate\Support\Carbon::parse($user->created_at)->format('d M Y, H:i') }}</dd></div>
        <div><dt>Last active</dt><dd>{{ $user->updated_at ? \Illuminate\Support\Carbon::parse($user->updated_at)->format('d M Y, H:i') : '—' }}</dd></div>
        <div><dt>Source</dt><dd>{{ $user->source ?? ($user->src ?? '—') }}</dd></div>
        <div><dt>Signup IP</dt><dd>{{ $user->signup_ip ?? ($user->ip ?? '—') }}</dd></div>
        <div><dt>Device</dt><dd>{{ $user->device ?? ($user->dev ?? '—') }}</dd></div>
      </div>
    </div>

    <div class="card">
      <h3>Referral & rewards</h3>
      <div class="kv">
        <div><dt>Own referral code</dt><dd>{{ $user->referral_code ?? '—' }}</dd></div>
        <div><dt>Referred by</dt><dd>{{ $user->referred_by_code ?? '—' }}</dd></div>
        <div><dt>Referrals made</dt><dd>{{ $leads->count() }}</dd></div>
        <div><dt>Points balance</dt><dd>{{ $user->points ?? 0 }}</dd></div>
        <div><dt>Wallet balance</dt><dd>₹{{ number_format($user->wallet_balance ?? 0, 0) }}</dd></div>
        <div><dt>Streak</dt><dd>{{ $user->streak ?? '—' }}</dd></div>
      </div>
    </div>

    <div class="card">
      <h3>Admin</h3>
      <div class="kv">
        <div><dt>Stage</dt><dd><span class="pill pri">{{ $user->stage ?? '—' }}</span></dd></div>
        <div><dt>Tags</dt><dd>
            @if(isset($user->tags))
                {{ is_array($user->tags) ? implode(', ', $user->tags) : $user->tags }}
            @else
                —
            @endif
        </dd></div>
        <div><dt>Assigned to</dt><dd>{{ $user->assigned_to ?? ($user->owner ?? 'Unassigned') }}</dd></div>
      </div>
    </div>
  </div>

  <div id="tab-payments" style="display:none">
    <div class="card">
      <h3>Payments</h3>
      <div class="sc">
        @if($payments->isEmpty())
          <div class="em">No payments.</div>
        @else
          <table>
            <thead><tr><th>TxnID</th><th>Purpose</th><th>Amount</th><th>Status</th><th>PayU ID</th><th>Mode</th><th>Paid at</th><th>Created</th></tr></thead>
            <tbody>
              @foreach($payments as $p)
                <tr>
                  <td>{{ $p->txnid }}</td>
                  <td>{{ $p->purpose }}</td>
                  <td>₹{{ number_format($p->amount,2) }}</td>
                  <td>@if($p->status==='success')<span class="pill ok">success</span>@elseif($p->status==='failed')<span class="pill bad">failed</span>@else<span class="pill warn">{{ $p->status }}</span>@endif</td>
                  <td>{{ $p->payu_id ?? '—' }}</td>
                  <td>{{ $p->mode ?? '—' }}</td>
                  <td>{{ $p->paid_at ? \Illuminate\Support\Carbon::parse($p->paid_at)->format('d M Y H:i') : '—' }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>

  <div id="tab-sessions" style="display:none">
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
  </div>

  <div id="tab-messages" style="display:none">
    <div class="card">
      <h3>Messages & notes</h3>
      <div class="em">No messages recorded.</div>
    </div>
    <div class="card">
      <h3>Notes</h3>
      <div class="em">No notes.</div>
    </div>
  </div>

  <div id="tab-activity" style="display:none">
    <div class="card">
      <h3>Activity log</h3>
      <div class="tl">
        @forelse($leads as $l)
          <div><b>{{ $l->event }}</b><small>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y, H:i') }}{{ $l->ip ? ' · '.$l->ip : '' }}</small></div>
        @empty
          <div class="em" style="padding-left:0">No activity.</div>
        @endforelse
      </div>
    </div>
  </div>

  <div id="tab-tools" style="display:none">
    <div class="card">
      <h3>Tools usage</h3>
      <div class="sc">
        <table>
          <thead><tr><th>Tool</th><th>Last used</th><th>Details</th></tr></thead>
          <tbody>
            <tr><td colspan="3" class="em">No tool usage recorded.</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div id="tab-referrals" style="display:none">
    <div class="card">
      <h3>Referrals</h3>
      <div class="sc">
        @if($leads->isEmpty())
          <div class="em">No referrals.</div>
        @else
          <table>
            <thead><tr><th>Event</th><th>Mobile</th><th>Email</th><th>Created</th></tr></thead>
            <tbody>
              @foreach($leads as $l)
                <tr><td>{{ $l->event }}</td><td>{{ $l->mobile ?? '—' }}</td><td>{{ $l->email ?? '—' }}</td><td>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y H:i') }}</td></tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  const tabs = document.querySelectorAll('#custTabs button');
  tabs.forEach(btn => {
    btn.addEventListener('click', () => {
      tabs.forEach(b=>b.classList.remove('on'));
      btn.classList.add('on');
      const tab = btn.dataset.tab;
      ['profile','planner','tools','payments','sessions','referrals','messages','activity'].forEach(t => {
        const el = document.getElementById('tab-'+t);
        if(el) el.style.display = (t===tab)?'block':'none';
      });
    });
  });
  document.querySelectorAll('.dd summary').forEach(s=>{ s.addEventListener('click',e=>{ e.preventDefault(); const d=s.parentElement; d.open=!d.open; }); });
</script>
@endpush
