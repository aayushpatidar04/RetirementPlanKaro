<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuidanceSession extends Model
{
    use HasFactory;

    protected $table = 'guidance_sessions';

    protected $fillable = ['user_id', 'payment_id', 'date', 'slot', 'mode', 'mobile', 'note', 'status', 'question', 'advisor', 'cancel_reason'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
