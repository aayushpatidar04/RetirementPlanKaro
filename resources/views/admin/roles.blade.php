@extends('admin.layout')
@section('title', 'Roles & Permissions')
@include('admin.partials.kit')
@include('admin.partials.perm-matrix')

@php
  // flat label => key list (defined once; the old view built it twice)
  $mods = collect(config('admin_permissions.groups'))->collapse();
  $specialKeys = array_keys(config('admin_permissions.special'));

  $roleData = $roles->mapWithKeys(fn($r) => [
    $r->id => [
      'id' => $r->id,
      'name' => $r->name,
      'description' => $r->description,
      'permissions' => (array) $r->permissions,
    ]
  ]);
@endphp

@push('scripts')
  <script>
    const ROLES = @json($roleData);
    const ROLE_STORE = @json(route('admin.roles.store'));
    const ROLE_UPDATE = @json(route('admin.roles.update', '__ID__'));

    function openRoleModal(role) {
      const edit = !!role;
      const cur = role || { id: '', name: '', description: '', permissions: {} };
      const body = `<div class="fg">
        ${edit ? '' : `<div class="w"><label>Role ID (unique — lowercase letters, numbers, underscore)
          <input class="in" name="id" required maxlength="40" pattern="[a-z0-9_]+" placeholder="e.g. senior_support"></label></div>`}
        <div class="w"><label>Name<input class="in" name="name" required maxlength="60" value="${esc(cur.name)}"></label></div>
        <div class="w"><label>Description<textarea class="in" name="description" rows="2">${esc(cur.description)}</textarea></label></div>
        ${edit ? permMatrix(cur.permissions)
          : '<div class="w hint">Permissions are set after creation — click <b>Edit permissions</b> on the new role.</div>'}
      </div>`;

      openModal(edit ? 'Edit permissions — ' + cur.name : 'Create role', body, async (form, close) => {
        const f = form.elements;
        const fd = new FormData();
        fd.append('name', f.name.value.trim());
        fd.append('description', f.description.value.trim());
        if (edit) {
          fd.append('_method', 'PUT');                      // multipart PUT isn't parsed by PHP, so spoof it over POST
          Object.entries(readPermMatrix(form)).forEach(([k, v]) => fd.append(`permissions[${k}]`, v));
        } else {
          fd.append('id', f.id.value.trim());
        }
        await sendForm(edit ? ROLE_UPDATE.replace('__ID__', encodeURIComponent(cur.id)) : ROLE_STORE, fd);
        close();
        saved(edit ? 'Role updated' : 'Role created');
      }, { wide: edit, init: edit ? wirePermMatrix : null });
    }

    document.addEventListener('click', e => {
      if (e.target.closest('[data-role-add]')) return openRoleModal(null);
      const ed = e.target.closest('[data-role-edit]');
      if (ed) openRoleModal(ROLES[ed.dataset.roleEdit]);
    });
  </script>
@endpush

@section('content')
  <div class="adm">
    <div class="hh">
      <div>
        <h2 style="margin:0">Roles & Permissions</h2>
        <div class="sub" style="margin:2px 0 0">Access Control · Create roles and choose what each role can see and do
        </div>
      </div>
    </div>

    @if(session('ok'))
    <div class="alert ok">{{ session('ok') }}</div>@endif
    @if($errors->any())
    <div class="alert bad">{{ $errors->first() }}</div>@endif

    <div class="card">
      <h3>Roles</h3>
      <div class="bar top"><button type="button" class="btn p" data-role-add>+ Create role</button></div>

      @if($roles->isEmpty())
        <div class="em">No roles yet.</div>
      @else
        <div class="sc">
          <table>
            <thead>
              <tr>
                <th>Role</th>
                <th>Members</th>
                <th>Can see</th>
                <th>Special</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($roles as $r)
                @php
                  $seen = $mods->filter(fn($key) => $r->can($key))->keys()->values();
                  $special = collect($specialKeys)->filter(fn($k) => $r->can($k))
                    ->map(fn($k) => \Illuminate\Support\Str::of($k)->after('@')->title()->toString());
                @endphp
                <tr>
                  <td class="wrap">
                    <b>{{ $r->name }}</b>
                    @if($r->is_system)<span class="pill pri">Locked</span>@endif
                    @if($r->description)
                      <div class="muted" style="font-size:12.5px;max-width:300px">{{ $r->description }}</div>
                    @endif
                  </td>
                  <td>{{ $teamCounts[$r->id] ?? 0 }}</td>
                  <td class="wrap" style="max-width:380px;line-height:2">
                    @if($r->is_system)
                      <span class="pill ok">Everything</span>
                    @elseif($seen->isEmpty())
                      <span class="muted">No access</span>
                    @else
                      @foreach($seen->take(4) as $label)<span class="pill">{{ $label }}</span> @endforeach
                      @if($seen->count() > 4)<span class="pill">+{{ $seen->count() - 4 }} more</span>@endif
                    @endif
                  </td>
                  <td>{{ $r->is_system ? 'Export, Publish' : ($special->isEmpty() ? '—' : $special->implode(', ')) }}</td>
                  <td>
                    @if($r->is_system)
                      <span class="muted">Full access, cannot be changed</span>
                    @else
                      <div class="row">
                        <button type="button" class="btn p s" data-role-edit="{{ $r->id }}">Edit permissions</button>

                        <form method="POST" action="{{ route('admin.roles.duplicate') }}" class="inline">
                          @csrf
                          <input type="hidden" name="id" value="{{ $r->id }}">
                          <button type="submit" class="btn s" data-confirm="Duplicate this role?">Duplicate</button>
                        </form>

                        <form method="POST" action="{{ route('admin.roles.delete') }}" class="inline">
                          @csrf
                          <input type="hidden" name="id" value="{{ $r->id }}">
                          <button type="submit" class="btn s d"
                            data-confirm="{{ 'Delete this role?' . "\n\n" . $r->name }}">Delete</button>
                        </form>
                      </div>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <div class="card">
      <h3>Access overview (V = view, VE = view + edit, VED = view + edit + delete)</h3>
      <div class="sc">
        <table style="min-width:0">
          <thead>
            <tr>
              <th>Role</th>
              @foreach($mods as $label => $key)
              <th style="text-align:center">{{ $label }}</th>@endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $r)
              @php $perm = (array) $r->permissions; @endphp
              <tr>
                <td><b>{{ $r->name }}</b> @if($r->is_system)<span class="pill pri">Locked</span>@endif</td>
                @foreach($mods as $label => $key)
                  @php
                    $p = $r->is_system ? 'ved' : (string) ($perm[$key] ?? '');
                    [$txt, $col] = match (true) {
                      $p === '' => ['–', 'var(--mut)'],
                      str_contains($p, 'd') => ['VED', 'var(--ok)'],
                      str_contains($p, 'e') => ['VE', 'var(--pri)'],
                      default => ['V', 'var(--mut)'],
                    };
                  @endphp
                  <td style="text-align:center;font-weight:700;color:{{ $col }}">{{ $txt }}</td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <h3>How roles work</h3>
      <div style="padding:14px 16px;line-height:1.7">
        <b>View</b> opens the page and shows its data. <b>Edit</b> adds, changes, sends or restores. <b>Delete</b> removes
        records. Edit needs View, and Delete needs Edit.<br>
        Special permissions control <b>Download Excel / export data</b> and <b>Publish changes to the website</b>
        separately from page access.<br>
        A role cannot be deleted while team members use it.
      </div>
    </div>

    <div class="tt" id="tt"></div>
  </div>
@endsection