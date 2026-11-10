@php
  $logs = $logsQuery->items();
  $scheduledItems = $scheduled->items();
@endphp

@if($scheduledItems->where('done', false)->isNotEmpty())
  <div class="card">
    <h3>Scheduled · {{ $scheduledItems->where('done', false)->count() }} pending{{ $scheduledItems->where('done', false)->where('scheduled_at', '<=', now())->count() ? ' · ' . $scheduledItems->where('done', false)->where('scheduled_at', '<=', now())->count() . ' due now' : '' }}</h3>
    <div class="sc">
      <table>
        <thead>
          <tr>
            <th>Send at</th>
            <th>Channel</th>
            <th>To</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($scheduledItems->where('done', false) as $x)
            <tr>
              <td>{{ $x->scheduled_at ? \Carbon\Carbon::parse($x->scheduled_at)->format('d M Y H:i') : '' }}</td>
              <td><span class="pill {{ $x->ch === 'wa' ? 'ok' : 'pri' }}">{{ $x->ch === 'wa' ? 'WhatsApp' : 'Email' }}</span></td>
              <td>{{ $x->recipient['name'] ?? $x->recipient['mobile'] ?? $x->recipient['email'] ?? '' }}</td>
              <td>{{ $x->subject ?? '' }}</td>
              <td>
                @if(new \Carbon\Carbon($x->scheduled_at) <= now())
                  <span class="pill bad">Due now</span>
                @else
                  <span class="pill warn">Scheduled</span>
                @endif
              </td>
              <td>
                <div class="row">
                  <form method="POST" action="{{ route('admin.messages.scheduled.send') }}" class="inline">
                    @csrf
                    <input type="hidden" name="id" value="{{ $x->id }}">
                    <button type="submit" class="btn s p">Send now</button>
                  </form>
                  <form method="POST" action="{{ route('admin.messages.scheduled.cancel') }}" class="inline" onsubmit="return confirm('Cancel this scheduled message?')">
                    @csrf
                    <input type="hidden" name="id" value="{{ $x->id }}">
                    <button type="submit" class="btn s d">Cancel</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif

<div class="card">
  <h3>Sent messages · {{ $logs->count() }}</h3>
  <div class="sc">
    @if($logs->isEmpty())
      <div class="em">No records</div>
    @else
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>To</th>
            <th>Channel</th>
            <th>Subject</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($logs as $c)
            <tr>
              <td>{{ $c->sent_at ? \Carbon\Carbon::parse($c->sent_at)->format('d M Y H:i') : '' }}</td>
              <td>{{ $c->recipient['name'] ?? $c->recipient['mobile'] ?? $c->recipient['email'] ?? '' }}</td>
              <td><span class="pill {{ $c->channel === 'wa' ? 'ok' : 'pri' }}">{{ $c->channel === 'wa' ? 'WhatsApp' : 'Email' }}</span></td>
              <td>{{ $c->subject ?? '' }}</td>
              <td><span class="pill {{ $c->status === 'sent' ? 'ok' : 'bad' }}">{{ $c->status }}</span></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  {{-- Pagination --}}
  @if($logsQuery->hasPages())
    <div style="padding:12px 16px;display:flex;gap:8px;align-items:center;justify-content:center;flex-wrap:wrap">
      {{ $logsQuery->appends(request()->except('page'))->links() }}
    </div>
  @endif

  {{-- Export --}}
  <div class="ac" style="margin:12px 16px 0;border-top:1px solid var(--line);padding-top:12px">
    <a href="{{ route('admin.messages.export.logs', request()->query()) }}" class="btn p">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Export Logs
    </a>
  </div>
</div>