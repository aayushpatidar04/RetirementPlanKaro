<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\CommunicationLog;
use App\Models\Coupon;
use App\Models\CouponRedemption;
use App\Models\GuidanceSession;
use App\Models\InvestmentPartner;
use App\Models\MessageTemplate;
use App\Models\Payment;
use App\Models\QuoteRequest;
use App\Models\Referral;
use App\Models\Role;
use App\Models\ScheduledMessage;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CompleteDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding complete database...');

        // ===== ADMIN USER (separate admins table) =====
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@retirementplankaro.com',
            'password' => Hash::make('password'),
        ]);

        // ===== REGULAR USERS =====
        $users = [];
        $stages = ['Signed up', 'Payment pending', 'Payment failed', 'Paid report', 'Wallet active', 'Session booked'];
        $cities = ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Pune', 'Kolkata', 'Ahmedabad'];
        $statuses = ['Active', 'Active', 'Active', 'Suspended'];

        for ($i = 1; $i <= 25; $i++) {
            $joined = Carbon::now()->subDays(rand(1, 180))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $lastLogin = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            $users[] = User::create([
                'name' => "User {$i} Name",
                'surname' => 'Surname',
                'mobile' => '9' . str_pad(rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => rand(0, 1) ? now() : null,
                'status' => $statuses[array_rand($statuses)],
                'tags' => $i <= 3 ? ['Paid', 'Hot lead'] : (rand(0, 1) ? ['Lead'] : []),
                'stage' => $stages[array_rand($stages)],
                'assigned_to' => rand(0, 1) ? 'Admin User' : null,
                'city' => $cities[array_rand($cities)],
                'referral_code' => strtoupper(Str::random(8)),
                'code' => strtoupper(Str::random(8)),
                'clicks' => rand(0, 50),
                'refoff' => false,
                'created_at' => $joined,
                'updated_at' => $lastLogin,
            ]);
        }

        // Add some specific test users matching HTML reference
        $testUsers = [
            [
                'name' => 'Gaurav Joshi',
                'mobile' => '9302157313',
                'email' => 'gaurav192003joshi@gmail.com',
                'city' => 'Indore',
                'stage' => 'Paid report',
                'tags' => ['Paid', 'Hot lead'],
                'referral_code' => 'RPK0XTQIU',
                'clicks' => 12,
            ],
            [
                'name' => 'Name Surname',
                'mobile' => '9589959468',
                'email' => 'jain30136@gmail.com',
                'city' => 'Indore',
                'stage' => 'Payment failed',
                'tags' => ['Payment failed'],
                'referral_code' => 'RPKPDIHBN',
                'clicks' => 1,
            ],
            [
                'name' => 'Praveen Bhati',
                'mobile' => '6268565414',
                'email' => 'praveenbhati823@gmail.com',
                'city' => 'Indore',
                'stage' => 'Signed up',
                'tags' => [],
                'referral_code' => 'RPKOBBELR',
                'clicks' => 0,
            ],
        ];

        foreach ($testUsers as $u) {
            $users[] = User::create([
                'name' => $u['name'],
                'surname' => 'Test',
                'mobile' => $u['mobile'],
                'email' => $u['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'Active',
                'tags' => $u['tags'],
                'stage' => $u['stage'],
                'city' => $u['city'],
                'referral_code' => $u['referral_code'],
                'code' => $u['referral_code'],
                'clicks' => $u['clicks'],
                'refoff' => false,
            ]);
        }

        // ===== REFERRALS =====
        foreach ($users as $user) {
            if (rand(0, 2) === 0) continue;
            $referrer = $users[array_rand($users)];
            if ($referrer->id === $user->id) continue;

            Referral::create([
                'referrer_user_id' => $referrer->id,
                'referred_user_id' => $user->id,
                'credited' => $user->email_verified_at ? true : false,
                'created_at' => $user->created_at->copy()->addHours(rand(1, 24)),
            ]);
        }

        // ===== PAYMENTS / TRANSACTIONS =====
        $purposes = ['report', 'session', 'wallet'];
        $statuses = ['success', 'failed', 'pending'];
        $methods = ['UPI', 'Card', 'Net Banking', 'Wallet'];
        
        foreach ($users as $user) {
            $numPayments = rand(1, 4);
            for ($p = 0; $p < $numPayments; $p++) {
                $status = $statuses[array_rand($statuses)];
                $purpose = $purposes[array_rand($purposes)];
                $amount = $purpose === 'report' ? 499 : ($purpose === 'session' ? 1000 : rand(100, 5000));
                
                $user->payments()->create([
                    'txnid' => 'TXN' . strtoupper(Str::random(32)),
                    'purpose' => $purpose,
                    'base_amount' => $amount,
                    'amount' => $amount,
                    'status' => $status,
                    'payu_id' => $status !== 'pending' ? 'PAYU' . strtoupper(Str::random(16)) : null,
                    'mode' => $methods[array_rand($methods)],
                    'coupon_code' => rand(0, 3) === 0 ? 'LAUNCH20' : null,
                    'coupon_off' => rand(0, 3) === 0 ? 99.8 : 0,
                    'points_used' => 0,
                    'paid_at' => $status === 'success' ? $user->created_at->copy()->addDays(rand(0, 30))->addHours(rand(0, 23)) : null,
                    'created_at' => $user->created_at->copy()->addDays(rand(0, 30)),
                ]);
            }
        }

        // ===== GUIDANCE SESSIONS =====
        $modes = ['Phone call', 'Video call', 'In-person'];
        $advisors = ['Ankit Sharma', 'Priya Patel', 'Rahul Verma', 'Sneha Gupta', 'Unassigned'];
        $sessionStatuses = ['pending_payment', 'confirmed', 'cancelled', 'done'];
        
        foreach ($users as $user) {
            if (rand(0, 2) === 0) continue;
            $numSessions = rand(1, 2);
            for ($s = 0; $s < $numSessions; $s++) {
                $date = $user->created_at->copy()->addDays(rand(1, 60));
                $slot = rand(0, 1) ? 'Morning (9 am – 12 pm)' : 'Afternoon (2 pm – 5 pm)';
                
                $user->guidanceSessions()->create([
                    'date' => $date,
                    'slot' => $slot,
                    'mode' => $modes[array_rand($modes)],
                    'mobile' => $user->mobile,
                    'note' => 'Can I retire at ' . rand(50, 60) . ' with current savings?',
                    'question' => 'Can I retire at ' . rand(50, 60) . ' with current savings?',
                    'advisor' => $advisors[array_rand($advisors)],
                    'status' => $sessionStatuses[array_rand($sessionStatuses)],
                    'cancel_reason' => rand(0, 1) ? 'Customer requested' : null,
                    'created_at' => $user->created_at->copy()->addDays(rand(0, 10)),
                ]);
            }
        }

        // ===== PLANNER DATA (using DB::table since no Eloquent models) =====
        foreach ($users as $user) {
            if (rand(0, 1) === 0) continue;

            // net_worths
            DB::table('net_worths')->insert([
                'user_id' => $user->id,
                'age' => rand(25, 55),
                'country' => 'IN',
                'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
            ]);

            // assets
            $assetTypes = [
                ['type' => 'liquid', 'slot' => 'bank', 'label' => 'Savings account – HDFC Bank'],
                ['type' => 'liquid', 'slot' => 'fd', 'label' => 'Fixed deposit'],
                ['type' => 'liquid', 'slot' => 'eq', 'label' => 'Mutual funds'],
                ['type' => 'non_liquid', 'slot' => 'epf', 'label' => 'EPF'],
                ['type' => 'non_liquid', 'slot' => 'ppf', 'label' => 'PPF'],
            ];
            foreach ($assetTypes as $a) {
                DB::table('assets')->insert([
                    'user_id' => $user->id,
                    'type' => $a['type'],
                    'slot' => $a['slot'],
                    'label' => $a['label'],
                    'amount' => rand(50000, 1000000),
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                ]);
            }

            // liabilities
            DB::table('liabilities')->insert([
                'user_id' => $user->id,
                'slot' => 'hl',
                'label' => 'Home loan – SBI',
                'amount' => rand(1000000, 5000000),
                'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
            ]);

            // income_expenses
            DB::table('income_expenses')->insert([
                'user_id' => $user->id,
                'monthly_income' => rand(50000, 300000),
                'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
            ]);

            // expenses
            $expenseCategories = [
                ['slot' => 'x0', 'label' => 'Rent / EMI', 'essential' => true],
                ['slot' => 'x1', 'label' => 'Groceries', 'essential' => true],
                ['slot' => 'x2', 'label' => 'Travel', 'essential' => false],
                ['slot' => 'x3', 'label' => 'Insurance', 'essential' => true],
                ['slot' => 'x4', 'label' => 'Gym/Health', 'essential' => false],
            ];
            foreach ($expenseCategories as $e) {
                DB::table('expenses')->insert([
                    'user_id' => $user->id,
                    'slot' => $e['slot'],
                    'label' => $e['label'],
                    'amount' => rand(1000, 40000),
                    'is_essential' => $e['essential'],
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                ]);
            }

            // protections
            DB::table('protections')->insert([
                'user_id' => $user->id,
                'life_insurance' => rand(0, 1) ? 'Yes' : 'No',
                'life_cover' => rand(5000000, 20000000),
                'term_premium' => rand(5000, 30000),
                'term_till_age' => rand(60, 75),
                'health_type' => ['None', 'Family floater', 'Individual'][array_rand(['None', 'Family floater', 'Individual'])],
                'health_cover' => rand(500000, 2000000),
                'health_premium' => rand(10000, 50000),
                'health_topup' => rand(0, 1) ? 'Yes' : 'No',
                'emergency_fund' => rand(100000, 1000000),
                'emergency_where' => 'Savings account',
                'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
            ]);

            // retirement_plans
            DB::table('retirement_plans')->insert([
                'user_id' => $user->id,
                'retirement_age' => rand(55, 65),
                'life_expectancy' => rand(80, 90),
                'monthly_spending' => rand(30000, 80000),
                'other_income' => rand(0, 20000),
                'inflation_rate' => rand(5, 7),
                'return_pre' => rand(8, 12),
                'return_post' => rand(5, 8),
                'current_corpus' => rand(500000, 5000000),
                'monthly_sip' => rand(5000, 50000),
                'step_up_percent' => rand(5, 10),
                'spending_auto' => true,
                'corpus_auto' => true,
                'sip_auto' => true,
                'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
            ]);

            // swp_settings
            DB::table('swp_settings')->insert([
                'user_id' => $user->id,
                'mode' => 'mine',
                'show_filter' => 'all',
                'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
            ]);

            // life_goals
            $goals = [
                ['name' => 'Child education', 'target_age' => rand(10, 20), 'cost_today' => rand(2000000, 5000000)],
                ['name' => 'Car', 'target_age' => rand(3, 7), 'cost_today' => rand(500000, 1500000)],
                ['name' => 'House down payment', 'target_age' => rand(5, 15), 'cost_today' => rand(1000000, 3000000)],
            ];
            foreach ($goals as $g) {
                DB::table('life_goals')->insert([
                    'user_id' => $user->id,
                    'name' => $g['name'],
                    'target_age' => $g['target_age'],
                    'cost_today' => $g['cost_today'],
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                ]);
            }

            // checklist_items
            $checklistItems = [
                ['age_group' => '20s', 'item_key' => 'emergency_fund'],
                ['age_group' => '20s', 'item_key' => 'health_insurance'],
                ['age_group' => '30s', 'item_key' => 'term_insurance'],
                ['age_group' => '30s', 'item_key' => 'retirement_sip'],
                ['age_group' => '40s', 'item_key' => 'child_education'],
                ['age_group' => '40s', 'item_key' => 'home_loan'],
            ];
            foreach ($checklistItems as $c) {
                if (rand(0, 1) === 0) continue;
                DB::table('checklist_items')->insert([
                    'user_id' => $user->id,
                    'age_group' => $c['age_group'],
                    'item_key' => $c['item_key'],
                    'is_checked' => rand(0, 1),
                    'checked_at' => rand(0, 1) ? $user->created_at->copy()->addDays(rand(1, 60)) : null,
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                ]);
            }

            // family_members
            DB::table('family_members')->insert([
                'user_id' => $user->id,
                'name' => 'Spouse',
                'rel' => 'Spouse',
                'age' => rand(25, 50),
                'inc' => rand(30000, 150000),
                'exp' => rand(10000, 50000),
                'liq' => rand(100000, 500000),
                'ill' => rand(200000, 1000000),
                'debt' => 0,
                'sip' => rand(5000, 20000),
                'tm' => rand(0, 1) ? 'Yes' : 'No',
                'lc' => rand(5000000, 20000000),
                'tp' => rand(5000, 30000),
                'tt' => rand(60, 75),
                'hs' => 'Family floater',
                'hc' => rand(500000, 2000000),
                'hp' => rand(10000, 50000),
                'ht' => rand(0, 1) ? 'Yes' : 'No',
                'ef' => rand(100000, 500000),
                'ew' => 'Savings account',
                'created_at' => $user->created_at->copy()->addDays(rand(1, 10)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 10)),
            ]);
        }

        // ===== COUPONS / DISCOUNT CODES (update existing from migration) =====
        Coupon::updateOrCreate(['code' => 'LAUNCH20'], [
            'type' => 'percent',
            'value' => 20,
            'max_uses' => null,
            'active' => true,
            'expires_at' => null,
            'used_count' => 45,
        ]);

        Coupon::updateOrCreate(['code' => 'FRIEND50'], [
            'type' => 'flat',
            'value' => 50,
            'max_uses' => 100,
            'active' => true,
            'expires_at' => Carbon::now()->addMonths(3),
            'used_count' => 12,
        ]);

        Coupon::updateOrCreate(['code' => 'WELCOME100'], [
            'type' => 'flat',
            'value' => 100,
            'max_uses' => 1000,
            'active' => true,
            'expires_at' => Carbon::now()->addYear(),
            'used_count' => 234,
        ]);

        // Coupon redemptions
        foreach ($users as $user) {
            if (rand(0, 3) === 0) {
                $coupon = Coupon::inRandomOrder()->first();
                CouponRedemption::create([
                    'user_id' => $user->id,
                    'coupon_id' => $coupon->id,
                    'payment_id' => $user->payments()->inRandomOrder()->first()?->id,
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 30)),
                ]);
            }
        }

        // ===== QUOTE REQUESTS =====
        $quoteProducts = ['Term Insurance', 'Health Insurance', 'Personal Loan', 'Loan Against Mutual Fund', 'Car / Bike Insurance', 'Credit Card'];
        $quoteStatuses = ['New', 'Quote shared', 'Follow-up', 'Converted', 'Lost'];
        
        foreach ($users as $user) {
            if (rand(0, 2) === 0) continue;
            $numQuotes = rand(1, 3);
            for ($q = 0; $q < $numQuotes; $q++) {
                $product = $quoteProducts[array_rand($quoteProducts)];
                QuoteRequest::create([
                    'user_id' => $user->id,
                    'product_type' => $product,
                    'customer_name' => $user->name,
                    'customer_mobile' => $user->mobile,
                    'customer_email' => $user->email,
                    'customer_city' => $user->city,
                    'details' => json_encode(['cover' => rand(50, 200) . 'L', 'term' => rand(20, 40) . ' years']),
                    'note' => rand(0, 1) ? 'Premium quote requested' : null,
                    'status' => $quoteStatuses[array_rand($quoteStatuses)],
                    'consent' => true,
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 60)),
                ]);
            }
        }

        // ===== MESSAGE TEMPLATES =====
        $waTemplates = [
            ['name' => 'Plan incomplete reminder', 'body' => "Hi {name}, your retirement plan is incomplete. Complete it here: {link}\n– Team Retirement Plan Karo"],
            ['name' => 'Payment failed', 'body' => "Hi {name}, your payment of ₹{amount} for {purpose} failed. Retry: {link}\n– Team Retirement Plan Karo"],
            ['name' => 'Referral update', 'body' => "Hi {name}, you earned {pts} points from referrals! Check wallet: {link}\n– Team Retirement Plan Karo"],
            ['name' => 'Greeting / follow-up', 'body' => "Namaste {name}\n\nRetirement Plan Karo se baat kar rahe hain. Aapke retirement plan me madad chahiye to bas reply karein.\n– Team Retirement Plan Karo"],
            ['name' => 'Report ready', 'body' => "Hi {name}, aapki Premium Retirement Report ready hai\nDownload karein: {link}\n– Team Retirement Plan Karo"],
            ['name' => 'Session reminder', 'body' => "Hi {name}, kal aapka guidance session hai. Time par available rahein\n– Team Retirement Plan Karo"],
        ];

        $emTemplates = [
            ['name' => 'Welcome Email', 'subject' => 'Welcome to Retirement Plan Karo!', 'body' => "Hi {name},\n\nWelcome to Retirement Plan Karo! Start planning your retirement today.\n\n{link}\n\n– Team Retirement Plan Karo"],
            ['name' => 'Report Ready Email', 'subject' => 'Your Premium Retirement Report is Ready', 'body' => "Hi {name},\n\nYour Premium Retirement Report is ready for download.\n\nDownload here: {link}\n\n– Team Retirement Plan Karo"],
            ['name' => 'Session Confirmation', 'subject' => 'Guidance Session Confirmed', 'body' => "Hi {name},\n\nYour guidance session is confirmed for {date} at {slot}.\n\nMode: {type}\nAdvisor: {advisor}\n\n– Team Retirement Plan Karo"],
            ['name' => 'Payment Receipt', 'subject' => 'Payment Receipt - ₹{amount}', 'body' => "Hi {name},\n\nThank you for your payment of ₹{amount} for {purpose}.\n\nTransaction ID: {txn_id}\nDate: {date}\n\n– Team Retirement Plan Karo"],
        ];

        foreach ($waTemplates as $t) {
            MessageTemplate::create([
                'name' => $t['name'],
                'channel' => 'wa',
                'subject' => null,
                'body' => $t['body'],
                'is_default' => false,
            ]);
        }

        foreach ($emTemplates as $t) {
            MessageTemplate::create([
                'name' => $t['name'],
                'channel' => 'em',
                'subject' => $t['subject'],
                'body' => $t['body'],
                'is_default' => false,
            ]);
        }

        // ===== COMMUNICATION LOGS =====
        $channels = ['wa', 'em'];
        $logStatuses = ['sent', 'delivered', 'failed'];
        
        foreach ($users as $user) {
            if (rand(0, 1) === 0) continue;
            $numLogs = rand(2, 6);
            for ($l = 0; $l < $numLogs; $l++) {
                $ch = $channels[array_rand($channels)];
                CommunicationLog::create([
                    'user_id' => $user->id,
                    'channel' => $ch,
                    'recipient' => json_encode([
                        'mobile' => $ch === 'wa' ? $user->mobile : null,
                        'email' => $ch === 'em' ? $user->email : null,
                        'name' => $user->name,
                    ]),
                    'subject' => $ch === 'em' ? 'Your Retirement Plan Update' : null,
                    'body' => "Hi {$user->name}, this is a test message.",
                    'status' => $logStatuses[array_rand($logStatuses)],
                    'template_id' => rand(0, 1) ? MessageTemplate::where('channel', $ch)->inRandomOrder()->first()?->id : null,
                    'sent_at' => $user->created_at->copy()->addDays(rand(1, 60))->addHours(rand(0, 23)),
                ]);
            }
        }

        // ===== SCHEDULED MESSAGES =====
        foreach ($users as $user) {
            if (rand(0, 3) === 0) continue;
            $ch = $channels[array_rand($channels)];
            ScheduledMessage::create([
                'channel' => $ch,
                'recipient' => json_encode([
                    'mobile' => $ch === 'wa' ? $user->mobile : null,
                    'email' => $ch === 'em' ? $user->email : null,
                    'name' => $user->name,
                ]),
                'subject' => $ch === 'em' ? 'Scheduled Update' : null,
                'body' => "Hi {$user->name}, this is a scheduled message.",
                'template_id' => MessageTemplate::where('channel', $ch)->inRandomOrder()->first()?->id,
                'scheduled_at' => now()->addDays(rand(1, 7)),
                'done' => false,
                'status' => 'scheduled',
            ]);
        }

        // ===== ACTIVITY LOGS (using DB::table since no model) =====
        $activities = [
            'Signed up',
            'Completed planner Step 1',
            'Completed planner Step 2',
            'Completed planner Step 3',
            'Completed planner Step 4',
            'Opened SIP calculator',
            'Opened Tax calculator',
            'Opened EMI calculator',
            'Opened Budget planner',
            'Opened Portfolio analysis',
            'Downloaded premium report',
            'Payment success',
            'Payment failed',
            'Wallet unlocked',
            'Daily streak check-in',
            'Referral link opened',
            'Guidance session booked',
            'Guidance session completed',
        ];

        foreach ($users as $user) {
            $numActivities = rand(5, 15);
            for ($a = 0; $a < $numActivities; $a++) {
                DB::table('activity_logs')->insert([
                    'user_id' => $user->id,
                    'actor_type' => 'user',
                    'actor_id' => $user->id,
                    'actor_name' => $user->name,
                    'event' => $activities[array_rand($activities)],
                    'description' => $activities[array_rand($activities)],
                    'ip' => '106.222.217.' . rand(1, 255),
                    'created_at' => $user->created_at->copy()->addDays(rand(0, 60))->addHours(rand(0, 23)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(0, 60))->addHours(rand(0, 23)),
                ]);
            }
        }

        // Admin activities
        DB::table('activity_logs')->insert([
            'user_id' => User::where('mobile', '9302157313')->first()?->id,
            'actor_type' => 'admin',
            'actor_id' => $admin->id,
            'actor_name' => 'Admin',
            'event' => 'user.created',
            'description' => 'Created user: Gaurav Joshi',
            'ip' => '127.0.0.1',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);

        // ===== TOOL USAGES (using DB::table since no model) =====
        $tools = ['SIP Calculator', 'Income Tax Calculator', 'Home Loan EMI Calculator', 'Budget Planner', 'Stock Portfolio Analysis', 'Returns Calculator'];
        
        foreach ($users as $user) {
            if (rand(0, 1) === 0) continue;
            $numTools = rand(1, 4);
            for ($t = 0; $t < $numTools; $t++) {
                DB::table('tool_usages')->insert([
                    'user_id' => $user->id,
                    'tool' => $tools[array_rand($tools)],
                    'inputs' => json_encode(['amount' => rand(1000, 100000), 'years' => rand(5, 30), 'rate' => rand(8, 15)]),
                    'summary' => 'Calculation completed',
                    'used_at' => $user->created_at->copy()->addDays(rand(1, 60))->addHours(rand(0, 23)),
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 60))->addHours(rand(0, 23)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(1, 60))->addHours(rand(0, 23)),
                ]);
            }
        }

        // ===== POINTS LEDGER (using DB::table since no model) =====
        $pointTypes = [
            ['type' => 'signup_bonus', 'points' => 600, 'note' => 'Welcome bonus'],
            ['type' => 'streak_bonus', 'points' => 50, 'note' => 'Daily streak – day 1'],
            ['type' => 'streak_bonus', 'points' => 50, 'note' => 'Daily streak – day 2'],
            ['type' => 'streak_bonus', 'points' => 50, 'note' => 'Daily streak – day 3'],
            ['type' => 'referral_bonus', 'points' => 100, 'note' => 'Referral bonus'],
            ['type' => 'wallet_unlock_debit', 'points' => -200, 'note' => 'Wallet unlock (24 h)'],
            ['type' => 'wallet_purchase', 'points' => -500, 'note' => 'Premium report purchase'],
        ];

        foreach ($users as $user) {
            foreach ($pointTypes as $pt) {
                if (rand(0, 1) === 0) continue;
                DB::table('points_ledger')->insert([
                    'user_id' => $user->id,
                    'account' => rand(0, 1) ? 'report' : 'wallet',
                    'type' => $pt['type'],
                    'points' => $pt['points'],
                    'note' => $pt['note'],
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 60))->addHours(rand(0, 23)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(1, 60))->addHours(rand(0, 23)),
                ]);
            }
        }

        // ===== WALLET UNLOCKS (using DB::table since no model) =====
        foreach ($users as $user) {
            if (rand(0, 2) === 0) continue;
            DB::table('wallet_unlocks')->insert([
                'user_id' => $user->id,
                'option_key' => '24h',
                'unlocked_at' => $user->created_at->copy()->addDays(rand(1, 30)),
                'expires_at' => $user->created_at->copy()->addDays(rand(1, 30))->addHours(24),
                'created_at' => $user->created_at->copy()->addDays(rand(1, 30)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 30)),
            ]);
        }

        // ===== USER STREAKS (using DB::table since no model) =====
        foreach ($users as $user) {
            DB::table('user_streaks')->insert([
                'user_id' => $user->id,
                'last_date' => now()->subDays(rand(0, 2)),
                'day' => rand(1, 15),
                'created_at' => $user->created_at->copy()->addDays(rand(1, 60)),
                'updated_at' => $user->created_at->copy()->addDays(rand(1, 60)),
            ]);
        }

        // ===== CLIENT NOTES (using DB::table since no model) =====
        $noteAuthors = ['Admin', 'Ankit Sharma', 'Priya Patel', 'Support Team'];
        $noteContents = [
            'Interested in guidance session, call back',
            'Payment failed, needs follow-up',
            'High net worth client, priority support',
            'Referred by existing customer',
            'Asked about NPS returns',
            'Wants to increase SIP amount',
        ];

        foreach ($users as $user) {
            if (rand(0, 2) === 0) continue;
            $numNotes = rand(1, 3);
            for ($n = 0; $n < $numNotes; $n++) {
                DB::table('client_notes')->insert([
                    'user_id' => $user->id,
                    'author' => $noteAuthors[array_rand($noteAuthors)],
                    'note' => $noteContents[array_rand($noteContents)],
                    'created_at' => $user->created_at->copy()->addDays(rand(1, 60)),
                    'updated_at' => $user->created_at->copy()->addDays(rand(1, 60)),
                ]);
            }
        }

        // ===== SETTINGS =====
        DB::table('settings')->updateOrInsert(
            ['key' => 'referral_programme'],
            ['value' => json_encode([
                'on' => true,
                'base' => config('app.url', 'https://retirementplankaro.com/'),
                'bonus' => 100,
                'friend' => 0,
                'verify' => true,
                'max' => '',
                'msg' => 'Plan your retirement with Retirement Plan Karo. Join with my link: {link}',
            ], JSON_UNESCAPED_UNICODE)]
        );

        DB::table('settings')->updateOrInsert(
            ['key' => 'referral_campaign_links'],
            ['value' => json_encode([
                [
                    'name' => 'WhatsApp Campaign Oct',
                    'code' => 'wa-oct',
                    'target' => 'planner',
                    'clicks' => 127,
                    'signups' => 23,
                    'on' => true,
                ],
                [
                    'name' => 'Email Newsletter',
                    'code' => 'email-nov',
                    'target' => 'get-quotes',
                    'clicks' => 89,
                    'signups' => 12,
                    'on' => true,
                ],
            ], JSON_UNESCAPED_UNICODE)]
        );

        DB::table('settings')->updateOrInsert(
            ['key' => 'session_availability'],
            ['value' => json_encode([
                'on' => true,
                'days' => [1, 2, 3, 4, 5],
                'slots' => "Morning (9 am – 12 pm)\nAfternoon (2 pm – 5 pm)",
                'modes' => 'Phone call, Video call',
                'blocked' => '2026-11-15, 2026-11-22',
                'win' => 14,
                'max' => 3,
                'dur' => 30,
                'notice' => 'A WhatsApp confirmation is sent once the booking is confirmed.',
            ], JSON_UNESCAPED_UNICODE)]
        );

        DB::table('settings')->updateOrInsert(
            ['key' => 'pricing'],
            ['value' => json_encode([
                'premium_report' => 499,
                'guidance_session' => 1000,
                'gst_percent' => 18,
            ], JSON_UNESCAPED_UNICODE)]
        );

        DB::table('settings')->updateOrInsert(
            ['key' => 'points'],
            ['value' => json_encode([
                'min_redeem' => 100,
                'welcome_bonus' => 600,
                'referral_bonus' => 100,
                'daily_streak' => 50,
                'streak_length' => 7,
                'wallet_unlock_cost' => 200,
                'wallet_unlock_hours' => 24,
                'min_wallet_recharge' => 100,
            ], JSON_UNESCAPED_UNICODE)]
        );

        // Seed investment partners
        $this->call(InvestmentPartnerSeeder::class);

        // Seed testimonials
        $this->call(TestimonialSeeder::class);

        // Seed roles and team members
        $this->call(RoleSeeder::class);
        $this->call(TeamMemberSeeder::class);

        DB::table('settings')->updateOrInsert(
            ['key' => 'message_stage_mapping'],
            ['value' => json_encode([
                'Signed up' => ['wa' => MessageTemplate::where('channel', 'wa')->where('name', 'Greeting / follow-up')->first()?->id, 'em' => MessageTemplate::where('channel', 'em')->where('name', 'Welcome Email')->first()?->id],
                'Payment pending' => ['wa' => MessageTemplate::where('channel', 'wa')->where('name', 'Plan incomplete reminder')->first()?->id, 'em' => null],
                'Payment failed' => ['wa' => MessageTemplate::where('channel', 'wa')->where('name', 'Payment failed')->first()?->id, 'em' => MessageTemplate::where('channel', 'em')->where('name', 'Payment Receipt')->first()?->id],
                'Paid report' => ['wa' => MessageTemplate::where('channel', 'wa')->where('name', 'Report ready')->first()?->id, 'em' => MessageTemplate::where('channel', 'em')->where('name', 'Report Ready Email')->first()?->id],
                'Wallet active' => ['wa' => MessageTemplate::where('channel', 'wa')->where('name', 'Referral update')->first()?->id, 'em' => null],
                'Session booked' => ['wa' => MessageTemplate::where('channel', 'wa')->where('name', 'Session reminder')->first()?->id, 'em' => MessageTemplate::where('channel', 'em')->where('name', 'Session Confirmation')->first()?->id],
            ], JSON_UNESCAPED_UNICODE)]
        );

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admins: ' . Admin::count());
        $this->command->info('Users: ' . User::count());
        $this->command->info('Referrals: ' . Referral::count());
        $this->command->info('Payments: ' . Payment::count());
        $this->command->info('Sessions: ' . GuidanceSession::count());
        $this->command->info('Quotes: ' . QuoteRequest::count());
        $this->command->info('Message Templates: ' . MessageTemplate::count());
        $this->command->info('Communication Logs: ' . CommunicationLog::count());
        $this->command->info('Scheduled Messages: ' . ScheduledMessage::count());
        $this->command->info('Activity Logs: ' . DB::table('activity_logs')->count());
        $this->command->info('Tool Usages: ' . DB::table('tool_usages')->count());
        $this->command->info('Client Notes: ' . DB::table('client_notes')->count());
        $this->command->info('Coupons: ' . Coupon::count());
        $this->command->info('Net Worths: ' . DB::table('net_worths')->count());
        $this->command->info('Assets: ' . DB::table('assets')->count());
        $this->command->info('Liabilities: ' . DB::table('liabilities')->count());
        $this->command->info('Life Goals: ' . DB::table('life_goals')->count());
        $this->command->info('Investment Partners: ' . InvestmentPartner::count());
        $this->command->info('Testimonials: ' . Testimonial::count());
        $this->command->info('Roles: ' . Role::count());
        $this->command->info('Team Members: ' . TeamMember::count());
    }
}