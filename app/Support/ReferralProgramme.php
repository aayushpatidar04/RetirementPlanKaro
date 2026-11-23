<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * The referral rules saved under Referrals → Reward settings, used by signup and email verification.
 *  on     – programme switched on
 *  bonus  – points the referrer earns
 *  friend – points the new client earns for joining with a link
 *  verify – pay only after the new client verifies their email
 *  max    – most paid referrals per client ('' = no limit)
 */
class ReferralProgramme
{
    /** campaign "target" => website path */
    public const TARGETS = [
        'planner' => '/',
        'explore' => '/explore',
        'get-quotes' => '/get-quotes',
        'sip-calculator' => '/sip-calculator',
        'tax-calculator' => '/income-tax-calculator',
        'emi-calculator' => '/home-loan-emi-calculator',
        'budget-planner' => '/budget-planner',
        'portfolio' => '/stock-portfolio-analysis',
        'returns' => '/my-investment-returns',
    ];

    public static function settings(): array
    {
        $d = [
            'on' => true,
            'base' => config('app.url', 'https://retirementplankaro.com'),
            'bonus' => (int) Settings::get('referral_bonus', 100),
            'friend' => 0,
            'verify' => true,
            'max' => '',
            'msg' => 'Plan your retirement with Retirement Plan Karo. Join with my link: {link}',
        ];
        $j = json_decode((string) Settings::get('referral_programme'), true);
        if (is_array($j)) {
            $d = array_merge($d, $j);
        }
        $d['on'] = filter_var($d['on'], FILTER_VALIDATE_BOOLEAN);
        $d['verify'] = filter_var($d['verify'], FILTER_VALIDATE_BOOLEAN);
        $d['bonus'] = (int) $d['bonus'];
        $d['friend'] = (int) $d['friend'];

        return $d;
    }

    public static function bonus(): int
    {
        return self::settings()['bonus'];
    }

    /** Full campaign URL for a saved campaign link. */
    public static function campaignUrl(array $link, ?string $base = null): string
    {
        $base = rtrim($base ?? self::settings()['base'], '/');
        $path = self::TARGETS[$link['target'] ?? 'planner'] ?? '/';

        return $base . $path . '?src=' . rawurlencode((string) ($link['code'] ?? ''));
    }

    /** May this client still earn from referrals? */
    public static function canRefer(User $referrer): bool
    {
        $s = self::settings();
        if (!$s['on'] || $referrer->refoff) {
            return false;
        }
        if ($s['max'] !== '' && $s['max'] !== null && (int) $s['max'] > 0) {
            $paid = DB::table('referrals')->where('referrer_user_id', $referrer->id)->where('credited', true)->count();

            return $paid < (int) $s['max'];
        }

        return true;
    }

    /** Pay out a pending referral row (referrer bonus + optional friend bonus). Safe to call twice. */
    public static function credit(int $referredUserId, string $why): void
    {
        DB::transaction(function () use ($referredUserId, $why) {
            $ref = DB::table('referrals')->where('referred_user_id', $referredUserId)
                ->where('credited', false)->lockForUpdate()->first();
            if (!$ref) {
                return;
            }
            $s = self::settings();
            $referrer = User::find($ref->referrer_user_id);
            $friend = User::find($referredUserId);

            if ($referrer && self::canRefer($referrer) && $s['bonus'] > 0) {
                DB::table('points_ledger')->insert([
                    'user_id' => $referrer->id, 'account' => 'report', 'type' => 'referral_bonus',
                    'points' => $s['bonus'], 'note' => 'Referred ' . ($friend->name ?? 'a friend') . ' (' . $why . ')',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            if ($friend && $s['friend'] > 0) {
                DB::table('points_ledger')->insert([
                    'user_id' => $friend->id, 'account' => 'report', 'type' => 'referral_friend_bonus',
                    'points' => $s['friend'], 'note' => 'Joined with a referral link',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            DB::table('referrals')->where('id', $ref->id)->update(['credited' => true, 'updated_at' => now()]);
        });
    }

    /** Count a signup against a campaign link (code from the visit's ?src=). */
    public static function countCampaignSignup(?string $code): void
    {
        self::bumpCampaign($code, 'signups');
    }

    public static function countCampaignClick(?string $code): void
    {
        self::bumpCampaign($code, 'clicks');
    }

    private static function bumpCampaign(?string $code, string $field): void
    {
        if (!$code) {
            return;
        }
        $links = json_decode((string) Settings::get('referral_campaign_links'), true);
        if (!is_array($links)) {
            return;
        }
        $hit = false;
        foreach ($links as &$l) {
            if (strcasecmp((string) ($l['code'] ?? ''), $code) === 0 && !empty($l['on'])) {
                $l[$field] = (int) ($l[$field] ?? 0) + 1;
                $hit = true;
            }
        }
        unset($l);
        if ($hit) {
            Settings::set('referral_campaign_links', json_encode($links, JSON_UNESCAPED_UNICODE));
        }
    }
}
