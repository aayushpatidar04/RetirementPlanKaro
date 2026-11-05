@extends('admin.layout')
@section('title', 'Client Records')

@push('styles')
  <style>
    .hh{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:flex-start;margin-bottom:14px}
    .hr{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .sub{color:var(--mut)}
    .kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:10px;margin-bottom:16px}
    .k{background:var(--card);border:1px solid var(--line);border-radius:12px;padding:12px 14px}
    .k span{color:var(--mut);font-size:12.5px}
    .k b{display:block;font-size:21px}
    .pick{display:flex;gap:8px;margin:0;flex-wrap:wrap;align-items:center}
    .pick input{font:inherit;padding:9px 12px;border:1px solid var(--line);border-radius:10px;background:var(--card);color:var(--ink);width:260px}
    .card{background:var(--card);border:1px solid var(--line);border-radius:12px;overflow:hidden;margin-bottom:14px}
    .sc{overflow-x:auto}
    table{border-collapse:collapse;width:100%;min-width:760px;font-size:13px}
    th,td{text-align:left;padding:9px 14px;border-bottom:1px solid var(--line);white-space:nowrap}
    th{color:var(--mut);font-size:12.5px;font-weight:600;background:color-mix(in srgb,var(--bg) 60%,var(--card))}
    tr:last-child td{border:0}
    .btn{display:inline-flex;align-items:center;gap:6px;font-family:inherit;font-weight:600;padding:7px 12px;border-radius:8px;border:1px solid var(--line);background:var(--card);color:var(--ink);cursor:pointer;font-size:13px;text-decoration:none}
    .btn.p{background:var(--pri);color:#fff;border-color:var(--pri)}
    .pager{display:flex;justify-content:space-between;align-items:center;margin-top:12px;color:var(--mut);font-size:13px}
    .em{padding:16px;color:var(--mut)}
  </style>
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
  <script>
    const PAL = [["1F4E9E","E3ECFA"],["0F7A3D","E1F5E9"],["B45309","FDEFD8"],["6D28D9","EDE5FC"],["BE123C","FCE4EA"],["0E7490","DAF2F7"]];
    async function xlsx(file, sheets){ if(!window.ExcelJS){ alert('Excel library could not be loaded.'); return; } const wb=new ExcelJS.Workbook(), used={}; const thin={style:'thin',color:{argb:'FFCBD5E1'}}, bd={top:thin,left:thin,bottom:thin,right:thin}; sheets.forEach((s,n)=>{ const [c,l]=PAL[n%PAL.length]; let nm=String(s.name||'Sheet').replace(/[\\\/\?\*\[\]:]/g,'-').slice(0,28); used[nm]=(used[nm]||0)+1; if(used[nm]>1) nm+=' '+used[nm]; const ws=wb.addWorksheet(nm,{views:[{showGridLines:false,state:'frozen',ySplit:3}]}); const nc=Math.max((s.head||[]).length,2); ws.mergeCells(1,1,1,nc); const t=ws.getCell(1,1); t.value=s.title||s.name; t.font={bold:true,size:16,color:{argb:'FFFFFFFF'}}; t.fill={type:'pattern',pattern:'solid',fgColor:{argb:'FF'+c}}; t.alignment={vertical:'middle',indent:1}; ws.getRow(1).height=32; ws.mergeCells(2,1,2,nc); const sb=ws.getCell(2,1); sb.value=s.sub||('Retirement Plan Karo · '+new Date().toLocaleDateString('en-IN')); sb.font={italic:true,color:{argb:'FF64748B'}}; sb.alignment={indent:1}; const h=ws.getRow(3); h.values=s.head; h.height=24; h.eachCell((k)=>{ k.fill={type:'pattern',pattern:'solid',fgColor:{argb:'FF'+c}}; k.font={bold:true,color:{argb:'FFFFFFFF'}}; k.border=bd; k.alignment={vertical:'middle',horizontal:'center'}; }); (s.rows||[]).forEach((r,i)=>{ const row=ws.addRow(r); row.height=20; for(let ci=1;ci<=nc;ci++){ const k=row.getCell(ci); k.border=bd; k.alignment={vertical:'middle',wrapText:true}; k.fill={type:'pattern',pattern:'solid',fgColor:{argb: i%2 ? 'FFFFFFFF':'FF'+l}}; if(typeof k.value==='number' && Math.abs(k.value)>=1000) k.numFmt='#,##0.##'; } }); if(!(s.rows||[]).length) ws.addRow(['No records']); s.head.forEach((x,ci)=>{ const vals=[String(x||'').length+4,...(s.rows||[]).map(r=>String((r||[])[ci]??'').length+3)]; ws.getColumn(ci+1).width=Math.min(52,Math.max(...vals)); }); ws.autoFilter={from:{row:3,column:1},to:{row:3,column:nc}}; }); const buf=await wb.xlsx.writeBuffer(); const a=document.createElement('a'); a.href=URL.createObjectURL(new Blob([buf],{type:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'})); a.download=file; a.click(); }
    async function exportClients(){
      const rows = Array.from(document.querySelectorAll('#clients-table tbody tr')).map(tr=>{
        const t = tr.querySelectorAll('td'); if(!t.length) return null;
        return [t[0].innerText.trim(), t[1].innerText.trim(), t[2].innerText.trim(), t[3].innerText.trim(), t[4].innerText.trim(), t[5].innerText.trim(), t[6].innerText.trim()];
      }).filter(Boolean);
      await xlsx('Client_Records.xlsx', [{ name:'Client Records', title:'Client Records', sub:'Retirement Plan Karo · '+new Date().toLocaleDateString('en-IN')+' · {{ $users->total() }} total' + (@json($q) ? ' · Search: '+@json($q) : ''), head:['Name','Mobile','Email','City','Referral','Joined','Status'], rows }]);
    }
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Client Records</h2>
      <div class="sub" style="margin:2px 0 0">{{ $users->total() }} total accounts @if($q) · Search: {{ $q }} @endif</div>
    </div>
    <div class="hr">
      <form class="pick" method="GET" action="{{ route('admin.users') }}">
        <input type="text" name="q" value="{{ $q }}" placeholder="Search name, mobile, email">
        <button class="btn" type="submit">Search</button>
        @if($q)<a class="btn" href="{{ route('admin.users') }}">Reset</a>@endif
      </form>
      <button class="btn p" type="button" onclick="exportClients()">Export Excel</button>
    </div>
  </div>

  <div class="kpis">
    <div class="k"><span>Total clients</span><b>{{ $users->total() }}</b></div>
    <div class="k"><span>Showing (page)</span><b>{{ $users->count() }}</b></div>
  </div>

  <div class="card">
    <div class="sc">
      @if($users->isEmpty())
        <div class="em">No users found.</div>
      @else
        <table id="clients-table">
          <thead>
            <tr><th>Name</th><th>Mobile</th><th>Email</th><th>City</th><th>Referral</th><th>Joined</th><th>Status</th><th></th></tr>
          </thead>
          <tbody>
            @foreach($users as $u)
              <tr>
                <td>{{ trim(($u->name ?? '').' '.($u->surname ?? '')) ?: '—' }}</td>
                <td>{{ $u->mobile ?: '—' }}</td>
                <td>{{ $u->email ?: '—' }}</td>
                <td>{{ $u->city ?: '—' }}</td>
                <td>{{ $u->referral_code ?: '—' }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($u->created_at)->format('d M Y') }}</td>
                <td>{{ $u->status ?? '—' }}</td>
                <td><a class="btn" href="{{ route('admin.users.show', $u->id) }}">View</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div class="pager">
    <div>Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}</div>
    <div>{{ $users->links() }}</div>
  </div>
@endsection
