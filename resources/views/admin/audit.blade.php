@extends('admin.layout')
@section('title', 'Audit Trail')
@include('admin.partials.kit')

@section('content')
  <div class="adm">
    <div class="hh">
      <div>
        <h2 style="margin:0">Audit Trail</h2>
        <div class="sub" style="margin:2px 0 0">Administration · Record of every change with before/after values</div>
      </div>
    </div>

    <div class="card">
      <h3>Filters</h3>
      <form method="GET" action="{{ route('admin.audit') }}" class="pg">
        <div><label>From date<input class="in" name="from" type="date" value="{{ request('from') }}"></label></div>
        <div><label>To date<input class="in" name="to" type="date" value="{{ request('to') }}"></label></div>
        <div>
          <label>Action
            <select class="in" name="action">
              <option value="">All actions</option>
              @foreach($actions as $a)
                <option value="{{ $a }}" @selected(request('action') === $a)>{{ $a }}</option>
              @endforeach
            </select>
          </label>
        </div>
        <div>
          <label>Subject type
            <select class="in" name="subject_type">
              <option value="">All types</option>
              @foreach($subjectTypes as $t)
                <option value="{{ $t }}" @selected(request('subject_type') === $t)>{{ $t }}</option>
              @endforeach
            </select>
          </label>
        </div>
        <div>
          <label>User
            <select class="in" name="user_id">
              <option value="">All users</option>
              @foreach($users as $u)
                <option value="{{ $u->id }}" @selected((string) request('user_id') === (string) $u->id)>{{ $u->name }}
                </option>
              @endforeach
            </select>
          </label>
        </div>
        <div class="w row">
          <button type="submit" class="btn p">Apply filters</button>
          <a href="{{ route('admin.audit') }}" class="btn">Clear</a>
          <button type="button" class="btn" data-export="{{ route('admin.audit.export', request()->except('page')) }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
              <polyline points="7 10 12 15 17 10" />
              <line x1="12" y1="15" x2="12" y2="3" />
            </svg>
            Export Excel
          </button>
        </div>
      </form>
    </div>

    <div class="card">
      <h3>Audit trail · {{ $audits->total() }} changes · what changed, previous value and new value</h3>
      @if($audits->isEmpty())
        <div class="em">No audit records found.</div>
      @else
        <div class="sc">
          <table>
            <thead>
              <tr>
                <th>When</th>
                <th>Admin</th>
                <th>Action</th>
                <th>Subject Type</th>
                <th>Subject ID</th>
                <th>Details (before → after)</th>
                <th>IP</th>
              </tr>
            </thead>
            <tbody>
              @foreach($audits as $log)
                @php
                  $props = $log->properties;
                  $flat = json_encode($props, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                  $pretty = json_encode($props, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                  $empty = $props === null || $props === [] || $flat === '[]' || $flat === 'null';
                @endphp
                <tr>
                  <td>{{ $log->created_at?->format('d M Y H:i:s') }}</td>
                  <td>{{ $log->user?->name ?? 'System' }}</td>
                  <td><span class="pill">{{ $log->action }}</span></td>
                  <td>{{ $log->subject_type ?? '—' }}</td>
                  <td>{{ $log->subject_id ?? '—' }}</td>
                  <td class="wrap">
                    @if($empty)
                      <span class="muted">—</span>
                    @else
                      <details class="det">
                        <summary>{{ \Illuminate\Support\Str::limit($flat, 110) }}</summary>
                        <pre>{{ $pretty }}</pre>
                      </details>
                    @endif
                  </td>
                  <td>{{ $log->ip ?? '—' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if($audits->hasPages())
          {{ $audits->withQueryString()->links('vendor.pagination.admin') }}
        @endif
      @endif
    </div>

    <div class="tt" id="tt"></div>
  </div>
@endsection