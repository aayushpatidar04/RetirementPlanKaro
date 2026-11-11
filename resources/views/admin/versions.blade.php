@extends('admin.layout')
@section('title', 'Website Versions')
@include('admin.partials.kit')

@push('scripts')
  <script>
    // Restore: confirm (data-confirm, handled in the kit) -> POST in the background -> reload
    document.addEventListener('submit', async e => {
      const form = e.target.closest('[data-restore-form]');
      if (!form) return;
      e.preventDefault();
      const btn = form.querySelector('button[type=submit]');
      btn.disabled = true;
      try {
        const res = await fetch(form.action, { method: 'POST', body: new FormData(form), credentials: 'same-origin', headers: JSON_H });
        if (!res.ok) throw new Error(await errMsg(res, 'Restore failed'));
        saved('Version restored');
      } catch (err) { toast(err.message); btn.disabled = false; }
    });
  </script>
@endpush

@section('content')
  <div class="adm">
    <div class="hh">
      <div>
        <h2 style="margin:0">Website Versions</h2>
        <div class="sub" style="margin:2px 0 0">Administration · Published versions and restore earlier versions</div>
      </div>
    </div>

    @if(session('ok'))
    <div class="alert ok">{{ session('ok') }}</div>@endif
    @if($errors->any())
    <div class="alert bad">{{ $errors->first() }}</div>@endif

    <div class="card">
      <h3>Version history</h3>
      <p class="note">Every setting that affects the website (pricing, points, discount codes, referral, session
        availability, investment partners, testimonials) is versioned here. Select <b>Restore</b> on any earlier version
        to reinstate that setting.</p>

      <div class="bar">
        <form method="GET" action="{{ route('admin.versions') }}" class="row">
          <select class="in" name="area" style="width:auto;margin:0;min-width:220px" onchange="this.form.submit()">
            <option value="">All areas</option>
            @foreach($areas as $name => $keys)
              <option value="{{ $name }}" @selected($filterArea === $name)>{{ $name }}</option>
            @endforeach
          </select>
          <noscript><button class="btn" type="submit">Filter</button></noscript>
        </form>
        <button type="button" class="btn"
          data-export="{{ route('admin.versions.export', array_filter(['area' => $filterArea])) }}">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
            <polyline points="7 10 12 15 17 10" />
            <line x1="12" y1="15" x2="12" y2="3" />
          </svg>
          Export Excel
        </button>
      </div>

      @if($versions->isEmpty())
        <div class="em">No versions yet.</div>
      @else
        @php $currentShown = []; @endphp
        <div class="sc">
          <table>
            <thead>
              <tr>
                <th>Version</th>
                <th>When</th>
                <th>Area</th>
                <th>Change</th>
                <th>Details (before → after)</th>
                <th>Status</th>
                <th>Restore</th>
              </tr>
            </thead>
            <tbody>
              @foreach($versions as $v)
                @php
                  // Only the newest version that equals the live data is "Current" (older identical ones stay restorable)
                  $isCurrent = false;
                  if (!isset($currentShown[$v->area]) && isset($currentData[$v->area])) {
                    $a = $currentData[$v->area];
                    $b = $v->data;
                    $isCurrent = (is_array($a) && is_array($b)) ? $a == $b : json_encode($a) === json_encode($b);
                    if ($isCurrent)
                      $currentShown[$v->area] = true;
                  }
                  $flat = json_encode($v->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                  $pretty = json_encode($v->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                @endphp
                <tr>
                  <td><b>v{{ $v->version }}</b></td>
                  <td>{{ $v->created_at?->format('d M Y H:i') }}</td>
                  <td>{{ $v->area }}</td>
                  <td class="wrap">{{ $v->description }}</td>
                  <td class="wrap">
                    <details class="det">
                      <summary>{{ \Illuminate\Support\Str::limit($flat, 110) }}</summary>
                      <pre>{{ $pretty }}</pre>
                    </details>
                  </td>
                  <td>@if($isCurrent)<span class="pill ok">Current</span>@endif</td>
                  <td>
                    @unless($isCurrent)
                      <form method="POST" action="{{ route('admin.versions.restore') }}" class="inline" data-restore-form>
                        @csrf
                        <input type="hidden" name="version" value="{{ $v->version }}">
                        <button type="submit" class="btn s p"
                          data-confirm="{{ 'Restore ' . $v->area . ' to version ' . $v->version . '? This will overwrite current settings.' }}">Restore</button>
                      </form>
                    @endunless
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if(method_exists($versions, 'hasPages') && $versions->hasPages())
          {{ $versions->withQueryString()->links('vendor.pagination.admin') }}
        @endif
      @endif
    </div>

    <div class="tt" id="tt"></div>
  </div>
@endsection