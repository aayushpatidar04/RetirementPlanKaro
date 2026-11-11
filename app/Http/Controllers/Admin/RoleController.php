<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\TeamMember;
use App\Support\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::orderBy('is_system', 'desc')->orderBy('name')->get();
        $teamCounts = TeamMember::selectRaw('role_id, count(*) as count')
            ->groupBy('role_id')
            ->pluck('count', 'role_id')
            ->toArray();

        // All available modules/actions from ACTS
        $modules = $this->getModules();

        return view('admin.roles', compact('roles', 'teamCounts', 'modules'));
    }

    private function getModules(): array
    {
        // These match the ACTS constant from the HTML reference
        return [
            'Overview' => ['Home (Dashboard)' => 'Home'],
            'Clients' => [
                'Client Records' => 'Customers',
                'Prospects' => 'Leads',
                'Transactions' => 'Payments',
            ],
            'Business Development' => [
                'Get Quotes' => 'Get Quotes',
                'Advisory Sessions' => 'Sessions',
                'Referrals' => 'Referrals',
                'Messages & Email' => 'Messages & Email',
            ],
            'Pricing & Incentives' => [
                'Discount Codes' => 'Coupons',
                'Settings' => 'Pricing & rewards',
            ],
            'Website Content' => [
                'Investment Partners' => 'One Window Investing',
                'Testimonials' => 'Testimonials',
            ],
            'Administration' => [
                'Published Versions' => 'Website versions',
                'Audit Trail' => 'Audit log',
            ],
            'Access Control' => [
                'Team Members' => 'Team',
                'Roles & Permissions' => 'Roles',
            ],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|string|max:40|unique:roles,id',
            'name' => 'required|string|max:60',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'id' => $data['id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_system' => false,
            'permissions' => $data['permissions'] ?? [],
        ]);

        Activity::log(null, 'role.created', "Role created: {$role->name}", $role->toArray(), 'Role', $role->id);

        return back()->with('ok', 'Role created.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        if ($role->is_system) {
            return back()->withErrors(['error' => 'System roles cannot be modified.']);
        }

        $data = $request->validate([
            'name' => 'required|string|max:60',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'permissions' => $data['permissions'] ?? [],
        ]);

        Activity::log(null, 'role.updated', "Role updated: {$role->name}", $role->toArray(), 'Role', $role->id);

        return back()->with('ok', 'Role updated.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($data['id']);

        if ($role->is_system) {
            return back()->withErrors(['error' => 'System roles cannot be deleted.']);
        }

        // Check if any team members use this role
        $count = TeamMember::where('role_id', $role->id)->count();
        if ($count > 0) {
            return back()->withErrors(['error' => "Cannot delete role: {$count} team member(s) use this role."]);
        }

        $name = $role->name;
        $role->delete();

        Activity::log(null, 'role.deleted', "Role deleted: {$name}", ['id' => $data['id']], 'Role', $data['id']);

        return back()->with('ok', 'Role deleted.');
    }

    public function duplicate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($data['id']);
        $newId = $role->id . '_copy_' . time();
        
        $newRole = Role::create([
            'id' => $newId,
            'name' => $role->name . ' (copy)',
            'description' => $role->description,
            'is_system' => false,
            'permissions' => $role->permissions,
        ]);

        Activity::log(null, 'role.duplicated', "Role duplicated: {$newRole->name}", $newRole->toArray(), 'Role', $newRole->id);

        return back()->with('ok', 'Role duplicated.');
    }
}