@extends('admin.layout')

@section('title', 'Client Profile')

@push('styles')
  <style>
    .hh {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
      align-items: flex-start;
      margin-bottom: 14px
    }

    .hr {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      align-items: center
    }

    .sub {
      color: var(--mut);
      font-size: 13px
    }

    .crumb {
      color: var(--mut);
      margin-bottom: 8px;
      font-size: 13px
    }

    .crumb a {
      color: var(--pri);
      text-decoration: none;
      font-weight: 600
    }

    .crumb b {
      color: var(--ink)
    }

    .hd {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 16px 18px;
      margin-bottom: 14px;
      display: flex;
      gap: 16px;
      align-items: center;
      flex-wrap: wrap
    }

    .av {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: var(--pri);
      color: #fff;
      display: grid;
      place-items: center;
      font-weight: 700;
      font-size: 18px
    }

    .hd h3 {
      margin: 0;
      font-size: 18px
    }

    .hd p {
      margin: 0;
      color: var(--mut)
    }

    .hd .r {
      margin-left: auto;
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      align-items: center
    }

    .btn {
      font: inherit;
      font-weight: 600;
      padding: 7px 12px;
      border-radius: 8px;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--ink);
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px
    }

    .btn.p {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri)
    }

    .btn.wa {
      background: #25d366;
      color: #053b1b;
      border-color: #25d366;
      text-decoration: none
    }

    .tabs {
      display: flex;
      gap: 6px;
      margin-bottom: 14px;
      flex-wrap: wrap;
      position: sticky;
      top: 0;
      background: var(--bg);
      padding: 6px 0;
      z-index: 5
    }

    .tabs button {
      font: inherit;
      font-weight: 600;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--mut);
      padding: 6px 13px;
      border-radius: 99px;
      cursor: pointer
    }

    .tabs button.on {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri)
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      margin-bottom: 14px;
      overflow: hidden
    }

    .card>h3 {
      margin: 0;
      padding: 12px 16px;
      font-size: 14.5px;
      border-bottom: 1px solid var(--line)
    }

    .kv {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }

    .kv div {
      padding: 10px 16px;
      border-bottom: 1px solid var(--line)
    }

    .kv dt {
      color: var(--mut);
      font-size: 12.5px
    }

    .kv dd {
      margin: 0;
      font-weight: 600;
      word-break: break-word
    }

    .sc {
      overflow-x: auto
    }

    table {
      border-collapse: collapse;
      width: 100%;
      min-width: 560px
    }

    th,
    td {
      text-align: left;
      padding: 9px 14px;
      border-bottom: 1px solid var(--line);
      white-space: nowrap
    }

    th {
      color: var(--mut);
      font-size: 12.5px;
      font-weight: 600;
      background: color-mix(in srgb, var(--bg) 60%, var(--card))
    }

    tr:last-child td {
      border: 0
    }

    .pill {
      display: inline-block;
      padding: 2px 9px;
      border-radius: 99px;
      font-size: 12px;
      font-weight: 700;
      background: var(--bg);
      color: var(--mut)
    }

    .pill.ok {
      background: var(--ok-s);
      color: var(--ok)
    }

    .pill.bad {
      background: var(--bad-s);
      color: var(--bad)
    }

    .pill.warn {
      background: var(--warn-s);
      color: var(--warn)
    }

    .pill.pri {
      background: var(--pri-s);
      color: var(--pri)
    }

    .em {
      padding: 16px;
      color: var(--mut)
    }

    .tl {
      border-left: 2px solid var(--line);
      margin: 14px 16px 8px 22px;
      padding-left: 18px
    }

    .tl div {
      position: relative;
      padding-bottom: 12px
    }

    .tl div:before {
      content: "";
      position: absolute;
      left: -25px;
      top: 6px;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--pri)
    }

    .tl small {
      color: var(--mut);
      display: block
    }

    .dd {
      position: relative;
      display: inline-block
    }

    .dd>summary {
      list-style: none;
      cursor: pointer;
      user-select: none
    }

    .dd>summary::-webkit-details-marker {
      display: none
    }

    .dd .ddm {
      position: absolute;
      right: 0;
      top: calc(100%+4px);
      min-width: 220px;
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
      padding: 4px;
      z-index: 70;
      display: flex;
      flex-direction: column
    }

    .dd .mi {
      font: inherit;
      font-weight: 600;
      text-align: left;
      background: none;
      border: 0;
      border-radius: 7px;
      padding: 9px 12px;
      color: var(--ink);
      cursor: pointer;
      white-space: nowrap;
      text-decoration: none
    }

    .dd .mi:hover {
      background: var(--pri-s)
    }

    .dd .mi.d {
      color: var(--bad)
    }
  </style>
@endpush

@section('content')
  @php
    $fullname = trim(($user->name ?? '') . ' ' . ($user->surname ?? ''));
    $initials = collect(preg_split('/\s+/', $fullname))->filter()->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') ?? 'C';
    $mobileClean = preg_replace('/\D/', '', $user->mobile ?? '');
  @endphp
  <div class="hh">
    <div>
      <div class="crumb"><a href="{{ route('admin.clients') }}">Clients</a> › <a href="{{ route('admin.users') }}">Client
          Records</a> › <b>Customer</b></div>
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
      @if($user->mobile)<button type="button" class="btn wa" onclick="oc('wa')">WhatsApp</button><a class="btn"
      href="tel:{{ $user->mobile }}">Call</a>@endif
      @if($user->email)<button type="button" class="btn" onclick="oc('em')">Email</button>@endif
      <details class="dd">
        <summary class="btn">More ▾</summary>
        <div class="ddm">
          <button type="button" class="mi"
            onclick="document.getElementById('editClient').showModal(); this.closest('details').open=false;">Edit client
            profile</button>
          <button type="button" class="mi"
            onclick="document.getElementById('adjustPoints').showModal(); this.closest('details').open=false;">Adjust
            points / wallet</button>
          <button type="button" class="mi"
            onclick="document.getElementById('addNote').showModal(); this.closest('details').open=false;">Add
            note</button>
          <button type="button" class="mi"
            onclick="document.getElementById('editTags').showModal(); this.closest('details').open=false;">Edit
            tags</button>
          <button type="button" class="mi" onclick="exportClientReport()">Export client report</button>
          <form method="POST" action="{{ route('admin.users.suspend', $user->id) }}" style="margin:0" onsubmit="return confirm('{{ (!empty($user->status) && $user->status === 'Blocked') ? 'Reinstate this account?' : 'Suspend this account?' }}')">
            @csrf
            <button type="submit" class="mi d" style="width:100%">{{ !empty($user->status) && $user->status === 'Blocked' ? 'Reinstate account' : 'Suspend account' }}</button>
          </form>
        </div>
      </details>
    </div>
  </div>

  <dialog id="editClient" style="border:0;padding:0;background:transparent">
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="mo"
      style="width:min(560px,100%);background:var(--card);border:1px solid var(--line);border-radius:14px;padding:20px;display:block">
      @csrf
      @method('PUT')
      <h3 style="margin:0 0 12px">Edit client profile</h3>
      <div class="fg" style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <label>First name<input name="name" value="{{ $user->name ?? '' }}" required></label>
        <label>Surname<input name="surname" value="{{ $user->surname ?? '' }}"></label>
        <label>Mobile<input name="mobile" value="{{ $user->mobile ?? '' }}" required></label>
        <label>Email<input name="email" type="email" value="{{ $user->email ?? '' }}" required></label>
        <label>City<input name="city" value="{{ $user->city ?? '' }}"></label>
        <label>PAN<input name="pan" value="{{ $user->pan ?? '' }}" maxlength="10"></label>
        <label class="w" style="grid-column:1/-1;display:flex;gap:8px;align-items:center"><input type="checkbox"
            name="share_consent" value="1" {{ !empty($user->share_consent) ? 'checked' : '' }}> Share consent</label>
      </div>
      <div class="ac" style="display:flex;gap:8px;justify-content:flex-end;margin-top:14px">
        <button type="button" class="btn" onclick="document.getElementById('editClient').close()">Cancel</button>
        <button type="submit" class="btn p">Save</button>
      </div>
    </form>
  </dialog>

  <dialog id="adjustPoints" style="border:0;padding:0;background:transparent">
    <form method="POST" action="{{ route('admin.users.adjustPoints', $user->id) }}" class="mo"
      style="width:min(560px,100%);background:var(--card);border:1px solid var(--line);border-radius:14px;padding:20px;display:block">
      @csrf
      <h3 style="margin:0 0 12px">Adjust points / wallet – {{ $fullname ?? 'Client' }}</h3>
      <div class="fg" style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <label>Adjust<select name="kind">
            <option>Points</option>
            <option>Wallet (₹)</option>
          </select></label>
        <label>Amount (use − to deduct)<input name="amount" type="number" step="1" required></label>
        <label class="w" style="grid-column:1/-1">Reason (required)<textarea name="reason" rows="3"
            required></textarea></label>
      </div>
      <div class="ac" style="display:flex;gap:8px;justify-content:flex-end;margin-top:14px">
        <button type="button" class="btn" onclick="document.getElementById('adjustPoints').close()">Cancel</button>
        <button type="submit" class="btn p">Save</button>
      </div>
    </form>
  </dialog>

  <dialog id="addNote" style="border:0;padding:0;background:transparent">
    <form method="POST" action="{{ route('admin.users.notes.store', $user->id) }}" class="mo"
      style="width:min(560px,100%);background:var(--card);border:1px solid var(--line);border-radius:14px;padding:20px;display:block">
      @csrf
      <h3 style="margin:0 0 12px">Add note</h3>
      <div class="fg" style="display:grid;grid-template-columns:1fr;gap:10px">
        <label class="w">Note<textarea name="note" rows="4" required></textarea></label>
      </div>
      <div class="ac" style="display:flex;gap:8px;justify-content:flex-end;margin-top:14px">
        <button type="button" class="btn" onclick="document.getElementById('addNote').close()">Cancel</button>
        <button type="submit" class="btn p">Save</button>
      </div>
    </form>
  </dialog>

  <dialog id="editTags" style="border:0;padding:0;background:transparent">
    <form method="POST" action="{{ route('admin.users.tags.update', $user->id) }}" class="mo"
      style="width:min(560px,100%);background:var(--card);border:1px solid var(--line);border-radius:14px;padding:20px;display:block">
      @csrf
      @method('PUT')
      <h3 style="margin:0 0 12px">Edit tags</h3>
      @php $tagsVal = '';
        if (isset($user->tags)) {
          $tagsVal = is_string($user->tags) ? implode(', ', json_decode($user->tags, true) ?: []) : (is_array($user->tags) ? implode(', ', $user->tags) : $user->tags);
      } @endphp
      <div class="fg" style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <label class="w" style="grid-column:1/-1">Tags (comma separated)<input name="tags" value="{{ $tagsVal }}"></label>
        <label>Assigned to<input name="assigned_to" value="{{ $user->assigned_to ?? ($user->owner ?? '') }}"></label>
        <label>Stage<select name="stage">
            @php $st = $user->stage ?? '';
            $opts = ['', 'Signed up', 'Payment failed', 'Paid report', 'Session booked', 'Hot lead', 'Lost']; @endphp
            @foreach($opts as $o)
            <option value="{{ $o }}" {{ $st === $o ? 'selected' : '' }}>{{ $o ?: '—' }}</option>@endforeach
          </select></label>
      </div>
      <div class="ac" style="display:flex;gap:8px;justify-content:flex-end;margin-top:14px">
        <button type="button" class="btn" onclick="document.getElementById('editTags').close()">Cancel</button>
        <button type="submit" class="btn p">Save</button>
      </div>
    </form>
  </dialog>

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
        <div>
          <dt>Full name</dt>
          <dd>{{ $fullname ?? '—' }}</dd>
        </div>
        <div>
          <dt>Mobile</dt>
          <dd>{{ $user->mobile ?? '—' }}</dd>
        </div>
        <div>
          <dt>Email</dt>
          <dd>{{ $user->email ?? '—' }}</dd>
        </div>
        <div>
          <dt>Email verified</dt>
          <dd>@if(!empty($user->email_verified_at))<span class="pill ok">Yes</span>@else<span
          class="pill bad">No</span>@endif</dd>
        </div>
        <div>
          <dt>Mobile verified</dt>
          <dd><span class="pill bad">No</span></dd>
        </div>
        <div>
          <dt>Language</dt>
          <dd>{{ $user->language ?? ($user->lang ?? '—') }}</dd>
        </div>
        <div>
          <dt>Preferred contact</dt>
          <dd>{{ $user->preferred_contact ?? ($user->contact ?? '—') }}</dd>
        </div>
        <div>
          <dt>Country</dt>
          <dd>{{ $user->country ?? '—' }}</dd>
        </div>
        <div>
          <dt>Residential status</dt>
          <dd>{{ $user->residential_status ?? ($user->res ?? '—') }}</dd>
        </div>
        <div>
          <dt>State</dt>
          <dd>{{ $user->state ?? '—' }}</dd>
        </div>
        <div>
          <dt>City</dt>
          <dd>{{ $user->city ?? '—' }}</dd>
        </div>
        <div>
          <dt>Age</dt>
          <dd>{{ $user->age ?? '—' }}</dd>
        </div>
        <div>
          <dt>PAN (masked)</dt>
          <dd>{{ $user->pan_masked ?? ($user->pan ?? '—') }}</dd>
        </div>
        <div>
          <dt>Account status</dt>
          <dd>{{ $user->status ?? 'Active' }}</dd>
        </div>
        <div>
          <dt>Joined</dt>
          <dd>{{ \Illuminate\Support\Carbon::parse($user->created_at)->format('d M Y, H:i') }}</dd>
        </div>
        <div>
          <dt>Last active</dt>
          <dd>{{ $user->updated_at ? \Illuminate\Support\Carbon::parse($user->updated_at)->format('d M Y, H:i') : '—' }}
          </dd>
        </div>
        <div>
          <dt>Source</dt>
          <dd>{{ $user->source ?? ($user->src ?? '—') }}</dd>
        </div>
        <div>
          <dt>Signup IP</dt>
          <dd>{{ $user->signup_ip ?? ($user->ip ?? '—') }}</dd>
        </div>
        <div>
          <dt>Device</dt>
          <dd>{{ $user->device ?? ($user->dev ?? '—') }}</dd>
        </div>
      </div>
    </div>

    <div class="card">
      <h3>Referral & rewards</h3>
      <div class="kv">
        <div>
          <dt>Own referral code</dt>
          <dd>{{ $user->referral_code ?? '—' }}</dd>
        </div>
        <div>
          <dt>Referred by</dt>
          <dd>{{ $user->referred_by_code ?? '—' }}</dd>
        </div>
        <div>
          <dt>Referrals made</dt>
          <dd>{{ $leads->count() }}</dd>
        </div>
        <div>
          <dt>Points balance</dt>
          <dd>{{ $reportPts ?? 0 }}</dd>
        </div>
        <div>
          <dt>Wallet balance</dt>
          <dd>{{ $walletPts ?? 0 }}</dd>
        </div>
        <div>
          <dt>Streak</dt>
          <dd>{{ $user->streak ?? '—' }}</dd>
        </div>
      </div>
    </div>

    <div class="card">
      <h3>Admin</h3>
      <div class="kv">
        <div>
          <dt>Stage</dt>
          <dd><span class="pill pri">{{ $user->stage ?? '—' }}</span></dd>
        </div>
        <div>
          <dt>Tags</dt>
          <dd>
            @php $tv = [];
              if (isset($user->tags) && $user->tags) {
                $tv = is_string($user->tags) ? (json_decode($user->tags, true) ?: []) : (is_array($user->tags) ? $user->tags : []);
            } @endphp
            {{ $tv ? implode(', ', $tv) : '—' }}
          </dd>
        </div>
        <div>
          <dt>Assigned to</dt>
          <dd>{{ $user->assigned_to ?? 'Unassigned' }}</dd>
        </div>
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
            <thead>
              <tr>
                <th>TxnID</th>
                <th>Purpose</th>
                <th>Amount</th>
                <th>Status</th>
                <th>PayU ID</th>
                <th>Mode</th>
                <th>Paid at</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($payments as $p)
                <tr>
                  <td>{{ $p->txnid }}</td>
                  <td>{{ $p->purpose }}</td>
                  <td>₹{{ number_format($p->amount, 2) }}</td>
                  <td>@if($p->status === 'success')<span class="pill ok">success</span>@elseif($p->status === 'failed')<span
                  class="pill bad">failed</span>@else<span class="pill warn">{{ $p->status }}</span>@endif</td>
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
            <thead>
              <tr>
                <th>Date</th>
                <th>Slot</th>
                <th>Mode</th>
                <th>Mobile</th>
                <th>Status</th>
                <th>Note</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sessions as $s)
                <tr>
                  <td>{{ $s->date }}</td>
                  <td>{{ $s->slot }}</td>
                  <td>{{ $s->mode }}</td>
                  <td>{{ $s->mobile }}</td>
                  <td>{{ $s->status }}</td>
                  <td>{{ $s->note ?? '—' }}</td>
                </tr>
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
      @if(isset($notes) && $notes->count())
        <div class="tl">
          @foreach($notes as $n)
            <div>
              <b>{{ $n->author }}</b><small>{{ \Illuminate\Support\Carbon::parse($n->created_at)->format('d M Y, H:i') }}</small>
              <div style="margin-top:4px">{{ $n->note }}</div>
            </div>
          @endforeach
        </div>
      @else
        <div class="em">No notes.</div>
      @endif
    </div>
  </div>

  <div id="tab-activity" style="display:none">
    <div class="card">
      <h3>Activity log</h3>
      <div class="tl">
        @forelse($leads as $l)
          <div>
            <b>{{ $l->event }}</b><small>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y, H:i') }}{{ $l->ip ? ' · ' . $l->ip : '' }}</small>
          </div>
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
          <thead>
            <tr>
              <th>Tool</th>
              <th>Last used</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="3" class="em">No tool usage recorded.</td>
            </tr>
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
            <thead>
              <tr>
                <th>Event</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($leads as $l)
                <tr>
                  <td>{{ $l->event }}</td>
                  <td>{{ $l->mobile ?? '—' }}</td>
                  <td>{{ $l->email ?? '—' }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
  <script>
    (function () {
      const CT = [
        { n: "Welcome", t: "Namaste {name}\n\nRetirement Plan Karo me aapka swagat hai! Aapke account me 600 welcome points add ho gaye hain.\n\nApna free retirement plan banayein {link}\n– Team Retirement Plan Karo" },
        { n: "Plan incomplete reminder", t: "Hi {name},\n\nAapne Retirement Plan Karo par account banaya tha, lekin abhi tak apna retirement plan complete nahi kiya.\n\nSirf 4 simple steps, 5 minute\nFree retirement corpus & SIP calculation\n600 welcome points aapke account me wait kar rahe hain\n\nAbhi plan banayein: {link}\n\nKoi sawal ho to bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Payment failed", t: "Hi {name},\n\nAapka {purpose} payment complete nahi ho paya.\n\nKoi baat nahi Aap yahan se dobara try kar sakte hain: {link}\n\nAgar paise kat gaye hain to 2–3 din me auto-refund ho jayenge. Madad chahiye to reply karein.\n– Team Retirement Plan Karo" },
        { n: "Report ready", t: "Hi {name}, aapki Premium Retirement Report ready hai\nDownload karein: {link}\n– Team Retirement Plan Karo" },
        { n: "Session confirmation", t: "Hi {name}, aapka guidance session confirm ho gaya hai.\n\nHamari team aapko call / video link share karegi. Kisi badlav ke liye bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Hot lead follow-up", t: "Hi {name}, aapne retirement guidance me interest dikhaya tha\n\nKya hum kal ek chhota call fix kar dein? Aapko kaunsa time suit karega? Reply karein.\n– Team Retirement Plan Karo" },
        { n: "Inactive user nudge", t: "Hi {name}, kaafi din se aap Retirement Plan Karo par nahi aaye.\n\nAapka plan wahin save hai — 2 minute me update karein {link}\n– Team Retirement Plan Karo" },
        { n: "Coupon / promotion", t: "Hi {name}\n\nSirf aapke liye special offer: coupon code *{coupon}* use karein aur Premium Report / Guidance Session par discount payein.\n\nAbhi use karein {link}\n– Team Retirement Plan Karo" },
        { n: "Festival wishes", t: "Hi {name}, aapko aur parivaar ko tyohaar ki hardik shubhkamnayein\nIs saal apne retirement ko bhi surakshit banayein {link}\n– Team Retirement Plan Karo" },
        { n: "Referral update", t: "Congratulations {name},\n\nAapke referral link se naye signups hue hain.\n\nPoints check karein, Aur dosto ko invite karein: {link}\n– Team Retirement Plan Karo" },
        { n: "Greeting / follow-up", t: "Namaste {name}\n\nRetirement Plan Karo se baat kar rahe hain. Aapke retirement plan me madad chahiye to bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Quote · Term Insurance", t: "Hi {name}, aapki Term Insurance request ke liye shukriya\n\nAapke details ke hisaab se best options:\n1) ______ – ₹____ /year\n2) ______ – ₹____ /year\n\nCover aur premium compare karke plan select karein.\nAgle step ke liye bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Quote · Health Insurance", t: "Hi {name}, aapki Health Insurance request ke liye shukriya\n\nAapke details ke hisaab se best options:\n1) ______ – ₹____ /year\n2) ______ – ₹____ /year\n\nCover, network hospitals aur waiting period compare karein.\nAgle step ke liye bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Quote · Car / Bike Insurance", t: "Hi {name}, aapki Car / Bike Insurance request ke liye shukriya\n\nAapke details ke hisaab se best options:\n1) ______ – ₹____ /year\n2) ______ – ₹____ /year\n\nAapki policy expiry se pehle renew karna best rahega.\nAgle step ke liye bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Quote · Credit Card", t: "Hi {name}, aapki Credit Card request ke liye shukriya\n\nAapke details ke hisaab se best options:\n1) ______ – ₹____ /year\n2) ______ – ₹____ /year\n\nFees, rewards aur eligibility compare karein.\nAgle step ke liye bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Quote · Personal Loan", t: "Hi {name}, aapki Personal Loan request ke liye shukriya\n\nAapke details ke hisaab se best options:\n1) ______ – ₹____ /year\n2) ______ – ₹____ /year\n\nInterest rate aur processing fee compare karein.\nAgle step ke liye bas reply karein.\n– Team Retirement Plan Karo" },
        { n: "Quote · Loan Against Mutual Fund", t: "Hi {name}, aapki Loan Against Mutual Fund request ke liye shukriya\n\nAapke details ke hisaab se best options:\n1) ______ – ₹____ /year\n2) ______ – ₹____ /year\n\nAapke funds becheye bina low-interest loan mil sakta hai.\nAgle step ke liye bas reply karein.\n– Team Retirement Plan Karo" },

        { n: "Welcome email", sub: "Welcome to Retirement Plan Karo, {name}!", t: "Hi {name},\n\nRetirement Plan Karo me aapka swagat hai!\n\nAapke account me 600 welcome points add ho gaye hain. Sirf 5 minute me aap ye sab kar sakte hain:\n  • Apna retirement corpus aur SIP calculate karein\n  • Life goals aur family ka plan banayein\n  • Free calculators (SIP, Tax, Home Loan EMI) use karein\n\nAbhi shuru karein: {link}\n\nKoi bhi sawal ho to is mail ka reply karein, hum madad karenge. \n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Plan incomplete reminder", sub: "{name}, aapka retirement plan adhura hai", t: "Hi {name},\n\nAapne Retirement Plan Karo par account banaya tha, lekin plan abhi complete nahi hua. Sirf 4 simple steps baaki hain:\n  Net worth aur expenses\n  Retirement age aur investment\n  Life goals\n  Free report aur SIP suggestion\n\nPlan complete karne ke liye yahan click karein: {link}\n\nAapke 600 welcome points bhi wahin wait kar rahe hain.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Payment failed", sub: "Aapka ₹{amount} ka {purpose} payment complete nahi hua", t: "Hi {name},\n\nAapka ₹{amount} ka {purpose} payment ({date}) complete nahi ho paya. Koi baat nahi, aap dobara try kar sakte hain: {link}\n\nDhyan dein:\n • Agar paise kat gaye hain to 2–3 din me auto-refund ho jayenge.\n • Payment dobara fail ho to UPI ya card badal kar try karein.\n\nAgar koi dikkat ho to hume is mail ka reply karein.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Report ready", sub: "Aapki Premium Retirement Report ready hai", t: "Hi {name},\n\nAapki Premium Retirement Report ready hai.\n\nIsme aapko milega:\n• Corpus needed aur shortfall ka poora hisaab\n• Monthly SIP aur SWP income plan\n• Goal-wise readiness\n\nReport download karein: {link}\n\nReport samajhne me madad chahiye to guidance session book kar sakte hain.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Session confirmation", sub: "Aapka guidance session confirm ho gaya", t: "Hi {name},\n\nAapka guidance session confirm ho gaya hai.\n\nKya karein:\n• Session ke time par phone / video par available rahein\n• Apna planner aur report saath rakhein\n• Koi sawal ho to pehle se likh lein\n\nHamari team call / video link WhatsApp par share karegi. Badlav ke liye is mail ka reply karein.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Hot lead follow-up", sub: "{name} kya hum aapke retirement plan par baat karein?", t: "Hi {name},\n\nAapne retirement guidance me interest dikhaya tha, isliye hum follow-up kar rahe hain.\n\nEk chhote 20–30 minute ke call me hum:\n• Aapka retirement corpus aur gap samjhayenge\n• Aapke liye sahi SIP / investment mix batayenge\n• Aapke sawalon ke jawab denge\n\nBas bataiye aapko kaunsa din aur time suit karega.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Inactive user nudge", sub: "{name}, aapka plan aapka intezaar kar raha hai", t: "Hi {name},\n\nKaafi din se aap Retirement Plan Karo par nahi aaye. Aapka plan wahin save hai.\n\nNaya kya hai:\n• Income Tax Calculator (New Regime FY 2026-27)\n• SIP aur Home Loan EMI Calculators\n• Budget Planner\n\nWapas aayein: {link}\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Coupon / promotion", sub: "Aapke liye special coupon: LAUNCH20", t: "Hi {name},\n\nAapke liye ek special offer.\n\nCoupon Code: LAUNCH20\nLaagu hai: Premium Report aur Guidance Session par.\n\nCheckout ke time ye code daalein: {link}\n\nOffer limited time ke liye hai, isliye der na karein.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Festival wishes", sub: "Tyohaar ki hardik shubhkamnayein, {name}!", t: "Hi {name},\n\nAapko aur aapke parivaar ko tyohaar ki hardik shubhkamnayein.\n\nIs tyohaar par apne aur parivaar ke surakshit bhavishya ka sankalp lein. Aapka retirement plan banane me hum madad ke liye taiyar hain.\n\nShuruaat karein: {link}\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Referral update", sub: "Aapke dost join kar chuke hain", t: "Hi {name},\n\nShukriya! Aapke referral link se ab tak {referral_count} dost join kar chuke hain ({referral_names}).\n\nAapko {points} points mile hain. Aur dosto ko invite karne ke liye apna link share karein:\n{link}\n\nJitne zyada dost, utne zyada rewards!\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Quote · Term Insurance", sub: "Aapke Term Insurance quotes", t: "Hi {name},\n\nAapne hamare paas Term Insurance ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:\n\n1) {plan_1_name} – ₹{plan_1_premium}/year\n2) {plan_2_name} – ₹{plan_2_premium}/year\n\nCover aur premium compare karke plan select karein.\n\nAgle step ke liye aapko ID proof, address proof, income proof (salary slip / ITR) aur recent photo chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.\n\nKoi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Quote · Health Insurance", sub: "Aapke Health Insurance quotes", t: "Hi {name},\n\nAapne hamare paas Health Insurance ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:\n\n1) {option_1_name} – ₹{option_1_premium}/year\n2) {option_2_name} – ₹{option_2_premium}/year\n\nCover, network hospitals aur waiting period compare karein.\n\nAgle step ke liye aapko sabhi members ki age aur ID proof, aur kisi pehle se chal rahi bimari ki jaankari chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.\n\nKoi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Quote · Car / Bike Insurance", sub: "Aapke Car / Bike Insurance quotes", t: "Hi {name},\n\nAapne hamare paas Car / Bike Insurance ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:\n\n1) {option_1_name} – ₹{option_1_premium}/year\n2) {option_2_name} – ₹{option_2_premium}/year\n\nAapki policy expiry se pehle renew karna best rahega.\n\nAgle step ke liye aapko RC copy, purani policy ki copy aur ID proof chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.\n\nKoi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Quote · Credit Card", sub: "Aapke Credit Card quotes", t: "Hi {name},\n\nAapne hamare paas Credit Card ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:\n\n1) {option_1_name} – ₹{option_1_fee}/year\n2) {option_2_name} – ₹{option_2_fee}/year\n\nFees, rewards aur eligibility compare karein.\n\nAgle step ke liye aapko PAN, Aadhaar aur income proof (salary slip / ITR) chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.\n\nKoi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Quote · Personal Loan", sub: "Aapke Personal Loan quotes", t: "Hi {name},\n\nAapne hamare paas Personal Loan ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:\n\n1) {option_1_name} – ₹{option_1_rate}/year\n2) {option_2_name} – ₹{option_2_rate}/year\n\nInterest rate aur processing fee compare karein.\n\nAgle step ke liye aapko PAN, Aadhaar, 3 mahine ki salary slip aur 6 mahine ka bank statement chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.\n\nKoi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
        { n: "Quote · Loan Against Mutual Fund", sub: "Aapke Loan Against Mutual Fund quotes", t: "Hi {name},\n\nAapne hamare paas Loan Against Mutual Fund ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:\n\n1) {option_1_name} – ₹{option_1_rate}/year\n2) {option_2_name} – ₹{option_2_rate}/year\n\nAapke funds beche bina low-interest loan mil sakta hai.\n\nAgle step ke liye aapko PAN, Aadhaar aur mutual fund holdings statement (CAS) chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.\n\nKoi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },

      ];
      const U = { name: @json($fullname ?? 'Customer'), mobile: @json($user->mobile ?? ''), email: @json($user->email ?? ''), link: location.origin + '/' };
      if (!document.getElementById('cmo')) {
        const m = document.createElement('div'); m.id = 'cmo'; m.className = 'ov';
        m.innerHTML = '<div class="mo" style="width:min(920px,98vw)"><h3 id="ctit">WhatsApp · ' + (U.name || '') + '</h3><p style="color:var(--mut);margin:-4px 0 8px">+' + (U.mobile || '') + '</p><label style="font-size:12.5px;color:var(--mut);font-weight:600">Template<select class="in" id="ctsel"></select></label><textarea class="in" id="ctext" rows="10" style="margin-top:8px"></textarea><p style="color:var(--mut);font-size:12px;margin:4px 0 0" id="chelp">Preview · personalised for this client</p><div class="ac" style="flex-wrap:wrap"><button type="button" class="btn" id="fc">Cancel</button><button type="button" class="btn" id="cn">+ New template</button><button type="button" class="btn" id="ce">Edit template</button><button type="button" class="btn wa" id="ws">OK · Send on WhatsApp</button></div></div>';
        document.body.appendChild(m);
        const st = document.createElement('style');
        st.textContent = '.ov{position:fixed;inset:0;background:rgba(10,12,30,.5);display:none;align-items:center;justify-content:center;z-index:200;padding:16px}.ov.o{display:flex}.mo{background:var(--card);border-radius:14px;width:min(560px,100%);max-height:90vh;overflow:auto;padding:20px}.mo h3{margin:0 0 12px}.fg{display:grid;grid-template-columns:1fr 1fr;gap:10px}.fg .w{grid-column:1/-1}.fg label{display:block;font-size:12.5px;color:var(--mut);font-weight:600}.fg input,.fg select,.fg textarea,.in{font:inherit;width:100%;margin-top:3px;padding:8px 10px;border:1px solid var(--line);border-radius:8px;background:var(--bg);color:var(--ink)}.ac{display:flex;gap:8px;justify-content:flex-end;margin-top:14px}';
        document.head.appendChild(st);
      }
      const ov = document.getElementById('cmo');
      function $(id) { return document.getElementById(id); }
      function fill(t) { const n = (U.name || '').split(' ')[0]; return (t || '').replace(/\{name\}/g, n).replace(/\{link\}/g, U.link).replace(/\{amount\}/g, '').replace(/\{purpose\}/g, 'Premium Report').replace(/\{date\}/g, '').replace(/\{n\}/g, '0').replace(/\{names\}/g, '').replace(/\{pts\}/g, '0').replace(/\{coupon\}/g, '').replace(/\{type\}/g, '').replace(/\{quote\}/g, '1) ______ – ₹____ /year\n2) ______ – ₹____ /year'); }
      let k = 0, raw = false, ch = 'wa';
      function L() { return CT.map((c, i) => [c, i]).filter(x => (x[0].ch || 'wa') === ch); }
      function draw() {
        if (ch === 'wa') {
          $('ctit').textContent = 'WhatsApp · ' + (U.name || '');
          $('cmo').querySelector('p').textContent = '+' + (U.mobile || '');
          $('ws').textContent = 'OK · Send on WhatsApp';
          $('ws').classList.add('wa');
        } else {
          $('ctit').textContent = 'Email · ' + (U.name || '');
          $('cmo').querySelector('p').textContent = U.email || '';
          $('ws').textContent = 'OK · Send Email';
          $('ws').classList.remove('wa');
        }
        const sel = $('ctsel'); sel.innerHTML = '';
        L().forEach(x => { const o = document.createElement('option'); o.value = x[1]; o.textContent = x[0].n; if (x[1] === k) o.selected = true; sel.appendChild(o); });
        const c = CT[k] || { t: '' };
        $('ctext').value = raw ? c.t : fill(c.t);
        $('chelp').textContent = raw ? 'Template edit mode · variables: {name} {link} {amount} {purpose} {date} {n} {names} {pts}' : 'Preview · personalised for this client';
        $('ce').textContent = raw ? 'Save template' : 'Edit template';
      }
      window.oc = function (c) { ch = c || 'wa'; k = L()[0] ? L()[0][1] : 0; raw = false; draw(); ov.classList.add('o'); };
      $('fc').onclick = function () { ov.classList.remove('o'); };
      $('ctsel').onchange = function () { k = +this.value; raw = false; draw(); };
      $('ce').onclick = function () { if (raw) { CT[k].t = $('ctext').value; raw = false; alert('Template saved'); draw(); return; } raw = true; draw(); };
      $('cn').onclick = function () { const n = prompt('Template Name'); if (!n) return; CT.push({ n, t: 'Hi {name}, ' }); k = CT.length - 1; raw = true; draw(); };
      $('ws').onclick = function () { if (raw) { alert('Click Save template first'); return; } if (ch === 'wa') { const num = (U.mobile || '').replace(/\D/g, '').slice(-10); if (num.length < 10) { alert('Enter correct mobile number '); return; } window.open('https://wa.me/91' + num + '?text=' + encodeURIComponent($('ctext').value), '_blank'); } else { window.location.href = 'mailto:' + encodeURIComponent(U.email) + '?subject=' + (CT[k].sub ? fill(CT[k].sub) : CT[k].n) + '&body=' + encodeURIComponent($('ctext').value); } ov.classList.remove('o'); };
      const tabs = document.querySelectorAll('#custTabs button'); tabs.forEach(btn => { btn.addEventListener('click', () => { tabs.forEach(b => b.classList.remove('on')); btn.classList.add('on'); const tab = btn.dataset.tab;['profile', 'planner', 'tools', 'payments', 'sessions', 'referrals', 'messages', 'activity'].forEach(t => { const el = document.getElementById('tab-' + t); if (el) el.style.display = (t === tab) ? 'block' : 'none'; }); }); });
      document.querySelectorAll('.dd summary').forEach(s => { s.addEventListener('click', e => { e.preventDefault(); const d = s.parentElement; d.open = !d.open; }); });

      const PAL = [["1F4E9E", "E3ECFA"], ["0F7A3D", "E1F5E9"], ["B45309", "FDEFD8"], ["6D28D9", "EDE5FC"], ["BE123C", "FCE4EA"], ["0E7490", "DAF2F7"]];
      async function xlsx(file, sheets) { if (!window.ExcelJS) { alert('Excel library could not be loaded.'); return; } const wb = new ExcelJS.Workbook(), used = {}; const thin = { style: 'thin', color: { argb: 'FFCBD5E1' } }, bd = { top: thin, left: thin, bottom: thin, right: thin }; sheets.forEach((s, n) => { const [c, l] = PAL[n % PAL.length]; let nm = s.name.replace(/[\\\/\?\*\[\]:]/g, '-').slice(0, 28); used[nm] = (used[nm] || 0) + 1; if (used[nm] > 1) nm += ' ' + used[nm]; const ws = wb.addWorksheet(nm, { views: [{ showGridLines: false, state: 'frozen', ySplit: 3 }] }); const nc = Math.max(s.head.length, 2); ws.mergeCells(1, 1, 1, nc); const t = ws.getCell(1, 1); t.value = s.title || s.name; t.font = { bold: true, size: 16, color: { argb: 'FF' + c } }; t.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF' + c } }; t.alignment = { vertical: 'middle', indent: 1 }; ws.getRow(1).height = 32; ws.mergeCells(2, 1, 2, nc); const sb = ws.getCell(2, 1); sb.value = s.sub || ('Retirement Plan Karo · ' + new Date().toLocaleDateString('en-IN')); sb.font = { italic: true, color: { argb: 'FF64748B' } }; sb.alignment = { indent: 1 }; const h = ws.getRow(3); h.values = s.head; h.height = 24; h.eachCell((k) => { k.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF' + c } }; k.font = { bold: true, color: { argb: 'FFFFFFFF' } }; k.border = bd; k.alignment = { vertical: 'middle', horizontal: 'center' }; }); s.rows.forEach((r, i) => { const row = ws.addRow(r); row.height = 20; for (let ci = 1; ci <= nc; ci++) { const k = row.getCell(ci); k.border = bd; k.alignment = { vertical: 'middle', wrapText: true }; k.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: i % 2 ? 'FFFFFFFF' : 'FF' + l } }; if (typeof k.value === 'number' && k.value >= 1000) k.numFmt = '#,##0'; } }); if (!s.rows.length) { ws.addRow(['No records']); } s.head.forEach((x, ci) => { ws.getColumn(ci + 1).width = Math.min(50, Math.max(String(x).length + 4, ...s.rows.map(r => String(r[ci] ?? '').length + 3))); }); ws.autoFilter = { from: { row: 3, column: 1 }, to: { row: 3, column: nc } }; (s.charts || []).forEach((g, k) => { const id = wb.addImage({ base64: g, extension: 'png' }); ws.addImage(id, { tl: { col: nc + 1, row: 2 + k * 16 }, ext: { width: 520, height: 300 } }); }); }); const buf = await wb.xlsx.writeBuffer(); const a = document.createElement('a'); a.href = URL.createObjectURL(new Blob([buf], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })); a.download = file; a.click(); }
      function chart(kind, title, labels, vals) { const W = 520, H = 300, c = document.createElement('canvas'); c.width = W; c.height = H; const x = c.getContext('2d'); x.fillStyle = '#fff'; x.fillRect(0, 0, W, H); x.fillStyle = '#111827'; x.font = 'bold 14px sans-serif'; x.fillText(title, 12, 22); const max = Math.max(1, ...vals), padL = 40, padB = 36, padT = 34, innerW = W - padL - 20, innerH = H - padT - padB; x.strokeStyle = '#CBD5E1'; x.beginPath(); x.moveTo(padL, padT); x.lineTo(padL, H - padB); x.lineTo(W - 12, H - padB); x.stroke(); const bw = innerW / Math.max(1, vals.length); vals.forEach((v, i) => { const hgt = innerH * (v / max); const xx = padL + i * bw + 10; const yy = H - padB - hgt; x.fillStyle = '#' + PAL[i % PAL.length][0]; x.fillRect(xx, yy, Math.max(10, bw - 20), hgt); x.fillStyle = '#334155'; x.font = '11px sans-serif'; x.fillText(String(labels[i] || '').slice(0, 12), xx, H - padB + 14); x.fillText(String(v), xx, yy - 4); }); return c.toDataURL('image/png').split(',')[1]; }
      window.exportClientReport = async function () {
        const T = U.name + ' · ' + U.mobile;
        const nw = [{{ $reportPts ?? 0 }},{{ $walletPts ?? 0 }}];
        const S = [];
        S.push({
          name: 'Summary', title: 'Customer summary · ' + U.name, sub: T, head: ['Field', 'Value'], rows: [
            ['Name', @json($fullname ?? '')], ['Mobile', @json($user->mobile ?? '')], ['Email', @json($user->email ?? '')], ['City', @json($user->city ?? '')], ['Stage', @json($user->stage ?? '')], ['Joined', @json(isset($user->created_at) ? \Illuminate\Support\Carbon::parse($user->created_at)->format('d M Y, H:i') : '')], ['Referral code', @json($user->referral_code ?? '')], ['Points (report)', @json($reportPts ?? 0)], ['Points (wallet)', @json($walletPts ?? 0)]
          ], charts: [chart('bar', 'Points overview', ['Report pts', 'Wallet pts'], nw)]
        });
        S.push({ name: 'Payments', title: 'Payments', sub: T, head: ['Txn ID', 'Purpose', 'Amount', 'Status', 'PayU ID', 'When'], rows: [@foreach(($payments ?? []) as $p)[@json($p->txnid), @json($p->purpose), @json((float) $p->amount), @json($p->status), @json($p->payu_id ?? ''), @json(\Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y, H:i'))], @endforeach] });
        S.push({ name: 'Sessions', title: 'Guidance sessions', sub: T, head: ['Date', 'Slot', 'Mode', 'Status', 'Note'], rows: [@foreach(($sessions ?? []) as $s)[@json($s->date), @json($s->slot), @json($s->mode), @json($s->status), @json($s->note ?? '')], @endforeach] });
        S.push({ name: 'Notes', title: 'Notes', sub: T, head: ['Author', 'Note', 'When'], rows: [@foreach(($notes ?? []) as $n)[@json($n->author), @json($n->note), @json(\Illuminate\Support\Carbon::parse($n->created_at)->format('d M Y, H:i'))], @endforeach] });
        S.push({ name: 'Activity', title: 'Activity / Leads', sub: T, head: ['Event', 'Mobile', 'Email', 'IP', 'When'], rows: [@foreach(($leads ?? []) as $l)[@json($l->event), @json($l->mobile ?? ''), @json($l->email ?? ''), @json($l->ip ?? ''), @json(\Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y, H:i'))], @endforeach] });
        S.push({ name: 'Wallet ledger', title: 'Wallet & points ledger', sub: T, head: ['Account', 'Type', 'Points', 'Note', 'When'], rows: [@foreach(($ledger ?? []) as $x)[@json($x->account), @json($x->type), @json((int) $x->points), @json($x->note ?? ''), @json(\Illuminate\Support\Carbon::parse($x->created_at)->format('d M Y, H:i'))], @endforeach] });
        await xlsx('Customer_' + (U.name || 'Client').replace(/\W+/g, '_') + '.xlsx', S);
      };
    })();
  </script>
@endpush