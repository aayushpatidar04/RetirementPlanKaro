@extends('admin.layout')
@section('title', 'Team Members')
@include('admin.partials.kit')
@include('admin.partials.perm-matrix')

@php
  $canAdmin = (bool) auth()->user()?->can('admin');

  $roleList = $roles->map(fn($r) => ['id' => $r->id, 'name' => $r->name, 'is_system' => (bool) $r->is_system])->values();
  $memberData = $team->mapWithKeys(fn($m) => [
    $m->id => [
      'id' => $m->id,
      'name' => $m->name,
      'email' => $m->email,
      'mobile' => $m->mobile,
      'role_id' => $m->role_id,
      'is_active' => (bool) $m->is_active,
      'extra' => (array) ($m->extra ?? []),
    ]
  ]);
@endphp

@push('scripts')
  <script>
    const ROLE_LIST = @json($roleList);
    const MEMBERS = @json($memberData);
    const CAN_ADMIN = @json($canAdmin);
    const TEAM_STORE = @json(route('admin.team.store'));
    const TEAM_UPDATE = @json(route('admin.team.update', '__ID__'));
    const TEAM_PERMS = @json(route('admin.team.permissions', '__ID__'));

    function roleOptions(selected) {
      return ROLE_LIST.map(r => {
        const locked = r.is_system && !CAN_ADMIN && String(r.id) !== String(selected);   // only admins can hand out system roles
        return `<option value="${esc(r.id)}" ${String(r.id) === String(selected) ? 'selected' : ''} ${locked ? 'disabled' : ''}>${esc(r.name)}${r.is_system ? ' (system)' : ''}</option>`;
      }).join('');
    }

    function memberModal(m) {
      const edit = !!m;
      const cur = m || { name: '', email: '', mobile: '', role_id: '', is_active: true };
      const body = `<div class="fg">
        <div class="w"><label>Full name<input class="in" name="name" required maxlength="80" value="${esc(cur.name)}"></label></div>
        <div class="w"><label>Email<input class="in" name="email" type="email" required maxlength="120" value="${esc(cur.email)}"></label></div>
        <div><label>Mobile<input class="in" name="mobile" maxlength="20" value="${esc(cur.mobile)}"></label></div>
        <div><label>Role<select class="in" name="role_id" required>${roleOptions(cur.role_id)}</select></label></div>
        <div class="w"><label class="toggle-wrap"><input type="checkbox" name="is_active" ${cur.is_active ? 'checked' : ''}> Active</label></div>
      </div>`;

      openModal(edit ? 'Edit ' + cur.name : 'Add team member', body, async (form, close) => {
        const f = form.elements;
        const fd = new FormData();
        if (edit) fd.append('_method', 'PUT');
        fd.append('name', f.name.value.trim());
        fd.append('email', f.email.value.trim());
        fd.append('mobile', f.mobile.value.trim());
        fd.append('role_id', f.role_id.value);
        fd.append('is_active', f.is_active.checked ? '1' : '0');
        await sendForm(edit ? TEAM_UPDATE.replace('__ID__', cur.id) : TEAM_STORE, fd);
        close();
        saved(edit ? 'Team member updated' : 'Team member added');
      });
    }

    function extraModal(m) {
      const body = `<div class="fg">
        <div class="w hint">Extra access is <b>added on top of</b> the member's role. Leave everything unticked for role-only access.</div>
        ${permMatrix(m.extra)}
      </div>`;
      openModal('Extra access — ' + m.name, body, async (form, close) => {
        const fd = new FormData();
        fd.append('extra', JSON.stringify(readPermMatrix(form)));   // same JSON string the controller got from the old textarea
        await sendForm(TEAM_PERMS.replace('__ID__', m.id), fd);
        close();
        saved('Permissions assigned');
      }, { wide: true, init: wirePermMatrix });
    }

    document.addEventListener('click', e => {
      if (e.target.closest('[data-member-add]')) return memberModal(null);
      const ed = e.target.closest('[data-member-edit]');
      if (ed) return memberModal(MEMBERS[ed.dataset.memberEdit]);
      const ex = e.target.closest('[data-member-extra]');
      if (ex) extraModal(MEMBERS[ex.dataset.memberExtra]);
    });
  </script>
@endpush

@section('content')
  <div class="adm">
    <div class="hh">
      <div>
        <h2 style="margin:0">Team Members</h2>
        <div class="sub" style="margin:2px 0 0">Access Control · Add team members and assign roles & permissions</div>
      </div>
    </div>

    @if(session('ok'))
    <div class="alert ok">{{ session('ok') }}</div>@endif
    @if($errors->any())
    <div class="alert bad">{{ $errors->first() }}</div>@endif

    <div class="kpis">
      <div class="k"><span>Team members</span><b>{{ $team->count() }}</b></div>
      <div class="k"><span>Active</span><b>{{ $team->where('is_active', true)->count() }}</b></div>
      <div class="k"><span>Roles</span><b>{{ $roles->count() }}</b></div>
    </div>

    <div class="card">
      <h3>Team members</h3>
      <div class="bar top"><button type="button" class="btn p" data-member-add>+ Add team member</button></div>

      @if($team->isEmpty())
        <div class="em">No team members yet.</div>
      @else
        <div class="sc">
          <table>
            <thead>
              <tr>
                <th>Member</th>
                <th>Role</th>
                <th>Extra access</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($team as $m)
                @php
                  $extraKeys = array_keys((array) ($m->extra ?? []));
                  $isMe = $m->email === auth()->user()?->email;
                  $lockRole = $m->role?->is_system && !$canAdmin;     // non-admins can't change a system-role member
                  $isOwner = $m->role_id === 'owner';
                @endphp
                <tr>
                  <td>
                    <b>{{ $m->name }}</b>
                    @if($isMe)<span class="pill pri">You</span>@endif
                    <br><small class="muted">{{ $m->email }}{{ $m->mobile ? ' · ' . $m->mobile : '' }}</small>
                    @if($m->added_at)
                      <br><small class="muted">Added
                        {{ \Illuminate\Support\Carbon::parse($m->added_at)->format('d M Y') }}</small>
                    @endif
                  </td>
                  <td>
                    <form method="POST" action="{{ route('admin.team.role') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $m->id }}">
                      <select class="in" name="role_id" style="width:auto;margin:0;min-width:150px"
                        onchange="this.form.submit()" @disabled($lockRole)>
                        @foreach($roles as $r)
                          <option value="{{ $r->id }}" @selected($r->id === $m->role_id) @disabled($r->is_system && !$canAdmin && $r->id !== $m->role_id)>{{ $r->name }}{{ $r->is_system ? ' (system)' : '' }}</option>
                        @endforeach
                      </select>
                    </form>
                  </td>
                  <td>
                    @if($extraKeys)
                      <span class="pill pri"
                        title="{{ implode(', ', array_map('ucfirst', $extraKeys)) }}">{{ count($extraKeys) }} extra</span>
                    @else
                      <span class="pill">None</span>
                    @endif
                  </td>
                  <td>
                    <form method="POST" action="{{ route('admin.team.toggle') }}" class="inline">
                      @csrf
                      <input type="hidden" name="id" value="{{ $m->id }}">
                      <input type="hidden" name="is_active" value="0">
                      <label class="toggle-wrap">
                        <input type="checkbox" name="is_active" value="1" @checked($m->is_active)
                          onchange="this.form.submit()" @disabled($isOwner && $m->is_active) @if($isOwner && $m->is_active)
                          title="The Owner can't be deactivated" @endif>
                        <span>{{ $m->is_active ? 'Active' : 'Inactive' }}</span>
                      </label>
                    </form>
                  </td>
                  <td>
                    <div class="row">
                      <button type="button" class="btn p s" data-member-extra="{{ $m->id }}">Extra access</button>
                      <button type="button" class="btn s" data-member-edit="{{ $m->id }}" @disabled($lockRole)>Edit</button>
                      <form method="POST" action="{{ route('admin.team.delete') }}" class="inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ $m->id }}">
                        <button type="submit" class="btn s d"
                          data-confirm="{{ 'Remove this team member?' . "\n\n" . $m->name }}"
                          @disabled($lockRole)>Remove</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <div class="card">
      <h3>How access works</h3>
      <div style="padding:14px 16px;line-height:1.7">
        <b>1.</b> Create a role under <b>Roles & Permissions</b> and tick what it can see and do.<br>
        <b>2.</b> Add a team member and give them that role. Use <b>Extra access</b> to give one person more than their
        role allows.<br>
        <b>3.</b> To check what a person will see, choose their name under <b>Signed in as</b> in the left menu.<br>
        <span class="muted">Pages a person cannot open are hidden. Buttons they cannot use are greyed out. At least one
          active Owner is always kept.</span>
      </div>
    </div>

    <div class="tt" id="tt"></div>
  </div>
@endsection