@php
  $wa = $channel === 'wa';
  $templates = $wa ? $waTemplates : $emTemplates;
  $tplData = $templates->map(fn($t) => ['id' => $t->id, 'name' => $t->name, 'subject' => $t->subject, 'body' => $t->body])->values();
@endphp

<div class="card" id="send-app" data-wa="{{ $wa ? 1 : 0 }}" style="margin:0">

  {{-- Step 1: channel --}}
  <div class="ms-sec">
    <div class="ms-h"><i>1</i>Send through</div>
    <div class="tbs" style="margin:0">
      <a href="{{ route('admin.messages', ['tab' => 'send', 'channel' => 'wa', 'segment' => $segment, 'fixed' => $fixed ?: null]) }}"
        class="{{ $wa ? 'on' : '' }}">WhatsApp</a>
      <a href="{{ route('admin.messages', ['tab' => 'send', 'channel' => 'em', 'segment' => $segment, 'fixed' => $fixed ?: null]) }}"
        class="{{ !$wa ? 'on' : '' }}">Email</a>
    </div>
  </div>

  {{-- Step 2: recipients --}}
  <div class="ms-sec">
    <div class="ms-h"><i>2</i>Who gets it? <small>Tick or untick people · or add new
        {{ $wa ? 'numbers' : 'emails' }}</small></div>

    {{-- tiny GET form: ONLY changes the group. Everything else is handled in the browser --}}
    <form method="GET" action="{{ route('admin.messages') }}" class="ms-row">
      <input type="hidden" name="tab" value="send">
      <input type="hidden" name="channel" value="{{ $channel }}">
      @foreach($fixed as $fid)<input type="hidden" name="fixed[]" value="{{ $fid }}">@endforeach
      <select name="segment" onchange="this.form.submit()">
        <option value="all" @selected($segment === 'all')>All customers</option>
        <option value="paid" @selected($segment === 'paid')>Paid customers</option>
        <option value="unpaid" @selected($segment === 'unpaid')>Unpaid / failed</option>
        <option value="wallet" @selected($segment === 'wallet')>Wallet users</option>
        <option value="leads" @selected($segment === 'leads')>Leads (signed up only)</option>
        @if(count($fixed))
          <option value="__fixed" @selected($segment === '__fixed')>Leads you filtered ({{ count($fixed) }})</option>
        @endif
        <optgroup label="By lead stage">
          @foreach($leadStages as $stage)
            <option value="stage_{{ $stage }}" @selected($segment === 'stage_' . $stage)>Stage · {{ $stage }}</option>
          @endforeach
        </optgroup>
        <option value="new_only" @selected($segment === 'new_only')>Only new {{ $wa ? 'numbers' : 'emails' }}</option>
      </select>
      <button type="button" class="btn s" id="sel-all">Select all</button>
      <button type="button" class="btn s" id="sel-none">Select none</button>
    </form>

    <div class="ms-list sc">
      <div class="em" id="rcpt-empty">No recipients yet — choose a group above or add {{ $wa ? 'numbers' : 'emails' }}
        below.</div>
      <table id="rcpt-table" style="display:none">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>{{ $wa ? 'WhatsApp number' : 'Email ID' }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="rcpt-body"></tbody>
      </table>
    </div>

    <div class="ms-add">
      <b>Add new {{ $wa ? 'numbers' : 'emails' }} <span style="font-weight:500;color:var(--mut)">(people not in the
          portal yet)</span></b>
      <textarea id="raw" rows="3"
        placeholder="{{ $wa ? '9876543210, 9123456789 — or one per line' : 'name@gmail.com, other@yahoo.com — or one per line' }}"></textarea>
      <div class="ms-chips" id="chips"></div>
      <div class="ms-note">Paste {{ $wa ? 'numbers (+91, spaces and 0 prefix are fine)' : 'email IDs' }}. They get this
        message too — they are not saved as customers.</div>
    </div>
  </div>

  {{-- Step 3: message --}}
  <div class="ms-sec">
    <div class="ms-h"><i>3</i>Message</div>
    <div class="ms-row" style="margin-bottom:10px">
      <select id="tpl">
        <option value="-1">Write my own message</option>
        @foreach($templates as $t)
          <option value="{{ $t->id }}">
            {{ $t->name }}{{ (string) $recommendedId === (string) $t->id ? '  ★ Recommended' : '' }}</option>
        @endforeach
      </select>
    </div>
    @unless($wa)
      <input type="text" id="subject" placeholder="Email subject" style="margin-bottom:10px">
    @endunless
    <textarea id="body" rows="{{ $wa ? 7 : 11 }}" placeholder="Type your message here…"></textarea>
    <div class="ms-note">
      @if($wa)
        <b>{friend}</b> = customer's first name, <b>{name}</b> = full name, <b>{link}</b> = website link. WhatsApp opens
        one chat at a time — press <b>Send next</b> for each person.
      @else
        Email goes to everyone in BCC (they cannot see each other), so <b>{name}</b> / <b>{friend}</b> become "Friend".
        Gmail opens {{ 30 }} people at a time.
      @endif
    </div>
  </div>

  {{-- Bottom bar --}}
  <div class="ms-bar">
    <div id="summary" style="color:var(--mut)">Choose recipients to continue</div>
    <div class="row">
      <button type="button" class="btn link" id="copy">Copy {{ $wa ? 'numbers' : 'emails' }}</button>
      <span class="sched">
        <input type="datetime-local" id="when" title="Send later">
        <button type="button" class="btn" id="schedule">Schedule</button>
      </span>
      @if($wa)
        <button type="button" class="btn wa lg" id="send-main">Send on WhatsApp</button>
      @else
        <button type="button" class="btn p lg" id="send-main">Send Email</button>
        <button type="button" class="btn" id="send-mailto">Use Mail app</button>
      @endif
    </div>
  </div>
</div>

@push('scripts')
  <script>
    (() => {
      const WA = document.getElementById('send-app').dataset.wa === '1';
      const BASE = @json($rows);
      const TPL = @json($tplData);
      const LINK = @json($siteLink);
      const CHUNK = 30;
      const $ = id => document.getElementById(id);

      const unchecked = new Set();   // keys the user unticked
      const sent = new Set();        // keys already sent in this session
      let extras = [];
      let busy = false;

      /* ---- helpers (mirror MessageController::normalizePhone / render) ---- */
      const normPhone = v => {
        let d = String(v || '').replace(/\D/g, '');
        if (d.length === 12 && d.startsWith('91')) d = d.slice(2);
        else if (d.length === 11 && d.startsWith('0')) d = d.slice(1);
        return /^[6-9]\d{9}$/.test(d) ? d : null;
      };
      const isEmail = v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
      const render = (body, name, generic) => {
        name = String(name || '').trim();
        const anon = generic || !name;
        const first = anon ? 'Friend' : name.split(/\s+/)[0];
        return body.replace(/\{friend\}/gi, first).replace(/\{name\}/gi, anon ? 'Friend' : name).replace(/\{link\}/gi, LINK);
      };

      /* ---- recipient model ---- */
      function parseExtras() {
        const seen = new Set(BASE.map(r => WA ? r.phone : (r.email || '').toLowerCase()));
        const out = [];
        $('raw').value.split(/[\n,;]+/).map(s => s.trim()).filter(Boolean).forEach(raw => {
          const val = WA ? normPhone(raw) : (isEmail(raw) ? raw.toLowerCase() : null);
          if (val && seen.has(val)) return;          // duplicate of a customer / another extra
          if (val) seen.add(val);
          out.push({
            key: 'x|' + (val || raw), id: null, name: '', raw, extra: true, bad: !val,
            phone: WA ? val : null, mobile: WA ? val : '', email: WA ? '' : val
          });
        });
        return out;
      }

      const all = () => BASE.map(r => ({
        key: r.id + '|' + (WA ? r.phone : r.email), id: r.id, name: r.name, extra: false,
        bad: WA ? !r.phone : !isEmail(r.email || ''), phone: r.phone, mobile: r.mobile, email: r.email,
      })).concat(extras);

      const selected = () => all().filter(r => !r.bad && !unchecked.has(r.key));
      const eligible = () => selected().filter(r => !sent.has(r.key));
      const contact = r => WA ? r.phone : r.email;

      /* ---- rendering ---- */
      function draw() {
        const rows = all();
        $('rcpt-empty').style.display = rows.length ? 'none' : '';
        $('rcpt-table').style.display = rows.length ? '' : 'none';
        const tb = $('rcpt-body');
        tb.textContent = '';
        rows.forEach(r => {
          const tr = document.createElement('tr');
          const td0 = document.createElement('td');
          const cb = document.createElement('input');
          cb.type = 'checkbox'; cb.dataset.key = r.key; cb.checked = !r.bad && !unchecked.has(r.key); cb.disabled = r.bad;
          td0.append(cb);
          const td1 = document.createElement('td');
          td1.append(r.name || '—');
          if (r.extra) { const p = document.createElement('span'); p.className = 'pill pri'; p.textContent = 'New'; td1.append(' ', p); }
          const td2 = document.createElement('td');
          if (r.bad) { const s = document.createElement('span'); s.style.color = 'var(--bad)'; s.textContent = r.extra ? r.raw + ' — ' + (WA ? 'invalid number' : 'invalid email') : (WA ? 'invalid number' : 'invalid email'); td2.append(s); }
          else td2.textContent = contact(r);
          const td3 = document.createElement('td');
          if (sent.has(r.key)) { const p = document.createElement('span'); p.className = 'pill ok'; p.textContent = 'Sent'; td3.append(p); }
          tr.append(td0, td1, td2, td3);
          tb.append(tr);
        });

        const chips = $('chips');
        chips.textContent = '';
        extras.forEach(x => {
          const c = document.createElement('span'); c.className = 'chip' + (x.bad ? ' bad' : '');
          c.append(x.raw + ' ');
          const b = document.createElement('button'); b.type = 'button'; b.textContent = '×'; b.dataset.removeChip = x.raw;
          c.append(b); chips.append(c);
        });

        const total = selected().length, left = eligible().length, done = total - left;
        $('summary').innerHTML = '';
        if (total) {
          const b = document.createElement('b'); b.textContent = total;
          $('summary').append(b, ' ' + (WA ? 'WhatsApp numbers' : 'email IDs') + ' ready');
          if (done) { const s = document.createElement('span'); s.style.color = 'var(--ok)'; s.textContent = ' · ' + done + ' sent'; $('summary').append(s); }
        } else $('summary').textContent = 'Choose recipients to continue';

        const main = $('send-main');
        main.disabled = busy || left === 0;
        if (WA) main.textContent = total && left === 0 ? 'All ' + total + ' done' : (done ? 'Send next (' + left + ' left)' : 'Send on WhatsApp' + (total ? ' · ' + total : ''));
        else {
          main.textContent = total && left === 0 ? 'All ' + total + ' done' : (left > CHUNK ? 'Send to next ' + CHUNK + ' (' + left + ' left)' : 'Send Email' + (total ? ' · ' + total : ''));
          $('send-mailto').disabled = busy || left === 0;
        }
        $('schedule').disabled = busy || left === 0;
        $('copy').disabled = total === 0;
      }

      /* ---- events ---- */
      $('rcpt-body').addEventListener('change', e => {
        const k = e.target.dataset.key; if (!k) return;
        e.target.checked ? unchecked.delete(k) : unchecked.add(k);
        draw();
      });
      $('sel-all').onclick = () => { unchecked.clear(); draw(); };
      $('sel-none').onclick = () => { all().forEach(r => unchecked.add(r.key)); draw(); };

      $('raw').addEventListener('input', () => { extras = parseExtras(); draw(); });
      $('chips').addEventListener('click', e => {
        const v = e.target.dataset.removeChip; if (v === undefined) return;
        $('raw').value = $('raw').value.split(/[\n,;]+/).map(s => s.trim()).filter(x => x && x !== v).join(', ');
        extras = parseExtras(); draw();
      });

      $('tpl').addEventListener('change', e => {
        const t = TPL.find(x => String(x.id) === e.target.value);
        if (!t) return;                                  // "Write my own" keeps whatever is typed
        $('body').value = t.body || '';
        if (!WA && $('subject')) $('subject').value = t.subject || '';
      });

      $('copy').onclick = async () => {
        const list = selected().map(contact).join(WA ? '\n' : ', ');
        try { await navigator.clipboard.writeText(list); toast('Copied ' + selected().length); }
        catch (_) { toast('Copy failed — your browser blocked clipboard access'); }
      };

      /* ---- validation shared by all send paths ---- */
      function readForm() {
        const body = $('body').value.trim();
        const subject = WA ? '' : $('subject').value.trim();
        if (!body) { toast('Write a message first'); return null; }
        if (!WA && !subject) { toast('Add an email subject'); return null; }
        const bad = body.match(/\{(?!friend\}|name\}|link\})[a-z_]+\}/gi);
        if (bad && !confirm('These placeholders will be sent as-is: ' + [...new Set(bad)].join(' ') + '\n\nSend anyway?')) return null;
        const tplId = +$('tpl').value;
        const tpl = TPL.find(t => t.id === tplId);
        return { body, subject: WA ? (tpl ? tpl.name : 'Custom message') : subject, template_id: tplId > 0 ? tplId : null };
      }
      const payloadRecipients = rs => rs.map(r => ({ user_id: r.id, mobile: r.phone || r.mobile || null, email: r.email || null, name: r.name || null }));

      async function logSent(rs, f) {
        busy = true; draw();
        try {
          await postJson(MSG.sendUrl, {
            channel: WA ? 'wa' : 'em', subject: f.subject, body: f.body, template_id: f.template_id,
            generic: !WA, recipients: payloadRecipients(rs)
          });
          rs.forEach(r => sent.add(r.key));
        } catch (err) { toast('Opened, but could not be logged: ' + err.message); }
        busy = false; draw();
      }

      /* ---- send paths ---- */
      $('send-main').onclick = () => {
        const f = readForm(); if (!f) return;
        if (WA) {
          const r = eligible()[0]; if (!r) return;
          window.open('https://wa.me/91' + r.phone + '?text=' + encodeURIComponent(render(f.body, r.name, false)), '_blank', 'noopener');
          logSent([r], f);
        } else {
          const chunk = eligible().slice(0, CHUNK); if (!chunk.length) return;
          const url = 'https://mail.google.com/mail/?view=cm&fs=1&bcc=' + encodeURIComponent(chunk.map(r => r.email).join(','))
            + '&su=' + encodeURIComponent(f.subject) + '&body=' + encodeURIComponent(render(f.body, '', true));
          window.open(url, '_blank', 'noopener');
          logSent(chunk, f);
        }
      };

      if (!WA) $('send-mailto').onclick = () => {
        const f = readForm(); if (!f) return;
        const chunk = eligible().slice(0, CHUNK); if (!chunk.length) return;
        location.href = 'mailto:?bcc=' + encodeURIComponent(chunk.map(r => r.email).join(','))
          + '&subject=' + encodeURIComponent(f.subject) + '&body=' + encodeURIComponent(render(f.body, '', true));
        logSent(chunk, f);
      };

      $('schedule').onclick = async () => {
        const f = readForm(); if (!f) return;
        const when = $('when').value;
        if (!when) { toast('Pick a date and time first'); return; }
        if (new Date(when) <= new Date()) { toast('Pick a time in the future'); return; }
        const rs = eligible(); if (!rs.length) return;
        busy = true; draw();
        try {
          const j = await postJson(MSG.scheduleUrl, {
            channel: WA ? 'wa' : 'em', subject: f.subject, body: f.body, template_id: f.template_id,
            scheduled_at: when, recipients: payloadRecipients(rs)
          });
          toast(j.count + ' message(s) scheduled — see the Activity tab');
        } catch (err) { toast(err.message); }
        busy = false; draw();
      };

      draw();
    })();
  </script>
@endpush