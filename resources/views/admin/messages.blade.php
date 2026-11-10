@extends('admin.layout')
@section('title', 'Messages & Email')

@push('styles')
  <style>
    /* Everything is scoped under .msg so it can't leak into the rest of the admin panel */
    .msg .stab,
    .msg .tbs {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin: 0 0 16px;
    }

    .msg .stab a,
    .msg .tbs a {
      padding: 6px 14px;
      border-radius: 99px;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--mut);
      font-weight: 600;
      text-decoration: none;
    }

    .msg .stab a.on,
    .msg .tbs a.on {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri);
    }

    .msg .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      margin-bottom: 14px;
      overflow: hidden;
    }

    .msg .card>h3 {
      margin: 0;
      padding: 12px 16px;
      font-size: 14.5px;
      border-bottom: 1px solid var(--line);
    }

    .msg .bar {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-bottom: 12px;
      flex-wrap: wrap;
      padding: 12px 12px 0;
    }

    .msg .pg {
      display: grid;
      gap: 12px;
      padding: 16px;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    }

    .msg .pg label {
      font-size: 12.5px;
      color: var(--mut);
      font-weight: 600;
      display: block;
    }

    .msg .row {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      align-items: center;
    }

    .msg .ac {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      margin-top: 14px;
      flex-wrap: wrap;
    }

    .msg .em {
      color: var(--mut);
      padding: 20px;
      text-align: center;
    }

    .msg .alert {
      padding: 10px 14px;
      border-radius: 10px;
      margin-bottom: 12px;
      font-weight: 600;
    }

    .msg .alert.ok {
      background: var(--ok-s);
      color: var(--ok);
    }

    .msg .alert.bad {
      background: var(--bad-s);
      color: var(--bad);
    }

    .msg .in,
    .msg .ms-sec select,
    .msg .ms-sec input[type=text],
    .msg .ms-sec input[type=datetime-local],
    .msg .ms-sec textarea {
      font: inherit;
      width: 100%;
      padding: 9px 11px;
      border: 1px solid var(--line);
      border-radius: 9px;
      background: var(--bg);
      color: var(--ink);
    }

    .msg .ms-sec select {
      width: auto;
      min-width: 240px;
      font-weight: 600;
    }

    .msg .ms-sec input[type=datetime-local] {
      width: auto;
    }

    .msg .ms-sec textarea {
      line-height: 1.55;
      resize: vertical;
    }

    .msg .btn {
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

    .msg .btn:hover {
      background: var(--bg);
    }

    .msg .btn[disabled] {
      opacity: .5;
      cursor: not-allowed;
    }

    .msg .btn.p {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri);
    }

    .msg .btn.d {
      color: var(--bad);
    }

    .msg .btn.s {
      padding: 4px 9px;
      font-size: 12.5px;
    }

    .msg .btn.wa {
      background: #25d366;
      color: #fff;
      border-color: #25d366;
    }

    .msg .btn.lg {
      padding: 11px 20px;
      font-size: 15px;
      border-radius: 10px;
    }

    .msg .btn.link {
      border: 0;
      background: none;
      color: var(--pri);
      padding: 4px 6px;
    }

    .msg form.inline {
      display: inline;
      margin: 0;
    }

    .msg .ms-sec {
      padding: 16px;
      border-bottom: 1px solid var(--line);
    }

    .msg .ms-h {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
      font-size: 14.5px;
      margin-bottom: 10px;
      flex-wrap: wrap;
    }

    .msg .ms-h i {
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

    .msg .ms-h small {
      font-weight: 500;
      color: var(--mut);
    }

    .msg .ms-row {
      display: flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
    }

    .msg .ms-list {
      max-height: 270px;
      overflow: auto;
      border: 1px solid var(--line);
      border-radius: 10px;
      margin-top: 10px;
    }

    .msg .ms-list table {
      min-width: 0;
    }

    .msg .ms-list th {
      position: sticky;
      top: 0;
    }

    .msg .ms-list th:first-child,
    .msg .ms-list td:first-child {
      width: 34px;
      padding-right: 0;
    }

    .msg .ms-add {
      margin-top: 14px;
      padding: 12px;
      border: 1.5px dashed var(--line);
      border-radius: 10px;
      background: color-mix(in srgb, var(--pri-s) 35%, var(--card));
    }

    .msg .ms-add b {
      display: block;
      margin-bottom: 6px;
    }

    .msg .ms-chips {
      margin-top: 8px;
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      min-height: 4px;
    }

    .msg .ms-note {
      color: var(--mut);
      font-size: 12.5px;
      margin-top: 6px;
    }

    .msg .ms-bar {
      display: flex;
      gap: 12px;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 14px 16px;
      background: var(--card);
    }

    .msg .ms-bar .sched {
      display: flex;
      gap: 6px;
      align-items: center;
      flex-wrap: wrap;
    }

    .msg .chip {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 2px 8px;
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: 99px;
      font-size: 12px;
    }

    .msg .chip.bad {
      border-color: var(--bad);
      color: var(--bad);
    }

    .msg .chip button {
      background: none;
      border: 0;
      color: var(--bad);
      cursor: pointer;
      padding: 0;
      line-height: 1;
      font-size: 14px;
    }

    .msg .pill {
      display: inline-block;
      padding: 2px 9px;
      border-radius: 99px;
      font-size: 12px;
      font-weight: 700;
      background: var(--bg);
      color: var(--mut);
    }

    .msg .pill.ok {
      background: var(--ok-s);
      color: var(--ok);
    }

    .msg .pill.bad {
      background: var(--bad-s);
      color: var(--bad);
    }

    .msg .pill.warn {
      background: var(--warn-s);
      color: var(--warn);
    }

    .msg .pill.pri {
      background: var(--pri-s);
      color: var(--pri);
    }

    .msg .sc {
      overflow-x: auto;
    }

    .msg table {
      border-collapse: collapse;
      width: 100%;
      min-width: 560px;
      font-size: 13px;
    }

    .msg th,
    .msg td {
      text-align: left;
      padding: 9px 14px;
      border-bottom: 1px solid var(--line);
      white-space: nowrap;
    }

    .msg th {
      color: var(--mut);
      font-size: 12.5px;
      font-weight: 600;
      background: color-mix(in srgb, var(--bg) 60%, var(--card));
    }

    .msg tr:last-child td {
      border: 0;
    }

    .msg .tp {
      display: grid;
      grid-template-columns: 300px 1fr;
      gap: 12px;
      align-items: start;
    }

    .msg .tl2 {
      max-height: 62vh;
      overflow: auto;
    }

    .msg .tli {
      display: block;
      padding: 9px 14px;
      border-bottom: 1px solid var(--line);
      color: inherit;
      text-decoration: none;
    }

    .msg .tli small {
      display: block;
      color: var(--mut);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .msg .tli.on,
    .msg .tli:hover {
      background: var(--pri-s);
    }

    .msg .tt {
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

    .msg .tt.o {
      display: block;
    }

    @media (max-width:800px) {
      .msg .tp {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width:600px) {
      .msg .ms-sec select {
        width: 100%;
        min-width: 0;
      }
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
  <script>
    window.MSG = {
      csrf: @json(csrf_token()),
      sendUrl: @json(route('admin.messages.send')),
      scheduleUrl: @json(route('admin.messages.schedule')),
    };

    const PAL = [["1F4E9E", "E3ECFA"], ["0F7A3D", "E1F5E9"], ["B45309", "FDEFD8"], ["6D28D9", "EDE5FC"], ["BE123C", "FCE4EA"], ["0E7490", "DAF2F7"]];

    function toast(msg) {
      const t = document.getElementById('tt');
      t.textContent = msg;
      t.classList.add('o');
      clearTimeout(t._h);
      t._h = setTimeout(() => t.classList.remove('o'), 3000);
    }

    async function postJson(url, payload) {
      const res = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json', 'Accept': 'application/json',
          'X-CSRF-TOKEN': MSG.csrf, 'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload),
      });
      let json = {};
      try { json = await res.json(); } catch (_) { }
      if (!res.ok) {
        const first = json.errors ? Object.values(json.errors)[0][0] : (json.message || 'Request failed');
        throw new Error(first);
      }
      return json;
    }

    async function xlsx(file, sheets) {
      if (!window.ExcelJS) { toast('Excel library could not be loaded.'); return; }
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
        h.eachCell(k => {
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
      setTimeout(() => URL.revokeObjectURL(a.href), 1000);
    }

    // Export buttons: the routes return JSON, the browser builds the .xlsx
    document.addEventListener('click', async e => {
      const btn = e.target.closest('[data-export]');
      if (!btn) return;
      btn.disabled = true;
      try {
        const res = await fetch(btn.dataset.export, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
        if (!res.ok) throw new Error('Export failed');
        const j = await res.json();
        await xlsx(j.filename, j.sheets);
      } catch (err) { toast(err.message); }
      btn.disabled = false;
    });

    // Confirm dialogs (no inline JS with user data inside)
    document.addEventListener('click', e => {
      const el = e.target.closest('[data-confirm]');
      if (el && !confirm(el.dataset.confirm)) e.preventDefault();
    });

    // Scheduled "Send now": open WhatsApp/Gmail first (needs a real user gesture), then the form posts and logs
    document.addEventListener('submit', e => {
      const url = e.target.dataset.open;
      if (url) window.open(url, '_blank', 'noopener');
    });
  </script>
@endpush

@section('content')
  <div class="msg">
    <div class="hh">
      <div>
        <h2 style="margin:0">Messages & Email</h2>
        <div class="sub" style="margin:2px 0 0">Client communications · WhatsApp & Email</div>
      </div>
    </div>

    @if(session('ok'))
    <div class="alert ok">{{ session('ok') }}</div>@endif
    @if($errors->any())
    <div class="alert bad">{{ $errors->first() }}</div>@endif

    <div class="stab">
      <a href="{{ route('admin.messages', ['tab' => 'send', 'channel' => $channel]) }}"
        class="{{ $tab === 'send' ? 'on' : '' }}">Send</a>
      <a href="{{ route('admin.messages', ['tab' => 'act']) }}" class="{{ $tab === 'act' ? 'on' : '' }}">
        Activity @if($dueCount)<span class="pill bad">{{ $dueCount }}</span>@endif
      </a>
      <a href="{{ route('admin.messages', ['tab' => 'tpl']) }}" class="{{ $tab === 'tpl' ? 'on' : '' }}">Templates</a>
    </div>

    <div id="m">
      @if($tab === 'send')
        @include('admin.messages._send')
      @elseif($tab === 'act')
        @include('admin.messages._activity')
      @else
        @include('admin.messages._templates')
      @endif
    </div>

    <div class="tt" id="tt"></div>
  </div>
@endsection