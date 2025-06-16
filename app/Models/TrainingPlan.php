<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'start_date',
        'end_date',
        'notes',
    ];

    public function subscription() : BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function exercises() : HasMany
    {
        return $this->hasMany(TrainingPlanExercise::class);
    }
}
