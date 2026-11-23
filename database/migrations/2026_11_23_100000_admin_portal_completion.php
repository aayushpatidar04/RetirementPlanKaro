<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Columns that fill the client profile fields the admin portal already shows (signup IP, device, source, last active), plus a one-time import of the four partner links
 * the website showed before "One Window Investing" was switched to the database.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('signup_ip', 45)->nullable();
            $t->string('device', 80)->nullable();
            $t->string('source', 80)->nullable();
            $t->timestamp('last_login_at')->nullable();
            $t->timestamp('last_seen_at')->nullable();
        });

        // The website table used these four links. Seeded sample rows (made-up ?ref=rpk links)
        // are switched off, not deleted, so the website keeps showing exactly what it showed.
        if (!DB::table('investment_partners')->where('url', 'like', '%stablemoney.onelink.me%')->exists()) {
            DB::table('investment_partners')->where('url', 'like', '%?ref=rpk')->update(['is_active' => false]);
            DB::table('investment_partners')->increment('sort_order', 4);

            $rows = [
                ['Want to Invest in FD Upto 9% Interest Rate', 'Fixed Deposit', 'Stable Money', 'https://stablemoney.onelink.me/rkWL/vzit9seq'],
                ['Want to Invest in Bonds Upto 14% Interest Rate', 'Bonds', 'Wint Wealth', 'https://www.wintwealth.com/bonds/referral/invite?referralCode=44477F&utm_source=whatsapp&utm_medium=share_button&utm_platform=ios-app'],
                ['Want to Invest in International Market', 'International', 'IND Money', 'https://indmoney.onelink.me/RmHC/wb5s3u59'],
                ['Want to Invest in Mutual Fund or Indian Stocks', 'Mutual Funds & Stocks', 'Sharekhan', 'https://diy.sharekhan.com/app/Account/Register?grpcd=10632&type=pb&grpid=11021'],
            ];
            foreach ($rows as $i => [$label, $cat, $partner, $url]) {
                DB::table('investment_partners')->insert([
                    'label' => $label, 'category' => $cat, 'partner' => $partner, 'url' => $url,
                    'is_active' => true, 'clicks' => 0, 'sort_order' => $i + 1,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['signup_ip', 'device', 'source', 'last_login_at', 'last_seen_at']);
        });
    }
};
