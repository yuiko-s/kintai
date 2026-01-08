<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BreakTime; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'start_time', 'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function breaktimes()
    {
        return $this->hasMany(BreakTime::class);
    }

    
}
