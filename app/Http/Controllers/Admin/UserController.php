<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $users = DB::table('users')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('surname', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('mobile', 'like', "%{$q}%")
                        ->orWhere('referral_code', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function show(int $id): View
    {
        $user = DB::table('users')->find($id);
        $payments = DB::table('payments')->where('user_id', $id)->orderByDesc('id')->get();
        $sessions = DB::table('guidance_sessions')->where('user_id', $id)->orderByDesc('id')->get();
        $leads = DB::table('leads')->where('user_id', $id)->orderByDesc('id')->get();
        $blobs = DB::table('user_blobs')->where('user_id', $id)->get();
        $reportPts = (int) DB::table('points_ledger')->where('user_id', $id)->where('account','report')->sum('points');
        $walletPts = (int) DB::table('points_ledger')->where('user_id', $id)->where('account','wallet')->sum('points');
        $ledger = DB::table('points_ledger')->where('user_id', $id)->orderByDesc('id')->limit(50)->get();
        $notes = DB::table('client_notes')->where('user_id', $id)->orderByDesc('id')->get();

        $netWorth = DB::table('net_worths')->where('user_id', $id)->first();
        $assets = DB::table('assets')->where('user_id', $id)->orderBy('id')->get();
        $liabilities = DB::table('liabilities')->where('user_id', $id)->orderBy('id')->get();
        $incomeExpense = DB::table('income_expenses')->where('user_id', $id)->first();
        $expenses = DB::table('expenses')->where('user_id', $id)->orderBy('id')->get();
        $protection = DB::table('protections')->where('user_id', $id)->first();
        $retirement = DB::table('retirement_plans')->where('user_id', $id)->first();
        $goals = DB::table('life_goals')->where('user_id', $id)->orderBy('id')->get();
        $family = DB::table('family_members')->where('user_id', $id)->orderBy('id')->get();
        $swp = DB::table('swp_settings')->where('user_id', $id)->first();
        $toolUsages = DB::table('tool_usages')->where('user_id', $id)->orderByDesc('used_at')->orderByDesc('id')->get();
        $portfolioBlob = DB::table('user_blobs')->where('user_id', $id)->where('kind', 'portfolio')->value('data');
        $portfolio = $portfolioBlob ? json_decode($portfolioBlob, true) : null;
        $premiumReports = DB::table('payments')->where('user_id', $id)->where('purpose', 'report')->orderByDesc('id')->get();
        $couponRedemptions = DB::table('coupon_redemptions')
            ->leftJoin('coupons', 'coupons.id', '=', 'coupon_redemptions.coupon_id')
            ->leftJoin('payments', 'payments.id', '=', 'coupon_redemptions.payment_id')
            ->where('coupon_redemptions.user_id', $id)
            ->orderByDesc('coupon_redemptions.id')
            ->select('coupons.code', 'payments.txnid', 'payments.coupon_off', 'payments.amount', 'coupon_redemptions.created_at')
            ->get();

        return view('admin.users.show', compact(
            'user','payments','sessions','leads','blobs','reportPts','walletPts','ledger','notes',
            'netWorth','assets','liabilities','incomeExpense','expenses','protection','retirement','goals','family','swp',
            'toolUsages','portfolio','premiumReports','couponRedemptions'
        ));
    }



    public function updateTags(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'tags' => 'nullable|string|max:500',
            'assigned_to' => 'nullable|string|max:100',
            'stage' => 'nullable|string|max:50',
        ]);
        $tags = collect(explode(',', (string)($data['tags'] ?? '')))->map(fn($t)=>trim($t))->filter()->values()->all();
        DB::table('users')->where('id', $id)->update([
            'tags' => json_encode($tags),
            'assigned_to' => $data['assigned_to'] ?? null,
            'stage' => $data['stage'] ?? null,
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.users.show', $id)->with('ok', 'Tags updated.');
    }

    public function updatePlanner(Request $request, int $id)
    {
        User::findOrFail($id);
        $now = now();
        $num = fn($v) => ($v === null || $v === '') ? null : (float) $v;
        $amt = fn($v) => (float) ($v ?? 0);
        $parseList = function (?string $txt, string $type = 'asset') {
            $rows = [];
            foreach (preg_split('/\r?\n/', (string) $txt) as $line) {
                $line = trim($line); if ($line === '') continue;
                $essential = false;
                if ($type === 'expense' && str_ends_with($line, '*')) { $essential = true; $line = trim(substr($line, 0, -1)); }
                $parts = preg_split('/\s*[=:]\s*/', $line, 2);
                $label = trim($parts[0] ?? 'Other') ?: 'Other';
                $val = isset($parts[1]) ? (float) preg_replace('/[^\d.\-]/', '', $parts[1]) : 0;
                $rows[] = ['label' => $label, 'amount' => $val, 'essential' => $essential];
            }
            return $rows;
        };
        $parseGoals = function (?string $txt) {
            $rows = [];
            foreach (preg_split('/\r?\n/', (string) $txt) as $line) {
                $line = trim($line); if ($line === '') continue;
                $age = 0; if (preg_match('/@\s*(\d+(?:\.\d+)?)/', $line, $m)) { $age = (float) $m[1]; $line = trim(preg_replace('/@\s*\d+(?:\.\d+)?/', '', $line)); }
                $parts = preg_split('/\s*[=:]\s*/', $line, 2);
                $name = trim($parts[0] ?? 'Goal') ?: 'Goal';
                $cost = isset($parts[1]) ? (float) preg_replace('/[^\d.\-]/', '', $parts[1]) : 0;
                $rows[] = ['name' => $name, 'cost_today' => $cost, 'target_age' => $age];
            }
            return $rows;
        };
        $parseFamily = function (?string $txt) {
            $rows = [];
            foreach (preg_split('/\r?\n/', (string) $txt) as $line) {
                $line = trim($line); if ($line === '') continue;
                $parts = array_map('trim', explode('|', $line));
                $rows[] = ['name' => $parts[0] ?: 'Member', 'rel' => $parts[1] ?? '', 'age' => isset($parts[2]) ? (float) preg_replace('/[^\d.\-]/', '', $parts[2]) : 0];
            }
            return $rows;
        };

        $uid = $id;
        DB::transaction(function () use ($request, $uid, $now, $parseList, $parseGoals, $parseFamily, $num, $amt) {
            $nw = ['age' => $num($request->input('nw_age')), 'country' => $request->string('nw_country')->trim() ?: 'IN', 'updated_at' => $now];
            if (DB::table('net_worths')->where('user_id', $uid)->exists()) DB::table('net_worths')->where('user_id', $uid)->update($nw);
            else DB::table('net_worths')->insert($nw + ['user_id' => $uid, 'created_at' => $now]);

            DB::table('assets')->where('user_id', $uid)->delete();
            foreach ($parseList($request->input('assets_liquid')) as $r) DB::table('assets')->insert(['user_id'=>$uid,'type'=>'liquid','slot'=>null,'label'=>$r['label'],'amount'=>$r['amount'],'created_at'=>$now,'updated_at'=>$now]);
            foreach ($parseList($request->input('assets_non')) as $r) DB::table('assets')->insert(['user_id'=>$uid,'type'=>'non_liquid','slot'=>null,'label'=>$r['label'],'amount'=>$r['amount'],'created_at'=>$now,'updated_at'=>$now]);
            DB::table('liabilities')->where('user_id', $uid)->delete();
            foreach ($parseList($request->input('liabilities')) as $r) DB::table('liabilities')->insert(['user_id'=>$uid,'slot'=>null,'label'=>$r['label'],'amount'=>$r['amount'],'created_at'=>$now,'updated_at'=>$now]);

            $ie = ['monthly_income' => $amt($request->input('monthly_income')), 'updated_at' => $now];
            if (DB::table('income_expenses')->where('user_id', $uid)->exists()) DB::table('income_expenses')->where('user_id', $uid)->update($ie);
            else DB::table('income_expenses')->insert($ie + ['user_id' => $uid, 'created_at' => $now]);
            DB::table('expenses')->where('user_id', $uid)->delete();
            foreach ($parseList($request->input('expenses'), 'expense') as $r) DB::table('expenses')->insert(['user_id'=>$uid,'slot'=>null,'label'=>$r['label'],'amount'=>$r['amount'],'is_essential'=>$r['essential'],'created_at'=>$now,'updated_at'=>$now]);

            $prot = [
                'life_insurance'=>$request->string('life_insurance')->trim()?:'No','life_cover'=>$amt($request->input('life_cover')),
                'term_premium'=>$amt($request->input('term_premium')),'term_till_age'=>$amt($request->input('term_till_age')),
                'health_type'=>$request->string('health_type')->trim()?:'None','health_cover'=>$amt($request->input('health_cover')),
                'health_premium'=>$amt($request->input('health_premium')),'health_topup'=>$request->string('health_topup')->trim()?:'No',
                'emergency_fund'=>$amt($request->input('emergency_fund')),'emergency_where'=>$request->string('emergency_where')->trim()?:'Savings account','updated_at'=>$now,
            ];
            if (DB::table('protections')->where('user_id', $uid)->exists()) DB::table('protections')->where('user_id', $uid)->update($prot);
            else DB::table('protections')->insert($prot + ['user_id'=>$uid,'created_at'=>$now]);

            $rp = [
                'retirement_age'=>$amt($request->input('retirement_age'))?:60,'life_expectancy'=>$amt($request->input('life_expectancy'))?:90,
                'monthly_spending'=>$amt($request->input('monthly_spending')),'other_income'=>$amt($request->input('other_income')),
                'inflation_rate'=>$amt($request->input('inflation_rate')),'return_pre'=>$amt($request->input('return_pre')),'return_post'=>$amt($request->input('return_post')),
                'current_corpus'=>$amt($request->input('current_corpus')),'monthly_sip'=>$amt($request->input('monthly_sip')),'step_up_percent'=>$amt($request->input('step_up_percent')),
                'updated_at'=>$now,
            ];
            if (DB::table('retirement_plans')->where('user_id', $uid)->exists()) DB::table('retirement_plans')->where('user_id', $uid)->update($rp);
            else DB::table('retirement_plans')->insert($rp + ['user_id'=>$uid,'created_at'=>$now]);

            DB::table('life_goals')->where('user_id', $uid)->delete();
            foreach ($parseGoals($request->input('goals')) as $g) DB::table('life_goals')->insert(['user_id'=>$uid,'name'=>$g['name'],'cost_today'=>$g['cost_today'],'target_age'=>$g['target_age'],'created_at'=>$now,'updated_at'=>$now]);

            DB::table('family_members')->where('user_id', $uid)->delete();
            foreach ($parseFamily($request->input('family')) as $f) DB::table('family_members')->insert(['user_id'=>$uid,'name'=>$f['name'],'rel'=>$f['rel'],'age'=>$f['age'],'created_at'=>$now,'updated_at'=>$now]);

            $swp = ['mode'=>$request->string('swp_mode')->trim()?:'mine','show_filter'=>$request->string('swp_show_filter')->trim()?:'all','updated_at'=>$now];
            if (DB::table('swp_settings')->where('user_id', $uid)->exists()) DB::table('swp_settings')->where('user_id', $uid)->update($swp);
            else DB::table('swp_settings')->insert($swp + ['user_id'=>$uid,'created_at'=>$now]);
        });

        return redirect()->route('admin.users.show', $id)->with('ok', 'Planner inputs updated.');
    
    }

    public function toggleSuspend(int $id)
    {
        $user = User::findOrFail($id);
        $suspended = ($user->status === 'Blocked') || !empty($user->suspended_at);
        $user->status = $suspended ? 'Active' : 'Blocked';
        $user->suspended_at = $suspended ? null : now();
        $user->save();
        return redirect()->route('admin.users.show', $id)->with('ok', $suspended ? 'Account reinstated.' : 'Account suspended.');
    }

    public function updatePaymentStatus(Request $request, int $id, int $paymentId)
    {
        $data = $request->validate(['status' => 'required|in:success,failed,pending,refunded']);
        $upd = ['status' => $data['status'], 'updated_at' => now()];
        if ($data['status'] === 'success') $upd['paid_at'] = now();
        DB::table('payments')->where('id', $paymentId)->where('user_id', $id)->update($upd);
        $labels = ['success' => 'Marked as received.', 'refunded' => 'Recorded as refunded.', 'failed' => 'Marked as failed.', 'pending' => 'Marked as pending.'];
        return redirect()->route('admin.users.show', $id)->with('ok', $labels[$data['status']] ?? 'Payment updated.');
    }
}

