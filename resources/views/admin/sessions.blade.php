@extends('admin.layout')
@section('title', 'Advisory sessions')

@push('styles')
<style>
  .hh{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:flex-start;margin-bottom:14px}
  .hr{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
  .sub{color:var(--mut)}
  .tabs{display:flex;gap:6px;margin-bottom:14px;flex-wrap:wrap}
  .tabs a,.tabs button{font:inherit;font-weight:600;border:1px solid var(--line);background:var(--card);color:var(--mut);padding:6px 13px;border-radius:99px;cursor:pointer;text-decoration:none}
  .tabs .on{background:var(--pri);color:#fff;border-color:var(--pri)}
  .chips{display:flex;gap:4px;background:var(--card);border:1px solid var(--line);border-radius:10px;padding:3px;flex-wrap:wrap}
  .chips a{font:inherit;font-weight:600;border:0;background:none;color:var(--mut);padding:5px 11px;border-radius:7px;cursor:pointer;text-decoration:none}
  .chips a.on{background:var(--pri);color:#fff}
  .card{background:var(--card);border:1px solid var(--line);border-radius:12px;overflow:hidden;margin-bottom:14px}
  .card>h3{margin:0;padding:12px 16px;font-size:14.5px;border-bottom:1px solid var(--line)}
  .sc{overflow-x:auto}
  table{border-collapse:collapse;width:100%;min-width:1120px;font-size:13px}
  th,td{text-align:left;padding:9px 14px;border-bottom:1px solid var(--line);white-space:nowrap}
  th{color:var(--mut);font-size:12.5px;font-weight:600;background:color-mix(in srgb,var(--bg) 60%,var(--card))}
  tr:last-child td{border:0}
  .pill{display:inline-block;padding:2px 9px;border-radius:99px;font-size:12px;font-weight:700;background:var(--bg);color:var(--mut)}
  .pill.ok{background:var(--ok-s);color:var(--ok)} .pill.bad{background:var(--bad-s);color:var(--bad)} .pill.warn{background:var(--warn-s);color:var(--warn)}
  .btn{display:inline-flex;align-items:center;gap:6px;font-family:inherit;font-weight:600;padding:7px 12px;border-radius:8px;border:1px solid var(--line);background:var(--card);color:var(--ink);cursor:pointer;font-size:13px;text-decoration:none}
  .btn.p{background:var(--pri);color:#fff;border-color:var(--pri)} .btn.s{padding:5px 9px;font-size:12.5px} .btn.wa{background:#25d366;color:#fff;border-color:#25d366}
  .row{display:flex;gap:6px;flex-wrap:wrap}
  .srch{display:flex;gap:6px;align-items:center;background:var(--card);border:1px solid var(--line);border-radius:10px;padding:4px 8px;flex-wrap:wrap}
  .srch input,.srch select{border:1px solid var(--line);background:var(--bg);font:inherit;color:var(--ink);padding:6px 8px;border-radius:8px}
  .srch label{font-size:12.5px;color:var(--mut);font-weight:600}
  .fg{display:grid;grid-template-columns:1fr 1fr;gap:10px}.fg .w{grid-column:1/-1}.fg label{display:block;font-size:12.5px;color:var(--mut);font-weight:600}
  .in{font:inherit;width:100%;margin-top:3px;padding:8px 10px;border:1px solid var(--line);border-radius:8px;background:var(--bg);color:var(--ink)}
  .sav{display:flex;gap:10px;align-items:center;padding:0 16px 16px;flex-wrap:wrap}
  .pager{display:flex;justify-content:space-between;align-items:center;margin-top:12px;color:var(--mut);font-size:13px}
  .em{padding:16px;color:var(--mut)}
  dialog.mo{border:0;border-radius:14px;padding:0;max-width:620px;width:96%;box-shadow:0 18px 50px rgba(15,23,42,.18)}
  .ac{display:flex;gap:8px;justify-content:flex-end;margin-top:14px}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
<script>
  const PAL = [["1F4E9E","E3ECFA"],["0F7A3D","E1F5E9"],["B45309","FDEFD8"],["6D28D9","EDE5FC"],["BE123C","FCE4EA"],["0E7490","DAF2F7"]];
  async function xlsx(file,sheets){ if(!window.ExcelJS){ alert('Excel library could not be loaded.'); return; } const wb=new ExcelJS.Workbook(),used={}; const thin={style:'thin',color:{argb:'FFCBD5E1'}}, bd={top:thin,left:thin,bottom:thin,right:thin}; sheets.forEach((s,n)=>{ const [c,l]=PAL[n%PAL.length]; let nm=String(s.name||'Sheet').replace(/[\\\/\?\*\[\]:]/g,'-').slice(0,28); used[nm]=(used[nm]||0)+1; if(used[nm]>1) nm+=' '+used[nm]; const ws=wb.addWorksheet(nm,{views:[{showGridLines:false,state:'frozen',ySplit:3}]}); const nc=Math.max((s.head||[]).length,2); ws.mergeCells(1,1,1,nc); const t=ws.getCell(1,1); t.value=s.title||s.name; t.font={bold:true,size:16,color:{argb:'FFFFFFFF'}}; t.fill={type:'pattern',pattern:'solid',fgColor:{argb:'FF'+c}}; t.alignment={vertical:'middle',indent:1}; ws.getRow(1).height=32; ws.mergeCells(2,1,2,nc); const sb=ws.getCell(2,1); sb.value=s.sub||('Retirement Plan Karo · '+new Date().toLocaleDateString('en-IN')); sb.font={italic:true,color:{argb:'FF64748B'}}; sb.alignment={indent:1}; const h=ws.getRow(3); h.values=s.head; h.height=24; h.eachCell((k)=>{ k.fill={type:'pattern',pattern:'solid',fgColor:{argb:'FF'+c}}; k.font={bold:true,color:{argb:'FFFFFFFF'}}; k.border=bd; k.alignment={vertical:'middle',horizontal:'center'}; }); (s.rows||[]).forEach((r,i)=>{ const row=ws.addRow(r); row.height=20; for(let ci=1;ci<=nc;ci++){ const k=row.getCell(ci); k.border=bd; k.alignment={vertical:'middle',wrapText:true}; k.fill={type:'pattern',pattern:'solid',fgColor:{argb: i%2 ? 'FFFFFFFF':'FF'+l}}; } }); if(!(s.rows||[]).length) ws.addRow(['No records']); s.head.forEach((x,ci)=>{ const vals=[String(x||'').length+4,...(s.rows||[]).map(r=>String((r||[])[ci]??'').length+3)]; ws.getColumn(ci+1).width=Math.min(52,Math.max(...vals)); }); ws.autoFilter={from:{row:3,column:1},to:{row:3,column:nc}}; }); const buf=await wb.xlsx.writeBuffer(); const a=document.createElement('a'); a.href=URL.createObjectURL(new Blob([buf],{type:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'})); a.download=file; a.click(); }
  async function exportSessions(){
    const rows = Array.from(document.querySelectorAll('#sess-table tbody tr')).map(tr=>{
      const t = tr.querySelectorAll('td'); if(!t.length) return null;
      return [t[0].innerText.trim().replace(/\n/g,' '), t[1].innerText.trim(), t[2].innerText.trim(), t[3].innerText.trim(), t[4].innerText.trim(), t[5].innerText.trim(), t[6].innerText.trim(), t[7].innerText.trim(), t[8].innerText.trim(), t[9].innerText.trim()];
    }).filter(Boolean);
    const sub = 'Retirement Plan Karo · '+new Date().toLocaleDateString('en-IN')+(@json($from)||@json($to)?' · '+(@json($from)||'start')+' to '+(@json($to)||'today'):'')+(@json($status)?' · Status: '+@json($status):'');
    await xlsx('Advisory_sessions.xlsx', [{ name:'Bookings', title:'Advisory session bookings', sub, head:['Customer','Mobile','Email','City','Date','Slot','Mode','Question','Advisor','Status'], rows }]);
  }
  function openSessionEdit(id, date, slot, mode, question, advisor, status, cancelReason){
    var f=document.getElementById('esForm'); f.action=@json(url('/admin/sessions')).replace(/\/$/,'')+'/'+id;
    document.getElementById('es_date').value=(date||'').slice(0,10);
    document.getElementById('es_slot').value=slot||''; document.getElementById('es_mode').value=mode||'';
    document.getElementById('es_question').value=question||''; document.getElementById('es_advisor').value=advisor||'';
    document.getElementById('es_status').value=status||'pending_payment'; document.getElementById('es_cancel').value=cancelReason||'';
    document.getElementById('editSession').showModal();
  }
</script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Advisory sessions</h2>
      <div class="sub" style="margin:2px 0 0">{{ $counts['all'] ?? 0 }} bookings</div>
    </div>
  </div>

  <div class="tabs">
    <a href="{{ route('admin.sessions', array_merge(request()->except('page'), ['tab'=>'bookings'])) }}" class="{{ $tab==='bookings'?'on':'' }}">Sessions ({{ $counts['all'] ?? 0 }})</a>
    <a href="{{ route('admin.sessions', ['tab'=>'availability']) }}" class="{{ $tab==='availability'?'on':'' }}">Availability &amp; Rules</a>
  </div>

  @if($tab === 'availability')
    <form method="POST" action="{{ route('admin.sessions.availability') }}">@csrf
      <div class="card">
        <h3>Online booking</h3>
        <div style="padding:14px 16px">
          <div class="fg">
            <label>Status<br><label style="font-weight:400;color:var(--ink)"><input type="checkbox" name="on" value="1" {{ !empty($availability['on']) ? 'checked' : '' }}> Accept session bookings</label></label>
            <label class="w">Note shown to clients<input class="in" name="notice" value="{{ $availability['notice'] ?? '' }}"></label>
          </div>
        </div>
      </div>
      <div class="card">
        <h3>Booking window</h3>
        <div style="padding:14px 16px">
          <div class="fg">
            <div class="w"><label>Available days</label><div style="margin-top:6px">
              @foreach([1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat',7=>'Sun'] as $v=>$d)
                <label style="display:inline-block;margin-right:12px;font-weight:400;color:var(--ink)"><input type="checkbox" name="days[]" value="{{ $v }}" {{ in_array($v, $availability['days'] ?? [], true) ? 'checked' : '' }}> {{ $d }}</label>
              @endforeach
            </div></div>
            <label>Time slots (one per line)<textarea class="in" name="slots" rows="4">{{ $availability['slots'] ?? '' }}</textarea></label>
            <label>Session modes (comma separated)<input class="in" name="modes" value="{{ $availability['modes'] ?? '' }}"></label>
            <label class="w">Blocked dates (YYYY-MM-DD, comma separated)<textarea class="in" name="blocked" rows="3" placeholder="2026-11-01, 2026-11-08">{{ $availability['blocked'] ?? '' }}</textarea></label>
          </div>
        </div>
      </div>
      <div class="card">
        <h3>Limits</h3>
        <div style="padding:14px 16px">
          <div class="fg">
            <label>Advance booking limit (days)<input class="in" type="number" name="win" value="{{ $availability['win'] ?? 14 }}"></label>
            <label>Max bookings per slot<input class="in" type="number" name="max" value="{{ $availability['max'] ?? 3 }}"></label>
            <label>Session length (min)<input class="in" type="number" name="dur" value="{{ $availability['dur'] ?? 30 }}"></label>
          </div>
          <div style="margin-top:12px"><b>Dates visible to clients:</b>
            @if(empty($availability['on'])) <span class="pill bad">Bookings are off</span>
            @elseif(empty($previewDates)) —
            @else @foreach($previewDates as $pd)<span class="pill" style="margin:2px">{{ $pd }}</span>@endforeach @endif
          </div>
        </div>
        <div class="sav"><button class="btn p" type="submit">Save availability</button><span class="sub">The session fee is set under Pricing &amp; Incentives → Fees &amp; Rewards. Settings stored in DB (`settings.session_availability`).</span></div>
      </div>
    </form>

  @else
    <div class="hh" style="margin-bottom:10px">
      <div class="chips">
        @php $q = request()->except('page','status'); @endphp
        <a href="{{ route('admin.sessions', array_merge($q,['status'=>''])) }}" class="{{ $status===''?'on':'' }}">All {{ $counts['all'] }}</a>
        <a href="{{ route('admin.sessions', array_merge($q,['status'=>'pending_payment'])) }}" class="{{ $status==='pending_payment'?'on':'' }}">Pending {{ $counts['pending_payment'] }}</a>
        <a href="{{ route('admin.sessions', array_merge($q,['status'=>'confirmed'])) }}" class="{{ $status==='confirmed'?'on':'' }}">Confirmed {{ $counts['confirmed'] }}</a>
        <a href="{{ route('admin.sessions', array_merge($q,['status'=>'done'])) }}" class="{{ $status==='done'?'on':'' }}">Completed {{ $counts['done'] }}</a>
        <a href="{{ route('admin.sessions', array_merge($q,['status'=>'cancelled'])) }}" class="{{ $status==='cancelled'?'on':'' }}">Cancelled {{ $counts['cancelled'] }}</a>
      </div>
      <div class="hr">
        <form class="srch" method="GET" action="{{ route('admin.sessions') }}">
          <input type="hidden" name="status" value="{{ $status }}">
          <label>From <input type="date" name="from" value="{{ $from }}"></label>
          <label>To <input type="date" name="to" value="{{ $to }}"></label>
          <button class="btn s" type="submit">Apply</button>
        </form>
        <button class="btn p" type="button" onclick="exportSessions()">Export Excel</button>
        @if($from||$to||$status)<a class="btn" href="{{ route('admin.sessions') }}">Clear</a>@endif
      </div>
    </div>

    <div class="card">
      <div class="sc">
        @if($sessions->isEmpty())
          <div class="em">No bookings in this filter.</div>
        @else
          <table id="sess-table">
            <thead><tr><th>Customer</th><th>Mobile</th><th>Email</th><th>City</th><th>Date</th><th>Slot</th><th>Mode</th><th>Question</th><th>Advisor</th><th>Status</th><th>Reason</th><th>Action</th></tr></thead>
            <tbody>
              @foreach($sessions as $s)
                @php $cname = trim(($s->name ?? '').' '.($s->surname ?? '')) ?: ($s->name ?? 'Customer'); $st = $s->status; @endphp
                <tr>
                  <td>{{ $cname }}</td>
                  <td>{{ $s->mobile ?: ($s->user_mobile ?: '—') }}</td>
                  <td>{{ $s->email ?: '—' }}</td>
                  <td>{{ $s->city ?: '—' }}</td>
                  <td>{{ $s->date ? \Illuminate\Support\Carbon::parse($s->date)->format('d M Y') : '—' }}</td>
                  <td>{{ $s->slot ?: '—' }}</td>
                  <td>{{ $s->mode ?: '—' }}</td>
                  <td style="white-space:normal;max-width:240px">{{ $s->question ?? $s->note ?? '—' }}</td>
                  <td>{{ $s->advisor ?: '—' }}</td>
                  <td>@if($st==='done')<span class="pill ok">completed</span>@elseif($st==='confirmed')<span class="pill warn">confirmed</span>@elseif($st==='cancelled')<span class="pill bad">cancelled</span>@elseif($st==='booked')<span class="pill warn">booked</span>@elseif($st==='pending_payment')<span class="pill warn">pending payment</span>@else<span class="pill">{{ $st }}</span>@endif</td>
                  <td style="white-space:normal;max-width:160px">{{ $s->cancel_reason ?: '—' }}</td>
                  <td>
                    <div class="row">
                      <button class="btn s" type="button" onclick="openSessionEdit({{ $s->id }}, @json($s->date), @json($s->slot), @json($s->mode), @json($s->question ?? $s->note ?? ''), @json($s->advisor ?? ''), @json($st), @json($s->cancel_reason ?? ''))">Edit</button>
                      @if($st !== 'confirmed' && $st !== 'done' && $st !== 'cancelled')
                        <form method="POST" action="{{ route('admin.sessions.status', $s->id) }}">@csrf<input type="hidden" name="status" value="confirmed"><button class="btn s">Confirm</button></form>
                      @endif
                      @if($st !== 'done' && $st !== 'cancelled')
                        <form method="POST" action="{{ route('admin.sessions.status', $s->id) }}">@csrf<input type="hidden" name="status" value="done"><button class="btn s p">Done</button></form>
                      @endif
                      @if($st !== 'cancelled')
                        <form method="POST" action="{{ route('admin.sessions.status', $s->id) }}">@csrf<input type="hidden" name="status" value="cancelled"><button class="btn s" style="color:var(--bad)">Cancel</button></form>
                      @endif
                      @php $wam = preg_replace('/\D/','', (string)($s->mobile ?: $s->user_mobile ?: '')); $wam = strlen($wam)>10?substr($wam,-10):$wam; @endphp
                      @if(strlen($wam)>=10)<a class="btn s wa" target="_blank" rel="noopener" href="https://wa.me/91{{ $wam }}">WhatsApp</a>@endif
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
      <div>Showing {{ $sessions->firstItem() ?? 0 }}-{{ $sessions->lastItem() ?? 0 }} of {{ $sessions->total() }}</div>
      <div>{{ $sessions->links() }}</div>
    </div>

    <dialog id="editSession" class="mo">
      <form id="esForm" method="POST" style="padding:18px 18px 14px">@csrf
        <h3 style="margin:0 0 12px">Edit session</h3>
        <div class="fg">
          <label>Date<input class="in" id="es_date" name="date" type="date"></label>
          <label>Slot<input class="in" id="es_slot" name="slot" maxlength="40"></label>
          <label>Mode<input class="in" id="es_mode" name="mode" maxlength="20" placeholder="Call / Video / WhatsApp"></label>
          <label>Advisor<input class="in" id="es_advisor" name="advisor" maxlength="120"></label>
          <label>Status<select class="in" id="es_status" name="status"><option value="pending_payment">pending_payment</option><option value="booked">booked</option><option value="confirmed">confirmed</option><option value="done">done (completed)</option><option value="cancelled">cancelled</option></select></label>
          <label class="w">Question<textarea class="in" id="es_question" name="question" rows="3" maxlength="500"></textarea></label>
          <label class="w">Cancel reason<input class="in" id="es_cancel" name="cancel_reason" maxlength="300"></label>
        </div>
        <div class="ac"><button class="btn" type="button" onclick="document.getElementById('editSession').close()">Cancel</button><button class="btn p" type="submit">Save</button></div>
      </form>
    </dialog>
  @endif
@endsection
