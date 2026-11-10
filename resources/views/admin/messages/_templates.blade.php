@php
  // NOTE: don't reuse $tab here — it's the parent page's tab variable
  $tplTab = in_array(request('tpl_tab'), ['wa', 'em', 'sm'], true) ? request('tpl_tab') : 'wa';
  $waCT = $waTemplates->values();
  $emCT = $emTemplates->values();
  $L = $tplTab === 'wa' ? $waCT : ($tplTab === 'em' ? $emCT : collect());
  $selectedId = (int) request('tpl_idx', 0);
  if (!$L->contains('id', $selectedId))
    $selectedId = (int) ($L->first()->id ?? 0);
  $c = $L->firstWhere('id', $selectedId);
  $chName = $tplTab === 'wa' ? 'WhatsApp' : 'Email';
  $vars = '{friend} {name} {link} {amount} {purpose} {date} {n} {names} {pts} {coupon} {type} {quote}';
@endphp

<div class="tbs">
  <a href="{{ route('admin.messages', ['tab' => 'tpl', 'tpl_tab' => 'wa']) }}"
    class="{{ $tplTab === 'wa' ? 'on' : '' }}">WhatsApp Templates ({{ $waCT->count() }})</a>
  <a href="{{ route('admin.messages', ['tab' => 'tpl', 'tpl_tab' => 'em']) }}"
    class="{{ $tplTab === 'em' ? 'on' : '' }}">Email Templates ({{ $emCT->count() }})</a>
  <a href="{{ route('admin.messages', ['tab' => 'tpl', 'tpl_tab' => 'sm']) }}"
    class="{{ $tplTab === 'sm' ? 'on' : '' }}">Lead-stage mapping</a>
</div>

@if($tplTab === 'sm')
  <form method="POST" action="{{ route('admin.messages.stage-mapping') }}">
    @csrf
    <div class="card">
      <h3>Default WhatsApp and email template for each lead stage · shown as "★ Recommended" when sending</h3>
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
                @foreach(['wa' => $waCT, 'em' => $emCT] as $ch => $list)
                  <td>
                    <select class="in" name="stage_mapping[{{ $stage }}][{{ $ch }}]" onchange="this.form.submit()">
                      <option value="">— None —</option>
                      @foreach($list as $t)
                        <option value="{{ $t->id }}" @selected((string) ($stageMapping[$stage][$ch] ?? '') === (string) $t->id)>
                          {{ $t->name }}</option>
                      @endforeach
                    </select>
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </form>

@else
  <div class="tp">
    {{-- list: plain links (old code used a form per row and kept new_template alive in the URL) --}}
    <div class="card" style="margin:0">
      <div class="bar">
        <a href="{{ route('admin.messages', ['tab' => 'tpl', 'tpl_tab' => $tplTab, 'new_template' => 1]) }}"
          class="btn p s">+ New {{ $chName }} template</a>
      </div>
      <div class="tl2">
        @forelse($L as $item)
          <a href="{{ route('admin.messages', ['tab' => 'tpl', 'tpl_tab' => $tplTab, 'tpl_idx' => $item->id]) }}"
            class="tli {{ !$newTemplate && $selectedId === $item->id ? 'on' : '' }}">
            <b>{{ $item->name }}</b>
            @if($tplTab === 'em' && $item->subject)<small>{{ $item->subject }}</small>@endif
          </a>
        @empty
          <div class="em">No {{ $chName }} templates yet. Click "New" to create one.</div>
        @endforelse
      </div>
    </div>

    @if($newTemplate)
      <form method="POST" action="{{ route('admin.messages.templates.store') }}">
        @csrf
        <input type="hidden" name="channel" value="{{ $tplTab }}">
        <div class="card" style="margin:0">
          <h3>New {{ $chName }} Template</h3>
          <div class="pg" style="grid-template-columns:1fr">
            <label>Template name <input class="in" name="name" value="{{ old('name') }}" required autofocus></label>
            @if($tplTab === 'em')
              <label>Email subject <input class="in" name="subject" value="{{ old('subject') }}"></label>
            @endif
            <label>Message <textarea class="in" name="body" rows="{{ $tplTab === 'em' ? 15 : 10 }}"
                required>{{ old('body') }}</textarea></label>
            <div style="color:var(--mut);font-size:12.5px">Variables: {{ $vars }}</div>
            <div class="ac">
              <button type="submit" class="btn p">Create</button>
              <a href="{{ route('admin.messages', ['tab' => 'tpl', 'tpl_tab' => $tplTab]) }}" class="btn">Cancel</a>
            </div>
          </div>
        </div>
      </form>

    @elseif($c)
      {{-- Save / Duplicate / Delete are SEPARATE forms (nested forms are invalid HTML: the browser
      dropped the inner <form> tags, so Duplicate and Delete were submitting the PUT update form).
        Buttons are tied to their forms with the form="" attribute. --}}
        <form method="POST" action="{{ route('admin.messages.templates.update', $c->id) }}" id="tplSave">
          @csrf
          @method('PUT')
          <div class="card" style="margin:0">
            <div class="pg" style="grid-template-columns:1fr">
              <label>Template name <input class="in" name="name" value="{{ old('name', $c->name) }}" required></label>
              @if($c->channel === 'em')
                <label>Email subject <input class="in" name="subject" value="{{ old('subject', $c->subject) }}"></label>
              @endif
              <label>Message <textarea class="in" name="body" rows="{{ $c->channel === 'em' ? 15 : 10 }}"
                  required>{{ old('body', $c->body) }}</textarea></label>
              <div style="color:var(--mut);font-size:12.5px">Variables: {{ $vars }}</div>
              <div class="ac">
                <button type="submit" class="btn p">Save</button>
                <button type="submit" class="btn" form="tplDup">Duplicate</button>
                <button type="submit" class="btn d" form="tplDel"
                  data-confirm="{{ 'Delete "' . $c->name . '"?' }}">Delete</button>
              </div>
            </div>
          </div>
        </form>
        <form method="POST" action="{{ route('admin.messages.templates.duplicate') }}" id="tplDup">@csrf<input type="hidden"
            name="id" value="{{ $c->id }}"></form>
        <form method="POST" action="{{ route('admin.messages.templates.delete') }}" id="tplDel">@csrf<input type="hidden"
            name="id" value="{{ $c->id }}"></form>
    @endif
  </div>

  <div class="ac" style="margin-top:12px">
    <button type="button" class="btn p" data-export="{{ route('admin.messages.export.templates') }}">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
        <polyline points="7 10 12 15 17 10" />
        <line x1="12" y1="15" x2="12" y2="3" />
      </svg>
      Export Templates
    </button>
  </div>
@endif