@extends("admin.layout")

@section("title", "Transactions")

@push("styles")
  <style>
    .hh { display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; margin-bottom:14px }
    .hr { display:flex; gap:8px; flex-wrap:wrap; align-items:center }
    .sub { color:var(--mut) }
    .card { background:var(--card); border:1px solid var(--line); border-radius:12px; overflow:hidden; margin-bottom:14px }
    .sc { overflow-x:auto }
    table { border-collapse:collapse; width:100%; min-width:920px; font-size:13px }
    th,td { text-align:left; padding:9px 14px; border-bottom:1px solid var(--line); white-space:nowrap }
    th { color:var(--mut); font-size:12.5px; font-weight:600; background:color-mix(in srgb,var(--bg) 60%,var(--card)) }
    tr:last-child td { border:0 }
    .pill { display:inline-block; padding:2px 9px; border-radius:99px; font-size:12px; font-weight:700; background:var(--bg); color:var(--mut) }
    .pill.ok { background:var(--ok-s); color:var(--ok) }
    .pill.bad { background:var(--bad-s); color:var(--bad) }
    .pill.warn { background:var(--warn-s); color:var(--warn) }
    .btn { display:inline-flex; align-items:center; gap:6px; font-family:inherit; font-weight:600; padding:7px 12px; border-radius:8px; border:1px solid var(--line); background:var(--card); color:var(--ink); cursor:pointer; font-size:13px; text-decoration:none }
    .srch { display:flex; gap:6px; align-items:center; background:var(--card); border:1px solid var(--line); border-radius:10px; padding:4px 8px }
    .srch select { border:0; background:transparent; font:inherit; color:var(--ink); padding:6px 4px }
    .pager { display:flex; justify-content:space-between; align-items:center; margin-top:12px; color:var(--mut); font-size:13px }
    .em { padding:16px; color:var(--mut) }
  </style>
@endpush

@push("scripts")
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script>
    function exportPayments(){
      const rows = [];
      document.querySelectorAll("#payments-table tbody tr").forEach(tr=>{
        const tds = tr.querySelectorAll("td");
        if(tds.length===0) return;
        rows.push([
          tds[0].innerText,
          tds[1].innerText,
          tds[2].innerText,
          tds[3].innerText,
          tds[4].innerText.replace(/[^0-9.]/g,""),
          tds[5].innerText,
          tds[6].innerText,
          tds[7].innerText,
          tds[8].innerText,
        ]);
      });
      const ws = XLSX.utils.aoa_to_sheet([["Txn ID","Customer","Mobile","Purpose","Amount","Coupon","Status","PayU ID","When"], ...rows]);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, "Transactions");
      XLSX.writeFile(wb, "Transactions.xlsx");
    }
  </script>
@endpush

@section("content")
  <div class="hh">
    <div>
      <h2 style="margin:0">Transactions</h2>
      <div class="sub" style="margin:2px 0 0">Revenue collected: ₹{{ number_format($totals["success"]) }} · {{ $totals["pending"] }} pending · {{ $totals["failed"] }} failed</div>
    </div>
    <div class="hr">
      <form class="srch" method="GET" action="{{ route("admin.payments") }}">
        <select name="status" onchange="this.form.submit()">
          <option value="">All statuses</option>
          <option value="success" {{ $status === "success" ? "selected" : "" }}>Success</option>
          <option value="pending" {{ $status === "pending" ? "selected" : "" }}>Pending</option>
          <option value="failed" {{ $status === "failed" ? "selected" : "" }}>Failed</option>
        </select>
      </form>
      <button class="btn" type="button" onclick="exportPayments()">Export Excel</button>
      @if($status)<a class="btn" href="{{ route("admin.payments") }}">Clear</a>@endif
    </div>
  </div>

  <div class="card">
    <div class="sc">
      @if($payments->isEmpty())
        <div class="em">No payments.</div>
      @else
        <table id="payments-table">
          <thead><tr><th>Txn ID</th><th>Customer</th><th>Mobile</th><th>Purpose</th><th>Amount</th><th>Coupon</th><th>Status</th><th>PayU ID</th><th>When</th></tr></thead>
          <tbody>
            @foreach($payments as $p)
              <tr>
                <td>{{ $p->txnid }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->mobile }}</td>
                <td>{{ ucfirst($p->purpose) }}</td>
                <td>₹{{ number_format($p->amount, 2) }}</td>
                <td>{{ $p->coupon_code ?? '—' }}</td>
                <td>@if($p->status==="success")<span class="pill ok">success</span>@elseif($p->status==="failed")<span class="pill bad">failed</span>@else<span class="pill warn">{{ $p->status }}</span>@endif</td>
                <td>{{ $p->payu_id ?? '—' }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format("d M Y, h:i A") }}</td>
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
