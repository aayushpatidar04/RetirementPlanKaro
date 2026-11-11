<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'id',
        'name',
        'description',
        'is_system',
        'permissions',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'permissions' => 'array',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'role_id', 'id');
    }

    public function can(string $area, string $required = 'v'): bool
    {
        $perms = $this->permissions ?? [];
        $has = $perms[$area] ?? '';
        
        foreach (str_split($required) as $r) {
            if (!str_contains($has, $r)) {
                return false;
            }
        }
        return true;
    }

    public function getDisplayPermissions(): array
    {
        return $this->permissions ?? [];
    }
}