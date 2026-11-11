<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'id' => 'm1',
                'name' => 'Owner',
                'email' => 'retirementplankaro@gmail.com',
                'mobile' => '',
                'role_id' => 'owner',
                'extra' => null,
                'is_active' => true,
                'added_at' => now()->subDays(10),
            ],
            [
                'id' => 'm2',
                'name' => 'Support Executive (sample)',
                'email' => 'support.sample@example.com',
                'mobile' => '',
                'role_id' => 'support',
                'extra' => null,
                'is_active' => true,
                'added_at' => now()->subDays(10),
            ],
            [
                'id' => 'm3',
                'name' => 'Accounts Executive (sample)',
                'email' => 'accounts.sample@example.com',
                'mobile' => '',
                'role_id' => 'accounts',
                'extra' => null,
                'is_active' => true,
                'added_at' => now()->subDays(10),
            ],
            [
                'id' => 'm4',
                'name' => 'Content Editor (sample)',
                'email' => 'content.sample@example.com',
                'mobile' => '',
                'role_id' => 'content',
                'extra' => null,
                'is_active' => true,
                'added_at' => now()->subDays(10),
            ],
        ];

        foreach ($members as $data) {
            TeamMember::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
        }
    }
}