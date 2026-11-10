@if($paginator->hasPages())
  <div class="pagination" style="display:flex;gap:4px;align-items:center;justify-content:center;flex-wrap:wrap;padding:8px 0">
    {{-- Previous --}}
    @if($paginator->onFirstPage())
      <span class="page-link" style="padding:6px 10px;border:1px solid var(--line);border-radius:6px;color:var(--mut);cursor:not-allowed">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;vertical-align:middle"><polyline points="15 18 9 12 15 6"/></svg>
      </span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" class="page-link" style="padding:6px 10px;border:1px solid var(--line);border-radius:6px;color:var(--ink);text-decoration:none;background:var(--card);display:inline-flex;align-items:center;gap:4px" rel="prev">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;vertical-align:middle"><polyline points="15 18 9 12 15 6"/></svg>
      </a>
    @endif

    {{-- Page numbers --}}
    @foreach($elements as $element)
      @if(is_array($element))
        @foreach($element as $page => $url)
          @if($page == $paginator->currentPage())
            <span class="page-link current" style="padding:6px 10px;border:1px solid var(--pri);border-radius:6px;background:var(--pri);color:#fff;font-weight:600">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="page-link" style="padding:6px 10px;border:1px solid var(--line);border-radius:6px;color:var(--ink);text-decoration:none;background:var(--card);display:inline-flex;align-items:center">{{ $page }}</a>
          @endif
        @endforeach
      @else
        {{-- Ellipsis --}}
        <span class="page-link" style="padding:6px 8px;color:var(--mut)">…</span>
      @endif
    @endforeach

    {{-- Next --}}
    @if($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" class="page-link" style="padding:6px 10px;border:1px solid var(--line);border-radius:6px;color:var(--ink);text-decoration:none;background:var(--card);display:inline-flex;align-items:center;gap:4px" rel="next">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;vertical-align:middle"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    @else
      <span class="page-link" style="padding:6px 10px;border:1px solid var(--line);border-radius:6px;color:var(--mut);cursor:not-allowed">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block;vertical-align:middle"><polyline points="9 18 15 12 9 6"/></svg>
      </span>
    @endif
  </div>
@endif