@php
  $tab = request()->query('tpl_tab', 'wa'); // wa, em, sm
  $selectedIdx = request()->query('tpl_idx', 0);
  $CT = $waTemplates->concat($emTemplates)->values();
  $waCT = $waTemplates->values();
  $emCT = $emTemplates->values();
  $L = $tab === 'wa' ? $waCT : ($tab === 'em' ? $emCT : collect());
  $selectedIdx = $L->contains('id', $selectedIdx) ? $selectedIdx : ($L->first()?->id ?? -1);
  $c = $CT->firstWhere('id', $selectedIdx);
  $showNewForm = $newTemplate ?? false;
@endphp

<!-- Template tabs -->
<div class="tbs">
  <a href="{{ route('admin.messages', array_merge(['tab' => 'tpl', 'tpl_tab' => 'wa', 'tpl_idx' => $waCT->first()?->id ?? -1], request()->except(['tab', 'tpl_tab', 'tpl_idx']))) }}" class="{{ $tab === 'wa' ? 'on' : '' }}">WhatsApp Templates ({{ $waCT->count() }})</a>
  <a href="{{ route('admin.messages', array_merge(['tab' => 'tpl', 'tpl_tab' => 'em', 'tpl_idx' => $emCT->first()?->id ?? -1], request()->except(['tab', 'tpl_tab', 'tpl_idx']))) }}" class="{{ $tab === 'em' ? 'on' : '' }}">Email Templates ({{ $emCT->count() }})</a>
  <a href="{{ route('admin.messages', array_merge(['tab' => 'tpl', 'tpl_tab' => 'sm'], request()->except(['tab', 'tpl_tab', 'tpl_idx']))) }}" class="{{ $tab === 'sm' ? 'on' : '' }}">Lead-stage mapping</a>
</div>

@if($tab === 'sm')
  <!-- Lead-stage mapping -->
  <form method="POST" action="{{ route('admin.messages.stage-mapping') }}">
    @csrf
    <div class="card">
      <h3>Default WhatsApp and email template for each prospect stage · shown as Recommended when sending</h3>
      <div class="sc">
        <table>
          <thead>
            <tr>
              <th>Lead stage</th>
              <th>WhatsApp template</th>
              <th>Email template</th>
            </tr>
          </thead>
          <tbody>
            @foreach($leadStages as $stage)
              <tr>
                <td>{{ $stage }}</td>
                <td>
                  <select class="in" name="stage_mapping[{{ $stage }}][wa]" onchange="this.form.submit()">
                    <option value="">— None —</option>
                    @foreach($waCT as $t)
                      <option value="{{ $t->id }}" {{ ($stageMapping[$stage]['wa'] ?? null) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                  </select>
                </td>
                <td>
                  <select class="in" name="stage_mapping[{{ $stage }}][em]" onchange="this.form.submit()">
                    <option value="">— None —</option>
                    @foreach($emCT as $t)
                      <option value="{{ $t->id }}" {{ ($stageMapping[$stage]['em'] ?? null) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </form>

@else
  <!-- Template list + editor -->
  <div class="tp">
    <div class="card" style="margin:0">
      <div class="bar">
        <a href="{{ route('admin.messages', array_merge(['tab' => 'tpl', 'tpl_tab' => $tab, 'new_template' => 'true'], request()->except(['tab', 'tpl_tab', 'tpl_idx', 'new_template']))) }}" class="btn p s">+ New {{ $tab === 'wa' ? 'WhatsApp' : 'Email' }} template</a>
      </div>
      <div class="tl2">
        @foreach($L as $item)
          <form method="GET" action="{{ route('admin.messages') }}" class="inline" style="margin:0">
            <input type="hidden" name="tab" value="tpl">
            <input type="hidden" name="tpl_tab" value="{{ $tab }}">
            <input type="hidden" name="tpl_idx" value="{{ $item->id }}">
            @foreach(request()->except(['tab', 'tpl_tab', 'tpl_idx']) as $k => $v)
              <input type="hidden" name="{{ $k }}" value="{{ is_array($v) ? json_encode($v) : $v }}">
            @endforeach
            <button type="submit" class="tli {{ $selectedIdx == $item->id ? 'on' : '' }} w-100 text-left p-0 border-0 bg-transparent" style="width:100%;text-align:left;padding:9px 14px;border-bottom:1px solid var(--line);background:none;border:0">
              <b>{{ $item->name }}</b>
              @if($item->channel === 'em' && $item->subject)
                <small>{{ $item->subject }}</small>
              @endif
            </button>
          </form>
        @endforeach
        @if($L->isEmpty())
          <div class="em" style="padding:20px">No {{ $tab === 'wa' ? 'WhatsApp' : 'Email' }} templates yet. Click "New" to create one.</div>
        @endif
      </div>
    </div>

    @if($showNewForm)
      <!-- New template form -->
      <form method="POST" action="{{ route('admin.messages.templates.store') }}">
        @csrf
        <input type="hidden" name="channel" value="{{ $tab }}">
        <div class="card" style="margin:0">
          <h3>New {{ $tab === 'wa' ? 'WhatsApp' : 'Email' }} Template</h3>
          <div class="pg" style="grid-template-columns:1fr;padding:16px">
            <div>
              <label>Template name
                <input class="in" name="name" required autofocus>
              </label>
            </div>
            @if($tab === 'em')
              <div>
                <label>Email subject
                  <input class="in" name="subject">
                </label>
              </div>
            @endif
            <div class="w">
              <label>Message
                <textarea class="in" name="body" rows="{{ $tab === 'em' ? 15 : 10 }}" required></textarea>
              </label>
            </div>
            <div class="w" style="color:var(--mut);font-size:12.5px">Variables: {name} {link} {amount} {purpose} {date} {n} {names} {pts} {coupon} {type} {quote}</div>
            <div class="ac">
              <button type="submit" class="btn p">Create</button>
              <a href="{{ route('admin.messages', array_merge(['tab' => 'tpl', 'tpl_tab' => $tab], request()->except(['tab', 'tpl_tab', 'tpl_idx', 'new_template']))) }}" class="btn">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    @elseif($c)
      <form method="POST" action="{{ route('admin.messages.templates.update', $c->id) }}">
        @csrf
        @method('PUT')
        <div class="card" style="margin:0">
          <div class="pg" style="grid-template-columns:1fr">
            <div>
              <label>Template name
                <input class="in" name="name" value="{{ $c->name }}" required>
              </label>
            </div>
            @if($c->channel === 'em')
              <div>
                <label>Email subject
                  <input class="in" name="subject" value="{{ $c->subject ?? '' }}">
                </label>
              </div>
            @endif
            <div class="w">
              <label>Message
                <textarea class="in" name="body" rows="{{ $c->channel === 'em' ? 15 : 10 }}" required>{{ $c->body }}</textarea>
              </label>
            </div>
            <div class="w" style="color:var(--mut);font-size:12.5px">Variables: {name} {link} {amount} {purpose} {date} {n} {names} {pts} {coupon} {type} {quote}</div>
            <div class="ac">
              <button type="submit" class="btn p">Save</button>

              <form method="POST" action="{{ route('admin.messages.templates.duplicate') }}" class="inline" style="margin:0">
                @csrf
                <input type="hidden" name="id" value="{{ $c->id }}">
                <button type="submit" class="btn">Duplicate</button>
              </form>

              <form method="POST" action="{{ route('admin.messages.templates.delete') }}" class="inline" onsubmit="return confirm('Delete \"{{ $c->name }}\"?')" style="margin:0">
                @csrf
                <input type="hidden" name="id" value="{{ $c->id }}">
                <button type="submit" class="btn d">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </form>
    @endif
  </div>
@endif

@if($tab !== 'sm')
  <!-- Export templates -->
  <div class="ac" style="margin-top:12px">
    <a href="{{ route('admin.messages.export.templates') }}" class="btn p">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Export Templates
    </a>
  </div>
@endif