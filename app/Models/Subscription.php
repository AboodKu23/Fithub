<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'trainee_id',
        'subscription_date',
        'expire_date',
        'status',
        'trainee_rating',
    ];

    public function trainee():BelongsTo
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }

    public function trainer():BelongsTo
    {
        return $this->belongsTo(Trainer::class, 'trainee_id');
    }

    public function trainingPlan():HasOne
    {
        return $this->hasOne(TrainingPlan::class, 'subscription_id');
    }

    public function messages():HasMany
    {
        return $this->hasMany(Message::class, 'subscription_id');
    }
}
