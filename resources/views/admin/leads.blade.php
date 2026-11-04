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
      min-width: 820px;
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

    .srch {
      display: flex;
      gap: 6px;
      align-items: center;
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 10px;
      padding: 4px 8px
    }

    .srch select {
      border: 0;
      background: transparent;
      font: inherit;
      color: var(--ink);
      padding: 6px 4px
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

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">Prospects</h2>
      <div class="sub" style="margin:2px 0 0">{{ $leads->total() }} total</div>
    </div>
    <div class="hr">
      <div class="chips">
        <a href="{{ route('admin.leads') }}" class="{{ empty($event) ? 'on' : '' }}">All</a>
        @foreach($events as $e)
          <a href="{{ route('admin.leads', ['event' => $e]) }}" class="{{ $event === $e ? 'on' : '' }}">{{ $e }}</a>
        @endforeach
      </div>

      <button class="btn p">Message all</button>
    </div>
  </div>

  <div class="card">
    <div class="sc">
      @if($leads->isEmpty())
        <div class="em">No prospects found.</div>
      @else
        <table>
          <thead>
            <tr>
              <th>Event</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>IP</th>
              <th>User ID</th>
              <th>When</th>
            </tr>
          </thead>
          <tbody>
            @foreach($leads as $l)
              <tr>
                <td><span class="pill pri">{{ $l->event }}</span></td>
                <td>{{ $l->mobile ?? '—' }}</td>
                <td>{{ $l->email ?? '—' }}</td>
                <td>{{ $l->ip ?? '—' }}</td>
                <td>{{ $l->user_id ?? '—' }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y, h:i A') }}</td>
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
@endsection