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

    .stab button,
    .stab a {
      padding: 6px 14px;
      border-radius: 99px;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--mut);
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
    }

    .stab button.on,
    .stab a.on {
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

    .tbs button,
    .tbs a {
      font: inherit;
      font-weight: 600;
      border: 1px solid var(--line);
      background: var(--card);
      color: var(--mut);
      padding: 6px 14px;
      border-radius: 99px;
      cursor: pointer;
      text-decoration: none;
    }

    .tbs button.on,
    .tbs a.on {
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

    .em {
      color: var(--mut);
      padding: 20px;
      text-align: center;
    }

    /* Form inline */
    form.inline {
      display: inline;
    }

    /* Segment select full width on mobile */
    @media (max-width: 600px) {
      #ms-seg {
        width: 100%;
        min-width: 0;
      }
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

    // Add chip removal handlers
    document.addEventListener('click', e => {
      if (e.target.matches('[data-remove-chip]')) {
        const v = e.target.dataset.removeChip;
        const raw = document.getElementById('ms-raw');
        if (raw) {
          raw.value = raw.value.split(/[\n,]+/).map(s => s.trim()).filter(x => x !== v).join(', ');
          raw.dispatchEvent(new Event('input'));
        }
      }
    });

    // Checkbox handlers for recipient selection
    document.addEventListener('change', e => {
      if (e.target.matches('.ms-chk')) {
        const form = e.target.closest('form');
        if (form) form.submit();
      }
    });

    // Segment change handler
    document.addEventListener('change', e => {
      if (e.target.matches('#ms-seg')) {
        e.target.closest('form').submit();
      }
    });

    // Template select change
    document.addEventListener('change', e => {
      if (e.target.matches('#ms-tpl')) {
        const idx = +e.target.value;
        if (idx >= 0 && window.CT && CT[idx]) {
          const c = CT[idx];
          document.getElementById('ms-text').value = c.t;
          if (c.ch === 'em') {
            const sub = document.getElementById('ms-sub');
            if (sub) sub.value = c.sub || '';
          }
        }
      }
    });

    // Stage mapping change
    document.addEventListener('change', e => {
      if (e.target.matches('[data-sm]')) {
        const form = e.target.closest('form');
        if (form) form.submit();
      }
    });

    // Handle "Select all/none" buttons
    document.addEventListener('click', e => {
      if (e.target.matches('[data-msall]')) {
        const selectAll = e.target.dataset.msall === '1';
        document.querySelectorAll('.ms-chk').forEach(chk => {
          if (!chk.disabled) chk.checked = selectAll;
        });
        // Trigger change on first checkbox to submit form
        const first = document.querySelector('.ms-chk:not(:disabled)');
        if (first) first.dispatchEvent(new Event('change'));
      }
    });
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Messages & Email</h2>
      <div class="sub" style="margin:2px 0 0">Client communications · WhatsApp & Email</div>
    </div>
  </div>

  @php
    // Build users array with computed fields for Blade
    $wa = $channel === 'wa';
    $seg = request()->query('segment', 'all');
    $fixed = request()->query('fixed') ? json_decode(request()->query('fixed'), true) : [];

    // Build base recipient list
    function buildBaseList($users, $seg, $fixed)
    {
      if ($seg === '__fixed') {
        return $users->whereIn('id', $fixed)->values();
      }
      if ($seg === 'new_only') {
        return collect();
      }
      if (Str::startsWith($seg, 'stage_')) {
        return $users->where('stage', Str::after($seg, 'stage_'))->values();
      }
      $list = $users;
      if ($seg === 'paid')
        $list = $list->whereIn('stage', ['Paid report', 'Wallet active']);
      if ($seg === 'unpaid')
        $list = $list->whereIn('stage', ['Payment failed', 'Payment pending']);
      if ($seg === 'wallet')
        $list = $list->where('stage', 'Wallet active');
      if ($seg === 'leads')
        $list = $list->where('stage', 'Signed up');
      return $list->values();
    }

    $baseUsers = buildBaseList($users, $seg, $fixed);

    // Filter by channel (must have mobile/email)
    $hasContact = $wa ? 'mobile' : 'email';
    $validUsers = $baseUsers->filter(fn($u) => !empty($u->{$hasContact}));

    // Build raw extras
    $raw = request()->query('raw', '');
    $chips = array_filter(array_map('trim', preg_split('/[\n,]+/', $raw)));
    $extras = collect();
    foreach ($chips as $chip) {
      $val = $wa ? $chip : $chip;
      $exists = $validUsers->contains(fn($u) => $wa ? $u->mobile === $val : $u->email === $val);
      if (!$exists) {
        $extras->push([
          'name' => $wa ? '' : (str_contains($val, '@') ? explode('@', $val)[0] : $val),
          'mobile' => $wa ? $val : '',
          'email' => $wa ? '' : $val,
          'isNew' => true,
          'extra' => true,
          'bad' => !$val,
        ]);
      }
    }

    // Combine
    $recipients = $validUsers->map(function ($u) {
      return [
        'u' => $u,
        'name' => $u->name,
        'mobile' => $u->mobile,
        'email' => $u->email,
        'isNew' => false,
        'extra' => false,
        'bad' => false,
        'off' => false,
      ];
    })->concat($extras)->values();

    // Sent tracking from query
    $sentIds = request()->query('sent', []);
    if (is_string($sentIds))
      $sentIds = json_decode($sentIds, true) ?? [];
    $sentKey = fn($r) => ($r['u']->id ?? 'new') . '|' . ($wa ? ($r['mobile'] ?? '') : ($r['email'] ?? ''));
    $sentCount = 0;
    foreach ($recipients as $r) {
      if (in_array($sentKey($r), $sentIds))
        $sentCount++;
    }
    $leftCount = count($recipients) - $sentCount;
  @endphp

  <!-- Tabs -->
  <div class="stab">
    <a href="{{ route('admin.messages', array_merge(
    ['tab' => 'send', 'channel' => $channel],
    request()->except(['tab', 'channel'])
  )) }}" class="{{ $tab === 'send' ? 'on' : '' }}">
      Send
    </a>

    <a href="{{ route('admin.messages', array_merge(
    ['tab' => 'act', 'channel' => $channel],
    request()->except(['tab', 'channel'])
  )) }}" class="{{ $tab === 'act' ? 'on' : '' }}">
      Activity
      {!! $scheduled->where('done', false)->where('scheduled_at', '<=', now())->count()
    ? '<span class="pill bad">' . $scheduled->where('done', false)->where('scheduled_at', '<=', now())->count() . '</span>'
    : '' !!}
    </a>

    <a href="{{ route('admin.messages', array_merge(
    ['tab' => 'tpl', 'channel' => $channel],
    request()->except(['tab', 'channel'])
  )) }}" class="{{ $tab === 'tpl' ? 'on' : '' }}">
      Templates
    </a>
  </div>

  <div id="m">
    @if($tab === 'send')
      @include('admin.messages._send')
    @elseif($tab === 'act')
      @include('admin.messages._activity')
    @elseif($tab === 'tpl')
      @include('admin.messages._templates')
    @endif
  </div>

  <div class="tt" id="tt"></div>
@endsection