@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
  <style>
    .hh { display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; align-items: flex-start; margin-bottom: 14px }
    .hr { display: flex; gap: 8px; flex-wrap: wrap; align-items: center }
    .chips { display: flex; gap: 4px; background: var(--card); border: 1px solid var(--line); border-radius: 10px; padding: 3px; flex-wrap: wrap }
    .chips a { font: inherit; font-weight: 600; border: 0; background: none; color: var(--mut); padding: 5px 11px; border-radius: 7px; cursor: pointer; text-decoration: none }
    .chips a.on { background: var(--pri); color: #fff }
    .hr input[type=date] { font: inherit; padding: 5px 8px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink) }
    .dg { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 12px; margin-bottom: 22px }
    .dg .wide { grid-column: span 2 }
    @media(max-width:560px){ .dg .wide { grid-column: span 1 } }
    .dc { position: relative; background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 14px 16px; cursor: pointer; text-decoration: none; color: inherit }
    .dc:hover { border-color: var(--pri) }
    .dc>span { color: var(--mut); font-size: 12.5px; font-weight: 600 }
    .dc>b { display: block; font-size: 26px; margin: 2px 0 }
    .dc.alert { border-color: var(--bad) }
    .dc em { font-style: normal; font-size: 10.5px; background: var(--warn-s); color: var(--warn); padding: 1px 6px; border-radius: 99px; margin-left: 4px }
    .cm { font-style: normal; color: var(--mut); font-size: 12px; margin-left: 6px }
    .up { color: var(--ok) }
    .dn { color: var(--bad) }
    .sub { color: var(--mut) }
    .card { background: var(--card); border: 1px solid var(--line); border-radius: 12px; margin-bottom: 14px; overflow: hidden }
    .card>h3 { margin: 0; padding: 12px 16px; font-size: 14.5px; border-bottom: 1px solid var(--line) }
    .sc { overflow-x: auto }
    table { border-collapse: collapse; width: 100%; min-width: 560px; font-size: 13px }
    th, td { text-align: left; padding: 9px 14px; border-bottom: 1px solid var(--line); white-space: nowrap }
    th { color: var(--mut); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .03em; background: color-mix(in srgb, var(--bg) 60%, var(--card)) }
    tr:last-child td { border: 0 }
    .pill { display: inline-block; padding: 2px 9px; border-radius: 99px; font-size: 12px; font-weight: 700; background: var(--bg); color: var(--mut) }
    .pill.ok { background: var(--ok-s); color: var(--ok) }
    .pill.bad { background: var(--bad-s); color: var(--bad) }
    .pill.warn { background: var(--warn-s); color: var(--warn) }
    .pill.pri { background: var(--pri-s); color: var(--pri) }
    .btn { display: inline-flex; align-items: center; gap: 6px; font-family: inherit; font-weight: 600; padding: 7px 12px; border-radius: 8px; border: 1px solid var(--line); background: var(--card); color: var(--ink); cursor: pointer; font-size: 13px; text-decoration: none }
    .btn:hover { background: var(--bg) }
    .gb { height: 6px; background: var(--bg); border-radius: 9px; margin-top: 8px; overflow: hidden }
    .gb span { display: block; height: 100%; background: var(--ok) }
    .chart-card { background: var(--card); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; margin-bottom: 14px }
    .chart-card h3 { margin: 0; padding: 12px 16px; font-size: 14.5px; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between }
    .chart-body { padding: 14px 16px; position: relative; height: 320px }
    .chart-body canvas { width: 100% !important; height: 100% !important; max-width: 100%; display: block }
    .charts-grid { display: grid; grid-template-columns: 1fr; gap: 14px; }
    @media (min-width: 1100px) { .charts-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    .charts-grid .chart-card { height: 100%; }
    .eb { background: var(--pri-s); color: var(--pri); padding: 9px 14px; border-radius: 10px; margin-bottom: 12px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; font-weight: 600 }
    .eb .sp { flex: 1 }
    .ce { position: absolute; right: 8px; top: 8px; display: none; gap: 3px; z-index: 20 }
    .ce button { font: inherit; border: 1px solid var(--line); background: var(--card); color: var(--ink); border-radius: 6px; cursor: pointer; padding: 0 7px; line-height: 22px; font-size: 11px }
    .dg.edit .dc { cursor: move; outline: 2px dashed var(--line); outline-offset: -2px }
    .dg.edit .ce { display: flex }
    .dg.edit .kpi-card a { pointer-events: none }
    .dg.edit .kpi-card .ce { pointer-events: auto }
    .dg.edit .kpi-card .ce button { pointer-events: auto }
    .dc.hidden-card { display: none !important }
    .dg .add { display: none; place-items: center; min-height: 90px; border: 2px dashed var(--pri); color: var(--pri); font-weight: 700; background: var(--pri-s); cursor: pointer; border-radius: 14px }
    .dg.edit .add { display: grid }
  </style>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Dashboard</h2>
      <div class="sub" style="margin:2px 0 0">{{ $stats['periodLabel'] }} · compared with the period before</div>
    </div>
    <div class="hr">
      <div class="chips">
        <a href="{{ route('admin.dashboard', ['period'=>'today']) }}" class="{{ ($period??'today')==='today'?'on':'' }}">Today</a>
        <a href="{{ route('admin.dashboard', ['period'=>'7']) }}" class="{{ ($period??'')==='7'?'on':'' }}">7 days</a>
        <a href="{{ route('admin.dashboard', ['period'=>'30']) }}" class="{{ ($period??'')==='30'?'on':'' }}">30 days</a>
        <a href="{{ route('admin.dashboard', ['period'=>'month']) }}" class="{{ ($period??'')==='month'?'on':'' }}">This month</a>
        <a href="{{ route('admin.dashboard', ['period'=>'90']) }}" class="{{ ($period??'')==='90'?'on':'' }}">90 days</a>
        <a href="javascript:void(0)" onclick="document.getElementById('customRange').style.display='flex'">Custom</a>
      </div>
      <form id="customRange" style="display:none;gap:6px;align-items:center" method="GET" action="{{ route('admin.dashboard') }}">
        <input type="hidden" name="period" value="custom">
        <input type="date" name="from" required>
        <input type="date" name="to" required>
        <button class="btn" type="submit">Apply</button>
      </form>
      <button class="btn" onclick="exportDashboard()">Export Excel</button>
      <button class="btn" id="btnCustomise">Customise</button>
    </div>
  </div>

  <div id="editBar" class="eb" style="display:none">
    Customising the dashboard. Use Up and Down to reorder, Remove to hide a card.
    <span class="sp"></span>
    <button class="btn" id="btnResetDash">Reset</button>
    <button class="btn p" id="btnDoneDash">Done</button>
  </div>

  <div class="dg" id="kpiGrid">
    <a class="dc kpi-card" data-id="site-visits" href="{{ route('admin.users') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Site visits</span><b>{{ rand(120,450) }}</b><div><i class="cm">demo</i></div>
    </a>
    <a class="dc kpi-card" data-id="new-registrations" href="{{ route('admin.users') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>New registrations</span><b>{{ number_format($stats['signups']) }}</b>
      <div><?php $p=$stats['pc_signups']; ?>@if($p['val']>0 || $stats['signups']>0)<i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>@else<i class="cm">all time</i>@endif</div>
    </a>
    <a class="dc kpi-card" data-id="verified-clients" href="{{ route('admin.users') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Verified clients</span><b>{{ number_format($stats['verified_r']) }}</b><div><i class="cm">in period</i></div>
    </a>
    <a class="dc kpi-card" data-id="pending-verification" href="{{ route('admin.users') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Pending verification</span><b>{{ number_format($stats['users'] - $stats['verified']) }}</b><div><i class="cm">all time</i></div>
    </a>
    <a class="dc kpi-card" data-id="active-clients" href="{{ route('admin.users') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Active clients</span><b>{{ number_format($stats['users']) }}</b><div><i class="cm">all time</i></div>
    </a>
    <a class="dc kpi-card" data-id="client-records" href="{{ route('admin.users') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Client Records</span><b>{{ number_format($stats['users']) }}</b><div><i class="cm">all time</i></div>
    </a>
    <a class="dc kpi-card" data-id="prospects" href="{{ route('admin.leads') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Prospects</span><b>{{ number_format($stats['leads_r']) }}</b><div><?php $p=$stats['pc_leads']; ?>@if($p['val']>0 || $stats['leads_r']>0)<i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>@else<i class="cm">in period</i>@endif</div>
    </a>
    <a class="dc kpi-card" data-id="revenue" href="{{ route('admin.payments') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Revenue collected</span><b>₹{{ number_format($stats['revenue_r']) }}</b><div><?php $p=$stats['pc_revenue']; ?>@if($p['val']>0 || $stats['revenue_r']>0)<i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>@else<i class="cm">in period</i>@endif</div>
    </a>
    <a class="dc kpi-card" data-id="paying-clients" href="{{ route('admin.payments') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Paying clients</span><b>{{ number_format($stats['paid_clients']) }}</b><div><?php $p=$stats['pc_paid']; ?>@if($p['val']>0 || $stats['paid_clients']>0)<i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>@else<i class="cm">in period</i>@endif</div>
    </a>
    <a class="dc kpi-card" data-id="failed-transactions" href="{{ route('admin.payments') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Failed transactions</span><b>{{ number_format($stats['failed_r']) }}</b><div><?php $p=$stats['pc_failed']; ?>@if($p['val']>0 || $stats['failed_r']>0)<i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>@else<i class="cm">in period</i>@endif</div>
    </a>
    <a class="dc kpi-card" data-id="collection-rate" href="{{ route('admin.payments') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Collection success rate</span><b>{{ ($stats['payments_ok']+$stats['failed_r'])>0 ? round(($stats['payments_ok']/($stats['payments_ok']+$stats['failed_r']))*100) : 0 }}%</b><div><i class="cm">in period</i></div>
    </a>
    <a class="dc kpi-card" data-id="advisory-booked" href="{{ route('admin.sessions') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Advisory sessions booked</span><b>{{ number_format($stats['sessions_booked']) }}</b><div><i class="cm">in period</i></div>
    </a>
    <a class="dc kpi-card" data-id="sessions-pending" href="{{ route('admin.sessions') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Sessions pending</span><b>{{ number_format($stats['sessions_due']) }}</b><div><i class="cm">all time</i></div>
    </a>
    <a class="dc kpi-card" data-id="referral-registrations" href="{{ route('admin.leads') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Referral registrations</span><b>{{ number_format($stats['leads_r']) }}</b><div><i class="cm">in period</i></div>
    </a>
    <a class="dc kpi-card" data-id="messages-sent" href="{{ route('admin.dashboard') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Messages sent</span><b>0</b><div><i class="cm">in period</i></div>
    </a>
    <a class="dc kpi-card" data-id="coupons-redeemed" href="{{ route('admin.coupons') }}">
      <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
      <span>Discount codes redeemed</span><b>0</b><div><i class="cm">all time</i></div>
    </a>
    <div class="add" id="addCardBtn">+ Add card</div>
  </div>

  <div class="charts-grid">
    <div class="chart-card"><h3>Traffic and registrations <span class="cm">last {{ $stats['periodLabel'] }}</span></h3><div class="chart-body"><canvas id="trendChart"></canvas><div style="font-size:12px;color:var(--mut);margin-top:8px"><span style="color:var(--pri)">●</span> Site visits (demo) &nbsp; <span style="color:var(--warn)">●</span> Registrations ×10</div></div></div>
    <div class="chart-card"><h3>Revenue collected <span class="cm">by day</span></h3><div class="chart-body"><canvas id="revChart"></canvas></div></div>
    <div class="chart-card"><h3>Acquisition funnel <span class="cm">in period</span></h3><div class="chart-body">
      <?php $f1=max(1,$stats['signups']);$f2v=max(0,$stats['leads_r']);$f3v=max(0,$stats['paid_clients']);$f1m=max($f1,$f2v,$f3v);?>
      <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center;margin-bottom:8px"><span>Site visits</span><div style="height:12px;border-radius:6px;background:var(--pri);width:100%"></div><b style="text-align:right">{{ $f1 }}</b></div>
      <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center;margin-bottom:8px"><span>Registrations</span><div style="height:12px;border-radius:6px;background:var(--pri);width:100%"></div><b style="text-align:right">{{ $f1 }}</b></div>
      <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center;margin-bottom:8px"><span>Prospects</span><div style="height:12px;border-radius:6px;background:var(--warn);width:{{ $f1m>0?round(($f2v/$f1m)*100):0 }}%"></div><b style="text-align:right">{{ $f2v }}</b></div>
      <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center"><span>Paying clients</span><div style="height:12px;border-radius:6px;background:var(--ok);width:{{ $f1m>0?round(($f3v/$f1m)*100):0 }}%"></div><b style="text-align:right">{{ $f3v }}</b></div>
    </div></div>
    <div class="chart-card"><h3>Payments by status <span class="cm">in period</span></h3><div class="chart-body" style="height:280px;max-width:320px;margin:0 auto"><canvas id="payChart"></canvas></div></div>
  </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
const labels = Array.from({length:14},(_,i)=>{const d=new Date();d.setDate(d.getDate()-(13-i));return d.toLocaleDateString('en-GB',{day:'2-digit',month:'short'});});
const visits = labels.map(()=>Math.floor(40+Math.random()*60));
const regs = labels.map(()=>Math.floor(({{ $stats['signups'] }}+Math.random()*5)/14));
const chartOptions={responsive:true,maintainAspectRatio:false,interaction:{mode:'index',intersect:false},plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}},x:{ticks:{maxTicksLimit:7}}}};
new Chart(document.getElementById('trendChart'),{type:'line',data:{labels,datasets:[{label:'Site visits (demo)',data:visits,borderColor:'#4f46e5',backgroundColor:'#4f46e5',tension:0.4,pointRadius:2},{label:'Registrations ×10',data:regs.map(x=>x*10),borderColor:'#8a5a00',backgroundColor:'#8a5a00',tension:0.4,pointRadius:2}]},options:chartOptions});
new Chart(document.getElementById('revChart'),{type:'bar',data:{labels,datasets:[{label:'Revenue',data:labels.map(()=>Math.floor(Math.random()*({{ $stats['revenue_r']>0?$stats['revenue_r']:5000 }})/10)),backgroundColor:'#0f7a3d'}]},options:chartOptions});
new Chart(document.getElementById('payChart'),{type:'doughnut',data:{labels:['Success','Failed','Pending'],datasets:[{data:[{{ $stats['payments_ok']>0?$stats['payments_ok']:3 }},{{ $stats['failed_r']>0?$stats['failed_r']:1 }},0],backgroundColor:['#0f7a3d','#a4161a','#8a5a00']}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}});

function exportDashboard(){
  const data=[['Dashboard Export - {{ $stats["periodLabel"] }}'],[''],['Metric','Value'],['Site visits','{{ rand(120,450) }} (demo)'],['New registrations','{{ $stats["signups"] }}'],['Verified clients (in period)','{{ $stats["verified_r"] }}'],['Pending verification','{{ $stats["users"]-$stats["verified"] }}'],['Client Records','{{ $stats["users"] }}'],['Prospects (in period)','{{ $stats["leads_r"] }}'],['Revenue collected (in period)','₹{{ $stats["revenue_r"] }}'],['Paying clients (in period)','{{ $stats["paid_clients"] }}'],['Failed transactions (in period)','{{ $stats["failed_r"] }}'],['Advisory sessions booked (in period)','{{ $stats["sessions_booked"] }}'],['Sessions pending (all time)','{{ $stats["sessions_due"] }}']];
  const ws=XLSX.utils.aoa_to_sheet(data); const wb=XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb,ws,'Dashboard'); XLSX.writeFile(wb,'Dashboard-{{ str_replace(' ','-',$stats["periodLabel"]) }}.xlsx');
}

const grid=document.getElementById('kpiGrid');
const btnCustomise=document.getElementById('btnCustomise');
const editBar=document.getElementById('editBar');
const btnDone=document.getElementById('btnDoneDash');
const btnReset=document.getElementById('btnResetDash');
const addBtn=document.getElementById('addCardBtn');
const KEY='rpk_dash_layout_v5';

function loadLayout(){
  try{
    const raw=localStorage.getItem(KEY);
    if(!raw)return;
    const cfg=JSON.parse(raw);
    if(Array.isArray(cfg.order)){
      cfg.order.forEach(id=>{
        const el=grid.querySelector('.kpi-card[data-id="'+id+'"]');
        if(el && addBtn) grid.insertBefore(el, addBtn);
      });
    }
    if(Array.isArray(cfg.hidden)){
      cfg.hidden.forEach(id=>{
        const el=grid.querySelector('.kpi-card[data-id="'+id+'"]');
        if(el) el.classList.add('hidden-card');
      });
    }
  }catch(e){}
}

function saveLayout(){
  const order=[]; const hidden=[];
  grid.querySelectorAll('.kpi-card').forEach(c=>{
    order.push(c.dataset.id);
    if(c.classList.contains('hidden-card')) hidden.push(c.dataset.id);
  });
  try{ localStorage.setItem(KEY,JSON.stringify({order,hidden})); }catch(e){}
}

btnCustomise.addEventListener('click',function(){
  if(grid.classList.contains('edit')){
    grid.classList.remove('edit');
    editBar.style.display='none';
    btnCustomise.textContent='Customise';
    saveLayout();
  }else{
    grid.classList.add('edit');
    editBar.style.display='flex';
    btnCustomise.textContent='Cancel';
  }
});

btnDone.addEventListener('click',function(){
  grid.classList.remove('edit');
  editBar.style.display='none';
  btnCustomise.textContent='Customise';
  saveLayout();
});

btnReset.addEventListener('click',function(){
  try{localStorage.removeItem(KEY);}catch(e){}
  location.reload();
});

grid.addEventListener('click',function(e){
  if(!grid.classList.contains('edit')) return;
  if(e.target.closest('a')) e.preventDefault();
  if(e.target.closest('.ce button')){
    const btn=e.target.closest('button');
    if(btn.classList.contains('up')){
      const card=btn.closest('.kpi-card');
      const prev=card.previousElementSibling;
      if(prev && prev.classList.contains('kpi-card')) grid.insertBefore(card, prev);
      return;
    }
    if(btn.classList.contains('down')){
      const card=btn.closest('.kpi-card');
      const next=card.nextElementSibling;
      if(next && next.classList.contains('kpi-card')){
        if(next===addBtn) grid.insertBefore(addBtn, card);
        else grid.insertBefore(next, card);
      }
      return;
    }
    if(btn.classList.contains('rm')){
      const card=btn.closest('.kpi-card');
      card.classList.add('hidden-card');
      return;
    }
  }
});

addBtn.addEventListener('click',function(){
  if(!grid.classList.contains('edit')) return;
  const hidden=[...grid.querySelectorAll('.kpi-card.hidden-card')];
  if(hidden.length){ hidden[0].classList.remove('hidden-card'); }
});

loadLayout();
</script>
@endpush
