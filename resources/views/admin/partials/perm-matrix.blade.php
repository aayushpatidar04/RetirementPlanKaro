@php
    $permGroups = collect(config('admin_permissions.groups'))
        ->map(fn($items, $g) => ['group' => $g, 'items' => collect($items)->map(fn($k, $l) => ['label' => $l, 'key' => $k])->values()])
        ->values();
    $permSpecial = collect(config('admin_permissions.special'))->map(fn($l, $k) => ['key' => $k, 'label' => $l])->values();
@endphp

@push('scripts')
    <script>
        
        const PERM_GROUPS = @json($permGroups);
        const PERM_SPECIAL = @json($permSpecial);

        /** HTML for a View / Edit / Delete matrix + special permissions. cur = { Key: 'ved', '@special': 'y' } */
        function permMatrix(cur) {
            cur = cur || {};
            const has = (k, c) => String(cur[k] || '').includes(c);
            let h = '<div class="w pm">';
            PERM_GROUPS.forEach(g => {
                h += `<div class="pm-sec"><h4>${esc(g.group)}</h4><table class="pm-t"><thead><tr><th>Module</th><th>View</th><th>Edit</th><th>Delete</th></tr></thead><tbody>`;
                g.items.forEach(i => {
                    h += `<tr data-pm-key="${esc(i.key)}"><td>${esc(i.label)}</td>`
                        + ['v', 'e', 'd'].map(c => `<td><input type="checkbox" data-p="${c}" ${has(i.key, c) ? 'checked' : ''}></td>`).join('')
                        + '</tr>';
                });
                h += '</tbody></table></div>';
            });
            h += '<div class="pm-sec"><h4>Special</h4>'
                + PERM_SPECIAL.map(s => `<label class="pm-sp"><input type="checkbox" data-sp="${esc(s.key)}" ${cur[s.key] === 'y' ? 'checked' : ''}> ${esc(s.label)}</label>`).join('')
                + '</div></div>';
            return h;
        }

        /** Enforces: Edit needs View, Delete needs Edit (same rule the page explains). Pass as openModal opts.init */
        function wirePermMatrix(form) {
            form.addEventListener('change', e => {
                const cb = e.target.closest('[data-p]');
                if (!cb) return;
                const row = cb.closest('tr');
                const v = row.querySelector('[data-p="v"]'), ed = row.querySelector('[data-p="e"]'), d = row.querySelector('[data-p="d"]');
                if (cb === d && d.checked) { ed.checked = true; v.checked = true; }
                if (cb === ed && ed.checked) v.checked = true;
                if (cb === ed && !ed.checked) d.checked = false;
                if (cb === v && !v.checked) { ed.checked = false; d.checked = false; }
            });
        }

        /** -> { Key: 'ved', '@special': 'y' } (modules with nothing ticked are left out) */
        function readPermMatrix(form) {
            const out = {};
            form.querySelectorAll('[data-pm-key]').forEach(row => {
                const s = ['v', 'e', 'd'].filter(c => row.querySelector(`[data-p="${c}"]`).checked).join('');
                if (s) out[row.dataset.pmKey] = s;
            });
            form.querySelectorAll('[data-sp]').forEach(cb => { if (cb.checked) out[cb.dataset.sp] = 'y'; });
            return out;
        }
    </script>
@endpush