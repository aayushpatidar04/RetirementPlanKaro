@extends('admin.layout')
@section('title', 'Transactions')

@push('styles')
  <style>
    .hh{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:flex-start;margin-bottom:14px}
    .hr{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .sub{color:var(--mut)}
    .card{background:var(--card);border:1px solid var(--line);border-radius:12px;overflow:hidden;margin-bottom:14px}
    .sc{overflow-x:auto}
    table{border-collapse:collapse;width:100%;min-width:1100px;font-size:13px}
    th,td{text-align:left;padding:9px 14px;border-bottom:1px solid var(--line);white-space:nowrap}
    th{color:var(--mut);font-size:12.5px;font-weight:600;background:color-mix(in srgb,var(--bg) 60%,var(--card))}
    tr:last-child td{border:0}
    .pill{display:inline-block;padding:2px 9px;border-radius:99px;font-size:12px;font-weight:700;background:var(--bg);color:var(--mut)}
    .pill.ok{background:var(--ok-s);color:var(--ok)} .pill.bad{background:var(--bad-s);color:var(--bad)} .pill.warn{background:var(--warn-s);color:var(--warn)}
    .btn{display:inline-flex;align-items:center;gap:6px;font-family:inherit;font-weight:600;padding:7px 12px;border-radius:8px;border:1px solid var(--line);background:var(--card);color:var(--ink);cursor:pointer;font-size:13px;text-decoration:none}
    .btn.s{padding:5px 9px;font-size:12.5px}
    .btn.p{background:var(--pri);color:#fff;border-color:var(--pri)}
    .btn.wa{background:#25d366;color:#fff;border-color:#25d366}
    .row{display:flex;gap:6px;flex-wrap:wrap}
    .srch{display:flex;gap:6px;align-items:center;background:var(--card);border:1px solid var(--line);border-radius:10px;padding:4px 8px;flex-wrap:wrap}
    .srch select,.srch input{border:1px solid var(--line);background:var(--bg);font:inherit;color:var(--ink);padding:6px 8px;border-radius:8px}
    .srch label{font-size:12.5px;color:var(--mut);font-weight:600}
    .pager{display:flex;justify-content:space-between;align-items:center;margin-top:12px;color:var(--mut);font-size:13px}
    .em{padding:16px;color:var(--mut)}
    .ov{position:fixed;inset:0;background:rgba(10,12,30,.5);display:none;align-items:center;justify-content:center;z-index:200;padding:16px}.ov.o{display:flex}.mo{background:var(--card);border-radius:14px;width:min(920px,98vw);max-height:90vh;overflow:auto;padding:20px}.mo h3{margin:0 0 12px}.fg{display:grid;grid-template-columns:1fr 1fr;gap:10px}.fg .w{grid-column:1/-1}.fg label{display:block;font-size:12.5px;color:var(--mut);font-weight:600}.in{font:inherit;width:100%;margin-top:3px;padding:8px 10px;border:1px solid var(--line);border-radius:8px;background:var(--bg);color:var(--ink)}.ac{display:flex;gap:8px;justify-content:flex-end;margin-top:14px;flex-wrap:wrap}
  </style>
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
  <script>
    const PAL = [["1F4E9E","E3ECFA"],["0F7A3D","E1F5E9"],["B45309","FDEFD8"],["6D28D9","EDE5FC"],["BE123C","FCE4EA"],["0E7490","DAF2F7"]];
    async function xlsx(file, sheets){ if(!window.ExcelJS){ alert('Excel library could not be loaded.'); return; } const wb=new ExcelJS.Workbook(), used={}; const thin={style:'thin',color:{argb:'FFCBD5E1'}}, bd={top:thin,left:thin,bottom:thin,right:thin}; sheets.forEach((s,n)=>{ const [c,l]=PAL[n%PAL.length]; let nm=String(s.name||'Sheet').replace(/[\\\/\?\*\[\]:]/g,'-').slice(0,28); used[nm]=(used[nm]||0)+1; if(used[nm]>1) nm+=' '+used[nm]; const ws=wb.addWorksheet(nm,{views:[{showGridLines:false,state:'frozen',ySplit:3}]}); const nc=Math.max((s.head||[]).length,2); ws.mergeCells(1,1,1,nc); const t=ws.getCell(1,1); t.value=s.title||s.name; t.font={bold:true,size:16,color:{argb:'FFFFFFFF'}}; t.fill={type:'pattern',pattern:'solid',fgColor:{argb:'FF'+c}}; t.alignment={vertical:'middle',indent:1}; ws.getRow(1).height=32; ws.mergeCells(2,1,2,nc); const sb=ws.getCell(2,1); sb.value=s.sub||('Retirement Plan Karo · '+new Date().toLocaleDateString('en-IN')); sb.font={italic:true,color:{argb:'FF64748B'}}; sb.alignment={indent:1}; const h=ws.getRow(3); h.values=s.head; h.height=24; h.eachCell((k)=>{ k.fill={type:'pattern',pattern:'solid',fgColor:{argb:'FF'+c}}; k.font={bold:true,color:{argb:'FFFFFFFF'}}; k.border=bd; k.alignment={vertical:'middle',horizontal:'center'}; }); (s.rows||[]).forEach((r,i)=>{ const row=ws.addRow(r); row.height=20; for(let ci=1;ci<=nc;ci++){ const k=row.getCell(ci); k.border=bd; k.alignment={vertical:'middle',wrapText:true}; k.fill={type:'pattern',pattern:'solid',fgColor:{argb: i%2 ? 'FFFFFFFF':'FF'+l}}; if(typeof k.value==='number' && Math.abs(k.value)>=1000) k.numFmt='#,##0.##'; } }); if(!(s.rows||[]).length) ws.addRow(['No records']); s.head.forEach((x,ci)=>{ const vals=[String(x||'').length+4,...(s.rows||[]).map(r=>String((r||[])[ci]??'').length+3)]; ws.getColumn(ci+1).width=Math.min(52,Math.max(...vals)); }); ws.autoFilter={from:{row:3,column:1},to:{row:3,column:nc}}; }); const buf=await wb.xlsx.writeBuffer(); const a=document.createElement('a'); a.href=URL.createObjectURL(new Blob([buf],{type:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'})); a.download=file; a.click(); }
    async function exportPayments(){
      const rows = Array.from(document.querySelectorAll('#payments-table tbody tr')).map(tr=>{
        const t = tr.querySelectorAll('td'); if(!t.length) return null;
        const amt = (t[4].innerText||'').replace(/[^0-9.\-]/g,'');
        return [t[0].innerText.trim(), t[1].innerText.trim(), t[2].innerText.trim(), t[3].innerText.trim(), amt?Number(amt):t[4].innerText.trim(), t[5].innerText.trim(), t[6].innerText.trim(), t[7].innerText.trim(), t[8].innerText.trim()];
      }).filter(Boolean);
      const sub = 'Retirement Plan Karo · '+new Date().toLocaleDateString('en-IN')+' · {{ $payments->total() }} records' + (@json($status) ? ' · Status: '+@json($status) : '') + (@json($from)||@json($to) ? ' · '+(@json($from)||'start')+' to '+(@json($to)||'today') : '');
      await xlsx('Payments_'+(@json($from)||'start')+'_to_'+(@json($to)||'today')+'.xlsx', [{ name:'Transactions', title:'Transactions / Payments', sub, head:['Txn ID','Customer','Mobile','Purpose','Amount','Coupon','Status','PayU ID','When'], rows }]);
    }
  </script>
  <script>
  (function(){
    const CT = [
      { n: "Welcome", t: "Namaste {name}\n\nRetirement Plan Karo me aapka swagat hai! Aapke account me 600 welcome points add ho gaye hain.\n\nApna free retirement plan banayein {link}\n– Team Retirement Plan Karo" },
      { n: "Plan incomplete reminder", t: "Hi {name},\n\nAapne Retirement Plan Karo par account banaya tha, lekin abhi tak apna retirement plan complete nahi kiya.\n\nSirf 4 simple steps, 5 minute\nFree retirement corpus & SIP calculation\n600 welcome points aapke account me wait kar rahe hain\n\nAbhi plan banayein: {link}\n\nKoi sawal ho to bas reply karein.\n– Team Retirement Plan Karo" },
      { n: "Payment failed", t: "Hi {name},\n\nAapka {purpose} payment complete nahi ho paya.\n\nKoi baat nahi Aap yahan se dobara try kar sakte hain: {link}\n\nAgar paise kat gaye hain to 2–3 din me auto-refund ho jayenge. Madad chahiye to reply karein.\n– Team Retirement Plan Karo" },
      { n: "Report ready", t: "Hi {name}, aapki Premium Retirement Report ready hai\nDownload karein: {link}\n– Team Retirement Plan Karo" },
      { n: "Session confirmation", t: "Hi {name}, aapka guidance session confirm ho gaya hai.\n\nHamari team aapko call / video link share karegi. Kisi badlav ke liye bas reply karein.\n– Team Retirement Plan Karo" },
      { n: "Hot lead follow-up", t: "Hi {name}, aapne retirement guidance me interest dikhaya tha\n\nKya hum kal ek chhota call fix kar dein? Aapko kaunsa time suit karega? Reply karein.\n– Team Retirement Plan Karo" },
      { n: "Inactive user nudge", t: "Hi {name}, kaafi din se aap Retirement Plan Karo par nahi aaye.\n\nAapka plan wahin save hai — 2 minute me update karein {link}\n– Team Retirement Plan Karo" },
      { n: "Coupon / promotion", t: "Hi {name}\n\nSirf aapke liye special offer: coupon code *{coupon}* use karein aur Premium Report / Guidance Session par discount payein.\n\nAbhi use karein {link}\n– Team Retirement Plan Karo" },
      { n: "Greeting / follow-up", t: "Namaste {name}\n\nRetirement Plan Karo se baat kar rahe hain. Aapke retirement plan me madad chahiye to bas reply karein.\n– Team Retirement Plan Karo" },
      { n: "Welcome email", sub: "Welcome to Retirement Plan Karo, {name}!", t: "Hi {name},\n\nRetirement Plan Karo me aapka swagat hai!\n\nAapke account me 600 welcome points add ho gaye hain. Sirf 5 minute me aap ye sab kar sakte hain:\n  • Apna retirement corpus aur SIP calculate karein\n  • Life goals aur family ka plan banayein\n  • Free calculators (SIP, Tax, Home Loan EMI) use karein\n\nAbhi shuru karein: {link}\n\nKoi bhi sawal ho to is mail ka reply karein, hum madad karenge.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
      { n: "Payment failed", sub: "Aapka {purpose} payment complete nahi hua", t: "Hi {name},\n\nAapka {purpose} payment complete nahi ho paya. Koi baat nahi, aap dobara try kar sakte hain: {link}\n\nDhyan dein:\n • Agar paise kat gaye hain to 2–3 din me auto-refund ho jayenge.\n • Payment dobara fail ho to UPI ya card badal kar try karein.\n\nAgar koi dikkat ho to hume is mail ka reply karein.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" },
      { n: "Hot lead follow-up", sub: "{name} kya hum aapke retirement plan par baat karein?", t: "Hi {name},\n\nAapne retirement guidance me interest dikhaya tha, isliye hum follow-up kar rahe hain.\n\nEk chhote 20–30 minute ke call me hum:\n• Aapka retirement corpus aur gap samjhayenge\n• Aapke liye sahi SIP / investment mix batayenge\n• Aapke sawalon ke jawab denge\n\nBas bataiye aapko kaunsa din aur time suit karega.\n\nWarm regards,\nTeam Retirement Plan Karo\nretirementplankaro.com", ch: "em" }
    ];
    let U = { name: 'Customer', mobile: '', email: '', link: location.origin + '/', purpose:'payment', amount:'', date:'' };
    let k = 0, raw = false, ch = 'wa';
    if (!document.getElementById('cmo')) {
      const m = document.createElement('div'); m.id = 'cmo'; m.className = 'ov';
      m.innerHTML = '<div class="mo" style="width:min(920px,98vw)"><h3 id="ctit">WhatsApp</h3><p id="csub" style="color:var(--mut);margin:-4px 0 8px"></p><label style="font-size:12.5px;color:var(--mut);font-weight:600">Template<select class="in" id="ctsel"></select></label><textarea class="in" id="ctext" rows="10" style="margin-top:8px"></textarea><p style="color:var(--mut);font-size:12px;margin:4px 0 0" id="chelp">Preview · personalised</p><div class="ac" style="flex-wrap:wrap"><button type="button" class="btn" id="fc">Cancel</button><button type="button" class="btn" id="cn">+ New template</button><button type="button" class="btn" id="ce">Edit template</button><button type="button" class="btn wa" id="ws">OK · Send on WhatsApp</button></div></div>';
      document.body.appendChild(m);
    }
    const ov = document.getElementById('cmo');
    function $(id){ return document.getElementById(id); }
    function fill(t){ const n=(U.name||'').split(' ')[0]||'there'; return (t||'').replace(/\{name\}/g,n).replace(/\{link\}/g,U.link).replace(/\{amount\}/g,U.amount||'').replace(/\{purpose\}/g,U.purpose||'payment').replace(/\{date\}/g,U.date||'').replace(/\{n\}/g,'0').replace(/\{names\}/g,'').replace(/\{pts\}/g,'0').replace(/\{coupon\}/g,'').replace(/\{type\}/g,'').replace(/\{quote\}/g,'1) ______ – ₹____ /year\n2) ______ – ₹____ /year'); }
    function L(){ return CT.map((c,i)=>[c,i]).filter(x => (x[0].ch||'wa')===ch); }
    function draw(){
      if(ch==='wa'){ $('ctit').textContent='WhatsApp · '+(U.name||''); $('csub').textContent='+'+(U.mobile||''); $('ws').textContent='OK · Send on WhatsApp'; $('ws').classList.add('wa'); }
      else { $('ctit').textContent='Email · '+(U.name||''); $('csub').textContent=U.email||''; $('ws').textContent='OK · Send Email'; $('ws').classList.remove('wa'); }
      const sel=$('ctsel'); sel.innerHTML=''; L().forEach(x=>{ const o=document.createElement('option'); o.value=x[1]; o.textContent=x[0].n; if(x[1]===k) o.selected=true; sel.appendChild(o); });
      const c=CT[k]||{t:''}; $('ctext').value = raw ? c.t : fill(c.t);
      $('chelp').textContent = raw ? 'Template edit mode · variables: {name} {link} {amount} {purpose} {date} {n} {names} {pts}' : 'Preview · personalised';
      $('ce').textContent = raw ? 'Save template' : 'Edit template';
    }
    window.oc = function(c,mobile,email,name,purpose,amount,date){
      ch = c||'wa'; U = { name: name||'Customer', mobile: (mobile||'').toString(), email: (email||'').toString(), link: location.origin+'/', purpose: purpose||'payment', amount: amount||'', date: date||'' };
      k = L()[0] ? L()[0][1] : 0; raw=false; draw(); ov.classList.add('o');
    };
    $('fc').onclick = function(){ ov.classList.remove('o'); };
    $('ctsel').onchange = function(){ k=+this.value; raw=false; draw(); };
    $('ce').onclick = function(){ if(raw){ CT[k].t=$('ctext').value; raw=false; alert('Template saved'); draw(); return; } raw=true; draw(); };
    $('cn').onclick = function(){ const n=prompt('Template Name'); if(!n) return; CT.push({n, t:'Hi {name}, '}); k=CT.length-1; raw=true; draw(); };
    $('ws').onclick = function(){
      if(raw){ alert('Click Save template first'); return; }
      if(ch==='wa'){ const num=(U.mobile||'').replace(/\D/g,'').slice(-10); if(num.length<10){ alert('Enter correct mobile number'); return; } window.open('https://wa.me/91'+num+'?text='+encodeURIComponent($('ctext').value),'_blank'); }
      else { if(!(U.email||'').trim()){ alert('No email for this customer'); return; } window.location.href='mailto:'+encodeURIComponent(U.email)+'?subject='+encodeURIComponent((CT[k]&&CT[k].sub)?fill(CT[k].sub):(CT[k]?CT[k].n:'Message'))+'&body='+encodeURIComponent($('ctext').value); }
      ov.classList.remove('o');
    };
  })();
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Transactions</h2>
      <div class="sub" style="margin:2px 0 0">Revenue collected: ₹{{ number_format($totals["success"]) }} · {{ $totals["pending"] }} pending · {{ $totals["failed"] }} failed @if($from||$to) · {{ $from ?: 'start' }} to {{ $to ?: 'today' }}@endif</div>
    </div>
    <div class="hr">
      <form class="srch" method="GET" action="{{ route('admin.payments') }}">
        <label>Status
          <select name="status">
            <option value="">All statuses</option>
            <option value="success" {{ $status === 'success' ? 'selected' : '' }}>Success</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
            <option value="refunded" {{ $status === 'refunded' ? 'selected' : '' }}>Refunded</option>
          </select>
        </label>
        <label>From <input type="date" name="from" value="{{ $from }}"></label>
        <label>To <input type="date" name="to" value="{{ $to }}"></label>
        <button class="btn s" type="submit">Apply</button>
      </form>
      <button class="btn p" type="button" onclick="exportPayments()">Export Excel</button>
      @if($status||$from||$to)<a class="btn" href="{{ route('admin.payments') }}">Clear</a>@endif
    </div>
  </div>

  <div class="card">
    <div class="sc">
      @if($payments->isEmpty())
        <div class="em">No payments.</div>
      @else
        <table id="payments-table">
          <thead><tr><th>Txn ID</th><th>Customer</th><th>Mobile</th><th>Purpose</th><th>Amount</th><th>Coupon</th><th>Status</th><th>PayU ID</th><th>When</th><th>Action</th></tr></thead>
          <tbody>
            @foreach($payments as $p)
              @php $cname = trim(($p->name ?? '').' '.($p->surname ?? '')) ?: ($p->name ?? 'Customer'); @endphp
              <tr>
                <td>{{ $p->txnid }}</td>
                <td>{{ $cname }}</td>
                <td>{{ $p->mobile ?: '—' }}</td>
                <td>{{ ucfirst($p->purpose) }}</td>
                <td>₹{{ number_format((float)$p->amount, 2) }}</td>
                <td>{{ $p->coupon_code ?: '—' }}</td>
                <td>@if($p->status==='success')<span class="pill ok">success</span>@elseif($p->status==='failed')<span class="pill bad">failed</span>@elseif($p->status==='refunded')<span class="pill warn">refunded</span>@else<span class="pill warn">{{ $p->status }}</span>@endif</td>
                <td>{{ $p->payu_id ?: '—' }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y, h:i A') }}</td>
                <td>
                  @if($p->status === 'failed')
                    <div class="row">
                      <button class="btn s wa" type="button" data-mobile="{{ e($p->mobile ?: '') }}" data-email="{{ e($p->email ?: '') }}" data-name="{{ e($cname) }}" data-purpose="{{ e($p->purpose ?: 'payment') }}" data-amount="{{ e(number_format((float)$p->amount,2)) }}" data-date="{{ e(\Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y')) }}" onclick="oc('wa', this.dataset.mobile, this.dataset.email, this.dataset.name, this.dataset.purpose, this.dataset.amount, this.dataset.date)">WhatsApp</button>
                      <button class="btn s" type="button" data-mobile="{{ e($p->mobile ?: '') }}" data-email="{{ e($p->email ?: '') }}" data-name="{{ e($cname) }}" data-purpose="{{ e($p->purpose ?: 'payment') }}" data-amount="{{ e(number_format((float)$p->amount,2)) }}" data-date="{{ e(\Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y')) }}" onclick="oc('em', this.dataset.mobile, this.dataset.email, this.dataset.name, this.dataset.purpose, this.dataset.amount, this.dataset.date)">Email</button>
                    </div>
                  @else
                    —
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div class="pager">
    <div>Showing {{ $payments->firstItem()??0 }}-{{ $payments->lastItem()??0 }} of {{ $payments->total() }}</div>
    <div>{{ $payments->appends(request()->query())->links() }}</div>
  </div>
@endsection
