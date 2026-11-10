@extends('admin.layout')
@section('title', 'Investment Partners')

@php
  // Data for the Edit modal. Passed to JS with @json so it is escaped correctly,
  // instead of being pasted into an inline onclick="" attribute.
  $partnerData = $partners->mapWithKeys(fn($p) => [$p->id => [
      'id' => $p->id,
      'label' => $p->label,
      'category' => $p->category,
      'partner' => $p->partner,
      'url' => $p->url,
      'is_active' => (bool) $p->is_active,
  ]]);
@endphp

@push('styles')
<style>
  /* Scoped under .ip so it can't leak into the rest of the admin panel */
  .ip .sc { overflow-x: auto; }
  .ip table { border-collapse: collapse; width: 100%; min-width: 720px; font-size: 13px; }
  .ip th, .ip td { text-align: left; padding: 9px 14px; border-bottom: 1px solid var(--line); white-space: nowrap; }
  .ip th { color: var(--mut); font-size: 12.5px; font-weight: 600; background: color-mix(in srgb, var(--bg) 60%, var(--card)); }
  .ip tr:last-child td { border: 0; }

  .ip .card { background: var(--card); border: 1px solid var(--line); border-radius: 12px; margin-bottom: 14px; overflow: hidden; }
  .ip .card > h3 { margin: 0; padding: 12px 16px; font-size: 14.5px; border-bottom: 1px solid var(--line); }
  .ip .bar { display: flex; gap: 10px; align-items: center; margin-bottom: 12px; flex-wrap: wrap; }
  .ip .row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
  .ip .ac { display: flex; gap: 8px; justify-content: flex-end; margin-top: 14px; flex-wrap: wrap; }
  .ip .em { color: var(--mut); padding: 20px; text-align: center; }
  .ip form.inline { display: inline; margin: 0; }
  .ip .alert { padding: 10px 14px; border-radius: 10px; margin-bottom: 12px; font-weight: 600; }
  .ip .alert.ok { background: var(--ok-s); color: var(--ok); }
  .ip .alert.bad { background: var(--bad-s); color: var(--bad); }

  .ip .in { font: inherit; width: 100%; margin-top: 3px; padding: 8px 10px; border: 1px solid var(--line); border-radius: 8px; background: var(--bg); color: var(--ink); }
  .ip .in:focus, .ov .in:focus { outline: none; border-color: var(--pri); }

  .ip .btn, .ov .btn { display: inline-flex; align-items: center; gap: 6px; font-family: inherit; font-weight: 600; padding: 7px 12px; border-radius: 8px; border: 1px solid var(--line); background: var(--card); color: var(--ink); cursor: pointer; font-size: 13px; text-decoration: none; }
  .ip .btn:hover, .ov .btn:hover { background: var(--bg); }
  .ip .btn[disabled], .ov .btn[disabled] { opacity: .45; cursor: not-allowed; }
  .ip .btn.p, .ov .btn.p { background: var(--pri); color: #fff; border-color: var(--pri); }
  .ip .btn.d { color: var(--bad); }
  .ip .btn.s { padding: 4px 9px; font-size: 12.5px; }

  .ip .pill { display: inline-block; padding: 2px 9px; border-radius: 99px; font-size: 12px; font-weight: 700; background: var(--bg); color: var(--mut); }

  .ip .url-cell { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
  .ip .url-cell a { color: var(--pri); text-decoration: none; }
  .ip .url-cell a:hover { text-decoration: underline; }

  /* toggle switch */
  .toggle-wrap { display: flex; align-items: center; gap: 8px; }
  .toggle-wrap input[type=checkbox] { -webkit-appearance: none; appearance: none; width: 36px; height: 20px; border-radius: 99px; background: var(--line); position: relative; cursor: pointer; transition: background .2s; flex: none; margin: 0; }
  .toggle-wrap input[type=checkbox]:checked { background: var(--pri); }
  .toggle-wrap input[type=checkbox]::after { content: ''; position: absolute; top: 2px; left: 2px; width: 16px; height: 16px; border-radius: 50%; background: #fff; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
  .toggle-wrap input[type=checkbox]:checked::after { transform: translateX(16px); }

  /* modal (lives on <body>, so not scoped under .ip) */
  .ov { position: fixed; inset: 0; background: rgba(10,12,30,.5); display: flex; align-items: center; justify-content: center; z-index: 200; padding: 16px; }
  .mo { background: var(--card); color: var(--ink); border-radius: 14px; width: min(600px, 98vw); max-height: 90vh; overflow: auto; padding: 20px; }
  .mo h3 { margin: 0 0 12px; }
  .mo .in { font: inherit; width: 100%; margin-top: 3px; padding: 8px 10px; border: 1px solid var(--line); border-radius: 8px; background: var(--bg); color: var(--ink); }
  .mo .ac { display: flex; gap: 8px; justify-content: flex-end; margin-top: 14px; }
  .mo .err { color: var(--bad); font-weight: 600; font-size: 13px; margin-top: 10px; }
  .fg { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .fg .w { grid-column: 1 / -1; }
  .fg label { display: block; font-size: 12.5px; color: var(--mut); font-weight: 600; }
  .fg label.toggle-wrap { display: flex; }

  .tt { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: var(--ink); color: var(--bg); padding: 10px 16px; border-radius: 10px; z-index: 300; display: none; font-weight: 600; }
  .tt.o { display: block; }

  @media (max-width: 600px) { .fg { grid-template-columns: 1fr; } }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
<script>
  const IP = {
    csrf: @json(csrf_token()),
    storeUrl: @json(route('admin.investment-partners.store')),
    updateUrl: @json(route('admin.investment-partners.update', '__ID__')),
    partners: @json($partnerData),
  };

  const PAL = [["1F4E9E","E3ECFA"],["0F7A3D","E1F5E9"],["B45309","FDEFD8"],["6D28D9","EDE5FC"],["BE123C","FCE4EA"],["0E7490","DAF2F7"]];

  const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

  function toast(msg) {
    const t = document.getElementById('tt');
    t.textContent = msg;
    t.classList.add('o');
    clearTimeout(t._h);
    t._h = setTimeout(() => t.classList.remove('o'), 2500);
  }

  /* ---------- ExcelJS export ---------- */
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
    setTimeout(() => URL.revokeObjectURL(a.href), 1000);
  }

  /* ---------- modal ---------- */
  function openModal(title, bodyHtml, onSubmit) {
    const ov = document.createElement('div');
    ov.className = 'ov';
    ov.innerHTML = `<div class="mo"><h3>${esc(title)}</h3><form novalidate>${bodyHtml}<div class="err" hidden></div>
      <div class="ac"><button type="button" class="btn" data-close>Cancel</button><button type="submit" class="btn p">Save</button></div></form></div>`;
    document.body.appendChild(ov);

    const form = ov.querySelector('form');
    const err = ov.querySelector('.err');
    const close = () => ov.remove();
    ov.addEventListener('click', e => { if (e.target === ov || e.target.hasAttribute('data-close')) close(); });
    form.addEventListener('submit', async e => {
      e.preventDefault();
      if (!form.reportValidity()) return;
      const btn = form.querySelector('button[type=submit]');
      btn.disabled = true; err.hidden = true;
      try {
        await onSubmit(form, close);
      } catch (ex) {
        err.textContent = ex.message || 'Something went wrong';
        err.hidden = false;
        btn.disabled = false;
      }
    });
    form.querySelector('textarea, input')?.focus();
  }

  function partnerFields(p) {
    return `<div class="fg">
      <div class="w"><label>Investment type text (customer sees this)<textarea class="in" name="label" rows="3" required>${esc(p.label)}</textarea></label></div>
      <div><label>Category<input class="in" name="category" value="${esc(p.category)}"></label></div>
      <div><label>Partner name<input class="in" name="partner" value="${esc(p.partner)}"></label></div>
      <div class="w"><label>Referral link (must start with https://)<input class="in" type="url" name="url" pattern="https://.+" value="${esc(p.url)}" required></label></div>
      <div class="w"><label class="toggle-wrap"><input type="checkbox" name="is_active" ${p.is_active ? 'checked' : ''}> Show on website</label></div>
    </div>`;
  }

  function openPartnerModal(p) {
    const edit = !!p;
    const cur = p || { label: '', category: 'Other', partner: '', url: '', is_active: true };

    openModal(edit ? 'Edit investment option' : 'Add investment option', partnerFields(cur), async (form, close) => {
      const f = form.elements;
      const fd = new FormData();
      fd.append('_token', IP.csrf);
      if (edit) fd.append('_method', 'PUT');          // multipart PUT isn't parsed by PHP, so spoof it over POST
      fd.append('label', f.label.value.trim());
      fd.append('category', f.category.value.trim() || 'Other');
      fd.append('partner', f.partner.value.trim());
      fd.append('url', f.url.value.trim());
      if (f.is_active.checked) fd.append('is_active', '1');   // unchecked => omitted => false

      const res = await fetch(edit ? IP.updateUrl.replace('__ID__', cur.id) : IP.storeUrl, {
        method: 'POST', body: fd, credentials: 'same-origin',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      });
      if (!res.ok) {
        let msg = 'Error saving';
        try { const j = await res.json(); msg = j.errors ? Object.values(j.errors)[0][0] : (j.message || msg); } catch (_) {}
        throw new Error(msg);
      }
      close();
      toast(edit ? 'Saved' : 'Investment partner added');
      setTimeout(() => location.reload(), 300);
    });
  }

  /* ---------- page events ---------- */
  document.addEventListener('click', async e => {
    // add / edit
    if (e.target.closest('[data-add]')) return openPartnerModal(null);
    const ed = e.target.closest('[data-edit]');
    if (ed) return openPartnerModal(IP.partners[ed.dataset.edit]);

    // confirm dialogs (delete)
    const cf = e.target.closest('[data-confirm]');
    if (cf && !confirm(cf.dataset.confirm)) { e.preventDefault(); return; }

    // export
    const ex = e.target.closest('[data-export]');
    if (ex) {
      ex.disabled = true;
      try {
        const res = await fetch(ex.dataset.export, { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
        if (!res.ok) throw new Error('Export failed');
        const data = await res.json();
        if (!data.sheets) throw new Error('Export failed');
        await xlsx(data.filename, data.sheets);
      } catch (err) { toast(err.message || 'Export failed'); }
      ex.disabled = false;
    }
  });
</script>
@endpush

@section('content')
<div class="ip">
  <div class="hh">
    <div>
      <h2 style="margin:0">Investment Partners</h2>
      <div class="sub" style="margin:2px 0 0">One Window Investing · Partner links shown on website</div>
    </div>
  </div>

  @if(session('ok'))<div class="alert ok">{{ session('ok') }}</div>@endif
  @if($errors->any())<div class="alert bad">{{ $errors->first() }}</div>@endif

  <div class="card">
    <h3>Partner Options (rows of the table on website)</h3>

    @if($partners->isEmpty())
      <div class="em">No investment partner options yet. Click "Add partner option" to create one.</div>
    @else
      <div class="sc">
        <table>
          <thead>
            <tr>
              <th>Order</th>
              <th>Investment Type (text shown to customer)</th>
              <th>Category</th>
              <th>Partner</th>
              <th>Referral Link</th>
              <th>Clicks</th>
              <th>Show</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($partners as $p)
              <tr>
                <td>
                  <div class="row">
                    <form method="POST" action="{{ route('admin.investment-partners.move-up') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $p->id }}">
                      <button type="submit" class="btn s" title="Move up" @disabled($loop->first)>▲</button>
                    </form>
                    <form method="POST" action="{{ route('admin.investment-partners.move-down') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $p->id }}">
                      <button type="submit" class="btn s" title="Move down" @disabled($loop->last)>▼</button>
                    </form>
                    <span style="margin-left:6px;font-weight:600;color:var(--mut)">{{ $p->sort_order }}</span>
                  </div>
                </td>
                <td style="white-space:normal;min-width:220px">{{ $p->label }}</td>
                <td>{{ $p->category }}</td>
                <td>{{ $p->partner ?: '—' }}</td>
                <td class="url-cell">
                  @if(\Illuminate\Support\Str::startsWith($p->url, ['https://', 'http://']))
                    <a href="{{ $p->url }}" target="_blank" rel="noopener noreferrer">{{ \Illuminate\Support\Str::limit($p->url, 50) }}</a>
                  @else
                    <span style="color:var(--bad)" title="Link must start with https://">{{ \Illuminate\Support\Str::limit($p->url, 50) }}</span>
                  @endif
                </td>
                <td>{{ $p->clicks }}</td>
                <td>
                  <div class="toggle-wrap">
                    <form method="POST" action="{{ route('admin.investment-partners.update', $p->id) }}" class="inline">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="label" value="{{ $p->label }}">
                      <input type="hidden" name="category" value="{{ $p->category }}">
                      <input type="hidden" name="partner" value="{{ $p->partner ?? '' }}">
                      <input type="hidden" name="url" value="{{ $p->url }}">
                      <input type="checkbox" name="is_active" value="1" {{ $p->is_active ? 'checked' : '' }} onchange="this.form.submit()" aria-label="Show on website">
                    </form>
                  </div>
                </td>
                <td>
                  <div class="row">
                    <button type="button" class="btn s p" data-edit="{{ $p->id }}">Edit</button>

                    <form method="POST" action="{{ route('admin.investment-partners.duplicate') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $p->id }}">
                      <button type="submit" class="btn s">Duplicate</button>
                    </form>

                    <form method="POST" action="{{ route('admin.investment-partners.delete') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $p->id }}">
                      <button type="submit" class="btn s d" data-confirm="Delete this option from website table?">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    <div class="bar" style="padding:12px 16px;border-top:1px solid var(--line);margin-bottom:0">
      <button type="button" class="btn p" data-add>+ Add partner option</button>

      <button type="button" class="btn" data-export="{{ route('admin.investment-partners.export') }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/>
          <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Export
      </button>
    </div>
  </div>

  <div class="tt" id="tt"></div>
</div>
@endsection