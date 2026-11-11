@extends('admin.layout')
@section('title', 'Testimonials')

@php
  // Data for the Edit modal — passed with @json instead of being pasted into inline onclick="" attributes
  $testimonialData = $testimonials->mapWithKeys(fn($t) => [$t->id => [
      'id' => $t->id,
      'name' => $t->name,
      'text' => $t->text,
      'permission_taken' => (bool) $t->permission_taken,
      'is_active' => (bool) $t->is_active,
  ]]);

  $activeTestimonials = $testimonials->where('is_active', true)->where('permission_taken', true);
  $shown = $activeTestimonials->count();
  $total = $testimonials->count();

  $version = \App\Models\Setting::where('key', 'testimonials_version')->first()?->value ?? '1';
  $publishedAt = \App\Models\Setting::where('key', 'testimonials_published_at')->first()?->value;
  $pubTs = $publishedAt ? strtotime($publishedAt) : false;
  $lastEdit = $testimonials->max('updated_at');
  // "Unpublished changes" = never published, or a testimonial was edited after the last publish
  $dirty = !$pubTs || ($lastEdit && \Illuminate\Support\Carbon::parse($lastEdit)->timestamp > $pubTs);
@endphp

@push('styles')
<style>
  /* Scoped under .tm so nothing leaks into the rest of the admin panel */
  .tm .sc { overflow-x: auto; }
  .tm table { border-collapse: collapse; width: 100%; min-width: 720px; font-size: 13px; }
  .tm th, .tm td { text-align: left; padding: 9px 14px; border-bottom: 1px solid var(--line); white-space: nowrap; vertical-align: top; }
  .tm th { color: var(--mut); font-size: 12.5px; font-weight: 600; background: color-mix(in srgb, var(--bg) 60%, var(--card)); }
  .tm tr:last-child td { border: 0; }
  .tm td.testimonial-cell { max-width: 520px; min-width: 300px; white-space: normal; overflow-wrap: anywhere; }

  .tm .card { background: var(--card); border: 1px solid var(--line); border-radius: 12px; margin-bottom: 14px; overflow: hidden; }
  .tm .card > h3 { margin: 0; padding: 12px 16px; font-size: 14.5px; border-bottom: 1px solid var(--line); }
  .tm .bar { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
  .tm .pg { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 12px; padding: 16px; }
  .tm .pg .w { grid-column: 1 / -1; }
  .tm .pg label, .tm .lbl { font-size: 12.5px; color: var(--mut); font-weight: 600; display: block; }
  .tm .row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
  .tm .em { color: var(--mut); padding: 20px; text-align: center; }
  .tm form.inline { display: inline; margin: 0; }
  .tm .alert { padding: 10px 14px; border-radius: 10px; margin-bottom: 12px; font-weight: 600; }
  .tm .alert.ok { background: var(--ok-s); color: var(--ok); }
  .tm .alert.bad { background: var(--bad-s); color: var(--bad); }

  .tm .in, .mo .in { font: inherit; width: 100%; margin-top: 3px; padding: 8px 10px; border: 1px solid var(--line); border-radius: 8px; background: var(--bg); color: var(--ink); }
  .tm .in:focus, .mo .in:focus { outline: none; border-color: var(--pri); }
  .tm textarea.in, .mo textarea.in { min-height: 80px; resize: vertical; }

  .tm .btn, .mo .btn { display: inline-flex; align-items: center; gap: 6px; font-family: inherit; font-weight: 600; padding: 7px 12px; border-radius: 8px; border: 1px solid var(--line); background: var(--card); color: var(--ink); cursor: pointer; font-size: 13px; text-decoration: none; }
  .tm .btn:hover, .mo .btn:hover { background: var(--bg); }
  .tm .btn[disabled], .mo .btn[disabled] { opacity: .45; cursor: not-allowed; }
  .tm .btn.p, .mo .btn.p { background: var(--pri); color: #fff; border-color: var(--pri); }
  .tm .btn.d { color: var(--bad); }
  .tm .btn.s { padding: 4px 9px; font-size: 12.5px; }

  .tm .pill { display: inline-block; padding: 2px 9px; border-radius: 99px; font-size: 12px; font-weight: 700; background: var(--bg); color: var(--mut); }
  .tm .pill.warn { background: var(--warn-s); color: var(--warn); }
  .tm .pill.ok { background: var(--ok-s); color: var(--ok); }

  /* toggle switch */
  .toggle-wrap { display: flex; align-items: center; gap: 8px; }
  .toggle-wrap input[type=checkbox] { -webkit-appearance: none; appearance: none; width: 36px; height: 20px; border-radius: 99px; background: var(--line); position: relative; cursor: pointer; transition: background .2s; flex: none; margin: 0; }
  .toggle-wrap input[type=checkbox]:checked { background: var(--pri); }
  .toggle-wrap input[type=checkbox]:disabled { opacity: .45; cursor: not-allowed; }
  .toggle-wrap input[type=checkbox]::after { content: ''; position: absolute; top: 2px; left: 2px; width: 16px; height: 16px; border-radius: 50%; background: #fff; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
  .toggle-wrap input[type=checkbox]:checked::after { transform: translateX(16px); }
  .toggle-wrap span, label.toggle-wrap { font-size: 13px; color: var(--ink); cursor: pointer; }

  /* modal (appended to <body>, so not scoped) */
  .ov { position: fixed; inset: 0; background: rgba(10,12,30,.5); display: flex; align-items: center; justify-content: center; z-index: 200; padding: 16px; }
  .mo { background: var(--card); color: var(--ink); border-radius: 14px; width: min(600px, 98vw); max-height: 90vh; overflow: auto; padding: 20px; }
  .mo h3 { margin: 0 0 12px; }
  .mo .ac { display: flex; gap: 8px; justify-content: flex-end; margin-top: 14px; flex-wrap: wrap; }
  .mo .err { color: var(--bad); font-weight: 600; font-size: 13px; margin-top: 10px; }
  .mo textarea.mono { font: 12px ui-monospace, SFMono-Regular, Menlo, monospace; }
  .fg { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .fg .w { grid-column: 1 / -1; }
  .fg label { display: block; font-size: 12.5px; color: var(--mut); font-weight: 600; }
  .fg label.toggle-wrap { display: flex; }

  .tt { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: var(--ink); color: var(--bg); padding: 10px 16px; border-radius: 10px; z-index: 300; display: none; font-weight: 600; max-width: 90vw; }
  .tt.o { display: block; }

  @media (max-width: 600px) { .fg { grid-template-columns: 1fr; } }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
<script>
  const TM = {
    csrf: @json(csrf_token()),
    storeUrl: @json(route('admin.testimonials.store')),
    updateUrl: @json(route('admin.testimonials.update', '__ID__')),
    toggleUrl: @json(route('admin.testimonials.toggle')),
    publishUrl: @json(route('admin.testimonials.publish')),
    jsonUrl: @json(route('admin.testimonials.json')),
    items: @json($testimonialData),
  };
  const JSON_HEADERS = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
  const PAL = [["1F4E9E","E3ECFA"],["0F7A3D","E1F5E9"],["B45309","FDEFD8"],["6D28D9","EDE5FC"],["BE123C","FCE4EA"],["0E7490","DAF2F7"]];
  const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

  function toast(msg) {
    const t = document.getElementById('tt');
    t.textContent = msg;
    t.classList.add('o');
    clearTimeout(t._h);
    t._h = setTimeout(() => t.classList.remove('o'), 3000);
  }

  async function errorMessage(res, fallback) {
    try { const j = await res.json(); return j.errors ? Object.values(j.errors)[0][0] : (j.error || j.message || fallback); }
    catch (_) { return fallback; }
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

  /* ---------- modals ---------- */
  function makeOverlay(inner) {
    const ov = document.createElement('div');
    ov.className = 'ov';
    ov.innerHTML = `<div class="mo">${inner}</div>`;
    document.body.appendChild(ov);
    ov.addEventListener('click', e => { if (e.target === ov || e.target.closest('[data-close]')) ov.remove(); });
    return ov;
  }

  function openModal(title, bodyHtml, onSubmit) {
    const ov = makeOverlay(`<h3>${esc(title)}</h3><form novalidate>${bodyHtml}<div class="err" hidden></div>
      <div class="ac"><button type="button" class="btn" data-close>Cancel</button><button type="submit" class="btn p">Save</button></div></form>`);
    const form = ov.querySelector('form'), err = ov.querySelector('.err');
    form.addEventListener('submit', async e => {
      e.preventDefault();
      if (!form.reportValidity()) return;
      const btn = form.querySelector('button[type=submit]');
      btn.disabled = true; err.hidden = true;
      try { await onSubmit(form, () => ov.remove()); }
      catch (ex) { err.textContent = ex.message || 'Something went wrong'; err.hidden = false; btn.disabled = false; }
    });
    form.querySelector('input, textarea')?.focus();
  }

  function testimonialFields(t) {
    return `<div class="fg">
      <div class="w"><label>Name (shown under the quote)<input class="in" name="name" required maxlength="40" value="${esc(t.name)}"></label></div>
      <div class="w"><label>Testimonial (max 300 characters)<textarea class="in" name="text" required maxlength="300" rows="4">${esc(t.text)}</textarea></label></div>
      <div><label class="toggle-wrap"><input type="checkbox" name="permission_taken" ${t.permission_taken ? 'checked' : ''}> Permission taken</label></div>
      <div><label class="toggle-wrap"><input type="checkbox" name="is_active" ${t.is_active ? 'checked' : ''}> Show on website</label></div>
    </div>`;
  }

  function openTestimonialModal(t) {
    const edit = !!t;
    const cur = t || { name: '', text: '', permission_taken: false, is_active: false };
    openModal(edit ? 'Edit testimonial' : 'Add testimonial', testimonialFields(cur), async (form, close) => {
      const f = form.elements;
      if (f.is_active.checked && !f.permission_taken.checked) throw new Error('Permission must be taken before a testimonial can be shown.');
      const fd = new FormData();
      fd.append('_token', TM.csrf);
      if (edit) fd.append('_method', 'PUT');          // multipart PUT isn't parsed by PHP, so spoof it over POST
      fd.append('name', f.name.value.trim());
      fd.append('text', f.text.value.trim());
      fd.append('permission_taken', f.permission_taken.checked ? '1' : '0');
      fd.append('is_active', f.is_active.checked ? '1' : '0');
      const res = await fetch(edit ? TM.updateUrl.replace('__ID__', cur.id) : TM.storeUrl, { method: 'POST', body: fd, credentials: 'same-origin', headers: JSON_HEADERS });
      if (!res.ok) throw new Error(await errorMessage(res, 'Error saving'));
      close();
      toast(edit ? 'Testimonial updated' : 'Testimonial added');
      setTimeout(() => location.reload(), 300);
    });
  }

  async function openJsonViewer() {
    try {
      const res = await fetch(TM.jsonUrl, { credentials: 'same-origin', headers: JSON_HEADERS });
      if (!res.ok) throw new Error('Could not load feed');
      const text = JSON.stringify(await res.json(), null, 2);
      const ov = makeOverlay(`<h3>Testimonials JSON served to website</h3>
        <textarea class="in mono" rows="14" readonly></textarea>
        <div class="ac"><button type="button" class="btn" data-copy>Copy</button><button type="button" class="btn p" data-close>Close</button></div>`);
      ov.querySelector('textarea').value = text;       // textContent-safe, no escaping needed
      ov.querySelector('[data-copy]').onclick = async () => {
        try { await navigator.clipboard.writeText(text); toast('Copied'); }
        catch (_) { ov.querySelector('textarea').select(); toast('Select and copy manually'); }
      };
    } catch (err) { toast(err.message); }
  }

  async function publish(btn) {
    if (!confirm('Publish current testimonials to website?')) return;
    btn.disabled = true;
    try {
      const res = await fetch(TM.publishUrl, { method: 'POST', credentials: 'same-origin', headers: { ...JSON_HEADERS, 'Content-Type': 'application/json', 'X-CSRF-TOKEN': TM.csrf } });
      if (!res.ok) throw new Error(await errorMessage(res, 'Publish failed'));
      toast('Published');
      setTimeout(() => location.reload(), 400);
    } catch (err) { toast(err.message); btn.disabled = false; }
  }

  /* ---------- toggles (permission / show) ---------- */
  async function sendToggle(id, field, value) {
    const res = await fetch(TM.toggleUrl, {
      method: 'POST', credentials: 'same-origin',
      headers: { ...JSON_HEADERS, 'Content-Type': 'application/json', 'X-CSRF-TOKEN': TM.csrf },
      body: JSON.stringify({ id, field, value }),
    });
    if (!res.ok) throw new Error(await errorMessage(res, 'Error updating'));
  }

  document.addEventListener('change', async e => {
    const cb = e.target.closest('[data-toggle]');
    if (!cb) return;
    const id = cb.dataset.toggle, field = cb.dataset.field, value = cb.checked;
    const row = cb.closest('tr');
    const showCb = row.querySelector('[data-field="is_active"]');
    cb.disabled = true;
    try {
      await sendToggle(id, field, value);
      if (field === 'permission_taken') {
        // "Show" is only allowed while permission is taken
        if (!value && showCb.checked) { await sendToggle(id, 'is_active', false); showCb.checked = false; }
        showCb.disabled = !value;
        showCb.title = value ? '' : 'Permission must be taken first';
      }
      toast('Saved. Click "Publish changes" to push live.');
      document.getElementById('dirty-badge').hidden = false;
    } catch (err) {
      cb.checked = !value;                  // revert
      toast(err.message);
    }
    cb.disabled = false;
  });

  /* ---------- clicks ---------- */
  document.addEventListener('click', async e => {
    if (e.target.closest('[data-add]')) return openTestimonialModal(null);
    const ed = e.target.closest('[data-edit]');
    if (ed) return openTestimonialModal(TM.items[ed.dataset.edit]);
    if (e.target.closest('[data-json]')) return openJsonViewer();
    const pub = e.target.closest('[data-publish]');
    if (pub) return publish(pub);

    const cf = e.target.closest('[data-confirm]');
    if (cf && !confirm(cf.dataset.confirm)) { e.preventDefault(); return; }

    const ex = e.target.closest('[data-export]');
    if (ex) {
      ex.disabled = true;
      try {
        const res = await fetch(ex.dataset.export, { credentials: 'same-origin', headers: JSON_HEADERS });
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
<div class="tm">
  <div class="hh">
    <div>
      <h2 style="margin:0">Testimonials</h2>
      <div class="sub" style="margin:2px 0 0">Dynamic testimonials for website · Versioned & published separately</div>
    </div>
  </div>

  @if(session('ok'))<div class="alert ok">{{ session('ok') }}</div>@endif
  @if($errors->any())<div class="alert bad">{{ $errors->first() }}</div>@endif

  {{-- Testimonials table --}}
  <div class="card">
    <h3>Testimonials (cards on website)</h3>

    @if($testimonials->isEmpty())
      <div class="em">No testimonials. The section will be hidden on the website.</div>
    @else
      <div class="sc">
        <table>
          <thead>
            <tr><th>Order</th><th>Name</th><th>Testimonial</th><th>Permission</th><th>Show</th><th>Actions</th></tr>
          </thead>
          <tbody>
            @foreach($testimonials as $t)
              <tr>
                <td>
                  <div class="row">
                    <form method="POST" action="{{ route('admin.testimonials.move-up') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $t->id }}">
                      <button type="submit" class="btn s" title="Move up" @disabled($loop->first)>▲</button>
                    </form>
                    <form method="POST" action="{{ route('admin.testimonials.move-down') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $t->id }}">
                      <button type="submit" class="btn s" title="Move down" @disabled($loop->last)>▼</button>
                    </form>
                    <span style="margin-left:6px;font-weight:600;color:var(--mut)">{{ $t->sort_order }}</span>
                  </div>
                </td>
                <td><b>{{ $t->name }}</b></td>
                <td class="testimonial-cell">{{ $t->text }}</td>
                <td>
                  <label class="toggle-wrap">
                    <input type="checkbox" data-toggle="{{ $t->id }}" data-field="permission_taken" @checked($t->permission_taken)>
                    <span>Taken</span>
                  </label>
                </td>
                <td>
                  <label class="toggle-wrap">
                    <input type="checkbox" data-toggle="{{ $t->id }}" data-field="is_active"
                           @checked($t->is_active) @disabled(!$t->permission_taken)
                           @if(!$t->permission_taken) title="Permission must be taken first" @endif>
                    <span>Show</span>
                  </label>
                </td>
                <td>
                  <div class="row">
                    <button type="button" class="btn s p" data-edit="{{ $t->id }}">Edit</button>

                    <form method="POST" action="{{ route('admin.testimonials.duplicate') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $t->id }}">
                      <button type="submit" class="btn s">Duplicate</button>
                    </form>

                    <form method="POST" action="{{ route('admin.testimonials.delete') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $t->id }}">
                      <button type="submit" class="btn s d" data-confirm="{{ 'Delete this testimonial from the website?' . "\n\n" . $t->name }}">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    <div class="bar" style="padding:12px 16px;border-top:1px solid var(--line)">
      <button type="button" class="btn p" data-add>+ Add testimonial</button>
      <button type="button" class="btn" data-export="{{ route('admin.testimonials.export') }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export
      </button>
    </div>
  </div>

  {{-- Section text --}}
  <div class="card">
    <h3>Section text</h3>
    <form method="POST" action="{{ route('admin.testimonials.section') }}">
      @csrf
      <div class="pg">
        <div class="w">
          <label class="toggle-wrap">
            <input type="checkbox" name="on" value="1" @checked($section['on'])>
            <span>Show Testimonials section on website</span>
          </label>
        </div>
        <div><label>Small label above heading<input class="in" name="kicker" value="{{ old('kicker', $section['kicker']) }}" maxlength="60"></label></div>
        <div><label>Section heading<input class="in" name="title" value="{{ old('title', $section['title']) }}" maxlength="120"></label></div>
        <div class="w"><label>Sub-heading<input class="in" name="sub" value="{{ old('sub', $section['sub']) }}" maxlength="200"></label></div>
        <div class="w"><label>Note below the cards<textarea class="in" name="note" rows="3" maxlength="500">{{ old('note', $section['note']) }}</textarea></label></div>
      </div>
      <div style="padding:0 16px 16px"><button type="submit" class="btn p">Save text</button></div>
    </form>
  </div>

  {{-- Live preview --}}
  <div class="card">
    <h3>Live preview (as customer sees it)</h3>
    <div style="padding:16px">
      <div style="color:var(--pri);font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase">{{ $section['kicker'] }}</div>
      <h3 style="margin:2px 0 4px">{{ $section['title'] }}</h3>
      <p style="margin:0 0 12px;color:var(--mut)">{{ $section['sub'] }}</p>

      @if($shown > 0 && $section['on'])
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:10px">
          @foreach($activeTestimonials as $t)
            <div style="background:var(--card);border:1px solid var(--line);border-radius:14px;padding:14px 14px 12px;display:flex;flex-direction:column;gap:12px">
              <div style="font-size:13.5px;line-height:1.55;white-space:pre-line;overflow-wrap:anywhere">{{ $t->text }}</div>
              <div style="display:flex;align-items:center;gap:8px;font-weight:600;margin-top:auto">
                <span style="width:30px;height:30px;border-radius:50%;background:var(--pri);color:#fff;display:grid;place-items:center;font-size:12px;flex:none">{{ mb_strtoupper(mb_substr($t->name, 0, 1)) }}</span>
                {{ $t->name }}
              </div>
            </div>
          @endforeach
        </div>
      @elseif(!$section['on'])
        <p style="color:var(--bad);font-weight:600">Section is switched off and will not show on the website.</p>
      @else
        <div class="em" style="padding:0">No testimonial is switched on, so the section stays hidden.</div>
      @endif

      <p style="color:var(--mut);font-size:12.5px;margin-top:12px">{{ $section['note'] }}</p>
    </div>
  </div>

  {{-- Publish status --}}
  <div class="card">
    <h3>Publish status</h3>
    <div class="pg" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
      <div><span class="lbl">Version</span><div style="font-weight:600">{{ $version }}</div></div>
      <div><span class="lbl">Last published</span><div style="font-weight:600">{{ $publishedAt ?: 'Not published yet' }}</div></div>
      <div><span class="lbl">Shown on website</span><div style="font-weight:600">{{ $shown }} of {{ $total }}</div></div>
      <div class="w">
        <span class="lbl">Website feed</span>
        <div class="row" style="margin-top:8px">
          <button type="button" class="btn p" data-json>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
            View JSON for website
          </button>
          <button type="button" class="btn" data-publish>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            Publish changes
          </button>
          <span class="pill warn" id="dirty-badge" @if(!$dirty) hidden @endif>Unpublished changes</span>
        </div>
      </div>
    </div>
  </div>

  <div class="tt" id="tt"></div>
</div>
@endsection