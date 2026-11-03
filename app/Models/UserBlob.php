<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlob extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kind', 'data'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
