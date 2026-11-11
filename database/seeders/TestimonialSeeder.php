<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Vaibhav',
                'text' => 'I finished my plan in one sitting. The steps are short and the language is simple.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Aishwary',
                'text' => 'Seeing my plan year by year made things much clearer for me.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Kuber',
                'text' => 'I like that each step explains how the numbers are calculated.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Mahaveer',
                'text' => 'Easy to use on my phone. The buttons and text are big and clear.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Padmavati',
                'text' => 'The checklist told me what to look at next, one step at a time.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Laxmi',
                'text' => 'The Family Dashboard puts everyone\'s details in one place. It is very handy.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Sharda',
                'text' => 'No heavy words. I could follow every step without any help.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Riddhi',
                'text' => 'I liked that it shows the numbers and leaves the decision to me.',
                'permission_taken' => true,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Rajesh',
                'text' => 'The retirement calculator gave me a clear picture of what I need to save.',
                'permission_taken' => true,
                'is_active' => false,
                'sort_order' => 9,
            ],
            [
                'name' => 'Priya',
                'text' => 'Customer support was very helpful when I had questions about my plan.',
                'permission_taken' => false,
                'is_active' => false,
                'sort_order' => 10,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }

        // Seed section settings
        $section = [
            'on' => true,
            'kicker' => 'Kind words',
            'title' => 'What people say about Retirement Plan Karo',
            'sub' => 'Here is what people liked about planning their retirement here.',
            'note' => 'Testimonials are individual opinions, shared with permission, and are not a promise or guarantee of any result. This tool is for education only.',
        ];

        Setting::updateOrCreate(
            ['key' => 'testimonials_section'],
            ['value' => json_encode($section, JSON_UNESCAPED_UNICODE)]
        );

        // Seed version and publish tracking
        Setting::updateOrCreate(
            ['key' => 'testimonials_version'],
            ['value' => '1']
        );
        Setting::updateOrCreate(
            ['key' => 'testimonials_published_at'],
            ['value' => now()->format('Y-m-d H:i:s')]
        );

        // Create published snapshot
        $feed = [
            'on' => $section['on'],
            'text' => [
                'kicker' => $section['kicker'],
                'title' => $section['title'],
                'sub' => $section['sub'],
                'note' => $section['note'],
            ],
            'testimonials' => Testimonial::where('is_active', true)
                ->where('permission_taken', true)
                ->orderBy('sort_order')
                ->get(['id', 'name', 'text'])
                ->toArray(),
        ];
        Setting::updateOrCreate(
            ['key' => 'testimonials_published_snapshot'],
            ['value' => json_encode($feed, JSON_UNESCAPED_UNICODE)]
        );
    }
}