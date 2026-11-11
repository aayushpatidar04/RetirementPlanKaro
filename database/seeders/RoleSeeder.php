<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id' => 'owner',
                'name' => 'Owner',
                'description' => 'Full access to everything, including roles and team. Cannot be changed.',
                'is_system' => true,
                'permissions' => [],
            ],
            [
                'id' => 'manager',
                'name' => 'Manager',
                'description' => 'Runs day-to-day work. Can see and change everything except team and roles.',
                'is_system' => false,
                'permissions' => [
                    'Home' => 'v',
                    'Customers' => 've',
                    'Leads' => 've',
                    'Payments' => 've',
                    'Get Quotes' => 've',
                    'Sessions' => 've',
                    'Referrals' => 'ved',
                    'Messages & Email' => 'ved',
                    'Coupons' => 'ved',
                    'Pricing & rewards' => 've',
                    'One Window Investing' => 'ved',
                    'Testimonials' => 'ved',
                    'Website versions' => 've',
                    'Audit log' => 'v',
                    '@export' => 'y',
                    '@publish' => 'y',
                ],
            ],
            [
                'id' => 'support',
                'name' => 'Support Executive',
                'description' => 'Talks to customers, handles leads, quotes and sessions.',
                'is_system' => false,
                'permissions' => [
                    'Home' => 'v',
                    'Customers' => 've',
                    'Leads' => 've',
                    'Payments' => 'v',
                    'Get Quotes' => 've',
                    'Sessions' => 've',
                    'Referrals' => 'v',
                    'Messages & Email' => 've',
                ],
            ],
            [
                'id' => 'accounts',
                'name' => 'Accounts',
                'description' => 'Looks after payments and can download reports.',
                'is_system' => false,
                'permissions' => [
                    'Home' => 'v',
                    'Customers' => 'v',
                    'Payments' => 've',
                    'Coupons' => 'v',
                    'Pricing & rewards' => 'v',
                    'Referrals' => 'v',
                    '@export' => 'y',
                ],
            ],
            [
                'id' => 'content',
                'name' => 'Content Editor',
                'description' => 'Updates website content such as testimonials and partner links.',
                'is_system' => false,
                'permissions' => [
                    'Home' => 'v',
                    'Pricing & rewards' => 'v',
                    'One Window Investing' => 'ved',
                    'Testimonials' => 'ved',
                    'Website versions' => 'v',
                    '@publish' => 'y',
                ],
            ],
            [
                'id' => 'viewer',
                'name' => 'Viewer',
                'description' => 'Can look but cannot change anything.',
                'is_system' => false,
                'permissions' => [
                    'Home' => 'v',
                    'Customers' => 'v',
                    'Leads' => 'v',
                    'Payments' => 'v',
                    'Get Quotes' => 'v',
                    'Sessions' => 'v',
                    'Referrals' => 'v',
                    'Messages & Email' => 'v',
                    'Coupons' => 'v',
                    'Pricing & rewards' => 'v',
                    'One Window Investing' => 'v',
                    'Testimonials' => 'v',
                    'Website versions' => 'v',
                ],
            ],
        ];

        foreach ($roles as $data) {
            Role::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
        }
    }
}