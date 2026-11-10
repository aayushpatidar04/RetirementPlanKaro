<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use App\Support\Activity;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReferralController extends Controller
{
    public function index(Request $request): View
    {
        $from = trim((string) $request->query('from', ''));
        $to = trim((string) $request->query('to', ''));

        $referralQuery = Referral::query()
            ->join('users as referrer', 'referrer.id', '=', 'referrals.referrer_user_id')
            ->join('users as referred', 'referred.id', '=', 'referrals.referred_user_id')
            ->when($from !== '', fn ($q) => $q->whereDate('referrals.created_at', '>=', $from))
            ->when($to !== '', fn ($q) => $q->whereDate('referrals.created_at', '<=', $to))
            ->orderByDesc('referrals.created_at')
            ->select([
                'referrals.*',
                'referrer.name as referrer_name',
                'referrer.mobile as referrer_mobile',
                'referrer.code as referrer_code',
                'referred.name as referred_name',
                'referred.mobile as referred_mobile',
                'referred.email as referred_email',
                'referred.stage as referred_stage',
            ]);

        $referrals = $referralQuery->paginate(40)->withQueryString();

        // Referral settings
        $settings = $this->getReferralSettings();

        // Referral codes (all users with their codes)
        $referralCodes = User::select('id', 'name', 'mobile', 'referral_code', 'refoff')
            ->orderBy('name')
            ->get();

        // Campaign links from settings
        $campaignLinks = $this->getCampaignLinks();

        // KPIs
        $totalReferrals = Referral::count();
        $totalClicks = User::sum('clicks');
        $bonus = (int) ($settings['bonus'] ?? 100);
        $rewardPoints = $totalReferrals * $bonus;

        // Click stats per referrer for export
        $referrerStats = User::select('name', 'mobile', 'code', 'clicks')
            ->where('clicks', '>', 0)
            ->get()
            ->mapWithKeys(fn ($u) => [$u->name => (int) $u->clicks])
            ->all();

        return view('admin.referrals', compact(
            'referrals',
            'from',
            'to',
            'settings',
            'referralCodes',
            'campaignLinks',
            'totalReferrals',
            'totalClicks',
            'rewardPoints',
            'referrerStats'
        ));
    }

    private function getReferralSettings(): array
    {
        $defaults = [
            'on' => true,
            'base' => config('app.url', 'https://retirementplankaro.com/'),
            'bonus' => 100,
            'friend' => 0,
            'verify' => true,
            'max' => '',
            'msg' => 'Plan your retirement with Retirement Plan Karo. Join with my link: {link}',
        ];
        $raw = Settings::get('referral_programme');
        if ($raw) {
            $j = json_decode($raw, true);
            if (is_array($j)) {
                return array_merge($defaults, $j);
            }
        }
        return $defaults;
    }

    private function getCampaignLinks(): array
    {
        $raw = Settings::get('referral_campaign_links');
        if ($raw) {
            $j = json_decode($raw, true);
            if (is_array($j)) {
                return $j;
            }
        }
        return [];
    }

    public function saveSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'on' => 'nullable|string|in:0,1',
            'bonus' => 'nullable|integer|min:0',
            'friend' => 'nullable|integer|min:0',
            'verify' => 'nullable|string|in:0,1',
            'max' => 'nullable|integer|min:0',
            'base' => 'nullable|string|max:255',
            'msg' => 'nullable|string|max:500',
        ]);
        $settings = [
            'on' => $data['on'] === '1',
            'bonus' => (int) ($data['bonus'] ?? 100),
            'friend' => (int) ($data['friend'] ?? 0),
            'verify' => $request->verify === '1' ? '1' : '0',
            'max' => $data['max'] !== '' ? (int) $data['max'] : '',
            'base' => (string) ($data['base'] ?? config('app.url')),
            'msg' => (string) ($data['msg'] ?? ''),
        ];

        Settings::set('referral_programme', json_encode($settings, JSON_UNESCAPED_UNICODE));
        Activity::log(null, 'referral.settings_saved', 'Referral programme settings saved', $settings, 'Settings', 'referral_programme');

        return back()->with('ok', 'Referral settings saved.');
    }

    public function updateReferralCode(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:users,id',
            'code' => 'required|string|max:20|unique:users,code,' . $request->input('id'),
        ]);

        $user = User::findOrFail($data['id']);
        $oldCode = $user->code;
        $newCode = strtoupper(trim($data['code']));

        $user->update(['code' => $newCode]);

        Activity::log(
            $user->id,
            'referral.code_updated',
            "Referral code updated: {$oldCode} → {$newCode}",
            ['user_id' => $user->id, 'old_code' => $oldCode, 'new_code' => $newCode],
            'User',
            $user->id
        );

        return back()->with('ok', 'Referral code updated.');
    }

    public function toggleReferral(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($data['id']);
        $user->update(['refoff' => !$user->refoff]);

        Activity::log(
            $user->id,
            'referral.toggled',
            ($user->refoff ? 'Disabled' : 'Enabled') . " referral for {$user->name}",
            ['user_id' => $user->id, 'refoff' => $user->refoff],
            'User',
            $user->id
        );

        return back()->with('ok', $user->refoff ? 'Referral disabled.' : 'Referral enabled.');
    }

    public function addCampaignLink(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
            'target' => 'required|string|max:100',
            'on' => 'nullable|string|in:0,1',
        ]);

        $links = $this->getCampaignLinks();
        $data['code'] = trim($data['code']);
        if (empty($data['name']) || empty($data['code'])) {
            return back()->with('error', 'Name and code are required.');
        }
        if (collect($links)->contains('code', $data['code'])) {
            return back()->with('error', 'Campaign code already exists.');
        }

        $links[] = [
            'name' => $data['name'],
            'code' => $data['code'],
            'target' => $data['target'],
            'clicks' => 0,
            'signups' => 0,
            'on' => $data['on'] === '1',
        ];

        Settings::set('referral_campaign_links', json_encode($links, JSON_UNESCAPED_UNICODE));
        Activity::log(null, 'referral.campaign_link_added', "Campaign link added: {$data['name']}", $links, 'Settings', 'referral_campaign_links');

        return back()->with('ok', 'Campaign link added.');
    }

    public function editCampaignLink(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'index' => 'required|integer|min:0',
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
            'target' => 'required|string|max:100',
            'on' => 'nullable|string|in:0,1',
        ]);

        $links = $this->getCampaignLinks();
        $index = $data['index'];

        if (!isset($links[$index])) {
            return back()->with('error', 'Campaign link not found.');
        }

        $data['code'] = trim($data['code']);
        if (empty($data['name']) || empty($data['code'])) {
            return back()->with('error', 'Name and code are required.');
        }
        if (collect($links)->except($index)->contains('code', $data['code'])) {
            return back()->with('error', 'Campaign code already exists.');
        }

        $links[$index] = [
            'name' => $data['name'],
            'code' => $data['code'],
            'target' => $data['target'],
            'clicks' => $links[$index]['clicks'] ?? 0,
            'signups' => $links[$index]['signups'] ?? 0,
            'on' => $data['on'] === '1',
        ];

        Settings::set('referral_campaign_links', json_encode($links, JSON_UNESCAPED_UNICODE));
        Activity::log(null, 'referral.campaign_link_edited', "Campaign link edited: {$data['name']}", $links, 'Settings', 'referral_campaign_links');

        return back()->with('ok', 'Campaign link updated.');
    }

    public function deleteCampaignLink(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'index' => 'required|integer|min:0',
        ]);

        $links = $this->getCampaignLinks();
        $index = $data['index'];

        if (!isset($links[$index])) {
            return back()->with('error', 'Campaign link not found.');
        }

        $name = $links[$index]['name'];
        unset($links[$index]);
        $links = array_values($links);

        Settings::set('referral_campaign_links', json_encode($links, JSON_UNESCAPED_UNICODE));
        Activity::log(null, 'referral.campaign_link_deleted', "Campaign link deleted: {$name}", $links, 'Settings', 'referral_campaign_links');

        return back()->with('ok', 'Campaign link deleted.');
    }
}