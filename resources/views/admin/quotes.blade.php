@extends('admin.layout')
@include('admin.partials.popup-backend')
@section('title', 'Quote Requests')

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
      min-width: 1100px;
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
      padding: 9px 12px;
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
      width: min(920px, 98vw);
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

    async function exportQuotes() {
      const quotes = @json($exportQuotes);
      const rows = quotes.map(q => [
        q.created_at ? new Date(q.created_at).toLocaleString('en-IN', {day:'2-digit',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit',hour12:true}) : '',
        q.customer_name || '',
        q.customer_email || '',
        q.customer_mobile || '',
        q.customer_city || '',
        q.product_type || '',
        (q.details || []).map(d => (d[0]||'')+': '+(d[1]||'')).join(' · '),
        q.status || '',
        q.note || ''
      ]);
      const sub = 'Retirement Plan Karo · ' + new Date().toLocaleDateString('en-IN') + ' · {{ $quotes->total() }} records' +
        (@json($productType) ? ' · Product: ' + @json($productType) : '') +
        (@json($status) ? ' · Status: ' + @json($status) : '') +
        (@json($from) || @json($to) ? ' · ' + (@json($from) || 'start') + ' to ' + (@json($to) || 'today') : '');
      await xlsx('Quotes_' + (@json($from) || 'start') + '_to_' + (@json($to) || 'today') + '.xlsx', [{
        name: 'Quote Requests', title: 'Quote Requests', sub,
        head: ['Date', 'Customer', 'Email', 'Mobile', 'City', 'Product', 'Key Details', 'Status', 'Notes'],
        rows
      }]);
    }
  </script>
  <script>
    // Composer modal for WhatsApp / Email (shared with payments page)
    (function () {
      const CT = @json(\App\Support\PopupTemplates::all());
      
      let U = { name: 'Customer', mobile: '', email: '', link: location.origin + '/', purpose: 'payment', amount: '', date: '', type: '', quote: '' };
      let k = 0, raw = false, ch = 'wa';
      if (!document.getElementById('cmo')) {
        const m = document.createElement('div'); m.id = 'cmo'; m.className = 'ov';
        m.innerHTML = '<div class="mo" style="width:min(920px,98vw)"><h3 id="ctit">WhatsApp</h3><p id="csub" style="color:var(--mut);margin:-4px 0 8px"></p><label style="font-size:12.5px;color:var(--mut);font-weight:600">Template<select class="in" id="ctsel"></select></label><textarea class="in" id="ctext" rows="10" style="margin-top:8px"></textarea><p style="color:var(--mut);font-size:12px;margin:4px 0 0" id="chelp">Preview · personalised</p><div class="ac" style="flex-wrap:wrap"><button type="button" class="btn" id="fc">Cancel</button><button type="button" class="btn" id="cn">+ New template</button><button type="button" class="btn" id="ce">Edit template</button><button type="button" class="btn wa" id="ws">OK · Send on WhatsApp</button></div></div>';
        document.body.appendChild(m);
      }
      const ov = document.getElementById('cmo');
      function $(id) { return document.getElementById(id); }
      function fill(t) {
        const n = (U.name || '').split(' ')[0] || '';
        return (t || '').replace(/\{name\}/g, n)
          .replace(/\{link\}/g, U.link)
          .replace(/\{amount\}/g, U.amount || '')
          .replace(/\{purpose\}/g, U.purpose || 'payment')
          .replace(/\{date\}/g, U.date || '')
          .replace(/\{n\}/g, '0')
          .replace(/\{names\}/g, '')
          .replace(/\{pts\}/g, '0')
          .replace(/\{coupon\}/g, '')
          .replace(/\{type\}/g, U.type || '')
          .replace(/\{quote\}/g, U.quote || '1) ______ – ₹____ /year\n2) ______ – ₹____ /year');
      }
      function L() { return CT.map((c, i) => [c, i]).filter(x => (x[0].ch || 'wa') === ch); }
      function draw() {
        if (ch === 'wa') { $('ctit').textContent = 'WhatsApp · ' + (U.name || ''); $('csub').textContent = '+' + (U.mobile || ''); $('ws').textContent = 'OK · Send on WhatsApp'; $('ws').classList.add('wa'); }
        else { $('ctit').textContent = 'Email · ' + (U.name || ''); $('csub').textContent = U.email || ''; $('ws').textContent = 'OK · Send Email'; $('ws').classList.remove('wa'); }
        const sel = $('ctsel'); sel.innerHTML = ''; L().forEach(x => { const o = document.createElement('option'); o.value = x[1]; o.textContent = x[0].n; if (x[1] === k) o.selected = true; sel.appendChild(o); });
        const c = CT[k] || { t: '' }; $('ctext').value = raw ? c.t : fill(c.t);
        $('chelp').textContent = raw ? 'Template edit mode · variables: {name} {link} {amount} {purpose} {date} {n} {names} {pts} {coupon} {type} {quote}' : 'Preview · personalised';
        $('ce').textContent = raw ? 'Save template' : 'Edit template';
      }
      window.oc = function (c, mobile, email, name, purpose, amount, date, type, quote) {
        ch = c || 'wa'; U = { name: name || 'Customer', mobile: (mobile || '').toString(), email: (email || '').toString(), link: location.origin + '/', purpose: purpose || 'payment', amount: amount || '', date: date || '', type: type || '', quote: quote || '' };
        k = L()[0] ? L()[0][1] : 0; raw = false; draw(); ov.classList.add('o');
      };
      $('fc').onclick = function () { ov.classList.remove('o'); };
      $('ctsel').onchange = function () { k = +this.value; raw = false; draw(); };
      $('ce').onclick = function () { if (raw) { CT[k].t = $('ctext').value; raw = false; rpkTplSave(CT[k]); draw(); return; } raw = true; draw(); };
      $('cn').onclick = function () { const n = prompt('Template Name'); if (!n) return; CT.push({ n, t: 'Hi {name}, ', ch: ch }); rpkTplNew(CT[CT.length - 1]); k = CT.length - 1; raw = true; draw(); };
      $('ws').onclick = function () {
        if (raw) { alert('Click Save template first'); return; }
        if (ch === 'wa') { const num = (U.mobile || '').replace(/\D/g, '').slice(-10); if (num.length < 10) { alert('Enter correct mobile number'); return; } window.open('https://wa.me/91' + num + '?text=' + encodeURIComponent($('ctext').value), '_blank'); rpkLog('wa', U, $('ctext').value, CT[k]); }
        else { if (!(U.email || '').trim()) { alert('No email for this customer'); return; } rpkLog('em', U, $('ctext').value, CT[k], (CT[k] && CT[k].sub) ? fill(CT[k].sub) : (CT[k] ? CT[k].n : 'Message')); }
        ov.classList.remove('o');
      };
    })();

    // New Quote Request Modal - Normal form submit
    (function () {
      const QF = {
        "Term Insurance": [
          ["dob", "Date of birth", "date"],
          ["gen", "Gender", "select", ["Male", "Female"]],
          ["tob", "Tobacco / smoker", "select", ["No", "Yes"]],
          ["inc", "Annual income (₹)", "number"],
          ["occ", "Occupation", "select", ["Salaried", "Self-employed", "Business"]],
          ["cover", "Cover needed (₹)", "number"],
          ["till", "Cover till age", "number"],
          ["edu", "Education", "text"],
          ["ex", "Existing life cover", "select", ["None", "Yes"]],
        ],
        "Health Insurance": [
          ["ty", "Cover type", "select", ["Family floater", "Individual"]],
          ["mem", "Members & ages (e.g. Self 34, Spouse 32, Son 6)", "text"],
          ["pin", "Pincode", "text"],
          ["si", "Sum insured (₹)", "number"],
          ["ped", "Pre-existing disease", "select", ["No", "Yes"]],
          ["ped2", "Disease details (if yes)", "text"],
          ["par", "Parents covered", "select", ["No", "Yes"]],
          ["ex", "Existing policy", "select", ["No", "Yes"]],
        ],
        "Car / Bike Insurance": [
          ["v", "Vehicle", "select", ["Car", "Bike"]],
          ["mm", "Make / model / variant", "text"],
          ["rno", "Registration no.", "text"],
          ["yr", "Registration year", "number"],
          ["pins", "Previous insurer", "text"],
          ["pexp", "Policy expiry", "date"],
          ["ncb", "NCB", "select", ["0%", "20%", "25%", "35%", "45%", "50%"]],
          ["ty", "Plan", "select", ["Comprehensive", "Third party"]],
        ],
        "Credit Card": [
          ["emp", "Employment", "select", ["Salaried", "Self-employed", "Business"]],
          ["inc", "Annual income (₹)", "number"],
          ["cib", "CIBIL range", "select", ["Not sure", "750+", "700-749", "650-699", "Below 650"]],
          ["ncards", "Existing cards (count)", "number"],
          ["use", "Main spend", "select", ["Shopping", "Travel", "Fuel", "Dining", "Rewards / Cashback"]],
          ["fee", "Annual fee", "select", ["Free only", "Up to ₹1,000", "Any"]],
        ],
        "Personal Loan": [
          ["amt", "Loan amount (₹)", "number"],
          ["ten", "Tenure (months)", "number"],
          ["emp", "Employment", "select", ["Salaried", "Self-employed", "Business"]],
          ["inc", "Monthly income (₹)", "number"],
          ["co", "Company / business", "text"],
          ["emi", "Existing EMIs / month (₹)", "number"],
          ["cib", "CIBIL range", "select", ["Not sure", "750+", "700-749", "650-699", "Below 650"]],
          ["pur", "Purpose", "text"],
        ],
        "Loan Against Mutual Fund": [
          ["pv", "Portfolio value (₹)", "number"],
          ["ft", "Fund type", "select", ["Equity", "Debt", "Hybrid", "Mixed"]],
          ["rta", "Units held with", "select", ["CAMS", "KFintech", "Not sure"]],
          ["amt", "Loan required (₹)", "number"],
          ["ten", "Tenure (months)", "number"],
          ["pan", "PAN (last 4 digits)", "text"],
          ["pur", "Purpose", "text"],
        ],
      };
      const QST = ["New", "Quote shared", "Follow-up", "Converted", "Lost"];
      let currentProduct = "Term Insurance";
      let existingCustomers = @json(\App\Models\User::select('id', 'name', 'mobile')->orderBy('name')->get()->toArray());

      function openNewQuoteModal() {
        const modal = document.getElementById('newQuoteModal');
        if (!modal) { createModal(); return; }
        modal.classList.add('o');
        renderProductFields();
      }

      function createModal() {
        const m = document.createElement('div');
        m.id = 'newQuoteModal';
        m.className = 'ov';
        m.innerHTML = `
          <div class="mo" style="width:min(920px,98vw)">
            <h3>New Quote Request</h3>
            <form id="newQuoteForm" method="POST" action="{{ route('admin.quotes.store') }}">
              @csrf
              <div class="fg">
                <div class="w">
                  <label>Pick existing customer
                    <select class="in" id="q_customer_id" name="user_id">
                      <option value="">— new person —</option>
                      ${existingCustomers.map(u => `<option value="${u.id}">${u.name} · ${u.mobile}</option>`).join('')}
                    </select>
                  </label>
                </div>
                <div class="w">
                  <label>Product type
                    <select class="in" id="q_product_type" name="product_type">
                      ${Object.keys(QF).map(t => `<option${t === currentProduct ? ' selected' : ''}>${t}</option>`).join('')}
                    </select>
                  </label>
                </div>
                <div class="w">
                  <label>Full name<input class="in" id="q_name" name="customer_name" type="text" required></label>
                </div>
                <div class="w">
                  <label>Mobile (WhatsApp)<input class="in" id="q_mobile" name="customer_mobile" type="text" maxlength="10" pattern="\\d{10}" required></label>
                </div>
                <div class="w">
                  <label>Email<input class="in" id="q_email" name="customer_email" type="email"></label>
                </div>
                <div class="w">
                  <label>City<input class="in" id="q_city" name="customer_city" type="text"></label>
                </div>
                <div class="w" id="q_fields"></div>
                <div class="w">
                  <label>Notes / best time to call<textarea class="in" id="q_note" name="note" rows="2"></textarea></label>
                </div>
                <div class="w">
                  <label><input type="checkbox" id="q_consent" name="consent" value="1" checked> Customer ne quote share karne ki consent di</label>
                </div>
              </div>
              <div class="ac">
                <button type="button" class="btn" id="qfc">Cancel</button>
                <button type="submit" class="btn p">Save request</button>
              </div>
            </form>
          </div>
        `;
        document.body.appendChild(m);
        document.getElementById('qfc').onclick = () => m.classList.remove('o');
        document.getElementById('q_product_type').onchange = function () {
          currentProduct = this.value;
          renderProductFields();
        };
        document.getElementById('q_customer_id').onchange = function () {
          const id = this.value;
          if (!id) return;
          const u = existingCustomers.find(x => String(x.id) === id);
          if (u) {
            document.getElementById('q_name').value = u.name;
            document.getElementById('q_mobile').value = u.mobile;
          }
        };
        // Normal form submit - no AJAX needed
        renderProductFields();
      }

      function renderProductFields() {
        const container = document.getElementById('q_fields');
        const fields = QF[currentProduct] || [];
        container.innerHTML = fields.map(f => {
          if (f[2] === 'select') {
            return `<div><label>${f[1]}<select class="in" id="q_${f[0]}" name="details[${f[0]}]">${f[3].map(o => `<option>${o}</option>`).join('')}</select></label></div>`;
          }
          return `<div><label>${f[1]}<input class="in" type="${f[2] || 'text'}" id="q_${f[0]}" name="details[${f[0]}]"></label></div>`;
        }).join('');
      }

      window.openNewQuoteModal = openNewQuoteModal;
    })();

    // Inline status change - normal form submit
    document.addEventListener('change', function (e) {
      if (e.target.matches('[data-qs]')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.quotes.status", ["id" => ":id"]) }}'.replace(':id', e.target.dataset.qs);
        form.style.display = 'none';
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = document.querySelector('meta[name="csrf-token"]').content;
        const status = document.createElement('input');
        status.type = 'hidden';
        status.name = 'status';
        status.value = e.target.value;
        form.appendChild(csrf);
        form.appendChild(status);
        document.body.appendChild(form);
        e.target.dataset.old = e.target.value;
        form.submit();
      }
    });
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Quote Requests</h2>
      <div class="sub" style="margin:2px 0 0">
        Total: {{ $quotes->total() }}
        @foreach($counts as $k => $v)
          · {{ $k }}: {{ $v }}
        @endforeach
        @if($from || $to) · {{ $from ?: 'start' }} to {{ $to ?: 'today' }}@endif
      </div>
    </div>
    <div class="hr">
      <button class="btn p" type="button" onclick="openNewQuoteModal()">+ New Quote Request</button>
      <button class="btn p" type="button" onclick="exportQuotes()">Export Excel</button>
    </div>
  </div>

  <div class="pick">
    <form method="GET" action="{{ route('admin.quotes') }}" class="srch"
      style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;width:100%">
      <label>Product
        <select name="product_type">
          <option value="">All products</option>
          @foreach(\App\Models\QuoteRequest::productTypes() as $pt)
            <option value="{{ $pt }}" {{ $productType === $pt ? 'selected' : '' }}>{{ $pt }}</option>
          @endforeach
        </select>
      </label>
      <label>Status
        <select name="status">
          <option value="">All statuses</option>
          @foreach(\App\Models\QuoteRequest::statuses() as $st)
            <option value="{{ $st }}" {{ $status === $st ? 'selected' : '' }}>{{ $st }}</option>
          @endforeach
        </select>
      </label>
      <label>From <input type="date" name="from" value="{{ $from }}"></label>
      <label>To <input type="date" name="to" value="{{ $to }}"></label>
      <button class="btn s" type="submit">Apply</button>
      @if($productType || $status || $from || $to)<a class="btn" href="{{ route('admin.quotes') }}">Clear</a>@endif
    </form>
  </div>

  <div class="card">
    <div class="sc">
      @if($quotes->isEmpty())
        <div class="em">No quote requests yet.</div>
      @else
        <table id="quotes-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Customer</th>
              <th>Mobile</th>
              <th>Product</th>
              <th>Key Details</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quotes as $q)
              <tr>
                <td>{{ \Illuminate\Support\Carbon::parse($q->created_at)->format('d M Y, h:i A') }}</td>
                <td>{{ $q->customer_name }}</td>
                <td>{{ $q->customer_mobile }}</td>
                <td>{{ $q->product_type }}</td>
                <td>
                  @if(!empty($q->details) && count($q->details))
                      {{ collect($q->details)
                          ->slice(0, 4)
                          ->map(fn ($d) => ($d[0] ?? '') . ': ' . ($d[1] ?? ''))
                          ->join(' · ') }}

                      @if(count($q->details) > 4)
                          <span style="color:var(--mut)"> …</span>
                      @endif
                  @else
                      —
                  @endif
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.quotes.status', ['id' => $q->id]) }}" style="display:inline">
                    @csrf
                    <select class="in" name="status" data-qs="{{ $q->id }}" data-old="{{ $q->status }}"
                      style="margin:0;min-width:160px" onchange="this.form.submit()">
                      @foreach(\App\Models\QuoteRequest::statuses() as $st)
                        <option value="{{ $st }}" {{ $q->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                      @endforeach
                    </select>
                  </form>
                </td>
                <td>
                  <div class="row">
                    <button class="btn s wa" type="button" data-mobile="{{ e($q->customer_mobile) }}"
                      data-email="{{ e($q->customer_email) }}" data-name="{{ e($q->customer_name) }}"
                      data-type="{{ e($q->product_type) }}" data-quote="1) ______ – ₹____ /year\n2) ______ – ₹____ /year"
                      onclick="oc('wa', this.dataset.mobile, this.dataset.email, this.dataset.name, 'quote', '', '', this.dataset.type, this.dataset.quote)">
                      Share Quote
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div class="pager">
    <div>Showing {{ $quotes->firstItem() ?? 0 }}-{{ $quotes->lastItem() ?? 0 }} of {{ $quotes->total() }}</div>
    <div>{{ $quotes->appends(request()->query())->links() }}</div>
  </div>
@endsection