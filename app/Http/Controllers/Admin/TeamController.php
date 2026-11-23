<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\TeamMember;
use App\Support\Activity;
use App\Support\AdminAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $team = TeamMember::with('role')->orderBy('added_at')->get();
        $roles = Role::where('is_system', false)->orWhere('id', 'owner')->get();

        return view('admin.team', compact('team', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:80',
            'email' => 'required|email|max:120|unique:team_members,email',
            'mobile' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
            'password' => 'required|string|min:8|max:100',
        ]);
        $data['email'] = strtolower(trim($data['email']));

        if ($data['role_id'] === 'owner' && !AdminAccess::isOwner()) {
            return back()->withErrors(['error' => 'Only an Owner can give the Owner role.']);
        }

        $member = TeamMember::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'] ?? null,
            'role_id' => $data['role_id'],
            'extra' => null,
            'is_active' => $request->boolean('is_active', true),
            'added_at' => now(),
            'password' => $data['password'],
        ]);

        Activity::log(null, 'team.added', "Team member added: {$member->name} ({$member->role_id})", $member->toArray(), 'TeamMember', $member->id);

        return back()->with('ok', 'Team member added.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $member = TeamMember::findOrFail($id);
        $oldRole = $member->role_id;

        $data = $request->validate([
            'name' => 'required|string|max:80',
            'email' => "required|email|max:120|unique:team_members,email,{$id}",
            'mobile' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
            'password' => 'nullable|string|min:8|max:100',
        ]);

        if ($data['role_id'] !== $oldRole && ($data['role_id'] === 'owner' || $oldRole === 'owner') && !AdminAccess::isOwner()) {
            return back()->withErrors(['error' => 'Only an Owner can give or take away the Owner role.']);
        }
        if ($oldRole === 'owner' && ($data['role_id'] !== 'owner' || !$request->boolean('is_active')) && $this->isLastOwner($member)) {
            return back()->withErrors(['error' => 'At least one active Owner is required.']);
        }

        $upd = [
            'name' => $data['name'],
            'email' => strtolower(trim($data['email'])),
            'mobile' => $data['mobile'] ?? null,
            'role_id' => $data['role_id'],
            'is_active' => $request->boolean('is_active'),
        ];
        if (!empty($data['password'])) {
            $upd['password'] = $data['password'];
        }
        $member->update($upd);

        Activity::log(null, 'team.updated', "Team member updated: {$member->name}", [
            'old_role' => $oldRole,
            'new_role' => $data['role_id'],
        ], 'TeamMember', $member->id);

        return back()->with('ok', 'Team member updated.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:team_members,id',
        ]);

        $member = TeamMember::findOrFail($data['id']);
        
        // Prevent removing the last active owner
        if ($member->role_id === 'owner' && $member->is_active) {
            $otherOwners = TeamMember::where('role_id', 'owner')
                ->where('is_active', true)
                ->where('id', '!=', $member->id)
                ->count();
            if ($otherOwners === 0) {
                return back()->withErrors(['error' => 'At least one active Owner is required.']);
            }
        }

        $name = $member->name;
        $member->delete();

        Activity::log(null, 'team.deleted', "Team member removed: {$name}", ['id' => $data['id']], 'TeamMember', $data['id']);

        return back()->with('ok', 'Team member removed.');
    }

    public function toggle(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:team_members,id',
            'is_active' => 'required|boolean',
        ]);

        $member = TeamMember::findOrFail($data['id']);

        // Prevent deactivating the last active owner
        if ($member->role_id === 'owner' && !$data['is_active']) {
            $otherOwners = TeamMember::where('role_id', 'owner')
                ->where('is_active', true)
                ->where('id', '!=', $member->id)
                ->count();
            if ($otherOwners === 0) {
                return back()->withErrors(['error' => 'At least one active Owner is required.']);
            }
        }

        // Prevent deactivating yourself
        if ($member->email === (AdminAccess::actor()['email'] ?? null) && !$data['is_active']) {
            return back()->withErrors(['error' => 'You cannot deactivate your own account.']);
        }

        $member->update(['is_active' => $data['is_active']]);

        Activity::log(null, 'team.toggled', "Team member {$member->name} " . ($data['is_active'] ? 'activated' : 'deactivated'), ['is_active' => $data['is_active']], 'TeamMember', $member->id);

        return back()->with('ok', 'Status updated.');
    }

    public function updateRole(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:team_members,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $member = TeamMember::findOrFail($data['id']);
        $newRole = Role::findOrFail($data['role_id']);
        $oldRole = $member->role_id;

        // Only owners can give owner role
        if (($newRole->id === 'owner' || $oldRole === 'owner') && !AdminAccess::isOwner()) {
            return back()->withErrors(['error' => 'Only an Owner can give the Owner role.']);
        }

        // Prevent removing last active owner
        if ($oldRole === 'owner' && $member->is_active && $newRole->id !== 'owner') {
            $otherOwners = TeamMember::where('role_id', 'owner')
                ->where('is_active', true)
                ->where('id', '!=', $member->id)
                ->count();
            if ($otherOwners === 0) {
                return back()->withErrors(['error' => 'At least one active Owner is required.']);
            }
        }

        $member->update(['role_id' => $data['role_id']]);

        Activity::log(null, 'team.role_changed', "Team member {$member->name} role changed from {$oldRole} to {$newRole->name}", [
            'old_role' => $oldRole,
            'new_role' => $data['role_id'],
        ], 'TeamMember', $member->id);

        return back()->with('ok', 'Role updated.');
    }

    public function assignPermissions(Request $request): RedirectResponse
    {
        // the page sends the ticked boxes as a JSON string
        if (is_string($request->input('extra'))) {
            $request->merge(['extra' => json_decode($request->input('extra'), true) ?: []]);
        }
        $data = $request->validate([
            'id' => 'required|exists:team_members,id',
            'extra' => 'nullable|array',
            'extra.*' => 'string',
        ]);

        $member = TeamMember::findOrFail($data['id']);
        $member->update(['extra' => $data['extra'] ?? []]);

        Activity::log(null, 'team.permissions_assigned', "Extra permissions assigned to {$member->name}", $data['extra'] ?? [], 'TeamMember', $member->id);

        return back()->with('ok', 'Permissions assigned.');
    }

    private function isLastOwner(TeamMember $member): bool
    {
        return !TeamMember::where('role_id', 'owner')->where('is_active', true)
            ->where('id', '!=', $member->id)->exists()
            && !\Illuminate\Support\Facades\DB::table('admins')->exists();
    }
}
