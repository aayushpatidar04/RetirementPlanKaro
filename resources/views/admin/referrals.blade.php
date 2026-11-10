@extends('admin.layout')
@section('title', 'Referrals')

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
      color: var(--mut)
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 14px
    }

    .sc {
      overflow-x: auto
    }

    table {
      border-collapse: collapse;
      width: 100%;
      min-width: 900px;
      font-size: 13px
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

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-family: inherit;
      font-weight: 600;
      padding: 7px 12px;
      border-radius: 8px;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--ink);
      cursor: pointer;
      font-size: 13px;
      text-decoration: none
    }

    .btn.s {
      padding: 5px 9px;
      font-size: 12.5px
    }

    .btn.p {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri)
    }

    .btn.wa {
      background: #25d366;
      color: #fff;
      border-color: #25d366
    }

    .row {
      display: flex;
      gap: 6px;
      flex-wrap: wrap
    }

    .srch {
      display: flex;
      gap: 6px;
      align-items: center;
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 10px;
      padding: 4px 8px;
      flex-wrap: wrap
    }

    .srch select,
    .srch input {
      border: 1px solid var(--line);
      background: var(--bg);
      font: inherit;
      color: var(--ink);
      padding: 6px 8px;
      border-radius: 8px
    }

    .srch label {
      font-size: 12.5px;
      color: var(--mut);
      font-weight: 600
    }

    .pager {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 12px;
      color: var(--mut);
      font-size: 13px
    }

    .em {
      padding: 16px;
      color: var(--mut)
    }

    .ov {
      position: fixed;
      inset: 0;
      background: rgba(10, 12, 30, .5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 200;
      padding: 16px
    }

    .ov.o {
      display: flex
    }

    .mo {
      background: var(--card);
      border-radius: 14px;
      width: min(600px, 98vw);
      max-height: 90vh;
      overflow: auto;
      padding: 20px
    }

    .mo h3 {
      margin: 0 0 12px
    }

    .fg {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px
    }

    .fg .w {
      grid-column: 1/-1
    }

    .fg label {
      display: block;
      font-size: 12.5px;
      color: var(--mut);
      font-weight: 600
    }

    .in {
      font: inherit;
      width: 100%;
      margin-top: 3px;
      padding: 8px 10px;
      border: 1px solid var(--line);
      border-radius: 8px;
      background: var(--bg);
      color: var(--ink)
    }

    .ac {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      margin-top: 14px;
      flex-wrap: wrap
    }

    .pick {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 14px;
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      align-items: center
    }

    .pick label {
      display: flex;
      flex-direction: column;
      gap: 4px;
      font-size: 12.5px;
      color: var(--mut)
    }

    .pick input[type=date] {
      padding: 6px 8px;
      border: 1px solid var(--line);
      border-radius: 8px;
      background: var(--bg);
      color: var(--ink);
      font: inherit
    }

    .kpis {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 14px
    }

    .k {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 14px 20px;
      min-width: 180px;
      flex: 1
    }

    .k span {
      display: block;
      font-size: 12.5px;
      color: var(--mut);
      margin-bottom: 4px
    }

    .k b {
      font-size: 22px;
      color: var(--ink)
    }

    .adv {
      margin-top: 8px;
    }

    .adv summary {
      cursor: pointer;
      color: var(--mut);
      font-size: 12.5px;
      font-weight: 600;
      padding: 8px 0
    }

    .adv summary:hover {
      color: var(--ink)
    }

    .pg {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 10px;
      margin-top: 12px;
      padding: 12px;
    }

    @media (min-width: 768px) {
      .full-width {
        grid-column: span 2;
      }
    }

    .pg .w {
      grid-column: 1/-1
    }

    .pg label {
      display: block;
      font-size: 12.5px;
      color: var(--mut);
      font-weight: 600
    }

    /* Better toggle button style */
    .toggle-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      border-radius: 8px;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--ink);
      font-size: 12.5px;
      font-weight: 600;
      cursor: pointer;
      transition: all .15s;
    }

    .toggle-btn.active {
      background: var(--ok-s);
      color: var(--ok);
      border-color: var(--ok);
    }

    .toggle-btn.inactive {
      background: var(--bad-s);
      color: var(--bad);
      border-color: var(--bad);
    }

    .toggle-btn:hover {
      background: var(--bg);
    }

    .toggle-btn.active:hover {
      background: var(--ok);
      color: #fff;
    }

    .toggle-btn.inactive:hover {
      background: var(--bad);
      color: #fff;
    }

    .monospace {
      font-family: monospace;
      font-size: 12px;
      background: var(--bg);
      padding: 2px 6px;
      border-radius: 4px
    }

    .code-badge {
      background: var(--pri-s);
      color: var(--pri);
      padding: 2px 8px;
      border-radius: 6px;
      font-family: monospace;
      font-weight: 600;
      font-size: 12px
    }

    .link-cell {
      font-size: 12px;
      max-width: 300px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
  <script>
    const PAL = [["1F4E9E", "E3ECFA"], ["0F7A3D", "E1F5E9"], ["B45309", "FDEFD8"], ["6D28D9", "EDE5FC"], ["BE123C", "FCE4EA"], ["0E7490", "DAF2F7"]];

    async function xlsx(file, sheets) {
      if (!window.ExcelJS) { alert('Excel library could not be loaded.'); return; }
      const wb = new ExcelJS.Workbook(), used = {};
      const thin = { style: 'thin', color: { argb: 'FFCBD5E1' } }, bd = { top: thin, left: thin, bottom: thin, right: thin };
      sheets.forEach((s, n) => {
        const [c, l] = PAL[n % PAL.length];
        let nm = String(s.name || 'Sheet').replace(/[\\\/\?\*\[\]:]/g, '-').slice(0, 28);
        used[nm] = (used[nm] || 0) + 1;
        if (used[nm] > 1) nm += ' ' + used[nm];
        const ws = wb.addWorksheet(nm, { views: [{ showGridLines: false, state: 'frozen', ySplit: 3 }] });
        const nc = Math.max((s.head || []).length, 2);
        ws.mergeCells(1, 1, 1, nc);
        const t = ws.getCell(1, 1);
        t.value = s.title || s.name;
        t.font = { bold: true, size: 16, color: { argb: 'FFFFFFFF' } };
        t.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF' + c } };
        t.alignment = { vertical: 'middle', indent: 1 };
        ws.getRow(1).height = 32;
        ws.mergeCells(2, 1, 2, nc);
        const sb = ws.getCell(2, 1);
        sb.value = s.sub || ('Retirement Plan Karo · ' + new Date().toLocaleDateString('en-IN'));
        sb.font = { italic: true, color: { argb: 'FF64748B' } };
        sb.alignment = { indent: 1 };
        const h = ws.getRow(3);
        h.values = s.head;
        h.height = 24;
        h.eachCell((k) => {
          k.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF' + c } };
          k.font = { bold: true, color: { argb: 'FFFFFFFF' } };
          k.border = bd;
          k.alignment = { vertical: 'middle', horizontal: 'center' };
        });
        (s.rows || []).forEach((r, i) => {
          const row = ws.addRow(r);
          row.height = 20;
          for (let ci = 1; ci <= nc; ci++) {
            const k = row.getCell(ci);
            k.border = bd;
            k.alignment = { vertical: 'middle', wrapText: true };
            k.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: i % 2 ? 'FFFFFFFF' : 'FF' + l } };
            if (typeof k.value === 'number' && Math.abs(k.value) >= 1000) k.numFmt = '#,##0.##';
          }
        });
        if (!(s.rows || []).length) ws.addRow(['No records']);
        s.head.forEach((x, ci) => {
          const vals = [String(x || '').length + 4, ...(s.rows || []).map(r => String((r || [])[ci] ?? '').length + 3)];
          ws.getColumn(ci + 1).width = Math.min(52, Math.max(...vals));
        });
        ws.autoFilter = { from: { row: 3, column: 1 }, to: { row: 3, column: nc } };
      });
      const buf = await wb.xlsx.writeBuffer();
      const a = document.createElement('a');
      a.href = URL.createObjectURL(new Blob([buf], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }));
      a.download = file;
      a.click();
      URL.revokeObjectURL(a.href);
    }

    async function exportReferrals() {
      const referrals = @json($referrals->items());
      const rows = referrals.map(r => [
        r.created_at ? new Date(r.created_at).toLocaleString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '',
        r.referrer_name || '',
        r.referrer_mobile || '',
        r.referrer_code || '',
        r.referred_name || '',
        r.referred_mobile || '',
        r.referred_email || '',
        r.referred_stage || '',
      ]);
      const sub = 'Retirement Plan Karo · ' + new Date().toLocaleDateString('en-IN') + ' · {{ $referrals->total() }} records' +
        (@json($from) || @json($to) ? ' · ' + (@json($from) || 'start') + ' to ' + (@json($to) || 'today') : '');
      await xlsx('Referrals_' + (@json($from) || 'start') + '_to_' + (@json($to) || 'today') + '.xlsx', [{
        name: 'Referral Ledger', title: 'Referral Ledger', sub,
        head: ['Date', 'Referrer', 'Referrer Mobile', 'Referral Code', 'Referred Person', 'Mobile', 'Email', 'Stage'],
        rows
      }]);
    }

    async function exportReferrerSummary() {
      const referrerStats = @json($referrerStats);
      const rows = Object.entries(referrerStats).map(([name, clicks]) => [name, clicks]);
      await xlsx('Referrer_Summary_' + new Date().toLocaleDateString('en-IN') + '.xlsx', [{
        name: 'Referrer Summary', title: 'Referrer Summary', sub: 'Retirement Plan Karo · ' + new Date().toLocaleDateString('en-IN'),
        head: ['Referrer', 'Link Clicks'],
        rows
      }]);
    }

    // Form modal helper
    function openForm(title, fields, defaults, onSubmit) {
      const m = document.createElement('div');
      m.className = 'ov';
      m.innerHTML = `
        <div class="mo" style="width:min(600px,98vw)">
          <h3>${title}</h3>
          <form id="dynForm">
            @csrf
            ${fields.map(f => {
        const [name, label, type = 'text', ...rest] = f;
        const options = rest[0] || [];
        const value = defaults[name] ?? '';
        if (type === 'select') {
          return `<div class="fg w"><label>${label}<select class="in" name="${name}">${options.map(o => `<option value="${o}" ${value === o ? 'selected' : ''}>${o}</option>`).join('')}</select></label></div>`;
        }
        if (type === 'check') {
          return `<div class="fg w"><label>${label}<input type="checkbox" name="${name}" ${value ? 'checked' : ''}></label></div>`;
        }
        if (type === 'textarea') {
          return `<div class="fg w"><label>${label}<textarea class="in" name="${name}" rows="3">${value}</textarea></label></div>`;
        }
        return `<div class="fg${type === 'number' ? '' : ''}"><label>${label}<input class="in" type="${type}" name="${name}" value="${value}"></label></div>`;
      }).join('')}
            <div class="ac"><button type="button" class="btn" onclick="this.closest('.ov').remove()">Cancel</button><button type="submit" class="btn p">Save</button></div>
          </form>
        </div>
      `;
      document.body.appendChild(m);
      m.classList.add('o');
      m.querySelector('form').onsubmit = (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        const data = {};
        fd.forEach((v, k) => data[k] = v);
        // Get fresh CSRF token from meta tag at submit time
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (token) data._token = token;
        onSubmit(data, m);
      };
    }

    // Edit referral code
    function editReferralCode(id, currentCode) {
      openForm('Edit referral code', [
        ['code', 'Referral code', 'text']
      ], { code: currentCode }, (data, modal) => {
        if (!data.code.trim()) { alert('Code cannot be empty'); return; }
        const fd = new FormData();
        fd.append('id', id);
        fd.append('referral_code', data.code.trim().toUpperCase());
        fd.append('_token', data._token);
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.referrals.code") }}';
        form.style.display = 'none';
        for (const [k, v] of fd.entries()) {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = k;
          input.value = v;
          form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
      });
    }

    // Campaign link modal
    function openCampaignLinkModal(editIndex = null) {
      const links = @json($campaignLinks);
      const isEdit = editIndex !== null;
      const link = isEdit ? links[editIndex] : { name: '', code: '', target: 'planner', on: true };
      const title = isEdit ? 'Edit campaign link' : 'Add campaign link';

      openForm(title, [
        ['name', 'Campaign name', 'text'],
        ['code', 'Campaign code', 'text'],
        ['target', 'Target page', 'select', ['planner', 'explore', 'get-quotes', 'sip-calculator', 'tax-calculator', 'emi-calculator', 'budget-planner', 'portfolio', 'returns']],
        ['on', 'Active', 'check'],
      ], link, (data, modal) => {
        if (!data.name.trim() || !data.code.trim()) {
          alert('Name and code are required');
          return;
        }

        const fd = new FormData();
        fd.append('name', data.name.trim());
        fd.append('code', data.code.trim());
        fd.append('target', data.target);
        fd.append('on', data.on ? '1' : '0');

        if (isEdit) {
          fd.append('index', editIndex);
        }

        fd.append('_token', data._token || '{{ csrf_token() }}');
        fd.append('_method', isEdit ? 'PUT' : 'POST');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = isEdit
          ? '{{ route("admin.referrals.campaign-link.edit") }}'
          : '{{ route("admin.referrals.campaign-link.add") }}';

        form.style.display = 'none';

        for (const [k, v] of fd.entries()) {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = k;
          input.value = v;
          form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
      });
    }

    // Delete campaign link
    function deleteCampaignLink(index) {
      if (!confirm('Delete this campaign link?')) return;
      const token = document.querySelector('meta[name="csrf-token"]')?.content;
      if (!token) { alert('CSRF token not found'); return; }
      const fd = new FormData();
      fd.append('index', index);
      fd.append('_token', token);
      fd.append('_method', 'DELETE');
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route("admin.referrals.campaign-link.delete") }}';
      form.style.display = 'none';
      Object.entries(fd).forEach(([k, v]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = k;
        input.value = v;
        form.appendChild(input);
      });
      document.body.appendChild(form);
      form.submit();
    }

    // Toggle setting (on/verify) - updates hidden input and submits form
    function toggleSetting(name, hiddenId) {
      const hidden = document.getElementById(hiddenId);
      const btn = hidden.nextElementSibling;
      const newVal = hidden.value === '1' ? '0' : '1';
      hidden.value = newVal;
      btn.classList.toggle('active', newVal === '1');
      btn.classList.toggle('inactive', newVal === '0');
      btn.textContent = newVal === '1' ? 'ON' : 'OFF';
      document.getElementById('referralSettingsForm').submit();
    }
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Referrals</h2>
      <div class="sub" style="margin:2px 0 0">Referral programme & campaign links</div>
    </div>
  </div>

  <!-- KPIs -->
  <div class="kpis">
    <div class="k"><span>Referral registrations</span><b>{{ $totalReferrals }}</b></div>
    <div class="k"><span>Link clicks</span><b>{{ $totalClicks }}</b></div>
    <div class="k"><span>Reward points issued</span><b>{{ $rewardPoints }}</b></div>
  </div>

  <!-- Reward Settings -->
  <div class="card">
    <h3>Reward settings</h3>
    <form method="POST" action="{{ route('admin.referrals.settings') }}" class="pg" id="referralSettingsForm">
      @csrf
      <div>
        <label>Referral programme
          <input type="hidden" name="on" id="refOn" value="{{ $settings['on'] ? '1' : '0' }}">
          <button type="button" class="toggle-btn {{ $settings['on'] ? 'active' : 'inactive' }}"
            onclick="toggleSetting('on', 'refOn')">
            {{ $settings['on'] ? 'ON' : 'OFF' }}
          </button>
        </label>
      </div>
      <div>
        <label>Reward points: referrer<input class="in" type="number" name="bonus"
            value="{{ $settings['bonus'] }}"></label>
      </div>
      <div>
        <label>Reward points: referred client<input class="in" type="number" name="friend"
            value="{{ $settings['friend'] }}"></label>
      </div>
      <details class="adv full-width">
        <summary>More settings</summary>
        <div class="pg" style="margin-top:12px">
          <div>
            <label>Credit rewards only after email verification
              <input type="hidden" name="verify" id="refVerify" value="{{ $settings['verify'] ? '1' : '0' }}">
              <button type="button" class="toggle-btn {{ $settings['verify'] ? 'active' : 'inactive' }}"
                onclick="toggleSetting('verify', 'refVerify')">
                {{ $settings['verify'] ? 'ON' : 'OFF' }}
              </button>
            </label>
          </div>
          <div>
            <label>Maximum referrals per client<input class="in" type="number" name="max" value="{{ $settings['max'] }}"
                placeholder="Unlimited"></label>
          </div>
          <div class="w">
            <label>Website link<input class="in" name="base" value="{{ $settings['base'] }}"></label>
          </div>
          <div class="w">
            <label>Share message ({link} is replaced)<textarea class="in" name="msg"
                rows="2">{{ $settings['msg'] }}</textarea></label>
          </div>
        </div>
      </details>
      <div style="padding:12px 16px 4px;grid-column:1/-1">
        <button type="submit" class="btn p">Save</button>
      </div>
    </form>
  </div>

  <!-- Referral Ledger -->
  <div class="hh srch" style="margin-bottom:8px">
    <h3 class="sec" style="margin:0">Referral ledger · {{ $referrals->total() }}</h3>
    <div class="hr">
      <form method="GET" action="{{ route('admin.referrals') }}"
        style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">
        <label style="color:var(--mut);font-size:12.5px;font-weight:600">From <input type="date" name="from"
            value="{{ $from }}"></label>
        <label style="color:var(--mut);font-size:12.5px;font-weight:600">To <input type="date" name="to"
            value="{{ $to }}"></label>
        <a class="btn" href="{{ route('admin.referrals') }}">Clear</a>
        <button class="btn" type="button" onclick="exportReferrals()">Export Excel</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="sc">
      @if($referrals->isEmpty())
        <div class="em">No referrals in this period</div>
      @else
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Referrer</th>
              <th>Referred client</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>Stage</th>
            </tr>
          </thead>
          <tbody>
            @foreach($referrals as $r)
              <tr>
                <td>{{ \Illuminate\Support\Carbon::parse($r->created_at)->format('d M Y') }}</td>
                <td>{{ $r->referrer_name }}<br><small style="color:var(--mut)">{{ $r->referrer_mobile }}</small></td>
                <td>{{ $r->referred_name }}</td>
                <td>{{ $r->referred_mobile }}</td>
                <td>{{ $r->referred_email ?: '—' }}</td>
                <td><span class="pill pri">{{ $r->referred_stage ?: 'Signed up' }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <!-- Referral Codes -->
  <div class="card" style="padding:12px;">
    <details class="adv" style="border:0">
      <summary>Referral codes and campaign links</summary>
      <table>
        <thead>
          <tr>
            <th>Client</th>
            <th>Code</th>
            <th>Link</th>
            <th>Clicks</th>
            <th>Registrations</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($referralCodes as $u)
            <tr>
              <td>{{ $u->name }}</td>
              <td><span class="code-badge">{{ $u->code ?? $u->referral_code }}</span></td>
              <td class="link-cell monospace" title="{{ $settings['base'] }}?ref={{ $u->code ?? $u->referral_code }}">
                {{ $settings['base'] }}?ref={{ $u->code ?? $u->referral_code }}
              </td>
              <td>{{ $u->clicks ?? 0 }}</td>
              <td>{{ \App\Models\Referral::where('referrer_user_id', $u->id)->count() }}</td>
              <td>
                <form method="POST" action="{{ route('admin.referrals.toggle') }}" style="display:inline">
                  @csrf
                  <input type="hidden" name="id" value="{{ $u->id }}">
                  <button type="submit" class="toggle-btn {{ $u->refoff ? 'inactive' : 'active' }}"
                    style="padding:4px 10px;font-size:12px">
                    {{ $u->refoff ? 'OFF' : 'ON' }}
                  </button>
                </form>
              </td>
              <td>
                <button class="btn s" type="button"
                  onclick="editReferralCode({{ $u->id }}, '{{ $u->code ?? $u->referral_code }}')">Edit code</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Campaign Links -->
      <div style="padding:12px 16px 4px">
        <b>Campaign links</b> <span style="color:var(--mut)">(advertising, WhatsApp, partners)</span>
        <button class="btn s" type="button" onclick="openCampaignLinkModal()" style="float:right">+ Add</button>
      </div>
      <table style="margin-top:8px">
        <thead>
          <tr>
            <th>Campaign</th>
            <th>Link</th>
            <th>Clicks</th>
            <th>Registrations</th>
            <th>Active</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($campaignLinks as $index => $l)
            <tr>
              <td>{{ $l['name'] }}</td>
              <td class="link-cell monospace" title="{{ $settings['base'] }}{{ $l['target'] }}?src={{ $l['code'] }}">
                {{ $settings['base'] }}/{{ $l['target'] }}?src={{ $l['code'] }}
              </td>
              <td>{{ $l['clicks'] ?? 0 }}</td>
              <td>{{ $l['signups'] ?? 0 }}</td>
              <td>
                <form method="POST" action="{{ route('admin.referrals.campaign-link.edit') }}" style="display:inline">
                  @csrf
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="index" value="{{ $index }}">
                  <input type="hidden" name="name" value="{{ $l['name'] }}">
                  <input type="hidden" name="code" value="{{ $l['code'] }}">
                  <input type="hidden" name="target" value="{{ $l['target'] }}">
                  <input type="hidden" name="on" value="{{ $l['on'] ? '1' : '0' }}">
                  <button type="submit" name="on" value="{{ $l['on'] ? '0' : '1' }}"
                    class="toggle-btn {{ $l['on'] ? 'active' : 'inactive' }}" style="padding:4px 10px;font-size:12px">
                    {{ $l['on'] ? 'ON' : 'OFF' }}
                  </button>
                </form>
              </td>
              <td>
                <div class="row">
                  <button class="btn s" type="button" onclick="openCampaignLinkModal({{ $index }})">Edit</button>
                  <form method="POST" action="{{ route('admin.referrals.campaign-link.delete') }}" style="display:inline"
                    onsubmit="return confirm('Delete this campaign link?')">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="index" value="{{ $index }}">
                    <button type="submit" class="btn s d">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
          @if(empty($campaignLinks))
            <tr>
              <td colspan="6" class="em">No campaign links</td>
            </tr>
          @endif
        </tbody>
      </table>
    </details>
  </div>

  <div class="pager">
    <div>Showing {{ $referrals->firstItem() ?? 0 }}-{{ $referrals->lastItem() ?? 0 }} of {{ $referrals->total() }}</div>
    <div>{{ $referrals->appends(request()->query())->links() }}</div>
  </div>
@endsection