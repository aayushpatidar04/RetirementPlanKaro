@extends('admin.layout')
@section('title', 'Messages & Email')

@push('styles')
  <style>
    /* Tabs */
    .stab {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin: 0 0 16px;
    }

    .stab button {
      padding: 6px 14px;
      border-radius: 99px;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--mut);
      font-weight: 600;
      cursor: pointer;
    }

    .stab button.on {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri);
    }

    /* Message sections */
    .ms-sec {
      padding: 16px;
      border-bottom: 1px solid var(--line);
    }

    .ms-sec:last-child {
      border: 0;
    }

    .ms-h {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
      font-size: 14.5px;
      margin-bottom: 10px;
    }

    .ms-h i {
      font-style: normal;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: var(--pri);
      color: #fff;
      display: grid;
      place-items: center;
      font-size: 12.5px;
    }

    .ms-h small {
      font-weight: 500;
      color: var(--mut);
    }

    .ms-row {
      display: flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
    }

    .ms-sec select,
    .ms-sec input[type="text"],
    .ms-sec textarea {
      font: inherit;
      width: 100%;
      padding: 9px 11px;
      border: 1px solid var(--line);
      border-radius: 9px;
      background: var(--bg);
      color: var(--ink);
    }

    .ms-sec select {
      width: auto;
      min-width: 240px;
      font-weight: 600;
    }

    .ms-sec textarea {
      line-height: 1.55;
      resize: vertical;
    }

    /* Recipient list */
    .ms-list {
      max-height: 270px;
      overflow: auto;
      border: 1px solid var(--line);
      border-radius: 10px;
      margin-top: 10px;
    }

    .ms-list table {
      min-width: 0;
    }

    .ms-list td,
    .ms-list th {
      padding: 7px 12px;
    }

    .ms-list th {
      position: sticky;
      top: 0;
    }

    .ms-list th:first-child,
    .ms-list td:first-child {
      width: 34px;
      padding-right: 0;
    }

    /* Add new recipients */
    .ms-add {
      margin-top: 14px;
      padding: 12px;
      border: 1.5px dashed var(--line);
      border-radius: 10px;
      background: color-mix(in srgb, var(--pri-s) 35%, var(--card));
    }

    .ms-add b {
      display: block;
      margin-bottom: 6px;
    }

    .ms-chips {
      margin-top: 8px;
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      min-height: 4px;
    }

    .ms-note {
      color: var(--mut);
      font-size: 12.5px;
      margin-top: 6px;
    }

    /* Bottom bar */
    .ms-bar {
      position: sticky;
      bottom: 0;
      display: flex;
      gap: 12px;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 14px 16px;
      background: var(--card);
      border-top: 1px solid var(--line);
    }

    /* Template page */
    .tbs {
      display: flex;
      gap: 6px;
      margin-bottom: 12px;
      flex-wrap: wrap;
    }

    .tbs button {
      font: inherit;
      font-weight: 600;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--mut);
      padding: 6px 14px;
      border-radius: 99px;
      cursor: pointer;
    }

    .tbs button.on {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri);
    }

    .tp {
      display: grid;
      grid-template-columns: 300px 1fr;
      gap: 12px;
    }

    .tl2 {
      max-height: 62vh;
      overflow: auto;
    }

    .tli {
      padding: 9px 14px;
      border-bottom: 1px solid var(--line);
      cursor: pointer;
    }

    .tli small {
      display: block;
      color: var(--mut);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .tli.on,
    .tli:hover {
      background: var(--pri-s);
    }

    @media (max-width: 800px) {
      .tp {
        grid-template-columns: 1fr;
      }
    }

    /* Pills for badges */
    .pill {
      display: inline-block;
      padding: 2px 9px;
      border-radius: 99px;
      font-size: 12px;
      font-weight: 700;
      background: var(--bg);
      color: var(--mut);
    }

    .pill.ok {
      background: var(--ok-s);
      color: var(--ok);
    }

    .pill.bad {
      background: var(--bad-s);
      color: var(--bad);
    }

    .pill.warn {
      background: var(--warn-s);
      color: var(--warn);
    }

    .pill.pri {
      background: var(--pri-s);
      color: var(--pri);
    }

    /* Chip for added recipients */
    .chip {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 2px 8px;
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: 99px;
      font-size: 12px;
    }

    .chip button {
      background: none;
      border: 0;
      color: var(--bad);
      cursor: pointer;
      padding: 0;
      line-height: 1;
      font-size: 14px;
    }

    /* Card */
    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      margin-bottom: 14px;
      overflow: hidden;
    }

    .card>h3 {
      margin: 0;
      padding: 12px 16px;
      font-size: 14.5px;
      border-bottom: 1px solid var(--line);
    }

    .bar {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-bottom: 12px;
      flex-wrap: wrap;
    }

    .pg {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 12px;
      padding: 16px;
    }

    .pg label {
      font-size: 12.5px;
      color: var(--mut);
      font-weight: 600;
    }

    .in {
      font: inherit;
      width: 100%;
      margin-top: 3px;
      padding: 8px 10px;
      border: 1px solid var(--line);
      border-radius: 8px;
      background: var(--bg);
      color: var(--ink);
    }

    .row {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .ac {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      margin-top: 14px;
      flex-wrap: wrap;
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
      text-decoration: none;
    }

    .btn:hover {
      background: var(--bg);
    }

    .btn.p {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri);
    }

    .btn.p:hover {
      background: color-mix(in srgb, var(--pri) 85%, #000);
    }

    .btn.d {
      color: var(--bad);
    }

    .btn.s {
      padding: 4px 9px;
      font-size: 12.5px;
    }

    .btn.wa {
      background: #25d366;
      color: #fff;
      border-color: #25d366;
    }

    .btn.lg {
      padding: 11px 20px;
      font-size: 15px;
      border-radius: 10px;
    }

    .btn.link {
      border: 0;
      background: none;
      color: var(--pri);
      padding: 4px 6px;
      font-weight: 600;
    }

    .sc {
      overflow-x: auto;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      min-width: 560px;
      font-size: 13px;
    }

    th,
    td {
      text-align: left;
      padding: 9px 14px;
      border-bottom: 1px solid var(--line);
      white-space: nowrap;
    }

    th {
      color: var(--mut);
      font-size: 12.5px;
      font-weight: 600;
      background: color-mix(in srgb, var(--bg) 60%, var(--card));
    }

    tr:last-child td {
      border: 0;
    }

    /* Toggle buttons */
    .tbs button {
      font: inherit;
      font-weight: 600;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--mut);
      padding: 6px 14px;
      border-radius: 99px;
      cursor: pointer;
    }

    .tbs button.on {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri);
    }

    /* Adv details */
    details.adv {
      border-top: 1px solid var(--line);
    }

    details.adv summary {
      padding: 11px 16px;
      cursor: pointer;
      font-weight: 600;
      color: var(--pri);
    }

    details.adv .pg {
      padding-top: 4px;
    }

    /* Toast */
    .tt {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--ink);
      color: var(--bg);
      padding: 10px 16px;
      border-radius: 10px;
      z-index: 60;
      display: none;
      font-weight: 600;
    }

    .tt.o {
      display: block;
    }

    /* Overlay for modals */
    .ov {
      position: fixed;
      inset: 0;
      background: rgba(10, 12, 30, 0.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 200;
      padding: 16px;
    }

    .ov.o {
      display: flex;
    }

    .mo {
      background: var(--card);
      border-radius: 14px;
      width: min(600px, 98vw);
      max-height: 90vh;
      overflow: auto;
      padding: 20px;
    }

    .mo h3 {
      margin: 0 0 12px;
    }

    .fg {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }

    .fg .w {
      grid-column: 1/-1;
    }

    .fg label {
      display: block;
      font-size: 12.5px;
      color: var(--mut);
      font-weight: 600;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
  <script>
    const PAL = [["1F4E9E", "E3ECFA"], ["0F7A3D", "E1F5E9"], ["B45309", "FDEFD8"], ["6D28D9", "EDE5FC"], ["BE123C", "FCE4EA"], ["0E7490", "DAF2F7"]];

    // ExcelJS export helper
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

    // Toast
    function toast(msg) {
      const t = document.getElementById('tt');
      t.textContent = msg;
      t.classList.add('o');
      setTimeout(() => t.classList.remove('o'), 2500);
    }

    // Modal helper
    function openModal(title, html, onSubmit) {
      const ov = document.createElement('div');
      ov.className = 'ov';
      ov.innerHTML = `<div class="mo"><h3>${title}</h3><form>${html}<div class="ac"><button type="button" class="btn" onclick="this.closest('.ov').remove()">Cancel</button><button type="submit" class="btn p">Save</button></div></form></div>`;
      document.body.appendChild(ov);
      ov.classList.add('o');
      ov.querySelector('form').onsubmit = (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        const data = {}; fd.forEach((v, k) => data[k] = v);
        onSubmit(data, ov);
      };
    }

    // ===== STATE =====
    const MS = {
      tab: '{{ $tab }}',           // send, act, tpl
      ch: '{{ $channel }}',        // wa, em
      seg: 'all',
      off: new Set(),
      sent: {},
      k: -1,                       // selected template index
      raw: '',
      text: '',
      sub: '',
      fixed: [],
    };

    @php
        $templates = $waTemplates
            ->concat($emTemplates)
            ->map(fn ($t) => [
                'id' => $t->id,
                'n' => $t->name,
                'ch' => $t->channel,
                'sub' => $t->subject,
                't' => $t->body,
            ])
            ->values()
            ->all();
    @endphp

    const CT = @json($templates);
    const USERS = @json($users);
    const LSTAGES = @json($leadStages);
    const STAGE_MAPPING = @json($stageMapping);

    // ===== RENDER =====
    function render() {
      const m = document.getElementById('m');
      if (!m) return;
      m.innerHTML = renderTabs() + (MS.tab === 'send' ? renderSend() : MS.tab === 'act' ? renderAct() : renderTemplates());
      bindSend();
      if (MS.tab === 'tpl') bindTemplates();
      if (MS.tab === 'act') bindActivity();
    }

    function renderTabs() {
      const tabs = [['send', 'Send'], ['act', 'Activity'], ['tpl', 'Templates']];
      let d = 0;
      @if($scheduled->where('done', false)->where('scheduled_at', '<=', now())->count())
        d = {{ $scheduled->where('done', false)->where('scheduled_at', '<=', now())->count() }};
      @endif
        return `<div class="stab">${tabs.map((t, i) => `<button data-a="mstab" data-i="${i}" class="${MS.tab === t[0] ? 'on' : ''}">${t[1]}${t[0] === 'act' && d ? ` <span class="pill bad">${d}</span>` : ''}</button>`).join('')}</div>`;
    }

    // ===== SEND TAB =====
    function renderSend() {
      const wa = MS.ch === 'wa';
      const ts = CT.map((c, i) => [c, i]).filter(x => x[0].ch === MS.ch);
      const R = msRecips();
      return `
          <div class="card" style="margin:0">
            <div class="ms-sec"><div class="ms-h"><i>1</i>Send through</div><div class="tbs" style="margin:0">
              <button data-a="msch" data-i="0" class="${wa ? 'on' : ''}">WhatsApp</button>
              <button data-a="msch" data-i="1" class="${!wa ? 'on' : ''}">Email</button>
            </div></div>
            <div class="ms-sec"><div class="ms-h"><i>2</i>Who gets it? <small>Tick or untick people · or add new numbers / emails</small></div>
              <div class="ms-row">
                <select id="ms-seg">${Object.keys(SEGS).map(seg => `<option value="${seg}" ${MS.seg === seg ? 'selected' : ''}>${seg}</option>`).join('')}${MS.fixed.length ? `<optgroup label="Other"><option value="__fixed" ${MS.seg === '__fixed' ? 'selected' : ''}>Leads you filtered (${MS.fixed.length})</option></optgroup>` : ''}<optgroup label="By lead stage">${LSTAGES.map(s => `<option value="stage_${s}" ${MS.seg === 'stage_' + s ? 'selected' : ''}>Stage · ${s}</option>`).join('')}</optgroup><optgroup label="Other"><option value="new_only" ${MS.seg === 'new_only' ? 'selected' : ''}>Only new numbers / emails</option></optgroup></select>
                <button class="btn s" data-a="msall" data-i="1">Select all</button>
                <button class="btn s" data-a="msall" data-i="0">Select none</button>
              </div>
              <div class="ms-list sc" id="ms-list">${msList()}</div>
              <div class="ms-add"><b>Add new ${wa ? 'numbers' : 'emails'} <span style="font-weight:500;color:var(--mut)">(people not in the portal yet)</span></b>
                <textarea id="ms-raw" rows="3" placeholder="${wa ? '9876543210, 9123456789 — or one per line' : 'name@gmail.com, other@yahoo.com — or one per line'}">${MS.raw}</textarea>
                <div class="ms-chips" id="ms-chips">${msChips()}</div>
                <div class="ms-note">You can paste ${wa ? 'numbers' : 'email IDs'} in any format. They get this message too — they are not saved as customers.</div>
              </div></div>
            <div class="ms-sec"><div class="ms-h"><i>3</i>Message</div>
              <div class="ms-row" style="margin-bottom:10px">
                <select id="ms-tpl"><option value="-1" ${MS.k < 0 ? 'selected' : ''}>Write my own message</option>${ts.map(x => `<option value="${x[1]}" ${x[1] === MS.k ? 'selected' : ''}>${x[0].n}</option>`).join('')}</select>
              </div>
              ${!wa ? `<input type="text" id="ms-sub" placeholder="Email subject" value="${MS.sub}" style="margin-bottom:10px">` : ''}
              <textarea id="ms-text" rows="${wa ? 7 : 11}" placeholder="Type your message here…">${MS.text}</textarea>
              <div class="ms-note">${wa ? '<b>Friend</b> is replaced by each customer\'s first name. WhatsApp opens one chat at a time — press <b>Send next</b> for each person.' : 'Email goes to everyone in BCC (they cannot see each other). Gmail opens 30 people at a time.'}</div>
            </div>
            <div class="ms-bar" id="ms-bar">${msBar()}</div>
          </div>
        `;
    }

    // Recipient segments
    const SEGS = {
      'all': 'All customers',
      'paid': 'Paid customers',
      'unpaid': 'Unpaid / failed',
      'wallet': 'Wallet users',
      'leads': 'Leads (signed up only)',
    };

    function msBase() {
      const wa = MS.ch === 'wa';
      if (MS.seg === '__fixed') return MS.fixed.map(id => USERS.find(u => u.id == id)).filter(Boolean);
      if (MS.seg === 'new_only') return [];
      if (MS.seg.startsWith('stage_')) return USERS.filter(u => u.stage === MS.seg.replace('stage_', ''));
      let list = USERS;
      if (MS.seg === 'paid') list = list.filter(u => u.stage === 'Paid report' || u.stage === 'Wallet active');
      if (MS.seg === 'unpaid') list = list.filter(u => u.stage === 'Payment failed' || u.stage === 'Payment pending');
      if (MS.seg === 'wallet') list = list.filter(u => u.stage === 'Wallet active');
      if (MS.seg === 'leads') list = list.filter(u => u.stage === 'Signed up');
      return list;
    }

    function msRecips() {
      const wa = MS.ch === 'wa';
      const base = msBase();
      const list = base.filter(u => {
        const val = wa ? (u.mobile || '') : (u.email || '');
        return val && !MS.off.has(u.id);
      });
      const bad = base.filter(u => {
        const val = wa ? (u.mobile || '') : (u.email || '');
        return !val && !MS.off.has(u.id);
      });
      const rows = list.map(u => ({
        u, name: u.name, mobile: u.mobile, email: u.email, isNew: false, extra: false, bad: false, off: MS.off.has(u.id)
      }));
      const chips = MS.raw.split(/[\n,]+/).map(s => s.trim()).filter(Boolean);
      chips.forEach(c => {
        const val = wa ? c : c;
        const exists = list.some(u => (wa ? u.mobile : u.email) === val);
        if (!exists) rows.push({ u: null, name: wa ? '' : c.split('@')[0], mobile: wa ? val : '', email: wa ? '' : val, isNew: true, extra: true, bad: !val, off: false });
      });
      return { list: rows, base, bad };
    }

    function msList() {
      const R = msRecips(), wa = MS.ch === 'wa';
      if (!R.list.length) return '<div class="em">No recipients yet — choose a group above or add numbers below.</div>';
      return `<table><thead><tr><th></th><th>Name</th><th>${wa ? 'WhatsApp number' : 'Email ID'}</th><th></th></tr></thead><tbody>${R.list.map(r => `<tr><td>${r.extra ? '<span title="Added by you"></span>' : `<input type="checkbox" class="ms-chk" data-id="${r.u?.id}" ${r.off || r.bad ? '' : 'checked'} ${r.bad ? 'disabled' : ''}>`}</td><td>${r.name || '—'} ${r.isNew ? '<span class="pill pri">New</span>' : ''}</td><td>${r.bad ? '<span style="color:var(--bad)">' + (wa ? 'no valid number' : 'no valid email') + '</span>' : (wa ? r.mobile : r.email)}</td><td>${MS.sent[msKey(r)] ? '<span class="pill ok">Sent</span>' : ''}</td></tr>`).join('')}</tbody></table>`;
    }

    function msKey(r) { return (r.u?.id || 'new') + '|' + (MS.ch === 'wa' ? (r.mobile || '') : (r.email || '')); }

    function msChips() {
      const wa = MS.ch === 'wa';
      return MS.raw.split(/[\n,]+/).map(s => s.trim()).filter(Boolean).map(v => `<span class="chip">${wa ? v : v} <button data-remove-chip="${v}">×</button></span>`).join('');
    }

    function msBar() {
      const R = msRecips(), n = R.list.length, wa = MS.ch === 'wa';
      const left = R.list.filter(x => !MS.sent[msKey(x)]);
      const dis = !n || !MS.text.trim() || (!wa && !MS.sub.trim());
      const info = n ? `<b>${n}</b> ${wa ? 'WhatsApp numbers' : 'email IDs'} ready${n > left.length ? ` · <span style="color:var(--ok)">${n - left.length} sent</span>` : ''}` : '<span style="color:var(--mut)">Choose recipients to continue</span>';
      let btn;
      if (n && !left.length) btn = `<span class="pill ok">All ${n} done</span> <button class="btn" data-a="msreset">Send another</button>`;
      else if (wa) btn = `<button class="btn wa lg" data-a="msgo" ${dis ? 'disabled' : ''}>${left.length < n ? `Send next (${left.length} left)` : `Send on WhatsApp${n ? ' · ' + n : ''}`}</button>`;
      else btn = `<button class="btn p lg" data-a="msgo" ${dis ? 'disabled' : ''}>${left.length > 30 ? `Send to next 30 (${left.length} left)` : `Send Email${n ? ' · ' + n : ''}`}</button> <button class="btn link" data-a="msmail" ${dis ? 'disabled' : ''}>Use Mail app</button>`;
      return `<div>${info}</div><div class="row" style="align-items:center">${n ? `<button class="btn link" data-a="mscopy">Copy ${wa ? 'numbers' : 'emails'}</button>` : ''}${btn}</div>`;
    }

    // ===== ACTIVITY TAB =====
    function renderAct() {
      const pend = @json($scheduled->where('done', false));
      const lg = @json($logsQuery->items());
      let h = '';
      if (pend.length) {
        h += `<div class="card"><h3>Scheduled · ${pend.length} pending${pend.filter(x => new Date(x.scheduled_at) <= new Date()).length ? ` · ${pend.filter(x => new Date(x.scheduled_at) <= new Date()).length} due now` : ''}</h3><div class="sc">${renderTable(['Send at', 'Channel', 'To', 'Subject', 'Status', 'Action'], pend.map(x => [x.scheduled_at.replace('T', ' '), x.ch === 'wa' ? 'WhatsApp' : 'Email', x.recipient?.name || x.recipient?.mobile || x.recipient?.mail || '', x.subject || '', x.done ? '<span class="pill ok">Sent</span>' : new Date(x.scheduled_at) <= new Date() ? '<span class="pill bad">Due now</span>' : '<span class="pill warn">Scheduled</span>', x.done ? '' : `<div class="row"><button class="btn s p" data-a="ssend" data-i="${x.id}">Send now</button><button class="btn s d" data-a="sdel" data-i="${x.id}">Cancel</button></div>`]))}</div></div>`;
      }
      h += `<div class="card"><h3>Sent messages · ${lg.length}</h3><div class="sc">${renderTable(['Date', 'To', 'Channel', 'Subject', 'Status'], lg.map(c => [c.sent_at ? new Date(c.sent_at).toLocaleString('en-IN') : '', c.recipient?.name || c.recipient?.mobile || c.recipient?.email || '', c.ch === 'wa' ? '<span class="pill ok">WhatsApp</span>' : '<span class="pill pri">Email</span>', c.subject || '', `<span class="pill ${c.status === 'sent' ? 'ok' : 'bad'}">${c.status}</span>`]))}</div></div>`;
      return h;
    }

    function renderTable(head, rows) {
      if (!rows.length) return '<div class="em">No records</div>';
      return `<table><thead><tr>${head.map(h => `<th>${h}</th>`).join('')}</tr></thead><tbody>${rows.map(r => `<tr>${r.map(c => `<td>${c}</td>`).join('')}</tr>`).join('')}</tbody></table>`;
    }

    // ===== TEMPLATES TAB =====
    function renderTemplates() {
      const tabs = [['wa', 'WhatsApp Templates'], ['em', 'Email Templates'], ['sm', 'Lead-stage mapping']];
      let h = `<div class="tbs">${tabs.map((t, i) => `<button data-a="ttab" data-i="${i}" class="${TS.tab === t[0] ? 'on' : ''}">${t[1]}${t[0] !== 'sm' ? ' (' + CT.filter(c => c.ch === t[0]).length + ')' : ''}</button>`).join('')}</div>`;
      if (TS.tab === 'sm') {
        const sel = (ch, s) => `<select class="in" data-sm="${s}|${ch}" style="margin:0"><option value="">— None —</option>${CT.filter(c => c.ch === ch).map(c => `<option value="${c.id}" ${STAGE_MAPPING[s] && STAGE_MAPPING[s][ch] === c.id ? 'selected' : ''}>${c.n}</option>`).join('')}</select>`;
        h += `<div class="card"><h3>Default WhatsApp and email template for each prospect stage · shown as Recommended when sending</h3><div class="sc">${renderTable(['Lead stage', 'WhatsApp template', 'Email template'], LSTAGES.map(s => [s, sel('wa', s), sel('em', s)]))}</div></div>`;
        return h;
      }
      const L = CT.map((c, i) => [c, i]).filter(x => x[0].ch === TS.tab);
      if (!L.some(x => x[1] === TS.i)) TS.i = L.length ? L[0][1] : -1;
      const c = CT[TS.i];
      h += `<div class="tp"><div class="card" style="margin:0"><div class="bar"><button class="btn p s" data-a="tnew">+ New ${TS.tab === 'wa' ? 'WhatsApp' : 'Email'} template</button></div><div class="tl2">${L.map(x => `<div class="tli ${x[1] === TS.i ? 'on' : ''}" data-a="tsel" data-i="${x[1]}"><b>${x[0].n}</b>${x[0].ch === 'em' ? `<small>${x[0].sub || ''}</small>` : ''}</div>`).join('')}</div></div>`;
      if (c) {
        h += `<div class="card" style="margin:0"><div class="pg" style="grid-template-columns:1fr"><div><label>Template name<input class="in" id="tn" value="${c.n}"></label></div>${c.ch === 'em' ? `<div><label>Email subject<input class="in" id="ts" value="${c.sub || ''}"></label></div>` : ''}<div><label>Message<textarea class="in" id="tt" rows="${c.ch === 'em' ? 15 : 10}">${c.t}</textarea></label></div><div style="color:var(--mut);font-size:12.5px">Variables: {name} {link} {amount} {purpose} {date} {n} {names} {pts} {coupon} {type} {quote}</div><div class="row"><button class="btn p" data-a="tsave">Save</button><button class="btn" data-a="tdup">Duplicate</button><button class="btn d" data-a="tdel">Delete</button></div></div></div>`;
      }
      h += `</div>`;
      return h;
    }

    // ===== BINDINGS =====
    function bindSend() {
      const q = document.getElementById('ms-seg');
      if (q) q.onchange = e => { MS.seg = e.target.value; MS.off = new Set(); MS.sent = {}; render(); };
      const tpl = document.getElementById('ms-tpl');
      if (tpl) tpl.onchange = e => { msPick(+e.target.value); render(); };
      const raw = document.getElementById('ms-raw');
      if (raw) raw.oninput = e => { MS.raw = e.target.value; msRefresh(true); };
      const txt = document.getElementById('ms-text');
      if (txt) txt.oninput = e => { MS.text = e.target.value; msRefresh(); };
      const sub = document.getElementById('ms-sub');
      if (sub) sub.oninput = e => { MS.sub = e.target.value; msRefresh(); };
      document.querySelectorAll('.ms-chk').forEach(chk => {
        chk.onchange = e => { const id = +e.target.dataset.id; e.target.checked ? MS.off.delete(id) : MS.off.add(id); msRefresh(); };
      });
      document.querySelectorAll('[data-remove-chip]').forEach(btn => {
        btn.onclick = e => { MS.raw = MS.raw.split(/[\n,]+/).map(s => s.trim()).filter(v => v !== e.target.dataset.removeChip).join(', '); msRefresh(true); };
      });
    }

    function msRefresh(all) {
      const a = document.getElementById('ms-chips'), b = document.getElementById('ms-list'), c = document.getElementById('ms-bar');
      if (all) { if (a) a.innerHTML = msChips(); if (b) b.innerHTML = msList(); }
      if (c) c.innerHTML = msBar();
    }

    function msPick(i) {
      MS.k = i;
      if (i >= 0) {
        const c = CT[i];
        MS.text = c.t;
        if (c.ch === 'em') MS.sub = c.sub || '';
      }
    }

    // ===== TEMPLATE BINDINGS =====
    const TS = { tab: 'wa', i: 0 };
    function bindTemplates() {
      // tsel, ttab handled via global A
    }

    // ===== ACTIVITY BINDINGS =====
    function bindActivity() { }

    // ===== ACTIONS =====
    window.A = {
      mstab: (i) => { MS.tab = ['send', 'act', 'tpl'][i]; render(); },
      msch: (i) => { const c = i ? 'em' : 'wa'; if (c !== MS.ch) { MS.ch = c; MS.sent = {}; msPick(-1); } render(); },
      msall: (i) => { MS.off = new Set(i ? [] : msBase().map(u => u.id)); render(); },
      msreset: () => { MS.sent = {}; render(); },
      mscopy: () => { const R = msRecips(); navigator.clipboard?.writeText(R.list.map(r => MS.ch === 'wa' ? r.mobile : r.email).join(MS.ch === 'wa' ? '\n' : ', ')); toast('Copied ' + R.list.length); },
      msgo: async () => {
        const R = msRecips(), todo = R.list.filter(x => !MS.sent[msKey(x)]);
        if (!todo.length) return;
        const c = MS.k >= 0 ? CT[MS.k] : null, wa = MS.ch === 'wa', chn = wa ? 'WhatsApp' : 'Email', subj = wa ? (c ? c.n : 'Custom message') : MS.sub;
        if (wa) {
          const r = todo[0], t = msText(r);
          window.open('https://wa.me/91' + r.mobile + '?text=' + encodeURIComponent(t), '_blank');
          MS.sent[msKey(r)] = 1;
          logComm(r.u, chn, { mobile: r.mobile, email: r.email, name: r.name }, subj, t, 'Sent');
          toast('WhatsApp opened for ' + (r.name || r.mobile));
        } else {
          const b = todo.slice(0, 30);
          window.open('https://mail.google.com/mail/?view=cm&fs=1&bcc=' + encodeURIComponent(b.map(r => r.email).join(',')) + '&su=' + encodeURIComponent(subj) + '&body=' + encodeURIComponent(MS.text), '_blank');
          b.forEach(r => { MS.sent[msKey(r)] = 1; logComm(r.u, chn, { mobile: r.mobile, email: r.email, name: r.name }, subj, MS.text, 'Sent'); });
          toast('Gmail opened for ' + b.length + ' recipients');
        }
        msRefresh();
      },
      msmail: () => { const R = msRecips(), left = R.list.filter(x => !MS.sent[msKey(x)]); if (!left.length) return; navigator.clipboard?.writeText(left.map(r => r.email).join(', ')); toast('Copied ' + left.length + ' emails'); },
      // Template actions
      ttab: (i) => { TS.tab = ['wa', 'em', 'sm'][i]; render(); },
      tsel: (i) => { TS.i = i; render(); },
      tnew: () => {
        openModal('New ' + (TS.tab === 'wa' ? 'WhatsApp' : 'Email') + ' template', `<div class="fg"><div><label>Template name<input class="in" name="name" required></label></div>${TS.tab === 'em' ? `<div><label>Email subject<input class="in" name="subject"></label></div>` : ''}<div class="w"><label>Message<textarea class="in" name="body" rows="10" required></textarea></label></div></div>`, async (data, modal) => {
          const fd = new FormData(); fd.append('name', data.name); fd.append('channel', TS.tab); fd.append('body', data.body); if (data.subject) fd.append('subject', data.subject); fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
          const res = await fetch('{{ route("admin.messages.templates.store") }}', { method: 'POST', body: fd, credentials: 'same-origin' });
          if (res.ok) { modal.remove(); toast('Template created'); render(); } else { alert('Error creating template'); }
        });
      },
      tsave: () => {
        const c = CT[TS.i];
        const fd = new FormData(); fd.append('name', document.getElementById('tn').value); fd.append('body', document.getElementById('tt').value); const ts = document.getElementById('ts'); if (ts) fd.append('subject', ts.value); fd.append('_token', document.querySelector('meta[name="csrf-token"]').content); fd.append('_method', 'PUT');
        const url = '{{ route("admin.messages.templates.update", ["id" => "__ID__"]) }}'
            .replace('__ID__', c.id);

        fetch(url, {
            method: 'POST',
            body: fd,
            credentials: 'same-origin'
        }).then(r => {
            if (r.ok) {
                toast('Saved');
                render();
            } else {
                alert('Error saving');
            }
        });
      },
      tdup: () => {
        const c = CT[TS.i];
        const fd = new FormData(); fd.append('id', c.id); fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fetch('{{ route("admin.messages.templates.duplicate") }}', { method: 'POST', body: fd, credentials: 'same-origin' }).then(r => { if (r.ok) { toast('Duplicated'); render(); } else alert('Error'); });
      },
      tdel: () => {
        const c = CT[TS.i]; if (!confirm('Delete "' + c.n + '"?')) return;
        const fd = new FormData(); fd.append('id', c.id); fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fetch('{{ route("admin.messages.templates.delete") }}', { method: 'POST', body: fd, credentials: 'same-origin' }).then(r => { if (r.ok) { toast('Deleted'); render(); } else alert('Error'); });
      },
      // Stage mapping
      // Handled via change event on selects
      // Scheduled messages
      ssend: (id) => {
        const fd = new FormData(); fd.append('id', id); fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fetch('{{ route("admin.messages.scheduled.send") }}', { method: 'POST', body: fd, credentials: 'same-origin' }).then(r => { if (r.ok) { toast('Sent'); render(); } else alert('Error'); });
      },
      sdel: (id) => {
        if (!confirm('Cancel this scheduled message?')) return;
        const fd = new FormData(); fd.append('id', id); fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fetch('{{ route("admin.messages.scheduled.cancel") }}', { method: 'POST', body: fd, credentials: 'same-origin' }).then(r => { if (r.ok) { toast('Cancelled'); render(); } else alert('Error'); });
      },
      // Exports
      xlm: async () => {
        const params = new URLSearchParams(window.location.search);
        const res = await fetch('{{ route("admin.messages.export.logs") }}?' + params.toString(), { credentials: 'same-origin' });
        const data = await res.json();
        if (data.sheets) await xlsx(data.filename, data.sheets);
        else alert('Export failed');
      },
      xlt: async () => {
        const res = await fetch('{{ route("admin.messages.export.templates") }}', { credentials: 'same-origin' });
        const data = await res.json();
        if (data.sheets) await xlsx(data.filename, data.sheets);
        else alert('Export failed');
      },
    };

    // Stage mapping change handler
    document.addEventListener('change', e => {
      const m = e.target.dataset.sm;
      if (m) {
        const [s, ch] = m.split('|');
        const fd = new FormData(); fd.append('stage_mapping', JSON.stringify({ ...STAGE_MAPPING, [s]: { ...(STAGE_MAPPING[s] || {}), [ch]: e.target.value } })); fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fetch('{{ route("admin.messages.stage-mapping") }}', { method: 'POST', body: fd, credentials: 'same-origin' }).then(r => { if (r.ok) toast('Saved'); else alert('Error'); });
      }
    });

    // Log communication to server
    async function logComm(user, channel, recipient, subject, body, status) {
      const fd = new FormData();
      fd.append('channel', channel.toLowerCase().startsWith('w') ? 'wa' : 'em');
      fd.append('recipient', JSON.stringify(recipient));
      fd.append('subject', subject);
      fd.append('body', body);
      fd.append('status', status);
      fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
      if (user?.id) fd.append('user_id', user.id);
      await fetch('{{ route("admin.messages.send") }}', { method: 'POST', body: fd, credentials: 'same-origin' });
    }

    function msText(r) {
      let t = MS.text;
      const fn = (r.name || '').split(' ')[0] || 'Friend';
      t = t.replace(/{name}/g, r.name || '').replace(/{friend}/g, fn).replace(/{link}/g, 'https://retirementplankaro.com');
      return t;
    }

    // Delegated event handler for all data-a actions
    document.addEventListener('click', e => {
      const btn = e.target.closest('[data-a]');
      if (!btn) return;
      const action = btn.dataset.a;
      const arg = btn.dataset.i !== undefined ? +btn.dataset.i : btn.dataset.id;
      if (window.A && typeof window.A[action] === 'function') {
        window.A[action](arg);
      }
    });

    // Initial render
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', render);
    } else {
      render();
    }
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Messages & Email</h2>
      <div class="sub" style="margin:2px 0 0">Client communications · WhatsApp & Email</div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="stab" id="ms-tabs"></div>

  <!-- Main content -->
  <div id="m"></div>

  <div class="tt" id="tt"></div>
@endsection