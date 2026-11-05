<?php

namespace App\Traits;

use App\Support\Activity;

trait RecordsActivity
{
    protected function recordActivity(
        ?int $userId,
        string $event,
        ?string $description = null,
        array $properties = [],
        ?string $subjectType = null,
        $subjectId = null
    ): void {
        Activity::log($userId, $event, $description, $properties, $subjectType, $subjectId);
    }
}
