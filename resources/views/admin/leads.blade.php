@extends('admin.layout')
@section('title', 'Prospects')

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

    .kpis {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 10px;
      margin-bottom: 16px
    }

    .k {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 12px 14px
    }

    .k span {
      color: var(--mut);
      font-size: 12.5px
    }

    .k b {
      display: block;
      font-size: 21px
    }

    .chips {
      display: flex;
      gap: 4px;
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 10px;
      padding: 3px;
      flex-wrap: wrap
    }

    .chips a {
      font: inherit;
      font-weight: 600;
      border: 0;
      background: none;
      color: var(--mut);
      padding: 5px 11px;
      border-radius: 7px;
      cursor: pointer;
      text-decoration: none
    }

    .chips a.on {
      background: var(--pri);
      color: #fff
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
      min-width: 980px;
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

    .pill.pri {
      background: var(--pri-s);
      color: var(--pri)
    }

    .pill.ok {
      background: var(--ok-s);
      color: var(--ok)
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

    .btn.p {
      background: var(--pri);
      color: #fff;
      border-color: var(--pri)
    }

    .btn.s {
      padding: 5px 9px;
      font-size: 12.5px
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
  </style>
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
  <script>
    const PAL = [["1F4E9E", "E3ECFA"], ["0F7A3D", "E1F5E9"], ["B45309", "FDEFD8"], ["6D28D9", "EDE5FC"], ["BE123C", "FCE4EA"], ["0E7490", "DAF2F7"]];
    async function xlsx(file, sheets) { if (!window.ExcelJS) { alert('Excel library could not be loaded.'); return; } const wb = new ExcelJS.Workbook(), used = {}; const thin = { style: 'thin', color: { argb: 'FFCBD5E1' } }, bd = { top: thin, left: thin, bottom: thin, right: thin }; sheets.forEach((s, n) => { const [c, l] = PAL[n % PAL.length]; let nm = String(s.name || 'Sheet').replace(/[\\\/\?\*\[\]:]/g, '-').slice(0, 28); used[nm] = (used[nm] || 0) + 1; if (used[nm] > 1) nm += ' ' + used[nm]; const ws = wb.addWorksheet(nm, { views: [{ showGridLines: false, state: 'frozen', ySplit: 3 }] }); const nc = Math.max((s.head || []).length, 2); ws.mergeCells(1, 1, 1, nc); const t = ws.getCell(1, 1); t.value = s.title || s.name; t.font = { bold: true, size: 16, color: { argb: 'FFFFFFFF' } }; t.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF' + c } }; t.alignment = { vertical: 'middle', indent: 1 }; ws.getRow(1).height = 32; ws.mergeCells(2, 1, 2, nc); const sb = ws.getCell(2, 1); sb.value = s.sub || ('Retirement Plan Karo · ' + new Date().toLocaleDateString('en-IN')); sb.font = { italic: true, color: { argb: 'FF64748B' } }; sb.alignment = { indent: 1 }; const h = ws.getRow(3); h.values = s.head; h.height = 24; h.eachCell((k) => { k.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF' + c } }; k.font = { bold: true, color: { argb: 'FFFFFFFF' } }; k.border = bd; k.alignment = { vertical: 'middle', horizontal: 'center' }; }); (s.rows || []).forEach((r, i) => { const row = ws.addRow(r); row.height = 20; for (let ci = 1; ci <= nc; ci++) { const k = row.getCell(ci); k.border = bd; k.alignment = { vertical: 'middle', wrapText: true }; k.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: i % 2 ? 'FFFFFFFF' : 'FF' + l } }; if (typeof k.value === 'number' && Math.abs(k.value) >= 1000) k.numFmt = '#,##0.##'; } }); if (!(s.rows || []).length) ws.addRow(['No records']); s.head.forEach((x, ci) => { const vals = [String(x || '').length + 4, ...(s.rows || []).map(r => String((r || [])[ci] ?? '').length + 3)]; ws.getColumn(ci + 1).width = Math.min(52, Math.max(...vals)); }); ws.autoFilter = { from: { row: 3, column: 1 }, to: { row: 3, column: nc } }; }); const buf = await wb.xlsx.writeBuffer(); const a = document.createElement('a'); a.href = URL.createObjectURL(new Blob([buf], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })); a.download = file; a.click(); }
    async function exportLeads() {
      const rows = Array.from(document.querySelectorAll('#leads-table tbody tr')).map(tr => {
        const t = tr.querySelectorAll('td'); if (!t.length) return null;
        return [t[0].innerText.trim(), t[1].innerText.trim(), t[2].innerText.trim(), t[3].innerText.trim(), t[4].innerText.trim(), t[5].innerText.trim()];
      }).filter(Boolean);
      await xlsx('Prospects.xlsx', [{ name: 'Prospects', title: 'Prospects / Leads', sub: 'Retirement Plan Karo · ' + new Date().toLocaleDateString('en-IN') + ' · {{ $leads->total() }} total' + (@json($event) ? ' · Event: ' + @json($event) : ''), head: ['Event', 'Mobile', 'Email', 'IP', 'User ID', 'When'], rows }]);
    }
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Prospects</h2>
      <div class="sub" style="margin:2px 0 0">{{ $leads->total() }} total @if($event) · Event: {{ $event }} @endif</div>
    </div>
    <div class="hr">
      <div class="chips">
        <a href="{{ route('admin.leads') }}" class="{{ empty($event) ? 'on' : '' }}">All</a>
        @foreach($events as $e)
          <a href="{{ route('admin.leads', ['event' => $e]) }}" class="{{ $event === $e ? 'on' : '' }}">{{ $e }}</a>
        @endforeach
      </div>
      <button class="btn p" type="button" onclick="exportLeads()">Export Excel</button>
    </div>
  </div>

  <div class="kpis">
    <div class="k"><span>Total prospects</span><b>{{ $leads->total() }}</b></div>
    <div class="k"><span>Events (types)</span><b>{{ $events->count() }}</b></div>
    <div class="k"><span>Showing (page)</span><b>{{ $leads->count() }}</b></div>
  </div>

  <div class="card">
    <div class="sc">
      @if($leads->isEmpty())
        <div class="em">No prospects found.</div>
      @else
        <table id="leads-table">
          <thead>
            <tr>
              <th>Event</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>IP</th>
              <th>User ID</th>
              <th>When</th>
              <th>Send</th>
            </tr>
          </thead>
          <tbody>
            @foreach($leads as $l)
              <tr>
                <td><span class="pill pri">{{ $l->event }}</span></td>
                <td>{{ $l->mobile ?: '—' }}</td>
                <td>{{ $l->email ?: '—' }}</td>
                <td>{{ $l->ip ?: '—' }}</td>
                <td>{{ $l->user_id ?: '—' }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y, h:i A') }}</td>
                <td>
                  <div class="row">
                    <button class="btn s wa" type="button" data-mobile="{{ e($l->mobile ?: '') }}" data-email="{{ e($l->email ?: '') }}" data-name="" onclick="oc('wa', this.dataset.mobile, this.dataset.email, this.dataset.name)">WhatsApp</button>
                    <button class="btn s" type="button" data-mobile="{{ e($l->mobile ?: '') }}" data-email="{{ e($l->email ?: '') }}" data-name="" onclick="oc('em', this.dataset.mobile, this.dataset.email, this.dataset.name)">Email</button>
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
    <div>Showing {{ $leads->firstItem() ?? 0 }}-{{ $leads->lastItem() ?? 0 }} of {{ $leads->total() }}</div>
    <div>{{ $leads->appends(request()->query())->links() }}</div>
  </div>


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

      let U = { name: '', mobile: '', email: '', link: location.origin + '/' };
      let k = 0, raw = false, ch = 'wa';
      if (!document.getElementById('cmo')) {
        const m = document.createElement('div'); m.id = 'cmo'; m.className = 'ov';
        m.innerHTML = '<div class="mo" style="width:min(920px,98vw)"><h3 id="ctit">WhatsApp</h3><p id="csub" style="color:var(--mut);margin:-4px 0 8px"></p><label style="font-size:12.5px;color:var(--mut);font-weight:600">Template<select class="in" id="ctsel"></select></label><textarea class="in" id="ctext" rows="10" style="margin-top:8px"></textarea><p style="color:var(--mut);font-size:12px;margin:4px 0 0" id="chelp">Preview · personalised</p><div class="ac" style="flex-wrap:wrap"><button type="button" class="btn" id="fc">Cancel</button><button type="button" class="btn" id="cn">+ New template</button><button type="button" class="btn" id="ce">Edit template</button><button type="button" class="btn wa" id="ws">OK · Send on WhatsApp</button></div></div>';
        document.body.appendChild(m);
      }
      const ov = document.getElementById('cmo');
      function $(id) { return document.getElementById(id); }
      function fill(t) { const n = (U.name || '').split(' ')[0] || ''; return (t || '').replace(/\{name\}/g, n).replace(/\{link\}/g, U.link).replace(/\{amount\}/g, '').replace(/\{purpose\}/g, 'Premium Report').replace(/\{date\}/g, '').replace(/\{n\}/g, '0').replace(/\{names\}/g, '').replace(/\{pts\}/g, '0').replace(/\{coupon\}/g, '').replace(/\{type\}/g, '').replace(/\{quote\}/g, '1) ______ – ₹____ /year\n2) ______ – ₹____ /year'); }
      function L() { return CT.map((c, i) => [c, i]).filter(x => (x[0].ch || 'wa') === ch); }
      function draw() {
        if (ch === 'wa') { $('ctit').textContent = 'WhatsApp · ' + (U.name || ''); $('csub').textContent = '+' + (U.mobile || ''); $('ws').textContent = 'OK · Send on WhatsApp'; $('ws').classList.add('wa'); }
        else { $('ctit').textContent = 'Email · ' + (U.name || ''); $('csub').textContent = U.email || ''; $('ws').textContent = 'OK · Send Email'; $('ws').classList.remove('wa'); }
        const sel = $('ctsel'); sel.innerHTML = '';
        L().forEach(x => { const o = document.createElement('option'); o.value = x[1]; o.textContent = x[0].n; if (x[1] === k) o.selected = true; sel.appendChild(o); });
        const c = CT[k] || { t: '' }; $('ctext').value = raw ? c.t : fill(c.t);
        $('chelp').textContent = raw ? 'Template edit mode · variables: {name} {link} {amount} {purpose} {date} {n} {names} {pts}' : 'Preview · personalised';
        $('ce').textContent = raw ? 'Save template' : 'Edit template';
      }
      window.oc = function (c, mobile, email, name) {
        ch = c || 'wa'; U = { name: name || '', mobile: (mobile || '').toString(), email: (email || '').toString(), link: location.origin + '/' };
        k = L()[0] ? L()[0][1] : 0; raw = false; draw(); ov.classList.add('o');
      };
      $('fc').onclick = function () { ov.classList.remove('o'); };
      $('ctsel').onchange = function () { k = +this.value; raw = false; draw(); };
      $('ce').onclick = function () { if (raw) { CT[k].t = $('ctext').value; raw = false; alert('Template saved'); draw(); return; } raw = true; draw(); };
      $('cn').onclick = function () { const n = prompt('Template Name'); if (!n) return; CT.push({ n, t: 'Hi {name}, ' }); k = CT.length - 1; raw = true; draw(); };
      $('ws').onclick = function () {
        if (raw) { alert('Click Save template first'); return; }
        if (ch === 'wa') { const num = (U.mobile || '').replace(/\D/g, '').slice(-10); if (num.length < 10) { alert('Enter correct mobile number'); return; } window.open('https://wa.me/91' + num + '?text=' + encodeURIComponent($('ctext').value), '_blank'); }
        else { if (!(U.email || '').trim()) { alert('No email for this prospect'); return; } window.location.href = 'mailto:' + encodeURIComponent(U.email) + '?subject=' + encodeURIComponent((CT[k] && CT[k].sub) ? fill(CT[k].sub) : (CT[k] ? CT[k].n : 'Message')) + '&body=' + encodeURIComponent($('ctext').value); }
        ov.classList.remove('o');
      };
    })();
  </script>

@endsection