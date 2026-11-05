<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class Activity
{
    public static function log(
        ?int $userId,
        string $event,
        ?string $description = null,
        array $properties = [],
        ?string $subjectType = null,
        $subjectId = null,
        ?string $actorType = null,
        $actorId = null,
        ?string $actorName = null
    ): void {
        try {
            if (!Schema::hasTable('activity_logs')) return;
            $admin = null;
            try { $admin = Auth::guard('admin')->user(); } catch (\Throwable $e) {}
            DB::table('activity_logs')->insert([
                'user_id' => $userId,
                'actor_type' => $actorType ?? ($admin ? 'admin' : 'system'),
                'actor_id' => $actorId ?? ($admin->id ?? null),
                'actor_name' => $actorName ?? ($admin->name ?? ($admin->email ?? null)),
                'event' => $event,
                'description' => $description,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId !== null ? (string) $subjectId : null,
                'properties' => $properties ? json_encode($properties, JSON_UNESCAPED_UNICODE) : null,
                'ip' => Request::ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Never break primary flows for logging.
        }
    }
}
