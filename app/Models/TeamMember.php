<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** A person who can sign in to the admin portal (guard "team"). */
class TeamMember extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $hidden = ['password', 'remember_token'];

    protected static function booted(): void
    {
        // ids are strings like "m1", "m2" (the column has no auto-increment)
        static::creating(function (TeamMember $m) {
            if (empty($m->id)) {
                $n = static::query()->pluck('id')
                    ->map(fn ($id) => preg_match('/^m(\d+)$/', (string) $id, $x) ? (int) $x[1] : 0)
                    ->max() ?? 0;
                $m->id = 'm' . ($n + 1);
            }
            if (empty($m->added_at)) {
                $m->added_at = now();
            }
        });
    }

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
        'password',
        'last_login_at',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'extra' => 'array',
        'is_active' => 'boolean',
        'added_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
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