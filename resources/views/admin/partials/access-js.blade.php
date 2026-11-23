{{-- Role permissions on the page (no markup): the server refuses anything not allowed; this only greys out what the person can't use. --}}
@php
  $pageArea = \App\Support\AdminAccess::areaForRoute(request()->route()?->getName());
  $pageCan = [
    'e' => !$pageArea || \App\Support\AdminAccess::can($pageArea, 've'),
    'd' => !$pageArea || \App\Support\AdminAccess::can($pageArea, 'ved'),
    'export' => \App\Support\AdminAccess::can('@export'),
    'publish' => \App\Support\AdminAccess::can('@publish'),
  ];
@endphp
<script>
  (function () {
    const C = @json($pageCan);
    const why = 'Your role does not allow this. Ask an Owner under Access Control.';
    function off(el, t) { el.disabled = true; el.title = t || why; el.style.pointerEvents = 'none'; el.style.opacity = '.5'; }
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('main form').forEach(f => {
        if ((f.getAttribute('method') || 'get').toLowerCase() !== 'post') return;
        const m = ((f.querySelector('input[name=_method]') || {}).value || '').toUpperCase();
        const del = m === 'DELETE' || /delete|destroy/.test(f.action);
        const pub = /\/publish$/.test(f.action);
        if (!(del ? C.d : (pub ? (C.e && C.publish) : C.e))) f.querySelectorAll('button, input[type=submit], select, input[type=checkbox]').forEach(b => off(b));
      });
      if (!C.e) document.querySelectorAll('main [data-add],main [data-edit],main [data-role-add],main [data-role-edit],main [data-member-add],main [data-member-edit],main [data-member-extra],main [data-publish],main #btnCustomise').forEach(b => off(b));
      if (!C.export) document.querySelectorAll('main [data-export],main button').forEach(b => { if (b.hasAttribute('data-export') || /^\s*Export/i.test(b.textContent)) off(b, 'Your role cannot download or export data.'); });
    });
    /* show the server's reason when a background request is refused */
    const of = window.fetch;
    window.fetch = async function () {
      const r = await of.apply(this, arguments);
      if (r.status === 403 || r.status === 401) { try { const j = await r.clone().json(); if (j && j.message) alert(j.message); } catch (e) {} }
      return r;
    };
  })();
</script>
