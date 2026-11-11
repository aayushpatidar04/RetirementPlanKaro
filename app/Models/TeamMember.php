<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members';

    protected $fillable = [
        'id',
        'name',
        'email',
        'mobile',
        'role_id',
        'extra',
        'is_active',
        'added_at',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'extra' => 'array',
        'is_active' => 'boolean',
        'added_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getPermissions(): array
    {
        $base = $this->role?->permissions ?? [];
        $extra = $this->extra ?? [];
        
        // Merge base permissions with extra permissions
        foreach ($extra as $area => $perm) {
            if (!isset($base[$area])) {
                $base[$area] = '';
            }
            // Extra permissions add to base (e.g., base "v" + extra "e" = "ve")
            $base[$area] = $this->mergePermissions($base[$area], $perm);
        }
        
        return $base;
    }

    private function mergePermissions(string $base, string $extra): string
    {
        $result = '';
        if (str_contains($base, 'v') || str_contains($extra, 'v')) $result .= 'v';
        if (str_contains($base, 'e') || str_contains($extra, 'e')) $result .= 'e';
        if (str_contains($base, 'd') || str_contains($extra, 'd')) $result .= 'd';
        if (str_contains($extra, 'y')) $result .= 'y'; // Special perms like @export, @publish
        return $result;
    }

    public function can(string $area, string $required = 'v'): bool
    {
        $perms = $this->getPermissions();
        $has = $perms[$area] ?? '';
        
        foreach (str_split($required) as $r) {
            if (!str_contains($has, $r)) {
                return false;
            }
        }
        return true;
    }
}