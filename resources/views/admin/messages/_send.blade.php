@php
  $wa = $channel === 'wa';
  $hasContact = $wa ? 'mobile' : 'email';
  $templates = $wa ? $waTemplates : $emTemplates;
  $queryParams = request()->except(['tab', 'channel']);
  $segment = request()->query('segment', 'all');
  $sentIds = request()->query('sent', []);
  if (is_string($sentIds))
    $sentIds = json_decode($sentIds, true) ?? [];
  $sentKey = fn($r) => ($r['u']->id ?? 'new') . '|' . ($wa ? ($r['mobile'] ?? '') : ($r['email'] ?? ''));
  $left = $recipients->filter(fn($r) => !in_array($sentKey($r), $sentIds))->values();
  $leftCount = $left->count();
  $totalCount = $recipients->count();
  $allSent = $totalCount > 0 && $leftCount === 0;
  $canSend = $totalCount > 0 && $leftCount > 0;
  $canSendEmail = $canSend && !$wa && (request()->filled('subject') || !request()->filled('subject'));
  $canSendWa = $canSend && $wa;
@endphp

<div class="card" style="margin:0">
  <form method="GET" action="{{ route('admin.messages') }}">
    <input type="hidden" name="tab" value="send">
    <input type="hidden" name="channel" value="{{ $channel }}">

    <!-- Step 1: Channel -->
    <div class="ms-sec">
      <div class="ms-h"><i>1</i>Send through</div>
      <div class="tbs" style="margin:0">
        <a href="{{ route('admin.messages', array_merge(['channel' => 'wa'], $queryParams)) }}"
          class="{{ $wa ? 'on' : '' }}">WhatsApp</a>
        <a href="{{ route('admin.messages', array_merge(['channel' => 'em'], $queryParams)) }}"
          class="{{ !$wa ? 'on' : '' }}">Email</a>
      </div>
    </div>

    <!-- Step 2: Recipients -->
    <div class="ms-sec">
      <div class="ms-h"><i>2</i>Who gets it? <small>Tick or untick people · or add new numbers / emails</small></div>
      <div class="ms-row">
        <select id="ms-seg" name="segment" onchange="this.form.submit()">
          <option value="all" {{ $segment === 'all' ? 'selected' : '' }}>All customers</option>
          <option value="paid" {{ $segment === 'paid' ? 'selected' : '' }}>Paid customers</option>
          <option value="unpaid" {{ $segment === 'unpaid' ? 'selected' : '' }}>Unpaid / failed</option>
          <option value="wallet" {{ $segment === 'wallet' ? 'selected' : '' }}>Wallet users</option>
          <option value="leads" {{ $segment === 'leads' ? 'selected' : '' }}>Leads (signed up only)</option>
          @if(count($fixed))
            <optgroup label="Other">
              <option value="__fixed" {{ $segment === '__fixed' ? 'selected' : '' }}>Leads you filtered
                ({{ count($fixed) }})</option>
            </optgroup>
          @endif
          <optgroup label="By lead stage">
            @foreach($leadStages as $stage)
              <option value="stage_{{ $stage }}" {{ $segment === 'stage_' . $stage ? 'selected' : '' }}>Stage · {{ $stage }}
              </option>
            @endforeach
          </optgroup>
          <optgroup label="Other">
            <option value="new_only" {{ $segment === 'new_only' ? 'selected' : '' }}>Only new numbers / emails</option>
          </optgroup>
        </select>
        <button type="button" class="btn s" data-msall="1">Select all</button>
        <button type="button" class="btn s" data-msall="0">Select none</button>
      </div>

      <div class="ms-list sc">
        @if($recipients->isEmpty())
          <div class="em">No recipients yet — choose a group above or add numbers below.</div>
        @else
          <table>
            <thead>
              <tr>
                <th></th>
                <th>Name</th>
                <th>{{ $wa ? 'WhatsApp number' : 'Email ID' }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($recipients as $r)
                <tr>
                  <td>
                    @if($r['extra'])
                      <span title="Added by you"></span>
                    @else
                      <form method="GET" action="{{ route('admin.messages') }}" class="inline">
                        <input type="hidden" name="tab" value="send">
                        <input type="hidden" name="channel" value="{{ $channel }}">
                        @foreach($queryParams as $k => $v)
                          @if($k !== 'sent')
                            <input type="hidden" name="{{ $k }}" value="{{ is_array($v) ? json_encode($v) : $v }}">
                          @endif
                        @endforeach
                        <input type="hidden" name="segment" value="{{ $segment }}">
                        <input type="hidden" name="raw" value="{{ request()->query('raw', '') }}">
                        <input type="checkbox" class="ms-chk" name="off[{{ $r['u']->id }}]" value="1" {{ in_array($r['u']->id, request()->query('off', [])) ? 'checked' : '' }} onchange="this.form.submit()">
                        <input type="hidden" name="sent" value="{{ json_encode($sentIds) }}">
                      </form>
                    @endif
                  </td>
                  <td>
                    {{ $r['name'] ?: '—' }}
                    @if($r['isNew'])
                      <span class="pill pri">New</span>
                    @endif
                  </td>
                  <td>
                    @if($r['bad'])
                      <span style="color:var(--bad)">{{ $wa ? 'no valid number' : 'no valid email' }}</span>
                    @else
                      {{ $wa ? $r['mobile'] : $r['email'] }}
                    @endif
                  </td>
                  <td>
                    @if(in_array($sentKey($r), $sentIds))
                      <span class="pill ok">Sent</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      <div class="ms-add">
        <b>Add new {{ $wa ? 'numbers' : 'emails' }} <span style="font-weight:500;color:var(--mut)">(people not in the
            portal yet)</span></b>
        <textarea id="ms-raw" name="raw" rows="3"
          placeholder="{{ $wa ? '9876543210, 9123456789 — or one per line' : 'name@gmail.com, other@yahoo.com — or one per line' }}">{{ request()->query('raw', '') }}</textarea>
        <div class="ms-chips">
          @foreach(explode(',', request()->query('raw', '')) as $chip)
            @php $chip = trim($chip); @endphp
            @if($chip)
              <span class="chip">{{ $chip }} <button type="button" data-remove-chip="{{ $chip }}">×</button></span>
            @endif
          @endforeach
        </div>
        <div class="ms-note">You can paste {{ $wa ? 'numbers' : 'email IDs' }} in any format. They get this message too
          — they are not saved as customers.</div>
      </div>
    </div>

    <!-- Step 3: Message -->
    <div class="ms-sec">
      <div class="ms-h"><i>3</i>Message</div>
      <div class="ms-row" style="margin-bottom:10px">
        <select id="ms-tpl" name="template_id" onchange="this.form.submit()">
          <option value="-1" {{ request()->query('template_id', -1) == -1 ? 'selected' : '' }}>Write my own message
          </option>
          @foreach($templates as $t)
            <option value="{{ $t->id }}" {{ request()->query('template_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}
            </option>
          @endforeach
        </select>
      </div>
      @if(!$wa)
        <input type="text" id="ms-sub" name="subject" placeholder="Email subject"
          value="{{ request()->query('subject', '') }}" style="margin-bottom:10px">
      @endif
      <textarea id="ms-text" name="body" rows="{{ $wa ? 7 : 11 }}"
        placeholder="Type your message here…">{{ request()->query('body', '') }}</textarea>
      <div class="ms-note">
        {{ $wa ? '<b>Friend</b> is replaced by each customer\'s first name. WhatsApp opens one chat at a time — press <b>Send next</b> for each person.' : 'Email goes to everyone in BCC (they cannot see each other). Gmail opens 30 people at a time.' }}
      </div>
    </div>

    <!-- Bottom bar -->
    <div class="ms-bar">
      <div>
        @if($totalCount)
          <b>{{ $totalCount }}</b> {{ $wa ? 'WhatsApp numbers' : 'email IDs' }} ready
          @if($totalCount > $leftCount)
            · <span style="color:var(--ok)">{{ $totalCount - $leftCount }} sent</span>
          @endif
        @else
          <span style="color:var(--mut)">Choose recipients to continue</span>
        @endif
      </div>
      <div class="row" style="align-items:center">
        @if($totalCount)
          <a href="{{ route('admin.messages', array_merge(['tab' => 'send', 'channel' => $channel, 'sent' => '[]'], $queryParams)) }}"
            class="btn link">Copy {{ $wa ? 'numbers' : 'emails' }}</a>
        @endif

        @if($allSent)
          <span class="pill ok">All {{ $totalCount }} done</span>
          <a href="{{ route('admin.messages', array_merge(['tab' => 'send', 'channel' => $channel, 'sent' => '[]', 'segment' => 'all'], array_except($queryParams, ['sent', 'segment']))) }}"
            class="btn">Send another</a>
        @elseif($wa && $canSend)
          <form method="POST" action="{{ route('admin.messages.send') }}">
            @csrf
            <input type="hidden" name="channel" value="wa">
            <input type="hidden" name="subject"
              value="{{ request()->query('template_id', -1) != -1 ? $templates->firstWhere('id', request()->query('template_id'))->name ?? 'Custom message' : 'Custom message' }}">
            <input type="hidden" name="body" value="{{ request()->query('body', '') }}">
            <input type="hidden" name="template_id" value="{{ request()->query('template_id', '') }}">
            @foreach($left as $r)
              <input type="hidden" name="recipients[{{ $loop->index }}][user_id]" value="{{ $r['u']->id ?? '' }}">
              <input type="hidden" name="recipients[{{ $loop->index }}][mobile]" value="{{ $r['mobile'] }}">
              <input type="hidden" name="recipients[{{ $loop->index }}][email]" value="{{ $r['email'] }}">
              <input type="hidden" name="recipients[{{ $loop->index }}][name]" value="{{ $r['name'] }}">
            @endforeach
            <button type="submit" class="btn wa lg" target="_blank"
              formaction="https://wa.me/91{{ $left->first()['mobile'] }}?text={{ urlencode(str_replace('{friend}', explode(' ', $left->first()['name'] ?? '')[0] ?? 'Friend', str_replace('{name}', $left->first()['name'] ?? '', str_replace('{link}', 'https://retirementplankaro.com', request()->query('body', ''))))) }}">
              {{ $leftCount < $totalCount ? 'Send next (' . $leftCount . ' left)' : 'Send on WhatsApp' . ($totalCount ? ' · ' . $totalCount : '') }}
            </button>
          </form>
        @elseif(!$wa && $canSend)
          <form method="POST" action="{{ route('admin.messages.send') }}" target="_blank">
            @csrf
            <input type="hidden" name="channel" value="em">
            <input type="hidden" name="subject" value="{{ request()->query('subject', '') }}">
            <input type="hidden" name="body" value="{{ request()->query('body', '') }}">
            <input type="hidden" name="template_id" value="{{ request()->query('template_id', '') }}">
            @foreach($left->take(30) as $r)
              <input type="hidden" name="recipients[{{ $loop->index }}][user_id]" value="{{ $r['u']->id ?? '' }}">
              <input type="hidden" name="recipients[{{ $loop->index }}][mobile]" value="{{ $r['mobile'] }}">
              <input type="hidden" name="recipients[{{ $loop->index }}][email]" value="{{ $r['email'] }}">
              <input type="hidden" name="recipients[{{ $loop->index }}][name]" value="{{ $r['name'] }}">
            @endforeach
            <button type="submit" class="btn p lg"
              formaction="https://mail.google.com/mail/?view=cm&fs=1&bcc={{ urlencode($left->take(30)->pluck('email')->implode(',')) }}&su={{ urlencode(request()->query('subject', '')) }}&body={{ urlencode(request()->query('body', '')) }}">
              {{ $leftCount > 30 ? 'Send to next 30 (' . $leftCount . ' left)' : 'Send Email' . ($totalCount ? ' · ' . $totalCount : '') }}
            </button>
          </form>
          <a href="https://mail.google.com/mail/?view=cm&fs=1&bcc={{ urlencode($left->pluck('email')->implode(',')) }}&su={{ urlencode(request()->query('subject', '')) }}&body={{ urlencode(request()->query('body', '')) }}"
            target="_blank" class="btn link">Use Mail app</a>
        @else
          <button class="btn p lg" disabled>{{ $wa ? 'Send on WhatsApp' : 'Send Email' }}</button>
          @if(!$wa)
            <a class="btn link" disabled>Use Mail app</a>
          @endif
        @endif
      </div>
    </div>
  </form>
</div>

@push('scripts')
  <script>
    // Template auto-fill on select
    document.addEventListener('change', e => {
      if (e.target.matches('#ms-tpl')) {
        const idx = +e.target.value;
        if (idx >= 0 && window.CT && CT[idx]) {
          const c = CT[idx];
          document.getElementById('ms-text').value = c.t;
          if (c.ch === 'em') {
            const sub = document.getElementById('ms-sub');
            if (sub) sub.value = c.sub || '';
          }
        }
      }
    });

    // Raw input handler - update chips display
    document.addEventListener('input', e => {
      if (e.target.matches('#ms-raw')) {
        const chips = e.target.value.split(/[\n,]+/).map(s => s.trim()).filter(Boolean);
        const container = document.querySelector('.ms-chips');
        if (container) {
          container.innerHTML = chips.map(v => `<span class="chip">${v} <button type="button" data-remove-chip="${v}">×</button></span>`).join('');
        }
      }
    });

    // Chip removal
    document.addEventListener('click', e => {
      if (e.target.matches('[data-remove-chip]')) {
        const v = e.target.dataset.removeChip;
        const raw = document.getElementById('ms-raw');
        if (raw) {
          raw.value = raw.value.split(/[\n,]+/).map(s => s.trim()).filter(x => x !== v).join(', ');
          raw.dispatchEvent(new Event('input'));
        }
      }
    });

    // Select all/none
    document.addEventListener('click', e => {
      if (e.target.matches('[data-msall]')) {
        const selectAll = e.target.dataset.msall === '1';
        document.querySelectorAll('.ms-chk:not(:disabled)').forEach(chk => {
          chk.checked = selectAll;
        });
        // Submit first form
        const firstForm = document.querySelector('.ms-chk:not(:disabled)')?.closest('form');
        if (firstForm) firstForm.submit();
      }
    });
  </script>
@endpush