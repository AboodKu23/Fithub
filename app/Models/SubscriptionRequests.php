<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionRequests extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'trainee_id',
        'request_date',
        'request_status',
        'action_date',
    ];

    public function trainee() : BelongsTo
    {
        return $this->belongsTo(User::class, 'trainee_id');
    }

    public function trainer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

}
