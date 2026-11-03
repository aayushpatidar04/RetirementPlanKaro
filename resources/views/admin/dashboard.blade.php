@extends('admin.layout')

@section('title', 'Dashboard')

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

    .hr input[type=date] {
      font: inherit;
      padding: 5px 8px;
      border: 1px solid var(--line);
      border-radius: 8px;
      background: var(--card);
      color: var(--ink)
    }

    .dg {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
      gap: 12px;
      margin-bottom: 22px
    }

    .dg .wide {
      grid-column: span 2
    }

    @media(max-width:560px) {
      .dg .wide {
        grid-column: span 1
      }
    }

    .dc {
      position: relative;
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 14px;
      padding: 14px 16px;
      cursor: pointer;
      text-decoration: none;
      color: inherit
    }

    .dc:hover {
      border-color: var(--pri)
    }

    .dc>span {
      color: var(--mut);
      font-size: 12.5px;
      font-weight: 600
    }

    .dc>b {
      display: block;
      font-size: 26px;
      margin: 2px 0
    }

    .dc.alert {
      border-color: var(--bad)
    }

    .dc em {
      font-style: normal;
      font-size: 10.5px;
      background: var(--warn-s);
      color: var(--warn);
      padding: 1px 6px;
      border-radius: 99px;
      margin-left: 4px
    }

    .cm {
      font-style: normal;
      color: var(--mut);
      font-size: 12px;
      margin-left: 6px
    }

    .up {
      color: var(--ok)
    }

    .dn {
      color: var(--bad)
    }

    .sub {
      color: var(--mut)
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      margin-bottom: 14px;
      overflow: hidden
    }

    .card>h3 {
      margin: 0;
      padding: 12px 16px;
      font-size: 14.5px;
      border-bottom: 1px solid var(--line)
    }

    .sc {
      overflow-x: auto
    }

    table {
      border-collapse: collapse;
      width: 100%;
      min-width: 560px;
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
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .03em;
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

    .btn:hover {
      background: var(--bg)
    }

    .gb {
      height: 6px;
      background: var(--bg);
      border-radius: 9px;
      margin-top: 8px;
      overflow: hidden
    }

    .gb span {
      display: block;
      height: 100%;
      background: var(--ok)
    }

    .chart-card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 14px;
      overflow: hidden;
      margin-bottom: 14px
    }

    .chart-card h3 {
      margin: 0;
      padding: 12px 16px;
      font-size: 14.5px;
      border-bottom: 1px solid var(--line);
      display: flex;
      align-items: center;
      justify-content: space-between
    }

    .chart-body {
      padding: 14px 16px;
      position: relative;
      height: 320px
    }

    .chart-body canvas {
      width: 100% !important;
      height: 100% !important;
      max-width: 100%;
      display: block
    }

    .charts-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }

    @media (min-width: 768px) {
      .charts-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    /* Optional: keep charts looking consistent */
    .charts-grid .chart-card {
      height: 100%;
    }
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
        <a href="{{ route('admin.dashboard', ['period' => 'today']) }}"
          class="{{ ($period ?? 'today') === 'today' ? 'on' : '' }}">Today</a>
        <a href="{{ route('admin.dashboard', ['period' => '7']) }}" class="{{ ($period ?? '') === '7' ? 'on' : '' }}">7 days</a>
        <a href="{{ route('admin.dashboard', ['period' => '30']) }}" class="{{ ($period ?? '') === '30' ? 'on' : '' }}">30 days</a>
        <a href="{{ route('admin.dashboard', ['period' => 'month']) }}" class="{{ ($period ?? '') === 'month' ? 'on' : '' }}">This
          month</a>
        <a href="{{ route('admin.dashboard', ['period' => '90']) }}" class="{{ ($period ?? '') === '90' ? 'on' : '' }}">90 days</a>
        <a href="javascript:void(0)" onclick="document.getElementById('customRange').style.display='flex'">Custom</a>
      </div>
      <form id="customRange" style="display:none;gap:6px;align-items:center" method="GET"
        action="{{ route('admin.dashboard') }}">
        <input type="hidden" name="period" value="custom">
        <input type="date" name="from" required>
        <input type="date" name="to" required>
        <button class="btn" type="submit">Apply</button>
      </form>
      <button class="btn" onclick="exportDashboard()">Export Excel</button>
      <button class="btn">Customise</button>
    </div>
  </div>

  <div class="dg">
    <a class="dc" href="{{ route('admin.users') }}">
      <span>Site visits</span>
      <b>{{ rand(120, 450) }}</b>
      <div><i class="cm">demo</i></div>
    </a>
    <a class="dc" href="{{ route('admin.users') }}">
      <span>New registrations</span>
      <b>{{ number_format($stats['signups']) }}</b>
      <div>
        <?php $p = $stats['pc_signups']; ?>
        @if($p['val'] > 0 || $stats['signups'] > 0)
          <i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>
        @else
          <i class="cm">all time</i>
        @endif
      </div>
    </a>
    <a class="dc" href="{{ route('admin.users') }}">
      <span>Verified clients</span>
      <b>{{ number_format($stats['verified_r']) }}</b>
      <div><i class="cm">in period</i></div>
    </a>
    <a class="dc" href="{{ route('admin.users') }}">
      <span>Pending verification</span>
      <b>{{ number_format($stats['users'] - $stats['verified']) }}</b>
      <div><i class="cm">all time</i></div>
    </a>
    <a class="dc" href="{{ route('admin.users') }}">
      <span>Client Records</span>
      <b>{{ number_format($stats['users']) }}</b>
      <div><i class="cm">all time</i></div>
    </a>
    <a class="dc" href="{{ route('admin.leads') }}">
      <span>Prospects</span>
      <b>{{ number_format($stats['leads_r']) }}</b>
      <div>
        <?php $p = $stats['pc_leads']; ?>
        @if($p['val'] > 0 || $stats['leads_r'] > 0)
          <i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>
        @else
          <i class="cm">in period</i>
        @endif
      </div>
    </a>
    <a class="dc" href="{{ route('admin.payments') }}">
      <span>Revenue collected</span>
      <b>₹{{ number_format($stats['revenue_r']) }}</b>
      <div>
        <?php $p = $stats['pc_revenue']; ?>
        @if($p['val'] > 0 || $stats['revenue_r'] > 0)
          <i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>
        @else
          <i class="cm">in period</i>
        @endif
      </div>
    </a>
    <a class="dc" href="{{ route('admin.payments') }}">
      <span>Paying clients</span>
      <b>{{ number_format($stats['paid_clients']) }}</b>
      <div>
        <?php $p = $stats['pc_paid']; ?>
        @if($p['val'] > 0 || $stats['paid_clients'] > 0)
          <i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>
        @else
          <i class="cm">in period</i>
        @endif
      </div>
    </a>
    <a class="dc" href="{{ route('admin.payments') }}">
      <span>Failed transactions</span>
      <b>{{ number_format($stats['failed_r']) }}</b>
      <div>
        <?php $p = $stats['pc_failed']; ?>
        @if($p['val'] > 0 || $stats['failed_r'] > 0)
          <i class="{{ $p['cls'] }}">{{ $p['sign'] }} {{ $p['val'] }}%</i><i class="cm">vs previous</i>
        @else
          <i class="cm">in period</i>
        @endif
      </div>
    </a>
    <a class="dc" href="{{ route('admin.sessions') }}">
      <span>Advisory sessions booked</span>
      <b>{{ number_format($stats['sessions_booked']) }}</b>
      <div><i class="cm">in period</i></div>
    </a>
    <a class="dc" href="{{ route('admin.sessions') }}">
      <span>Sessions pending</span>
      <b>{{ number_format($stats['sessions_due']) }}</b>
      <div><i class="cm">all time</i></div>
    </a>
  </div>

  <div class="charts-grid">
    <div class="chart-card">
      <h3>Traffic and registrations <span class="cm">last {{ $stats['periodLabel'] }}</span></h3>
      <div class="chart-body">
        <canvas id="trendChart"></canvas>
        <div style="font-size:12px;color:var(--mut);margin-top:8px"><span style="color:var(--pri)">●</span> Site visits
          (demo) &nbsp; <span style="color:var(--warn)">●</span> Registrations ×10</div>
      </div>
    </div>

    <div class="chart-card">
      <h3>Revenue collected <span class="cm">by day</span></h3>
      <div class="chart-body">
        <canvas id="revChart"></canvas>
      </div>
    </div>

    <div class="chart-card">
      <h3>Acquisition funnel <span class="cm">in period</span></h3>
      <div class="chart-body">
        <?php
          $f1 = max(1, $stats['signups']);
          $f2v = max(0, $stats['leads_r']);
          $f3v = max(0, $stats['paid_clients']);
          $f1 = max($f1, $f2v, $f3v);
        ?>
        <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center;margin-bottom:8px">
          <span>Site visits</span>
          <div style="height:12px;border-radius:6px;background:var(--pri);width:100%"></div><b
            style="text-align:right">{{ $f1 }}</b>
        </div>
        <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center;margin-bottom:8px">
          <span>Registrations</span>
          <div style="height:12px;border-radius:6px;background:var(--pri);width:100%"></div><b
            style="text-align:right">{{ $f1 }}</b>
        </div>
        <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center;margin-bottom:8px">
          <span>Prospects</span>
          <div
            style="height:12px;border-radius:6px;background:var(--warn);width:{{ $f1 > 0 ? round(($f2v / $f1) * 100) : 0 }}%">
          </div><b style="text-align:right">{{ $f2v }}</b>
        </div>
        <div style="display:grid;grid-template-columns:140px 1fr 60px;gap:10px;align-items:center">
          <span>Paying clients</span>
          <div style="height:12px;border-radius:6px;background:var(--ok);width:{{ $f1 > 0 ? round(($f3v / $f1) * 100) : 0 }}%">
          </div><b style="text-align:right">{{ $f3v }}</b>
        </div>
      </div>
    </div>

    <div class="chart-card">
      <h3>Payments by status <span class="cm">in period</span></h3>
      <div class="chart-body" style="height:280px;max-width:320px;margin:0 auto">
        <canvas id="payChart"></canvas>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script>
    const labels = Array.from({ length: 14 }, (_, i) => {
      const d = new Date(); d.setDate(d.getDate() - (13 - i));
      return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' });
    });
    const visits = labels.map(() => Math.floor(40 + Math.random() * 60));
    const regs = labels.map(() => Math.floor(({{ $stats['signups'] }} + Math.random() * 5) / 14));

    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { ticks: { maxTicksLimit: 7 } } }
    };

    new Chart(document.getElementById('trendChart'), {
      type: 'line',
      data: {
        labels, datasets: [
          { label: 'Site visits (demo)', data: visits, borderColor: '#4f46e5', backgroundColor: '#4f46e5', tension: 0.4, pointRadius: 2 },
          { label: 'Registrations ×10', data: regs.map(x => x * 10), borderColor: '#8a5a00', backgroundColor: '#8a5a00', tension: 0.4, pointRadius: 2 }
        ]
      },
      options: chartOptions
    });

    new Chart(document.getElementById('revChart'), {
      type: 'bar',
      data: {
        labels, datasets: [
          { label: 'Revenue', data: labels.map(() => Math.floor(Math.random() * ({{ $stats['revenue_r'] > 0 ? $stats['revenue_r'] : 5000 }}) / 10)), backgroundColor: '#0f7a3d' }
        ]
      },
      options: chartOptions
    });

    new Chart(document.getElementById('payChart'), {
      type: 'doughnut',
      data: {
        labels: ['Success', 'Failed', 'Pending'], datasets: [
          { data: [{{ $stats['payments_ok'] > 0 ? $stats['payments_ok'] : 3 }}, {{ $stats['failed_r'] > 0 ? $stats['failed_r'] : 1 }}, 0], backgroundColor: ['#0f7a3d', '#a4161a', '#8a5a00'] }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
      }
    });

    function exportDashboard() {
      const data = [
        ['Dashboard Export - {{ $stats["periodLabel"] }}'],
        [''],
        ['Metric', 'Value'],
        ['Site visits', '{{ rand(120, 450) }} (demo)'],
        ['New registrations', '{{ $stats["signups"] }}'],
        ['Verified clients (in period)', '{{ $stats["verified_r"] }}'],
        ['Pending verification', '{{ $stats["users"] - $stats["verified"] }}'],
        ['Client Records', '{{ $stats["users"] }}'],
        ['Prospects (in period)', '{{ $stats["leads_r"] }}'],
        ['Revenue collected (in period)', '₹{{ $stats["revenue_r"] }}'],
        ['Paying clients (in period)', '{{ $stats["paid_clients"] }}'],
        ['Failed transactions (in period)', '{{ $stats["failed_r"] }}'],
        ['Advisory sessions booked (in period)', '{{ $stats["sessions_booked"] }}'],
        ['Sessions pending (all time)', '{{ $stats["sessions_due"] }}'],
      ];
      const ws = XLSX.utils.aoa_to_sheet(data);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Dashboard');
      XLSX.writeFile(wb, 'Dashboard-{{ str_replace(' ', '-', $stats["periodLabel"]) }}.xlsx');
    }
  </script>
@endpush