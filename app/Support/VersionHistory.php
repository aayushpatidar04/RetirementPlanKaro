<?php

namespace App\Support;

use App\Models\VersionSnapshot;
use Illuminate\Support\Facades\DB;

/**
 * Published Versions: every save of something the website uses stores a snapshot here,
 * so an earlier version can be restored. Each area reads/writes the real data
 * (settings keys or table rows). Live counters (coupon uses, partner clicks) are never
 * rolled back.
 */
class VersionHistory
{
    /** area => ['settings' => keys, 'table' => name|null] */
    public const AREAS = [
        'Pricing' => ['settings' => ['report_price', 'session_price']],
        'Points' => ['settings' => ['ref_pts', 'wallet_unlock_cost', 'wallet_unlock_hours', 'welcome_bonus', 'referral_bonus', 'streak_points', 'streak_days', 'packs']],
        'Discount Codes' => ['table' => 'coupons'],
        'Referral' => ['settings' => ['referral_programme', 'referral_campaign_links']],
        'Session Availability' => ['settings' => ['session_availability']],
        'Investment Partners' => ['table' => 'investment_partners'],
        'Testimonials' => ['table' => 'testimonials', 'settings' => ['testimonials_section']],
    ];

    private const TABLE_COLS = [
        'coupons' => ['id', 'code', 'type', 'value', 'max_uses', 'active', 'expires_at'],
        'investment_partners' => ['id', 'label', 'category', 'partner', 'url', 'is_active', 'sort_order'],
        'testimonials' => ['id', 'name', 'text', 'permission_taken', 'is_active', 'sort_order'],
    ];

    /** Current data of an area, in a stable shape so two captures can be compared. */
    public static function capture(string $area): array
    {
        $def = self::AREAS[$area] ?? [];
        $out = [];
        foreach ($def['settings'] ?? [] as $k) {
            $v = DB::table('settings')->where('key', $k)->value('value');
            $j = is_string($v) ? json_decode($v, true) : null;
            $out[$k] = (is_array($j)) ? $j : (is_numeric($v) ? $v + 0 : $v);
        }
        if (!empty($def['table'])) {
            $t = $def['table'];
            $out['rows'] = DB::table($t)->orderBy('id')->get(self::TABLE_COLS[$t])
                ->map(function ($r) {
                    $a = (array) $r;
                    foreach ($a as $k => $v) {
                        if (is_numeric($v) && !in_array($k, ['code', 'url', 'name', 'label', 'text'], true)) {
                            $a[$k] = $v + 0;
                        }
                    }
                    if (array_key_exists('expires_at', $a) && $a['expires_at']) {
                        $a['expires_at'] = substr((string) $a['expires_at'], 0, 10);
                    }

                    return $a;
                })->all();
        }

        return $out;
    }

    /** Save a version if the area changed since its last version. */
    public static function record(string $area, string $description): ?VersionSnapshot
    {
        try {
            if (!isset(self::AREAS[$area])) {
                return null;
            }
            $data = self::capture($area);
            $last = VersionSnapshot::where('area', $area)->orderByDesc('version')->first();
            if ($last && self::same($last->data, $data)) {
                return null;
            }

            return VersionSnapshot::createSnapshot($area, $data, mb_substr($description, 0, 200));
        } catch (\Throwable $e) {
            return null; // versioning must never break the save itself
        }
    }

    public static function same($a, $b): bool
    {
        return json_encode($a) === json_encode($b);
    }

    /** Put an area back to a stored version. */
    public static function restore(VersionSnapshot $snap): void
    {
        $def = self::AREAS[$snap->area] ?? null;
        abort_unless($def, 422, 'Unknown area.');
        $data = (array) $snap->data;

        DB::transaction(function () use ($def, $data) {
            foreach ($def['settings'] ?? [] as $k) {
                if (!array_key_exists($k, $data) || $data[$k] === null) {
                    continue;
                }
                $v = is_array($data[$k]) ? json_encode($data[$k], JSON_UNESCAPED_UNICODE) : (string) $data[$k];
                Settings::set($k, $v);
            }

            if (!empty($def['table']) && isset($data['rows']) && is_array($data['rows'])) {
                $t = $def['table'];
                $cols = self::TABLE_COLS[$t];
                $keep = [];
                foreach ($data['rows'] as $row) {
                    $row = array_intersect_key((array) $row, array_flip($cols));
                    if (empty($row['id'])) {
                        continue;
                    }
                    $keep[] = $row['id'];
                    $row['updated_at'] = now();
                    if (DB::table($t)->where('id', $row['id'])->exists()) {
                        DB::table($t)->where('id', $row['id'])->update($row);
                    } else {
                        $row['created_at'] = now();
                        if ($t === 'coupons') {
                            $row['used_count'] = 0;
                        }
                        if ($t === 'investment_partners') {
                            $row['clicks'] = 0;
                        }
                        DB::table($t)->insert($row);
                    }
                }
                // rows added after that version
                $extra = DB::table($t)->whereNotIn('id', $keep ?: [0]);
                if ($t === 'coupons') {
                    // a code that was already used keeps its history: switch it off instead
                    $used = DB::table('coupon_redemptions')->pluck('coupon_id')->all();
                    (clone $extra)->whereIn('id', $used ?: [0])->update(['active' => false, 'updated_at' => now()]);
                    $extra->whereNotIn('id', $used ?: [0])->delete();
                } else {
                    $extra->delete();
                }
            }
        });

        // the website shows the *published* testimonials: a restore publishes the restored set
        if ($snap->area === 'Testimonials') {
            $feed = app(\App\Http\Controllers\Admin\TestimonialController::class)->getFeed();
            Settings::set('testimonials_published_snapshot', json_encode($feed, JSON_UNESCAPED_UNICODE));
            Settings::set('testimonials_published_at', now()->format('Y-m-d H:i:s'));
        }
    }

    /** Short "what changed" text between two versions of the same area. */
    public static function diff(?array $before, array $after): string
    {
        if ($before === null) {
            return 'First saved version';
        }
        $parts = [];
        foreach ($after as $k => $v) {
            if ($k === 'rows') {
                $b = collect($before['rows'] ?? [])->keyBy('id');
                $a = collect($v)->keyBy('id');
                $added = $a->keys()->diff($b->keys())->count();
                $removed = $b->keys()->diff($a->keys())->count();
                $changed = $a->filter(fn ($r, $id) => $b->has($id) && json_encode($b[$id]) !== json_encode($r))->count();
                foreach ([[$added, 'added'], [$changed, 'changed'], [$removed, 'removed']] as [$n, $w]) {
                    if ($n) {
                        $parts[] = $n . ' row' . ($n > 1 ? 's' : '') . ' ' . $w;
                    }
                }
                continue;
            }
            $old = $before[$k] ?? null;
            if (json_encode($old) !== json_encode($v)) {
                $fmt = fn ($x) => is_array($x) ? '(list changed)' : (string) ($x ?? '—');
                $parts[] = is_array($v) || is_array($old)
                    ? str_replace('_', ' ', $k) . ' changed'
                    : str_replace('_', ' ', $k) . ': ' . $fmt($old) . ' → ' . $fmt($v);
            }
        }

        return $parts ? implode(' · ', $parts) : 'No change';
    }
}
