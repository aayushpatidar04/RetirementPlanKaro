<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Website → Tools tab on the admin client page: which free tools a signed-in client opened. */
class ToolUsageController extends Controller
{
    private const TOOLS = [
        'My Investment Returns', 'Stock Portfolio Analysis', 'Income Tax Calculator', 'SIP Calculator',
        'Home Loan EMI Calculator', 'Budget Planner', 'Sample Portfolio', 'One Window Investing', 'Get Quotes',
    ];

    public function store(Request $request)
    {
        $user = $request->user();
        $tool = (string) $request->input('tool', '');
        if (!$user || !in_array($tool, self::TOOLS, true)) {
            return response()->noContent();
        }

        // opening the same tool again within 30 minutes counts as the same visit
        $recent = DB::table('tool_usages')->where('user_id', $user->id)->where('tool', $tool)
            ->where('used_at', '>=', now()->subMinutes(30))->orderByDesc('id')->first();

        if ($recent) {
            DB::table('tool_usages')->where('id', $recent->id)->update(['used_at' => now(), 'updated_at' => now()]);
        } else {
            DB::table('tool_usages')->insert([
                'user_id' => $user->id, 'tool' => $tool, 'inputs' => null, 'summary' => 'Opened the tool',
                'used_at' => now(), 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        return response()->noContent();
    }
}
