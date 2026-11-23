<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /** website product key => Quote Requests product type */
    private const QUOTE_PRODUCTS = [
        'term' => 'Term Insurance',
        'health' => 'Health Insurance',
        'motor' => 'Car / Bike Insurance',
        'card' => 'Credit Card',
        'loan' => 'Personal Loan',
        'lamf' => 'Loan Against Mutual Fund',
    ];

    // The page already fires leads through CFG.hook as plain-text JSON; CFG.hook now points here.
    public function store(Request $request)
    {
        $raw = $request->getContent();
        if ($raw === '' || strlen($raw) > 20000) {
            return response()->noContent();
        }

        $d = json_decode($raw, true);
        if (!is_array($d)) {
            return response()->noContent();
        }

        $event  = substr((string) ($d['ev'] ?? $d['type'] ?? 'lead'), 0, 60);
        $mobile = isset($d['mobile']) ? substr(preg_replace('/\D/', '', (string) $d['mobile']), -10) : null;
        $mobile = $mobile ?: null;
        $email  = isset($d['email']) ? substr((string) $d['email'], 0, 190) : null;

        // "signup" fires on every login in the page: keep one row per person
        if ($event === 'signup' && $mobile && DB::table('leads')->where('event', 'signup')->where('mobile', $mobile)->exists()) {
            return response()->noContent();
        }

        // Never store a PAN number in leads
        if (isset($d['details']['pan'])) {
            $d['details']['pan'] = '(provided)';
        }

        if ($event === 'quote_request') {
            $this->quoteRequest($d, $request);
            $mobile = $mobile ?? (isset($d['details']['mb']) ? substr(preg_replace('/\D/', '', (string) $d['details']['mb']), -10) : null);
            $email = $email ?? ($d['details']['em'] ?? null);
        }

        if ($event === 'referral_click') {
            // One Window Investing: count the click on that partner option
            $opt = $d['option'] ?? null;
            if (is_numeric($opt)) {
                DB::table('investment_partners')->where('id', (int) $opt)->increment('clicks');
            }
        }

        DB::table('leads')->insert([
            'user_id'    => $request->user()?->id,
            'event'      => $event,
            'mobile'     => $mobile,
            'email'      => $email,
            'payload'    => json_encode($d),
            'ip'         => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->noContent();
    }

    /** Website "Get Quotes" form → a row in Admin → Quote Requests. */
    private function quoteRequest(array $d, Request $request): void
    {
        try {
            $det = is_array($d['details'] ?? null) ? $d['details'] : [];
            $type = self::QUOTE_PRODUCTS[$d['product'] ?? ''] ?? substr((string) ($d['productName'] ?? 'Other'), 0, 60);
            $mobile = substr(preg_replace('/\D/', '', (string) ($det['mb'] ?? '')), -10);

            // label/value pairs shown on the website confirmation, minus the contact fields kept in their own columns
            $skip = ['Full name', 'Mobile number', 'Email ID', 'City'];
            $pairs = [];
            foreach (is_array($d['rows'] ?? null) ? $d['rows'] : [] as $r) {
                if (is_array($r) && isset($r[0], $r[1]) && !in_array($r[0], $skip, true)) {
                    $pairs[] = [mb_substr((string) $r[0], 0, 80), mb_substr((string) $r[1], 0, 300)];
                }
            }
            if (!$pairs) {
                foreach ($det as $k => $v) {
                    if (!in_array($k, ['nm', 'mb', 'em', 'ct', 'pan'], true) && is_scalar($v) && $v !== '') {
                        $pairs[] = [$k, mb_substr((string) $v, 0, 300)];
                    }
                }
            }

            DB::table('quote_requests')->insert([
                'user_id' => $request->user()?->id,
                'product_type' => $type,
                'customer_name' => mb_substr((string) ($det['nm'] ?? ($request->user()?->name ?? 'Website visitor')), 0, 120),
                'customer_mobile' => $mobile ?: ($request->user()?->mobile ?? null),
                'customer_email' => isset($det['em']) ? mb_substr((string) $det['em'], 0, 190) : ($request->user()?->email ?? null),
                'customer_city' => isset($det['ct']) ? mb_substr((string) $det['ct'], 0, 80) : ($request->user()?->city ?? null),
                'details' => json_encode($pairs, JSON_UNESCAPED_UNICODE),
                'note' => 'Website request ' . mb_substr((string) ($d['ref'] ?? ''), 0, 30),
                'status' => 'New',
                'consent' => !empty($d['consent']['given']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
