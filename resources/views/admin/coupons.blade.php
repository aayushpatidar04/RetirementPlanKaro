@extends('admin.layout')
@section('title', 'Discount codes')

@push('styles')
  <style>
    .hh { display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; margin-bottom:14px }
    .hr { display:flex; gap:8px; flex-wrap:wrap; align-items:center }
    .sub { color:var(--mut) }
    .card { background:var(--card); border:1px solid var(--line); border-radius:12px; overflow:hidden; margin-bottom:14px }
    .sc { overflow-x:auto }
    table { border-collapse:collapse; width:100%; min-width:980px; font-size:13px }
    th,td { text-align:left; padding:9px 14px; border-bottom:1px solid var(--line); white-space:nowrap }
    th { color:var(--mut); font-size:12.5px; font-weight:600; background:color-mix(in srgb,var(--bg) 60%,var(--card)) }
    tr:last-child td { border:0 }
    .pill { display:inline-block; padding:2px 9px; border-radius:99px; font-size:12px; font-weight:700; background:var(--bg); color:var(--mut) }
    .pill.ok { background:var(--ok-s); color:var(--ok) }
    .pill.bad { background:var(--bad-s); color:var(--bad) }
    .btn { display:inline-flex; align-items:center; gap:6px; font-family:inherit; font-weight:600; padding:7px 12px; border-radius:8px; border:1px solid var(--line); background:var(--card); color:var(--ink); cursor:pointer; font-size:13px; text-decoration:none }
    .btn.p { background:var(--pri); color:#fff; border-color:var(--pri) }
    .btn.s { padding:5px 9px; font-size:12.5px }
    .btn.d { color:var(--bad); border-color:color-mix(in srgb,var(--bad) 40%,var(--line)) }
    .row { display:flex; gap:6px; flex-wrap:wrap; align-items:center }
    .form { display:flex; gap:8px; flex-wrap:wrap; align-items:center; padding:14px 16px }
    .form input, .form select { border:1px solid var(--line); background:var(--card); color:var(--ink); border-radius:8px; padding:7px 10px; font:inherit }
    .em { padding:16px; color:var(--mut) }
  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script>
    function exportCoupons(){
      const rows = [];
      document.querySelectorAll('#coupons-table tbody tr').forEach(tr=>{
        const tds = tr.querySelectorAll('td');
        if(tds.length===0) return;
        rows.push([tds[0].innerText, tds[1].innerText, tds[2].innerText, tds[3].innerText, tds[4].innerText, tds[5].innerText, tds[6].innerText]);
      });
      const ws = XLSX.utils.aoa_to_sheet([['Code','Type','Value','Used','Max uses','Expires','Status'], ...rows]);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Coupons');
      XLSX.writeFile(wb, 'Discount_codes.xlsx');
    }
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Discount codes</h2>
      <div class="sub" style="margin:2px 0 0">Create and manage discount codes</div>
    </div>
    <div class="hr">
      <button class="btn" type="button" onclick="exportCoupons()">Export Excel</button>
    </div>
  </div>

  <div class="card">
    <div style="padding:12px 16px; border-bottom:1px solid var(--line); font-weight:600">Add a coupon</div>
    <form method="POST" action="{{ route('admin.coupons.store') }}" class="form">
      @csrf
      <input name="code" placeholder="CODE" maxlength="30" required style="text-transform:uppercase">
      <select name="type"><option value="flat">Flat ₹ off</option><option value="percent">% off</option></select>
      <input name="value" type="number" step="1" min="1" placeholder="Value" required style="width:110px">
      <input name="max_uses" type="number" min="1" placeholder="Max uses (optional)" style="width:170px">
      <input name="expires_at" type="date" placeholder="Expires (optional)">
      <button class="btn p" type="submit">Add coupon</button>
    </form>
    @if($errors->any())<div style="padding:0 16px 14px;color:var(--bad);font-size:13px">{{ $errors->first() }}</div>@endif
  </div>

  <div class="card">
    <div style="padding:12px 16px; border-bottom:1px solid var(--line); font-weight:600">All coupons</div>
    <div class="sc">
      @if($coupons->isEmpty())
        <div class="em">No coupons yet.</div>
      @else
        <table id="coupons-table">
          <thead><tr><th>Code</th><th>Type</th><th>Value</th><th>Used</th><th>Max uses</th><th>Expires</th><th>Status</th><th>Action</th></tr></thead>
          <tbody>
            @foreach($coupons as $c)
              <tr>
                <td><b>{{ $c->code }}</b></td>
                <td>{{ $c->type==='flat'?'Flat ₹':'Percent' }}</td>
                <td>{{ $c->type==='flat'?'₹'.number_format($c->value):$c->value.'%' }}</td>
                <td>{{ $c->used_count }}</td>
                <td>{{ $c->max_uses ?? 'Unlimited' }}</td>
                <td>{{ $c->expires_at ? \Illuminate\Support\Carbon::parse($c->expires_at)->format('d M Y') : 'No expiry' }}</td>
                <td>@if($c->active)<span class="pill ok">Active</span>@else<span class="pill bad">Disabled</span>@endif</td>
                <td>
                  <div class="row">
                    <form method="POST" action="{{ route('admin.coupons.toggle',$c->id) }}">@csrf<button class="btn s">{{ $c->active?'Disable':'Enable' }}</button></form>
                    <form method="POST" action="{{ route('admin.coupons.delete',$c->id) }}" onsubmit="return confirm('Delete this coupon?')">@csrf<button class="btn s d">Delete</button></form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection
