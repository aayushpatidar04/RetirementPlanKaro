@extends('admin.layout')
@section('title', 'Advisory sessions')

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

    .btn.d {
      color: var(--bad);
      border-color: color-mix(in srgb, var(--bad) 40%, var(--line))
    }

    .row {
      display: flex;
      gap: 6px;
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
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script>
    function exportSessions() {
      const rows = [];
      document.querySelectorAll('#sess-table tbody tr').forEach(tr => {
        const tds = tr.querySelectorAll('td');
        if (tds.length === 0) return;
        rows.push([tds[0].innerText.replace(/\n/g, ' '), tds[1].innerText, tds[2].innerText, tds[3].innerText, tds[4].innerText, tds[5].innerText]);
      });
      const ws = XLSX.utils.aoa_to_sheet([['Customer', 'Date', 'Slot', 'Mode', 'Question', 'Status'], ...rows]);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Sessions');
      XLSX.writeFile(wb, 'Advisory_sessions.xlsx');
    }
  </script>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Advisory sessions</h2>
      <div class="sub" style="margin:2px 0 0">{{ $sessions->total() }} bookings</div>
    </div>
    <div class="hr">
      <button class="btn" type="button" onclick="exportSessions()">Export Excel</button>
    </div>
  </div>

  <div class="card">
    <div class="sc">
      @if($sessions->isEmpty())
        <div class="em">No bookings.</div>
      @else
        <table id="sess-table">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Date</th>
              <th>Slot</th>
              <th>Mode</th>
              <th>Mobile</th>
              <th>Question</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sessions as $s)
              <tr>
                <td>{{ $s->name }}<br><small style="color:var(--mut)">{{ $s->email }}</small></td>
                <td>{{ \Illuminate\Support\Carbon::parse($s->date)->format('d M Y') }}</td>
                <td>{{ $s->slot }}</td>
                <td>{{ $s->mode }}</td>
                <td>{{ $s->mobile }}</td>
                <td style="white-space:normal;max-width:280px">{{ $s->question ?? $s->note ?? '—' }}</td>
                <td>
                  @if($s->status === 'confirmed')<span class="pill warn">confirmed</span>
                  @elseif($s->status === 'done')<span class="pill ok">done</span>
                  @elseif($s->status === 'cancelled')<span class="pill bad">cancelled</span>
                  @else<span class="pill">{{ $s->status }}</span>
                  @endif
                </td>
                <td>
                  <div class="row">
                    @if($s->status !== 'done')
                      <form method="POST" action="{{ route('admin.sessions.status', $s->id) }}">@csrf<input type="hidden"
                          name="status" value="done"><button class="btn s p">Mark done</button></form>
                    @endif
                    @if($s->status !== 'confirmed')
                      <form method="POST" action="{{ route('admin.sessions.status', $s->id) }}">@csrf<input type="hidden"
                          name="status" value="confirmed"><button class="btn s">Confirm</button></form>
                    @endif
                    @if($s->status !== 'cancelled')
                      <form method="POST" action="{{ route('admin.sessions.status', $s->id) }}">@csrf<input type="hidden"
                          name="status" value="cancelled"><button class="btn s d">Cancel</button></form>
                    @endif
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
@endsection
