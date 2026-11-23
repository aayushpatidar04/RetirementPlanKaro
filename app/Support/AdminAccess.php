<?php

namespace App\Support;

use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;

/**
 * Who is signed in to the admin portal and what they may do.
 *
 * Two kinds of accounts can sign in:
 *  - an `admins` row (the original owner account): full access
 *  - a `team_members` row with a password: access comes from its role + extra permissions
 *
 * Permission letters: v = view, e = edit (add/change/send/restore), d = delete.
 * Special permissions: "@export" (download Excel) and "@publish" (publish to website), value "y".
 */
class AdminAccess
{
    /** route-name prefix => permission area (keys match the role permission matrix) */
    public const ROUTE_AREAS = [
        'admin.dashboard' => 'Home',
        'admin.users' => 'Customers',
        'admin.leads' => 'Leads',
        'admin.payments' => 'Payments',
        'admin.quotes' => 'Get Quotes',
        'admin.sessions' => 'Sessions',
        'admin.referrals' => 'Referrals',
        'admin.messages' => 'Messages & Email',
        'admin.coupons' => 'Coupons',
        'admin.settings' => 'Pricing & rewards',
        'admin.investment-partners' => 'One Window Investing',
        'admin.testimonials' => 'Testimonials',
        'admin.versions' => 'Website versions',
        'admin.audit' => 'Audit log',
        'admin.team' => 'Team',
        'admin.roles' => 'Roles',
    ];

    /** Sidebar groups exactly as in the admin layout => [title, description, [area, label, route, about]] */
    public static function sections(): array
    {
        return [
            'clients' => ['Clients', 'Registrations, prospects and transactions', [
                ['Customers', 'Client Records', 'admin.users', 'Every registered client with profile and history'],
                ['Leads', 'Prospects', 'admin.leads', 'Prospects awaiting follow-up'],
                ['Payments', 'Transactions', 'admin.payments', 'Receipts, failed transactions and refunds'],
            ]],
            'business' => ['Business Development', 'Engage clients and acquire new ones', [
                ['Get Quotes', 'Quote Requests', 'admin.quotes', 'Insurance and loan quote requests'],
                ['Sessions', 'Advisory sessions', 'admin.sessions', 'Advisory session bookings'],
                ['Referrals', 'Referrals', 'admin.referrals', 'Referral ledger and rewards'],
                ['Messages & Email', 'Messages & Email', 'admin.messages', 'WhatsApp and email to clients'],
            ]],
            'pricing' => ['Pricing & Incentives', 'Discount codes and partner links', [
                ['Coupons', 'Discount codes', 'admin.coupons', 'Discount codes and redemptions'],
                ['One Window Investing', 'Investment Partners', 'admin.investment-partners', 'Partner investment options on the website'],
            ]],
            'content' => ['Website Content', 'What visitors see on the website', [
                ['Testimonials', 'Testimonials', 'admin.testimonials', 'Client testimonials shown on the home page'],
            ]],
            'administration' => ['Administration', 'Published versions and audit trail', [
                ['Website versions', 'Published Versions', 'admin.versions', 'Restore earlier versions of website settings'],
                ['Audit log', 'Audit Trail', 'admin.audit', 'Record of every change'],
            ]],
            'access' => ['Access Control', 'Who can sign in and what they can do', [
                ['Team', 'Team Members', 'admin.team', 'People who can sign in to this portal'],
                ['Roles', 'Roles & Permissions', 'admin.roles', 'What each role can view, edit and delete'],
            ]],
        ];
    }

    private static ?array $cache = null;

    /** ['type','id','name','email','owner','perms','role'] or null when nobody is signed in. */
    public static function actor(): ?array
    {
        if (self::$cache !== null) {
            return self::$cache ?: null;
        }

        $a = null;
        try {
            if ($admin = Auth::guard('admin')->user()) {
                $a = ['type' => 'admin', 'id' => $admin->id, 'name' => $admin->name ?: $admin->email,
                    'email' => $admin->email, 'owner' => true, 'perms' => [], 'role' => 'Owner'];
            } elseif (($m = Auth::guard('team')->user()) instanceof TeamMember && $m->is_active) {
                $role = $m->role;
                $a = ['type' => 'team', 'id' => $m->id, 'name' => $m->name, 'email' => $m->email,
                    'owner' => (bool) ($role?->is_system), 'perms' => $m->getPermissions(),
                    'role' => $role?->name ?? 'No role'];
            }
        } catch (\Throwable $e) {
            $a = null;
        }

        self::$cache = $a ?: [];

        return $a;
    }

    public static function flush(): void
    {
        self::$cache = null;
    }

    public static function isOwner(): bool
    {
        return (bool) (self::actor()['owner'] ?? false);
    }

    /** can('Payments', 'e'), can('@export'), can('@publish') */
    public static function can(string $area, string $act = 'v'): bool
    {
        $a = self::actor();
        if (!$a) {
            return false;
        }
        if ($a['owner']) {
            return true;
        }
        $has = (string) ($a['perms'][$area] ?? '');
        if ($area[0] === '@') {
            return str_contains($has, 'y');
        }
        foreach (str_split($act) as $c) {
            if (!str_contains($has, $c)) {
                return false;
            }
        }

        return true;
    }

    /** Can the actor open this admin route (sidebar links)? */
    public static function canRoute(string $name): bool
    {
        $area = self::areaForRoute($name);

        return $area ? self::can($area) : (bool) self::actor();
    }

    /** Can the actor view at least one page of this sidebar section? */
    public static function canSection(string $key): bool
    {
        foreach (self::sections()[$key][2] ?? [] as $item) {
            if (self::can($item[0], 'v')) {
                return true;
            }
        }

        return false;
    }

    /** First admin page this actor may open (used after login / when a page is denied). */
    public static function home(): string
    {
        if (self::can('Home')) {
            return route('admin.dashboard');
        }
        foreach (self::sections() as $s) {
            foreach ($s[2] as $item) {
                if (self::can($item[0])) {
                    return route($item[2]);
                }
            }
        }
        if (self::can('Pricing & rewards')) {
            return route('admin.settings');
        }

        return route('admin.login');
    }

    public static function areaForRoute(?string $name): ?string
    {
        if (!$name) {
            return null;
        }
        foreach (self::ROUTE_AREAS as $prefix => $area) {
            if ($name === $prefix || str_starts_with($name, $prefix . '.')) {
                return $area;
            }
        }

        return null;
    }

    /**
     * What a request needs: [area, letters, special|null]. Null = no permission needed
     * (section overview pages check their own items).
     */
    public static function requirement(?string $routeName, string $method): ?array
    {
        $area = self::areaForRoute($routeName);
        if (!$area) {
            return null;
        }
        $n = (string) $routeName;
        $special = null;
        if (str_contains($n, 'export') || str_ends_with($n, '.json')) {
            $special = '@export';
        }
        if (str_ends_with($n, '.publish')) {
            $special = '@publish';
        }

        if ($method === 'GET' || $method === 'HEAD') {
            $act = 'v';
        } elseif ($method === 'DELETE' || preg_match('/\.(delete|destroy)$|\.delete\b/', $n)) {
            $act = 'ved';
        } else {
            $act = 've';
        }

        return [$area, $act, $special];
    }

    /** Plain-language reason shown when an action is blocked. */
    public static function denyMessage(string $area, string $act, ?string $special = null): string
    {
        if ($special === '@export') {
            return 'Your role cannot download or export data. Ask an Owner to give you access under Access Control.';
        }
        if ($special === '@publish') {
            return 'Your role cannot publish to the website. Ask an Owner to give you access under Access Control.';
        }
        $what = str_contains($act, 'd') ? 'delete on' : (str_contains($act, 'e') ? 'make changes on' : 'open');

        return "Your role cannot {$what} {$area}. Ask an Owner to give you access under Access Control.";
    }
}
