@php
  use Illuminate\Support\Carbon;
  $who = function ($r) {
    $r = (array) $r;
    return ($r['name'] ?? '') ?: (($r['mobile'] ?? '') ?: ($r['email'] ?? ''));
  };
@endphp

@if($pending->isNotEmpty())
  <div class="card">
    <h3>Scheduled · {{ $pending->count() }} pending{{ $dueCount ? ' · ' . $dueCount . ' due now' : '' }}</h3>
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
          @foreach($pending as $x)
            @php $due = Carbon::parse($x->scheduled_at)->lte(now()); @endphp
            <tr>
              <td>{{ Carbon::parse($x->scheduled_at)->format('d M Y H:i') }}</td>
              <td><span
                  class="pill {{ $x->channel === 'wa' ? 'ok' : 'pri' }}">{{ $x->channel === 'wa' ? 'WhatsApp' : 'Email' }}</span>
              </td>
              <td>{{ $who($x->recipient) }}</td>
              <td>{{ $x->subject ?? '' }}</td>
              <td><span class="pill {{ $due ? 'bad' : 'warn' }}">{{ $due ? 'Due now' : 'Scheduled' }}</span></td>
              <td>
                <div class="row">
                  {{-- data-open: the chat/compose window opens first, then the form posts and logs it --}}
                  <form method="POST" action="{{ route('admin.messages.scheduled.send') }}" class="inline" @if($x->open_url)
                  data-open="{{ $x->open_url }}" @endif>
                    @csrf
                    <input type="hidden" name="id" value="{{ $x->id }}">
                    <button type="submit" class="btn s p" @disabled(!$x->open_url)
                      title="{{ $x->open_url ? '' : 'No valid contact' }}">Send now</button>
                  </form>
                  <form method="POST" action="{{ route('admin.messages.scheduled.cancel') }}" class="inline">
                    @csrf
                    <input type="hidden" name="id" value="{{ $x->id }}">
                    <button type="submit" class="btn s d" data-confirm="Cancel this scheduled message?">Cancel</button>
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
  <h3>Sent messages · {{ $logsQuery->total() }}</h3>

  <form method="GET" action="{{ route('admin.messages') }}" class="bar" style="padding:12px 16px 0">
    <input type="hidden" name="tab" value="act">
    <input class="in" type="date" name="from" value="{{ request('from') }}" style="width:auto" title="From">
    <input class="in" type="date" name="to" value="{{ request('to') }}" style="width:auto" title="To">
    <select class="in" name="log_channel" style="width:auto">
      <option value="">All channels</option>
      <option value="wa" @selected(request('log_channel') === 'wa')>WhatsApp</option>
      <option value="em" @selected(request('log_channel') === 'em')>Email</option>
    </select>
    <button class="btn p" type="submit">Filter</button>
    <a class="btn" href="{{ route('admin.messages', ['tab' => 'act']) }}">Reset</a>
  </form>

  <div class="sc">
    @if($logsQuery->isEmpty())
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
          @foreach($logsQuery as $c)
            <tr>
              <td>{{ $c->sent_at ? Carbon::parse($c->sent_at)->format('d M Y H:i') : '' }}</td>
              <td>{{ $who($c->recipient) }}</td>
              <td><span
                  class="pill {{ $c->channel === 'wa' ? 'ok' : 'pri' }}">{{ $c->channel === 'wa' ? 'WhatsApp' : 'Email' }}</span>
              </td>
              <td>{{ $c->subject ?? '' }}</td>
              <td><span class="pill {{ $c->status === 'sent' ? 'ok' : 'bad' }}">{{ $c->status }}</span></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  @if($logsQuery->hasPages())
    <div style="padding:12px 16px;display:flex;justify-content:center">{{ $logsQuery->links() }}</div>
  @endif

  <div class="ac" style="margin:12px 16px;border-top:1px solid var(--line);padding-top:12px">
    <button type="button" class="btn p"
      data-export="{{ route('admin.messages.export.logs', request()->only('from', 'to', 'log_channel')) }}">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
        <polyline points="7 10 12 15 17 10" />
        <line x1="12" y1="15" x2="12" y2="3" />
      </svg>
      Export Logs
    </button>
  </div>
</div>