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

  @php
    $n = fn ($v) => number_format($v);
    // [data-id, label, value, link, % key (or null), raw key for the zero check, caption when no % is shown]
    $cards = [
      ['site-visits', 'Site visits', $n($stats['visits']), route('admin.users'), 'pc_visits', 'visits', 'in period'],
      ['new-registrations', 'New registrations', $n($stats['signups']), route('admin.users'), 'pc_signups', 'signups', 'in period'],
      ['verified-clients', 'Verified clients', $n($stats['verified_r']), route('admin.users'), null, null, 'in period'],
      ['pending-verification', 'Pending verification', $n($stats['users'] - $stats['verified']), route('admin.users'), null, null, 'all time'],
      ['active-clients', 'Active clients', $n($stats['active_clients']), route('admin.users'), null, null, 'all time'],
      ['client-records', 'Client Records', $n($stats['users']), route('admin.users'), null, null, 'all time'],
      ['prospects', 'Prospects', $n($stats['leads_r']), route('admin.leads'), 'pc_leads', 'leads_r', 'in period'],
      ['revenue', 'Revenue collected', '₹' . $n($stats['revenue_r']), route('admin.payments'), 'pc_revenue', 'revenue_r', 'in period'],
      ['paying-clients', 'Paying clients', $n($stats['paid_clients']), route('admin.payments'), 'pc_paid', 'paid_clients', 'in period'],
      ['failed-transactions', 'Failed transactions', $n($stats['failed_r']), route('admin.payments'), 'pc_failed', 'failed_r', 'in period'],
      ['collection-rate', 'Collection success rate', $stats['collection_rate'] . '%', route('admin.payments'), null, null, 'in period'],
      ['advisory-booked', 'Advisory sessions booked', $n($stats['sessions_booked']), route('admin.sessions'), null, null, 'in period'],
      ['sessions-pending', 'Sessions pending', $n($stats['sessions_due']), route('admin.sessions'), null, null, 'all time'],
      ['referral-registrations', 'Referral registrations', $n($stats['referral_regs']), route('admin.referrals'), null, null, 'in period'],
      ['messages-sent', 'Messages sent', $n($stats['messages_sent']), route('admin.messages', ['tab' => 'act']), null, null, 'in period'],
      ['coupons-redeemed', 'Discount codes redeemed', $n($stats['coupons_redeemed']), route('admin.coupons'), null, null, 'in period'],
    ];
  @endphp
  <div class="dg" id="kpiGrid">
    @foreach($cards as [$id, $label, $val, $href, $pck, $raw, $scope])
      <a class="dc kpi-card" data-id="{{ $id }}" href="{{ $href }}">
        <div class="ce"><button type="button" class="up">Up</button><button type="button" class="down">Down</button><button type="button" class="rm">Remove</button></div>
        <span>{{ $label }}</span><b>{{ $val }}</b>
        <div>
          @php $p = $pck ? $stats[$pck] : null; @endphp
          @if($p && ($p['val'] > 0 || $stats[$raw] > 0))
            <i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>
          @else
            <i class="cm">{{ $scope }}</i>
          @endif
        </div>
      </a>
    @endforeach
    <div class="add" id="addCardBtn">+ Add card</div>
  </div>

  <div class="charts-grid">
    <div class="chart-card"><h3>Traffic and registrations <span class="cm">{{ $stats['periodLabel'] }}@if($charts['padded']) · showing last 7 days @endif</span></h3><div class="chart-body"><canvas id="trendChart"></canvas></div></div>
    <div class="chart-card"><h3>Revenue collected <span class="cm">by day</span></h3><div class="chart-body"><canvas id="revChart"></canvas></div></div>
    <div class="chart-card"><h3>Acquisition funnel <span class="cm">in period</span></h3><div class="chart-body">
      @php
        $funnel = [
          ['Site visits', $stats['visits'], 'var(--pri)'],
          ['Registrations', $stats['signups'], 'var(--pri)'],
          ['Prospects', $stats['leads_r'], 'var(--warn)'],
          ['Paying clients', $stats['paid_clients'], 'var(--ok)'],
        ];
        $fmax = max(1, ...array_column($funnel, 1));
      @endphp
      @foreach($funnel as [$fl, $fv, $fc])
        <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center;margin-bottom:{{ $loop->last ? 0 : 8 }}px"><span>{{ $fl }}</span><div style="height:12px;border-radius:6px;background:{{ $fc }};width:{{ round($fv / $fmax * 100) }}%"></div><b style="text-align:right">{{ number_format($fv) }}</b></div>
      @endforeach
    </div></div>
    <div class="chart-card"><h3>Payments by status <span class="cm">in period</span></h3><div class="chart-body" style="height:280px;max-width:320px;margin:0 auto"><canvas id="payChart"></canvas></div></div>
  </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
const CH = @json($charts);
const inr = v => '₹' + Number(v).toLocaleString('en-IN');
const chartOptions={responsive:true,maintainAspectRatio:false,interaction:{mode:'index',intersect:false},plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}},x:{ticks:{maxTicksLimit:7}}}};
new Chart(document.getElementById('trendChart'),{type:'line',data:{labels:CH.labels,datasets:[
  {label:'Site visits',data:CH.visits,borderColor:'#4f46e5',backgroundColor:'#4f46e5',tension:0.4,pointRadius:2,yAxisID:'y'},
  {label:'Registrations',data:CH.regs,borderColor:'#8a5a00',backgroundColor:'#8a5a00',tension:0.4,pointRadius:2,yAxisID:'y1'}
]},options:{responsive:true,maintainAspectRatio:false,interaction:{mode:'index',intersect:false},plugins:{legend:{display:true,position:'bottom'}},scales:{y:{beginAtZero:true,ticks:{precision:0}},y1:{beginAtZero:true,position:'right',grid:{drawOnChartArea:false},ticks:{precision:0}},x:{ticks:{maxTicksLimit:7}}}}});
new Chart(document.getElementById('revChart'),{type:'bar',data:{labels:CH.labels,datasets:[{label:'Revenue',data:CH.revenue,backgroundColor:'#0f7a3d'}]},options:{...chartOptions,plugins:{legend:{display:false},tooltip:{callbacks:{label:c=>inr(c.parsed.y)}}},scales:{y:{beginAtZero:true,ticks:{callback:v=>inr(v)}},x:{ticks:{maxTicksLimit:7}}}}});
new Chart(document.getElementById('payChart'),{type:'doughnut',data:{labels:['Success','Failed','Pending','Refunded'],datasets:[{data:CH.pay,backgroundColor:['#0f7a3d','#a4161a','#8a5a00','#697089']}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}});

function exportDashboard(){
  const S=@json($stats);
  const data=[['Dashboard Export - '+S.periodLabel],[''],['Metric','Value'],
    ['Site visits (in period)',S.visits],['New registrations (in period)',S.signups],['Verified clients (in period)',S.verified_r],
    ['Pending verification (all time)',S.users-S.verified],['Active clients (all time)',S.active_clients],['Client Records (all time)',S.users],
    ['Prospects (in period)',S.leads_r],['Revenue collected (in period)','₹'+S.revenue_r],['Paying clients (in period)',S.paid_clients],
    ['Failed transactions (in period)',S.failed_r],['Collection success rate (in period)',S.collection_rate+'%'],
    ['Advisory sessions booked (in period)',S.sessions_booked],['Sessions pending (all time)',S.sessions_due],
    ['Referral registrations (in period)',S.referral_regs],['Messages sent (in period)',S.messages_sent],['Discount codes redeemed (in period)',S.coupons_redeemed]];
  const ws=XLSX.utils.aoa_to_sheet(data); const wb=XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb,ws,'Dashboard'); XLSX.writeFile(wb,'Dashboard-'+S.periodLabel.replace(/\s+/g,'-')+'.xlsx');
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
  if(!hidden.length){ alert('All cards are already on the dashboard. Use Remove on a card first, then you can add it back here.'); return; }
  const list=hidden.map((c,i)=>(i+1)+'. '+c.querySelector('span').textContent.trim()).join('\n');
  const pick=prompt('Which card do you want to add?\n\n'+list+'\n\nType its number:','1');
  if(pick===null) return;
  const card=hidden[parseInt(pick,10)-1];
  if(!card){ alert('Please type a number from the list.'); return; }
  card.classList.remove('hidden-card');
  grid.insertBefore(card, addBtn);   // shows up at the end, next to "+ Add card"
  saveLayout();
});

loadLayout();
</script>
@endpush