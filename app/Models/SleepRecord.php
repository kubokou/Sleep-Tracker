<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SleepRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'sleep_time',
        'wake_time',
        'duration',
        'memo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
