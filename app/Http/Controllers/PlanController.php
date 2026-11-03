<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    private const ASSET_SLOTS = ['bank', 'fd', 'eq', 'epf', 'gold', 're', 'home'];
    private const LIAB_SLOTS  = ['hl', 'cl', 'pl', 'ol'];
    private const EXP_SLOTS   = ['x0', 'x1', 'x2', 'x3', 'x4', 'x5', 'x6', 'x7', 'x8', 'x9'];
    private const COUNTRIES   = ['IN', 'US', 'GB', 'EU', 'AE', 'SA', 'QA', 'CA', 'AU', 'NZ', 'SG', 'HK', 'CH', 'JP', 'MY', 'PH', 'NP', 'BD', 'PK', 'ZA', 'NG'];
    private const HEALTH      = ['None', 'Individual', 'Family floater', 'Employer (group) only'];
    private const EMERGENCY   = ['Savings account', 'Liquid fund or FD', 'Both', 'Not kept separately'];

    /* ---------- GET /api/plan : everything saved so far ---------- */
    public function show(Request $request): JsonResponse
    {
        $uid = $request->user()->id;

        $nw = DB::table('net_worths')->where('user_id', $uid)->first();
        $ie = DB::table('income_expenses')->where('user_id', $uid)->first();
        $rp = DB::table('retirement_plans')->where('user_id', $uid)->first();

        $protection = DB::table('protections')->where('user_id', $uid)->first([
            'life_insurance', 'life_cover', 'term_premium', 'term_till_age',
            'health_type', 'health_cover', 'health_premium', 'health_topup',
            'emergency_fund', 'emergency_where',
        ]);

        return response()->json([
            'netWorth' => $nw ? [
                'age'         => $nw->age,
                'country'     => $nw->country,
                'assets'      => DB::table('assets')->where('user_id', $uid)->orderBy('id')->get(['slot', 'type', 'label', 'amount']),
                'liabilities' => DB::table('liabilities')->where('user_id', $uid)->orderBy('id')->get(['slot', 'label', 'amount']),
            ] : null,

            'incomeExpense' => $ie ? [
                'income'     => $ie->monthly_income,
                'expenses'   => DB::table('expenses')->where('user_id', $uid)->orderBy('id')->get(['slot', 'label', 'amount', 'is_essential as essential']),
                'protection' => $protection,
            ] : null,

            'retirement' => $rp ? [
                'retirement_age'   => $rp->retirement_age,
                'life_expectancy'  => $rp->life_expectancy,
                'monthly_spending' => $rp->monthly_spending,
                'other_income'     => $rp->other_income,
                'inflation_rate'   => $rp->inflation_rate,
                'return_pre'       => $rp->return_pre,
                'return_post'      => $rp->return_post,
                'current_corpus'   => $rp->current_corpus,
                'monthly_sip'      => $rp->monthly_sip,
                'step_up_percent'  => $rp->step_up_percent,
                'spending_auto'    => (bool) $rp->spending_auto,
                'corpus_auto'      => (bool) $rp->corpus_auto,
                'sip_auto'         => (bool) $rp->sip_auto,
            ] : null,
        ]);
    }

    /* ---------- POST /api/plan/net-worth (Step 1) ---------- */
    public function netWorth(Request $request): JsonResponse
    {
        $d = $request->validate([
            'age'                   => ['nullable', 'numeric', 'min:0', 'max:110'],
            'country'               => ['nullable', Rule::in(self::COUNTRIES)],
            'assets'                => ['present', 'array', 'max:80'],
            'assets.*.type'         => ['required', Rule::in(['liquid', 'non_liquid'])],
            'assets.*.slot'         => ['nullable', Rule::in(self::ASSET_SLOTS)],
            'assets.*.label'        => ['nullable', 'string', 'max:60'],
            'assets.*.amount'       => $this->money(),
            'liabilities'           => ['present', 'array', 'max:20'],
            'liabilities.*.slot'    => ['nullable', Rule::in(self::LIAB_SLOTS)],
            'liabilities.*.label'   => ['nullable', 'string', 'max:60'],
            'liabilities.*.amount'  => $this->money(),
        ]);

        $uid = $request->user()->id;

        DB::transaction(function () use ($uid, $d) {
            $this->upsertRow('net_worths', $uid, [
                'age'     => isset($d['age']) ? (float) $d['age'] : null,
                'country' => $d['country'] ?? 'IN',
            ]);

            $this->replaceRows('assets', $uid, array_map(fn ($a) => [
                'type'   => $a['type'],
                'slot'   => $a['slot'] ?? null,
                'label'  => trim((string) ($a['label'] ?? '')) ?? 'Other',
                'amount' => (float) ($a['amount'] ?? 0),
            ], array_values($d['assets'])));

            $this->replaceRows('liabilities', $uid, array_map(fn ($l) => [
                'slot'   => $l['slot'] ?? null,
                'label'  => trim((string) ($l['label'] ?? '')) ?? 'Other',
                'amount' => (float) ($l['amount'] ?? 0),
            ], array_values($d['liabilities'])));
        });

        return response()->json(['saved' => true]);
    }

    /* ---------- POST /api/plan/income-expense (Step 2) ---------- */
    public function incomeExpense(Request $request): JsonResponse
    {
        $d = $request->validate([
            'income'                        => $this->money(),
            'expenses'                      => ['present', 'array', 'max:80'],
            'expenses.*.slot'               => ['nullable', Rule::in(self::EXP_SLOTS)],
            'expenses.*.label'              => ['nullable', 'string', 'max:60'],
            'expenses.*.amount'             => $this->money(),
            'expenses.*.essential'          => ['nullable', 'boolean'],
            'protection'                    => ['required', 'array'],
            'protection.life_insurance'     => ['nullable', Rule::in(['Yes', 'No'])],
            'protection.life_cover'         => $this->money(),
            'protection.term_premium'       => $this->money(),
            'protection.term_till_age'      => ['nullable', 'numeric', 'min:0', 'max:120'],
            'protection.health_type'        => ['nullable', Rule::in(self::HEALTH)],
            'protection.health_cover'       => $this->money(),
            'protection.health_premium'     => $this->money(),
            'protection.health_topup'       => ['nullable', Rule::in(['Yes', 'No'])],
            'protection.emergency_fund'     => $this->money(),
            'protection.emergency_where'    => ['nullable', Rule::in(self::EMERGENCY)],
        ]);

        $uid = $request->user()->id;
        $p = $d['protection'];

        DB::transaction(function () use ($uid, $d, $p) {
            $this->upsertRow('income_expenses', $uid, [
                'monthly_income' => (float) ($d['income'] ?? 0),
            ]);

            $this->replaceRows('expenses', $uid, array_map(fn ($x) => [
                'slot'         => $x['slot'] ?? null,
                'label'        => trim((string) ($x['label'] ?? '')) ?? 'Other',
                'amount'       => (float) ($x['amount'] ?? 0),
                'is_essential' => (bool) ($x['essential'] ?? false),
            ], array_values($d['expenses'])));

            $this->upsertRow('protections', $uid, [
                'life_insurance'  => $p['life_insurance'] ?? 'No',
                'life_cover'      => (float) ($p['life_cover'] ?? 0),
                'term_premium'    => (float) ($p['term_premium'] ?? 0),
                'term_till_age'   => (float) ($p['term_till_age'] ?? 0),
                'health_type'     => $p['health_type'] ?? 'None',
                'health_cover'    => (float) ($p['health_cover'] ?? 0),
                'health_premium'  => (float) ($p['health_premium'] ?? 0),
                'health_topup'    => $p['health_topup'] ?? 'No',
                'emergency_fund'  => (float) ($p['emergency_fund'] ?? 0),
                'emergency_where' => $p['emergency_where'] ?? 'Savings account',
            ]);
        });

        return response()->json(['saved' => true]);
    }

    /* ---------- POST /api/plan/retirement-plan (Step 3) ---------- */
    public function retirementPlan(Request $request): JsonResponse
    {
        $d = $request->validate([
            'retirement_age'   => ['nullable', 'numeric', 'min:0', 'max:110'],
            'life_expectancy'  => ['nullable', 'numeric', 'min:0', 'max:120'],
            'monthly_spending' => $this->money(),
            'other_income'     => $this->money(),
            'inflation_rate'   => ['nullable', 'numeric', 'min:0', 'max:100'],
            'return_pre'       => ['nullable', 'numeric', 'min:0', 'max:100'],
            'return_post'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'current_corpus'   => $this->money(),
            'monthly_sip'      => $this->money(),
            'step_up_percent'  => ['nullable', 'numeric', 'min:0', 'max:100'],
            'spending_auto'    => ['nullable', 'boolean'],
            'corpus_auto'      => ['nullable', 'boolean'],
            'sip_auto'         => ['nullable', 'boolean'],
        ]);

        $this->upsertRow('retirement_plans', $request->user()->id, [
            'retirement_age'   => (float) ($d['retirement_age'] ?? 60),
            'life_expectancy'  => (float) ($d['life_expectancy'] ?? 90),
            'monthly_spending' => (float) ($d['monthly_spending'] ?? 0),
            'other_income'     => (float) ($d['other_income'] ?? 0),
            'inflation_rate'   => (float) ($d['inflation_rate'] ?? 0),
            'return_pre'       => (float) ($d['return_pre'] ?? 0),
            'return_post'      => (float) ($d['return_post'] ?? 0),
            'current_corpus'   => (float) ($d['current_corpus'] ?? 0),
            'monthly_sip'      => (float) ($d['monthly_sip'] ?? 0),
            'step_up_percent'  => (float) ($d['step_up_percent'] ?? 0),
            'spending_auto'    => (bool) ($d['spending_auto'] ?? false),
            'corpus_auto'      => (bool) ($d['corpus_auto'] ?? false),
            'sip_auto'         => (bool) ($d['sip_auto'] ?? false),
        ]);

        return response()->json(['saved' => true]);
    }

    /* ---------- POST /api/plan/sync-local : one-time bulk import of guest localStorage ----------
     * Fired once, right after a logged-out user is forced through signup/login at the
     * Step 3 -> Step 4 gate. The frontend sends whatever is sitting in localStorage for
     * Steps 1-3 under netWorth / incomeExpense / retirementPlan keys (same shape each
     * step already posts individually). We only fill a step that has NOTHING saved for
     * this user yet — never silently overwrite a plan the user already saved earlier
     * (e.g. from a previous session/device), since that would be surprising data loss.
     */
    public function syncLocal(Request $request): JsonResponse
    {
        $uid = $request->user()->id;

        $d = $request->validate([
            'netWorth'                      => ['nullable', 'array'],
            'netWorth.age'                   => ['nullable', 'numeric', 'min:0', 'max:110'],
            'netWorth.country'               => ['nullable', Rule::in(self::COUNTRIES)],
            'netWorth.assets'                => ['nullable', 'array', 'max:80'],
            'netWorth.assets.*.type'         => ['required_with:netWorth.assets', Rule::in(['liquid', 'non_liquid'])],
            'netWorth.assets.*.slot'         => ['nullable', Rule::in(self::ASSET_SLOTS)],
            'netWorth.assets.*.label'        => ['nullable', 'string', 'max:60'],
            'netWorth.assets.*.amount'       => $this->money(),
            'netWorth.liabilities'           => ['nullable', 'array', 'max:20'],
            'netWorth.liabilities.*.slot'    => ['nullable', Rule::in(self::LIAB_SLOTS)],
            'netWorth.liabilities.*.label'   => ['nullable', 'string', 'max:60'],
            'netWorth.liabilities.*.amount'  => $this->money(),

            'incomeExpense'                              => ['nullable', 'array'],
            'incomeExpense.income'                        => $this->money(),
            'incomeExpense.expenses'                      => ['nullable', 'array', 'max:80'],
            'incomeExpense.expenses.*.slot'               => ['nullable', Rule::in(self::EXP_SLOTS)],
            'incomeExpense.expenses.*.label'              => ['nullable', 'string', 'max:60'],
            'incomeExpense.expenses.*.amount'             => $this->money(),
            'incomeExpense.expenses.*.essential'          => ['nullable', 'boolean'],
            'incomeExpense.protection'                    => ['nullable', 'array'],
            'incomeExpense.protection.life_insurance'     => ['nullable', Rule::in(['Yes', 'No'])],
            'incomeExpense.protection.life_cover'         => $this->money(),
            'incomeExpense.protection.term_premium'       => $this->money(),
            'incomeExpense.protection.term_till_age'      => ['nullable', 'numeric', 'min:0', 'max:120'],
            'incomeExpense.protection.health_type'        => ['nullable', Rule::in(self::HEALTH)],
            'incomeExpense.protection.health_cover'       => $this->money(),
            'incomeExpense.protection.health_premium'     => $this->money(),
            'incomeExpense.protection.health_topup'       => ['nullable', Rule::in(['Yes', 'No'])],
            'incomeExpense.protection.emergency_fund'     => $this->money(),
            'incomeExpense.protection.emergency_where'    => ['nullable', Rule::in(self::EMERGENCY)],

            'retirementPlan'                    => ['nullable', 'array'],
            'retirementPlan.retirement_age'     => ['nullable', 'numeric', 'min:0', 'max:110'],
            'retirementPlan.life_expectancy'    => ['nullable', 'numeric', 'min:0', 'max:120'],
            'retirementPlan.monthly_spending'   => $this->money(),
            'retirementPlan.other_income'       => $this->money(),
            'retirementPlan.inflation_rate'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'retirementPlan.return_pre'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'retirementPlan.return_post'        => ['nullable', 'numeric', 'min:0', 'max:100'],
            'retirementPlan.current_corpus'     => $this->money(),
            'retirementPlan.monthly_sip'        => $this->money(),
            'retirementPlan.step_up_percent'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'retirementPlan.spending_auto'      => ['nullable', 'boolean'],
            'retirementPlan.corpus_auto'        => ['nullable', 'boolean'],
            'retirementPlan.sip_auto'           => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($uid, $d) {
            if (!empty($d['netWorth']) && !DB::table('net_worths')->where('user_id', $uid)->exists()) {
                $nw = $d['netWorth'];
                $this->upsertRow('net_worths', $uid, [
                    'age'     => isset($nw['age']) ? (float) $nw['age'] : null,
                    'country' => $nw['country'] ?? 'IN',
                ]);
                $this->replaceRows('assets', $uid, array_map(fn ($a) => [
                    'type'   => $a['type'],
                    'slot'   => $a['slot'] ?? null,
                    'label'  => trim((string) ($a['label'] ?? '')) ?? 'Other',
                    'amount' => (float) ($a['amount'] ?? 0),
                ], array_values($nw['assets'] ?? [])));
                $this->replaceRows('liabilities', $uid, array_map(fn ($l) => [
                    'slot'   => $l['slot'] ?? null,
                    'label'  => trim((string) ($l['label'] ?? '')) ?? 'Other',
                    'amount' => (float) ($l['amount'] ?? 0),
                ], array_values($nw['liabilities'] ?? [])));
            }

            if (!empty($d['incomeExpense']) && !DB::table('income_expenses')->where('user_id', $uid)->exists()) {
                $ie = $d['incomeExpense'];
                $p  = $ie['protection'] ?? [];
                $this->upsertRow('income_expenses', $uid, [
                    'monthly_income' => (float) ($ie['income'] ?? 0),
                ]);
                $this->replaceRows('expenses', $uid, array_map(fn ($x) => [
                    'slot'         => $x['slot'] ?? null,
                    'label'        => trim((string) ($x['label'] ?? '')) ?? 'Other',
                    'amount'       => (float) ($x['amount'] ?? 0),
                    'is_essential' => (bool) ($x['essential'] ?? false),
                ], array_values($ie['expenses'] ?? [])));
                $this->upsertRow('protections', $uid, [
                    'life_insurance'  => $p['life_insurance'] ?? 'No',
                    'life_cover'      => (float) ($p['life_cover'] ?? 0),
                    'term_premium'    => (float) ($p['term_premium'] ?? 0),
                    'term_till_age'   => (float) ($p['term_till_age'] ?? 0),
                    'health_type'     => $p['health_type'] ?? 'None',
                    'health_cover'    => (float) ($p['health_cover'] ?? 0),
                    'health_premium'  => (float) ($p['health_premium'] ?? 0),
                    'health_topup'    => $p['health_topup'] ?? 'No',
                    'emergency_fund'  => (float) ($p['emergency_fund'] ?? 0),
                    'emergency_where' => $p['emergency_where'] ?? 'Savings account',
                ]);
            }

            if (!empty($d['retirementPlan']) && !DB::table('retirement_plans')->where('user_id', $uid)->exists()) {
                $rp = $d['retirementPlan'];
                $this->upsertRow('retirement_plans', $uid, [
                    'retirement_age'   => (float) ($rp['retirement_age'] ?? 60),
                    'life_expectancy'  => (float) ($rp['life_expectancy'] ?? 90),
                    'monthly_spending' => (float) ($rp['monthly_spending'] ?? 0),
                    'other_income'     => (float) ($rp['other_income'] ?? 0),
                    'inflation_rate'   => (float) ($rp['inflation_rate'] ?? 0),
                    'return_pre'       => (float) ($rp['return_pre'] ?? 0),
                    'return_post'      => (float) ($rp['return_post'] ?? 0),
                    'current_corpus'   => (float) ($rp['current_corpus'] ?? 0),
                    'monthly_sip'      => (float) ($rp['monthly_sip'] ?? 0),
                    'step_up_percent'  => (float) ($rp['step_up_percent'] ?? 0),
                    'spending_auto'    => (bool) ($rp['spending_auto'] ?? false),
                    'corpus_auto'      => (bool) ($rp['corpus_auto'] ?? false),
                    'sip_auto'         => (bool) ($rp['sip_auto'] ?? false),
                ]);
            }
        });

        return response()->json(['saved' => true]);
    }

    /* ---------- helpers ---------- */
    private function money(): array
    {
        return ['nullable', 'numeric', 'min:0', 'max:10000000000000'];
    }

    // One row per user: update if it exists, insert if not
    private function upsertRow(string $table, int $uid, array $values): void
    {
        $now = now();

        if (DB::table($table)->where('user_id', $uid)->exists()) {
            DB::table($table)->where('user_id', $uid)->update($values + ['updated_at' => $now]);
        } else {
            DB::table($table)->insert($values + ['user_id' => $uid, 'created_at' => $now, 'updated_at' => $now]);
        }
    }

    // Many rows per user: delete old rows, insert the new set
    private function replaceRows(string $table, int $uid, array $rows): void
    {
        DB::table($table)->where('user_id', $uid)->delete();

        if (!$rows) {
            return;
        }

        $now = now();
        DB::table($table)->insert(array_map(
            fn ($r) => $r + ['user_id' => $uid, 'created_at' => $now, 'updated_at' => $now],
            $rows
        ));
    }
}