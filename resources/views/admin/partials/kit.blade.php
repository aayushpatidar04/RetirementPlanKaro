{{--
Shared CSS + JS for the admin pages (audit, roles, team, versions).
Include ONCE, near the top of the page, BEFORE the page's own @push('scripts'):
@include('admin.partials.kit')
Wrap the page content in <div class="adm"> so the CSS stays scoped.
    --}}
    @push('styles')
        <style>
            .adm .sc {
                overflow-x: auto;
            }

            .adm table {
                border-collapse: collapse;
                width: 100%;
                min-width: 720px;
                font-size: 13px;
            }

            .adm th,
            .adm td {
                text-align: left;
                padding: 9px 14px;
                border-bottom: 1px solid var(--line);
                white-space: nowrap;
                vertical-align: top;
            }

            .adm th {
                color: var(--mut);
                font-size: 12.5px;
                font-weight: 600;
                background: color-mix(in srgb, var(--bg) 60%, var(--card));
            }

            .adm tr:last-child td {
                border: 0;
            }

            .adm td.wrap {
                white-space: normal;
            }

            .adm .card {
                background: var(--card);
                border: 1px solid var(--line);
                border-radius: 12px;
                margin-bottom: 14px;
                overflow: hidden;
            }

            .adm .card>h3 {
                margin: 0;
                padding: 12px 16px;
                font-size: 14.5px;
                border-bottom: 1px solid var(--line);
            }

            .adm .card .note {
                color: var(--mut);
                margin: 0;
                padding: 12px 16px 0;
            }

            .adm .bar {
                display: flex;
                gap: 10px;
                align-items: center;
                flex-wrap: wrap;
                padding: 12px 16px;
            }

            .adm .bar.top {
                border-bottom: 1px solid var(--line);
            }

            .adm .pg {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
                gap: 12px;
                padding: 16px;
            }

            .adm .pg .w,
            .fg .w {
                grid-column: 1 / -1;
            }

            .adm .pg label {
                font-size: 12.5px;
                color: var(--mut);
                font-weight: 600;
                display: block;
            }

            .adm .row {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
                align-items: center;
            }

            .adm .em {
                color: var(--mut);
                padding: 20px;
                text-align: center;
            }

            .adm form.inline {
                display: inline;
                margin: 0;
            }

            .adm .muted {
                color: var(--mut);
            }

            .adm small.muted {
                font-size: 12.5px;
            }

            .adm .alert {
                padding: 10px 14px;
                border-radius: 10px;
                margin-bottom: 12px;
                font-weight: 600;
            }

            .adm .alert.ok {
                background: var(--ok-s);
                color: var(--ok);
            }

            .adm .alert.bad {
                background: var(--bad-s);
                color: var(--bad);
            }

            .adm .in,
            .mo .in {
                font: inherit;
                width: 100%;
                margin-top: 3px;
                padding: 8px 10px;
                border: 1px solid var(--line);
                border-radius: 8px;
                background: var(--bg);
                color: var(--ink);
            }

            .adm .in:focus,
            .mo .in:focus {
                outline: none;
                border-color: var(--pri);
            }

            .adm textarea.in,
            .mo textarea.in {
                min-height: 70px;
                resize: vertical;
            }

            .adm .btn,
            .mo .btn {
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

            .adm .btn:hover,
            .mo .btn:hover {
                background: var(--bg);
            }

            .adm .btn[disabled],
            .mo .btn[disabled] {
                opacity: .45;
                cursor: not-allowed;
            }

            .adm .btn.p,
            .mo .btn.p {
                background: var(--pri);
                color: #fff;
                border-color: var(--pri);
            }

            .adm .btn.d {
                color: var(--bad);
            }

            .adm .btn.s {
                padding: 4px 9px;
                font-size: 12.5px;
            }

            .adm .pill {
                display: inline-block;
                padding: 2px 9px;
                border-radius: 99px;
                font-size: 12px;
                font-weight: 700;
                background: var(--bg);
                color: var(--mut);
            }

            .adm .pill.ok {
                background: var(--ok-s);
                color: var(--ok);
            }

            .adm .pill.bad {
                background: var(--bad-s);
                color: var(--bad);
            }

            .adm .pill.warn {
                background: var(--warn-s);
                color: var(--warn);
            }

            .adm .pill.pri {
                background: var(--pri-s);
                color: var(--pri);
            }

            .adm .kpis {
                display: flex;
                gap: 16px;
                margin-bottom: 12px;
                flex-wrap: wrap;
            }

            .adm .kpis .k {
                background: var(--card);
                border: 1px solid var(--line);
                border-radius: 10px;
                padding: 12px 16px;
                min-width: 140px;
            }

            .adm .kpis .k span {
                display: block;
                font-size: 12px;
                color: var(--mut);
            }

            .adm .kpis .k b {
                font-size: 22px;
                font-weight: 700;
                color: var(--ink);
            }

            /* before/after details: short preview, click to expand */
            .adm details.det summary {
                cursor: pointer;
                color: var(--mut);
                white-space: normal;
                max-width: 420px;
                overflow-wrap: anywhere;
            }

            .adm details.det[open] summary {
                color: var(--pri);
                font-weight: 600;
            }

            .adm details.det pre {
                margin: 8px 0 0;
                padding: 10px;
                background: var(--bg);
                border: 1px solid var(--line);
                border-radius: 8px;
                max-width: 560px;
                max-height: 260px;
                overflow: auto;
                white-space: pre-wrap;
                overflow-wrap: anywhere;
                font: 12px ui-monospace, SFMono-Regular, Menlo, monospace;
                color: var(--ink);
            }

            /* toggle switch */
            .toggle-wrap {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .toggle-wrap input[type=checkbox] {
                -webkit-appearance: none;
                appearance: none;
                width: 36px;
                height: 20px;
                border-radius: 99px;
                background: var(--line);
                position: relative;
                cursor: pointer;
                transition: background .2s;
                flex: none;
                margin: 0;
            }

            .toggle-wrap input[type=checkbox]:checked {
                background: var(--pri);
            }

            .toggle-wrap input[type=checkbox]:disabled {
                opacity: .45;
                cursor: not-allowed;
            }

            .toggle-wrap input[type=checkbox]::after {
                content: '';
                position: absolute;
                top: 2px;
                left: 2px;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                background: #fff;
                transition: transform .2s;
                box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
            }

            .toggle-wrap input[type=checkbox]:checked::after {
                transform: translateX(16px);
            }

            .toggle-wrap span,
            label.toggle-wrap {
                font-size: 13px;
                color: var(--ink);
                cursor: pointer;
            }

            /* pagination (used with the vendor.pagination.admin view) */
            .adm .pagination {
                display: flex;
                gap: 4px;
                justify-content: center;
                padding: 12px 16px;
                flex-wrap: wrap;
            }

            .adm .pagination a,
            .adm .pagination span {
                padding: 6px 12px;
                border: 1px solid var(--line);
                border-radius: 6px;
                text-decoration: none;
                color: var(--ink);
            }

            .adm .pagination a:hover {
                background: var(--bg);
            }

            .adm .pagination .current,
            .adm .pagination .active {
                background: var(--pri);
                color: #fff;
                border-color: var(--pri);
            }

            /* modal (appended to <body>, so not scoped) */
            .ov {
                position: fixed;
                inset: 0;
                background: rgba(10, 12, 30, .5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 200;
                padding: 16px;
            }

            .mo {
                background: var(--card);
                color: var(--ink);
                border-radius: 14px;
                width: min(600px, 98vw);
                max-height: 90vh;
                overflow: auto;
                padding: 20px;
            }

            .mo.wide {
                width: min(820px, 98vw);
            }

            .mo h3 {
                margin: 0 0 12px;
            }

            .mo .ac {
                display: flex;
                gap: 8px;
                justify-content: flex-end;
                margin-top: 14px;
                flex-wrap: wrap;
            }

            .mo .err {
                color: var(--bad);
                font-weight: 600;
                font-size: 13px;
                margin-top: 10px;
            }

            .fg {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .fg label {
                display: block;
                font-size: 12.5px;
                color: var(--mut);
                font-weight: 600;
            }

            .fg label.toggle-wrap {
                display: flex;
            }

            .fg .hint {
                color: var(--mut);
                font-size: 12.5px;
            }

            /* permission matrix */
            .pm-sec {
                margin-bottom: 14px;
            }

            .pm-sec h4 {
                margin: 0 0 6px;
                font-size: 13px;
                color: var(--pri);
                font-weight: 700;
            }

            .pm-t {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            .pm-t th,
            .pm-t td {
                padding: 6px 10px;
                border-bottom: 1px solid var(--line);
                text-align: center;
            }

            .pm-t th:first-child,
            .pm-t td:first-child {
                text-align: left;
            }

            .pm-t th {
                color: var(--mut);
                font-size: 12px;
                font-weight: 600;
            }

            .pm-t input {
                width: 16px;
                height: 16px;
                accent-color: var(--pri);
            }

            .pm-sp {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 6px 0;
                font-size: 13px;
                font-weight: 500;
                color: var(--ink);
                cursor: pointer;
            }

            .pm-sp input {
                width: 16px;
                height: 16px;
                accent-color: var(--pri);
            }

            .tt {
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: var(--ink);
                color: var(--bg);
                padding: 10px 16px;
                border-radius: 10px;
                z-index: 300;
                display: none;
                font-weight: 600;
                max-width: 90vw;
            }

            .tt.o {
                display: block;
            }

            @media (max-width: 600px) {
                .fg {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
        <script>
            const CSRF = @json(csrf_token());
            const JSON_H = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
            const PAL = [["1F4E9E", "E3ECFA"], ["0F7A3D", "E1F5E9"], ["B45309", "FDEFD8"], ["6D28D9", "EDE5FC"], ["BE123C", "FCE4EA"], ["0E7490", "DAF2F7"]];
            const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

            function toast(msg) {
                const t = document.getElementById('tt');
                t.textContent = msg;
                t.classList.add('o');
                clearTimeout(t._h);
                t._h = setTimeout(() => t.classList.remove('o'), 3000);
            }

            async function errMsg(res, fallback) {
                try { const j = await res.json(); return j.errors ? Object.values(j.errors)[0][0] : (j.error || j.message || fallback); }
                catch (_) { return fallback; }
            }

            /** POST a FormData (add _method=PUT on the FormData for updates). Throws Error(message) on failure. */
            async function sendForm(url, fd) {
                fd.append('_token', CSRF);
                const res = await fetch(url, { method: 'POST', body: fd, credentials: 'same-origin', headers: JSON_H });
                if (!res.ok) throw new Error(await errMsg(res, 'Something went wrong'));
                return res;
            }

            /* ---------- modal ---------- */
            function openModal(title, bodyHtml, onSubmit, opts = {}) {
                const ov = document.createElement('div');
                ov.className = 'ov';
                ov.innerHTML = `<div class="mo ${opts.wide ? 'wide' : ''}"><h3>${esc(title)}</h3><form novalidate>${bodyHtml}<div class="err" hidden></div>
          <div class="ac"><button type="button" class="btn" data-close>Cancel</button><button type="submit" class="btn p">${esc(opts.submitLabel || 'Save')}</button></div></form></div>`;
                document.body.appendChild(ov);
                const form = ov.querySelector('form'), err = ov.querySelector('.err');
                ov.addEventListener('click', e => { if (e.target === ov || e.target.closest('[data-close]')) ov.remove(); });
                form.addEventListener('submit', async e => {
                    e.preventDefault();
                    if (!form.reportValidity()) return;
                    const btn = form.querySelector('button[type=submit]');
                    btn.disabled = true; err.hidden = true;
                    try { await onSubmit(form, () => ov.remove()); }
                    catch (ex) { err.textContent = ex.message || 'Something went wrong'; err.hidden = false; btn.disabled = false; }
                });
                if (opts.init) opts.init(form);
                form.querySelector('input:not([type=checkbox]), textarea, select')?.focus();
                return ov;
            }

            function saved(msg) { toast(msg); setTimeout(() => location.reload(), 300); }

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

            /* ---------- global click handlers: confirm + export ---------- */
            document.addEventListener('click', async e => {
                const cf = e.target.closest('[data-confirm]');
                if (cf && !confirm(cf.dataset.confirm)) { e.preventDefault(); return; }

                const ex = e.target.closest('[data-export]');
                if (ex) {
                    ex.disabled = true;
                    try {
                        const res = await fetch(ex.dataset.export, { credentials: 'same-origin', headers: JSON_H });
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